<?php

/*
 * Plugin Name: StarWars
 * Plugin URI: https://irinikp.com/
 * Description: Sets up all Custom Post Types needed for the Star Wars API
 * Version: 2.0.0
 * License: (c) irinikp.com
 */

if ( ! function_exists( 'add_action' ) ) {
	die( "Hi there! I'm just a plugin, not much I can do when called directly." );
}

require __DIR__ . '/vendor/autoload.php';

// Setup
define( 'STARWARS_PLUGIN_URL', __FILE__ );

// Includes
include 'includes/activate.php';
include 'includes/deactivate.php';
include 'includes/admin/init.php';
include 'includes/custom-post-types/starship-init.php';

// Hooks
register_activation_hook( __FILE__, 'sw_activate_plugin' );
register_deactivation_hook( __FILE__, 'sw_deactivate_plugin' );
add_action( 'init', 'sw_starship_init' );
add_action( 'admin_init', 'sw_admin_init' );

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
