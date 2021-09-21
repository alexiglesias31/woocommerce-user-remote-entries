<?php

/**
 * WoocommerceUserRemoteEntries initialization
 *
 * @package WoocommerceUserRemoteEntries
 */

defined('ABSPATH') || exit;

class WoocommerceUserRemoteEntries
{
	/**
	 * Current version of the plugin
	 */
	public $version = '1.0.0';

	/*
	 * The single instance of the class.
	 *
	 * @var WoocommerceUserRemoteEntries
	 */
	protected static $_instance = null;

	/**
	 * Main WoocommerceUserRemoteEntries Instance.
	 *
	 * Ensures only one instance of WoocommerceUserRemoteEntries is loaded or can be loaded.
	 *
	 * @return WoocommerceUserRemoteEntries - Main instance.
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * WoocommerceUserRemoteEntries Constructor.
	 */
	public function __construct()
	{
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define the plugin's constants.
	 */
	private function define_constants()
	{
		$this->define('WCURE_VERSION', $this->version);
	}

	/**
	 * Include required files
	 */
	private function includes()
	{
		// Class Autoloader
		$this->require_once('autoloader.php');
		$this->autoloader 			= new \WCURE\Autoloader('WCURE', $this->instance_path());

		// Functions
		$this->require_once('functions.php');

		// Admin Settings Class
		$this->admin_settings 			= new \WCURE\Admin\AdminSettings();

		// Scripts Handler
		$this->scripts_handler 			= new \WCURE\ScriptsHandler();

		// Ajax Handler
		$this->ajax 					= new \WCURE\Ajax();

		// Communication Interfaces
		$this->httpbin_interface 		= new \WCURE\Interfaces\HttpbinInterface();

		// Transients
		$this->httpbin_transient 		= new \WCURE\Transients\HttpbinTransient();

		// Endpoints
		$this->remote_entries_endpoint 	= new \WCURE\Endpoints\AccountRemoteEntriesEndpoint();

		// Sections
		$this->account_section			= new \WCURE\Sections\AccountSection();

		// Widgets
		$this->widgets			 		= new \WCURE\Widgets\Widgets();

		// Template functions
		$this->template_functions		= new \WCURE\TemplateFunctions();
	}

	/**
	 * Hook into actions and filters.
	 */
	private function init_hooks()
	{
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define($name, $value)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}

	/**
	 * Get the plugin plugin path.
	 *
	 * @return string
	 */
	public function plugin_path()
	{
		return untrailingslashit(plugin_dir_path(WCURE_PLUGIN_FILE));
	}

	/**
	 * Template path
	 * 
	 * @return string
	 */
	public function template_path()
	{
		return $this->plugin_path() . '/templates/';
	}

	/**
	 * Get the plugin instance path.
	 *
	 * @return string
	 */
	public function instance_path()
	{
		return $this->plugin_path() . '/includes/';
	}

	/**
	 * Includes a file relative to this main class
	 * 
	 * @param string relative file path
	 */
	public function require_once($file)
	{
		require_once $this->instance_path() . $file;
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url()
	{
		return untrailingslashit(plugins_url('/', WCURE_PLUGIN_FILE));
	}

	/**
	 * Return asset URL.
	 *
	 * @param string $path Assets path.
	 * @return string
	 */
	public function get_asset_url($path)
	{
		return plugins_url($path, WCURE_PLUGIN_FILE);
	}

	/**
	 * Return asset URL.
	 *
	 * @param string $path Assets path.
	 * @return string
	 */
	public function get_asset_path($path)
	{
		return $this->plugin_path() . '/' . $path;
	}

	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public function ajax_url()
	{
		return admin_url('admin-ajax.php', 'relative');
	}

	/**
	 * Get httpbin_interface
	 * 
	 * @return Interfaces\HttpInterface
	 */
	public function httpbin_interface()
	{
		return $this->httpbin_interface;
	}

	/**
	 * Get httpbin_transient
	 * 
	 * @return Collections\HttpbinTransient
	 */
	public function httpbin_transient()
	{
		return $this->httpbin_transient;
	}

	/**
	 * Get remote_entries_endpoint
	 * 
	 * @return Sections\AccountRemoteEntriesEndpoint
	 */
	public function remote_entries_endpoint()
	{
		return $this->remote_entries_endpoint;
	}

	/**
	 * Get account_section
	 * 
	 * @return Sections\AccountSection
	 */
	public function account_section()
	{
		return $this->account_section;
	}

	/**
	 * Get widgets
	 * 
	 * @return Widgets\Widgets;
	 */
	public function widgets()
	{
		return $this->widgets;
	}

	/**
	 * Get widgets
	 * 
	 * @return TemplateFunctions
	 */
	public function template_functions()
	{
		return $this->template_functions;
	}
}
