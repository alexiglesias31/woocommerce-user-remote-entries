<?php

/**
 * WoocommerceUserRemoteEntries Section for MyAccount
 */

namespace WCURE\Sections;

defined('ABSPATH') || exit;

class AccountSection
{
    /**
     *  The remote entries tab will be inserted before this tab. 
     */
    private $tab_position = 'customer-logout';

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
        add_filter('woocommerce_account_menu_items', array($this, 'add_tab_account_menu_item'), 10, 1);
    }

    /**
     * Add remote entries menu item to My Account section
     */
    public function add_tab_account_menu_item($items)
    {
        if (WCURE()->remote_entries_endpoint()->account_remote_entries_endpoint_option_value()) {
            $new_item = array(
                'remote-entries'    => __('Remote Entries', 'woocommerce-user-remote-entries')
            );

            $items = wcure_array_insert_before($items, $new_item, $this->tab_position);
        }

        return $items;
    }
}
