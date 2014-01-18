<?php
/**
 * Metabox Functions
 *
 * @package     ETM
 * @subpackage  Admin/Classes
 * @copyright   Copyright (c) 2013, Bryan Monzon
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/** All Downloads *****************************************************************/

/**
 * Register all the meta boxes for the Download custom post type
 *
 * @since 1.0
 * @return void
 */
function ffw_events_add_meta_box() {

    $post_types = apply_filters( 'ffw_events_metabox_post_types' , array( 'ffw_events' ) );

    foreach ( $post_types as $post_type ) {

        /** Class Configuration */
        add_meta_box( 'classinfo', sprintf( __( '%1$s Information', 'ffw_events' ), ffw_events_get_label_singular(), ffw_events_get_label_plural() ),  'fw_events_render_meta_box', $post_type, 'normal', 'default' );

        
    }
}
add_action( 'add_meta_boxes', 'ffw_events_add_meta_box' );


/**
 * Sabe post meta when the save_post action is called
 *
 * @since 1.0
 * @param int $post_id Download (Post) ID
 * @global array $post All the data of the the current post
 * @return void
 */
function ffw_events_meta_box_save( $post_id) {
    global $post, $ffw_events_settings;

    if ( ! isset( $_POST['ffw_events_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['ffw_events_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) )
        return $post_id;

    if ( isset( $post->post_type ) && $post->post_type == 'revision' )
        return $post_id;




    if( isset( $_POST['ffw_events_start_date'] ) ) {

        $ffw_events_start_date   = sanitize_text_field( $_POST['ffw_events_start_date'] );
        
        $ffw_events_start_minute = sanitize_text_field( $_POST['ffw_events_start_minute'] );
        $ffw_events_start_hour   = sanitize_text_field( $_POST['ffw_events_start_hour'] );
        
        $ffw_events_start_day    = date( 'd', strtotime( $ffw_events_start_date ) );
        $ffw_events_start_month  = date( 'm', strtotime( $ffw_events_start_date ) );
        $ffw_events_start_year   = date( 'Y', strtotime( $ffw_events_start_date ) );

        $final_start_date_time = mktime( $ffw_events_start_hour, $ffw_events_start_minute, 0, $ffw_events_start_month, $ffw_events_start_day, $ffw_events_start_year );

        update_post_meta($post_id, 'ffw_events_start_date_time', $final_start_date_time);
        update_post_meta( $post_id, 'ffw_events_start_day', date( 'D', strtotime( $ffw_events_start_date ) ) );
        update_post_meta( $post_id, 'ffw_events_start_day_of_month', $ffw_events_start_day );
        update_post_meta( $post_id, 'ffw_events_start_month', $ffw_events_start_month );
        update_post_meta( $post_id, 'ffw_events_start_year', $ffw_events_start_year );
    }





    // The default fields that get saved
    $fields = apply_filters( 'ffw_events_metabox_fields_save', array(
            'ffw_events_start_date',
            'ffw_events_start_hour',
            'ffw_events_start_minute',
            'ffw_events_start_meridian',

        )
    );


    foreach ( $fields as $field ) {
        if ( ! empty( $_POST[ $field ] ) ) {
            $new = apply_filters( 'etm_metabox_save_' . $field, $_POST[ $field ] );
            update_post_meta( $post_id, $field, $new );
        } else {
            //delete_post_meta( $post_id, $field );
        }
    }
}
add_action( 'save_post', 'ffw_events_meta_box_save' );





/** Class Configuration *****************************************************************/

/**
 * Class Metabox
 *
 * Extensions (as well as the core plugin) can add items to the main download
 * configuration metabox via the `ffw_events_meta_box_fields` action.
 *
 * @since 1.0
 * @return void
 */
function fw_events_render_meta_box() {
    global $post, $ffw_events_settings;

    do_action( 'ffw_events_meta_box_fields', $post->ID );
    wp_nonce_field( basename( __FILE__ ), 'ffw_events_meta_box_nonce' );
}




function ffw_events_render_fields( $post )
{
    global $post, $ffw_events_settings;

    // $ffw_events_all_day        = get_post_meta( $post->ID, 'ffw_events_all_day', true );
    $ffw_events_start_date     = get_post_meta( $post->ID, 'ffw_events_start_date', true );
    $ffw_events_start_hour     = get_post_meta( $post->ID, 'ffw_events_start_hour', true );
    $ffw_events_start_minute   = get_post_meta( $post->ID, 'ffw_events_start_minute', true );
    $ffw_events_start_meridian = get_post_meta( $post->ID, 'ffw_events_start_meridian', true );
    
    ?>
    
    <div class="etm_information_metabox">
        <div id="classDetails" class="classForm">
            <table cellspacing="0" cellpadding="0" id="ffw_events_info">
                <tbody>
                    <tr>
                        <!-- <p><strong>Schedule your Event</strong></p> -->
                        <td colspan="2">
                            <table class="eventtable">
                                <tbody>

                                    <tr>
                                        <td style="width:175px;">Start Date &amp; Time:</td>
                                        <td id="ffw-event-datepickers" data-startofweek="1">
                                            <input autocomplete="off" tabindex="2001" type="text" name="ffw_events_start_date" id="ffw_events_start_date" value="<?php echo $ffw_events_start_date; ?>">

                                            <span class="helper-text hide-if-js" style="display: none;">YYYY-MM-DD</span>
                                            <span class="timeofdayoptions">
                                                @
                                                <select name="ffw_events_start_hour">
                                                    <option value="01" <?php selected( $ffw_events_start_hour, "01" ); ?>>01</option>
                                                    <option value="02" <?php selected( $ffw_events_start_hour, "02" ); ?>>02</option>
                                                    <option value="03" <?php selected( $ffw_events_start_hour, "03" ); ?>>03</option>
                                                    <option value="04" <?php selected( $ffw_events_start_hour, "04" ); ?>>04</option>
                                                    <option value="05" <?php selected( $ffw_events_start_hour, "05" ); ?>>05</option>
                                                    <option value="06" <?php selected( $ffw_events_start_hour, "06" ); ?>>06</option>
                                                    <option value="07" <?php selected( $ffw_events_start_hour, "07" ); ?>>07</option>
                                                    <option value="08" <?php selected( $ffw_events_start_hour, "08" ); ?>>08</option>
                                                    <option value="09" <?php selected( $ffw_events_start_hour, "09" ); ?>>09</option>
                                                    <option value="10" <?php selected( $ffw_events_start_hour, "10" ); ?>>10</option>
                                                    <option value="11" <?php selected( $ffw_events_start_hour, "11" ); ?>>11</option>
                                                    <option value="12" <?php selected( $ffw_events_start_hour, "12" ); ?>>12</option>
                                                </select>
                                                <select name="ffw_events_start_minute">
                                                    <option value="00" <?php selected( $ffw_events_start_minute, "00" ); ?>>00</option>
                                                    <option value="05" <?php selected( $ffw_events_start_minute, "05" ); ?>>05</option>
                                                    <option value="10" <?php selected( $ffw_events_start_minute, "10" ); ?>>10</option>
                                                    <option value="15" <?php selected( $ffw_events_start_minute, "15" ); ?>>15</option>
                                                    <option value="20" <?php selected( $ffw_events_start_minute, "20" ); ?>>20</option>
                                                    <option value="25" <?php selected( $ffw_events_start_minute, "25" ); ?>>25</option>
                                                    <option value="30" <?php selected( $ffw_events_start_minute, "30" ); ?>>30</option>
                                                    <option value="35" <?php selected( $ffw_events_start_minute, "35" ); ?>>35</option>
                                                    <option value="40" <?php selected( $ffw_events_start_minute, "40" ); ?>>40</option>
                                                    <option value="45" <?php selected( $ffw_events_start_minute, "45" ); ?>>45</option>
                                                    <option value="50" <?php selected( $ffw_events_start_minute, "50" ); ?>>50</option>
                                                    <option value="55" <?php selected( $ffw_events_start_minute, "55" ); ?>>55</option>
                                                </select>
                                                <select name="ffw_events_start_meridian">
                                                    <option value="am" <?php selected( $ffw_events_start_meridian, 'am'); ?>>am</option>
                                                    <option value="pm" <?php selected( $ffw_events_start_meridian, 'pm'); ?>>pm</option>
                                                </select>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <?php

}
add_action( 'ffw_events_meta_box_fields', 'ffw_events_render_fields', 10 );

