<?php
class PM_Upload {

	function initCurrUpload($key, $value) {
		list($t, $i) = explode('_', $key);
		$arr = array(
			'id'		=> intval($i),
			'attname'	=> $t,
			'name'		=> Char_cv($value['name']),
			'size'		=> intval($value['size']),
			'type'		=> 'zip',
			'fileuploadurl' => ''
		);
		$arr['ext'] = strtolower(substr(strrchr($arr['name'],'.'),1));
		return $arr;
	}

	function upload(&$bhv) {

		$uploaddb = array();

		foreach ($_FILES as $key => $value) {
			if (!PM_Upload::if_uploaded_file($value['tmp_name']) || !$bhv->allowType($key)) {
				continue;
			}
			$atc_attachment = $value['tmp_name'];
			$upload = PM_Upload::initCurrUpload($key, $value);

			if (empty($upload['ext']) || !isset($bhv->ftype[$upload['ext']])) {
				uploadmsg('upload_type_error');
			}
			if ($upload['size'] < 1 || $upload['size'] > $bhv->ftype[$upload['ext']]*1024) {
				$GLOBALS['atc_attachment_name'] = $upload['name'];
				$GLOBALS['oversize'] = $bhv->ftype[$upload['ext']];
				uploadmsg($upload['size'] < 1 ? 'upload_size_0' : 'upload_size_error');
			}
			list($filename, $savedir, $thumbname, $thumbdir) = $bhv->getFilePath($upload);
			$upload['fileuploadurl'] = $savedir . $filename;

			$source   = PM_Upload::savePath($bhv->ifftp, $filename, $savedir);

			if (!PM_Upload::postupload($atc_attachment, $source)) {
				uploadmsg('upload_error');
			}
			$upload['size'] = ceil(filesize($source)/1024);

			if (in_array($upload['ext'], array('gif','jpg','jpeg','png','bmp','swf'))) {
				require_once(R_P.'require/imgfunc.php');
				if (!$img_size = GetImgSize($source, $upload['ext'])) {
					P_unlink($source);
					uploadmsg('upload_content_error');
				}
			} elseif ($upload['ext'] == 'txt') {
				if (preg_match('/(onload|submit|post|form)/i', readover($source))) {
					__unlink($source);
					uploadmsg('upload_content_error');
				}
				$upload['type'] = 'txt';
			}
			$uploaddb[] = $upload;
		}
		$bhv->update($uploaddb);
	}
	//static function
	function getUploadNum() {
		foreach ($_FILES as $key => $val) {
			if (!$val['tmp_name'] || $val['tmp_name'] == 'none') {
				unset($_FILES[$key]);
			}
		}
		return count($_FILES);
	}
	//static function
	function if_uploaded_file($tmp_name) {
		if (!$tmp_name || $tmp_name == 'none') {
			return false;
		} elseif (function_exists('is_uploaded_file') && !is_uploaded_file($tmp_name) && !is_uploaded_file(str_replace('\\\\', '\\', $tmp_name))) {
			return false;
		} else {
			return true;
		}
	}
	//static function
	function movetoftp($srcfile, $dstfile) {
		global $ftp;
		if (pwFtpNew($ftp, true) && $ftp->upload($srcfile, $dstfile)) {
			P_unlink($srcfile);
			return true;
		}
		return false;
	}
	//static function
	function movefile($srcfile, $dstfile) {
		PwUpload::createFolder(dirname($dstfile));
		if (rename($srcfile,$dstfile)) {
			@chmod($dstfile,0777);
			return true;
		} elseif (@copy($srcfile,$dstfile)) {
			@chmod($dstfile,0777);
			P_unlink($srcfile);
			return true;
		} elseif (is_readable($srcfile)) {
			writeover($dstfile,readover($srcfile));
			if (file_exists($dstfile)) {
				@chmod($dstfile,0777);
				P_unlink($srcfile);
				return true;
			}
		}
		return false;
	}
	//static function
	function postupload($tmp_name,$filename) {
		if (strpos($filename,'..') !== false || strpos($filename,'.php.') !== false || eregi("\.php$",$filename)) {
			exit('illegal file type!');
		}
		PwUpload::createFolder(dirname($filename));
		if (function_exists("move_uploaded_file") && @move_uploaded_file($tmp_name,$filename)) {
			@chmod($filename,0777);
			return true;
		} elseif (@copy($tmp_name, $filename)) {
			@chmod($filename,0777);
			return true;
		} elseif (is_readable($tmp_name)) {
			writeover($filename,readover($tmp_name));
			if (file_exists($filename)) {
				@chmod($filename,0777);
				return true;
			}
		}
		return false;
	}
	//static function
	function createFolder($path) {
		if (!is_dir($path)) {
			PwUpload::createFolder(dirname($path));
			@mkdir($path);
			@chmod($path,0777);
			@fclose(@fopen($path.'/index.html','w'));
			@chmod($path.'/index.html',0777);
		}
	}
	//static function
	function savePath($ifftp, $filename, $dir, $thumb = '') {
		global $attachdir;
		if ($ifftp) {
			$thumb && $filename = $thumb . $filename;
			$source = D_P . "data/tmp/{$filename}";
		} else {
			$source = $attachdir . '/' . $dir . $filename;
		}
		return $source;
	}
}

class uploadBehavior {

	var $ftype;
	var $ifftp;

	function uploadBehavior() {
		global $db_ifftp;
		$this->ifftp =& $db_ifftp;
		$this->ftype = array();
	}

	function allowThumb() {
		return false;
	}

	function allowWaterMark() {
		return false;
	}

	function getThumbSize() {
		return '';
	}
	//abstruct
	function allowType($key) {}
	//abstruct
	function getFilePath($currUpload) {}
	//abstruct
	function update($uploaddb){}
}

function uploadmsg($msg) {
	Showmsg($msg);
}
?>