<?php
class PM_AdminUserDB extends BaseDB{
	//系统模块----------------------------------------------------------------------------------------------------
	function insertSysModule($fieldsData){
		$fieldsData = $this->_checkSysModuleData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysmodule SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysModule($id,$updateData){
		$updateData = $this->_checkSysModuleData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysmodule SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysModule($ids){
		$this->_db_adspace->update("DELETE FROM pm_sysmodule WHERE id in (". $ids.")");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysModule($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysmodule WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysModuleCountByParentId($parentId){
		$sql = "SELECT count(id) as count FROM pm_sysmodule WHERE parent_id=".intval($parentId);
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}	
	
	function getSysModuleAll($stwhere=null,$orderby=null){
		$sql = "select a.*,b.name as parentname from pm_sysmodule a left outer join pm_sysmodule b on a.parent_id=b.id";
		if($stwhere!=null)
			$sql .= " where $stwhere";
		if($orderby!=null)
			$sql .= " order by $orderby";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getSysModulePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "select a.*,b.name as parentname from pm_sysmodule a left outer join pm_sysmodule b on a.parent_id=b.id";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." asc";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getSysModuleTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysmodule";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysModuleStruct() {
		return array('code','name','url','create_time','parent_id','memo','col_index','is_del');
	}
	
	function _checkSysModuleData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysModuleStruct());
		return $data;
	}	
	
	//系统用户操作模块----------------------------------------------------------------------------------------------------
	function insertSysOperate($fieldsData){
		$fieldsData = $this->_checkSysOperateData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysoperate SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysOperate($id,$updateData){
		$updateData = $this->_checkSysOperateData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysoperate SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysOperate($id){
		$this->_db_adspace->update("DELETE FROM pm_sysoperate WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysOperate($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysoperate WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysOperateAll(){
		$sql = "select * from pm_sysoperate";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getSysOperatePageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysoperate ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getSysOperateStruct() {
		return array('op_name','op_code','is_del');
	}
	
	function _checkSysOperateData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysOperateStruct());
		return $data;
	}	

	//系统用户操作最小操作模块----------------------------------------------------------------------------------------------------
	function insertSysCellOperate($fieldsData){
		$fieldsData = $this->_checkSysCellOperateData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_syscelloperate SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysCellOperate($id,$updateData){
		$updateData = $this->_checkSysCellOperateData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_syscelloperate SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysCellOperate($id){
		$this->_db_adspace->update("DELETE FROM pm_syscelloperate WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysCellOperateByColId($col_ids){
		$this->_db_adspace->update("DELETE FROM pm_syscelloperate WHERE col_id in (". $col_ids.")" );
		return $this->_db_adspace->affected_rows();
	}	
	
	function checkSysCellOperate($col_id,$op_id){
		$sql = "select count(id) as count from pm_syscelloperate where col_id=".$col_id." and op_id=".$op_id;
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysCellOperate($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_syscelloperate WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysCellOperateAll($stwhere=null){
		$sql = "select a.*,b.op_code as op_code,b.op_name as op_name from pm_syscelloperate a, pm_sysoperate b where a.op_id=b.id and a.is_del=0";
		if($stwhere!=null)
			$sql .= " and ".$stwhere;
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getSysCellOperateById($col_id,$op_id){
		$sql = "select a.*,b.op_name as op_name from pm_syscelloperate a, pm_sysoperate b where a.op_id=b.id and a.is_del=0 and a.col_id=".$col_id." and a.op_id=".$op_id;
		$data = $this->_db_adspace->get_one($sql);
		if (!$data) return null;
		return $data;
	}	
	
	function getSysCellOperatePageList($page, $perPage){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$query = $this->_db_adspace->query("SELECT * FROM pm_syscelloperate ORDER BY id DESC LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getSysCellOperateStruct() {
		return array('col_id','op_id','is_del');
	}
	
	function _checkSysCellOperateData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysCellOperateStruct());
		return $data;
	}	

	//系统角色操作模块----------------------------------------------------------------------------------------------------
	function insertSysRole($fieldsData){
		$fieldsData = $this->_checkSysRoleData($fieldsData);
		if (!$fieldsData) return null;
		$this->_db_adspace->update("INSERT INTO pm_sysrole SET " . $this->_getUpdateSqlString($fieldsData));
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysRole($id,$updateData){
		$updateData = $this->_checkSysRoleData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysrole SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateSysRoleOperateIds($curid,$operate_ids){
		$sql = "update pm_sysrole set operate_ids = ".sqlEscape($operate_ids)." where id=".intval($curid);
		$this->_db_adspace->update($sql);
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysRole($id){
		$this->_db_adspace->update("DELETE FROM pm_sysrole WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysRoleBatch($ids){
		$this->_db_adspace->update("DELETE FROM pm_sysrole WHERE id in (". $ids .")");
		return $this->_db_adspace->affected_rows();
	}	
	
	function getSysRoleAll(){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysrole ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getSysRoleAllByType($type){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysrole where itype=".$type." ORDER BY id DESC");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}		
	
	function getSysRole($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysrole WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysRoles($ids){
		$query = $this->_db_adspace->query("SELECT * FROM pm_sysrole WHERE id in (".$ids.")");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}	
	
	function getSysRolePageList($page, $perPage,$stwhere=null,$storderby=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysrole";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getSysRoleTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysrole";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}
	
	function getSysRoleStruct() {
		return array('name','memo','itype','operate_ids','is_del');
	}
	
	function _checkSysRoleData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysRoleStruct());
		return $data;
	}	

	//系统用户模块----------------------------------------------------------------------------------------------------
	function insertSysUser($fieldsData){
		$fieldsData = $this->_checkSysUserData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO pm_sysuser SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db_adspace->update($sql);
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysUser($id,$updateData){
		$updateData = $this->_checkSysUserData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysuser SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function updateSysUserState($state,$arrIds){
		$strLen = count($arrIds);
		if($strLen>1){
			$strIds = arrayImplode($arrIds);
			$sql = "update pm_sysuser set is_active=$state where id in ( $strIds )";	
			$this->_db_adspace->update($sql);	
			return ($this->_db_adspace->affected_rows())>0;
		}else if($strLen==1){
			$sql = "update pm_sysuser set is_active=$state where id=$strIds[0]";
			$this->_db_adspace->update($sql);
			return ($this->_db_adspace->affected_rows())>0;
		}
		return false;
	}
	
	function getSysUser($id){
		$strSql = "select * from pm_sysuser where id=".$id;
		$data = $this->_db_adspace->get_one($strSql);
		if (!$data) return null;
		return $data;
	}
	
	function getSysUserByLogin($userName,$userPass){
		$strSql = "select * from pm_sysuser where login_name=".sqlEscape($userName,false)." and login_pwd=".sqlEscape($userPass,false)." and is_active=1 and is_del=0";
		$data = $this->_db_adspace->get_one($strSql);
		if (!$data) return null;
		return $data;
	}
	
	function getSysUserByUserName($userName){
		$strSql = "select * from pm_sysuser where login_name=".sqlEscape($userName,false)." and is_active=1 and is_del=0";
		$data = $this->_db_adspace->get_one($strSql);
		if (!$data) return null;
		return $data;
	}	
	
	function changeSysUserPass($id,$oldPass,$newPass){
		$strSql = "update pm_sysuser set login_pwd=".amEscape($newPass,false)." where login_pwd=".sqlEscape($oldPass,false)." and id=".sqlEscape($id);
		$this->_db_adspace->update($strSql);
		$ret = $this->_db_adspace->affected_rows();
		return $ret;
	}
	
	function getSysUserByRoleIds($roleIds){
		$sql = "select * from pm_sysuser where role_id in (".$roleIds.")";
		$query = $this->_db_adspace->query($sql);
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}
	
	function getSysUserByRole($strRoleName){
		$strSql = "select id from pm_sysrole where name=".sqlEscape($strRoleName);
		$data = $this->_db_adspace->get_one($strSql);
		if ($data){
			$query = $this->_db_adspace->query("select * from pm_sysuser where CONCAT(',',rold_id,',') like ".sqlEscape("%,".$data["id"].",%",false));
			return $this->_getAllResultFromQuery($query,$this->_db_adspace);
		}
		return null;		
	}
	
    function distributeSysUser($intID, $strUserID){
		$strSql = "update pm_sysuser set own_users=".sqlEscape($strUserID)." where id=".sqlEscape($intID);
		$this->_db_adspace->update($strSql);
		$ret = $this->_db_adspace->affected_rows();
		return $ret;
    }	
    
	function getSysUserBelongID($strIds){
		$ret = "";
		$ret = getSysUserChildren($strIds, $ret);
		$ret = $strIds.",".$ret;
		$ret = rtrim($ret,',');
		return trimSameTags($ret);
	}
	
	function getSysUserChildren($strIds,$str){
		$query = $this->_db_adspace->query("select * from pm_sysuser where is_del=0 where CONCAT(id,',') like '%".$strIds."%' order by id asc");
		while ($rt = $this->_db_adspace->fetch_array($query)) {
			if($rt["own_users"]!="" && (",".$str).IndexOf(",".$rt["own_users"].ToString() + ",") == -1){
				$str .= $rt["own_users"].ToString().",";
				$str = getSysUserChildren($rt["own_users"].ToString(),$str);
			}
		}
		return $str;
	}
	
	/**
	 * 取得用户具有权限的操作栏目
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function getSysUserColumns($id){
		$queryModel = $this->getSysModuleAll(null,"a.col_index asc");
		$rtUser = $this->getSysUser($id);
		if($rtUser){
			$popedomIds = "";
			if(strpos($rtUser["role_id"],',')>0){
				$arrRole = explode(',',$rtUser["role_id"]);
				$sql = "select * from pm_sysrole where id in (".pmImplode($arrRole).")";
			}else{
				$sql = "select * from pm_sysrole where id = ".$rtUser["role_id"];
			}
			$query = $this->_db_adspace->query($sql);
			$db_rolelist = $this->_getAllResultFromQuery($query,$this->_db_adspace);($query);
			foreach($db_rolelist as $db_role){
				$popedomIds .= $db_role["operate_ids"].",";
			}
			$popedomIds = rtrim($popedomIds,',');
			$strIds = "";
			if(!empty($popedomIds)){
				$sql = "select * from pm_syscelloperate where is_del=0 and id in (".$popedomIds.")";
				$queryCol = $this->_db_adspace->query($sql);
				$db_oplist = $this->_getAllResultFromQuery($query,$this->_db_adspace);($queryCol);
				foreach($db_oplist as $db_op){
					$strIds .= $db_op[col_id].",";
					$strIds = $this->getSysUserParentColumns($queryModel,$db_op[col_id],$strIds);
				}
				$strIds = trimSameTags(rtrim($strIds,','));
				$queryModel2 = $this->_db_adspace->query("select * from pm_sysmodule where is_del=0 and id in (".$strIds.") order by col_index ASC");
				return $this->_getAllResultFromQuery($query,$this->_db_adspace);($queryModel2);
			}				
		}
		return null;
	}
	
	function getSysUserParentColumns($queryModel,$colId,$str){
		foreach ($queryModel as $rtModel){
			if($rtModel["id"]==$colId){
				$str .= $rtModel["parent_id"].',';
				$str = $this->getSysUserParentColumns($queryModel,$rtModel["parent_id"],$str);
			}
		}
		return $str;
	}
	
	function deleteSysUser($id){
		$this->_db_adspace->update("DELETE FROM pm_sysuser WHERE id=".sqlEscape($id));
		return $this->_db_adspace->affected_rows();
	}	
	
	function deleteSysUserBatch($ids){
		$this->_db_adspace->update("DELETE FROM pm_sysuser WHERE id in (".$ids.")");
		return $this->_db_adspace->affected_rows();
	}
	
	function checkSysUser($login_name){
		$sql = "select count(id) as count from pm_sysuser where login_name=".sqlEscape($login_name);
		$count = $this->_db_adspace->get_value($sql);
		if($count>0) return false;
		return true;
	}
	
	function getSysUserNormalAll(){
		$query = $this->_db_adspace->query("select * from pm_sysuser where is_del=0 order by id desc");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);($query);
	}
	
	function getSysUserPageList($page, $perPage,$storderby=null, $stwhere=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysuser";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);
	}

	function getSysUserTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysuser";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}

	function getSysUserStruct() {
		return array('login_name','login_pwd','login_srcpwd','real_name','nick_name','create_time','role_id','own_users','is_active','qq','mobile','msn','is_del');
	}
	
	function _checkSysUserData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysUserStruct());
		return $data;
	}	
	
	//用户操作日志----------------------------------------------------------------------------------------------------
	function insertSysOpLog($fieldsData){
		$fieldsData = $this->_checkSysOpLogData($fieldsData);
		if (!$fieldsData) return null;
		$sql = "INSERT INTO pm_sysoplog SET " . $this->_getUpdateSqlString($fieldsData);
		$this->_db_adspace->update($sql);
		$insertId = $this->_db_adspace->insert_id();
		return $insertId;
	}
	
	function updateSysOpLog($id,$updateData){
		$updateData = $this->_checkSysOpLogData($updateData);
		if (!$updateData) return null;
		$this->_db_adspace->update("UPDATE pm_sysoplog SET " . $this->_getUpdateSqlString($updateData) . " WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function deleteSysOpLog($id){
		$this->_db_adspace->update("DELETE FROM pm_sysoplog WHERE id=". intval($id) ." LIMIT 1");
		return $this->_db_adspace->affected_rows();
	}
	
	function getSysOpLog($id){
		$data = $this->_db_adspace->get_one("SELECT * FROM pm_sysoplog WHERE id=".intval($id));
		if (!$data) return null;
		return $data;
	}
	
	function getSysOpLogPageList($page, $perPage, $storderby=null, $stwhere=null){
		$page = intval($page);
		$perPage = intval($perPage);
		if ($page <= 0 || $perPage <= 0) return array();
		$offset = ($page - 1) * $perPage;
		$sql = "SELECT * FROM pm_sysoplog";
		if($stwhere!=null)
			$sql = $sql." where ".$stwhere;
		if($storderby!=null)
			$sql = $sql." order by ".$storderby." DESC";
		$query = $this->_db_adspace->query($sql." LIMIT $offset,$perPage");
		return $this->_getAllResultFromQuery($query,$this->_db_adspace);	
	}

	function getSysOpLogTotalCount($stwhere=null){
		$sql = "SELECT COUNT(id) as count FROM pm_sysoplog";
		if($stwhere!=null)
			$sql = "$sql where $stwhere";
		$count = $this->_db_adspace->get_value($sql);
		return $count;
	}

	function getSysOpLogStruct() {
		return array('user_id','user_name','platform','op_type','op_name','op_content','create_time');
	}
	
	function _checkSysOpLogData($data){
		if (!is_array($data) || !count($data)) return null;
		$data = $this->_checkAllowField($data,$this->getSysOpLogStruct());
		return $data;
	}		


}
?>