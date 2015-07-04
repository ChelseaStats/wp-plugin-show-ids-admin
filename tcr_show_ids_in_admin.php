<?php
/*
Plugin Name: TCR Show IDs
Description: Shows the ID of Posts, Pages, Media, Links, Categories, Tags and Users in the admin tables for easy access. Very lightweight.
Version: 2.0.0
Plugin URI: http://thecellarroom.uk
Author: The Cellar Room Limited
Author URI: http://www.thecellarroom.uk
Copyright (c) 2013 The Cellar Room Limited
*/

	defined( 'ABSPATH' ) or die();

	/*************************************************************************/

	if ( !class_exists( 'tcr_simply_ids' ) ) :

		class tcr_simply_ids {

			function __construct() {


				add_action( 'admin_init', array ( $this, 'tcr_sid_add' ) );
			}


			function tcr_sid_column( $cols ) {
				$cols['tcr_sid'] = 'ID';

				return $cols;
			}

			function tcr_sid_value( $column_name, $id ) {
				if ( $column_name == 'tcr_sid' ) {
					echo $id;
				}
			}

			function tcr_sid_return_value( $value, $column_name, $id ) {
				if ( $column_name == 'tcr_sid' ) {
					$value = $id;
				}

				return $value;
			}


			function tcr_sid_css() {
				?>
				<style type = "text/css">
					/* Show IDs */
					#tcr_sid { width: 50px; }
				</style>
			<?php
			}

			function tcr_sid_add() {

				add_action( 'admin_head'                            , array( $this , 'tcr_sid_css' ));
				add_filter( 'manage_posts_columns'                  , array( $this , 'tcr_sid_column' ));
				add_action( 'manage_posts_custom_column'            , array( $this , 'tcr_sid_value'), 10, 2 );
				add_filter( 'manage_pages_columns'                  , array( $this , 'tcr_sid_column') );
				add_action( 'manage_pages_custom_column'            , array( $this , 'tcr_sid_value'), 10, 2 );
				add_filter( 'manage_media_columns'                  , array( $this , 'tcr_sid_column') );
				add_action( 'manage_media_custom_column'            , array( $this , 'tcr_sid_value'), 10, 2 );
				add_filter( 'manage_link-manager_columns'           , array( $this , 'tcr_sid_column') );
				add_action( 'manage_link_custom_column'             , array( $this , 'tcr_sid_value'), 10, 2 );
				add_action( 'manage_edit-link-categories_columns'   , array( $this , 'tcr_sid_column') );
				add_filter( 'manage_link_categories_custom_column'  , array( $this , 'tcr_sid_return_value'), 10, 3 );
				add_action( 'manage_users_columns'                  , array( $this , 'tcr_sid_column') );
				add_filter( 'manage_users_custom_column'            , array( $this , 'tcr_sid_return_value'), 10, 3 );
				add_action( 'manage_edit-comments_columns'          , array( $this , 'tcr_sid_column') );
				add_action( 'manage_comments_custom_column'         , array( $this , 'tcr_sid_value'), 10, 2 );

				foreach ( get_taxonomies() as $taxonomy ) {
					add_action( "manage_edit-${taxonomy}_columns"   , array( $this ,'tcr_sid_column') );
					add_filter( "manage_${taxonomy}_custom_column"  , array( $this ,'tcr_sid_return_value'), 10, 3 );
				}
			}

		}

		new tcr_simply_ids;

	endif;
