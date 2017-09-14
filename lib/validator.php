<?php 
namespace Lib;

use DateTime;

class Validator {
	
	public static function is_international_phone($in) {
		//+22 333 333 4444 x666666		
		$pattern = '/^\+\d\d? ?\d{1,3} ?\d{1,3} ?\d{1,4}( ?x\d{1,6})?$/';
			
		return filter_var($in, FILTER_VALIDATE_REGEXP, array( 
			'options' => array(
				'regexp' => $pattern
			)
		));	
	}
	
	public static function is_date($in) {
		return DateTime::createFromFormat(DATE_FORMAT_PHP, $in) !== FALSE;
	}
	
	public static function is_email($in) {
		return filter_var($in, FILTER_VALIDATE_EMAIL);		
	}
	
	
}