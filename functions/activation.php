<?php

function va_employees_setup_post_type() {

	$args = array(
	'labels' => array(
		'name' => __('Employees', 'va-employees'),
		'singular_name' => __('Employee', 'va-employees'),
		'all_items' => __('All Employees', 'va-employees'),
		'add_new_item' => __('Add New Employee', 'va-employees'),
		'edit_item' => __('Edit Employee', 'va-employees'),
		'view_item' => __('View Employee', 'va-employees')
	),
	'public' => false,
	'publicly_queryable' => false,
	'has_archive' => false,
	'rewrite' => array('slug' => __('employees', 'va-employees')),
	'show_ui' => true,
	'show_in_menu' => true,
	'show_in_nav_menus' => true,
	'show_in_admin_bar' => true,
	'capability_type' => 'page',
	'supports' => array('title', 'thumbnail', 'page-attributes'),
	'exclude_from_search' => true,
	'menu_position' => 20,
	'menu_icon' => 'dashicons-businessman'
	);
	
	// https://codex.wordpress.org/Function_Reference/register_post_type
	register_post_type('va-employees', $args);

}
add_action( 'init', 'va_employees_setup_post_type' );





function va_employees_install() {

    // trigger our function that registers the custom post type
    va_employees_setup_post_type();
 
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();

}
register_activation_hook( __FILE__, 'va_employees_install' );
