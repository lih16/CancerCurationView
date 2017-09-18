<?php
namespace Lib;

class View {
	
	public static function get_view_contents($view, $data = array()) {
        global $config;
		$view = Router::secure_path($view);
		
		foreach($data as $key => $value) {
			$$key = $value;
		}
		$path = VIEW_PATH . $view . '.php';
		if (!is_file($path)) {
			Router::not_found();
			return;
		}
		ob_start();
		include($path);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	public static function render($view, $data = array()) {
        global $config;
		$view = Router::secure_path($view);
		
		foreach($data as $key => $value) {
			$$key = $value;
		}
		$path = VIEW_PATH . $view . '.php';
		if (!is_file($path)) {
			Router::not_found();
			return;
		}
		ob_start();
		include($path);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	public static function layout($view, array $data = array(), $layout = null) {
		if ($view != null) {
			$view_content = View::get_view_contents($view, $data);
			$data['content'] = $view_content;
		}
		$layout = $layout == null ? DEFAULT_LAYOUT : $layout;
		$layout_content = View::get_view_contents($layout, $data);
		print $layout_content;
	}
}
