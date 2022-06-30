<?php

namespace GutenbergSidebar\views;

class MetaboxView {

	public static function renderOptionControls($optionKey, $config) {

		switch ($config['type']) {
			case 'bool':
				return self::renderBool($optionKey, $config);
			case 'radio':
				return '<div class="multiline">' . self::renderRadio($optionKey, $config['options'], $config['value']) . '</div>';
			case 'string':
				return self::renderInputText($optionKey, $config);
			default:
				return '';
		}
	}

	protected static function renderBool($optionKey, $settings) {
		return self::renderRadio($optionKey, array(1 => 'On', 0 => 'Off'), $settings['value']);
	}

	protected static function renderRadio($name, $options, $currentValue) {
		$result = '';
		$fieldName = esc_attr($name);
		foreach ($options as $value => $text) {
			$fieldId = esc_attr($name . '_' . $value);
			$result .= sprintf('<label><input type="radio" name="%s" id="%s" value="%s"%s /> %s</label>',
				$fieldName, $fieldId, esc_attr($value),
				( $currentValue == $value ? ' checked="checked"' : ''), esc_html($text)
			);
		}
		return $result;
	}

	protected static function renderSelect($name, $settings) {
		return sprintf('<div><select name="%s">%s</select></div>', esc_attr($name), self::renderSelectOptions($name, $settings['options'], $settings['value']));
	}

	protected static function renderSelectOptions($name, $options, $currentValue) {
		$result = '';
		foreach ($options as $value => $text) {
			$result .= sprintf('<option value="%s"%s>%s</option>',
				esc_attr($value),
				( self::isSelected($value, $currentValue) ? ' selected="selected"' : ''),
				esc_html($text)
			);
		}
		return $result;
	}

	protected static function isSelected($option, $value) {
		if (is_array($value)) {
			return in_array($option, $value);
		} else {
			return ((string) $option == (string) $value);
		}
	}

	protected static function renderInputText($name, $settings) {
		return sprintf('<input type="text" name="%s" value="%s" />', esc_attr($name), esc_attr($settings['value']));
	}

	protected static function renderLabel($name, $settings) {
		return sprintf('<input type="text" name="%s" value="%s" />', $name, $settings['value']);
	}

	public static function getConditionForItem($config) {
		$output = '';
		if(isset($config['condition'])) {
			$field = array_key_first($config['condition']);
			$value = implode(',', $config['condition'][$field]);
			$output = ' data-field="' . $field . '" data-value="' . $value . '"';
		}
		return $output;
	}
}