<?php

namespace Starwars\WP\Plugin\Handler;

use Starwars\WP\Plugin\Entity\Booking;
use Starwars\WP\Plugin\Entity\Excursion;

/**
 * Class Database
 * @package Starwars\WP\Plugin\Handler
 */
class Database {
	const IMAGE_BASE_PATH = '';

	/**
	 * @param string $cpt_name
	 *
	 * @return array
	 */
	public function get_cpt_id_name( $cpt_name ) {
		global $wpdb;
		$cpt_entries      = array();
		$response_entries = $wpdb->get_results( $wpdb->prepare( "SELECT ID as post_id, post_title FROM $wpdb->posts WHERE post_type=%s and post_status=%s", [
			$cpt_name,
			'publish'
		] ) );
		$db_entries       = $response_entries;
		foreach ( $db_entries as $entry ) {
			$entity = [
				'id'   => $entry->post_id,
				'name' => $entry->post_title
			];
			array_push( $cpt_entries, $entity );
		}

		return $cpt_entries;
	}

	/**
	 * @param int $post_id
	 * @param string $post_type
	 * @param Object $object
	 */
	public function populate_object_from_post( $post_id, $post_type, $object ) {
		global $wpdb;

		$object->set_id( $post_id );
		$post_entries = $wpdb->get_results( $wpdb->prepare( "SELECT post_title FROM $wpdb->posts WHERE ID=%d AND post_type=%s AND post_status=%s limit 0,1", [
			$post_id,
			$post_type,
			'publish'
		] ) );
		if ( ! empty( $post_entries ) ) {
			$post_entry = $post_entries[0];
			$object->set_name( $post_entry->post_title );
		}
	}

