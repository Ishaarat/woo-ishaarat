<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! function_exists( 'ishaarat_input_fields' ) ) {
	/**
	 * Generate appropriate fields for meta and page in WordPress.
	 *
	 * @param string $key Key.
	 * @param mixed $args Arguments.
	 * @param string $value (default: null).
	 *
	 * @return string
	 */
	function ishaarat_input_fields( $key, $args, $value = null, $uniqkey = false ) {

		$id = $key;
		if ( $uniqkey ) {
			$id = uniqid();
		}

		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'autocomplete'      => false,
			'id'                => $id,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'return'            => false,
			'options'           => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'           => '',
			'autofocus'         => '',
			'priority'          => '',
		);

		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'ishaarat_form_field_args', $args, $key, $value );

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', WOO_ISHAARAT_PLUGIN_NAME ) . '">*</abbr>';
		} else {
			$required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', WOO_ISHAARAT_PLUGIN_NAME ) . ')</span>';
		}

		if ( is_string( $args['label_class'] ) ) {
			$args['label_class'] = array( $args['label_class'] );
		}

		if ( is_null( $value ) || empty( $value ) ) {
			$value = $args['default'];
		}

		$counter = 0;
		$limit   = 0;

		if ( ! isset( $args['textarea_class'] ) ) {
			$args['textarea_class'] = array();
		}

		// Custom attribute handling.
		$custom_attributes         = array();
		$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

		if ( $args['maxlength'] ) {
			$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
		}

		if ( ! empty( $args['autocomplete'] ) ) {
			$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
		}

		if ( true === $args['autofocus'] ) {
			$args['custom_attributes']['autofocus'] = 'autofocus';
		}

		if ( $args['description'] ) {
			$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
		}

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		if ( ! empty( $args['validate'] ) ) {
			foreach ( $args['validate'] as $validate ) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field    = '';
		$label_id = $args['id'];
		$sort     = $args['priority'] ? $args['priority'] : '';
		if ( isset( $custom_attributes['wrapper'] ) ) {
			$field_container = '<p class="form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p><br/>';
		} else {
			$field_container = '%3$s';
		}

		switch ( $args['type'] ) {
			case 'textarea':
				$field_container = '<div class="form-row %1$s ' . esc_attr( implode( ' ', $args['textarea_class'] ) ) . '" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div><br/>';
				$n_time          = 1;
				if ( isset( $args['n_display'] ) ) {
					$n_time  = $args['n_display'];
					$limit   = $n_time;
					$counter = 1;
				}
				while ( $counter <= $limit ) {
					if ( isset( $args['multiple_values'] ) ) {
						$value = $args['multiple_values'][ $counter - 1 ];
					}
					$field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . ' data-id="' . $counter . '">' . esc_textarea( $value ) . '</textarea><br/>';
					++ $counter;
				}
				break;
			case 'checkbox':
				$field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
						<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

				break;
			case 'text':
			case 'password':
			case 'datetime':
			case 'datetime-local':
			case 'date':
			case 'month':
			case 'time':
			case 'week':
			case 'number':
			case 'email':
			case 'url':
			case 'tel':
				$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'select':
				$field   = '';
				$options = '';

				if ( isset( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						$selected = '';
						if ( '' === $option_key ) {
							// If we have a blank option, select2 needs a placeholder.
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', WOO_ISHAARAT_PLUGIN_NAME );
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}

						if ( isset( $args['selected'] ) && in_array( $option_key, $args['selected'], true ) ) {
							$selected = 'selected=selected';
						}

						$options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . ' ' . $selected . ' >' . esc_attr( $option_text ) . '</option>';
					}

					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
							' . $options . '
						</select>';
				}

				break;
			case 'radio':
				$label_id .= '_' . current( array_keys( $args['options'] ) );

				if ( ! empty( $args['options'] ) ) {
					$field .= "<div class='woo-ishaarat-radio'>";
					foreach ( $args['options'] as $option_key => $option_text ) {
						$field .= '<span class="woo-ishaarat-"' . esc_attr( $option_key ) . '><input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
						$field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label></span>';
					}
					$field .= "</div>";
				}

				break;
		}

		if ( ! empty( $field ) ) {
			$field_html = '';

			if ( $args['label'] && 'checkbox' !== $args['type'] ) {
				$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '"><strong>' . $args['label'] . $required . '</strong></label>';
			}

			$field_html .= '<span class="ishaarat-input-wrapper">' . $field;

			if ( $args['description'] ) {
				$field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
			}

			$field_html .= '</span> ';

			$container_class = esc_attr( implode( ' ', $args['class'] ) );
			$container_id    = esc_attr( $args['id'] ) . '_field';
			$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
		}

		/**
		 * Filter by type.
		 */
		$field = apply_filters( 'ishaarat_form_field_' . $args['type'], $field, $key, $args, $value );

		/**
		 * General filter on form fields.
		 *
		 * @since 3.4.0
		 */
		$field = apply_filters( 'ishaarat_form_field', $field, $key, $args, $value );

		if ( $args['return'] ) {
			return $field;
		} else {
			Woo_Ishaarat_UI_Fields::format_html_fields( $field );
		}
	}
}

if ( ! function_exists( 'ishaarat_input_table' ) ) {
	/**
	 * This method displays input fields into the dashboard.
	 *
	 * @param $key
	 * @param $args
	 */
	function ishaarat_input_table( $key, $args ) {
		$html = "<table style='border-style:double;' name='ishaarat-input-" . $key . "'> <tbody>";
		foreach ( $args as $arg_key => $arg ) {
			$label_class = '';
			if ( isset( $arg['label_class'] ) ) {
				$label_class = $arg['label_class'];
			}
			$tr_class = '';
			if ( isset( $arg['tr_class'] ) ) {
				$tr_class = $arg['tr_class'];
			}
			$html .= "<tr class='" . $tr_class . "'><td class='" . $label_class . "'>";
			if ( isset( $arg['label'] ) ) {
				$html .= '<strong>' . $arg['label'] . '</strong>';
			}
			if ( isset( $arg['description'] ) ) {
				$html .= '<br/>' . $arg['description'];
			}
			$html .= '</td><td>';
			if ( isset( $arg['content'] ) ) {
				$html .= $arg['content'];
			}
			$html .= '</td></tr>';
		}
		$html .= '</tbody></table>';
		Woo_Ishaarat_UI_Fields::format_html_fields( $html );
	}
}
