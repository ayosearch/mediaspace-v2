<?php
class PM_MerchantDB extends basedb{

	function insertMerChance( $fieldsData ){
		$fieldsData = $this->_checkmerchancedata( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$this->_db_adspace->update( "INSERT INTO pm_merchance SET ".$this->_getupdatesqlstring( $fieldsData ) );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerChance( $id, $updateData ){
		$updateData = $this->_checkmerchancedata( $updateData );
		if ( !$updateData ){
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_merchance SET ".$this->_getupdatesqlstring( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function deleteMerChance( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_merchance WHERE id in (".$id.")");
		return $this->_db_adspace->affected_rows( );
	}
	
	function deleteBatchMerChance( $id ){
		$this->_db_adspace->update( "update pm_merchance set is_del=1 WHERE id in (".$id.")" );
		return $this->_db_adspace->affected_rows( );
	}	

	function getMerChance( $id ){
		$data = $this->_db_adspace->get_one( "SELECT * FROM pm_merchance WHERE id=".intval( $id ) );
		if ( !$data )
		{
			return null;
		}
		return $data;
	}

	function getMerChanceAll( ){
		$query = $this->_db_adspace->query( "SELECT * FROM pm_merchance ORDER BY id DESC" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerChancePageList( $page, $perPage, $stwhere = null, $storderby = null ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$sql = "SELECT * FROM pm_merchance";
		if ( $stwhere != null ){
			$sql = $sql." where ".$stwhere;
		}
		if ( $storderby != null ){
			$sql = $sql." order by ".$storderby." DESC";
		}
		$query = $this->_db_adspace->query( $sql." LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerChanceTotalCount( $stwhere = null ){
		$sql = "SELECT COUNT(id) as count FROM pm_merchance";
		if ( $stwhere != null ){
			$sql = "{$sql} where {$stwhere}";
		}
		$count = $this->_db_adspace->get_value( $sql );
		return $count;
	}

	function getMerChanceStruct( ){
		return array( "chance_no", "title", "nickname", "require_type", "clientsource", "phase", "status", "est_money", "sign_date", "seller_id", "seller_name", "creator_id", "creator_name", "create_time" );
	}

	function _checkMerChanceData( $data ){
		if ( !is_array( $data ) || !count( $data ) )
		{
			return null;
		}
		$data = $this->_checkallowfield( $data, $this->getMerChanceStruct( ) );
		return $data;
	}

	//广告主合同
	function insertMerContract( $fieldsData ){
		$fieldsData = $this->_checkMerContractData( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$sql =  "INSERT INTO pm_mercontract SET ".$this->_getUpdateSqlString( $fieldsData );
		$this->_db_adspace->update( $sql );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerContract( $id, $updateData ){
		$updateData = $this->_checkMerContractData( $updateData );
		if ( !$updateData ){
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_mercontract SET ".$this->_getupdatesqlstring( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}
	
	function updateMerContractStatus($ids,$status){
		$sql = "update pm_contract set status=".intval($status)." where id in (".$ids.")";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows( );
	}

	function deleteMerContract( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_mercontract WHERE id in (".$id.")" );
		return $this->_db_adspace->affected_rows( );
	}
	
	function deleteBatchMerContract( $id ){
		$this->_db_adspace->update( "UPDATE pm_mercontract set is_del=1 WHERE id in (".$id.")" );
		return $this->_db_adspace->affected_rows( );
	}	

	function getMerContract( $id ){
		$data = $this->_db_adspace->get_one( "SELECT * FROM pm_mercontract WHERE id=".intval( $id ) );
		if ( !$data ){
			return null;
		}
		return $data;
	}

	function getMerContractAll( $status=-1,$merId=-1){
		$sql = "SELECT * FROM pm_mercontract where 1=1 ";
		if($merId!=-1)
			$sql .= " and mer_id=".intval($merId);		
		if($status!=-1)
			$sql .= " and status=".intval($status);
		$sql .= " ORDER BY id DESC";
		$query = $this->_db_adspace->query( $sql );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerContractPageList( $page, $perPage, $stwhere = null, $storderby = null ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$sql = "SELECT a.*,b.short_name as mer_name FROM pm_mercontract a,pm_merchant b where a.mer_id=b.id";
		if ( $stwhere != null ){
			$sql = $sql." and ".$stwhere;
		}
		if ( $storderby != null ){
			$sql = $sql." order by ".$storderby." DESC";
		}
		$query = $this->_db_adspace->query( $sql." LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerContractTotalCount( $stwhere = null ){
		$sql = "SELECT COUNT(id) as count FROM pm_mercontract";
		if ( $stwhere != null ){
			$sql = "{$sql} where {$stwhere}";
		}
		$count = $this->_db_adspace->get_value( $sql );
		return $count;
	}

	function getMerContractStruct( ){
		return array( "contract_no", "mer_id", "paytype", "itype", "chance_id", "title", "memo", "fee", "sign_date", "file_path", "start_date", "end_date", "seller_id", "seller_name", "creator_id", "creator_name", "create_time","status");
	}

	function _checkMerContractData( $data ){
		if ( !is_array( $data ) || !count( $data ) ){
			return null;
		}
		$data = $this->_checkAllowField( $data, $this->getMerContractStruct( ) );
		return $data;
	}
	
	//广告主
	function insertMerchant( $fieldsData ){
		$fieldsData = $this->_checkMerchantData( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$this->_db_adspace->update( "INSERT INTO pm_merchant SET ".$this->_getUpdateSqlString( $fieldsData ) );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerchant( $id, $updateData ){
		$updateData = $this->_checkMerchantData( $updateData );
		if ( !$updateData ){
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_merchant SET ".$this->_getUpdateSqlString( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}
	
	function updateMerchantOverDraft($id,$over_draft){
		$sql = "update pm_merchant set over_draft=over_draft+".$over_draft." where id=".intval($id);
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function updateMerchantCredit($ids,$point){
		$sql = "update pm_merchant set credit=credit+".intval($point)." where id in (".$ids.")";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function updateMerchantClientType($ids,$clienttype){
		$sql = "update pm_merchant set client_type=".intval($clienttype)." where id in (".$ids.")";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}	
	
	function updateMerchantStatus($id,$sysaudit_id=0,$status){
		global $timestamp;
		if($sysaudit_id==0)
			$sql = "update pm_merchant set status=".intval($status).",audit_time=$timestamp where id in (".sqlEscape($id).")";
		else
			$sql = "update pm_merchant set status=".intval($status).",audit_time=$timestamp, sysaudit_id=".intval($sysaudit_id)." where id in (".sqlEscape($id).")";		
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}	
	
	function deleteMerchantBatch( $ids ){
		$this->_db_adspace->update( "update pm_merchant set is_del=1 WHERE id in (".$ids.")" );
		return $this->_db_adspace->affected_rows( );
	}	
	
	function deleteMerchant( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_merchant WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function getMerchant( $id ){
		$sql = "SELECT a.*,b.name as province_name,c.name as city_name FROM pm_merchant a left join (pm_baseprovince b,pm_basecity c) on a.province_id=b.id and a.city_id=c.id where a.id=".intval( $id );
		$data = $this->_db_adspace->get_one( $sql );
		if ( !$data ){
			return null;
		}
		return $data;
	}	
	
	function getMerAdvList($mer_id){
		$sql = "SELECT * FROM pm_advertise where mer_id=".intval($mer_id)." and status=1";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}	

	function getMerchantAll( $status=null ){
		$sql = "SELECT * FROM pm_merchant";
		if($status!=null)
			$sql .= " where status=".intval($status);
		$sql .= " ORDER BY id DESC";
		$query = $this->_db_adspace->query( $sql );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerchantPageList( $page, $perPage, $stwhere = null, $storderby = null ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$sql = "SELECT a.*,b.name as province_name,c.name as city_name FROM pm_merchant a,pm_baseprovince b,pm_basecity c where a.province_id=b.id and a.city_id=c.id";
		if ( $stwhere != null ){
			$sql = $sql." and ".$stwhere;
		}
		if ( $storderby != null ){
			$sql = $sql." order by ".$storderby." DESC";
		}
		$query = $this->_db_adspace->query( $sql." LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerchantTotalCount( $stwhere = null ){
		$sql = "SELECT COUNT(a.id) as count FROM pm_merchant a";
		if ( $stwhere != null ){
			$sql = "{$sql} where {$stwhere}";
		}
		$count = $this->_db_adspace->get_value( $sql );
		return $count;
	}

	function getMerchantStruct( ){
		return array( "login_name", "login_pwd", "company", "scale", "short_name", "logo", "biz_code", "url", "ticket_title", "province_id", "city_id", "address", "zip", "trade", "client_source", "seller_id", "seller_name", "phase", "client_type", "client_level", "credit", "create_time", "audit_time", "memo", "init_store", "current_store", "deposit","over_draft" );
	}

	function _checkMerchantData( $data ){
		if ( !is_array( $data ) || !count( $data ) ){
			return null;
		}
		$data = $this->_checkAllowField( $data, $this->getMerchantStruct( ) );
		return $data;
	}

	//广告主阀值
	function insertMerDeposit( $fieldsData ){
		$fieldsData = $this->_checkmerdepositdata( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$this->_db_adspace->update( "INSERT INTO pm_merdeposit SET ".$this->_getupdatesqlstring( $fieldsData ) );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerDeposit( $id, $updateData ){
		$updateData = $this->_checkMerchant( $updateData );
		if ( !$updateData ){
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_merdeposit SET ".$this->_getupdatesqlstring( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function deleteMerDeposit( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_merdeposit WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function getMerMeposit( $id ){
		$data = $this->_db_adspace->get_one( "SELECT * FROM pm_merdeposit WHERE id=".intval( $id ) );
		if ( !$data ){
			return null;
		}
		return $data;
	}

	function getMerDepositAll( ){
		$query = $this->_db_adspace->query( "SELECT * FROM pm_merdeposit ORDER BY id DESC" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerDepositPageList( $page, $perPage, $stwhere = null, $storderby = null ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$sql = "SELECT a.*,b.short_name as mer_name FROM pm_merdeposit a,pm_merchant b where a.mer_id=b.id ";
		if ( $stwhere != null ){
			$sql = $sql." and ".$stwhere;
		}
		if ( $storderby != null ){
			$sql = $sql." order by ".$storderby." DESC";
		}
		$query = $this->_db_adspace->query( $sql." LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerDepositTotalCount( $stwhere = null ){
		$sql = "SELECT COUNT(a.id) as count FROM pm_merdeposit a,pm_merchant b where a.mer_id=b.id ";
		if ( $stwhere != null ){
			$sql = "{$sql} and {$stwhere}";
		}
		$count = $this->_db_adspace->get_value( $sql );
		return $count;
	}

	function getMerDepositStruct( ){
		return array( "mer_id", "curr_fee", "itype", "create_time","iday");
	}

	function _checkMerDepositData( $data ){
		if ( !is_array( $data ) || !count( $data ) ){
			return null;
		}
		$data = $this->_checkAllowField( $data, $this->getMerDepositStruct( ) );
		return $data;
	}

	//广告主回款
	function insertMerPayrec( $fieldsData ){
		$fieldsData = $this->_checkMerPayrecData( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$this->_db_adspace->update( "INSERT INTO pm_merpayrec SET ".$this->_getupdatesqlstring( $fieldsData ) );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerPayrec( $id, $updateData ){
		$updateData = $this->_checkMerPayrecData( $updateData );
		if ( !$updateData )
		{
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_merpayrec SET ".$this->_getupdatesqlstring( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}
	
	function deleteMerPayrecBatch($ids){
		$sql = "update pm_merpayrec set is_del=1 where id in (".$ids.")";
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows( );		
	}

	function deleteMerPayrec( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_merpayrec WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function getMerPayrec( $id ){
		$data = $this->_db_adspace->get_one( "SELECT * FROM pm_merpayrec WHERE id=".intval( $id ) );
		if ( !$data ){
			return null;
		}
		return $data;
	}

	function getMerPayrecAll(){
		$query = $this->_db_adspace->query( "SELECT * FROM pm_merpayrec ORDER BY id DESC" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerPayrecPageList( $page, $perPage, $stwhere = null, $storderby = null ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$sql = "SELECT a.*,b.title as contract_name,b.fee as contract_fee,c.short_name as mer_name FROM pm_merpayrec a,pm_mercontract b,pm_merchant c where a.contract_id=b.id and a.mer_id=c.id ";
		if ( $stwhere != null ){
			$sql = $sql." and ".$stwhere;
		}
		if ( $storderby != null ){
			$sql = $sql." order by ".$storderby." DESC";
		}
		$query = $this->_db_adspace->query( $sql." LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerPayrecTotalCount( $stwhere = null ){
		$sql = "SELECT a.*,b.title as contract_name,c.short_name as mer_name FROM pm_merpayrec a,pm_mercontract b,pm_merchant c where a.contract_id=b.id and a.mer_id=c.id ";
		if ( $stwhere != null ){
			$sql .= " and ".$stwhere;
		}
		$count = $this->_db_adspace->get_value( $sql );
		return $count;
	}

	function getMerPayrecStruct( ){
		return array( "mer_id", "contract_id", "plan_money", "real_money", "wheel", "plan_paydate", "real_paydate", "creator_id", "creator_user", "create_time","ticket_time", "ticketor_id", "ticketor_user", "sure_id", "sure_user", "fin_no", "pay_time", "memo", "status" );
	}

	function _checkMerPayrecData( $data ){
		if ( !is_array( $data ) || !count( $data ) ){
			return null;
		}
		$data = $this->_checkAllowField( $data, $this->getMerPayrecStruct( ) );
		return $data;
	}

	//广告主附属图标
	function insertMerAppendIcons( $fieldsData ){
		$fieldsData = $this->_checkMerAppendIconsData( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$this->_db_adspace->update( "INSERT INTO pm_merappendicons SET ".$this->_getupdatesqlstring( $fieldsData ) );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerAppendIcons( $id, $updateData ){
		$updateData = $this->_checkMerAppendIconsData( $updateData );
		if ( !$updateData ){
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_merappendicons SET ".$this->_getupdatesqlstring( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function deleteMerAppendIcons( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_merappendicons WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function getMerAppendIcons( $id ){
		$data = $this->_db_adspace->get_one( "SELECT * FROM pm_merappendicons WHERE id=".intval( $id ) );
		if ( !$data ){
			return null;
		}
		return $data;
	}

	function getMerAppendIconsAll( ){
		$query = $this->_db_adspace->query( "SELECT * FROM pm_merappendicons ORDER BY id DESC" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerAppendIconspagelist( $page, $perPage ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$query = $this->_db_adspace->query( "SELECT * FROM pm_merappendicons ORDER BY id DESC LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerAppendIconsStruct( ){
		return array( "mer_id", "icon_type", "icon_path", "width", "height" );
	}

	function _checkMerAppendIconsData( $data ){
		if ( !is_array( $data ) || !count( $data ) ){
			return null;
		}
		$data = $this->_checkallowfield( $data, $this->getMerAppendIconsStruct( ) );
		return $data;
	}

	//广告主联系人
	function insertMerLinkMan( $fieldsData ){
		$fieldsData = $this->_checkMerLinkManData( $fieldsData );
		if ( !$fieldsData ){
			return null;
		}
		$this->_db_adspace->update( "INSERT INTO pm_merlinkman SET ".$this->_getupdatesqlstring( $fieldsData ) );
		$insertId = $this->_db_adspace->insert_id( );
		return $insertId;
	}

	function updateMerLinkMan( $id, $updateData ){
		$updateData = $this->_checkMerLinkManData( $updateData );
		if ( !$updateData ){
			return null;
		}
		$this->_db_adspace->update( "UPDATE pm_merlinkman SET ".$this->_getupdatesqlstring( $updateData )." WHERE id=".intval( $id )." LIMIT 1" );
		return $this->_db_adspace->affected_rows( );
	}

	function deleteMerLinkMan( $id ){
		$this->_db_adspace->update( "DELETE FROM pm_merlinkman WHERE id in (".$id.")" );
		return $this->_db_adspace->affected_rows( );
	}
	
	function deleteBatchMerLinkMan( $id ){
		$this->_db_adspace->update( "update pm_merlinkman set is_del=1 WHERE id in (".$id.")" );
		return $this->_db_adspace->affected_rows( );
	}

	function getMerLinkMan( $id ){
		$data = $this->_db_adspace->get_one( "SELECT * FROM pm_merlinkman WHERE id=".intval( $id ) );
		if ( !$data ){
			return null;
		}
		return $data;
	}
	
	function getDefaultMerLinkMan($mer_id){
		$data = $this->_db_adspace->get_one("select * from pm_merlinkman where mer_id=".intval($mer_id)." and is_default=1");
		if ( !$data ){
			return null;
		}
		return $data;		
	}

	function getMerLinkManAll( ){
		$query = $this->_db_adspace->query( "SELECT * FROM pm_merlinkman ORDER BY id DESC" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerLinkManPageList( $page, $perPage, $stwhere = null, $storderby = null ){
		$page = intval( $page );
		$perPage = intval( $perPage );
		if ( $page <= 0 || $perPage <= 0 ){
			return array( );
		}
		$offset = ( $page - 1 ) * $perPage;
		$sql = "SELECT a.*,b.short_name as mer_name FROM pm_merlinkman a left join pm_merchant b on a.mer_id=b.id ";
		if ( $stwhere != null ){
			$sql = $sql." where ".$stwhere;
		}
		if ( $storderby != null ){
			$sql = $sql." order by ".$storderby." DESC";
		}
		$query = $this->_db_adspace->query( $sql." LIMIT {$offset},{$perPage}" );
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getMerLinkManTotalCount( $stwhere = null ){
		$sql = "SELECT COUNT(id) as count FROM pm_merlinkman";
		if ( $stwhere != null ){
			$sql = "{$sql} where {$stwhere}";
		}
		$count = $this->_db_adspace->get_value( $sql );
		return $count;
	}

	function getMerLinkManStruct( ){
		return array( "mer_id", "is_default", "name", "idcard_no", "idcard_path", "sex", "title", "department", "duty_id", "function", "work_tel", "ext", "fax", "mobile", "email", "msn", "qq", "family_tel", "family_address", "birthday", "favorite", "memo", "create_time" );
	}

	function _checkMerLinkManData( $data ){
		if ( !is_array( $data ) || !count( $data ) ){
			return null;
		}
		$data = $this->_checkallowfield( $data, $this->getMerLinkManStruct( ) );
		return $data;
	}

}

?>