	public function remove_webservice_entries() {
		global $wpdb;

		$myrows = $wpdb->get_col( $wpdb->prepare( "SELECT id FROM $wpdb->posts WHERE post_type=%s", [ 'starships' ] ) );
		foreach ( $myrows as $starship_id ) {
			$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'post_id' => $starship_id ) );
			$wpdb->delete( $wpdb->posts, array( 'ID' => $starship_id ) );
		}
	}

	/**
	 * @param string $post_content
	 * @param string $post_title
	 * @param int $entry_id
	 * @param string $post_excerpt
	 * @param string $post_type
	 *
	 * @return int
	 */
	public function update_starwars_entry( $post_content, $post_title, $entry_id, $post_excerpt, $post_type ) {
		global $wpdb;
		$post_id = $this->get_post_id( $entry_id );
		if ( null !== $post_id ) {
			$entry = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID=%d AND post_status=%s", [
				$post_id,
				'publish'
			] ) );
			if ( null !== $entry ) {
				$update_data = array();
				$format      = array();
				if ( $post_content !== $entry->post_content ) {
					$update_data['post_content'] = $post_content;
					array_push( $format, '%s' );
				}
				if ( $post_title !== $entry->post_title ) {
					$update_data['post_title'] = $post_title;
					array_push( $format, '%s' );
				}
				if ( $post_excerpt !== $entry->post_excerpt ) {
					$update_data['post_excerpt'] = $post_excerpt;
					array_push( $format, '%s' );
				}
				if ( $post_type !== $entry->post_type ) {
					$update_data['post_type'] = $post_type;
					array_push( $format, '%s' );
				}
				$slug = $this->get_entity_slug( $entry_id );
				if ( $slug !== $entry->post_name ) {
					$update_data['post_name'] = $slug;
					array_push( $format, '%s' );
				}
				if ( ! empty( $update_data ) ) {
					$wpdb->update(
						$wpdb->posts,
						$update_data,
						array( 'ID' => $entry->ID ),
						$format,
						array( '%d' )
					);
				}

				return $entry->ID;
			}
		} else {
			return $this->add_starwars_entry( $post_content, $post_title, $entry_id, $post_excerpt, $post_type );
		}
	}

	/**
	 * @param int $entry_id
	 *
	 * @return int|NULL
	 */
	private function get_post_id( $entry_id ) {
		return $entry_id;
	}

	/**
	 * @param int $entity_id
	 *
	 * @return string
	 */
	public function get_entity_slug( $entity_id ) {
		if ( $entity_id === null ) {
			return '';
		}
		$post = get_post( $entity_id );

		return $post->post_name;
	}

	/**
	 * @param string $post_content
	 * @param string $post_title
	 * @param int $entry_id
	 * @param string $post_excerpt
	 * @param string $post_type
	 *
	 * @return int
	 */
	private function add_starwars_entry( $post_content, $post_title, $entry_id, $post_excerpt, $post_type ) {
		global $wpdb;

		if ( ! $post_content ) {
			$post_content = '';
		}
		if ( ! $post_excerpt ) {
			$post_excerpt = '';
		}
		$contents = array(
			'post_date'             => date( 'Y-m-d H:i:s' ),
			'post_date_gmt'         => get_gmt_from_date( date( 'Y-m-d H:i:s' ) ),
			'post_content'          => $post_content,
			'post_title'            => $post_title,
			'post_name'             => $this->get_entity_slug( $entry_id ),
			'post_excerpt'          => $post_excerpt,
			'post_status'           => 'publish',
			'comment_status'        => 'closed',
			'ping_status'           => 'closed',
			'to_ping'               => '',
			'pinged'                => '',
			'post_modified'         => date( 'Y-m-d H:i:s' ),
			'post_modified_gmt'     => get_gmt_from_date( date( 'Y-m-d H:i:s' ) ),
			'post_content_filtered' => '',
			'post_type'             => $post_type,
			'post_mime_type'        => '',
		);

		$wpdb->insert(
			$wpdb->posts,
			$contents,
			array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
		);
		$link_id    = (int) $wpdb->insert_id;
		if ( false === $wpdb->update(
				$wpdb->posts,
				array(
					'guid' => get_site_url() . '?post_type=' . $post_type . '&#038;p=' . $link_id,
				),
				array(
					'ID' => $link_id,
				),
				array(
					'%s',
				),
				array( '%d' )
			) ) {
			if ( $wp_error ) {
				return new WP_Error( 'db_update_error', __( 'Could not update link in the database' ), $wpdb->last_error );
			} else {
				return $link_id;
			}
		}

		return $link_id;
	}

	/**
	 * @param int $post_id
	 * @param string $meta_key
	 * @param string[]|string $meta_values
	 * @param bool $value_is_array
	 */
	public function update_starwars_postmeta( $post_id, $meta_key, $meta_values, $value_is_array = true ) {
		global $wpdb;
		$meta_value = $meta_values;
		if ( $value_is_array ) {
			$meta_value = $this->get_meta_value( $meta_values );
		}

		$entry = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "postmeta WHERE post_id=%d and meta_key=%s", [
			$post_id,
			$meta_key
		] ) );
		if ( null !== $entry ) {
			$update_data = array();
			$format      = array();
			if ( $meta_value !== $entry->meta_value ) {
				$update_data['meta_value'] = $meta_value;
				array_push( $format, '%s' );
			}
			if ( ! empty( $update_data ) ) {
				$update_result = $wpdb->update(
					'wp_postmeta',
					array(
						'meta_value' => $meta_value
					),
					array(
						'post_id'  => $post_id,
						'meta_key' => $meta_key
					),
					array( '%s' ),
					array(
						'%d',
						'%s'
					)
				);
				if ( false === $update_result ) {
					error_log( "could not update postmeta $post_id, $meta_key, $meta_value" );
				}
			}
		} else {
			$this->add_starwars_postmeta( $post_id, $meta_key, $meta_value );
		}
	}

	/**
	 * @param string[] $meta_values
	 *
	 * @return string
	 */
	private function get_meta_value( $meta_values ) {
		$meta_value = '';
		$meta_value .= 'a:' . sizeof( $meta_values ) . ':{';
		if ( $meta_values ) {
			foreach ( $meta_values as $key => $value ) {
				$meta_value .= 's:' . strlen( $key ) . ':"' . $key . '";s:' . strlen( $value ) . ':"' . $value . '";';
			}
		}
		$meta_value .= '}';

		return $meta_value;
	}

	/**
	 * @param int $post_id
	 * @param string $meta_key
	 * @param string $meta_value
	 */
	private function add_starwars_postmeta( $post_id, $meta_key, $meta_value ) {
		global $wpdb;

		$wpdb->insert(
			$wpdb->prefix . 'postmeta',
			array(
				'post_id'    => $post_id,
				'meta_key'   => $meta_key,
				'meta_value' => $meta_value,
			),
			array( '%d', '%s', '%s' )
		);
	}
}
