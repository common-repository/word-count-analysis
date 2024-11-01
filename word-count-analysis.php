<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nurullah.org
 * @since             1.0.0
 * @package           Word_Count_Analysis
 *
 * @wordpress-plugin
 * Plugin Name:       Word Count & Analysis
 * Plugin URI:        https://nurullah.org
 * Description:       See the word counts of your posts and pages and their analysis for seo. Optimize your articles with reports such as unique word and sentence length.
 * Version:           1.0.11
 * Author:            Nurullah SERT
 * Author URI:        https://nurullah.org
 * Requires PHP:      7.4
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wcadomain
 * Domain Path:       /lang
 */

define('WCA_PATH', plugin_dir_path(__FILE__));
define('WCA_URL', plugins_url(__DIR__));
define('WCA_LIBS', plugin_dir_path(__FILE__) . '/libs/');
define('WCA_VENDOR', plugin_dir_path(__FILE__) . '/vendor/');
define('WORD_COUNT_ANALYSIS_VERSION', '1.0.11');
//add_filter( 'auto_update_plugin', '__return_true' );

if ( ! function_exists( 'wca_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wca_fs() {
        global $wca_fs;

        if ( ! isset( $wca_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $wca_fs = fs_dynamic_init( array(
                'id'                  => '11931',
                'slug'                => 'word-count-analysis',
                'type'                => 'plugin',
                'public_key'          => 'pk_1833635772e9e1ede1520134bca2c',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'first-path'     => 'admin.php?page=wca_dashboard',
                    'account'        => false,
                ),
            ) );
        }

        return $wca_fs;
    }

    // Init Freemius.
    wca_fs();
    // Signal that SDK was initiated.
    do_action( 'wca_fs_loaded' );
}


include(WCA_PATH . 'wca_hook.php');


/*if (WORD_COUNT_ANALYSIS_VERSION !== get_option('my_awesome_plugin_version'))
    update_option('wca_version', WORD_COUNT_ANALYSIS_VERSION);*/



// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('WCA_PLUGIN_FILE')) {


    $plugin_data = get_file_data(__FILE__, array('version' => 'Version'), 'plugin');


    include(WCA_PATH . 'plugin.php');
    $plugin = new WCA_Plugin();
    register_activation_hook(__FILE__, array('WCA_Plugin', '_activation'));
    register_deactivation_hook(__FILE__, array('WCA_Plugin', '_deactivation'));

    add_action('init', 'lang');
    function lang()
    {
        load_plugin_textdomain('wcadomain', false, dirname(plugin_basename(__FILE__)) . '/lang');
    }

    // @todo: Buradan kaynaklı bir hata var.
    if (empty($_GET['page']) || $_GET['page'] != 'wca_dashboard') {
        return;
    }
    add_action('admin_enqueue_scripts', 'wca_scripts_enqueue');
    function wca_scripts_enqueue($hook)
    {
        wp_register_style('tailwindcss', plugins_url('/css/output.css', __FILE__), array());
        wp_enqueue_style('tailwindcss');
    }


}

