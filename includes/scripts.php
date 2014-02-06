<?php
 /**
 * Scripts
 *
 * @package     ETM
 * @subpackage  Functions
 * @copyright   Copyright (c) 2013, Bryan Monzon
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



function ffw_events_load_admin_scripts( $hook ) 
{
    global $post,
    $ffw_events_settings,
    $ffw_events_settings_page,
    $wp_version;

    $js_dir  = FFW_EVENTS_PLUGIN_URL . 'assets/js/';
    $css_dir = FFW_EVENTS_PLUGIN_URL . 'assets/css/';

    wp_register_script( 'ffw-events-admin', $js_dir . 'ffw-events-admin.js', array('jquery'), '1.0', true );
    wp_register_style( 'ffw-events-datepicker-style', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', false, FFW_EVENTS_VERSION, false );
    

    wp_enqueue_script( 'ffw-events-admin' );
    wp_localize_script( 'ffw-events-admin', 'ffw_events_vars', array(
        'new_media_ui'            => apply_filters( 'ffw_events_use_35_media_ui', 1 ),
        ) 
    );

    if ( $hook == $ffw_events_settings_page ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'colorbox', $css_dir . 'colorbox.css', array(), '1.3.20' );
        wp_enqueue_script( 'colorbox', $js_dir . 'jquery.colorbox-min.js', array( 'jquery' ), '1.3.20' );
        if( function_exists( 'wp_enqueue_media' ) && version_compare( $wp_version, '3.5', '>=' ) ) {
            //call for new media manager
            wp_enqueue_media();
        }
    }




    wp_enqueue_script( 'jquery-ui-datepicker');
    wp_enqueue_script( 'ffw-events-admin' );

    
    wp_enqueue_style( 'ffw-events-datepicker-style' );
    
}
add_action( 'admin_enqueue_scripts', 'ffw_events_load_admin_scripts', 100 );

