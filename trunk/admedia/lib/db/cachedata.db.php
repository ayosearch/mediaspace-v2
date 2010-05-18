<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

if ( !defined( "P_W" ) )
{
	exit( "Forbidden" );
}
class pw_cachedatadb extends basedb
{

	var $_tableName = "pw_cachedata";

	function getdatabyinvokepieceid( $invokepieceid, $fid = 0, $loopid = 0 )
	{
		$temp = $this->_db->get_one( "SELECT invokepieceid,fid,loopid,data,cachetime FROM ".$this->_tableName." WHERE invokepieceid=".pwescape( $invokepieceid )."AND fid=".pwescape( $fid )." AND loopid=".pwescape( $loopid ) );
		if ( !$temp )
		{
			return array( );
		}
		return $this->_unserializedata( $temp );
	}

	function insertdata( $array )
	{
		$array = $this->_checkdata( $array );
		if ( !$array || !$array['invokepieceid'] || !$array['fid'] || !$array['loopid'] )
		{
			return null;
		}
		$this->_db->update( "REPLACE INTO ".$this->_tableName." SET ".pwsqlsingle( $array, false ) );
		return $this->_db->insert_id( );
	}

	function deletedata( $invokepieceid, $fid = 0, $loopid = 0 )
	{
		$sqladd = "";
		if ( $fid )
		{
			$sqladd .= " AND fid=".pwescape( $fid );
		}
		if ( $loopid )
		{
			$sqladd .= " AND loopid=".pwescape( $loopid );
		}
		$this->_db->update( "DELETE FROM ".$this->_tableName." WHERE invokepieceid=".pwescape( $invokepieceid )." {$sqladd}" );
	}

	function truncate( )
	{
		$this->_db->query( "TRUNCATE ".$this->_tableName."" );
	}

	function updates( $array )
	{
		foreach ( $array as $key => $value )
		{
			$array[$key] = $this->_serializedata( $value );
		}
		$this->_db->update( "REPLACE INTO ".$this->_tableName." (invokepieceid,fid,loopid,data,cachetime) VALUES ".pwsqlmulti( $array, false ) );
	}

	function getdatasbyinvokepieceids( $invokepieceids )
	{
		$temp_0 = $temp_1 = $invokepieceids_0 = $invokepieceids_1 = array( );
		foreach ( $invokepieceids as $key => $value )
		{
			if ( $value == 0 )
			{
				$invokepieceids_0[] = $key;
			}
			else
			{
				$invokepieceids_1[] = $key;
			}
		}
		$temp_0 = $this->commongetdatas( $invokepieceids_0 );
		$temp_1 = $this->specialgetdatas( $invokepieceids_1 );
		return $temp_0 + $temp_1;
	}

	function commongetdatas( $invokepieceids )
	{
		if ( !is_array( $invokepieceids ) || !$invokepieceids )
		{
			return array( );
		}
		$temp = array( );
		$query = $this->_db->query( "SELECT * FROM ".$this->_tableName." WHERE invokepieceid IN(".pwimplode( $invokepieceids ).")" );
		while ( $rt = $this->_db->fetch_array( $query ) )
		{
			$rt = $this->_unserializedata( $rt );
			$key = $rt['loopid'] ? $rt['invokepieceid']."_".$rt['loopid'] : $rt['invokepieceid'];
			$temp[$key] = $rt;
		}
		return $temp;
	}

	function specialgetdatas( $invokepieceids )
	{
		global $fid;
		$temp_fid = $fid ? $fid : "";
		if ( !is_array( $invokepieceids ) || !$invokepieceids )
		{
			return array( );
		}
		$temp = array( );
		$query = $this->_db->query( "SELECT * FROM ".$this->_tableName." WHERE invokepieceid IN(".pwimplode( $invokepieceids ).") AND fid=".pwescape( $temp_fid ) );
		while ( $rt = $this->_db->fetch_array( $query ) )
		{
			$rt = $this->_unserializedata( $rt );
			$key = $rt['loopid'] ? $rt['invokepieceid']."_".$rt['loopid'] : $rt['invokepieceid'];
			$temp[$key] = $rt;
		}
		return $temp;
	}

	function getstruct( )
	{
		return array( "id", "invokepieceid", "fid", "loopid", "data", "cachetime" );
	}

	function _checkdata( $data )
	{
		if ( !is_array( $data ) || !count( $data ) )
		{
			return null;
		}
		$data = $this->_checkallowfield( $data, $this->getstruct( ) );
		$data = $this->_serializedata( $data );
		return $data;
	}

	function _serializedata( $data )
	{
		if ( isset( $data['data'] ) && is_array( $data['data'] ) )
		{
			$data['data'] = serialize( $data['data'] );
		}
		return $data;
	}

	function _unserializedata( $data )
	{
		if ( $data['data'] )
		{
			$data['data'] = unserialize( $data['data'] );
		}
		return $data;
	}

}

?>
