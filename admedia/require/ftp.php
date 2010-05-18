<?php
function ftpNew(&$ftp,$ifftp) {
	if (!$ifftp) return false;
	static $ftp_server,$ftp_port,$ftp_user,$ftp_pass,$ftp_dir;
	if (!is_object($ftp)) {
		require_once(S_P.'lib/ftp.class.php');
		$ftp = new FTP($ftp_server,$ftp_port,$ftp_user,$ftp_pass,$ftp_dir);
	}
	return true;
}
function ftpClose(&$ftp) {
	if (is_object($ftp) && method_exists($ftp,'close')) {
		$ftp->close();
		$ftp = null;
	}
}
?>