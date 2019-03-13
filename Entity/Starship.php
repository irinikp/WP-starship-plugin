<?php

namespace Starwars\WP\Plugin\Entity;

use Starwars\WP\Plugin\Handler\Database as Database_Handler;

class Starship {
	/** int */
	private $id;
	/** string */
	private $name;
	/** string */
	private $model;
	/** string */
	private $manufacturer;
	/** string */
	private $cost_in_credits;
	/** string */
	private $length;
	/** string */
	private $max_atmosphering_speed;
	/** string */
	private $crew;
	/** string */
	private $passengers;
	/** string */
	private $cargo_capacity;
	/** string */
	private $hyperdrive_rating;
	/** string */
	private $mglt;
	/** string */
	private $class;
	/** string */
	private $consumables;

	public function __construct( $post_id = null ) {
		$this->name                   = '';
		$this->model                  = '';
		$this->manufacturer           = '';
		$this->cost_in_credits        = '';
		$this->length                 = '';
		$this->max_atmosphering_speed = '';
		$this->crew                   = '';
		$this->passengers             = '';
		$this->cargo_capacity         = '';
		$this->hyperdrive_rating      = '';
		$this->mglt                   = '';
		$this->class                  = '';
		$this->consumables            = '';
		if ( $post_id !== null ) {
			$this->populate_from_DB( $post_id );
		}
	}

	/**
	 * @param int $post_id
	 */
	public function populate_from_DB( $post_id ) {
		$database_handler = new Database_Handler();
		$database_handler->populate_object_from_post( $post_id, 'starships', $this );
		$this->generate_from_meta( $post_id, 'starship_info' );
	}

	/**
	 * @param int $post_id
	 * @param $meta_key
	 */
	public function generate_from_meta( $post_id, $meta_key ) {
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( is_array( $meta_value ) ) {
			if ( $meta_value && array_key_exists( 'name', $meta_value ) ) {
				$this->set_name( $meta_value['name'] );
			}
			if ( $meta_value && array_key_exists( 'model', $meta_value ) ) {
				$this->set_model( $meta_value['model'] );
			}
			if ( $meta_value && array_key_exists( 'manufacturer', $meta_value ) ) {
				$this->set_manufacturer( $meta_value['manufacturer'] );
			}
			if ( $meta_value && array_key_exists( 'cost_in_credits', $meta_value ) ) {
				$this->set_cost_in_credits( $meta_value['cost_in_credits'] );
			}
			if ( $meta_value && array_key_exists( 'length', $meta_value ) ) {
				$this->set_length( $meta_value['length'] );
			}
			if ( $meta_value && array_key_exists( 'max_atmosphering_speed', $meta_value ) ) {
				$this->set_max_atmosphering_speed( $meta_value['max_atmosphering_speed'] );
			}
			if ( $meta_value && array_key_exists( 'crew', $meta_value ) ) {
				$this->set_crew( $meta_value['crew'] );
			}
			if ( $meta_value && array_key_exists( 'passengers', $meta_value ) ) {
				$this->set_passengers( $meta_value['passengers'] );
			}
			if ( $meta_value && array_key_exists( 'cargo_capacity', $meta_value ) ) {
				$this->set_cargo_capacity( $meta_value['cargo_capacity'] );
			}
			if ( $meta_value && array_key_exists( 'hyperdrive_rating', $meta_value ) ) {
				$this->set_hyperdrive_rating( $meta_value['hyperdrive_rating'] );
			}
			if ( $meta_value && array_key_exists( 'mglt', $meta_value ) ) {
				$this->set_mglt( $meta_value['mglt'] );
			}
			if ( $meta_value && array_key_exists( 'class', $meta_value ) ) {
				$this->set_class( $meta_value['class'] );
			}
		}
	}

	/**
	 * @return string[]
	 */
	public static function get_starships() {
		$starships        = array();
		$database_handler = new Database_Handler();
		$entries          = $database_handler->get_cpt_id_name( 'starships' );
		foreach ( $entries as $entry ) {
			$starships[ $entry['id'] ] = $entry['name'];
		}

		return $starships;
	}

