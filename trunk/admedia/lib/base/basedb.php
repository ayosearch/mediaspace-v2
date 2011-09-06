<?php

class BaseDB {
	var $_db_adspace = null;
	var $_db_prices = null;

	function BaseDB() {
		$this->_db_adspace = $GLOBALS['db_adspace'];
		$this->_db_prices = $GLOBALS['db_prices'];
	}

	function _getAdSpaceConnection() {
		//global
		return $GLOBALS['_db_adspace'];
	}
	
	function _getPricesConneciton(){
		return $GLOBALS['db_prices'];
	}

	function _getUpdateSqlString($arr) {
		//global
		return sqlSingle($arr);
	}

	function _getAllResultFromQuery($query,$db) {
		$result = array ();
		while ( $rt = $db->fetch_array ( $query ) ) {
			$result [] = $rt;
		}
		return $result;
	}

	function _checkAllowField($fieldData,$allowFields) {
		foreach ($fieldData as $key=>$value) {
			if (!in_array($key,$allowFields)) {
				unset($fieldData[$key]);
			}
		}
		return $fieldData;
	}

	function _addSlashes($var) {
		//global
		return sqlEscape($var);
	}

	function _getImplodeString($string,$strip=true) {
		return arrayImplode($string,$strip);
	}

	function _serialize($value) {
		if (!is_string($value) && !is_numeric($value)) {
			$value = serialize($value);
		}
		return $value;
	}

	function _unserialize($value) {
		if ($value && is_array($tmpValue = unserialize($value))) {
			$value = $tmpValue;
		}
		return $value;
	}
}

?>