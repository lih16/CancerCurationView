<?php 
namespace Lib;

class Language {
	
	public static $locale = null;
	public static $available_locales = null;
	
	public static $config = array();
	
	private static $items = array();
	private static $javascript_items = array();

	public static function init() {
		global $config;

		Language::$available_locales = $config['available_locales'];

        if (isset($_GET['locale'])) {
            $locale = $_GET['locale'];
        } else {
            $locale = isset($_COOKIE['locale']) && $_COOKIE['locale'] != '' ? $_COOKIE['locale'] : DEFAULT_LOCALE;
        }

		if (!in_array($locale, Language::$available_locales)) {
			$locale = DEFAULT_LOCALE;
		}
        if (isset($_GET['locale'])) {
            setcookie("locale", $locale, time() + (86400 * 365), '/');
            header('Location: /');
            exit;
        };

		Language::$locale = $locale;

	}
	
	public static function ensure_language_data($area, $javascript = false) {

		if ($javascript && !isset(static::$javascript_items[$area]) ) {

			$path = LANG_PATH . static::$locale . DIRECTORY_SEPARATOR . 'javascript' . DIRECTORY_SEPARATOR . $area . '.php';
			$lang = null;
			require_once $path;
			static::$javascript_items[$area] = $lang;
		
		} elseif ( !isset(static::$items[$area]) ) {			
			$path = LANG_PATH . static::$locale . DIRECTORY_SEPARATOR . $area . '.php';
			$lang = null;
			require_once $path;
			static::$items[$area] = $lang;
		}
	}
	
	public static function item($area, $item) {	
		static::ensure_language_data($area);		
		$item = static::$items[$area][$item];
		return $item;		
	}

	
	public static function javascript_area($area) {	
		static::ensure_language_data($area, true);		
		$area = static::$javascript_items[$area];
		return $area; 
	}
}
?>