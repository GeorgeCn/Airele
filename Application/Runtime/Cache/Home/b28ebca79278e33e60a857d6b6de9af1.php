<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>新增菜单</title>
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
				<h2>新增菜单</h2>
			</div>
			<div class="common_main">
				 <form action="<?php echo U('Sysmenu/addSysmenu');?>" method="post"  id="form">
					<table class="table_one table_two">
						<tr>
							<td colspan="2">新增菜单</td>
						</tr>

						<?php if(strtoupper($updata['parent_id']) != '0'): ?><tr>
							<td class="td_title"><span>*</span><?php if($_GET['mid']==""){echo"主菜单";}else{echo"上级菜单";}?>：</td>
							<td class="td_main">
								<select name="parent_id">
								    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</td>
						</tr><?php endif; ?>
						<tr>
							<td class="td_title"><span>*</span>菜单名称：</td>
							<td class="td_main"><input type="text" name="mname" value="<?php echo ($updata["name"]); ?>"></td>
						</tr>
						<tr>
							<td class="td_title"><span>*</span>菜单链接：</td>
							<td class="td_main"><input type="text" name="murl" value="<?php echo ($updata["url"]); ?>"></td>
						</tr>
						<tr>
							<td class="td_title"><span>*</span>菜单排序：</td>
							<td class="td_main"><input type="text" name="index_no" value="<?php echo ($updata["index_no"]); ?>"></td>
						</tr>
						<tr>
						<td class="td_title"><span>*</span>城市：</td>
							<td class="td_main">
							<label><input type="checkbox" name="admincity[]" value="1" checked="">&nbsp;上海</label>&nbsp;&nbsp;&nbsp;<label>
							<input type="checkbox" name="admincity[]" value="2" checked="">&nbsp;北京</label>&nbsp;&nbsp;&nbsp;							
							</td>
						</tr>
					</table>
					 <div class="addhouse_last addhouse_last_room">
						<a href="<?php echo U('Sysmenu/sysmenuList');?>" class="btn_b">返回</a>
						<input type="hidden" name="id" value="<?php echo ($updata["id"]); ?>" />
						<input type="hidden" name="uptype" value="up" />
						<button class="btn_a"  onclick="return check();">确定提交</button>
					</div>
				</form>
			</div>
		</div>
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
		
	<script type="text/javascript">
	/*提交表单*/
 function check(){
	   var mname=$("input[name='mname']").val();
	   var murl=$("input[name='murl']").val();
	   var index_no=$("input[name='index_no']").val();
	   if(mname==""){
		    alert("菜单名称不能为空！");
		    return false;
	   }else if(murl==""){
		   alert("菜单链接不能为空！");
		   return false;
	   }else if(index_no==""){
		   alert("菜单排序不能为空！");
		   return false;
	   }else{
		   $("#form").submit();
	   } 
   }
</script>
</body>
</html>