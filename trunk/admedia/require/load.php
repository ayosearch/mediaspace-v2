<?php 
/**
 * 加载类(包括通用类和通用配置文件的加载)
 */
class LOAD {
	function loadClass($className,$dir ='db',$check=false) {
		static $classes = array();
		$suffix = '.class.php';
		if ($dir) {
			$dir = strtolower(trim($dir));
			if ($dir == 'db') {
				if (!class_exists('BaseDB')) require(R_P.'lib/base/basedb.php');
				$fileDir = pathCheck(R_P.'lib/'.$dir.'/'.strtolower($className).'.db.php');
				$className .= 'DB';
			} else {
				$fileDir = pathCheck(R_P.'lib/'.$dir.'/'.strtolower($className).$suffix);
			}
		} else {
			$fileDir = pathCheck(R_P.'lib/'.strtolower($className).$suffix);
		}
		if (isset($classes[$className])) {
			return $classes[$className];
		} elseif ($check == true) {
			return false;
		}
		if (file_exists($fileDir)) {
			$class = 'PM_'.$className;
			if(!class_exists($class)) 
				require $fileDir;
			$classes[$className] = &new $class();
		} else {
			showMsg('load_class_error');
		}
		return $classes[$className];
	}

	function loadDB($dbName) {
		return LOAD::loadClass($dbName,'db');
	}

	function config($var = null, $file = 'config', $dir = 'bbscache', $isStatic = true) {
		static $conf = array();
		if (!isset($conf[$file])) {
			if (file_exists(D_P . "data/$dir/{$file}.php")) {
				include checkPurview(R_P . "data/$dir/{$file}.php");
				$arr = get_defined_vars();
				unset($arr['dir'], $arr['file'], $arr['var'], $arr['conf'], $arr['isStatic']);
				if ($isStatic !== true) {
					return $var ? $arr[$var] : $arr;
				}
				$conf[$file] = $arr;
			} else {
				$conf[$file] = array();
			}
		}
		return $var ? $conf[$file][$var] : $conf[$file];
	}
}
?>