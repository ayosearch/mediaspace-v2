<?php
class PM_FinanceDB extends BaseDB{
	function getAffBillCyclePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM fin_affbill_cycle";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffBillCycleTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_affbill_cycle";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}

	function getMerBillDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM fin_merbill_day";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerBillDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_merbill_day";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getMerProfiltDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.short_name as mer_name FROM fin_merprofit_day_total a inner join pm_merchant b on a.mer_id=b.id ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerProfiltDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(a.id) as count FROM fin_merprofit_day_total a";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getAffBillDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_affbill_day";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffBillDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_affbill_day";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getAdvProfitDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.short_name as mer_name,c.name as adv_name FROM fin_advprofit_day_total a,pm_merchant b,pm_advertise c where a.mer_id=b.id and a.adv_id=c.id ";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAdvProfitDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(a.id) as count FROM fin_advprofit_day_total a";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getAffSiteProfitDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.login_name as aff_name,c.name as site_name FROM fin_affsiteprofit_day_total a,pm_affiliate b,pm_affwebsite c where a.aff_id=b.id and a.site_id=c.id ";
		if($stwhere!=null)
			$sql = $sql." and ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffSiteProfitDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(a.id) as count FROM fin_affsiteprofit_day_total a ";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getAffProfitDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT a.*,b.login_name as aff_name FROM fin_affprofit_day_total a inner join pm_affiliate b on a.aff_id=b.id";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffProfitDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(a.id) as count FROM fin_affprofit_day_total a";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function geAffPaymentPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM fin_affpayment";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getAffPaymentTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_affpayment";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
}
?>