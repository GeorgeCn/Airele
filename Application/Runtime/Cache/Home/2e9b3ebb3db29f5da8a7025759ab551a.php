<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>所有联系房东记录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
</head>
<body>
 <div class="citySelect"><!-- 城市切换 -->
		<select onchange="cutClick(this.options[this.selectedIndex].value)">
		   <?php if(is_array($switchcity)): $i = 0; $__LIST__ = $switchcity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['city_no'] == 1): ?><option value="1" selected="selected">上海</option><?php endif; ?>
			<?php if($vo['city_no'] == 2): ?><option value="2">北京</option><?php endif; ?>
			<?php if($vo['city_no'] == 3): ?><option value="3">杭州</option><?php endif; ?>
			<?php if($vo['city_no'] == 4): ?><option value="4">南京</option><?php endif; ?>
			<?php if($vo['city_no'] == 5): ?><option value="5">广州</option><?php endif; ?>
			<?php if($vo['city_no'] == 6): ?><option value="6">深圳</option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>

<script type="text/javascript">
	function cutClick(value){
		 if(value==1){
		    window.location.href="http://"+document.domain+"/admin/Welcome/welcome.html";
		 }else if(value==2){
		 	window.location.href="http://"+document.domain+"/adminbj/Welcome/welcome.html";
		 }else if(value==3){
		 	window.location.href="http://"+document.domain+"/adminhz/Welcome/welcome.html";
		 }else if(value==4){
		 	window.location.href="http://"+document.domain+"/adminnj/Welcome/welcome.html";
		 }else if(value==5){
		 	window.location.href="http://"+document.domain+"/admingz/Welcome/welcome.html";
		 }else if(value==6){
		 	window.location.href="http://"+document.domain+"/adminsz/Welcome/welcome.html";
		 }
	}
