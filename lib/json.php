<?php
namespace Lib;

class Json {

	// indents a json string so it is more human readable
	public static function indent($json) {
		
		$result = '';
		$pos = 0;
		$strLen = strlen ( $json );
		$indentStr = '  ';
		$newLine = "\n";
		$prevChar = '';
		$outOfQuotes = true;
		
		for($i = 0; $i <= $strLen; $i ++) {
			
			// Grab the next character in the string.
			$char = substr ( $json, $i, 1 );
			
			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = ! $outOfQuotes;
			
		// If this character is the end of an element, 
			// output a new line and indent the next line.
			} else if (($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos --;
				for($j = 0; $j < $pos; $j ++) {
					$result .= $indentStr;
				}
			}
			
			// Add the character to the result string.
			$result .= $char;
			
			// If the last character was the beginning of an element, 
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}
				
				for($j = 0; $j < $pos; $j ++) {
					$result .= $indentStr;
				}
			}
			
			$prevChar = $char;
		}
		
		return $result;
	}
	
	// encodes and indents a json string
	public static function encode($json) {
		return Json::indent(
			 json_encode( $json )
		);
	}
	
	public static function decode($json) {
		return json_decode($json, true);
	}
	
	public static function get_var($var_name, $o, $add_var_text = true) {
		if ($add_var_text) {
			echo 'var ';
		}
		echo $var_name . ' = ' . Json::encode($o) . ';';
	}
}