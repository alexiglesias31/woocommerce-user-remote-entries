<?php

/**
 * WoocommerceUserRemoteEntries Settings Page
 */

namespace WCURE\Admin\Settings;

defined('ABSPATH') || exit;

/**
 * SettingsPage
 */
class SettingsPage extends \WC_Settings_Page
{

    /**
     * SettingsPage Constructor.
     */
    public function __construct()
    {
        $this->id    = 'user_remote_entries';
        $this->label = __('User Remote Entries', 'woocommerce-user-remote-entries');

        parent::__construct();
    }

    /**
     * Get settings or the default section.
     *
     * @return array
     */
    protected function get_settings_for_default_section()
    {
        $settings =
            array(

                array(
                    'title' => __('API Credentials', 'woocommerce-user-remote-entries'),
                    'type'  => 'title',
                    'id'    => 'api_credentials_section',
                ),

                array(
                    'title'    => __('API Key', 'woocommerce'),
                    'id'       => 'wcure_api_key',
                    'default'  => '',
                    'type'     => 'text',
                ),

                array(
                    'title'    => __('API Secret', 'woocommerce'),
                    'id'       => 'wcure_api_secret',
                    'default'  => '',
                    'type'     => 'password',
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'api_credentials_section',
                ),

                array(
                    'title' => __('Remote Entries Endpoint', 'woocommerce-user-remote-entries'),
                    'type'  => 'title',
                    'id'    => 'remote_entries_section',
                ),

                array(
                    'title'    => __('Remote Entries', 'woocommerce-user-remote-entries'),
                    'desc'     => __('Endpoint for the "My account &rarr; Remote Entries" page.', 'woocommerce-user-remote-entries'),
                    'id'       => WCURE()->remote_entries_endpoint()->account_remote_entries_endpoint_option_name(),
                    'type'     => 'text',
                    'default'  => 'remote-entries',
                    'desc_tip' => true,
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'remote_entries_section',
                ),

                array(
                    'title' => __('Transient Duration', 'woocommerce-user-remote-entries'),
                    'type'  => 'title',
                    'id'    => 'transient_section',
                ),

                array(
                    'title'    => __('Transient Duration', 'woocommerce-user-remote-entries'),
                    'desc'     => __('Duration in seconds for transient data', 'woocommerce-user-remote-entries'),
                    'id'       => 'wcure_transient_duration',
                    'type'     => 'number',
                    'default'  => DAY_IN_SECONDS,
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'transient_section',
                ),
            );

        return $settings;
    }
}
