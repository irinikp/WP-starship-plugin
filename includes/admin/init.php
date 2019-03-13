<?php

function sw_admin_init() {
	include 'create-metaboxes.php';
	include 'starship-info.php';
	include 'enqueue.php';

	add_action( 'add_meta_boxes_starships', 'sw_create_metaboxes' );
	add_action( 'admin_enqueue_scripts', 'sw_admin_enqueue' );
}
