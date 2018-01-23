<?php
/*
 * Plugin Name: Starship
 * Description: A plugin to show all Star Wars Starships
 * Version: 1.0
 * Author: Irini Koutaki
 * Author URI: http://irinikp.com
 * Text Domain: starship
 */

if (!function_exists('add_action')) {
    die("Hi there! I'm just a plugin, not much I can do when called directly.");
}

// Setup

// Includes
include 'includes/activate.php';
include 'includes/init.php';
include 'includes/swapi.php';
include 'includes/deactivate.php';

// Hooks
register_activation_hook(__FILE__, 'star_activate_plugin');
register_deactivation_hook(__FILE__, 'star_deactivate_plugin');
add_action('init', 'starship_init');
add_action('swapi', 'retrieve_starships');

// Shortcodes
remove_action('shutdown', 'wp_ob_end_flush_all', 1);
