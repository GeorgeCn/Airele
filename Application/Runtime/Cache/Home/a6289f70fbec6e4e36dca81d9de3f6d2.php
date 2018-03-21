<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>成交列表</title>
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
			<a class="blue" href="javascript:">欢迎您 <?php echo cookie("admin_user_name");?></a>
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
				<form action="<?php echo U('Stores/feedBackReward');?>" method="get" id="searchForm">
						<input type="hidden" name="no" value="162">
						<input type="hidden" name="leftno" value="188">
					<table class="table_one">
						<tr>
							<td class="td_title">反馈日期：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
							<td class="td_title">反馈人手机号：</td>
							<td class="td_main"><input type="text" maxlength="11" name="feedbacker_mobile" value="<?php echo I('get.feedbacker_mobile');?>"></td>
							<td class="td_title">店铺名称：</td>
							<td class="td_main"><input type="text" name="store_name" value="<?php echo I('get.store_name');?>" placeholder=""></td>
						</tr>
						<tr>
							<td class="td_title">筛选城市：</td>
							<td class="td_main">
								<select name="city_code">
							        <option value="" <?php if($_GET['city_code']===""){echo "selected";}?>>全部</option>
							    	<option value="001009001" <?php if($_GET['city_code']=="001009001"){echo "selected";}?>>上海</option>
							    	<option value="001001" <?php if($_GET['city_code']=="001001"){echo "selected";}?>>北京</option>
							    	<option value="001011001" <?php if($_GET['city_code']=="001011001"){echo "selected";}?>>南京</option>
							    	<option value="001010001" <?php if($_GET['city_code']=="001010001"){echo "selected";}?>>杭州</option>
							    	<option value="001019002" <?php if($_GET['city_code']=="001019002"){echo "selected";}?>>深圳</option>
							    </select>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>	
					</table>
					</form>
					<p class="head_p"><button type="submit" class="btn_a" id="btn_search">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表</a>
				</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>店铺名称</th>
								<th>反馈人手机号</th>
								<th>成交金额</th>
								<th>城市</th>
								<th>房间编号</th>
								<th>反馈时间</th>
								<th>中奖话费</th>
								<th>真实成交</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><a href="<?php echo U('stores/storeDetail?no=162&leftno=188',array('id'=>$vo['store_id']));?>"><?php echo ($vo['store_name']); ?></a></td>
								<td><?php echo ($vo['feedbacker_mobile']); ?></td>
								<td><?php echo ($vo['renter_price']); ?></td>
								<td>
									<?php switch($vo['city_code']): case "001009001": ?>上海<?php break; case "001001": ?>北京<?php break; case "001011001": ?>南京<?php break; case "001010001": ?>杭州<?php break; case "001019002": ?>深圳<?php break; endswitch;?>
								</td>
								<td><?php echo ($vo['room_no']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td><?php echo ($vo['price']); ?></td>
								<td>是</td>
								<td>
									<?php if(($vo["is_send"] == '1')): ?><a href="javascript:;" style="color:black" onclick="IsSend('<?php echo ($vo['id']); ?>','<?php echo ($vo['feedbacker_id']); ?>','<?php echo ($vo[feedbacker_mobile]); ?>','<?php echo ($vo['price']); ?>',1);">充值短信</a>
									<?php elseif(($vo["is_send"] == '0')): ?><a href="javascript:;" onclick="IsSend('<?php echo ($vo['id']); ?>','<?php echo ($vo['feedbacker_id']); ?>','<?php echo ($vo[feedbacker_mobile]); ?>','<?php echo ($vo['price']); ?>',1);">充值短信</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="infoAdd" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:470px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-235px;border-radius:10px;">
			<div style="margin:20px;margin-top:150px" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">租客电话：</label>
				<input type="text" name="mobile" readonly class="fl" style="width:200px;height:36px;">
			</div>
			<div style="margin:20px;" class="cf">
				<input type="text" name="content" readonly class="fl" style="width:550px;height:36px;">
			</div>
			<div  style="text-align:center;margin-top:80px">
				<button class="btn_b" style="margin-right:50px;">取消</button>
				<button class="btn_a" id="btn_submit">发送充值成功短信</button>
			</div>
		</div>
	</div>

	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"}); 
	$("#btn_search").click(function(){
		$(this).unbind('click').text('搜索中..');
		$("#searchForm").submit();
	});
	function IsSend(id,customer_id,mobile,price,status) {
		$("input[name='mobile']").val(mobile);
		$("input[name='content']").val("【嗨住网】您在主动反馈获得的"+price+"元话费已为您充值成功，感谢您对嗨住的支持。");
		$("#infoAdd").show();
		$(".btn_b").click(function(){
			$("#infoAdd").hide();
		});
		$("#btn_submit").click(function(){
			$.ajax({
		            type:"post",
		            url: "<?php echo U('Stores/modifyHouseDealLottery');?>",
		            data:{"id":id,"customer_id":customer_id,"mobile":mobile,"price":price,"is_send":status},
		            dataType:'json',
		            success:function(data){
		            	if(data.code == 404) {
		            		alert(data.message);
		            		location.reload(true);
		            	}

			            if(data.code == 400) {
			            	alert(data.message);
			            	location.reload(true);
			            }
			            if(data.code == 200) {
			            	alert(data.message);
			            	location.reload(true);
			            }
		            },				
			    })
		});
	}
	</script>
</body>
</html>