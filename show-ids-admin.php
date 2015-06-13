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

// Prepend the new column to the columns array
function TCR_sid_column($cols) {
  $cols['TCR_sid'] = 'ID';
	return $cols;
}

// Echo the ID for the new column
function TCR_sid_value($column_name, $id) {
	if ($column_name == 'TCR_sid')
		echo $id;
}

function TCR_sid_return_value($value, $column_name, $id) {
	if ($column_name == 'TCR_sid')
		$value = $id;
	return $value;
}

// Output CSS for width of new column
function TCR_sid_css() {
?>
<style type="text/css">
	#TCR_sid { width: 50px; } /* Show IDs */
</style>
<?php	
}

// Actions/Filters for various tables and the css output
function TCR_sid_add() {
	add_action('admin_head', 'TCR_sid_css');

	add_filter('manage_posts_columns', 'TCR_sid_column');
	add_action('manage_posts_custom_column', 'TCR_sid_value', 10, 2);

	add_filter('manage_pages_columns', 'TCR_sid_column');
	add_action('manage_pages_custom_column', 'TCR_sid_value', 10, 2);

	add_filter('manage_media_columns', 'TCR_sid_column');
	add_action('manage_media_custom_column', 'TCR_sid_value', 10, 2);

	add_filter('manage_link-manager_columns', 'TCR_sid_column');
	add_action('manage_link_custom_column', 'TCR_sid_value', 10, 2);

	add_action('manage_edit-link-categories_columns', 'TCR_sid_column');
	add_filter('manage_link_categories_custom_column', 'TCR_sid_return_value', 10, 3);

	foreach ( get_taxonomies() as $taxonomy ) {
		add_action("manage_edit-${taxonomy}_columns", 'TCR_sid_column');			
		add_filter("manage_${taxonomy}_custom_column", 'TCR_sid_return_value', 10, 3);
	}

	add_action('manage_users_columns', 'TCR_sid_column');
	add_filter('manage_users_custom_column', 'TCR_sid_return_value', 10, 3);

	add_action('manage_edit-comments_columns', 'TCR_sid_column');
	add_action('manage_comments_custom_column', 'TCR_sid_value', 10, 2);
}

add_action('admin_init', 'TCR_sid_add');
