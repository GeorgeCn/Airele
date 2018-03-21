<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>修改banner</title>
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
				<h2>修改banner</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/AdConfiguration/submitAdindex.html" id="submitForm" enctype='multipart/form-data'>
				   <input name="type" type="hidden" value="update">
				    <input name="upid" type="hidden" value="<?php echo ($adindex['id']); ?>">
				    <table class="table_one table_two"> 	
						<tr>
							<td class="td_title">标题：</td>
							<td class="td_main">
								<input type="text" name="title" value="<?php echo ($adindex['title']); ?>">
							</td>
						</tr>
					
					<tr>
						<td class="td_title">跳转地址：</td>
						<td class="td_main">
						   <input type="text" name="link" value="<?php echo ($adindex['link']); ?>">
						</td>
					</tr>
					<tr>
						<td class="td_title">banner图片：</td>
						<td class="td_main">
						  	   <div class="upload_photo">
									<span>上传照片</span>
									<input type="file" id="fileupload" name="mypic">
								</div>
								<ul class="cf" id="imglist"></ul>
						</td>
					</tr>
					<tr>
						<td class="td_title">排序：</td>
						<td class="td_main">
							   <input type="text" name="sort_index" value="<?php echo ($adindex['sort_index']); ?>">
						</td>
					</tr>
					<tr>
						<td class="td_title">数据状态：</td>
						<td class="td_main">
						      <input type="radio" id="show" name="is_display" value="1" checked <?php if($adindex['is_display']==1){echo"checked";}?>>
							  <label for="show">显示</label>
							  <input type="radio" id="hide" name="is_display" value="0" <?php if($adindex['is_display']==0){echo"checked";}?>>
							  <label for="hide">隐藏</label>
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
			$("#imglist").append('<li><img style="dispaly:inline-block;" src="'+result.data.imgUrl+'"><input type="hidden" name="bannername" value="'+result.data.imgUrl+'" /></li>');
				$("#fileupload").val('');
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
	   var title=$("input[name='title']").val();
	   var link=$("input[name='link']").val();
	   var sort_index=$("input[name='sort_index']").val();
	
	   if(title==""){
		    alert("标题不能为空！");
		    return false;
	   }else if(link==""){
		   alert("跳转地址不能为空！");
		   return false;
	   }else if(sort_index==""){
	   		alert("排序不能为空！");
		   return false;
	   }else{
		   $("#submitForm").submit();
	   } 
   }
</script>
</html>