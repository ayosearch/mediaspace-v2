<?php
class  PM_AffiliateDB extends BaseDB{
	//站长渠道----------------------------------------------------------------------------------------------------
	function insertAffiliate($fieldsData){
		$fieldsData = $this->_checkAffiliateData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affiliate SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffiliate($id,$updateData){
		$updateData = $this->_checkAffiliateData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affiliate SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateBatchAffiliates($ids,$updateData){
		$updateData = $this->_checkAffiliateData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affiliate SET " . $this->_getUpdateSqlString($updateData) . " WHERE id in (".$ids .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function updateAffiliateStatus($id,$sysaudit_id=0,$status){
		global $timestamp;
		if($sysaudit_id==0)
			$sql = "update pm_affiliate set status=".intval($status).",audit_time=".$timestamp.",update_time=".$timestamp." where id in (".$id.")";
		else
			$sql = "update pm_affiliate set status=".intval($status).",audit_time=".$timestamp.",update_time=".$timestamp.", sysaudit_id=".intval($sysaudit_id)." where id in (".$id.")";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffiliate($id){
		$this->_db_adspace->update("delete from pm_affiliate where id in (". intval($id) .")");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffiliateBatch($id){
		$this->_db_adspace->update("UPDATE pm_affiliate SET is_del=1 WHERE id in (". intval($id) .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function checkAffiliate($login_name){
		$sql = "select count(id) as count from pm_affiliate where login_name=".sqlEscape($login_name);
		$count = $this->_db_adspace->get_value($sql);
		if($count>0) return false;
		return true;
	}
	
	function getAffiliate($id){
		$sql = "SELECT a.*,b.name as province_name,c.name as city_name FROM pm_affiliate a left join (pm_baseprovince b,pm_basecity c) on a.province_id=b.id and a.city_id=c.id where a.id=".intval($id);
		$data = $this->_db_adspace->get_one($sql);
		if (!$data) return null;
		return $data;
	}
	
	function getAffiliateByLogin($userName,$userPass){
		$strSql = "select * from pm_affiliate where login_name=".sqlEscape($userName,false)." and login_pwd=".sqlEscape($userPass,false)." and is_del=0";
		$data = $this->_db_adspace->get_one($strSql);
		if (!$data) return null;
		return $data;
	}	
	
	function getAffiliateHaveSitePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.name as site_name FROM pm_affiliate a,pm_affwebsite b where a.id=b.aff_id ";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffiliateHaveSiteTotalCount($stwhere=null){
		$sql = "SELECT count(a.id) as count FROM pm_affiliate a,pm_affwebsite b where a.id=b.aff_id ";
		if($stwhere!=null)
			$sql = "$sql and $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}		
	
	function getAffiliatePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_affiliate";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffiliateTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_affiliate";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getAffiliateStruct() {
		return array('login_name','login_pwd','login_srcpwd','biz_type','biz_name','biz_code','biz_file','linkman','gender','telephone','ext','mobile','qq','msn','email','cert_type','cert_code','zip','fax','address','province_id','city_id','area_id','pay_limit','tax_rate','pay_cycle','commend_id','audit_id','audit_name','service_id','service_name','audit_time','create_time','update_time','credit','point','total_point','source','union_flag','pay_type','status','is_active','memo','balance','total_money','deduct','question','answer');
	}
	
	function _checkAffiliateData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffiliateStruct());
		return $data;
	}
		
	//站长站点----------------------------------------------------------------------------------------------------
	function insertAffWebSite($fieldsData){
		$fieldsData = $this->_checkAffWebSiteData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affwebsite SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffWebSite($id,$updateData){
		$updateData = $this->_checkAffWebSiteData($updateData);
		if (!$updateData) return null;
		$sql = "UPDATE pm_affwebsite SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}

	function updateAffWebSiteStatus($id,$sysaudit_id=0,$status){
		global $timestamp;
		if($sysaudit_id==0)
			$sql = "update pm_affwebsite set status=".intval($status).",audit_time=$timestamp where id in (".$id.")";
		else
			$sql = "update pm_affwebsite set status=".intval($status).",audit_time=$timestamp, sysaudit_id=".intval($sysaudit_id)." where id in (".$id.")";		
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffWebSite($id){
		$this->_db_adspace->update("UPDATE pm_affwebsite set is_del=1 WHERE id in (". sqlEscape($id) .")");
		return $this->_db_adspace->affected_rows();
	}
	
	function clearAffWebSite($id){
		$this->_db_adspace->update("DELETE FROM pm_affwebsite WHERE id in (". sqlEscape($id) .")");
		return $this->_db_adspace->affected_rows();
	}
	
	function getAffWebSite($id){
		$data = $this->_db_adspace->get_one("SELECT a.*,b.login_name as aff_name,b.linkman as aff_real_name,b.create_time as aff_create_time FROM pm_affwebsite a,pm_affiliate b WHERE a.aff_id=b.id and a.id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffWebSiteAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affwebsite ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffSiteStatusList($aff_id,$status=null){
		$sql = "SELECT * FROM pm_affwebsite where aff_id=".intval($aff_id);
		if($status!=null) $sql .= " and status=".intval($status);
		$sql .= " ORDER BY id DESC";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getAffWebSiteByAffId($aff_id){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affwebsite where aff_id=".intval($aff_id)." and status=1 ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	

	function getAffWebSiteAllPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.login_name as aff_name FROM pm_affwebsite a,pm_affiliate b where a.aff_id=b.id";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";

		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffWebSiteTotalCount($stwhere=null){
		$sql = "SELECT COUNT(a.id) as count FROM pm_affwebsite a";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getAffWebSiteAllStruct() {
		return array('aff_id','sitetype','name','url','tags','keyword','memo','ip','alexa_level','day_pv','day_ip','icp_code','ad_used','create_time','audit_time','update_time','enable_cpc','enable_roll','is_del','status');
	}
	
	function _checkAffWebSiteData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffWebSiteAllStruct());
		return $data;
	}
	
	//站长申请广告----------------------------------------------------------------------------------------------------
	function insertAffAdvApply($fieldsData){
		$fieldsData = $this->_checkAffAdvApplyData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affadvapply SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffAdvApply($id,$updateData){
		$updateData = $this->_checkAffAdvApplyData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affadvapply SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateAffAdvApplyStatus($id,$sysaudit_id,$status){
		$sql = "UPDATE pm_affadvapply SET status=".intval($status).",sysaudit_id=".intval($sysaudit_id)." where id=".intval($id);
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}	
	
	function deleteAffAdvApply($id){
		$this->_db_adspace->update("DELETE FROM pm_affadvapply WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getAffAdvApply($id){
		$sql = "SELECT a.*,b.login_name as aff_name FROM pm_affadvapply a,pm_affiliate b where a.aff_id=b.id and a.id=".intval($id);
		$data = $this->_db_adspace->get_one($sql);
		if (!$data) return null;
		return $data;
	}
	
	function getAffAdvApplyByAffId($aff_id,$adv_id){
		$sql = "SELECT a.*,b.login_name as aff_name FROM pm_affadvapply a,pm_affiliate b where a.aff_id=b.id and a.aff_id=".intval($aff_id)." and adv_id=".$adv_id." limit 1";
		$data = $this->_db_adspace->get_one($sql);
		if (!$data) return null;
		return $data;		
	}
	
	function getAffAdvApplyAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affadvapply ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffAdvApplyAllByAffId($aff_id,$status=-1){
		$sql = "SELECT * FROM pm_affadvapply where aff_id=".intval($aff_id);
		if($status!=-1){
			$sql .= " and status=".intval($status);
		}
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffAdvApplyPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = " select * from ( SELECT a.*,b.name as adv_name,d.login_name as aff_name FROM pm_affadvapply a,pm_advertise b,pm_affiliate d where a.aff_id=d.id and a.adv_id=b.id) view_advapply";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffAdvApplyTotalCount($stwhere=null){
		$sql = "select count(id) from ( SELECT a.*,b.name as adv_name,d.login_name as aff_name FROM pm_affadvapply a,pm_advertise b,pm_affiliate d where a.aff_id=d.id and a.adv_id=b.id) view_advapply";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getAdvApplyFrontPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "select * from (SELECT a.*,b.status as apply_status FROM pm_advertise a left join pm_affadvapply b on a.id=b.adv_id) as tbl";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAdvApplyFrontTotalCount($stwhere=null){
		$sql = "select count(id) as count from (SELECT a.*,b.status as apply_status FROM pm_advertise a left join pm_affadvapply b on a.id=b.adv_id) as tbl ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getAffAdvApplyStruct() {
		return array('aff_id','adv_id','site_ids','sysaudit_id','create_time','status','memo');
	}
	
	function _checkAffAdvApplyData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffAdvApplyStruct());
		return $data;
	}	
	
	//站长广告位----------------------------------------------------------------------------------------------------
	function insertAffAdvPlace($fieldsData){
		$fieldsData = $this->_checkAffAdvPlaceData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affadvplace SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffAdvPlace($id,$updateData){
		$updateData = $this->_checkAffAdvPlaceData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affadvplace SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateAffAdvPlaceAudit($ids,$sysaudit_id=0,$audit){
		global $timestamp;
		if($sysaudit_id==0)
			$sql = "update pm_affadvplace set audit=".intval($audit).",audit_time=$timestamp where id in (".$ids.")";
		else
			$sql = "update pm_affadvplace set audit=".intval($audit).",audit_time=$timestamp, sysaudit_id=".intval($sysaudit_id)." where id in (".$ids.")";		
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function updateAffAdvPlaceStatus($ids,$status){
		$this->_db_adspace->update("UPDATE pm_affadvplace SET audit=".intval($status)." WHERE id in (".$ids .")");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffAdvPlace($ids){
		$this->_db_adspace->update("DELETE FROM pm_affadvplace WHERE id in (". sqlEscape($ids) .")");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteBatchAffAdvPlace($ids){
		$this->_db_adspace->update("UPDATE pm_affadvplace set is_del=1 WHERE id in (". sqlEscape($ids) .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function getAffAdvPlace($id){
		$data = $this->_db_adspace->get_one("SELECT a.*,b.name as site_name,c.login_name as aff_name FROM pm_affadvplace a,pm_affwebsite b,pm_affiliate c where a.site_id=b.id and a.aff_id=c.id and a.id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffAdvPlaceAll($aff_id=0,$site_id=0,$audit=-1){
		$sql = "SELECT * FROM pm_affadvplace where 0=0 ";
		if($aff_id!=0) $sql .= " and aff_id=".intval($aff_id);
		if($site_id!=0) $sql .= " and site_id=".intval($site_id);
		if($audit!=-1) $sql .= " and audit=".intval($audit);
		$sql .= " ORDER BY id DESC";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffAdvPlacePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.name as site_name,c.login_name as aff_name FROM pm_affadvplace a,pm_affwebsite b,pm_affiliate c where a.site_id=b.id and a.aff_id=c.id";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffAdvPlaceTotalCount($stwhere=null){
		$sql = "SELECT count(a.id) as count FROM pm_affadvplace a,pm_affwebsite b,pm_affiliate c where a.site_id=b.id and a.aff_id=c.id ";
		if($stwhere!=null)
			$sql = "$sql and $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getAffAdvPlaceAllStruct() {
		return array('aff_id','site_id','name','keyword','demo_url','adsize','memo','change_apply',
		'check_status','audit','status','mod_right','week_price','click_price','create_time','update_time','sysaudit_id','audit_time');
	}
	
	function _checkAffAdvPlaceData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffAdvPlaceAllStruct());
		return $data;
	}	
	
	//站长支付信息----------------------------------------------------------------------------------------------------
	function insertAffPayInfo($fieldsData){
		$fieldsData = $this->_checkAffPayInfoData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affpayinfo SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffPayInfo($id,$updateData){
		$updateData = $this->_checkAffPayInfoData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affpayinfo SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffPayInfo($id){
		$this->_db_adspace->update("DELETE FROM pm_affpayinfo WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getAffPayInfo($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_affpayinfo WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffPayInfoByAffId($affid){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affpayinfo where aff_id=".intval($affid)." ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffPayInfoAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affpayinfo ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffPayInfoAllPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_affpayinfo ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffPayInfoAllStruct() {
		return array('aff_id','pay_method','open_name','open_address','acc_type','account','acc_contract');
	}
	
	function _checkAffPayInfoData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffPayInfoAllStruct());
		return $data;
	}
	
	//站长站点标签信息----------------------------------------------------------------------------------------------------
	function insertAffWebSiteTags($fieldsData){
		$fieldsData = $this->_checkAffWebSiteTagsData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affwebsitetags SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffWebSiteTags($id,$updateData){
		$updateData = $this->_checkAffWebSiteTagsData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affwebsitetags SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffWebSiteTags($id){
		$this->_db_adspace->update("DELETE FROM pm_affwebsitetags WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getAffWebSiteTags($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_affwebsitetags WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffWebSiteTagsAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affwebsitetags ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffWebSiteTagsAllPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_affwebsitetags ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffWebSiteTagsAllStruct() {
		return array('tag_name');
	}
	
	function _checkAffWebSiteTagsData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffWebSiteTagsAllStruct());
		return $data;
	}
	
	//站长作弊违规记录----------------------------------------------------------------------------------------------------
	function insertAffCheatPunishment($fieldsData){
		$fieldsData = $this->_checkAffWebSiteTagsData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_affcheatpunishment SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffCheatPunishment($id,$updateData){
		$updateData = $this->_checkAffWebSiteTagsData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_affcheatpunishment SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffCheatPunishment($id){
		$this->_db_adspace->update("DELETE FROM pm_affcheatpunishment WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getAffCheatPunishment($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_affcheatpunishment WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffCheatPunishmentAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_affcheatpunishment ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffCheatPunishmentPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_affcheatpunishment ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffCheatPunishmentAllStruct() {
		return array('aff_id','site_id','adv_id','ori_num','ori_fee','deduct_num','deduct_fee','memo','user_id','user_name','create_time','punish_date','punish_id','punish_user');
	}
	
	function _checkAffCheatPunishmentData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffCheatPunishmentAllStruct());
		return $data;
	}	
	
	//站长支付记录----------------------------------------------------------------------------------------------------
	function insertAffPayment($fieldsData){
		$fieldsData = $this->_checkAffPaymentData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO fin_affpayment SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateAffPayment($id,$updateData){
		$updateData = $this->_checkAffPaymentData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE fin_affpayment SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffPayment($id){
		$this->_db_adspace->update("DELETE FROM fin_affpayment WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getAffPayment($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM fin_affpayment WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffPaymentAll(){
		$query = $this->_db_adspace->query("SELECT * FROM fin_affpayment ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffPaymentPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM fin_affpayment ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffPaymentAllStruct() {
		return array('fin_no','aff_id','pay_type','pay_cycle','pay_start','pay_end','real_money','need_money','tax','balance','is_pay','audit_id','audit_name','create_time','pay_time','payinfo_id');
	}
	
	function _checkAffPaymentData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffPaymentAllStruct());
		return $data;
	}
	
	//站长黑名单----------------------------------------------------------------------------------------------------
	function insertAffBlack($fieldsData){
		$fieldsData = $this->_checkAffBlackData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysblacklist SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateBatchAffBlacks($ids,$updateData){
		$updateData = $this->_checkAffBlackData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysblacklist SET " . $this->_getUpdateSqlString($updateData) . " WHERE platform='aff' and id in (".$ids .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function updateAffBlack($id,$updateData){
		$updateData = $this->_checkAffBlackData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysblacklist SET " . $this->_getUpdateSqlString($updateData) . " WHERE platform='aff' and id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateAffBlackStatus($id,$status){
		$sql = "update pm_sysblacklist set status=".intval($status)." where platform='aff' and id in (".$id.")";
		echo $sql;
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteAffBlack($id){
		$this->_db_adspace->update("delete from pm_sysblacklist WHERE platform='aff' and id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function checkAffBlack($user_name){
		$sql = "select count(id) as count from pm_sysblacklist where platform='aff' and user_name=".sqlEscape($user_name);
		$count = $this->_db_adspace->get_value($sql);
		if($count>0) return false;
		return true;
	}
	
	function getAffBlack($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysblacklist WHERE platform='aff' and $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getAffBlackList($ids){
		$query =	$this->_db_adspace->query("SELECT * FROM pm_sysblacklist WHERE platform='aff' and id in (".$ids.")");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getAffBlackPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysblacklist where platform='aff'";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffBlackTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysblacklist";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getAffBlackStruct() {
		return array('platform','user_id','user_name','memo','status','release_id','release_user','release_time','lock_id','lock_user','lock_time','release_desc');
	}
	
	function _checkAffBlackData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getAffBlackStruct());
		return $data;
	}	
}