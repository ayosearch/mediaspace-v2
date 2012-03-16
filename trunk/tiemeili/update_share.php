<?php
require dirname(__FILE__).'/core/fanwe.php';
$fanwe = &FanweService::instance();
$fanwe->initialize();

$index = intval($_REQUEST['index']);
@set_time_limit(0);
if(function_exists('ini_set'))
    ini_set('max_execution_time',0);

$limit = 50;

$list = FDB::fetchAll('SELECT share_id,cache_data FROM '.FDB::table('share')." WHERE share_data IN ('goods','photo','goods_photo') ORDER BY share_id DESC LIMIT ".$index.','.$limit);
if(count($list) == 0)
{
	echo "<h1>更新会员图片完成</h1>";
	exit;
}

foreach($list as $data)
{
	$cache_data = fStripslashes(unserialize($data['cache_data']));
	$imgs = $cache_data['imgs'];

	include_once fimport('class/image');
	$image = new Image();

	foreach($imgs['all'] as $img)
	{
		$update = array();
		$update['img_width'] = 0;
		$update['img_height'] = 0;

		if(empty($img['server_code']))
		{
			$path = FANWE_ROOT.$img['img'];
			$info = $image->getImageInfo($path);
			if($info['type'] != 'jpg' && $info['type'] != 'jpeg')
			{
				$image->convertType($path,$path);
			}

			$update['img_width'] = $info[0];
			$update['img_height'] = $info[1];
		}
		else
		{
			$server = FS("Image")->getServer($img['server_code']);
			$args = array();
			$args['img_path'] = $img['img'];
			$server = FS("Image")->getImageUrlToken($args,$server,1);
			$body = FS("Image")->sendRequest($server,'updateimg',true);
			$info = unserialize($body);

			$update['img_width'] = $info[0];
			$update['img_height'] = $info[1];
		}

		if($img['type'] == 'g')
		{
			FDB::update('share_goods',$update,"goods_id = ".$img['id']);
		}
		else
		{
			FDB::update('share_photo',$update,"photo_id = ".$img['id']);
		}
		usleep(100);
	}

	FS('Share')->updateShareCache($data['share_id'],'imgs');
	
    echo "更新 $data[share_id] 图片成功<br/>";
	flush();
	ob_flush();
    usleep(10);
}

echo "<script type=\"text/javascript\">var fun = function(){location.href='update_share.php?index=".($index + $limit)."&time=".time()."';}; setTimeout(fun,1000);</script>"."\r\n";
flush();
ob_flush();
exit;
?>