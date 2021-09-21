<?php

/**
 * Plugin Name:       Woocommerce User Remote Entries
 * Plugin URI:        https://github.com/alexiglesias31/woocommerce_user_remote_entries
 * Description:       Add a widget to display remote posts in MyAccount section
 * Version:           1.0.0
 * Author:            Alejandro Iglesias
 * Author URI:        https://github.com/alexiglesias31
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-user-remote-entries
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

if (!defined('WCURE_PLUGIN_FILE')) {
	define('WCURE_PLUGIN_FILE', __FILE__);
}

// Main Plugin Class
if (!class_exists('WoocommerceUserRemoteEntries', false)) {
	include_once dirname(WCURE_PLUGIN_FILE) . '/includes/class-woocommerce-user-remote-entries.php';
}

/**
 * Returns the main instance of the plugin
 */
function WCURE()
{
	return WoocommerceUserRemoteEntries::instance();
}

/**
 * Initialize the plugin instance
 */
WCURE();
