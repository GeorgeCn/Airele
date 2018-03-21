<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>区域板块</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/parameter_management_house.css">
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
				<h2>修改图标</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/Paramappico/addAppico.html" id="submitForm" enctype='multipart/form-data'>
				   <input name="upid" type="hidden" value="<?php echo ($uparr['id']); ?>">
					<input name="type" type="hidden" value="update">
				    <table class="table_one table_two"> 	
						<tr>
							<td class="td_title">类型编号：</td>
							<td class="td_main">
								<input type="text" name="type_no" value="<?php echo ($uparr['type_no']); ?>">
							</td>
						</tr>
					<tr>
						<td class="td_title">房源详细类型：</td>
						<td class="td_main">
							   <select name="info_type">
								<option value="3" <?php if($uparr['info_type']==3){echo "selected";}?>>公共设施</option>
								<option value="11" <?php if($uparr['info_type']==11){echo "selected";}?>>房间设施</option>
								</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">名称：</td>
						<td class="td_main">
						   <input type="text" name="name" value="<?php echo ($uparr['name']); ?>">
						</td>
					</tr>
					<tr>
						<td class="td_title">灰图标：</td>
						<td class="td_main">
						  	   <div class="upload_photo">
									<span>上传照片</span>
									<input type="file" id="fileupload1" name="mypic">
								</div>
								<ul class="cf" id="imglist1"></ul>
						</td>
					</tr>
					<tr>
						<td class="td_title">亮图标：</td>
						<td class="td_main">
						    <div class="upload_photo">
									<span>上传照片</span>
									<input type="file" id="fileupload" name="mypic">
								</div>
								<ul class="cf" id="imglist"></ul>
						</td>
					</tr>
					
				</table>
			 		<div class="addhouse_last addhouse_last_room"><button class="btn_a" onclick="return check();">提交</button></div>
				</form>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
$(function () {
    $("#fileupload").change(function(){
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				console.log(result);
			$("#imglist").append('<li><img style="dispaly:inline-block;" src="'+result.data.imgUrl+'"><input type="hidden" name="bright" value="'+result.data.imgUrl+'" /></li>');
				$("#fileupload").val('');
			},
			error:function(xhr){
				alert(xhr.responseText);
			}
		});
	});


	 $("#fileupload1").change(function(){
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				console.log(result);
			$("#imglist1").append('<li><img style="dispaly:inline-block;"  src="'+result.data.imgUrl+'"><input type="hidden" name="gray" value="'+result.data.imgUrl+'" /></li>');
			$("#fileupload1").val('');
			},
			error:function(xhr){
				alert(xhr.responseText);
			}
		});
	});
	
});

</script>
<script type="text/javascript">
	/*提交表单*/
 function check(){
	   var type_no=$("input[name='type_no']").val();
	   var name=$("input[name='name']").val();
	   var bright=$("input[name='bright']").length;
	   var gray=$("input[name='gray']").length;
	   if(type_no==""){
		    alert("类型编号不能为空！");
		    return false;
	   }else if(name==""){
		   alert("名称不能为空！");
		   return false;
	   }else if(gray==""){
		   alert("灰图标不能为空！");
		   return false;
	   }else if(bright==""){
		   alert("亮图标不能为空！");
		   return false;
	   }else{
		   $("#submitForm").submit();
	   } 
   }
</script>
</html>