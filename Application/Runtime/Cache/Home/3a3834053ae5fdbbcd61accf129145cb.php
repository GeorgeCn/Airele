<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>新增中介公司</title>
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
				<h2>新增中介公司</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/AgentsManage/agentsCompanyModifyInfo.html" id="submitForm" enctype='multipart/form-data'>
				    <table class="table_one table_two"> 	
				    	<input type="hidden" name="id" value="<?php echo ($list['id']); ?>">
						<tr>
							<td class="td_title">公司名称：</td>
							<td class="td_main">
								<input type="text" name="company_name" value="<?php echo ($list['company_name']); ?>">
							</td>
						</tr>
						<tr>
							<td class="td_title">中介费比率：</td>
							<td class="td_main">
							   <input type="text" name="commission_fee" value="<?php echo ($list['commission_fee']); ?>">
							</td>
						</tr>
						<tr>
							<td class="td_title">公司LOGO：</td>
							<td class="td_main">
							    <div class="upload_photo">
										<span>上传照片</span>
										<input type="file" id="fileupload" name="mypic">
									</div>
									<ul class="cf" id="imglist"></ul>
							</td>
						</tr>
					</table>
			 		<div class="addhouse_last addhouse_last_room"><a href="javascript:window.history.back();" class="btn_b">返回</a><button class="btn_a" onclick="return check();">提交</button></div>
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
			url:"<?php echo U('AgentsManage/uploadImage');?>",
			dataType: 'json',
			data:{submitType:'upload'},
			beforeSend: function() {
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				console.log(result);
			$("#imglist").append('<li><img style="dispaly:inline-block;" src="'+result.data.imgUrl+'"><input type="hidden" name="img_url" value="'+result.data.imgUrl+'" /></li>');
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
	   var company_name = $("input[name='company_name']").val();
	   var commission_fee = $("input[name='commission_fee']").val();
	   var img_url = $("input[name='img_url']").length;
	   if(company_name == ""){
		    alert("公司名称不能为空！");
		    return false;
	   } else if(commission_fee == ""){
		   alert("中介费比率不能为空！");
		   return false;
	   } else {
		   $("#submitForm").submit();
	   } 
   }
</script>
</html>