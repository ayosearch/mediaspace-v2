<?php
class PM_MessageDB extends BaseDB{
	//消息模块----------------------------------------------------------------------------------------------------
	function insertSysMessage($fieldsData){
		$fieldsData = $this->_checkSysMessageData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysmsglog SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysMessage($id,$updateData){
		$updateData = $this->_checkSysMessageData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysmsglog SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysMessage($id){
		$this->_db_adspace->update("DELETE pm_sysmsglog WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysMessageBatch($ids){
		$this->_db_adspace->update("DELETE pm_sysmsglog WHERE id in (". $ids .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function getSysMessage($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysmsglog WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysMessageAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysmsglog ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysMessagePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysmsglog";
		if($stwhere!=null)
			$sql = $sql." WHERE ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysMessageTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysmsglog";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysMessageStruct() {
		return array('platform','rec_id','create_time','send_type','is_read','title','content','is_del');
	}
	
	function _checkSysMessageData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysMessageStruct());
		return $data;
	}
	
	//消息模版----------------------------------------------------------------------------------------------------
	function insertSysMsgtpl($fieldsData){
		$fieldsData = $this->_checkSysMsgtplData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysmsgtpl SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysMsgtpl($id,$updateData){
		$updateData = $this->_checkSysMsgtplData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysmsgtpl SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysMsgtpl($id){
		$this->_db_adspace->update("DELETE FROM pm_sysmsgtpl WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysMsgtplBatch($ids){
		$this->_db_adspace->update("DELETE FROM pm_sysmsgtpl WHERE id in (". $ids .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function getSysMsgtpl($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysmsgtpl WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysMsgtplAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysmsgtpl ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysMsgtplPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysmsgtpl ";
		if($stwhere!=null)
			$sql = $sql." WHERE ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysMsgtplTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysmsgtpl ";
		if($stwhere!=null)
			$sql = "$sql WHERE $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysMsgtplStruct() {
		return array('platform','create_time','send_type','name','subject','content','tag');
	}
	
	function _checkSysMsgtplData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysMsgtplStruct());
		return $data;
	}	
	
	//消息设置----------------------------------------------------------------------------------------------------
	function insertSysMsgset($fieldsData){
		$fieldsData = $this->_checkSysMsgsetData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysmsgset SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysMsgset($id,$updateData){
		$updateData = $this->_checkSysMsgsetData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysmsgset SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysMsgset($id){
		$this->_db_adspace->update("DELETE FROM pm_sysmsgset WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysMsgsetBatch($ids){
		$this->_db_adspace->update("DELETE FROM pm_sysmsgset WHERE id in (". $ids .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function getSysMsgset($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysmsgset WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysMsgsetAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysmsgset ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysMsgsetPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysmsgset";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysMsgsetTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysmsgset";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysMsgsetStruct() {
		return array('platform','is_all','create_time','send_time','rec_id','rec_user','send_type','msgtype','title','content','send_aim','sys_id','sys_name');
	}
	
	function _checkSysMsgsetData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysMsgsetStruct());
		return $data;
	}		
}
?>