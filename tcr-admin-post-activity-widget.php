<?php
/*
Plugin Name: TCR - Admin Post Activity Widget
Description: Shows all scheduled, draft and pending posts (from all post types) in admin dashboard widget
License: GPL
Version: 1.0.0
Plugin URI: http://thecellarroom.uk
Author: ChelseaStats
Author URI: http://thecellarroom.uk
Copyright (c) 2015 The Cellar Room Limited
*/

defined( 'ABSPATH' ) or die();

/*************************************************************************/

if ( ! class_exists( 'tcr_dashboard_widgets' ) ) :

		class tcr_dashboard_widgets {

			function __construct() {
				add_action('wp_dashboard_setup',  array( $this, 'tcr_add_dashboard_widgets'));
			}

			function tcr_add_dashboard_widgets() {
				wp_add_dashboard_widget( 'wp_cfc_dashboard_widget', 'Post Activity' ,  array( $this,'tcr_scheduled_post_widget_function') );
			}

			function tcr_scheduled_post_widget_function() {
				global $wpdb;

				$result = $wpdb->get_results("select * from ".$wpdb->prefix."posts where post_status in ('Pending','Draft','Future') AND post_type !='' ORDER BY post_date ASC ");

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
		}
endif;