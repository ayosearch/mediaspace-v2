<?php
class PM_DataLogDB extends BaseDB{
	function createShowLog($adv_id){
		$sqlX = "CREATE TABLE log_show_".$adv_id."_X (
						  id bigint(30) unsigned NOT NULL AUTO_INCREMENT,
						  aff_id int(10) unsigned NOT NULL DEFAULT '0',
						  adv_id int(10) unsigned NOT NULL DEFAULT '0',
						  site_id int(10) unsigned NOT NULL DEFAULT '0',
						  place_id int(10) unsigned NOT NULL DEFAULT '0',
						  creative_id int(10) unsigned NOT NULL DEFAULT '0',
						  ip varchar(20) NOT NULL DEFAULT '',
						  real_locas varchar(200) NOT NULL DEFAULT '',
						  uv_id varchar(100) NOT NULL DEFAULT '',
						  referer varchar(1000) NOT NULL DEFAULT '',
						  page_path varchar(255) NOT NULL DEFAULT '',
						  from_site varchar(255) NOT NULL DEFAULT '',
						  mobile varchar(20) NOT NULL DEFAULT '',
						  ua varchar(500) NOT NULL DEFAULT '',
						  search_key varchar(100) NOT NULL DEFAULT '',
						  create_time int(10) unsigned NOT NULL DEFAULT '0',
						  ad_url varchar(255) NOT NULL DEFAULT '',
						  PRIMARY KEY (id),
						  KEY idx_click (aff_id,site_id,place_id,adv_id,creative_id)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		
		$sqlY = "CREATE TABLE log_show_".$adv_id."_Y (
						  id bigint(30) unsigned NOT NULL AUTO_INCREMENT,
						  aff_id int(10) unsigned NOT NULL DEFAULT '0',
						  adv_id int(10) unsigned NOT NULL DEFAULT '0',
						  site_id int(10) unsigned NOT NULL DEFAULT '0',
						  place_id int(10) unsigned NOT NULL DEFAULT '0',
						  creative_id int(10) unsigned NOT NULL DEFAULT '0',
						  ip varchar(20) NOT NULL DEFAULT '',
						  real_locas varchar(200) NOT NULL DEFAULT '',
						  uv_id varchar(100) NOT NULL DEFAULT '',
						  referer varchar(1000) NOT NULL DEFAULT '',
						  page_path varchar(255) NOT NULL DEFAULT '',
						  from_site varchar(255) NOT NULL DEFAULT '',
						  mobile varchar(20) NOT NULL DEFAULT '',
						  ua varchar(500) NOT NULL DEFAULT '',
						  search_key varchar(100) NOT NULL DEFAULT '',
						  create_time int(10) unsigned NOT NULL DEFAULT '0',
						  ad_url varchar(255) NOT NULL DEFAULT '',
						  PRIMARY KEY (id),
						  KEY idx_click (aff_id,site_id,place_id,adv_id,creative_id)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		
		$result = $this->_db_adspace->query($sqlX);
		if($result){
			if($this->_db_adspace->query($sqlY))
				return true;		
		}
		return false;
	}
	
	function createClickLog($adv_id){
		$sqlX = "CREATE TABLE log_click_".$adv_id."_X (
						  id bigint(30) unsigned NOT NULL AUTO_INCREMENT,
						  aff_id int(10) unsigned NOT NULL DEFAULT '0',
						  site_id int(10) unsigned NOT NULL DEFAULT '0',
						  place_id int(10) unsigned NOT NULL DEFAULT '0',
						  adv_id int(10) unsigned NOT NULL DEFAULT '0',
						  creative_id int(10) unsigned NOT NULL DEFAULT '0',
						  ip varchar(20) NOT NULL DEFAULT '',
						  real_locas varchar(20) NOT NULL DEFAULT '',
						  uv_id varchar(100) NOT NULL DEFAULT '',
						  referer varchar(1000) NOT NULL DEFAULT '',
						  page_path varchar(255) NOT NULL DEFAULT '',
						  from_site varchar(255) NOT NULL DEFAULT '',
						  search_key varchar(100) NOT NULL DEFAULT '',
						  mobile varchar(20) NOT NULL DEFAULT '',
						  ua varchar(500) NOT NULL DEFAULT '',
						  create_time int(10) unsigned NOT NULL DEFAULT '0',
						  ad_url varchar(255) NOT NULL DEFAULT '',
						  show_id varchar(40) NOT NULL DEFAULT '0',
						  PRIMARY KEY (id),
						  KEY idx_click (aff_id,site_id,place_id,adv_id,creative_id)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		
		$sqlY = "CREATE TABLE log_click_".$adv_id."_Y (
						  id bigint(30) unsigned NOT NULL AUTO_INCREMENT,
						  aff_id int(10) unsigned NOT NULL DEFAULT '0',
						  site_id int(10) unsigned NOT NULL DEFAULT '0',
						  place_id int(10) unsigned NOT NULL DEFAULT '0',
						  adv_id int(10) unsigned NOT NULL DEFAULT '0',
						  creative_id int(10) unsigned NOT NULL DEFAULT '0',
						  ip varchar(20) NOT NULL DEFAULT '',
						  real_locas varchar(20) NOT NULL DEFAULT '',
						  uv_id varchar(100) NOT NULL DEFAULT '',
						  referer varchar(1000) NOT NULL DEFAULT '',
						  page_path varchar(255) NOT NULL DEFAULT '',
						  from_site varchar(255) NOT NULL DEFAULT '',
						  search_key varchar(100) NOT NULL DEFAULT '',
						  mobile varchar(20) NOT NULL DEFAULT '',
						  ua varchar(500) NOT NULL DEFAULT '',
						  create_time int(10) unsigned NOT NULL DEFAULT '0',
						  ad_url varchar(255) NOT NULL DEFAULT '',
						  show_id varchar(40) NOT NULL DEFAULT '0',
						  PRIMARY KEY (id),
						  KEY idx_click (aff_id,site_id,place_id,adv_id,creative_id)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		
		$result = $this->_db_adspace->query($sqlX);
		if($result){
			if($this->_db_adspace->query($sqlY))
				return true;		
		}
		return false;
	}
	
	function insertShowLog($adv_id,$flag,$fieldsData){
		$fieldsData = $this->_checkShowLogData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO log_show_".$adv_id."_".$flag." SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db_adspace->update($sql);
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function getShowLogStruct() {
		return array('aff_id','adv_id','site_id','place_id','creative_id','ip','real_locas','uv_id','referer','page_path','from_site','mobile','ua','search_key','create_time','ad_url');
	}
	
	function _checkShowLogData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getShowLogStruct());
		return $data;
	}
	
	function insertClickLog($adv_id,$flag,$fieldsData){
		$fieldsData = $this->_checkClickLogData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO log_click_".$adv_id."_".$flag." SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db_adspace->update($sql);
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function getClickLogStruct() {
		return array('aff_id','adv_id','site_id','place_id','creative_id','ip','real_locus','uv_id','referer','page_path','from_site','serarch_key','mobile','ua','create_time','ad_url','show_id');
	}
	
	function _checkClickLogData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getClickLogStruct());
		return $data;
	}
	
	function getShowLogPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM log_show";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getShowLogTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM log_show";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getClickLogPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM log_click";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getClickLogTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM log_click";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}

	function getEffectLogPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM log_effectlog";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getEffectLogTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM log_effectlog";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getEffectSubPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM log_effectsub";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getEffectSubTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM log_effectsub";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
}
?>