<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>已听录音</title>
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
				<h2>已听录音查询</h2>
				<div class="common_head_main">
					<form action="<?php echo U('ContactOwner/thearlist');?>" method="get">
					<input type="hidden" name="no" value="3">
					<input type="hidden" name="leftno" value="98">
					<input type="hidden" name="pagecnt" value="<?php echo ($pagecnt); ?>">
						<table class="table_one">
							<tr>
								<td class="td_title">拨打时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" value="<?php echo I('get.startTime'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo I('get.endTime'); ?>"></td>
								<td class="td_title">租客手机号：</td>
								<td class="td_main"><input type="text" name="loginphone" value="<?php echo I('get.loginphone'); ?>"></td>
								<td class="td_title">房东手机号：</td>
								<td class="td_main"><input type="text" name="ownerphone" value="<?php echo I('get.ownerphone'); ?>"></td>
							</tr>
							<tr>
								<td class="td_title">房源负责人：</td>
								<td class="td_main"><input type="text" name="charge_man" value="<?php echo I('get.charge_man'); ?>"></td>
								<td class="td_title">品牌公寓：</td>
								<td class="td_main">
									<select id="brand_type" name="brand_type">
										<option value="">全部</option>
										<?php echo ($brandTypeList); ?>
									</select></td>
								<td class="td_title">来源平台：</td>
								<td class="td_main">
									<select name="platform" id="js_platform">
									   <option value="">全部</option>
									   <option value="6">h5</option>
									   <option value="1">android</option>
									   <option value="2">iphone</option>
									   <option value="3">400系统</option>
										<option value="8">小程序</option>
									</select>
								</td>
							</tr>
							<tr>
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
							    <td class="td_title">拨打人员：</td>
								<td class="td_main">
									<select name="makcall" id="js_makcall">
									   <option value="">全部人员</option>
									   <option value="0">外部人员</option>
									   <option value="1">内部人员</option>
									</select>
								</td>
								<td class="td_title">操作人：</td>
								<td class="td_main"><input type="text" name="handleman" value="<?php echo I('get.handleman'); ?>"></td>
							</tr>
							<tr>
								<td class="td_title">是否中介:</td>
								<td class="td_main">
								   <select name="is_owner">
										<option value="">全部</option>
										<option value="5" <?php if(I('get.is_owner')==5)echo 'selected'; ?>>是</option>
										<option value="999" <?php if(I('get.is_owner')==999)echo 'selected'; ?>>否</option>
									</select>
							    </td>
							    <td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
							
						</table>
						<p class="head_p"><button class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>已听录音列表<a href="#" onclick="downloadData()" class="btn_a">下载</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房间编号</th>
								<th>来源</th><th>是否有佣金</th>
								<th>租客手机</th>
								<th>房东手机</th>
								<th>房东姓名</th>
								<th>房源负责人</th>
								<th>电话状态</th>
								<th>被叫时长(秒)</th>
								<th>拨打时间</th>
								<th>录音</th>
								<th>操作人</th>
								<th>操作时间</th>
								<th>录音内容</th>
								<th>是否中介录音</th>
							</tr>
						</thead>
						<tbody>
							  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo["room_id"]); ?></td>
								<td><?php echo ($vo["info_resource"]); ?></td><td><?php switch($vo["is_commission"]): case "1": ?>是<?php break; case "2": ?>否<?php break; endswitch;?></td>
								<td><?php echo ($vo["mobile"]); ?></td>
								<td><?php echo ($vo["owner_mobile"]); ?></td>
								<td><?php echo ($vo["owner_name"]); ?></td>
								<td><?php echo ($vo["charge_man"]); ?></td>
								<td>成功</td>
								<td><?php echo ($vo['called_length']); ?></td>
								<td><?php if(($vo["call_time"]) > "0"): echo (date("Y-m-d H:i",$vo['call_time'])); endif; ?></td>
								<?php if(strtoupper($vo['source']) == '10'): ?><td><audio  controls="controls" preload="none"  style="width:42px;height:30px;"  src="<?php echo C('CALL_RECORD_URL');?>/virtual/<?php echo substr($vo['call_id'],0,2);?>/<?php echo substr($vo['call_id'],2,2);?>/<?php echo $vo['call_id']?>.mp3"/>请升级浏览器版本</audio></td>
								<?php else: ?>
								   <td><audio  controls="controls" preload="none"  style="width:42px;height:30px;"  src="<?php echo C('CALL_RECORD_URL');?>/<?php echo $vo['call_id']?>.mp3"/>请升级浏览器版本</audio></td><?php endif; ?>
								<td><?php echo ($vo['updata_man']); ?></td>
								<td><?php if(($vo["update_time"]) > "0"): echo (date("Y-m-d H:i",$vo['update_time'])); endif; ?></td>
								<td><?php echo ($vo['memo']); ?></td>
								<td><?php if(strtoupper($vo['is_owner']) == '5'): ?>是<?php else: ?>否<?php endif; ?></td>
								<input name="room_id" type="hidden" value="<?php echo ($vo['room_id']); ?>">
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecnt); ?>条记录，每页8条</p>
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
   $('.inpt_a').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});

   $("#brand_type").val("<?php echo I('get.brand_type'); ?>");
   $("#js_platform").val("<?php echo I('get.platform'); ?>");
   $("#js_makcall").val("<?php echo I('get.makcall'); ?>");
   $("select[name='info_resource_type']").val('<?php echo I("get.info_resource_type"); ?>');
$("select[name='info_resource']").val('<?php echo I("get.info_resource"); ?>');
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
   function downloadData(){
   		var start_date=$("input[name='startTime']").val();
   		var end_date=$("input[name='endTime']").val();
   		if(start_date=="" || end_date==""){
   			alert("下载数据不能超过一个月！");return;
   		}
   		var start=new Date(start_date);
   		start.setMonth(start.getMonth()+1);
   		var end=new Date(end_date);
   		if(end-start>0){
   			alert("下载数据不能超过一个月！");return;
   		}
   		window.location.href="/hizhu/ContactOwner/dowthearlist.html?<?php echo $_SERVER['QUERY_STRING'];?>";
   }
   </script>
</body>
</html>