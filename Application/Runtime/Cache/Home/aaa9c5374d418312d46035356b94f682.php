<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>店铺详情</title>
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
				<h2>店铺详情</h2>
				<div class="common_head_main">
					<table class="table_one">
					<input type="hidden" value="<?php echo ($detail['name']); ?>" id="storeTitle">
						<tr>
							<td class="td_title">店铺名称：</td>
							<td class="td_main" ><?php echo ($detail['name']); ?>
							<a href="<?php echo U('Stores/storeTitle?no=162&leftno=164',array('id'=>$detail['id']));?>" class="fr" style="margin-right:100px" id="title">更改</a>
							</td>
							<td class="td_title">店铺ID：</td>
							<td class="td_main"><?php echo ($detail['id']); ?></td>
						</tr>
						<tr>
							<td class="td_title">创建时间：</td>
							<td class="td_main"><?php echo (date("Y-m-d H:i:s",$detail['create_time'])); ?></td>
							<td class="td_title">信用分：</td>
							<td class="td_main" ><?php echo ($detail['credit_score']); ?>
							<a href="<?php echo U('Stores/storeCreditScore?no=162&leftno=164',array('id'=>$detail['id']));?>" class="fr" style="margin-right:100px" id="creditscore">查看</a>
							</td>
						</tr>
						<tr>
							<td class="td_title">保证金：</td>
							<td class="td_main" ><?php echo ($detail['earnestmoney']); ?>
							<a href="<?php echo U('Stores/storeDeposit?no=162&leftno=164',array('id'=>$detail['id']));?>" class="fr" style="margin-right:100px" id="deposit">更改</a>
							</td>
							<td class="td_title">店铺类型：</td>
							<td class="td_main">
								<?php if(strtoupper($detail['medal_type']) == '0'): ?>普通
									<?php elseif(strtoupper($detail['medal_type']) == '1'): ?>
									 金牌
									<?php elseif(strtoupper($detail['medal_type']) == '2'): ?>
									 银牌<?php endif; ?>
							<a href="<?php echo U('Stores/storeType?no=162&leftno=164',array('id'=>$detail['id']));?>" class="fr" style="margin-right:100px" id="type">更改</a>
							</td>
						</tr>	
					</table>
					<div class="addhouse_last addhouse_last_room">
					<a href="<?php echo U('Stores/storeManager?no=162&leftno=164',array('id'=>$detail['id']));?>" class="btn_a" style="min-width: 160px;min-height:40px;line-height:40px;margin:20px 40px 20px 40px" id="button1">更改店长</a>
					<a href="<?php echo U('Stores/storeMember?no=162&leftno=164',array('id'=>$detail['id']));?>" class="btn_a" style="min-width: 160px;min-height:40px;line-height:40px;margin:20px 40px" id="button2">新增店员</a>
					<a href="<?php echo U('Stores/storeHouses?no=162&leftno=164',array('id'=>$detail['id']));?>" class="btn_a" style="min-width: 200px;min-height:40px;line-height:40px;margin:20px 40px " id="button3">房间编号移动房源</a>
					<a href="<?php echo U('Stores/storeMobileHouses?no=162&leftno=164',array('id'=>$detail['id']));?>" class="btn_a" style="min-width: 200px;min-height:40px;line-height:40px;margin:20px 20px" id="button4">手机号移动房源</a>
					</div>
				</div>
			</div>
			<div class="common_main">
				<h2>店员列表</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>人员名称</th>
								<th>手机号</th>
								<th>职位</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($members)): $i = 0; $__LIST__ = $members;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo['name']); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php if(strtoupper($vo['title']) == '100'): ?>店员
									<?php elseif(strtoupper($vo['title']) == '200'): ?>
									 接线员
									<?php elseif(strtoupper($vo['title']) == '300'): ?>
									 店长
									<?php elseif(strtoupper($vo['title']) == '400'): ?>
									 区域经理<?php endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="common_main">
				<h2>店铺房源</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>房间编号</th>
								<th>负责人</th>
								<th>租金</th>
								<th>房间状态</th>
								<th>创建时间</th>
								<th>历史信息</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><a href="<?php echo U('HouseRoom/modifyroom',array('room_id'=>$vo['id'],'handle'=>'search'));?>" target="_blank"><?php echo ($vo['room_no']); ?></a></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['room_money']); ?></td>
								<td>
									<?php if(strtoupper($vo['status']) == '0'): ?>待审核
									<?php elseif(strtoupper($vo['status']) == '1'): ?>
									 审核未通过
									<?php elseif(strtoupper($vo['status']) == '2'): ?>
									 未入住
									<?php elseif(strtoupper($vo['status']) == '3'): ?>
									 已出租
									<?php elseif(strtoupper($vo['status']) == '4'): ?>
									 待维护<?php endif; ?>
								</td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td><a href="<?php echo U('HouseResource/houseupdatelog',array('house_id'=>$vo['id'],'house_type'=>2));?>" target="_blank">历史记录</a></td>
								<td>
									<a href="javascript:;" onclick="DeleteById('<?php echo ($pagecount); ?>','<?php echo ($vo[id]); ?>',this);">删除</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left" id="count">共<?php echo ($pagecount); ?>条记录，每页10条</p>
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
	<script type="text/javascript">
		$(function display(){
		   var title = document.getElementById('storeTitle').value;
		   if(title == '我的房源') {
		   		$('#button1').hide();
		   		$('#button2').hide();
		   		$('#button3').hide();
		   		$('#button4').hide();
		   		$('#title').hide();
		   		$('#type').hide();
		   		$('#creditscore').hide();
		   		$('#deposit').hide();
		   		$('#count').hide();
		   }
		});
		function DeleteById(count,id,objective){
 	  	if(confirm('确定删除吗？')){
			$.get("/hizhu/Stores/deleteHouseRoom.html",{id:id,},function(data){
				var obj = eval('('+data+')');
	            if(obj.code == 404) {
			        alert(obj.message);
			    } 
				if(obj.code == 400) {
			        alert(obj.message);
			        location.reload(true );
			    } 
			    if(obj.code == 200) {
			        alert(obj.message);
			        $(objective).parent().parent().remove();
			        $('#count').html("共"+(count-1)+"条记录，每页10条");
			    }
			});
		}
   	}
	</script>
</body>
</html>