<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>门店管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
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
				<h2>门店管理
					<a href="javascript:;" onclick="addStore('<?php echo ($company["id"]); ?>','<?php echo ($company["company_name"]); ?>','<?php echo ($company["company_type"]); ?>')" class="btn_a">添加</a>
				</h2>
			</div>
			<div class="common_main">
				<div class="table" id="dataDiv">
					<table width="50%">
						<thead>
							<tr>
								<th>序号</th>
								<th>公司</th>
								<th>门店</th>
								<th>操作时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo["company_name"]); ?></td>
								<td><?php echo ($vo["company_store"]); ?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo["create_time"])); endif; ?></td>
								<td>
									<a href="javascript:;" onclick="editStore('<?php echo ($vo["id"]); ?>')" class="btn_a">编辑</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div id="infoAdd" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:470px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-235px;border-radius:10px;">
			<div style="margin:50px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">门店名称：</label>
				<input type="text" class="fl" id="companyStore" style="width:200px;height:36px;">
			</div>
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;">取消</button>
				<button class="btn_a" id="btn_submit">提交</button>
			</div>
		</div>
	</div>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script>
	//添加租客信息录入
  	function addStore(id,name,type) {
  		operation = 0;
  		pid = id;
  		company_name = name;
  		company_type = type;
  		$("#infoAdd").show();
	};
	function editStore(id,name) {
		operation = 1;
  		store_id = id;
  		$("#infoAdd").show();
	};
	$(".btn_b").click(function(){
		$("#infoAdd").hide();
	});
	$("#btn_submit").click(function() {
		var store = $("#companyStore").val(); 
		if(operation == 0) {
			$.ajax({
		            type:"post",
		            url: "<?php echo U('AgentsManage/companyStoreAddInfo');?>",
		            data:{"pid":pid,"company_name":company_name,"company_store":store,"company_type":company_type},
					dataType:"json",
		            success:function(data) {
		            	if(data.code == 404) alert(data.message);
			            if(data.code == 400) alert(data.message);
			            if(data.code == 200) {
			            	alert(data.message);
			            	$("#infoAdd").hide(); 
			            	location.reload();
						}
			    	}
				})
		} else if(operation == 1) {
			$.ajax({
		            type:"post",
		            url: "<?php echo U('AgentsManage/companyStoreEditInfo');?>",
		            data:{"id":store_id,"company_store":store},
					dataType:"json",
		            success:function(data) {
		            	if(data.code == 404) alert(data.message);
			            if(data.code == 400) alert(data.message);
			            if(data.code == 200) {
			            	alert(data.message);
			            	$("#infoAdd").hide(); 
			            	location.reload();
						}
			    	}
				})
		}
	})
</script>
</body>
</html>