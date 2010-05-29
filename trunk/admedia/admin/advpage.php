<?php 
InitGetPost(array('status','all'));

!empty($status) && $transtr .= "&status=$status";
(!empty($searchtype) && !empty($searchkey)) && $transtr .= "&searchtype=".$searchtype."&searchkey=$searchkey";

if($action=="new"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$op_advlist = loadAdvertiseList('1',"0");
}else if($action=="edit"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$db_advpage = $objAdvertise->getAdvPages($curid);
	$op_advlist = loadAdvertiseList('1',$db_advpage[adv_id]);	
}else if($action=="save"){
	if(!isset($curid) || empty($curid)){
		$objAdvertise = LOAD::loadDB("Advertise");
		$db_adv = $objAdvertise->getAdvertise($_POST[adv_id]);
		$_POST[mer_id]=$db_adv[mer_id];
		$_POST[create_time] = $timestamp;
		$_POST[update_time] = $timestamp;
		$objAdvertise->insertAdvPages($_POST);
		ObHeader("$basename?job=advpage$tranastr");
	}else{
		$objAdvertise = LOAD::loadDB("Advertise");
		$_POST[update_time] = $timestamp;
		$db_adv = $objAdvertise->getAdvertise($_POST[adv_id]);
		$_POST[mer_id]=$db_adv[mer_id];	
		$objAdvertise->updateAdvPages($curid,$_POST);
		ObHeader("$basename?job=advpage$tranastr");		
	}
	exit;
}else if($action=="del"){
	$objAdvertise = LOAD::loadDB("Advertise");
	$objAdvertise->deleteAdvPages($ids);
	ObHeader("$basename?job=advpage$tranastr");	
	exit;		
}else if(empty($action)){
 	$stwhere = "a.is_del=0 and ";
	(!empty($status)) && $stwhere .= " a.status=".sqlEscape($status)." and ";			
	if(!empty($searchtype) && !empty($searchkey)) {
		$querykey = "%".$searchkey."%";
		$stwhere .= " a.$searchtype like ".sqlEscape($querykey)." and ";			
	}
	(strlen($stwhere)>0) && $stwhere = substr($stwhere,0,strlen($stwhere)-4);	 		
	
	$objAdvertise = LOAD::loadDB("Advertise");
	$totalnum = $objAdvertise->getAdvPagesTotalCount($stwhere);
	$totalpage = ceil($totalnum/$perpage);
	$db_advpagelist = $objAdvertise->getAdvPagesPageList($curpage,$perpage,$stwhere,"a.id");
}

include PrintEot($job);
footer(true);

?>