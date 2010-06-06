	var arrprovince = new Array(new Array('1','北京'),new Array('2','上海'),new Array('3','福建'),new Array('4','甘肃'),new Array('5','广东'),new Array('6','广西'),new Array('7','贵州'),new Array('8','海南'),
			new Array('9','湖北'),new Array('10','河北'),new Array('11','河南'),new Array('12','黑龙江'),new Array('13','湖南'),new Array('14','吉林'),new Array('15','江苏'),new Array('16','江西'),
			new Array('17','辽宁'),new Array('18','内蒙古'),new Array('19','宁夏'),new Array('20','青海'),new Array('21','山东'),new Array('22','山西'),new Array('23','陕西'),new Array('24','四川'),
			new Array('25','安徽'),new Array('26','天津'),new Array('27','西藏'),new Array('28','新疆'),new Array('29','云南'),new Array('30','浙江'),new Array('31','重庆'));
	var arrcity = new Array(new Array('331','12','大兴安岭'),new Array('332','20','海东'),new Array('333','9','武汉'),new Array('334','27','拉萨'),new Array('335','4','平凉'),new Array('336','6','柳州'),
			new Array('337','24','南充'),new Array('338','16','九江'),new Array('339','9','鄂州'),new Array('340','13','湘潭'),new Array('341','24','广安'),new Array('342','28','库尔勒'),
			new Array('343','16','赣州'),new Array('344','28','克拉玛依'),new Array('345','5','佛山'),new Array('346','23','西安'),new Array('347','6','百色'),new Array('348','18','海拉尔'),
			new Array('349','11','新乡'),new Array('350','28','博尔塔拉'),new Array('351','24','广元'),new Array('352','15','苏州'),new Array('353','25','安庆'),new Array('354','11','漯河'),
			new Array('355','14','珲春'),new Array('356','4','金昌'),new Array('357','28','阿克苏'),new Array('358','28','吐鲁番'),new Array('359','22','晋中'),new Array('360','13','郴州'),
			new Array('361','12','黑河'),new Array('362','9','宜昌'),new Array('363','24','泸州'),new Array('364','23','榆林'),new Array('365','16','萍乡'),new Array('366','9','黄石'),
			new Array('367','11','信阳'),new Array('368','7','黔南州'),new Array('369','11','安阳'),new Array('370','24','成都'),new Array('371','30','舟山'),new Array('372','20','西宁'),
			new Array('373','18','锡林浩特'),new Array('374','10','邢台'),new Array('375','12','绥化'),new Array('376','20','黄南州'),new Array('377','22','阳泉'),new Array('378','22','运城'),
			new Array('379','24','宜宾'),new Array('380','5','茂名'),new Array('381','9','襄樊'),new Array('382','18','阿盟'),new Array('384','15','镇江'),new Array('385','29','玉溪'),
			new Array('386','13','株洲'),new Array('387','19','石嘴山'),new Array('388','30','台州'),new Array('389','22','长治'),new Array('390','7','毕节'),new Array('391','4','酒泉'),
			new Array('392','23','汉中'),new Array('393','15','盐城'),new Array('394','6','钦州'),new Array('395','20','玉树州'),new Array('396','18','通辽'),new Array('397','21','济南'),
			new Array('398','18','乌兰查布盟'),new Array('399','24','阿坝'),new Array('400','5','河源'),new Array('401','4','张掖'),new Array('1','15','张家港'),new Array('2','9','神农架'),
			new Array('3','29','迪庆'),new Array('4','24','达州'),new Array('5','17','锦州'),new Array('6','12','七台河'),new Array('7','10','秦皇岛'),new Array('8','11','平顶山'),
			new Array('9','29','红河'),new Array('10','11','潢川'),new Array('11','28','博乐'),new Array('13','22','朔州'),new Array('14','11','洛阳'),new Array('15','21','潍坊'),
			new Array('16','14','通化'),new Array('17','21','聊城'),new Array('18','3','莆田'),new Array('19','15','丹阳'),new Array('20','14','四平'),new Array('21','24','甘孜'),
			new Array('22','30','绍兴'),new Array('23','6','贺州'),new Array('24','11','鹤壁'),new Array('25','3','南平'),new Array('26','25','淮南'),new Array('27','10','石家庄'),
			new Array('28','15','溧阳'),new Array('29','17','鞍山'),new Array('30','5','云浮'),new Array('31','25','滁州'),new Array('32','28','克州'),new Array('33','22','吕梁'),
			new Array('34','5','揭阳'),new Array('35','13','岳阳'),new Array('36','6','梧州'),new Array('37','6','桂林'),new Array('38','25','宣城'),new Array('39','7','黔东南州'),
			new Array('40','7','兴义'),new Array('41','25','毫州'),new Array('42','27','那曲'),new Array('43','29','思茅'),new Array('44','17','阜新'),new Array('45','30','衢州'),
			new Array('46','30','宁波'),new Array('47','20','海西州'),new Array('48','25','宣州'),new Array('49','22','晋城'),new Array('50','13','张家界'),new Array('51','27','昌都'),
			new Array('52','28','塔城'),new Array('53','11','三门峡'),new Array('54','20','格尔木'),new Array('55','5','清远'),new Array('56','12','大庆'),new Array('57','5','中山'),
			new Array('58','6','来宾'),new Array('59','23','铜川'),new Array('60','13','怀化'),new Array('61','12','丹东'),new Array('62','21','莱芜'),new Array('63','7','六盘水'),
			new Array('64','3','泉州'),new Array('65','12','双鸭山'),new Array('66','30','丽水'),new Array('67','24','巴中'),new Array('68','10','承德'),new Array('69','29','临沧'),
			new Array('70','16','景德镇'),new Array('71','5','珠海'),new Array('72','21','青岛'),new Array('73','4','陇南'),new Array('74','2','上海'),new Array('75','27','日喀则'),
			new Array('76','4','天水'),new Array('77','25','阜阳'),new Array('78','13','邵阳'),new Array('79','17','营口'),new Array('80','24','马尔康'),new Array('81','3','福州'),
			new Array('82','9','十堰'),new Array('83','18','东胜'),new Array('84','28','伊犁'),new Array('85','18','呼盟'),new Array('86','5','江门'),new Array('87','25','淮北'),
			new Array('88','28','哈密'),new Array('89','25','亳州'),new Array('90','24','遂宁'),new Array('91','24','资阳'),new Array('92','4','白银'),new Array('93','24','德阳'),
			new Array('94','13','株州'),new Array('95','17','朝阳'),new Array('96','5','潮阳'),new Array('97','19','中卫'),new Array('98','24','自贡'),new Array('99','16','上饶'),
			new Array('100','7','凯里'),new Array('101','6','河池'),new Array('102','5','从化'),new Array('103','20','海东地区'),new Array('104','10','廊坊'),new Array('105','5','东莞'),
			new Array('106','9','孝感'),new Array('107','15','连云港'),new Array('108','18','阿拉善盟'),new Array('109','20','共和'),new Array('110','4','甘南州'),new Array('111','21','滨州'),
			new Array('112','24','乐山'),new Array('113','10','衡水'),new Array('114','26','天津'),new Array('115','25','合肥'),new Array('116','28','和田'),new Array('117','18','乌兰浩特'),
			new Array('118','31','黔江'),new Array('119','21','济宁'),new Array('120','25','巢湖'),new Array('121','23','安康'),new Array('122','23','渭南'),new Array('123','25','宿州'),
			new Array('124','14','梅河口'),new Array('125','13','吉首'),new Array('126','19','银川'),new Array('127','7','都匀'),new Array('128','5','潮州'),new Array('129','17','铁岭'),
			new Array('130','25','马鞍山'),new Array('131','15','太仓'),new Array('132','5','汕头'),new Array('133','4','嘉峪关'),new Array('134','17','葫芦岛'),new Array('135','20','果洛州'),
			new Array('136','5','阳江'),new Array('137','6','南宁'),new Array('138','9','天门'),new Array('139','5','梅州'),new Array('140','15','句容'),new Array('141','18','鄂尔多斯'),
			new Array('142','7','贵阳'),new Array('143','13','长沙'),new Array('144','9','江汉'),new Array('145','1','北京'),new Array('146','6','北海'),new Array('147','15','启东'),
			new Array('148','29','昆明'),new Array('149','14','吉林'),new Array('150','9','咸宁'),new Array('151','3','漳州'),new Array('152','15','昆山'),new Array('153','18','锡盟'),
			new Array('154','29','版纳'),new Array('155','5','湛江'),new Array('156','18','赤峰'),new Array('157','6','贵港'),new Array('158','25','铜陵'),new Array('159','5','广州'),
			new Array('160','4','临夏'),new Array('161','21','威海'),new Array('162','17','盘锦'),new Array('163','14','白山'),new Array('164','25','芜湖'),new Array('165','12','哈尔滨'),
			new Array('166','30','金华'),new Array('167','15','金坛'),new Array('168','15','南通'),new Array('169','28','阿勒泰'),new Array('170','21','德州'),new Array('171','16','南昌'),
			new Array('172','15','淮安'),new Array('173','5','肇庆'),new Array('174','11','焦作'),new Array('175','4','庆阳'),new Array('176','3','宁德'),new Array('177','30','湖州'),
			new Array('178','20','海北州'),new Array('179','24','西昌'),new Array('180','15','常熟'),new Array('181','3','厦门'),new Array('182','16','鹰潭'),new Array('183','11','商丘'),
			new Array('184','12','齐齐哈尔'),new Array('185','12','伊春'),new Array('186','15','淮阴'),new Array('187','15','宜兴'),new Array('188','11','郑州'),new Array('189','9','恩施'),
			new Array('190','4','武威'),new Array('191','30','温州'),new Array('192','5','三水'),new Array('193','5','汕尾'),new Array('194','7','安顺'),new Array('195','29','德宏'),
			new Array('196','24','绵阳'),new Array('197','6','玉林'),new Array('198','15','扬州'),new Array('199','15','无锡'),new Array('200','18','乌海'),new Array('201','11','南阳'),
			new Array('202','11','濮阳'),new Array('203','23','宝鸡'),new Array('204','3','龙岩'),new Array('205','21','东营'),new Array('206','22','太原'),new Array('207','17','辽阳'),
			new Array('208','10','沧州'),new Array('209','13','湘西'),new Array('210','21','日照'),new Array('211','28','昌吉'),new Array('212','12','牡丹江'),new Array('213','24','眉山'),
			new Array('214','12','佳木斯'),new Array('215','27','林芝'),new Array('216','5','高明'),new Array('217','10','保定'),new Array('218','5','增城'),new Array('219','20','海南州'),
			new Array('220','20','海南'),new Array('221','21','烟台'),new Array('222','29','丽江'),new Array('223','27','阿里'),new Array('224','29','文山'),new Array('225','28','奎屯'),
			new Array('226','21','淄博'),new Array('227','29','曲靖'),new Array('228','21','枣庄'),new Array('229','5','惠州'),new Array('230','24','攀枝花'),new Array('231','27','山南'),
			new Array('232','17','丹东'),new Array('233','16','宜春'),new Array('234','28','乌鲁木齐'),new Array('235','18','临河'),new Array('236','10','邯郸'),new Array('237','10','唐山'),
			new Array('238','18','锡林郭勒盟'),new Array('239','20','格尔木市'),new Array('240','24','雅安'),new Array('241','14','延边'),new Array('242','18','乌兰察布盟'),new Array('243','14','延吉'),
			new Array('244','15','泰州'),new Array('245','14','辽源'),new Array('246','29','大理'),new Array('247','15','江阴'),new Array('248','21','菏泽'),new Array('249','20','玉树'),
			new Array('250','13','永州'),new Array('251','5','顺德'),new Array('252','20','果洛'),new Array('253','4','定西'),new Array('254','10','张家口'),new Array('255','22','临汾'),
			new Array('256','30','杭州'),new Array('257','18','伊克昭盟'),new Array('258','18','集宁'),new Array('259','24','康定'),new Array('260','22','忻州'),new Array('261','29','昭通'),
			new Array('262','9','荆门'),new Array('263','16','吉安'),new Array('264','11','驻马店'),new Array('265','25','池州'),new Array('266','15','常州'),new Array('267','25','六安'),
			new Array('268','9','荆州'),new Array('269','14','长春'),new Array('270','31','万县'),new Array('271','9','仙桃'),new Array('272','31','涪陵'),new Array('273','18','包头'),
			new Array('274','20','黄南'),new Array('275','28','克孜勒苏柯尔克孜'),new Array('276','21','泰安'),new Array('277','13','衡阳'),new Array('278','17','抚顺'),new Array('279','25','黄山'),
			new Array('280','24','凉山'),new Array('281','23','咸阳'),new Array('282','9','潜江'),new Array('283','12','鹤岗'),new Array('284','8','海口'),new Array('285','22','大同'),
			new Array('286','14','白城'),new Array('287','16','新余'),new Array('288','23','商洛'),new Array('289','5','花都'),new Array('290','29','楚雄'),new Array('291','15','南京'),
			new Array('292','11','许昌'),new Array('293','15','宿迁'),new Array('294','12','鸡西'),new Array('295','18','呼和浩特'),new Array('296','17','大连'),new Array('297','28','伊犁哈萨克'),
			new Array('298','28','喀什'),new Array('299','29','保山'),new Array('300','5','韶关'),new Array('301','17','本溪'),new Array('302','13','常德'),new Array('303','17','沈阳'),
			new Array('304','18','呼伦贝尔'),new Array('305','14','松原'),new Array('306','28','石河子'),new Array('307','19','固原'),new Array('308','30','嘉兴'),new Array('309','11','周口'),
			new Array('310','29','怒江'),new Array('311','4','兰州'),new Array('402','31','万州'),new Array('404','19','吴忠'),new Array('405','25','蚌埠'),new Array('406','5','深圳'),
			new Array('407','18','兴安盟'),new Array('408','13','娄底'),new Array('409','18','巴彦淖尔盟'),new Array('410','7','铜仁'),new Array('411','16','抚州'),new Array('412','9','黄冈'),
			new Array('413','13','益阳'),new Array('414','15','徐州'),new Array('312','15','吴江'),new Array('403','28','巴音郭楞'),new Array('313','23','延安'),new Array('314','18','巴彦卓尔盟'),
			new Array('315','21','临沂'),new Array('316','7','黔西南州'),new Array('317','12','绥化'),new Array('318','5','南海'),new Array('319','6','防城港'),new Array('320','3','三明'),
			new Array('321','5','番禺'),new Array('322','20','海西'),new Array('323','15','通州'),new Array('324','20','海晏'),new Array('325','24','内江'),new Array('326','20','德令哈'),
			new Array('327','9','随州'),new Array('328','11','开封'),new Array('329','7','遵义'),new Array('330','31','重庆'));
	
	function showProvince(provinceid){
		var optprovince = "<select name='province_id' id='province_id' onchange='showCity(this.value)'>";
		for(i=0;i<arrprovince.length;i++){
			if(provinceid==arrprovince[i][0])
				optprovince += "<option value='"+arrprovince[i][0]+"' selected>"+arrprovince[i][1]+"</option>";
			else
				optprovince += "<option value='"+arrprovince[i][0]+"'>"+arrprovince[i][1]+"</option>";
		}
		optprovince += "</select>";
		document.getElementById("divprovince").innerHTML = optprovince;
		showCity(provinceid,'0');
	}

	function showCity(provinceid,city_id){
		var optcity = "<select name='city_id' id='city_id'>";
		for(i=0;i<arrcity.length;i++){
			if(provinceid==arrcity[i][1]){
				if(city_id==arrcity[i][0])
					optcity += "<option value='"+arrcity[i][0]+"' selected>"+arrcity[i][2]+"</option>";
				else
					optcity += "<option value='"+arrcity[i][0]+"'>"+arrcity[i][2]+"</option>";
			}
		}
		optcity += "</select>";
		document.getElementById("divcity").innerHTML = optcity;;
	}