</script>
    <div class="title cf">
    	<div class="logo fl cf">
			<img src="/hizhu/Public/images/logo.png">
		</div>
		<ul class="cf fl">
		<li><a href="<?php echo U('Welcome/welcome');?>">首页</a></li>
			<?php echo ($menutophtml); ?>
		</ul>
		<div class="cf fr title_right">
			<a class="blue" href="javascript:;">欢迎您 <?php echo cookie("admin_user_name");?></a>
			<span>|</span>
			<a href="<?php echo U('/Index/outlogin');?>">退出</a>
		</div>
    </div>
	<div class="main">
		<div class="main_left subNavBox">
		<input type="hidden" id="hdnTemp" value="1">
			<div id="btn" style="position:fixed;top:40%;left:15%;margin-left:-25px;height:50px;width:25px;right:0;z-index:9999;"> 
				<a style="position:relative;width:100%;display:block;">
					<img style="width:100%;height:100%;;display:block;" src="/hizhu/Public/images/jt_l.png">
				</a>
			</div>
			<?php echo ($menulefthtml); ?>
		</div>
		<div class="main_right">
			<div class="common_head">
				<h2>联系房东记录查询</h2>
				<div class="common_head_main">
					<form action="<?php echo U('ContactOwner/contactOwnerList');?>" method="get">
					<input type="hidden" name="no" value="3">
					<input type="hidden" name="leftno" value="28">
					<input type="hidden" name="temp" value="q">
					<input type="hidden" name="pagecnt" value="<?php echo ($pagecnt); ?>">
					<input type="hidden" name="roomcnt" value="<?php echo ($roomcnt); ?>">
					<input type="hidden" name="ownercnt" value="<?php echo ($ownercnt); ?>">
					<input type="hidden" name="rentercnt" value="<?php echo ($rentercnt); ?>">
						<table class="table_one">
							<tr>
								<td class="td_title">拨打时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" value="<?php echo I('get.startTime'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime"  value="<?php echo I('get.endTime'); ?>"></td>
								<td class="td_title">租客手机号：</td>
								<td class="td_main"><input type="text" name="loginphone" value="<?php echo I('get.loginphone'); ?>"></td>
								<td class="td_title">房间编号：</td>
								<td class="td_main"><input type="text" name="room_no" value="<?php echo I('get.room_no'); ?>"></td>
							</tr>
							<tr>
								<td class="td_title">房东手机号：</td>
								<td class="td_main"><input type="text" name="ownerphone" value="<?php echo I('get.ownerphone'); ?>"></td>
								<td class="td_title">拨打人员</td>
								<td class="td_main">
									<select name="makcall" id="js_makcall">
									   <option value="">全部人员</option>
									   <option value="0">外部人员</option>
									   <option value="1">内部人员</option>
									</select>
								</td>
								<td class="td_title">来源平台：</td>
								<td class="td_main">
									<select name="platform" id="js_platform">
									   <option value="">全部</option>
									   <option value="6">h5</option>
									   <option value="1">android</option>
									   <option value="2">iphone</option>
									   <option value="3">400系统</option>
									   <option value="8">小程序</option>
									   <option value="9">百度推广</option>
									   <option value="0">微信</option>
									   <option value="10">hi租房pro</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">400号码：</td>
								<td class="td_main"><input type="text" name="big_code" value="<?php echo I('get.big_code'); ?>"></td>
								<td class="td_title">电话状态：</td>
								<td class="td_main">
									<select name="status_code" id="js_statuscode">
									   <option value="">全部</option>
										<?php echo ($statusCodeList); ?>
									</select>
								</td>
								<td class="td_title">来源：</td>
								<td class="td_main">
								     <select name="info_resource_type" style="width:110px;">
								     	<?php echo ($infoResourceTypeList); ?>
								     </select>
								     <select name="info_resource" style="width:110px;">
								     	<option value=""></option>
								     	<?php echo ($infoResourceList); ?>
								     </select>
							    </td>
							</tr>
							<tr>
								<td class="td_title">筛选：</td>
								<td class="td_main">
									<label>不包含未知<input type="checkbox" id="jsunknown" name="unknown" checked="checked"></label>&nbsp;&nbsp; <label>不包含客户主动放弃<input type="checkbox" id="jsabandon" name="abandon" checked="checked"></label> 
								</td>
								<td class="td_title">房源负责人：</td>
								<td class="td_main">
									<input type="text" name="charge_man" value="<?php echo I('get.charge_man'); ?>">
									 
								</td>
								<td class="td_title">品牌公寓：</td>
								<td class="td_main">
									<select id="brand_type" name="brand_type">
										<option value="">全部</option>
										<?php echo ($brandTypeList); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">区域&板块：</td>
								<td class="td_main">
									<select id="ddl_region" name="region" style="width:100px">
										<option value=""></option>
										<?php echo ($regionList); ?>
									</select>
									<select id="ddl_scope" name="scope" style="width:120px">
										<?php echo ($scopeList); ?>
									</select>
								</td>
								<td class="td_title">是否有佣金：</td>
								<td class="td_main">
									<select id="is_commission" name="is_commission">
										<option value="">全部</option><option value="1">是</option><option value="2">否</option>
									</select>
								</td>
								<td class="td_title">房东负责人：</td>
								<td class="td_main"><input type="text" name="principal_man" value="<?php echo I('get.principal_man'); ?>"></td>
							</tr>
							<tr>
								<td class="td_title">租金：</td>
								<td class="td_main">
									<input type="tel" name="moneyMin" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMin');?>">~
									<input type="tel" name="moneyMax" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMax');?>">
								</td>
								<td class="td_title">房间类型：</td>
								<td class="td_main">
									<select id="room_type" name="room_type">
										<option value="">全部</option>
										<option value="1">合租</option>
										<option value="2">整租</option>
									</select> 
								</td>
								<td class="td_title">户型（室）：</td>
								<td class="td_main">
									<select id="room_num" name="room_num">
										<option value="">全部</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="2+">2室及以上</option>
										<option value="3+">3室及以上</option>
									</select> 
								</td>
							</tr>
							<tr>
								<td class="td_title">是否包月：</td>
								<td class="td_main">
									<select name="is_monthly">
										<option value="">全部</option>
										<option value="1" <?php if(I('get.is_monthly')==1)echo 'selected'; ?>>是</option>
										<option value="2" <?php if(I('get.is_monthly')==2)echo 'selected'; ?>>否</option>
									</select>
								</td>
								<td class="td_title">是否中介:</td>
								<td class="td_main">
									<select name="is_owner">
										<option value="">全部</option>
										<option value="5" <?php if(I('get.is_owner')==5)echo 'selected'; ?>>是</option>
										<option value="999" <?php if(I('get.is_owner')==999)echo 'selected'; ?>>否</option>
									</select>
								</td>
								<td class="td_title">中介公司:</td>
								<td class="td_main">
									<select name="agentCompany">
										<option value="">全部</option>
										<?php echo ($agentCompanyList); ?>
									</select>
								</td>
							</tr>
						</table>
						
					</form>
					<p class="head_p">点击搜索出来数据&nbsp;<button class="btn_a" id="btn_search">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>联系房东记录列表 <a href="#" class="btn_a" id="download">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th><th>区域</th><th>板块</th>
								<th>小区名称</th><th>房间类型</th><th>几室</th>
								<th>房间编号</th>
								<th>租金</th>
								<th>房间来源</th>
								<th>是否有佣金</th>
								<th>租客手机</th>
								<th>400号码</th><th>小号</th><th>中介公司</th>
								<th>房东手机</th>
								<th>房东姓名</th>
								<th>电话来源</th>
								<th>房源负责人</th><th>房东负责人</th>
								<th>电话状态</th>
								<th>主叫时长(秒)</th><th>被叫时长(秒)</th>
								<th>录音</th>
								<th>拨打时间</th><th>是否包月</th>
								<th>是否中介录音</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td><td><?php echo ($vo["region_name"]); ?></td><td><?php echo ($vo["scope_name"]); ?></td>
								<td><?php echo ($vo["estate_name"]); ?></td>
								<td><?php switch($vo["room_type"]): case "1": ?>合租<?php break; case "2": ?>整租<?php break; endswitch;?></td>
								<td><?php if(($vo["room_num"]) > "-1"): echo ($vo["room_num"]); endif; ?></td>
								<td><?php if(($vo["rooms_id"] == '')): echo ($vo["room_id"]); else: ?>
								<a href="/hizhu/HouseRoom/modifyroom?no=3&leftno=44&room_id=<?php echo ($vo["rooms_id"]); ?>&handle=search" target="_blank"><?php echo ($vo["room_id"]); ?></a><?php endif; ?>
									</td>
								<td><?php if(($vo["room_money"]) > "0"): echo ($vo["room_money"]); endif; ?></td>
								<td><?php echo ($vo["info_resource"]); ?></td>
								<td><?php switch($vo["is_commission"]): case "1": ?>是<?php break; case "2": ?>否<?php break; endswitch;?></td>
								<td><?php echo ($vo["mobile"]); ?></td>
								<td><?php echo ($vo["big_code"]); ?></td>
								<td><?php echo ($vo["ext_code"]); ?></td><td><?php echo ($vo["agent_company_name"]); ?></td>
								<td><?php echo ($vo["owner_mobile"]); ?></td>
								<td><?php echo ($vo["owner_name"]); ?></td>
								<td data-v="<?php echo ($vo["gaodu_platform"]); ?>"></td>
								<td><?php echo ($vo["charge_man"]); ?></td><td><?php echo ($vo["principal_man"]); ?></td>
								<td data-v="<?php echo ($vo["status_code"]); ?>"></td>
								<td><?php echo ($vo['caller_length']); ?></td>
								<td><?php echo ($vo['called_length']); ?></td>
								<?php if(strtoupper($vo['source']) == '10'): ?><td><?php if($vo['status_code']==0&&$vo['is_down']==1){?><audio  controls="controls" preload="none" style="width:42px;height:30px;"  src="<?php echo C('CALL_RECORD_URL');?>/virtual/<?php echo substr($vo['call_id'],0,2);?>/<?php echo substr($vo['call_id'],2,2);?>/<?php echo $vo['call_id']?>.mp3"/>请升级浏览器版本</audio><?php }else{if(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']>=20){echo'<a href="javascript:;" onclick="virtualanewdowload(\''.$vo['call_id'].'\',this)">重新下载</a>';}elseif(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']<20){echo"等待下载";}}?></td>
								<?php else: ?>	
								  <td><?php if($vo['status_code']==0&&$vo['is_down']==1){?><audio  controls="controls" preload="none" style="width:42px;height:30px;"  src="<?php echo C('CALL_RECORD_URL');?>/<?php echo $vo['call_id']?>.mp3"/>请升级浏览器版本</audio><?php }else{if(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']>=20){echo'<a href="javascript:;" onclick="anewdowload(\''.$vo['call_id'].'\',this)">重新下载</a>';}elseif(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']<20){echo"等待下载";}}?></td><?php endif; ?>
								<td><?php if(($vo["call_time"]) > "0"): echo (date("Y-m-d H:i",$vo['call_time'])); endif; ?></td>
								<td><?php switch($vo["is_monthly"]): case "1": ?>是<?php break; case "2": ?>否<?php break; endswitch;?></td>
								<td><?php if(strtoupper($vo['is_owner']) == '5'): ?>是<?php else: ?>否<?php endif; ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecnt); ?>条记录，每页8条。共租客<?php echo ($rentercnt); ?>，房东<?php echo ($ownercnt); ?>，房间数<?php echo ($roomcnt); ?></p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
	<script type="text/javascript">

	$('.inpt_a').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$("#brand_type").val("<?php echo I('get.brand_type'); ?>");
	$("#js_platform").val("<?php echo I('get.platform'); ?>");
	$("#js_makcall").val("<?php echo I('get.makcall'); ?>");
	$("#create_man").val("<?php echo I('get.charge_man'); ?>");
	$("#ddl_region").val("<?php echo I('get.region'); ?>");
	$("#ddl_scope").val("<?php echo I('get.scope'); ?>");
	$("#js_statuscode").val("<?php echo I('get.status_code'); ?>");
	$("#is_commission").val("<?php echo I('get.is_commission'); ?>");
