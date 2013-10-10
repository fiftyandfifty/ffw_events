<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   Fifty & Fifty Framework Event Post Type
 * @author    Fifty & Fifty <bryanm@fiftyandfifty.org>
 * @license   GPL-2.0+
 * @link      http://fiftyandfifty.org
 * @copyright 2013 Fifty and Fifty
 *
 * @wordpress-plugin
 * Plugin Name: Fifty & Fifty Framework Event Post Type
 * Plugin URI:  http://fiftyandfifty.org
 * Description: Simple event functionality.
 * Version:     1.0.0
 * Author:      Fifty & Fifty
 * Author URI:  http://fiftyandfifty.org
 * Text Domain: energyexcelerator-event
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

define( 'FFW_EVENTS_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define( 'FFW_EVENTS_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'FFW_EVENTS_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once( FFW_EVENTS_PLUGIN_PATH . '/lib/posttypes.php');
require_once( FFW_EVENTS_PLUGIN_PATH . '/lib/shortcodes.php');
require_once( FFW_EVENTS_PLUGIN_PATH . '/lib/widgets.php');

