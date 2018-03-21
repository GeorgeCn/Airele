<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>佣金管理</title>
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
				<h2>搜索条件</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Commission/commissionlist" method="get">
						<input type="hidden" name="no" value="107">
						<input type="hidden" name="leftno" value="109">
						<input type="hidden" id="jump" name="p">
						<table class="table_one">
							<tr>
								<td class="td_title">房间编号：</td>
								<td class="td_main"><input type="text" name="room_no" value="<?php echo isset($_GET['room_no'])?$_GET['room_no']:'' ?>"></td>
								<td class="td_title">小区名称：</td>
								<td class="td_main"><input type="text" name="estate_name" value="<?php echo isset($_GET['estate_name'])?$_GET['estate_name']:'' ?>"></td>
								<td class="td_title">是否扣佣：</td>
								<td class="td_main">
									<select id="is_online" name="is_online">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">结算方式：</td>
								<td class="td_main">
									<select id="settlement_method" name="settlement_method">
										<option value=""></option>
										<option value="1">次结</option>
										<option value="2">月结</option>
									</select></td>
								<td class="td_title">状态：</td>
								<td class="td_main">
									<select id="is_open" name="is_open">
										<option value=""></option>
										<option value="1">开启</option>
										<option value="0">停用</option>
									</select>
								</td>
								<td class="td_title">修改时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="updatetime_start" value="<?php echo isset($_GET['updatetime_start'])?$_GET['updatetime_start']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="updatetime_end" value="<?php echo isset($_GET['updatetime_end'])?$_GET['updatetime_end']:'' ?>"></td>
							</tr>
							<tr>
								<td class="td_title">房东姓名：</td>
								<td class="td_main"><input type="text" name="client_name" value="<?php echo isset($_GET['client_name'])?$_GET['client_name']:'' ?>"></td>
								<td class="td_title">房东手机：</td>
								<td class="td_main"><input type="text" name="client_phone" value="<?php echo isset($_GET['client_phone'])?$_GET['client_phone']:'' ?>"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" onclick="search()">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表展示<a href="/hizhu/Commission/commissionadd?no=107&leftno=109" class="btn_a">新增</a><a style="margin-left:100px;" href="/hizhu/Commission/downloadExcel?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>房间编号</th>
								<th>小区名称</th>
								<th>房东手机</th>
								<th>房东姓名</th>
								<th>房间状态</th>
								<th>租金</th>
								<th>合同时长</th>
								<th>状态</th>
								<th>创建人</th>
								<th>创建时间</th>
								<th>修改人</th>
								<th>修改时间</th>
								<th>查看</th>
								<th>停用</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td>
								<?php switch($vo["city_code"]): case "001009001": ?><a href="http://www.hizhu.com/shanghai/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank"><?php echo ($vo["room_no"]); ?></a><?php break;?>
									<?php case "001001": ?><a href="http://www.hizhu.com/beijing/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank"><?php echo ($vo["room_no"]); ?></a><?php break;?>
									<?php case "001011001": ?><a href="http://www.hizhu.com/hangzhou/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank"><?php echo ($vo["room_no"]); ?></a><?php break;?>
									<?php case "001010001": ?><a href="http://www.hizhu.com/nanjing/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank"><?php echo ($vo["room_no"]); ?></a><?php break;?>
									<?php case "001019002": ?><a href="http://www.hizhu.com/shenzhen/roomDetail/<?php echo ($vo["room_id"]); ?>.html" target="_blank"><?php echo ($vo["room_no"]); ?></a><?php break;?>
									<?php default: echo ($vo["room_no"]); endswitch;?>
								</td>
								<td><?php echo ($vo["estate_name"]); ?></td>
								<td><?php echo ($vo["client_phone"]); ?></td>
								<td><?php echo ($vo["client_name"]); ?></td>
								<td><?php switch($vo["room_status"]): case "0": ?>待审核<?php break; case "1": ?>审核不通过<?php break; case "2": ?>未入住<?php break; case "3": ?>已出租<?php break; case "4": ?>待维护<?php break; endswitch;?></td>
								<td><?php echo ($vo["room_money"]); ?></td>
								<td><?php if(($vo["contracttime_start"]) > "0"): echo ($vo["contracttime_start"]); endif; ?>~<?php if(($vo["contracttime_end"]) < "99"): echo ($vo["contracttime_end"]); endif; ?></td>
								
								<td><?php if(($vo["is_open"] == 1)): ?>启用<?php else: ?>停用<?php endif; ?></td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
								<td><?php echo ($vo["update_man"]); ?></td>
								<td><?php if(($vo["update_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["update_time"])); endif; ?></td>
								
								<td><a href="/hizhu/Commission/commissionedit?no=107&leftno=109&pid=<?php echo ($vo["id"]); ?>">查看</a></td>
								<td><?php if(($vo["is_open"]) == "1"): ?><a href="#" onclick="stopdown(<?php echo ($vo["id"]); ?>)">停用</a><?php endif; ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalCount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>&nbsp;<input type="text" style="width:50px" maxlength="4" id="jumpPage" name="jumpPage">&nbsp;<button onclick="jump()">跳转</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$('#is_online').val("<?php echo isset($_GET['is_online'])?$_GET['is_online']:'' ?>");
$('#is_open').val("<?php echo isset($_GET['is_open'])?$_GET['is_open']:'' ?>");
$('#settlement_method').val("<?php echo isset($_GET['settlement_method'])?$_GET['settlement_method']:'' ?>");
/*$("#dataDiv table tbody tr").each(function(){
	var room_no=$(this).children("td:eq(0)").text();
	var obj_status=$(this).children("td:eq(4)");
	var obj_money=$(this).children("td:eq(5)");
	$.get('/hizhu/Commission/getRoominfoByRoomno?room_no='+room_no,function(data){
		obj_status.html(data.status);obj_money.html(data.money);
	},'json');
});*/
   $('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});
	function search(){
		$("#searchForm").submit();
	}
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	function stopdown(pid){
		if(confirm('停用后将不能启用，是否确定？')){
			$.get('/hizhu/Commission/stopCommission?id='+pid,function(data){
				alert(data.message);document.location.reload();
			},'json');
		}
	}
	
</script>

</html>