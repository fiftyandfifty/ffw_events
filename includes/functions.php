<?php
/**
 * Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Sort posts on Archive by meta data
 * 
 * @param  [type] $query [description]
 * @return [type]        [description]
 */
function ffw_event_query_by_date( $query ) {
    
    global $ffw_events_settings;

    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_post_type_archive( 'ffw_events' ) ) {
        
        $meta_query = array(
              array(
                'key' => 'ffw_events_start_date_time',
                'value' => time(),
                'compare' => '>'
              )
            );

            $query->set( 'meta_query', $meta_query );
            $query->set( 'orderby', 'meta_value_num' );
            $query->set( 'meta_key', 'ffw_events_start_date_time' );
            $query->set( 'order', 'ASC' );
        
        return;
    }
}
add_action( 'pre_get_posts', 'ffw_event_query_by_date', 1 );




/**
 * Ge the mktime() format event start date/time
 * 
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function get_ffw_events_start_date_time( $post_id=null )
{
    global $post;

    $post_id    = isset( $post_id ) ? $post_id : $post->ID;
    
    $start_time = get_post_meta( $post_id, 'ffw_events_start_date_time', true );

    return $start_time;

}


/**
 * Get the events start date
 * 
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function get_ffw_events_start_date( $post_id=null )
{
    global $post;

    $post_id    = isset( $post_id ) ? $post_id : $post->ID;
    
    $start_date = get_post_meta( $post_id, 'ffw_events_start_date', true );

    return $start_date;

}



/**
 * Get the event's start hour
 * 
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function get_ffw_events_start_hour( $post_id=null )
{
    global $post;

    $post_id    = isset( $post_id ) ? $post_id : $post->ID;
    $start_hour = get_post_meta( $post_id, 'ffw_events_start_hour', true );

    return $start_hour;

}


/**
 * Get the event's start minute
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function get_ffw_events_start_minute( $post_id=null )
{
    global $post;
    
    $post_id = isset( $post_id ) ? $post_id : $post->ID;
    $start_minute = get_post_meta( $post_id, 'ffw_events_start_minute', true );

    return $start_minute;

}



/**
 * Get the event's start meridian (AM/PM
 * 
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function get_ffw_events_start_meridian( $post_id=null )
{
    global $post;

    $post_id        = isset( $post_id ) ? $post_id : $post->ID;
    $start_meridian = get_post_meta( $post_id, 'ffw_events_start_meridian', true );

    return $start_meridian;
}



/**
 * Echo formatted event date
 *
 * @uses  get_ffw_events_start_date_time() 
 * @param  [type] $args [description]
 * @return [type]       [description]
 */
function the_ffw_events_date_time_formatted( $args=null )
{
    global $post;

    $date_format     = get_option( 'date_format' );
    $default         = isset( $args ) ? $args : $date_format;
    $date_time_stamp = get_ffw_events_start_date_time();

    $date_time       = date( $default, $date_time_stamp ); 

    echo $date_time; 
}



/**
 * Returns URL from the settings page
 * 
 * @return [string] [the url of the media file]
 */
function get_events_archive_image()
{
    global $ffw_events_settings;

    $archive_image = isset( $ffw_events_settings['archive_image_url'] ) ? $ffw_events_settings['archive_image_url'] : '';
    
    return $archive_image;
}




/**
 * Grab the title set in the settings
 *
 * @return [string] [description]
 */
function ffw_events_the_archive_title()
{
    global $ffw_events_settings;

    $archive_title = isset( $ffw_events_settings['archive_title'] ) ? $ffw_events_settings['archive_title'] : 'Events';

    echo $archive_title; 
}


/**
 * Grab the content set in page settings
 *
 * @return [string] [description]
 */
function ffw_events_the_archive_content()
{
    global $ffw_events_settings;

    $archive_content = isset( $ffw_events_settings['archive_content'] ) ? $ffw_events_settings['archive_content'] : '';

    echo $archive_content; 
}


/**
 * Grab the excerpt section set in page settings
 * 
 * @return [string]
 */
function ffw_events_the_archive_excerpt()
{
    global $ffw_events_settings;

    $archive_excerpt = isset( $ffw_events_settings['archive_excerpt'] ) ? $ffw_events_settings['archive_excerpt'] : '';

    echo esc_textarea( stripslashes( $archive_excerpt ) ); 

}



