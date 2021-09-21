<?php

/**
 * WoocommerceUserRemoteEntries HttpBin Transient
 */

namespace WCURE\Transients;

defined('ABSPATH') || exit;

class HttpbinTransient
{
    /**
     * Transient prefix name
     */
    private $prefix = 'wcure_transient_httpbin_user_';

    /**
     * HttpbinTransient Constructor.
     */
    public function __construct()
    {
        $this->transient_duration = intval(get_option('wcure_transient_duration'));
    }

    /**
     * Add the data for the specified user
     * 
     * @param int $user_id
     * @param array $data
     * @return bool
     */
    public function add_user_data($user_id, $data = array())
    {
        return set_transient($this->transient_name($user_id), $data, $this->transient_duration);
    }

    /**
     * Delete the data for the specified user
     * 
     * @param int $user_id
     * @return bool
     */
    public function delete_user_data($user_id)
    {
        return delete_transient($this->transient_name($user_id));
    }

    /**
     * Get transient data for the specified user
     * 
     * @param int $user_id
     * @return array
     */
    public function transient_user_data($user_id)
    {
        return get_transient($this->transient_name($user_id));
    }

    /**
     * Get data for the specified user
     * 
     * @param int $user_id
     * @return array
     */
    public function get_user_data($user_id)
    {
        $data = $this->transient_user_data($user_id);

        if (!$data) {
            $data = $this->regenerate_user_data($user_id);
        }

        return $data;
    }

    /**
     * Regenerate data for the specified user
     * 
     * @param int $user_id
     * @return array
     */
    public function regenerate_user_data($user_id)
    {
        $user_settings = new \WCURE\UserSettings($user_id);

        $response = WCURE()->httpbin_interface()->get_remote_entries($user_settings->get_user_settings());

        if ($response['status'] === 'success') {
            $this->add_user_data($user_id, $response['data']);
            return $response['data'];
        }

        return array();
    }

    /**
     * Get the transient name from user_id
     * 
     * @param string $user_id
     * @return string
     */
    private function transient_name($user_id)
    {
        return $this->prefix . $user_id;
    }
}
