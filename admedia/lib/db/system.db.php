<?php
class PM_SystemDB extends BaseDB{
	//系统基础表----------------------------------------------------------------------------------------------------
	function insertSystem($fieldsData){
		$fieldsData = $this->_checkSystemData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO pm_sysconfig SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db_adspace->update($sql);
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function checkSystem($key){
		$sql = "select count(key_name) as count from pm_sysconfig where key_name=".sqlEscape($key);
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function updateSystem($key,$val){
		$this->_db_adspace->update("UPDATE pm_sysconfig SET key_value=" . sqlEscape($val) . " WHERE key_name=". sqlEscape($key) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSystem($key){
		$this->_db_adspace->update("DELETE FROM pm_sysconfig WHERE key_value=". sqlEscape($key) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSystem($key){
		$sql = "SELECT * FROM pm_sysconfig WHERE key_name=".sqlEscape($key)." limit 1";
		$data = $this->_db_adspace->get_one($sql);
		if (!$data) return null;
		return $data;
	}
	
	function getSystemAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysconfig");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSystemStruct() {
		return array('key_name','key_value');
	}
	
	function _checkSystemData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSystemStruct());
		return $data;
	}
	
	//系统公告表----------------------------------------------------------------------------------------------------
	function insertSysNews($fieldsData){
		$fieldsData = $this->_checkSysNewsData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysnews SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysNews($id,$updateData){
		$updateData = $this->_checkSysNewsData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysnews SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateSysNewsStatus($id,$status){
		$this->_db_adspace->update("UPDATE pm_sysnews SET status=" . sqlEscape($status) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}	
	
	function deleteSysNewsBatch($ids){
		$this->_db_adspace->update("DELETE FROM pm_sysnews WHERE id in (". $ids .")");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysNews($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysnews WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysNewsPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysnews";
		if($stwhere!=null && empty($stwhere)==false)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysNewsTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysnews";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysNewsStruct() {
		return array('title','create_time','content','user_id','user_name','audit_id','audit_name','audit_time','status','is_top','is_red','itype');
	}
	
	function _checkSysNewsData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysNewsStruct());
		return $data;
	}
		
	
	//系统黑名单模块----------------------------------------------------------------------------------------------------
	function insertSysBlackList($fieldsData){
		$fieldsData = $this->_checkSysBlackListData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysblacklist SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysBlackList($id,$updateData){
		$updateData = $this->_checkSysBlackListData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysblacklist SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysBlackList($id){
		$this->_db_adspace->update("DELETE FROM pm_sysblacklist WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysBlackList($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysblacklist WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysBlackPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysblacklist";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysBlackTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysblacklist";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysBlackListStruct() {
		return array('platform','user_id','user_name','lock_time','memo','status','release_id','release_user','release_time','lock_id','lock_user');
	}
	
	function _checkSysBlackListData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysBlackListStruct());
		return $data;
	}	
	
	//系统帮助----------------------------------------------------------------------------------------------------
	function insertSysHelp($fieldsData){
		$fieldsData = $this->_checkSysHelpData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_syshelp SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysHelp($id,$updateData){
		$updateData = $this->_checkSysHelpData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_syshelp SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysHelpBatch($ids){
		$sql = "DELETE FROM pm_syshelp WHERE id in (". $ids .")";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysHelp($id){
		$this->_db_adspace->update("DELETE FROM pm_syshelp WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}	
	
	function getSysHelp($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_syshelp WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}	
	
	function getSysHelpPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_syshelp ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysHelpTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_syshelp";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysHelpStruct() {
		return array('platform','module','itype','title','content','tags','hit_count','create_time');
	}
	
	function _checkSysHelpData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysHelpStruct());
		return $data;
	}
	
	//系统帮助模块功能----------------------------------------------------------------------------------------------------
	function insertSysHelpModule($fieldsData){
		$fieldsData = $this->_checkSysHelpModuleData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_syshelpmodule SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysHelpModule($id,$updateData){
		$updateData = $this->_checkSysHelpModuleData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_syshelpmodule SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysHelpModule($id){
		$this->_db_adspace->update("DELETE FROM pm_syshelpmodule WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysHelpModule($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_syshelpmodule WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysHelpModulePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_syshelpmodule";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysHelpModuleTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_syshelpmodule";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysHelpModuleStruct() {
		return array('platform','name','memo');
	}
	
	function _checkSysHelpModuleData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysHelpModuleStruct());
		return $data;
	}	
	
	//系统密码找回问题----------------------------------------------------------------------------------------------------
	function insertSysQuestion($fieldsData){
		$fieldsData = $this->_checkSysQuestionData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysquestion SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysQuestion($id,$updateData){
		$updateData = $this->_checkSysQuestionData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysquestion SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysQuestion($id){
		$this->_db_adspace->update("DELETE FROM pm_sysquestion WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysQuestion($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysquestion WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysQuestionPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysquestion";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysQuestionTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysquestion";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getSysQuestionStruct() {
		return array('id','platform','question','is_del');
	}
	
	function _checkSysQuestionData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysQuestionStruct());
		return $data;
	}
	
	//WAP网关IP列表
	function insertSysWapIp($fieldsData){
		$fieldsData = $this->_checkSysIpAccessData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_syswapip SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysWapIp($id,$updateData){
		$updateData = $this->_checkSysIpAccessData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_syswapip SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysWapIp($id){
		$this->_db_adspace->update("DELETE FROM pm_syswapip WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysWapIp($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_syswapip WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysWapIpPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_syswapip";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysWapIpTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_syswapip";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
	
	function getSysWapIpStruct() {
		return array('network','ip','province','carrier','gateway','city');
	}
	
	function _checkSysWapIpData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysWapIpStruct());
		return $data;
	}		

	//系统登陆IP限定----------------------------------------------------------------------------------------------------
	function insertSysIpAccess($fieldsData){
		$fieldsData = $this->_checkSysIpAccessData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysipaccess SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysIpAccess($id,$updateData){
		$updateData = $this->_checkSysIpAccessData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysipaccess SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysIpAccess($id){
		$this->_db_adspace->update("DELETE FROM pm_sysipaccess WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysIpAccess($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysipaccess WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysIpAccessPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysipaccess";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysIpAccessTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysipaccess";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
	
	function getSysIpAccessStruct() {
		return array('id','ip','create_time');
	}
	
	function _checkSysIpAccessData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysIpAccessStruct());
		return $data;
	}		
	
	//系统审批记录----------------------------------------------------------------------------------------------------
	function insertSysAudit($fieldsData){
		$fieldsData = $this->_checkSysAuditData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO pm_sysaudit SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db_adspace->update($sql);
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysAudit($id,$updateData){
		$updateData = $this->_checkSysAuditData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysaudit SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysAudit($id){
		$this->_db_adspace->update("DELETE FROM pm_sysaudit WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysAudit($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysaudit WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysAuditAll($target_id,$itype){
		$sql = "select * from pm_sysaudit where itype=".$itype." and CONCAT(target_ids,',') like '%".$target_id.",%'";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);			
	}
	
	function getSysAuditPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysaudit";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysAuditTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysaudit";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
	
	function getSysAuditStruct() {
		//itype=0 站长审批 itype=1 网站审核 itype=2 广告申请 itype=3 广告主审批 itype=4 广告计划审批
		return array('content','target_ids','itype','parent_id','level','audit_id','audit_name','auditstatus','create_time');
	}
	
	function _checkSysAuditData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysAuditStruct());
		return $data;
	}		
}
?>