	/**
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	public function save() {
		$db_handler                                           = new Database_Handler();
		$post_id                                              = $db_handler->update_starwars_entry( '', $this->get_name(), null, '', 'starships' );
		$meta_data                                            = array();
		$meta_data['starship_info']                           = array();
		$meta_data['starship_info']['name']                   = $this->get_name();
		$meta_data['starship_info']['model']                  = $this->get_model();
		$meta_data['starship_info']['manufacturer']           = $this->get_manufacturer();
		$meta_data['starship_info']['cost_in_credits']        = $this->get_cost_in_credits();
		$meta_data['starship_info']['length']                 = $this->get_length();
		$meta_data['starship_info']['max_atmosphering_speed'] = $this->get_max_atmosphering_speed();
		$meta_data['starship_info']['crew']                   = $this->get_crew();
		$meta_data['starship_info']['passengers']             = $this->get_passengers();
		$meta_data['starship_info']['cargo_capacity']         = $this->get_cargo_capacity();
		$meta_data['starship_info']['hyperdrive_rating']      = $this->get_hyperdrive_rating();
		$meta_data['starship_info']['mglt']                   = $this->get_mglt();
		$meta_data['starship_info']['class']                  = $this->get_class();
		$meta_data['starship_info']['consumables']            = $this->get_consumables();
		update_post_meta( $post_id, 'starship_info', $meta_data['starship_info'] );
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function get_model() {
		return $this->model;
	}

	/**
	 * @param string $model
	 */
	public function set_model( $model ) {
		$this->model = $model;
	}

	/**
	 * @return string
	 */
	public function get_manufacturer() {
		return $this->manufacturer;
	}

	/**
	 * @param string $manufacturer
	 */
	public function set_manufacturer( $manufacturer ) {
		$this->manufacturer = $manufacturer;
	}

	/**
	 * @return string
	 */
	public function get_cost_in_credits() {
		return $this->cost_in_credits;
	}

	/**
	 * @param string $cost_in_credits
	 */
	public function set_cost_in_credits( $cost_in_credits ) {
		$this->cost_in_credits = $cost_in_credits;
	}

	/**
	 * @return string
	 */
	public function get_length() {
		return $this->length;
	}

	/**
	 * @param string $length
	 */
	public function set_length( $length ) {
		$this->length = $length;
	}

	/**
	 * @return string
	 */
	public function get_max_atmosphering_speed() {
		return $this->max_atmosphering_speed;
	}

	/**
	 * @param string $max_atmosphering_speed
	 */
	public function set_max_atmosphering_speed( $max_atmosphering_speed ) {
		$this->max_atmosphering_speed = $max_atmosphering_speed;
	}

	/**
	 * @return string
	 */
	public function get_crew() {
		return $this->crew;
	}

	/**
	 * @param string $crew
	 */
	public function set_crew( $crew ) {
		$this->crew = $crew;
	}

	/**
	 * @return string
	 */
	public function get_passengers() {
		return $this->passengers;
	}

	/**
	 * @param string $passengers
	 */
	public function set_passengers( $passengers ) {
		$this->passengers = $passengers;
	}

	/**
	 * @return string
	 */
	public function get_cargo_capacity() {
		return $this->cargo_capacity;
	}

	/**
	 * @param string $cargo_capacity
	 */
	public function set_cargo_capacity( $cargo_capacity ) {
		$this->cargo_capacity = $cargo_capacity;
	}

	/**
	 * @return string
	 */
	public function get_hyperdrive_rating() {
		return $this->hyperdrive_rating;
	}

	/**
	 * @param string $hyperdrive_rating
	 */
	public function set_hyperdrive_rating( $hyperdrive_rating ) {
		$this->hyperdrive_rating = $hyperdrive_rating;
	}

	/**
	 * @return string
	 */
	public function get_mglt() {
		return $this->mglt;
	}

	/**
	 * @param string $mglt
	 */
	public function set_mglt( $mglt ) {
		$this->mglt = $mglt;
	}

	/**
	 * @return string
	 */
	public function get_class() {
		return $this->class;
	}

	/**
	 * @param string $class
	 */
	public function set_class( $class ) {
		$this->class = $class;
	}

	/**
	 * @return string
	 */
	public function get_consumables() {
		return $this->consumables;
	}

	public function set_consumables( $consumables ) {
		$this->consumables = $consumables;
	}
}
