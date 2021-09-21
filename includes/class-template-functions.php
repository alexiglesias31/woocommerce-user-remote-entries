<?php

/**
 * WoocommerceUserRemoteEntries Template Functions
 */

namespace WCURE;

defined('ABSPATH') || exit;

class TemplateFunctions
{
    /**
     * TemplateFunctions Constructor
     */
    public function __construct()
    {
    }

    /**
     * Print the template for the remote entries
     */
    public function remote_entries()
    {
        $user_id = get_current_user_id();

        if (!$user_id) {
            echo __('You must logged in to get the data', 'woocommerce-user-remote-entries');
            return;
        }

        $data = WCURE()->httpbin_transient()->transient_user_data($user_id);

        wcure_get_template_part(
            'myaccount/remote-entries',
            array(
                'data' => $data ? apply_filters('wcure_remote_entries_data', $data) : array(),
            )
        );
    }

    /**
     * Print the template for the user settings
     */
    public function user_settings()
    {
        $user_id = get_current_user_id();

        $user_settings = new UserSettings($user_id);

        wcure_get_template_part(
            'myaccount/user-settings',
            array(
                'user' => get_user_by('id', $user_id),
                'settings' => $user_settings->get_user_settings()
            )
        );
    }
}
