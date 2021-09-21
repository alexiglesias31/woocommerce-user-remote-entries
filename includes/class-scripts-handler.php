<?php

/**
 * WoocommerceUserRemoteEntries Scripts Handler
 */

namespace WCURE;

defined('ABSPATH') || exit;

class ScriptsHandler
{
    /**
     * Contains an array of script handles registered by WCURE.
     *
     * @var array
     */
    private $scripts = array();

    /**
     * Contains an array of script handles localized by WCURE.
     *
     * @var array
     */
    private $wp_localize_scripts = array();

    /**
     * Contains an array of style handles registered by WCURE.
     *
     * @var array
     */
    private $styles = array();

    /**
     * ScriptsHandler Constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Hook in methods.
     */
    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
        add_action('wp_print_scripts', array($this, 'localize_printed_scripts'));
        add_action('wp_print_footer_scripts', array($this, 'localize_printed_scripts'));
    }

    /**
     * Register/queue frontend scripts.
     */
    public function load_scripts()
    {
        $this->register_scripts();
        $this->register_styles();

        $this->enqueue_script('wcure');
        $this->enqueue_style('wcure');
    }

    /**
     * Localize a WCURE script once.
     * 
     * @param string $handle Script handle the data will be attached to.
     */
    private function localize_script($handle)
    {
        if (!in_array($handle, $this->wp_localize_scripts, true) && wp_script_is($handle)) {
            $data = $this->get_script_data($handle);

            if (!$data) {
                return;
            }

            $name = str_replace('-', '_', $handle) . '_params';
            $this->wp_localize_scripts[] = $handle;
            wp_localize_script($handle, $name, apply_filters($name, $data));
        }
    }

    /**
     * Return data for script handles.
     *
     * @param  string $handle Script handle the data will be attached to.
     * @return array|bool
     */
    private function get_script_data($handle)
    {
        switch ($handle) {
            case 'wcure':
                $params = array(
                    'ajax_url'    => WCURE()->ajax_url(),
                );
                break;
            default:
                $params = false;
        }

        return apply_filters('wcure_get_script_data', $params, $handle);
    }

    /**
     * Register all WCURE scripts.
     */
    private function register_scripts()
    {
        $suffix  = defined('SCRIPT_DEBUG') ? '' : '.min';
        $version = WCURE_VERSION;

        $register_scripts = array(
            'wcure'        => array(
                'src'     => WCURE()->get_asset_url('assets/js/frontend/wcure' . $suffix . '.js'),
                'deps'    => array('jquery'),
                'version' => 'wcure-' . $version,
            ),
        );
        foreach ($register_scripts as $name => $props) {
            $this->register_script($name, $props['src'], $props['deps'], $props['version']);
        }
    }

    /**
     * Register all WCURE styles.
     */
    private function register_styles()
    {
        $version = WCURE_VERSION;

        $register_styles = array(
            'wcure'                  => array(
                'src'     => WCURE()->get_asset_url('assets/css/wcure.css'),
                'deps'    => array(),
                'version' => 'wcure-' . $version,
            ),
        );
        foreach ($register_styles as $name => $props) {
            $this->register_style($name, $props['src'], $props['deps'], $props['version'], 'all');
        }
    }

    /**
     * Register a script for use.
     *
     * @uses   wp_register_script()
     * @param  string   $handle    Name of the script. Should be unique.
     * @param  string   $path      Full URL of the script, or path of the script relative to the WordPress root directory.
     * @param  string[] $deps      An array of registered script handles this script depends on.
     * @param  string   $version   String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
     * @param  boolean  $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
     */
    private function register_script($handle, $path, $deps = array('jquery'), $version = WCURE_VERSION, $in_footer = true)
    {
        $this->scripts[] = $handle;
        wp_register_script($handle, $path, $deps, $version, $in_footer);
    }

    /**
     * Register and enqueue a script for use.
     *
     * @uses   wp_enqueue_script()
     * @param  string   $handle    Name of the script. Should be unique.
     */
    private function enqueue_script($handle)
    {
        wp_enqueue_script($handle);
    }

    /**
     * Localize scripts only when enqueued.
     */
    public function localize_printed_scripts()
    {
        foreach ($this->scripts as $handle) {
            $this->localize_script($handle);
        }
    }

    /**
     * Register a style for use.
     *
     * @uses   wp_register_style()
     * @param  string   $handle  Name of the stylesheet. Should be unique.
     * @param  string   $path    Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
     * @param  string[] $deps    An array of registered stylesheet handles this stylesheet depends on.
     * @param  string   $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
     * @param  string   $media   The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
     */
    private function register_style($handle, $path, $deps = array(), $version = WCURE_VERSION, $media = 'all')
    {
        $this->styles[] = $handle;
        wp_register_style($handle, $path, $deps, $version, $media);
    }

    /**
     * Register and enqueue a styles for use.
     *
     * @uses   wp_enqueue_style()
     * @param  string   $handle  Name of the stylesheet. Should be unique.
     */
    private function enqueue_style($handle)
    {
        wp_enqueue_style($handle);
    }
}
