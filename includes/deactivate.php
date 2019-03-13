<?php

function sw_deactivate_plugin() {
	wp_clear_scheduled_hook( 'starwars_retrieval_hook' );
}
