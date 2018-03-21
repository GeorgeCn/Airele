<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>短链推送</title>
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
				<h2>查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/PushSms/pushshorthistory" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="130">
						<input type="hidden" name="totalcnt" value="<?php echo ($totalcnt); ?>">
						<table class="table_one">
							<tr>
								<td class="td_title">联系时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime"  value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:''; ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:''; ?>"></td>
								<td class="td_title">租客电话：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo isset($_GET['mobile'])?$_GET['mobile']:''; ?>"></td>
								<td class="td_title">处理人：</td>
								<td class="td_main"><input type="text" name="handle_man" value="<?php echo isset($_GET['handle_man'])?$_GET['handle_man']:''; ?>"></td>
							</tr>
							<tr>
								<td class="td_title">城市：</td>
								<td class="td_main"><select id="city_id" name="city_id">
										<option value=""></option>
										<option value="1009001">上海</option>
										<option value="1001">北京</option>
										<option value="1011001">杭州</option>
										<option value="001010001">南京</option>
										<option value="001019001">广州</option>
										<option value="001019002">深圳</option>
									</select></td>
								<td class="td_title">推送状态：</td>
								<td class="td_main"><select id="status" name="status">
										<option value=""></option>
										<option value="0">未推送</option>
										<option value="1">已推送</option>
									</select></td>
								<td class="td_title">租客来源：</td>
								<td class="td_main">
									<select name="rentsource">
										<option value=""></option>
										<option value="1">58端口</option>
										<option value="2">58品牌馆</option>
										<option value="3">搜房</option>
										<option value="4">365淘房</option>
										<option value="5">app拨打失败</option>
										<option value="6">安居客</option>
										<option value="8">其他</option>
									</select>
								</td>
							</tr>
							
						</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表<a href="#" class="btn_a" id="btn_add">新增</a>&nbsp;<a style="margin-left:100px;" href="/hizhu/PushSms/downloadShorturl?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>城市</th><th>租客来源</th>
								<th>租客电话</th>
								<th>联系时间</th>
								<!-- <th>联系电话</th> -->
								<th>区域板块</th>
								<th>价格</th>
								<th>房东电话</th>
								<th>处理人</th>
								<th>推送状态</th>
								<th>推送短链</th>
								<th>是否付费</th>
								<!-- <th>操作</th>
								<th>删除</th> -->
							</tr>
						</thead>
						<tbody>
							<?php $ident_num=1; ?>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo $ident_num++; ?></td>
								<td><?php switch($vo["city_id"]): case "1009001": ?>上海<?php break; case "1001": ?>北京<?php break; case "1011001": ?>杭州<?php break; case "1010001": ?>南京<?php break; case "001019001": ?>广州<?php break; case "001019002": ?>深圳<?php break; endswitch;?></td>
								<td><?php switch($vo["renter_source"]): case "1": ?>58端口<?php break; case "2": ?>58品牌馆<?php break; case "3": ?>搜房<?php break;?>
								<?php case "4": ?>365淘房<?php break; case "5": ?>app拨打失败<?php break; case "6": ?>安居客<?php break; case "8": ?>其他<?php break; endswitch;?></td>
								<td><?php echo ($vo["renter_phone"]); ?></td>
								<td><?php if(($vo["contact_time"]) > "0"): echo (date("Y-m-d H:i",$vo["contact_time"])); endif; ?></td>
								<!-- <td><?php echo ($vo["contact_phone"]); ?></td> -->
								<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
								<td><?php echo ($vo["room_money"]); ?></td>
								<td><?php echo ($vo["client_phone"]); ?></td>
								<td><?php echo ($vo["update_man"]); ?></td>
								<td><?php switch($vo["push_status"]): case "0": ?>未推送<?php break; case "1": ?>已推送<?php break; endswitch;?></td>
								<td><?php if(stripos($vo['short_url'], 'http')===0){ ?>
									<a href="<?php echo ($vo["short_url"]); ?>" target="_blank"><?php echo ($vo["short_url"]); ?></a>
								<?php }else{ ?>
									<a href="http://<?php echo ($vo["short_url"]); ?>" target="_blank"><?php echo ($vo["short_url"]); ?></a>
								<?php } ?>
									
								</td>
								<td style="width:200px;word-wrap:break-word;word-break:break-all;"><?php echo ($vo["bak_content"]); ?></td>
								<!-- <td><a href="#" onclick="startHandle('<?php echo ($vo["id"]); ?>',this)"><?php switch($vo["push_status"]): case "0": ?>开始处理<?php break; case "1": ?>重新处理<?php break; endswitch;?></a></td>
								<td><a href="#" onclick="removeData('<?php echo ($vo["id"]); ?>',this)">删除</a></td> -->
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<span style="color:red;"><?php echo ($totalcnt); ?></span>条记录</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="dialogAdd" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:400px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-235px;border-radius:10px;">
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">短信模版：</label>
				<select id="moduleType" style="width:420px;height:36px;">
					<option value="1">【嗨住网】您咨询房源的房东电话是#mobile#，房源具体信息可点击#link#查看，查看更多无中介费房源请下载嗨住app</option>
					<option value="3">【嗨住网】您咨询房源的管家电话是#mobile#，房源具体信息可点击#link#查看，查看更多无中介费房源请下载嗨住app</option>
					<option value="2"<?php if(C('CITY_CODE')=='001011001'){echo 'selected';} ?>>【嗨住网】根据您的租房需求，本房源可供您参考：房东电话是#mobile#，房源具体信息可点击#link#查看，查看更多无中介费房源请下载嗨住app</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">租客手机：</label>
				<input type="text" class="fl" id="renterMoblie" style="width:200px;height:36px;" maxlength="11">
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">租客来源：</label>
				<select id="rentsource" style="width:120px;height:36px;">
					<option value="">=请选择=</option>
					<option value="1">58端口</option>
					<option value="2">58品牌馆</option>
					<option value="3">搜房</option>
					<option value="4">365淘房</option>
					<option value="5">app拨打失败</option>
					<option value="6">安居客</option>
					<option value="8">其他</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">房间编号：</label>
				<textarea class="fl" id="roomnos" style="width:420px;height:76px;resize:none;" placeholder="多个编号请用逗号分割"></textarea>
			</div> 
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;">取消</button>
				<button class="btn_a" id="btn_submitadd">提交</button>
			</div>
		</div>
	</div>
	
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
	
	$("#city_id").val('<?php echo isset($_GET["city_id"])?$_GET["city_id"]:""; ?>');
	$("#status").val('<?php echo isset($_GET["status"])?$_GET["status"]:""; ?>');
	$("select[name='rentsource']").val('<?php echo I("get.rentsource"); ?>');

	$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});

	$("#btnSearch").click(function(){
		$(this).unbind('click').text('搜索中');
		$("#searchForm").submit();
	});

	function removeData(pid,obj){
		if(confirm('确定删除吗？')){
			$.get('/hizhu/PushSms/removeShorturl?pid='+pid,function(data){
				alert(data);
				$(obj).parent().parent().remove();
			});
		}
	}
	//add
	$("#btn_add").click(function(){
		$("#renterMoblie").val('');
		$("#rentsource").val('');
		$("#roomnos").val('');
		$("#dialogAdd").show();
	});
	$(".btn_b").click(function(){
		$("#dialogAdd").hide();
	});
	$("#btn_submitadd").click(function(){
		addMessage();
	});
	function addMessage(){
		var regPhone=/^1[34578]\d{9}$/;
		if(!regPhone.test($("#renterMoblie").val())){
			alert("请输入有效的租客手机");return;
		}
		var rentsource=$("#rentsource").val().replace(/\s+/g,'');
		if(rentsource==''){
			alert("请选择租客来源");return;
		}
		var roomnos=$("#roomnos").val().replace(/\s+/g,'');
		if(roomnos==''){
			alert("请输入房间编号");return;
		}
		$("#btn_submitadd").unbind('click').text('提交中');
		$.post('/hizhu/PushSms/addShorturl',{renter_source:rentsource,room_no:roomnos,renter_phone:$("#renterMoblie").val(),moduleType:$("#moduleType").val()},function(data){
			alert(data.message);
			$("#dialogAdd").hide();
			$("#btn_submitadd").bind('click',function(){
				addMessage();
			}).text('提交');
		},'json');
	}
</script>
</html>