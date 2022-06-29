<?php
/**
 * Plugin Name: Gutenberg Sidebar
 * Description: Plugin Description
 * Version:     1.0.0
 * Author:      Dmytro Hudenko
 */

namespace GutenbergSidebar;
use GutenbergSidebar\classes\controllers\AdminController;

if ( ! defined( 'ABSPATH' ) ) exit;


final class App {

	const TEXT_DOMAIN = 'post-settings';
	const PLUGIN_VERSION = '1.0.0';
	const PLUGIN_DIR = __DIR__;
	public static $pluginURL = null;

	public function __construct() {
		self::$pluginURL = plugin_dir_url(__FILE__);

		add_action('init', function () {
			AdminController::init();
		});

		add_action('admin_enqueue_scripts', [__CLASS__, 'registerAssets']);
	}

	public static function registerAssets() {
		wp_register_style('gs-styles', self::$pluginURL . 'assets/css/styles.css', '',self::PLUGIN_VERSION);

		wp_enqueue_script('jquery');
		wp_register_script('gs-scripts', self::$pluginURL . 'assets/js/script.js', ['jquery'], self::PLUGIN_VERSION);
	}

}
require_once 'helpers/ViewsLoader.php';
require_once 'views/MetaboxView.php';
require_once 'classes/models/abstract/PostType.php';
require_once 'classes/models/Post.php';
require_once 'classes/controllers/AdminController.php';
new App();

