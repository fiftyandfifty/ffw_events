<?php
/**
 * Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;




function get_ffw_events_start_time( $post_id=null )
{
    global $post;

    $post_id = isset( $post_id ) ? $post_id : $post->ID;

    $start_time = get_post_meta( $post_id, 'ffw_events_start_date_time', true );

    return $start_time;

}


