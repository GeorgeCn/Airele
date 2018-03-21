<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>修改密码</title>
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
				<h2>修改密码</h2>
			</div>
			<div class="common_main">
				<form action="<?php echo U('Account/upPassword');?>" method="post"  id="form">
					<table class="table_one table_two">
						<tr>
							<td colspan="2">修改密码</td>
						</tr>
						<tr>
							<td class="td_title"><span>*</span>账户名：</td>
							<?php if(cookie("admin_user_name")=="admin"){echo'<td class="td_main"><input type="text" name="user_name"><td><input type="hidden" name="usertype" value="admin"></td>';}else{echo '<td><input type="hidden" name="user_name" value="'.cookie("admin_user_name").'">'.cookie("admin_user_name").'</td>';}?>
							
						</tr>
						<?php if(cookie("admin_user_name")!="admin"){?>
						<tr>
							<td class="td_title"><span>*</span>原密码：</td>
							<td class="td_main"><input type="password" autocomplete="off" name="oldpwd"></td>
						</tr>
						<?php }?>
						<tr>
							<td class="td_title"><span>*</span>新密码：</td>
							<td class="td_main"><input type="password" autocomplete="off" name="newpwd"></td>
						</tr>
						<tr>
							<td class="td_title"><span>*</span>再次输入新密码：</td>
							<td class="td_main"><input type="password" autocomplete="off" name="newpwds"></td>
						</tr>
					</table>
					<div class="addhouse_last addhouse_last_room">
						<button class="btn_a" onclick="return check();">确定提交</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	/*提交表单*/
 function check(){
 	    var user_name=$("input[name='user_name']").val();
	    var oldpwd=$("input[name='oldpwd']").val();
	    var newpwd=$("input[name='newpwd']").val();
	    var newpwds=$("input[name='newpwds']").val();
	   if(user_name==""){
		    alert("请输入账户名");
		    return false;
	   }else if(oldpwd==""){
		   alert("请输入原密码");
		   return false;
	   }else if(newpwd==""){
		   alert("请输入新密码");
		   return false;
	   }else if(newpwds==""){
		   alert("请再次输入新密码");
		   return false;
	   }else if(newpwd!=newpwds){
		   alert("2次输入的新密码不一致");
		   return false;
	   }else if(newpwd.length>20 || newpwds.length>20){
		   alert("密码长度不能超过20个字符");
		   return false;
	   }else{
		   $("#form").submit();
	   } 
   }
</script>
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
</body>
</html>