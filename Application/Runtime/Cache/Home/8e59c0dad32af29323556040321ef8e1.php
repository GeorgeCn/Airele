<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>管理房间</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
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
				<h2>管理房间</h2>
				<p><?php echo ($resource_info); ?></p>
			</div>
			<div class="common_main">
			    <h2>房间信息(共<?php echo ($roomCount); ?>个房间)<a href="/hizhu/HouseRoom/addroom?resource_id=<?php echo ($resource_id); ?>&source_type=manage" class="btn_a">新增房间</a></h2> 
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房间编号</th>
								<th>卧室名称</th>
								<th>面积（㎡）</th>
								<th>租金（元）</th>
								<th>出租状态</th>
								<th>维护租客</th>
								<th>发布时间</th>
								<th>操作人</th>
								<th>数据来源</th>
								<th>修改房间</th>
								<th>删除房间</th>
								<th>管理租客</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><?php echo ($list["ident_num"]); ?></td>
								<td><?php echo ($list["room_no"]); ?></td>
								<td><?php echo ($list["room_name"]); ?></td>
								<td><?php echo ($list["room_area"]); ?></td>
								<td><?php echo ($list["room_money"]); ?></td>
								
								<?php if($list["status_name"] == '已出租'): ?><td style="color:green;"><?php echo ($list["status_name"]); ?></td>
								<?php elseif($list["status_name"] == '未入住'): ?>
									<td style="color:red;"><?php echo ($list["status_name"]); ?></td>
								<?php else: ?>
									<td><?php echo ($list["status_name"]); ?></td><?php endif; ?>
								<td><?php echo ($list["is_renter"]); ?></td>
								<td><?php echo ($list["update_time"]); ?></td>
								<td><?php echo ($list["update_man"]); ?></td>
								<?php if($list["info_resource_url"] == ''): ?><td></td>
								<?php else: ?>
									<td><a target="_blank" href="<?php echo ($list["info_resource_url"]); ?>">URL地址</a></td><?php endif; ?>
								<td><a href="/hizhu/HouseRoom/modifyroom?room_id=<?php echo ($list["room_id"]); ?>">修改</a></td>
								<td><a href="javascript:;" onclick="showDialog('<?php echo ($list["room_id"]); ?>',this);">删除</a></td>
								<td>
									<?php if($list["status_name"] == '已出租'): ?><a href="/hizhu/HouseRoom/roomrentermanage?resource_id=<?php echo ($resource_id); ?>&room_id=<?php echo ($list["room_id"]); ?>&room_name=<?php echo ($list["room_name"]); ?>">管理租客</a>
									<?php else: ?>--<?php endif; ?>
								</td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="addhouse_last"><a href="/hizhu/HouseResource/resourcelist" class="btn_b">返回</a>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<!--遮罩层 -->
	<div id="dialogDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:200px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:100px;text-align:right;">删除理由：</label>
				<select id="delete_type" style="width:250px;height:36px;">
					<option value="0"></option>
					<option value="1">骗子/钓鱼/微商</option>
					<option value="2">房源重复</option>
					<option value="3">商务需求</option>
					<option value="4">中介</option>
					<option value="5">图片/地址/电话问题</option>
					<option value="6">其他</option>
				</select>
			</div>
			<div style="margin:20px;height:36px;" class="cf">
				<input type="text" class="fl" id="delete_text" style="width:250px;height:36px;margin-left:100px;display:none;"> 
			</div> 
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancel">取消</button>
				<button class="btn_a" id="btn_submit">提交</button>
				<input type="hidden" id="removeroom_id">
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>

<script type="text/javascript">
	var resource_id='';
	/*function deleteRoom(room_id,resource_id){
		if(confirm("确定删除该房间吗？")){
			$.get("/hizhu/HouseRoom/removeRoom",{room_id:room_id,resource_id:resource_id},function(data){
				if(data.status=="200"){
					window.location.reload();
				}else{
					alert(data.msg);
				}
			},"json");
		}
	}*/
	/*删除操作 */
	$("#btn_cancel").click(function(){
		$("#dialogDiv").hide();
	});
	var delete_obj;
	function showDialog(room_id,obj){
		delete_obj=obj;
		$("#removeroom_id").val(room_id);
		$("#dialogDiv").show();
	}
	$("#delete_type").change(function(){
		if($(this).val()==6){
			$("#delete_text").show();
		}else{
			$("#delete_text").val('').hide();
		}
	});
	$("#btn_submit").click(function(){
		submitDelete();
	});
	function submitDelete(){
		var delete_type=$("#delete_type").val();
		var delete_text=$("#delete_text").val().replace(/\s+/g,'');
		if(delete_type=='0'){
			alert("请选择删除理由");return;
		}
		$("#btn_submit").unbind('click').text('提交中');
		$.post('/hizhu/HouseRoom/removeRoom',{delete_type:delete_type,delete_text:delete_text,room_id:$("#removeroom_id").val()},function(data){
			if(data.status=="200"){
				$(delete_obj).parent().parent().remove();
				$("#dialogDiv").hide();
			}else{
				alert(data.message);
			}
			$("#btn_submit").bind('click',function(){
				submitDelete();
			}).text('提交');
		},'json');
	}
</script>
</html>