<?php
InitGetPost(array('itype'));

!empty($itype) && $transtr .= "&itype=$itype";

if($action=="del"){
	$action = "inner";
	if($itype=="area"){
		$objCommData = LOAD::loadDB("CommonData");
		$objCommData->deleteBaseArea($curid);	
	}else if($itype=="province"){
		$objCommData = LOAD::loadDB("CommonData");
		$objCommData->deleteBaseProvince($curid);
	}else if($itype=="city"){	
		$objCommData = LOAD::loadDB("CommonData");
		$objCommData->deleteBaseCity($curid);
	}else if($itype=="advformat"){	
		$objCommData = LOAD::loadDB("CommonData");
		$objCommData->deleteBaseAdvFormat($curid);
	}else if($itype=="advsize"){	
		$objCommData = LOAD::loadDB("CommonData");
		$objCommData->deleteBaseAdvSize($curid);
	}else{
		$objCommData = LOAD::loadDB("CommonData");
		$objCommData->deleteBaseSort($curid,$itype);
	}
}

if($action=="inner"){
	if($itype=="area"){
		$objCommData = LOAD::loadDB("CommonData");
		$totalnum = $objCommData->getBaseAreaTotalCount();
		$totalpage = ceil($totalnum/$perpage);		
		$db_sysdatalist = $objCommData->getBaseAreaPageList($curpage,$perpage);
	}else if($itype=="province"){
		$objCommData = LOAD::loadDB("CommonData");
		$totalnum = $objCommData->getBaseProvinceTotalCount();
		$totalpage = ceil($totalnum/$perpage);		
		$db_sysdatalist = $objCommData->getBaseProvincePageList($curpage,$perpage);
	}else if($itype=="city"){
		$objCommData = LOAD::loadDB("CommonData");
		$totalnum = $objCommData->getBaseCityTotalCount();
		$totalpage = ceil($totalnum/$perpage);		
		$db_sysdatalist = $objCommData->getBaseCityPageList($curpage,$perpage);
	}else if($itype=="advformat"){
		$objCommData = LOAD::loadDB("CommonData");
		$totalnum = $objCommData->getBaseAdvFormatTotalCount();
		$totalpage = ceil($totalnum/$perpage);		
		$db_sysdatalist = $objCommData->getBaseAdvFormatPageList($curpage,$perpage);
	}else if($itype=="advsize"){
		$objCommData = LOAD::loadDB("CommonData");
		$totalnum = $objCommData->getBaseAdvSizeTotalCount();
		$totalpage = ceil($totalnum/$perpage);		
		$db_sysdatalist = $objCommData->getBaseAdvSizePageList($curpage,$perpage);
	}else{
		$objCommData = LOAD::loadDB("CommonData");
		$totalnum = $objCommData->getBaseSortTotalCount("ikey='$itype'");
		$totalpage = ceil($totalnum/$perpage);		
		$db_sysdatalist = $objCommData->getBaseSortPageList($curpage,$perpage,"ikey='$itype'");
	}
}
if($action=="new"){
	if($itype=="province"){
		$objCommData = LOAD::loadDB("CommonData");
		$db_arealist = $objCommData->getBaseAreaAll();
		$op_arealist = "";
		foreach($db_arealist as $db_area){
			$op_arealist .= "<option value='$db_area[id]'>$db_area[name]</option>";
		}
	}
	if($itype=="city"){
		$objCommData = LOAD::loadDB("CommonData");
		$db_provincelist = $objCommData->getBaseProvinceAll();
		$op_provincelist = "";
		foreach($db_provincelist as $db_province){
			$op_provincelist .= "<option value='$db_province[id]'>$db_province[name]</option>";
		}		
	}
	/**
	if($itype=="advformat"){
		$objCommData = LOAD::loadDB("CommonData");
	}
	if($itype=="advsize"){
		$objCommData = LOAD::loadDB("CommonData");
	}
	if($itype=="sitetype" || $itype=="channeltype" || $itype=="clientphase" || $itype=="clientsource" 
		|| $itype=="companyscale" || $itype=="duty" || $itype=="sitetype" || $itype=="trade" || $itype=="unit" 
		|| $itype=="bank" || $itype=="clientlevel" || $itype=="advtype"){
		$objCommData = LOAD::loadDB("CommonData");
	}**/
}

if($action=="save"){
	$objCommData = LOAD::loadDB("CommonData");
	if($itype=="area"){
		if(empty($curid)){
			$objCommData->insertBaseArea($_POST);
		}else{
			$objCommData->updateBaseArea($curid,$_POST);
		}
	}else if($itype=="province"){	
		if(empty($curid)){
			$objCommData->insertBaseProvince($_POST);
		}else{
			$objCommData->updateBaseProvince($curid,$_POST);
		}
	}else if($itype=="city"){	
		if(empty($curid)){
			$objCommData->insertBaseCity($_POST);
		}else{
			$objCommData->updateBaseCity($curid,$_POST);
		}
	}else if($itype=="advformat"){
		if(empty($curid)){
			$objCommData->insertBaseAdvFormat($_POST);
		}else{
			$objCommData->updateBaseAdvFormat($curid,$_POST);
		}
	}else if($itype=="advsize"){
		if(empty($curid)){
			$objCommData->insertBaseAdvSize($_POST);
		}else{
			$objCommData->updateBaseAdvSize($curid,$_POST);
		}
	}else{
		if(empty($curid)){			
			$objCommData->insertBaseSort($_POST);
		}else{
			$objCommData->updateBaseSort($curid,$_POST);
		}
	}
	echo "<script>window.opener=null;window.close();</script>";
}

if($action=="edit"){
	if($itype=="area"){
		$objCommData = LOAD::loadDB("CommonData");
		$db_basearea = $objCommData->getBaseArea($curid);
	}else if($itype=="province"){
		$objCommData = LOAD::loadDB("CommonData");		
		$db_baseprovince = $objCommData->getBaseProvince($curid);
		$db_arealist = $objCommData->getBaseAreaAll();
		$op_arealist = "";
		foreach($db_arealist as $db_area){
			if($db_baseprovince[area_id]==$db_area[id]){
				$op_arealist .= "<option value='$db_area[id]' selected>$db_area[name]</option>";
			}else{
				$op_arealist .= "<option value='$db_area[id]'>$db_area[name]</option>";
			}
		}
	}else if($itype=="city"){
		$objCommData = LOAD::loadDB("CommonData");		
		$db_basecity = $objCommData->getBaseCity($curid);
		$db_provincelist = $objCommData->getBaseProvinceAll();
		$op_provincelist = "";
		foreach($db_provincelist as $db_province){
			if($db_basecity[province_id]==$db_province[id]){
				$op_provincelist .= "<option value='$db_province[id]' selected>$db_province[name]</option>";
			}else{
				$op_provincelist .= "<option value='$db_province[id]'>$db_province[name]</option>";
			}
		}			
	}else if($itype=="advformat"){
		$objCommData = LOAD::loadDB("CommonData");		
		$db_baseadvformat = $objCommData->getBaseAdvFormat($curid);
	}else if($itype=="advsize"){
		$objCommData = LOAD::loadDB("CommonData");			
		$db_baseadvsize = $objCommData->getBaseAdvSize($curid);
	}else{
		$objCommData = LOAD::loadDB("CommonData");
		$db_basesort = $objCommData->getBaseSort($curid);
	}
}

include PrintEot($job);
footer(true);

?>