<?php

function star_deactivate_plugin()
{
    global $wpdb;
    $wpdb->query("DELETE FROM `" . $wpdb->prefix . "posts` WHERE post_type='starship'");
}
