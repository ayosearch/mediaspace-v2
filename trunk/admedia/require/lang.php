<?php

/**
 * 获取指定语言包里的某一内容信息
 *
 * @param string $T 语言包文件名
 * @param string $I 指定语言信息
 * @return string
 */
function getLangInfo($T,$I,$type='admin') {
	static $lang;
	if (!isset($lang[$T])) {
		require pathCheck(GetLang($T,$type));
	}
	if (isset($lang[$T][$I])) {
		eval('$I="'.addcslashes($lang[$T][$I],'"').'";');
	}
	return $I;
}

function GetLang($lang,$type='admin',$EXT='php'){
	if (file_exists(R_P."template/$type/lang_$lang.$EXT")) {
		return R_P."template/$type/lang_$lang.$EXT";
	} else {
		exit("Can not find $lang.$EXT file");
	}
}

function modeEot($template,$type='admin',$EXT='htm'){
	$srcTpl = R_P."template/$type/$template.$EXT";
	$tarTpl = R_P."data/tplcache/$type/$template.$EXT";
	
	if (!file_exists($srcTpl)) {
		return false;
	}
	if (fileTime($tarTpl)>fileTime($srcTpl)) {
		return $tarTpl;
	} else {
		return modeLang($template,$srcTpl,$tarTpl);
	}
}

function modeLang($tplname,$srcTpl,$tarTpl){
	$file_str	= readOver($srcTpl);
	$parseam	= LOAD::loadClass('parseam');
	$file_str	= $parseam->execute($tplname,$file_str);
	writeOver($tarTpl,$file_str);
	return $tarTpl;
}
?>