<?php

/**
 * WoocommerceUserRemoteEntries Ajax
 */

namespace WCURE;

defined('ABSPATH') || exit;

class Ajax
{

	/**
	 * Action prefixes
	 * 
	 * @var string
	 */
	protected $actionPrefix	 = 'wcure_';

	/**
	 * A list of the ajax actions
	 * 
	 * @var array
	 */
	protected $ajaxActions	 = array(
		// Public
		'update_user_settings' => array(
			'method' => 'POST',
			'nopriv' => true
		),
		'get_remote_entries' => array(
			'method' => 'GET',
			'nopriv' => true
		),
	);

	/**
	 * Ajax Constructor.
	 */
	public function __construct()
	{
		foreach ($this->ajaxActions as $action => $details) {
			$noPriv = isset($details['nopriv']) ? $details['nopriv'] : false;
			$this->add_ajax_action($action, $noPriv);
		}
	}

	/**
	 * Add method as an ajax action
	 * 
	 * @param string $action
	 * @param bool $noPriv
	 */
	public function add_ajax_action($action, $noPriv)
	{
		add_action('wp_ajax_' . $this->actionPrefix . $action, array($this, $action));

		if ($noPriv) {
			add_action('wp_ajax_nopriv_' . $this->actionPrefix . $action, array($this, $action));
		}
	}

	/**
	 * Handler method for update_user_settings
	 * 
	 * @return json
	 */
	public function update_user_settings()
	{
		// Check that user is logged in
		$user_id = get_current_user_id();

		if (!$user_id) {
			wp_send_json(array('status' => 'error', 'message' => __('The user is not logged in', 'woocommerce-user-remote-entries')), 500);
		}

		// Verify the nonce field value
		$_nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

		if (!wp_verify_nonce($_nonce, 'save_remote_entries_settings')) {
			wp_send_json(array('status' => 'error', 'message' => __('There was a problem saving the settings, nonce field is invalid', 'woocommerce-user-remote-entries')), 500);
		}

		$settings = isset($_POST['data']) ? $_POST['data'] : array();

		$user_settings = new UserSettings($user_id);

		// Return if stored settings and new settings are the same
		if ($user_settings->get_user_settings() == $settings) {
			wc_add_notice(__('The user settings have been saved successfully', 'woocommerce-user-remote-entries'));
			wp_send_json_success();
		}

		$user_settings->set_settings($settings);
		WCURE()->httpbin_transient()->regenerate_user_data($user_id);

		if ($user_settings->save_settings()) {
			wc_add_notice(__('The user settings have been saved successfully', 'woocommerce-user-remote-entries'));
			wp_send_json_success();
		} else {
			wp_send_json_error(array('error' => __('There was a problem saving the settings', 'woocommerce-user-remote-entries')), 500);
		}
	}

	/**
	 * Handler method for get_remote_entries
	 * 
	 * @return json
	 */
	public function get_remote_entries()
	{
		$user_id = get_current_user_id();
		WCURE()->httpbin_transient()->regenerate_user_data($user_id);
		WCURE()->template_functions()->remote_entries();
		die();
	}
}
