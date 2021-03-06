<?php
/**
 * Post Type Functions
 *
 * @package     FFW
 * @subpackage  Functions
 * @copyright   Copyright (c) 2013, Fifty and Fifty
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers and sets up the Downloads custom post type
 *
 * @since 1.0
 * @return void
 */
function setup_ffw_events_post_types() {
	global $ffw_events_settings;
	$archives = defined( 'FFW_EVENTS_DISABLE_ARCHIVE' ) && FFW_EVENTS_DISABLE_ARCHIVE ? false : true;

	//Check to see if anything is set in the settings area.
	if( !empty( $ffw_events_settings['events_slug'] ) ) {
	    $slug = defined( 'FFW_EVENTS_SLUG' ) ? FFW_EVENTS_SLUG : $ffw_events_settings['events_slug'];
	} else {
	    $slug = defined( 'FFW_EVENTS_SLUG' ) ? FFW_EVENTS_SLUG : 'events';
	}
	
	$rewrite  = defined( 'FFW_EVENTS_DISABLE_REWRITE' ) && FFW_EVENTS_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$events_labels =  apply_filters( 'ffw_events_events_labels', array(
		'name' 				=> '%2$s',
		'singular_name' 	=> '%1$s',
		'add_new' 			=> __( 'Add New', 'ffw_events' ),
		'add_new_item' 		=> __( 'Add New %1$s', 'ffw_events' ),
		'edit_item' 		=> __( 'Edit %1$s', 'ffw_events' ),
		'new_item' 			=> __( 'New %1$s', 'ffw_events' ),
		'all_items' 		=> __( 'All %2$s', 'ffw_events' ),
		'view_item' 		=> __( 'View %1$s', 'ffw_events' ),
		'search_items' 		=> __( 'Search %2$s', 'ffw_events' ),
		'not_found' 		=> __( 'No %2$s found', 'ffw_events' ),
		'not_found_in_trash'=> __( 'No %2$s found in Trash', 'ffw_events' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( '%2$s', 'ffw_events' )
	) );

	foreach ( $events_labels as $key => $value ) {
	   $events_labels[ $key ] = sprintf( $value, ffw_events_get_label_singular(), ffw_events_get_label_plural() );
	}

	$events_args = array(
		'labels' 			=> $events_labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'menu_position'		=> '34.3',
		'menu_icon'         => 'dashicons-calendar',
		'query_var' 		=> true,
		'rewrite' 			=> $rewrite,
		'map_meta_cap'      => true,
		'has_archive' 		=> $archives,
		'show_in_nav_menus'	=> true,
		'hierarchical' 		=> false,
		'supports' 			=> apply_filters( 'ffw_events_supports', array( 'title', 'editor', 'thumbnail', 'excerpt' ) ),
	);
	register_post_type( 'ffw_events', apply_filters( 'ffw_events_post_type_args', $events_args ) );
	
}
add_action( 'init', 'setup_ffw_events_post_types', 1 );

/**
 * Get Default Labels
 *
 * @since 1.0.8.3
 * @return array $defaults Default labels
 */
function ffw_events_get_default_labels() {
	global $ffw_events_settings;

	if( !empty( $ffw_events_settings['events_label_plural'] ) || !empty( $ffw_events_settings['events_label_singular'] ) ) {
	    $defaults = array(
	       'singular' => $ffw_events_settings['events_label_singular'],
	       'plural' => $ffw_events_settings['events_label_plural']
	    );
	 } else {
		$defaults = array(
		   'singular' => __( 'Event', 'ffw_events' ),
		   'plural' => __( 'Events', 'ffw_events')
		);
	}
	
	return apply_filters( 'ffw_events_default_name', $defaults );

}

/**
 * Get Singular Label
 *
 * @since 1.0.8.3
 * @return string $defaults['singular'] Singular label
 */
function ffw_events_get_label_singular( $lowercase = false ) {
	$defaults = ffw_events_get_default_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0.8.3
 * @return string $defaults['plural'] Plural label
 */
function ffw_events_get_label_plural( $lowercase = false ) {
	$defaults = ffw_events_get_default_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

/**
 * Change default "Enter title here" input
 *
 * @since 1.4.0.2
 * @param string $title Default title placeholder text
 * @return string $title New placeholder text
 */
function ffw_events_change_default_title( $title ) {
     $screen = get_current_screen();

     if  ( 'ffw_events' == $screen->post_type ) {
     	$label = ffw_events_get_label_singular();
        $title = sprintf( __( 'Enter %s title here', 'ffw_events' ), $label );
     }

     return $title;
}
add_filter( 'enter_title_here', 'ffw_events_change_default_title' );

/**
 * Registers the custom taxonomies for the downloads custom post type
 *
 * @since 1.0
 * @return void
*/
function ffw_events_setup_taxonomies() {

	$slug     = defined( 'FFW_EVENTS_SLUG' ) ? FFW_EVENTS_SLUG : 'events';

	/** Categories */
	$category_labels = array(
		'name' 				=> sprintf( _x( '%s Categories', 'taxonomy general name', 'ffw_events' ), ffw_events_get_label_singular() ),
		'singular_name' 	=> _x( 'Category', 'taxonomy singular name', 'ffw_events' ),
		'search_items' 		=> __( 'Search Categories', 'ffw_events'  ),
		'all_items' 		=> __( 'All Categories', 'ffw_events'  ),
		'parent_item' 		=> __( 'Parent Category', 'ffw_events'  ),
		'parent_item_colon' => __( 'Parent Category:', 'ffw_events'  ),
		'edit_item' 		=> __( 'Edit Category', 'ffw_events'  ),
		'update_item' 		=> __( 'Update Category', 'ffw_events'  ),
		'add_new_item' 		=> __( 'Add New Category', 'ffw_events'  ),
		'new_item_name' 	=> __( 'New Category Name', 'ffw_events'  ),
		'menu_name' 		=> __( 'Categories', 'ffw_events'  ),
	);

	$category_args = apply_filters( 'ffw_events_category_args', array(
			'hierarchical' 		=> true,
			'labels' 			=> apply_filters('ffw_events_category_labels', $category_labels),
			'show_ui' 			=> true,
			'query_var' 		=> 'events_category',
			'rewrite' 			=> array('slug' => $slug . '/category', 'with_front' => false, 'hierarchical' => true ),
			'capabilities'  	=> array( 'manage_terms','edit_terms', 'assign_terms', 'delete_terms' ),
			'show_admin_column'	=> true
		)
	);
	register_taxonomy( 'events_category', array('ffw_events'), $category_args );
	register_taxonomy_for_object_type( 'events_category', 'ffw_events' );

}
add_action( 'init', 'ffw_events_setup_taxonomies', 0 );



/**
 * Updated Messages
 *
 * Returns an array of with all updated messages.
 *
 * @since 1.0
 * @param array $messages Post updated message
 * @return array $messages New post updated messages
 */
function ffw_events_updated_messages( $messages ) {
	global $post, $post_ID;

	$url1 = '<a href="' . get_permalink( $post_ID ) . '">';
	$url2 = ffw_events_get_label_singular();
	$url3 = '</a>';

	$messages['ffw_events'] = array(
		1 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'ffw_events' ), $url1, $url2, $url3 ),
		4 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'ffw_events' ), $url1, $url2, $url3 ),
		6 => sprintf( __( '%2$s published. %1$sView %2$s%3$s.', 'ffw_events' ), $url1, $url2, $url3 ),
		7 => sprintf( __( '%2$s saved. %1$sView %2$s%3$s.', 'ffw_events' ), $url1, $url2, $url3 ),
		8 => sprintf( __( '%2$s submitted. %1$sView %2$s%3$s.', 'ffw_events' ), $url1, $url2, $url3 )
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'ffw_events_updated_messages' );
