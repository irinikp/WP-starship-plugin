<?php

function sw_starship_init() {
	$labels = array(
		'name'               => __( 'StarShips', 'starships' ),
		'singular_name'      => __( 'StarShip', 'starships' ),
		'menu_name'          => __( 'StarShips', 'starships' ),
		'name_admin_bar'     => __( 'StarShip', 'starships' ),
		'add_new'            => __( 'Add New', 'starships' ),
		'add_new_item'       => __( 'Add New StarShip', 'starships' ),
		'new_item'           => __( 'New StarShip', 'starships' ),
		'edit_item'          => __( 'Edit StarShip', 'starships' ),
		'view_item'          => __( 'View StarShip', 'starships' ),
		'all_items'          => __( 'All StarShips', 'starships' ),
		'search_items'       => __( 'Search StarShips', 'starships' ),
		'parent_item_colon'  => __( 'Parent StarShips:', 'starships' ),
		'not_found'          => __( 'No starships found.', 'starships' ),
		'not_found_in_trash' => __( 'No starships found in Trash.', 'starships' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'A custom post type for starships.', 'starships' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'starships' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-building',
		'supports'           => array( 'title' ),
	);

	register_post_type( 'starships', $args );
}
