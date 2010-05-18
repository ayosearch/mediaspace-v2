<?php
/**
 * 将数组格式化成json格式
 *
 * @param  $type
 * @return string
 */
function formatArrayToJson($var){
	 switch (gettype($var)) {
		case 'boolean':
			return $var ? 'true' : 'false';
		case 'NULL':
			return 'null';
		case 'integer':
			return (int) $var;
		case 'double':
		case 'float':
			return (float) $var;
		case 'string':
			return '"'.addslashes(str_replace(array("\n","\r","\t"),'',$var)).'"';
		case 'array':
			if (count($var) && (array_keys($var) !== range(0, sizeof($var) - 1))) {
				$properties = array();
				foreach ($var as $name=>$value) {
					$properties[] = pmJsonEncode(strval($name)) . ':' . pmJsonEncode($value);
				}
				return '{' . join(',', $properties) . '}';
			}
			$elements = array_map('pmJsonEncode', $var);
			return '[' . join(',', $elements) . ']';
	 }
	 return false;
}


function ajax_footer(){
	global $db_charset;
	$output = str_replace(array('<!--<!---->','<!---->'),'',ob_get_contents());
	header("Content-Type: text/xml;charset=$db_charset");
	echo ObContents("<?xml version=\"1.0\" encoding=\"$db_charset\"?><ajax><![CDATA[".$output."]]></ajax>");exit;
}

?>