<?php
/**
 * Created by PhpStorm.
 * User: irinikoutaki
 * Date: 2019-03-12
 * Time: 17:53
 */

namespace Starwars\WP\Plugin\Handler;


use Starwars\WP\Plugin\Entity\Starship;

class Swapi {

	const SWAPI_URL = 'https://swapi.co/api/';

	public static function populate_starships() {
		$starships_url          = 'starships/';
		$starships_api_response = wp_remote_get( self::SWAPI_URL . $starships_url );
		error_log( self::SWAPI_URL . $starships_url );

		$starships_response_object = json_decode( wp_remote_retrieve_body( $starships_api_response ) );
		$starships_number          = $starships_response_object->count;
		$next_page_url             = $starships_response_object->next;
		$starships                 = $starships_response_object->results;
		foreach ( $starships as $starship ) {
			$wp_starship = new Starship();
			$wp_starship->set_name( $starship->name );
			$wp_starship->set_model( $starship->model );
			$wp_starship->set_manufacturer( $starship->manufacturer );
			$wp_starship->set_cost_in_credits( $starship->cost_in_credits );
			$wp_starship->set_length( $starship->length );
			$wp_starship->set_max_atmosphering_speed( $starship->max_atmosphering_speed );
			$wp_starship->set_crew( $starship->crew );
			$wp_starship->set_passengers( $starship->passengers );
			$wp_starship->set_cargo_capacity( $starship->cargo_capacity );
			$wp_starship->set_consumables( $starship->consumables );
			$wp_starship->set_hyperdrive_rating( $starship->hyperdrive_rating );
			$wp_starship->set_mglt( $starship->MGLT );
			$wp_starship->set_class( $starship->starship_class );
			$wp_starship->save();
		}
	}

}