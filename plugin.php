<?php
	/*
	Plugin Name: TCR Admin Post Activity
	License: GPL
	Version: 1.0.0
	Plugin URI: http://thecellarroom.uk
	Author: ChelseaStats
	Author URI: http://thecellarroom.uk
	Copyright (c) 2015 The Cellar Room Limited
	Description: Shows all scheduled, draft and pending posts (from all post types) in admin dashboard widget
	*/

	defined( 'ABSPATH' ) or die();

	###################################################################################

	add_action('wp_dashboard_setup', 'wp_cfc_add_dashboard_widgets');

	function wp_cfc_scheduled_post_widget_function() {
		global $wpdb;

		$result=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_status in ('Pending','Draft','Future') AND post_type !='' ORDER BY post_date ASC ");

		echo '<div class="activity-block">';
		foreach($result as $sc_post)
		{
			echo '<ul><li>
				<span><strong>'. ucwords($sc_post->post_status) .'</strong> :</span>
				<span>'.get_date_from_gmt($sc_post->post_date_gmt, $format = 'Y-m-d H:i').' : </span>
			        <a href="'.get_edit_post_link($sc_post->ID).'">'.$sc_post->post_title.'</a>
			</li></ul>';
		}
		echo "</div>";

	}

	function wp_cfc_add_dashboard_widgets()
	{
		wp_add_dashboard_widget( 'wp_cfc_dashboard_widget', 'Post Activity' , 'wp_cfc_scheduled_post_widget_function' );
	}
