<?php

function retrieve_starships()
{
    global $wpdb;

    $starships_api_response = wp_remote_get('https://swapi.co/api/starships/');

    $starships_response_object = json_decode(wp_remote_retrieve_body($starships_api_response));
    $starships_number          = $starships_response_object->count;
    $next_page_url             = $starships_response_object->next;
    $starships                 = $starships_response_object->results;
    $starships_html            = '';
    $starship_title            = '';
    $starship_id               = 1;
    foreach ($starships as $starship) {
        $starship_title = $starship->name;
        $starships_html = '<b>Name</b>: ' . $starship_title . '<br/>';
        $starships_html .= '<b>Model</b>: ' . $starship->model . '<br/>';
        $starships_html .= '<b>Manufacturer</b>: ' . $starship->manufacturer . '<br/>';
        $starships_html .= '<b>Cost in credits</b>: ' . $starship->cost_in_credits . '<br/>';
        $starships_html .= '<b>Length</b>: ' . $starship->length . '<br/>';
        $starships_html .= '<b>Max atmosphering speed</b>: ' . $starship->max_atmosphering_speed . '<br/>';
        $starships_html .= '<b>Crew</b>: ' . $starship->crew . '<br/>';
        $starships_html .= '<b>Passengers</b>: ' . $starship->passengers . '<br/>';
        $starships_html .= '<b>Cargo capacity</b>: ' . $starship->cargo_capacity . '<br/>';
        $starships_html .= '<b>Consumables</b>: ' . $starship->consumables . '<br/>';
        $starships_html .= '<b>Hyperdrive rating</b>: ' . $starship->hyperdrive_rating . '<br/>';
        $starships_html .= '<b>MGLT</b>: ' . $starship->MGLT . '<br/>';
        $starships_html .= '<b>Starship class</b>: ' . $starship->starship_class . '<br/>';
        $starships_html .= '<b>Pilots</b>: <ul>';
        foreach ($starship->pilots as $pilot) {
            $starships_html .= '<li>' . $pilot . '</li>';
        }
        $starships_html .= '</ul><b>Films</b>: <ul>';
        foreach ($starship->films as $film) {
            $starships_html .= '<li>' . $film . '</li>';
        }
        $starships_html .= '</ul><b>Created</b>: ' . $starship->created . '<br/>';
        $starships_html .= '<b>Edited</b>: ' . $starship->edited . '<br/>';
        $starships_html .= '<b>Url</b>: ' . $starship->url;

        // Insert into database
        $wpdb->insert(
            $wpdb->prefix . 'posts',
            array(
                'post_content'          => $starships_html,
                'post_title'            => $starship_title,
                'post_name'             => str_replace(' ', '', trim(strtolower($starship_title))),
                'post_excerpt'          => '',
                'comment_status'        => 'closed',
                'ping_status'           => 'closed',
                'to_ping'               => '',
                'pinged'                => '',
                'post_content_filtered' => '',
                'post_type'             => 'starship',
                'post_mime_type'        => '',
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        $link_id = (int) $wpdb->insert_id;
        if (false === $wpdb->update(
            $wpdb->prefix . 'posts',
            array(
                'guid' => get_site_url() . '?post_type=starship&p=' . $link_id,
            ),
            array(
                'ID' => $link_id,
            ),
            array(
                '%s',
            ),
            array('%d')
        )) {
            if ($wp_error) {
                return new WP_Error('db_update_error', __('Could not update link in the database'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
    }
}
