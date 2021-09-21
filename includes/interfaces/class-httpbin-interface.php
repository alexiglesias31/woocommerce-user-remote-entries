<?php

/**
 * WoocommerceUserRemoteEntries HttpBin Interface
 */

namespace WCURE\Interfaces;

defined('ABSPATH') || exit;

class HttpbinInterface
{
    /**
     * HttpbinInterface Constructor.
     */
    public function __construct()
    {
        $this->url = esc_url('https://httpbin.org/post');
    }

    /**
     * Get data from remote API https://httpbin.org/
     * 
     * @param array $body
     * @return array $result
     */
    public function get_remote_entries($body = array())
    {
        $result = array('status' => '', 'data' => '');

        $data = wp_remote_post($this->url, array('body' => $body));
        if (is_wp_error($data)) {
            $result['status'] = 'error';
            $result['data'] = __('There was a problem getting the results. Please try again later', 'woocommerce-user-remote-entries');
        } else {
            $res = wp_remote_retrieve_headers($data)->getAll();
            $result['status'] = 'success';
            $result['data'] = $res;
        }
        return $result;
    }
}
