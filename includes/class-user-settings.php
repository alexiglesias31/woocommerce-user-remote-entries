<?php

/**
 * WoocommerceUserRemoteEntries User Settings
 */

namespace WCURE;

defined('ABSPATH') || exit;

class UserSettings
{
    /**
     * User ID
     */
    private $id;

    /**
     * User data
     */
    private $settings;

    /**
     * Post meta slug
     */
    protected $meta_slug = 'user_remote_entries_settings';

    /**
     * UserSettings Constructor
     */
    public function __construct($user_id)
    {
        $this->id = $user_id;
        $this->settings = get_post_meta($this->id, $this->meta_slug, true);
    }

    /**
     * Set settings for the current user
     * 
     * @param array $data
     */
    public function set_settings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * Save settings for the current user
     */
    public function save_settings()
    {
        $response = update_post_meta($this->id, $this->meta_slug, $this->settings);
        return $response;
    }

    /**
     * Get settings for the current user
     */
    public function get_user_settings()
    {
        return $this->settings;
    }
}