$("#room_type").val('<?php echo I("get.room_type"); ?>');
$("#room_num").val('<?php echo I("get.room_num"); ?>');
$("select[name='info_resource_type']").val('<?php echo I("get.info_resource_type"); ?>');
$("select[name='info_resource']").val('<?php echo I("get.info_resource"); ?>');
$("select[name='agentCompany']").val('<?php echo I("get.agentCompany"); ?>');
	var unknown="<?php echo I('get.unknown'); ?>";
	var abandon="<?php echo I('get.abandon'); ?>";
	var q="<?php echo I('get.temp'); ?>";
	if((q=='q' && unknown=='') || unknown=='0'){
		$('#jsunknown').removeAttr('checked');
	}
	if((q=='q' && abandon=='') || abandon=='0'){
		$('#jsabandon').removeAttr('checked');
	}

	/*键值转换*/
	$("#dataDiv table tbody tr").each(function(){
		var td_object=$(this).children("td:eq(19)");
		var status_code=td_object.attr('data-v');
		if(status_code!=''){
			var b_type_name=$("#js_statuscode option[value="+status_code+"]").text();
			td_object.text(b_type_name);
		}
		//来源
		var td_plat=$(this).children("td:eq(16)");
		var td_plat_name=$("#js_platform option[value="+td_plat.attr('data-v')+"]").text();
		td_plat.text(td_plat_name);

	});
	$("#btn_search").click(function(){
		$(this).unbind('click').text('搜索中');
		$("form").submit();
	});
	//下载
	$("#download").click(function(){
		var start_date=$("input[name='startTime']").val();
		var end_date=$("input[name='endTime']").val();
		if(start_date=="" || end_date==""){
			alert("下载数据不能超过1个月！");return;
		}
		var start=new Date(start_date);
		start.setDate(start.getDate()+30);
		var end=new Date(end_date);
		if(end-start>0){
			alert("下载数据不能超过1个月！");return;
		}
		window.location.href="/hizhu/ContactOwner/downAllContact.html?<?php echo $_SERVER['QUERY_STRING'];?>";
	});
	function anewdowload(callid,obj){
	     if(callid!=""){
	        $.get("/hizhu/ContactOwner/anewdowload.html",{callid:callid},function(data){
			     $(obj).parent().html('等待下载');
			});
			//location.reload();
	    }
	} 
//虚拟号录音
	function virtualanewdowload(callid,obj){
	     if(callid!=""){
	        $.get("/hizhu/ContactOwner/virtualanewdowload.html",{callid:callid},function(data){
			     $(obj).parent().html('等待下载');
			});
			//location.reload();
	    }
	} 
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseRoom/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});
	//下拉联动，来源
	$("select[name='info_resource_type']").change(function(){
		if($(this).val()==""){
			$("select[name='info_resource']").html("");
			return;
		}
		$.get("/hizhu/HouseResource/getInforesourceByType",{type:$(this).val()},function(data){
			$("select[name='info_resource']").html('<option value=""></option>'+data);
		},"html");
	});
	
   </script>

</body>
</html>