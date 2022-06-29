<?php

namespace GutenbergSidebar\helpers;


use GutenbergSidebar\App;

class ViewsLoader {
	public static function load($filename, $data = array()) {
		$args = $data;
		unset($data);
		ob_start();
		extract($args, EXTR_SKIP);
		$file = App::PLUGIN_DIR . '/views/' . $filename;
		if(file_exists($file)) {
			include $file;
		}
		else {
			throw new \Exception('File ' . $file . ' not found');
		}
		return ob_get_clean();
	}
}