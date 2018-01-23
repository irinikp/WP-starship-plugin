<?php

function star_activate_plugin()
{
    if (version_compare(get_bloginfo('version'), '4.5', '<')) {
        wp_die(__('You must update WordPress to use this plugin', 'starship'));
    }

    starship_init();
    retrieve_starships();
    flush_rewrite_rules();
}
