<?php

/**
 * WoocommerceUserRemoteEntries Widgets.
 */

namespace WCURE\Widgets;

defined('ABSPATH') || exit;

/**
 * Widgets class.
 */
class Widgets
{
    /**
     * Widgets Constructor.
     */
    public function __construct()
    {
        add_action('widgets_init', array($this, 'register_widgets'));
    }

    /**
     * Register widgets
     */
    public function register_widgets()
    {
        $this->remote_entries_widget = new RemoteEntriesWidget();
        register_widget('WCURE\Widgets\RemoteEntriesWidget');
    }
}
