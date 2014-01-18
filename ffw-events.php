<?php 
/**
 * Plugin Name: FFW Events
 * Plugin URI: http://fiftyandfifty.org
 * Description: Lightweight way to add events to your site.
 * Version: 1.0
 * Author: Fifty and Fifty
 * Author URI: http://labs.fiftyandfifty.org
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'FFW_EVENTS' ) ) :


/**
 * Main FFW_EVENTS Class
 *
 * @since 1.0 */
final class FFW_EVENTS {

  /**
   * @var FFW_EVENTS Instance
   * @since 1.0
   */
  private static $instance;


  /**
   * FFW_EVENTS Instance / Constructor
   *
   * Insures only one instance of FFW_EVENTS exists in memory at any one
   * time & prevents needing to define globals all over the place. 
   * Inspired by and credit to FFW_EVENTS.
   *
   * @since 1.0
   * @static
   * @uses FFW_EVENTS::setup_globals() Setup the globals needed
   * @uses FFW_EVENTS::includes() Include the required files
   * @uses FFW_EVENTS::setup_actions() Setup the hooks and actions
   * @see FFW_EVENTS()
   * @return void
   */
  public static function instance() {
    if ( ! isset( self::$instance ) && ! ( self::$instance instanceof FFW_EVENTS ) ) {
      self::$instance = new FFW_EVENTS;
      self::$instance->setup_constants();
      self::$instance->includes();
      // self::$instance->load_textdomain();
      // use @examples from public vars defined above upon implementation
    }
    return self::$instance;
  }



  /**
   * Setup plugin constants
   * @access private
   * @since 1.0 
   * @return void
   */
  private function setup_constants() {
    // Plugin version
    if ( ! defined( 'FFW_EVENTS_VERSION' ) )
      define( 'FFW_EVENTS_VERSION', '1.1' );

    // Plugin Folder Path
    if ( ! defined( 'FFW_EVENTS_PLUGIN_DIR' ) )
      define( 'FFW_EVENTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

    // Plugin Folder URL
    if ( ! defined( 'FFW_EVENTS_PLUGIN_URL' ) )
      define( 'FFW_EVENTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

    // Plugin Root File
    if ( ! defined( 'FFW_EVENTS_PLUGIN_FILE' ) )
      define( 'FFW_EVENTS_PLUGIN_FILE', __FILE__ );

    if ( ! defined( 'FFW_EVENTS_DEBUG' ) )
      define ( 'FFW_EVENTS_DEBUG', true );
  }



  /**
   * Include required files
   * @access private
   * @since 1.0
   * @return void
   */
  private function includes() {
    global $ffw_events_settings, $wp_version;

    require_once FFW_EVENTS_PLUGIN_DIR . '/includes/admin/settings/register-settings.php';
    $ffw_events_settings = ffw_events_get_settings();

    // Required Plugin Files
    require_once FFW_EVENTS_PLUGIN_DIR . '/includes/functions.php';
    require_once FFW_EVENTS_PLUGIN_DIR . '/includes/posttypes.php';
    require_once FFW_EVENTS_PLUGIN_DIR . '/includes/scripts.php';
    require_once FFW_EVENTS_PLUGIN_DIR . '/includes/shortcodes.php';

    if( is_admin() ){
        //Admin Required Plugin Files
        require_once FFW_EVENTS_PLUGIN_DIR . '/includes/admin/admin-pages.php';
        require_once FFW_EVENTS_PLUGIN_DIR . '/includes/admin/admin-notices.php';
        require_once FFW_EVENTS_PLUGIN_DIR . 'includes/admin/events/metabox.php';
        require_once FFW_EVENTS_PLUGIN_DIR . '/includes/admin/settings/display-settings.php';

    }


  }

} /* end FFW_EVENTS class */
endif; // End if class_exists check


/**
 * Main function for returning FFW_EVENTS Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $sqcash = FFW_EVENTS(); ?>
 *
 * @since 1.0
 * @return object The one true FFW_EVENTS Instance
 */
function FFW_EVENTS() {
  return FFW_EVENTS::instance();
}


/**
 * Initiate
 * Run the FFW_EVENTS() function, which runs the instance of the FFW_EVENTS class.
 */
FFW_EVENTS();



/**
 * Debugging
 * @since 1.0
 */
if ( FFW_EVENTS_DEBUG ) {
  ini_set('display_errors','On');
  error_reporting(E_ALL);
}


