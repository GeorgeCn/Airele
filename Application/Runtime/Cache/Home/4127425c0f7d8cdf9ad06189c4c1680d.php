<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>参数管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
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
				<h2>设施图标管理</h2>
				<form action="<?php echo U('Paramappico/paramAppIcoList');?>" method="get">
				   <input type="hidden" name="no" value="1">
				    <input type="hidden" name="leftno" value="25">
						<table class="table_one" style="margin-top:0px">
						<tr>
							<td class="td_title">房源类型：</td>
							<td class="td_main">
								<select name="keyword">
								 <option value="3" <?php if($_GET['keyword']==3){echo "selected";}?>>公共设施</option>
								 <option value="11" <?php if($_GET['keyword']==11){echo "selected";}?>>房间设施</option>
								</select>&nbsp;&nbsp;&nbsp;
								
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
					 </form>
				</div>
				<div class="common_main">
					<h2>设施图标列表<a href="/hizhu/Paramappico/addtemp.html?no=2&leftno=25" class="btn_a">新增图标</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>类型编号</th>
								<th>房源详细类型</th>
								<th>名称</th>
								<th>图片</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['type_no']); ?></td>
								<td><?php if($vo['info_type']==0){echo"装修";}elseif($vo['info_type']==1){echo"付款方式";}elseif($vo['info_type']==2){echo"房间类型";}elseif($vo['info_type']==3){echo"公共设施";}elseif($vo['info_type']==4){echo"房屋类型";}elseif($vo['info_type']==5){echo"房东喜欢的租客";}elseif($vo['info_type']==6){echo"租金";}elseif($vo['info_type']==7){echo"面积";}elseif($vo['info_type']==8){echo"性别";}elseif($vo['info_type']==9){echo"年龄范围";}elseif($vo['info_type']==10){echo"朝向";}elseif($vo['info_type']==11){echo"房间设施";}elseif($vo['info_type']==13){echo"人数";}elseif($vo['info_type']==14){echo"职业";}?></td>
								<td><?php echo ($vo['name']); ?></td>
								<td><img src="<?php echo ($vo['img_url_bright']); ?>"><img src="<?php echo ($vo['img_url_gray']); ?>"></td>
								<td><a href="<?php echo U('Paramappico/delAppIco');?>?paid=<?php echo ($vo['id']); ?>">删除</a>&nbsp;&nbsp;&nbsp;
								<a href="<?php echo U('Paramappico/upParamAppico');?>?no=2&leftno=25&paid=<?php echo ($vo['id']); ?>&intype=<?php echo ($vo['info_type']); ?>">修改</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			</div>
		</div>
	</div>
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
   <script src="/hizhu/Public/js/jquery.form.js"></script>
</body>
</html>