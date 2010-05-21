<?php 
class PM_AdvertiseDB extends BaseDB{
	//广告计划----------------------------------------------------------------------------------------------------
	function insertAdvertise($fieldsData){
		$fieldsData = $this->_checkAdvertiseData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO pm_advertise SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db->update($sql);
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvertise($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$sql = "UPDATE pm_advertise SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1";
		$this->_db->update($sql);
		return $this->_db->affected_rows();
	}
	
	function updateAdvertiseAudit($id,$sysaudit_id=0,$audit){
		global $timestamp;
		if($sysaudit_id==0)
			$sql = "update pm_advertise set audit=".intval($audit).",audit_time=$timestamp where id in (".$id.")";
		else
			$sql = "update pm_advertise set audit=".intval($audit).",audit_time=$timestamp, sysaudit_id=".intval($sysaudit_id)." where id in (".$id.")";
		$this->_db->update($sql);
		return $this->_db->affected_rows();
	}
	
	function updateAdvertiseStatus($id,$status){
		$sql = "update pm_advertise set status=".intval($status)." where id in (".$id.")";
		$this->_db->update($sql);
		return $this->_db->affected_rows();
	}
	
	function updateAdvertiseShow($curid){
		$sql = "update pm_advertise set log_v_created=1 where id=".intval($curid);
		$this->_db->update($sql);
		return $this->_db->affected_rows();
	}
	
	function updateAdvertiseClick($curid){
		$sql = "update pm_advertise set log_c_created=1 where id=".intval($curid);
		$this->_db->update($sql);
		return $this->_db->affected_rows();
	}
	
	function deleteAdvertise($id){
		$this->_db->update("DELETE FROM pm_advertise WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvertise($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advertise WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvertiseStatusList($status){
		$sql = "SELECT * FROM pm_advertise where status=".intval($status);
		$query = $this->_db->query($sql);
		return $this->_getAllResultFromQuery($query);	
	}
	
	function getAdvertiseAll(){
		$sql = "SELECT * FROM pm_advertise";
		$query = $this->_db->query($sql);
		return $this->_getAllResultFromQuery($query);	
	}
	
	function getAdvertisePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.short_name as mer_name FROM pm_advertise a,pm_merchant b where a.mer_id=b.id ";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvertiseTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advertise";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}	
	
	function getAdvertiseStruct() {
		return array('mer_id','name','memo','contract_id','advtype','aff_count','status','spread','money_state',
		'day_maxmoney','pay_cycle','audit','level','sitetype_ids','sel_sitetype','cust_link','start_time','end_time',
		'creative_count','create_time','bill_url','sys_correct','use_gateway','fee_type','clicked_show','max_crt','rec_cookie',
		'filter_likeip','filter_agentip','filter_foreignip','eff_singleip','eff_likeip','eff_codelike','eff_recodenum','is_view','is_click','is_rolling','mer_onlyfee',
		'logo','area_list','site_level','deduct','is_selector','price','aff_price','unit','aff_unit');
	}
	
	function _checkAdvertiseData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvertiseStruct());
		return $data;
	}
	
	//广告创意----------------------------------------------------------------------------------------------------
	function insertAdvCreative($fieldsData){
		$fieldsData = $this->_checkAdvertiseData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advcreative SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvCreative($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advcreative SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvCreative($id){
		$this->_db->update("DELETE FROM pm_advcreative WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvCreative($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advcreative WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}

	function getAdvCreativePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.name as adv_name,c.short_name as mer_name FROM pm_advcreative a,pm_advertise b,pm_merchant c where a.mer_id=c.id and a.adv_id=b.id ";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvCreativeTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advcreative";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}		
	
	function getAdvCreativeStruct() {
		return array('id','mer_id','adv_id','name','content_type','res_content','adsort','adsize','create_time','update_time','page_id','creator_id',
		'creator_user','sysaudit_id','memo','status');
	}
	
	function _checkAdvCreativeData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvCreativeStruct());
		return $data;
	}	
	
	//广告推广页面----------------------------------------------------------------------------------------------------
	function insertAdvPages($fieldsData){
		$fieldsData = $this->_checkAdvPagesData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advpages SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvPages($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advpages SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvPages($id){
		$this->_db->update("UPDATE pm_advpages SET is_del=1 WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvPages($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advpages WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvPagesPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.name as adv_name,c.short_name as mer_name FROM pm_advpages a,pm_advertise b,pm_merchant c where a.adv_id=b.id and a.mer_id=c.id ";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvPagesTotalCount($stwhere=null){
		$sql = "SELECT COUNT(a.id) as count FROM pm_advpages a";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}		
	
	function getAdvPagesStruct() {
		return array('mer_id','adv_id','name','url','code','memo','start_date','end_date','create_time','start_hour','end_hour','status');
	}
	
	function _checkAdvPagesData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvPagesStruct());
		return $data;
	}
	
	//广告选择定义----------------------------------------------------------------------------------------------------
	function insertAdvSelector($fieldsData){
		$fieldsData = $this->_checkAdvSelectorData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advselector SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvSelector($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advselector SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvSelector($id){
		$this->_db->update("DELETE FROM pm_advselector WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvSelector($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advselector WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvSelectorPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_advselector";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvSelectorTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advselector";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}		
	
	function getAdvSelectorStruct() {
		return array('id','mer_id','adv_id','type','content','status','create_time');
	}
	
	function _checkAdvSelectorData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvPagesStruct());
		return $data;
	}
	
	//广告包站点广告位----------------------------------------------------------------------------------------------------
	function insertAdvBuyAffPlaces($fieldsData){
		$fieldsData = $this->_checkAdvBuyAffPlacesData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advbuyaffplaces SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvBuyAffPlaces($id,$updateData){
		$updateData = $this->_checkAdvBuyAffPlacesData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advbuyaffplaces SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvBuyAffPlaces($id){
		$this->_db->update("DELETE FROM pm_advbuyaffplaces WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvBuyAffPlaces($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advbuyaffplaces WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvBuyAffPlacesPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_advbuyaffplaces";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvBuyAffPlacesTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advselector";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}	
	
	function getAdvBuyAffPlacesStruct() {
		return array('id','mer_id','adv_id','aff_id','site_id','place_id','memo','create_time','start_time','end_time','status','is_del','audit_id','audit_user','buy_time');
	}
	
	function _checkAdvBuyAffPlacesData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvBuyAffPlacesStruct());
		return $data;
	}		
	
	//广告获取记录----------------------------------------------------------------------------------------------------
	function insertAdvAccess($fieldsData){
		$fieldsData = $this->_checkAdvertiseData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advaccess SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvAccess($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advaccess SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvAccess($id){
		$this->_db->update("DELETE FROM pm_advaccess WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvAccess($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advaccess WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvAccessPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_advaccess";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvAccessTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advaccess";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}		
	
	function getAdvAccessStruct() {
		return array('id','mer_id','adv_id','aff_id','creative_id','site_id','place_id','create_time','update_time','status','memo');
	}
	
	function _checkAdvAccessData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvAccessStruct());
		return $data;
	}	
	
	//广告轮播计划定义----------------------------------------------------------------------------------------------------
	function insertAdvRollPlan($fieldsData){
		$fieldsData = $this->_checkAdvertiseData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advrollplan SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvRollPlan($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advrollplan SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvRollPlan($id){
		$this->_db->update("DELETE FROM pm_advrollplan WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvRollPlan($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advrollplan WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvRollPlanPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_advrollplan";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvRollPlanTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advrollplan";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}	
	
	function getAdvRollPlanStruct() {
		return array('id','name','is_cpc','is_cpm','is_cpa','type','is_all','is_auto','status','create_time','update_time');
	}
	
	function _checkAdvRollPlanData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvRollPlanPageList());
		return $data;
	}		
	
	//广告轮播定义明细----------------------------------------------------------------------------------------------------
	function insertAdvRollDetail($fieldsData){
		$fieldsData = $this->_checkAdvertiseData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db->update("INSERT INTO pm_advrolldetail SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db->insert_id();
		return $insertId;
	}
	
	function updateAdvRollDetail($id,$updateData){
		$updateData = $this->_checkAdvertiseData($updateData);
		if (!$updateData) return null;
		$this->_db->update("UPDATE pm_advrolldetail SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function deleteAdvRollDetail($id){
		$this->_db->update("DELETE FROM pm_advrolldetail WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db->affected_rows();
	}
	
	function getAdvRollDetail($id){
		$data = $this->_db->get_one("SELECT * FROM pm_advrolldetail WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAdvRollDetailPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_advrolldetail";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvRollDetailTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_advrolldetail";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}		
	
	function getAdvRollDetailStruct() {
		return array('id','mer_id','adv_id','creative_id','roll_id','start_time','end_time','start_time','update_time');
	}
	
	function _checkAdvRollDetailData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAdvRollDetailStruct());
		return $data;
	}	
}
?>