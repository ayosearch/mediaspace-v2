<?php
class PM_ReportDB extends BaseDB{
	//账单周期报表----------------------------------------------------------------------------------------------------
	function insertRepAffBillDay($fieldsData){
		$fieldsData = $this->_checkMerchant($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO rep_affbill_cycle SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateRepAffBillDay($id,$updateData){
		$updateData = $this->_checkMerchant($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE rep_affbill_cycle SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteRepAffBillDay($id){
		$this->_db_adspace->update("DELETE FROM rep_affbill_cycle WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getRepAffBillDay($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM rep_affbill_cycle WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getRepAffBillDayAll(){
		$query = $this->_db_adspace->query("SELECT * FROM rep_affbill_cycle ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepAffBillDayPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM rep_affbill_cycle ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepAffBillDayStruct() {
		return array('id','aff_id','pay_count','pay_fee','kill_count','pay_fee','pay_start','pay_end','create_time','update_time','audit_id','audit_user','memo','status');
	}
	
	function _checkRepAffBillDayData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getRepAffBillDayStruct());
		return $data;
	}
	
	//账单日报表----------------------------------------------------------------------------------------------------
	function insertRepAffBillCycle($fieldsData){
		$fieldsData = $this->_checkMerchant($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO rep_affbill_cycle SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateRepAffBillCycle($id,$updateData){
		$updateData = $this->_checkMerchant($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE rep_affbill_cycle SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteRepAffBillCycle($id){
		$this->_db_adspace->update("DELETE FROM rep_affbill_cycle WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getRepAffBillCycle($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM rep_affbill_cycle WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getRepAffBillCycleAll(){
		$query = $this->_db_adspace->query("SELECT * FROM rep_affbill_cycle ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepAffBillCyclePageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM rep_affbill_cycle ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepAffBillCycleStruct() {
		return array('id','aff_id','need_count','need_fee','pay_count','pay_fee','pay_start','pay_end','create_time','update_time','audit_id','audit_user','memo','status');
	}
	
	function _checkRepAffBillCycleData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getRepAffBillCycleStruct());
		return $data;
	}	
	
	//账单网站主广告位日报表----------------------------------------------------------------------------------------------------
	function insertRepAffPlaceCountDay($fieldsData){
		$fieldsData = $this->_checkMerchant($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO rep_affplacecount_day SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateRepAffPlaceCountDay($id,$updateData){
		$updateData = $this->_checkMerchant($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE rep_affplacecount_day SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteRepAffPlaceCountDay($id){
		$this->_db_adspace->update("DELETE FROM rep_affplacecount_day WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getRepAffPlaceCountDay($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM rep_affplacecount_day WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getRepAffPlaceCountDayAll(){
		$query = $this->_db_adspace->query("SELECT * FROM rep_affplacecount_day ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepAffPlaceCountDayPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM rep_affplacecount_day ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepAffPlaceCountDayStruct() {
		return array('id','aff_id','site_id','place_id','adv_id','creative_id','show_num','ip_shownum','click_num','ip_clicknum','fakeip_feenum',
		'cookie_num','order_money','send_money','real_num','fake_num','price','total_money','fake_totalmoney','iday','create_time','status');
	}
	
	function _checkRepAffPlaceCountDayData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getRepAffPlaceCountDayStruct());
		return $data;
	}	

	//广告商广告统计日报表----------------------------------------------------------------------------------------------------
	function insertRepMerBillDay($fieldsData){
		$fieldsData = $this->_checkMerchant($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO rep_merbill_day SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateRepMerBillDay($id,$updateData){
		$updateData = $this->_checkMerchant($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE rep_merbill_day SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteRepMerBillDayDay($id){
		$this->_db_adspace->update("DELETE FROM rep_merbill_day WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getRepMerBillDayDay($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM rep_merbill_day WHERE $id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getRepMerBillDayAll(){
		$query = $this->_db_adspace->query("SELECT * FROM rep_merbill_day ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepMerBillDayPageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM rep_merbill_day ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}
	
	function getRepMerBillDayStruct() {
		return array('id','mer_id','adv_id','income_count','income_fee','out_count','out_fee','create_time','update_time','iday','memo','fee_code');
	}
	
	function _checkRepMerBillDayData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getRepAffPlaceCountDayStruct());
		return $data;
	}		
}
?>