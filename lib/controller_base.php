<?php 
namespace Lib;

class Controller_base {

	public function __construct() {
		if (defined('DEBUG_SLOW_DOWN_AJAX') && $this->is_ajax_request()) {
			// microseconds 1 sec = 1000000 microsecond
			usleep(DEBUG_SLOW_DOWN_AJAX * 1000);
		}
	}
	
	public function set_no_cache($set_no_cache = true)
	{
		if (!$set_no_cache) {
			return;
		}
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache, must-revalidate");
	}

	public function set_javascript_content_type() {
		header('Content-Type: application/x-javascript; charset=UTF-8');		
	}
	
	public function set_json_content_type() {
		if (defined('DEBUG')) {
			header('Content-Type: application/x-javascript; charset=UTF-8');						
		} else {
			header('Content-Type: application/json');				
		}
	}
	
	public function is_ajax_request() {
	    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}	
	
	public function send_json($php_var, $set_no_cache = true) {
		$this->set_no_cache($set_no_cache);			
		$this->set_json_content_type();
		echo Json::encode($php_var);
	}
	
	public function send_javascript_var($var_name, $php_var, $add_var_text = true,$set_no_cache = true) {
		$this->set_no_cache($set_no_cache);			
		$this->set_javascript_content_type();			
		echo Json::get_var($var_name, $php_var, $add_var_text);
	}
	public function set_text_content_type() {
		if (defined('DEBUG')) {
			header('Content-Type: application/x-javascript; charset=UTF-8');						
		} else {
			header("Content-type: text/plain");				
		}
	}
	public function send_plaintext($php_var, $set_no_cache = true) {
		$this->set_no_cache($set_no_cache);			
		$this->set_text_content_type();
		echo $php_var;
	}
	
}