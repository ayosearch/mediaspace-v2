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
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAffBillCycleTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_affbill_cycle";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
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
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getMerBillDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_merbill_day";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
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
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAffBillDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_affbill_day";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}
	
	function getAdvProfitDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM fin_advprofit_day_total";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAdvProfitDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_advprofit_day_total";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}
	
	function getAffProfitDayPageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM fin_affprofit_day_total";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAffProfitDayTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_affprofit_day_total";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
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
		$query = $this->_db->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query);	
	}

	function getAffPaymentTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM fin_affpayment";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db->get_value($sql);
		return $count;
	}
	
}
?>