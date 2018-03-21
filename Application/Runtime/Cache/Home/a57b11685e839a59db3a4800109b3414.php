<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>中介经纪人详情</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
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
			<div class="common_main">
				<!-- 个人信息 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">个人信息
				<a href="<?php echo U('AgentsManage/middlemansUpdate',array('id'=>$infoList['id']));?>" class="btn_a" style="margin-left:50px" target="_blank">编辑</a>
				</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>用户身份</th>
							<th>姓名</th>
							<th>手机号</th>
							<th>跟进状态</th>
							<th>中介负责人</th>
							<th>城市</th>
							<th>所属公司</th>
							<th>所属门店</th>
							<th>权益</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php switch($infoList["is_owner"]): case "0": ?>租客<?php break; case "3": ?>个人房东<?php break; case "4": ?>职业房东<?php break; case "5": ?>中介经纪人<?php break; endswitch;?>
							</td>
							<td><?php echo ($infoList['true_name']); ?></td>
							<td><?php echo ($infoList['mobile']); ?></td>
							<td>
								<?php switch($infoList["status"]): case "0": ?>待跟进<?php break;?>
										<?php case "3": ?>跟进中<?php break;?>
										<?php case "5": ?>不合作<?php break;?>
										<?php case "2": ?>已签约<?php break;?>、
										<?php case "4": ?>职业房东<?php break;?>
										<?php default: ?>空<?php endswitch;?>
							</td>
							<td><?php echo ($infoList['principal_man']); ?></td>
							<td>
								<?php switch($infoList["city_code"]): case "001009001": ?>上海<?php break; case "001001": ?>北京<?php break; case "001011001": ?>南京<?php break; case "001010001": ?>杭州<?php break; case "001019002": ?>深圳<?php break; endswitch;?>
							</td>
							<td><?php echo ($infoList['agent_company_name']); ?></td>
							<td><?php echo ($infoList['company_store_name']); ?></td>
							<td>
								<?php switch($infoList['owner_verify']): case "2": ?>免审核<?php break;?>
									<?php default: ?>无<?php endswitch;?>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- 端口信息 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">端口信息
				<a href="<?php echo U('AgentsManage/middlemanPortAdd?no=6&leftno=206',array('id'=>$infoList['id']));?>" class="btn_a" style="margin-left:50px" target="_blank" id="portAdd">新增</a>
				<a href="<?php echo U('Jobowner/ownerPortDetail',array('id'=>$infoList['id']));?>" class="btn_a" style="margin-left:50px" target="_blank">查看明细</a>
				</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>启用日期</th>
							<th>端口时长(天)</th>
							<th>到期日期</th>
							<th>承诺链接数</th>
							<th>城市</th>
							<th>创建时间</th>
							<th>操作</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
					<?php if($portList != null): ?><tr>
							<td><?php if(($portList["service_start"] > 0)): echo (date("Y-m-d",$portList["service_start"])); endif; ?></td>
							<td><?php echo floor(($portList['service_end']-$portList['service_start'])/86400) ?></td>
							<td><?php if(($portList["service_end"] > 0)): echo (date("Y-m-d",$portList["service_end"])); endif; ?></td>
							<td><?php echo ($portList["links_num"]); ?></td>
							<td>
								<?php switch($portList["city_code"]): case "001009001": ?>上海<?php break; case "001001": ?>北京<?php break; case "001011001": ?>南京<?php break; case "001010001": ?>杭州<?php break; case "001019002": ?>深圳<?php break; endswitch;?>
							</td>
							<td><?php if(($portList["create_time"] > 0)): echo (date("Y-m-d H:i:s",$portList["create_time"])); endif; ?></td>
							<td>
								<a href="javascript:;" onclick="portstopdown('<?php echo ($portList["id"]); ?>','<?php echo ($portList["customer_id"]); ?>','<?php echo ($portList["service_start"]); ?>')" class="btn_a" style="margin:0px 20px 5px 20px">&nbsp;停用&nbsp;</a>
								<a href="<?php echo U('AgentsManage/middlemanPortDelay',array('id'=>$portList['id'],'customer_id'=>$infoList['id']));?>" class="btn_a" target="_blank" id="portDelay">延期&nbsp;</a>
							</td>
							<td><?php echo ($portList["memo"]); ?></td>
						</tr><?php endif; ?>
					</tbody>
				</table>
				<!-- 包月 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">包月
				<?php if($monthlyList["is_open"] == 0): ?><a href="<?php echo U('AgentsManage/middlemanMonthlyAdd?no=6&leftno=206',array('id'=>$infoList['id']));?>" class="btn_a" style="margin-left:80px" target="_blank">新增</a><?php endif; ?>
				</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>启用时间</th>
							<th>到期时间</th>
							<th>合同金额</th>
							<th>操作时间</th>
							<th>操作人</th>
							<th>操作</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
					<?php if($monthlyList != null): ?><tr>
							<td>
								<?php if(($monthlyList["monthly_start"] > 0)): echo (date("Y-m-d",$monthlyList["monthly_start"])); endif; ?>
							</td>
							<td>
								<?php if(($monthlyList["monthly_end"] > 0)): echo (date("Y-m-d",$monthlyList["monthly_end"])); endif; ?>
							</td>
							<td><?php echo ($monthlyList["monthly_money"]); ?></td>
							<td><?php if(($monthlyList["create_time"] > 0)): echo (date("Y-m-d H:i",$monthlyList["create_time"])); endif; ?></td>
							<td><?php echo ($monthlyList["create_man"]); ?></td>
							<td>
								<?php if($monthlyList["is_open"] == 1): ?><a href="javascript:;" onclick="monthlystopdown('<?php echo ($monthlyList["id"]); ?>','<?php echo ($monthlyList["customer_id"]); ?>')" class="btn_a" style="margin:0px 20px 5px 20px">&nbsp;停用&nbsp;</a>
								<?php elseif($monthlyList["is_open"] == 0): ?>停用<?php endif; ?>
							</td>
							<td><?php echo ($monthlyList["monthly_bak"]); ?></td>
						</tr><?php endif; ?>
					</tbody>
				</table>
				<!-- 佣金 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">佣金
				<?php if($commissionList["is_open"] == 0): ?><a href="<?php echo U('AgentsManage/middlemanCommissionAdd?no=6&leftno=206',array('id'=>$infoList['id']));?>" class="btn_a" style="margin-left:80px" target="_blank" id="isOpen">新增</a><?php endif; ?>
				</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>启用时间</th>
							<th>到期时间</th>
							<th>合同金额</th>
							<th>佣金基数</th>
							<th>结算方式</th>
							<th>操作时间</th>
							<th>操作人</th>
							<th>操作</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
					<?php if($commissionList != null): ?><tr>
							<td>
								<?php if($commissionList["use_time"] > 0): echo (date("Y-m-d",$commissionList["use_time"])); endif; ?>
							</td>
							<td>
								<?php if($commissionList["stop_time"] > 0): echo (date("Y-m-d",$commissionList["stop_time"])); endif; ?>
							</td>
							<td>
								<?php if($commissionList["contract_type"] == 0): echo ($commissionList["contract_money"]); ?>%
								<?php elseif($commissionList["contract_type"] == 1): echo ($commissionList["contract_money"]); endif; ?>
							</td>
							<td>
								<?php if($commissionList["contract_base"] == 1): ?>1个月
								<?php elseif($commissionList["contract_base"] == 3): ?>1年<?php endif; ?>
							</td>
							<td>
								<?php if($commissionList["pay_method"] == 1): ?>次结
								<?php elseif($commissionList["pay_method"] == 2): ?>月结<?php endif; ?>
							</td>
							<td>
								<?php if(($commissionList["create_time"] > 0)): echo (date("Y-m-d H:i",$commissionList["create_time"])); endif; ?>
							</td>
							<td><?php echo ($commissionList["create_man"]); ?></td>
							<td>
								<?php if($commissionList["is_open"] == 1): ?><a href="javascript:;" onclick="commissionstopdown('<?php echo ($commissionList["id"]); ?>','<?php echo ($commissionList["customer_id"]); ?>')" class="btn_a" style="margin:0px 20px 5px 20px">&nbsp;停用&nbsp;</a>
								<?php elseif($commissionList["is_open"] == 0): ?>停用<?php endif; ?>
							</td>
							<td><?php echo ($commissionList["memo"]); ?></td>
						</tr><?php endif; ?>
					</tbody>
				</table>
				<!-- 置顶 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">置顶</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>置顶房间编号</th>
							<th>置顶位</th>
							<th>行政区</th>
							<th>商圈</th>
							<th>地铁线</th>
							<th>地铁站</th>
							<th>操作时间</th>
							<th>操作人</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($stickList)): foreach($stickList as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_no"]); ?></td>
							<td>
								<?php switch($vo["top_type"]): case "0": ?>不置顶<?php break; case "1": ?>首页<?php break; case "2": ?>全城市<?php break; case "3": ?>区域<?php break; case "4": ?>板块<?php break; case "5": ?>地铁线<?php break; case "6": ?>地铁站<?php break; default: endswitch;?>
							</td>
							<td><?php echo ($vo["region_name"]); ?></td>
							<td><?php echo ($scope_name); ?></td>
							<td><?php echo ($vo["subwayline_name"]); ?></td>
							<td><?php echo ($vo["subway_name"]); ?></td>
							<td>
								<?php if($vo["toproom_createtime"] > 0): echo (date("Y-m-d H:i:s",$vo["toproom_createtime"])); endif; ?>
							</td>
							<td><?php echo ($vo["create_man"]); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<!-- 链接数据 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">链接数据</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>在架房源量</th>
							<th>租客数</th>
							<th>电话链接数</th>
							<th>预约链接数</th>
							<th>IM链接数</th>
							<th>总链接数</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo ($dataList["limit_count"]); ?></td>
							<td><?php echo ($dataList["renter_num"]); ?></td>
							<td><?php echo ($dataList["contact_num"]); ?></td>
							<td><?php echo ($dataList["reserve_num"]); ?></td>
							<td></td>
							<td><?php echo ($dataList["total_num"]); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
 <script src="/hizhu/Public/js/jquery.js"></script>
 <script src="/hizhu/Public/js/common.js"></script>
 <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	var portEndTime = "<?php echo $portList['service_end'];?>";
	var timestamp = Date.parse(new Date());
	if(portEndTime*1000 > timestamp) {
		$("#portAdd").hide();
	} else {
		$("#portDelay").hide();
	}
})
function portstopdown(id,cid,start){
		if(confirm('确认停用端口吗？')){
			$.get('/hizhu/Jobowner/ownerPortStop?id='+id+'&customer_id='+cid+'start='+start,function(data){
				alert(data.message);
				document.location.reload();
			},"json");
		}
}
function monthlystopdown(id,cid,time){
		if(confirm('确认停用包月吗？')){
			$.get('/hizhu/Jobowner/ownerMonthlyStop?id='+id+'&customer_id='+cid,function(data){
				alert(data.message);
				document.location.reload();
			},"json");
		}
}
function commissionstopdown(id,cid){
		if(confirm('确认停用佣金吗？')){
			$.get('/hizhu/Jobowner/ownerCommissionStop?id='+id+'&customer_id='+cid,function(data){
				alert(data.message);
				document.location.reload();
			},"json");
		}
}

</script>
</html>