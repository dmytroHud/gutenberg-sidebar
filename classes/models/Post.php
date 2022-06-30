<?php

namespace GutenbergSidebar\classes\models;

use GutenbergSidebar\App;
use GutenbergSidebar\classes\models\abstracts\PostType;

class Post extends PostType {

	const POST_TYPE = 'post';
	static $metaFields = [
		'gs-ad-status'    => [
			'label' => 'Advertisements',
			'type'  => 'bool',
			'value' => 1,
		],
		'gs-content-type' => [
			'label'   => 'Commercial content type',
			'type'    => 'radio',
			'options' => [
				'0'         => 'None',
				'sponsored' => 'Sponsored content',
				'partnered' => 'Partnered content',
				'brought'   => 'Brought to you by'
			],
			'value'   =>  '0',
		],
		'gs-name'         => [
			'label' => 'Advertiser name',
			'type'  => 'string',
			'value' => '',
			'condition' => [
				'gs-content-type' => [
					'sponsored',
					'partnered',
					'brought',
				]
			]
		]
	];

	public function getMetaFields() {
		$meta_fields = [];

		foreach (static::$metaFields as $key => $config) {
			$value = $this->getMetaValue($key);
			$field = [
				'label' => __($config['label'], App::TEXT_DOMAIN),
				'type' => $config['type'],
				'value' => $value,
				'show' => true
			];

			if(isset($config['options'])) {
				$field['options'] = $config['options'];
			}

			if(isset($config['condition'])){
				$field['condition'] = $config['condition'];
				$field_name = array_key_first($config['condition']);
				$field_value = $this->getMetaValue($field_name);
				if(!in_array($field_value, $config['condition'][$field_name])) {
					$field['show'] = false;
				}
			}

			$meta_fields[$key] = $field;
		}

		return $meta_fields;
	}

	public function getMetaValue($name) {
		$current_value = $this->getPostMeta($name);
		$default_value = static::$metaFields[$name]['value'] ?? '';

		if($current_value !== '' && $current_value != $default_value){
		    return $current_value;
		}

		return $default_value;
	}

}