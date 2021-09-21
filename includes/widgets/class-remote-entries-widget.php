<?php

/**
 * WoocommerceUserRemoteEntries Widget Remote Entries.
 */

namespace WCURE\Widgets;

defined('ABSPATH') || exit;

/**
 * Widget remote entries class.
 */
class RemoteEntriesWidget extends \WC_Widget
{

    /**
     * RemoteEntriesWidget Constructor.
     */
    public function __construct()
    {
        $this->widget_cssclass    = 'widget_block woocommerce widget_remote_entries';
        $this->widget_description = __('Display the customer remote entries.', 'woocommerce-user-remote-entries');
        $this->widget_id          = 'wcure_widget_remote_entries';
        $this->widget_name        = __('Remote Entries', 'woocommerce-user-remote-entries');
        $this->settings           = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => __('Remote Entries', 'woocommerce-user-remote-entries'),
                'label' => __('Title', 'woocommerce-user-remote-entries'),
            ),
            'hide_if_not_logged' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __('Hide if customer is not logged', 'woocommerce-user-remote-entries'),
            ),
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args     Arguments.
     * @param array $instance Widget instance.
     */
    public function widget($args, $instance)
    {
        $hide_if_not_logged = empty($instance['hide_if_not_logged']) ? 0 : 1;

        if (!isset($instance['title'])) {
            $instance['title'] = __('Remote Entries', 'woocommerce-user-remote-entries');
        }

        $this->widget_start($args, $instance);

        if ($hide_if_not_logged && is_user_logged_in()) {
            echo '<div class="wcure-remote-entries-container">';
            WCURE()->template_functions()->remote_entries();
            echo '</div>';
        } else {
            echo '<div>';
            echo '<p>' . __('You must login to get the content', 'woocommerce-user-remote-entries') . '</p>';
            echo '</div>';
        }

        $this->widget_end($args);
    }
}
