<?php
class PM_CommonDataDB extends BaseDB{
	
	//大区----------------------------------------------------------------------------------------------------
	function insertBaseArea($fieldsData){
		$fieldsData = $this->_checkBaseAreaData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_basearea SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseArea($id,$updateData){
		$updateData = $this->_checkBaseAreaData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_basearea SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseArea($id){
		$this->_db_adspace->update("UPDATE pm_basearea set is_del=1 WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function checkBaseArea($name){
		$sql = "select * from pm_basearea where name='$name'";
		$data = $this->_db_adspace->get_one($sql);
		if (!$data) return false;
		return true;
	}
	
	function getBaseAreaAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_basearea where is_del=0");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getBaseArea($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_basearea WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getBaseAreaPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_basearea where is_del=0";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getBaseAreaTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_basearea where is_del=0";
		if($stwhere!=null)
			$sql = "$sql and $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getBaseAreaStruct() {
		return array('id','name','is_del');
	}
	
	function _checkBaseAreaData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseAreaStruct());
		return $data;
	}		

	//省份--------------------------------------------------------------------------------------------------------	
	function insertBaseProvince($fieldsData){
		$fieldsData = $this->_checkBaseProvinceData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_baseprovince SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseProvince($id,$updateData){
		$updateData = $this->_checkBaseProvinceData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_baseprovince SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseProvince($id){
		$this->_db_adspace->update("UPDATE pm_baseprovince set is_del=1 WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseProvince($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_baseprovince WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getBaseProvinceAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_baseprovince where is_del=0");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getBaseProvinceAllByArea($areaid){
		$query = $this->_db_adspace->query("SELECT * FROM pm_baseprovince where area_id=".intval($areaid)." and is_del=0");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getBaseProvincePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.name as area_name FROM pm_baseprovince a,pm_basearea b where a.area_id=b.id and a.is_del=0";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getBaseProvinceTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_baseprovince where is_del=0";
		if($stwhere!=null)
			$sql = "$sql and $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getBaseProvinceStruct(){
		return array('area_id','name','is_del');
	}
	
	function _checkBaseProvinceData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseProvinceStruct());
		return $data;
	}		
	
	//城市--------------------------------------------------------------------------------------------------------
	function insertBaseCity($fieldsData){
		$fieldsData = $this->_checkBaseCityData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_basecity SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseCity($id,$updateData){
		$updateData = $this->_checkBaseCityData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_basecity SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseCity($id){
		$this->_db_adspace->update("DELETE FROM pm_basecity WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseCityAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_basecity");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getBaseCityAllByProvince($province_id){
		$query = $this->_db_adspace->query("SELECT * FROM pm_basecity where province_id=".intval($province_id));
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}		
	
	function getBaseCity($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_basecity WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}	
	
	function getBaseCityPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.name as province_name FROM pm_basecity a ,pm_baseprovince b where a.province_id=b.id ";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getBaseCityTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_basecity";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getBaseCityStruct(){
		return array('province_id','name','zip','code');
	}
	
	function _checkBaseCityData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseCityStruct());
		return $data;
	}
	
	//代理IP--------------------------------------------------------------------------------------------------------
	function insertBaseAgentIp($fieldsData){
		$fieldsData = $this->_checkBaseAgentIpData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_baseagentip SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseAgentIp($id,$updateData){
		$updateData = $this->_checkBaseAgentIpData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_baseagentip SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseAgentIp($id){
		$this->_db_adspace->update("DELETE FROM pm_baseagentip WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseAgentIp($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_baseagentip WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}	
	
	function getBaseAgentIpPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_baseagentip ORDER BY id LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}		
	
	function getBaseAgentIpStruct(){
		return array('ip','type');
	}
	
	function _checkBaseAgentIpData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseAgentIpStruct());
		return $data;
	}	
	
	//广告基本尺寸--------------------------------------------------------------------------------------------------------
	function insertBaseAdvSize($fieldsData){
		$fieldsData = $this->_checkBaseAdvSizeData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_baseadvsize SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseAdvSize($id,$updateData){
		$updateData = $this->_checkBaseAdvSizeData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_baseadvsize SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseAdvSize($id){
		$this->_db_adspace->update("DELETE FROM pm_baseadvsize WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseAdvSize($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_baseadvsize WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getBaseAdvSizeAll(){
		$sql = "SELECT * FROM pm_baseadvsize";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getBaseAdvSizePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_baseadvsize ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getBaseAdvSizeTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_baseadvsize";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
	
	function getBaseAdvSizeStruct(){
		return array('width','height','memo');
	}
	
	function _checkBaseAdvSizeData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseAdvSizeStruct());
		return $data;
	}		
	
	//广告基本类型--------------------------------------------------------------------------------------------------------
	function insertBaseAdvFormat($fieldsData){
		$fieldsData = $this->_checkBaseAdvFormatData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_baseadvformat SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseAdvFormat($id,$updateData){
		$updateData = $this->_checkBaseAdvFormatData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_baseadvformat SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseAdvFormat($id){
		$this->_db_adspace->update("DELETE FROM pm_baseadvformat WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseAdvFormatAll(){
		$sql = "select * from pm_baseadvformat";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getBaseAdvFormat($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_baseadvformat WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}	
	
	function getBaseAdvFormatPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_baseadvformat ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getBaseAdvFormatTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_baseadvformat";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
	
	function getBaseAdvFormatStruct(){
		return array('format','memo');
	}
	
	function _checkBaseAdvFormatData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseAdvTypeStruct());
		return $data;
	}			
	
	//基本IP库--------------------------------------------------------------------------------------------------------
	function insertBaseIp($fieldsData){
		$fieldsData = $this->_checkBaseIpData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_baseip SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseIp($id,$updateData){
		$updateData = $this->_checkBaseIpData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_baseip SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseIp($id){
		$this->_db_adspace->update("DELETE FROM pm_baseip WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseIp($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_baseip WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}	
	
	function getBaseIpPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_baseip ORDER BY id desc LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}		
	
	function getBaseIpStruct(){
		return array('start_ip','end_ip','province','city','post_code');
	}
	
	function _checkBaseIpData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseIpStruct());
		return $data;
	}
	
	//基本分类配置库--------------------------------------------------------------------------------------------------------
	function insertBaseSort($fieldsData){
		$fieldsData = $this->_checkBaseSortData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_basesort SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBaseSort($id,$updateData){
		$updateData = $this->_checkBaseSortData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_basesort SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBaseSort($id,$itype){
		$this->_db_adspace->update("DELETE FROM pm_basesort WHERE id=". intval($id) ." and ikey='$itype' LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getBaseSort($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_basesort WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getBaseSortKeyList($ikey){
		$sql = "SELECT * FROM pm_basesort WHERE ikey='$ikey'";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getBaseSortPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_basesort ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getBaseSortTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_basesort";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getBaseSortStruct(){
		return array('ikey','val');
	}
	
	function _checkBaseSortData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getBaseSortStruct());
		return $data;
	}	
	
}
?>