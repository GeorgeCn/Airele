<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>看房列表</title>
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
				<form action="<?php echo U('Stores/houseShowList');?>" method="get">
						<input type="hidden" name="no" value="162">
						<input type="hidden" name="leftno" value="166">
					<table class="table_one">
						<tr>
							<td class="td_title">创建时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
							<td class="td_title">反馈手机号：</td>
							<td class="td_main"><input type="text" maxlength="11" name="mobile" value="<?php echo I('get.mobile');?>"></td>
							</td>
							<td class="td_title">店铺名称：</td>
							<td class="td_main"><input type="text" name="name" value="<?php echo I('get.name');?>" placeholder="可模糊查询"></td>
							</td>
							</tr>
							<tr>
							<td class="td_title">是否删除</td>
							<td class="td_main">
								<select name="record_status">
							        <option value="" <?php if($_GET['record_status']===""){echo "selected";}?>>全部</option>
							    	<option value="0" <?php if($_GET['record_status']=="0"){echo "selected";}?>>已经删除</option>
							    	<option value="1" <?php if($_GET['record_status']=="1"){echo "selected";}?>>未删除的</option>
							    </select>
							</td>
							<td class="td_title">是否成交</td>
							<td class="td_main">
								<select name="deal">
							        <option value="" <?php if($_GET['deal']===""){echo "selected";}?>>全部</option>
							    	<option value="1" <?php if($_GET['deal']=="1"){echo "selected";}?>>是</option>
							    	<option value="0" <?php if($_GET['deal']=="0"){echo "selected";}?>>否</option>
							    </select>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>	
					</table>
					<p class="head_p"><button type="submit" class="btn_a">搜索</button></p>
					</form>
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
								<th>是否成交</th>
								<th>房源编号</th>
								<th>房源金额</th>
								<th>租客手机</th>
								<th>反馈时间</th>
								<th>是否真实看房</th>
								<th>是否真实成交</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><a href="<?php echo U('stores/storeDetail?no=162&leftno=166',array('id'=>$vo['store_id']));?>"><?php echo ($vo['store_name']); ?></a></td>
								<td><?php echo ($vo['owner_mobile']); ?></td>
								<td>
									<?php if($vo['type'] == '1'): ?>是
									<?php elseif($vo['type'] == '0'): ?>
									 否<?php endif; ?>
								</td>
								<td><?php echo ($vo['room_no']); ?></td>
								<td><?php echo ($vo['room_money']); ?></td>
								<td><?php echo ($vo['customer_mobile']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td>
									<?php if($vo['is_true_show'] == '0'): ?>否
									<?php elseif($vo['is_true_show'] == '1'): ?>
									是
									<?php elseif($vo['is_true_show'] == '2'): ?>
									<a href="javascript:;" onclick="IsShow('<?php echo ($vo[id]); ?>',1);">是&nbsp;</a>
									<a href="javascript:;" onclick="IsShow('<?php echo ($vo[id]); ?>',0);">&nbsp;否</a><?php endif; ?>
								</td>
								<td>
									<?php if($vo['is_true_deal'] == '0'): ?>否
									<?php elseif($vo['is_true_deal'] == '1'): ?>
									是
									<?php elseif($vo['is_true_deal'] == '2'): ?>
									<a href="javascript:;" onclick="IsDeal('<?php echo ($vo[id]); ?>',1);">是&nbsp;</a>
									<a href="javascript:;" onclick="IsDeal('<?php echo ($vo[id]); ?>',0);">&nbsp;否</a><?php endif; ?>
								</td>
								<td>
									<?php if($vo['status'] == '1'): ?><a href="javascript:;" onclick="DeleteById('<?php echo ($pagecount); ?>','<?php echo ($vo[id]); ?>',this);">删除</a>
									<?php elseif($vo['status'] == '0'): ?>
									已删除<?php endif; ?>
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
	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"}); 
	function DeleteById(count,id,objective){
 	  	if(confirm('确定删除吗？')){
			$.get("/hizhu/Stores/deleteHouseFback.html",{id:id,},function(data){
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
					$(objective).html('已删除');
					$(objective).css({color:'#000'});
			    }
				
			});
		}
   	}
	function IsShow(id,is_true_show){
   		if(confirm('确定选择吗？')) {
			$.get("/hizhu/Stores/modifyHouseFbackIsShow.html",{id:id,is_true_show:is_true_show},function(data){
				var obj = eval('('+data+')');
	            if(obj.code == 404) {
			        alert(obj.message);
			    } 
				if(obj.code == 400) {
			        alert(obj.message);
			        location.reload(true);
			    } 
			    if(obj.code == 200) {
			        alert(obj.message);
					location.reload(true);
			    }	
			});
		}
	}
   	function IsDeal(id,is_true_deal){
   		if(confirm('确定选择吗？')) {
			$.get("/hizhu/Stores/modifyHouseFback.html",{id:id,is_true_deal:is_true_deal},function(data){
				var obj = eval('('+data+')');
	            if(obj.code == 404) {
			        alert(obj.message);
			    } 
				if(obj.code == 400) {
			        alert(obj.message);
			        location.reload(true);
			    } 
			    if(obj.code == 200) {
			        alert(obj.message);
					location.reload(true);
			    }
			});
		}
	}
	</script>
</body>
</html>