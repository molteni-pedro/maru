<?php
namespace Jet_Engine\Query_Builder;

use Jet_Engine\Meta_Boxes\Option_Sources\Manual_Bulk_Options;

class Meta_Fields_Options_Source extends Manual_Bulk_Options {

	public $source_name = 'query';

	/**
	 * Custom part of init
	 * 
	 * @return [type] [description]
	 */
	public function init() {
		add_filter( 'jet-engine/meta-fields/config', array( $this, 'add_data_to_config' ) );
	}

	/**
	 * Add queries to meta fields config
	 * 
	 * @param [type] $config [description]
	 */
	public function add_data_to_config( $config ) {
		$config['queries'] = Manager::instance()->get_queries_for_options( true );
		return $config;
	}

	public function parse_options( $field ) {
	
		return function() use ( $field ) {

			$result = [];

			$query_id = ! empty( $field['query_id'] ) ? $field['query_id'] : false;

			if ( ! $query_id ) {
				return $result;
			}

			$query = Manager::instance()->get_query_by_id( $query_id );

			if ( ! $query ) {
				return $result;
			}

			$items = $query->get_items();

			if ( empty( $items ) ) {
				return $result;
			}

			$value_field = ! empty( $field['query_value_field'] ) ? $field['query_value_field'] : 'ID';
			$label_field = ! empty( $field['query_label_field'] ) ? $field['query_label_field'] : 'post_title';

			foreach ( $items as $item ) {

				$value = ( is_object( $item ) && isset( $item->$value_field ) ) ? $item->$value_field : null;

				if ( null === $value ) {
					continue;
				}

				$result[ $value ] = [
					'label' => isset( $item->$label_field ) ? $item->$label_field : $value,
				];

			}

			return $result;

		};

	}

}
