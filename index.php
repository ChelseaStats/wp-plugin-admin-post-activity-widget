<?php
/*
Plugin Name: Add Admin and Scheduled Posts widgets in Admin screen
License: GPL
Version: 1.0.2
Plugin URI: http://thecellarroom.uk
Author: ChelseaStats
Author URI: http://thecellarroom.uk
Copyright (c) 2015 HESA
Description: Shows all pending and scheduled posts (from all post types) in admin dashboard widgets
*/

defined( 'ABSPATH' ) or die();

###################################################################################

if(!class_exists('tcr_wp_widgets')):
    $tcr_wp_widgets = new tcr_wp_widgets();
endif;

class tcr_wp_widgets {

    function _construct() {
        add_action('wp_dashboard_setup', array($this, 'wp_cfc_add_dashboard_widgets'));
    }

    function wp_cfc_pending_post_widget_function() {
        global $wpdb;
        $result = $wpdb->get_results("select * from ".$wpdb->prefix."posts where post_status in ('Pending') AND post_type !='' ORDER BY post_date ASC ");
        echo '<div class="activity-block one">';
        foreach($result as $sc_post) {
          echo '<ul><li><a href="'.get_edit_post_link($sc_post->ID).'">'.$sc_post->post_title.'</a></li></ul>';
        }
        echo "</div>";
    }
    function wp_cfc_scheduled_post_widget_function() {
        global $wpdb;
        $result = $wpdb->get_results("select * from ".$wpdb->prefix."posts where post_status in ('Future') AND post_type !='' ORDER BY post_date ASC ");
        echo '<div class="activity-block two">';
        foreach($result as $sc_post) {
            echo '<ul><li><span>'.get_date_from_gmt($sc_post->post_date_gmt, $format = 'Y-m-d H:i').' <strong>:</strong> </span>
		  <a href="'.get_edit_post_link($sc_post->ID).'">'.$sc_post->post_title.'</a></li></ul>';
        }
        echo "</div>";
    }

    function wp_cfc_add_dashboard_widgets() {
        wp_add_dashboard_widget( 'wp_cfc_dashboard_widget_one', 'Pending Activity'   , array($this , 'wp_cfc_pending_post_widget_function') );
        wp_add_dashboard_widget( 'wp_cfc_dashboard_widget_two', 'Scheduled Activity' , array($this , 'wp_cfc_scheduled_post_widget_function') );
    }

}
