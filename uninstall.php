<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
include 'Handler/Database.php';
$database_handler = new Starwars\WP\Plugin\Handler\Database();
$database_handler->remove_webservice_entries();
