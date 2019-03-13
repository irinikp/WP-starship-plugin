<?php

function sw_create_metaboxes() {
	add_meta_box(
		'sw_starship_options_mb',
		__( 'starship Info', 'starships' ),
		'sw_starship_options_mb',
		'starships',
		'advanced',
		'high'
	);
}
