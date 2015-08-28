<?php
	/*
	Plugin Name: TCR Admin Pending and Scheduled Posts in Admin Widget
	License: GPL
	Version: 1.0.0
	Plugin URI: http://thecellarroom.uk
	Author: ChelseaStats
	Author URI: http://thecellarroom.uk
	Copyright (c) 2015 The Cellar Room Limited
	Description: Shows all pending and scheduled posts (from all post types) in admin dashboard widgets
	*/
	defined( 'ABSPATH' ) or die();
	###################################################################################
	add_action('wp_dashboard_setup', 'wp_cfc_add_dashboard_widgets');
	
	function wp_cfc_pending_post_widget_function() {
		global $wpdb;
		$result=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_status in ('Pending') AND post_type !='' ORDER BY post_date ASC ");
		echo '<div class="activity-block one">';
		foreach($result as $sc_post)
		{
			echo '<ul>
				     	<li>
							<a href="'.get_edit_post_link($sc_post->ID).'">'.$sc_post->post_title.'</a>
						</li>
				  </ul>';
		}
		echo "</div>";
	}
	function wp_cfc_scheduled_post_widget_function() {
		global $wpdb;
		$result=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_status in ('Future') AND post_type !='' ORDER BY post_date ASC ");
		echo '<div class="activity-block two">';
		foreach($result as $sc_post)
		{
			echo '<ul>
				     	<li>
					     	<span>'.get_date_from_gmt($sc_post->post_date_gmt, $format = 'Y-m-d H:i').' <strong>:</strong> </span>
			                <a href="'.get_edit_post_link($sc_post->ID).'">'.$sc_post->post_title.'</a>
						</li>
				  </ul>';
		}
		echo "</div>";
	}
	function wp_cfc_add_dashboard_widgets()
	{
		wp_add_dashboard_widget( 'wp_cfc_dashboard_widget_one', 'Pending Activity'   , 'wp_cfc_pending_post_widget_function' );
		wp_add_dashboard_widget( 'wp_cfc_dashboard_widget_two', 'Scheduled Activity' , 'wp_cfc_scheduled_post_widget_function' );
	}
