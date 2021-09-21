<?php

/**
 * WoocommerceUserRemoteEntries Account Endpoint
 */

namespace WCURE\Endpoints;

defined('ABSPATH') || exit;

class AccountRemoteEntriesEndpoint
{
    /**
     * The key of this endpoint
     */
    private $endpoint_key = 'remote-entries';

    /**
     * AccountRemoteEntriesEndpoint Constructor.
     */
    public function __construct()
    {
        $this->init_hooks();
    }

    /**
     * Initialization Hooks
     */
    private function init_hooks()
    {
        add_filter('woocommerce_get_query_vars', array($this, 'add_remote_entries_endpoint'));
        add_filter('woocommerce_endpoint_' . $this->endpoint_key . '_title', array($this, 'remote_entries_title'), 10, 2);
        add_action('woocommerce_account_' . $this->endpoint_key . '_endpoint', array($this, 'remote_entries_content'));
    }

    /**
     * Add remote entries endpoint
     * 
     * @param array $query_vars
     */
    public function add_remote_entries_endpoint($query_vars)
    {
        $query_vars[$this->endpoint_key] = $this->account_remote_entries_endpoint_option_value();
        return $query_vars;
    }

    /**
     * Get account endpoint value
     * 
     * @return string
     */
    public function account_remote_entries_endpoint_option_value()
    {
        return get_option($this->account_remote_entries_endpoint_option_name(), 'remote-entries');
    }

    /**
     * Get account endpoint option name
     * 
     * @return string
     */
    public function account_remote_entries_endpoint_option_name()
    {
        return 'wcure_myaccount_remote_entries_endpoint';
    }

    /**
     * Get the remote entries section title
     */
    public function remote_entries_title($title, $endpoint)
    {
        if ($endpoint === $this->endpoint_key) {
            $title = __('Remote Entries', 'woocommerce-user-remote-entries');
        }
        return $title;
    }

    /**
     * Get the remote entries section content
     */
    public function remote_entries_content()
    {
        echo '<div class="wcure-user-settings-container">';
        WCURE()->template_functions()->user_settings();
        echo '</div>';

        echo '<div class="wcure-remote-entries-container">';
        WCURE()->template_functions()->remote_entries();
        echo '</div>';
    }
}
