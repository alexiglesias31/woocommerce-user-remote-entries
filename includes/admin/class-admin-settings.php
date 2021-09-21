<?php

/**
 * WoocommerceUserRemoteEntries Admin Settings
 */

namespace WCURE\Admin;

defined('ABSPATH') || exit;

/**
 * SettingsPage.
 */
class AdminSettings
{
    /**
     * Settings page variable
     */
    private $settings_page;

    /**
     * AdminSettings Constructor.
     */
    public function __construct()
    {
        add_filter('woocommerce_get_settings_pages', array($this, 'add_settings_pages'));
    }

    /**
     * Add settings pages to Woocommerce.
     */
    public function add_settings_pages($settings)
    {
        $this->settings_page    = new Settings\SettingsPage();

        $settings[] = $this->settings_page;

        return $settings;
    }

    /**
     * SettingsPage getter method.
     * 
     * @return Settings\SettingsPage
     */
    public function settings_page()
    {
        return $this->settings_page;
    }
}
