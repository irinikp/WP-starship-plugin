<?php

function starship_init()
{
    $labels = array(
        'name'               => __('Starships', 'starship'),
        'singular_name'      => __('Starship', 'starship'),
        'menu_name'          => __('Starships', 'starship'),
        'name_admin_bar'     => __('Starship', 'starship'),
        'add_new'            => __('Add New', 'starship'),
        'add_new_item'       => __('Add New Starship', 'starship'),
        'new_item'           => __('New Starship', 'starship'),
        'edit_item'          => __('Edit Starship', 'starship'),
        'view_item'          => __('View Starship', 'starship'),
        'all_items'          => __('All Starships', 'starship'),
        'search_items'       => __('Search Starships', 'starship'),
        'parent_item_colon'  => __('Parent Starships:', 'starship'),
        'not_found'          => __('No starships found.', 'starship'),
        'not_found_in_trash' => __('No starships found in Trash.', 'starship'),
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('A custom post type for starships.', 'starship'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'starship'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array('title', 'editor', 'author', 'thumbnail'),
        'taxonomies'         => array('category', 'post_tag'),
    );

    register_post_type('starship', $args);
}
