<?php

namespace GutenbergSidebar\classes\controllers;

use GutenbergSidebar\App;
use GutenbergSidebar\classes\models\Post;
use GutenbergSidebar\helpers\ViewsLoader;

class AdminController {

	public static function init() {
		add_action('add_meta_boxes', [__CLASS__, 'registerMetabox']);
		add_action('save_post', [__CLASS__, 'savePost']);
	}

	public static function registerMetabox() {
		add_meta_box( 'gs-advertising-settings', __('Advertising Settings', App::TEXT_DOMAIN), [__CLASS__, 'printMetabox'], Post::POST_TYPE, 'side');
	}

	public static function printMetabox() {
		$post = Post::getInstance(get_post());
		$meta_fields = $post->getMetaFields();
		wp_enqueue_style('gs-styles');
		wp_enqueue_script('gs-scripts');

		echo ViewsLoader::load('advertising-metabox.php', [
			'fields' => $meta_fields
		]);
	}

	public static function savePost($post_id) {
		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || empty($_POST)) {
			return;
		}
		$post = Post::getInstance($post_id);
		foreach ($_POST as $key => $value) {
			if(strpos($key, 'gs-') !== false) {
				$post->setPostMeta($key, $value);
			}
		}
	}

}
