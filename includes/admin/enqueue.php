<?php

function sw_admin_enqueue() {
	global $typenow;

	if ( $typenow != "starships" ) {
		return;
	}

	wp_register_style(
		'ju_bootstrap',
		plugins_url( '/assets/styles/bootstrap.css', STARWARS_PLUGIN_URL )
	);

	wp_register_style(
		'admin_main_style',
		plugins_url( '/assets/styles/main.css', STARWARS_PLUGIN_URL )
	);

	wp_enqueue_style( 'ju_bootstrap' );
	wp_enqueue_style( 'admin_main_style' );
}
