<?php

function sw_activate_plugin() {
	if ( version_compare( get_bloginfo( 'version' ), '4.9', '<' ) ) {
		wp_die( __( 'You must update WordPress to use this plugin', 'starwars-custom-post-types' ) );
	}

	sw_starship_init();
	\Starwars\WP\Plugin\Handler\Swapi::populate_starships();
	flush_rewrite_rules();
}
