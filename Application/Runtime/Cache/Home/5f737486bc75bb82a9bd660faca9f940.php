<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>参数管理</title>
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
				<h2>房源参数管理</h2>
				<form action="<?php echo U('Paramhouse/paramHouseList');?>" method="get" id="form">
					<input type="hidden" name="no" value="2">
			        <input type="hidden" name="leftno" value="22">
					<table class="table_one">
						<tr>
							<td class="td_title">房源详细类型：</td>
							<td class="td_main">
							<select name="keyword">
									<option value="0" <?php if(isset($_GET['keyword']) && $_GET['keyword']==0){echo"selected ";}?>>装修</option>
									<option value="1" <?php if(isset($_GET['keyword']) && $_GET['keyword']==1){echo"selected ";}?>>付款方式</option>
									<option value="2" <?php if(isset($_GET['keyword']) && $_GET['keyword']==2){echo"selected ";}?>>房间类型</option>
									<option value="3" <?php if(isset($_GET['keyword']) && $_GET['keyword']==3){echo"selected ";}?>>公共设施</option>
									<option value="4" <?php if(isset($_GET['keyword']) && $_GET['keyword']==4){echo"selected ";}?>>房屋类型</option>
									<option value="5" <?php if(isset($_GET['keyword']) && $_GET['keyword']==5){echo"selected ";}?>>房东喜欢的租客</option>
									<option value="8" <?php if(isset($_GET['keyword']) && $_GET['keyword']==8){echo"selected ";}?>>性别</option>
									<option value="9" <?php if(isset($_GET['keyword']) && $_GET['keyword']==9){echo"selected ";}?>>年龄范围</option>
									<option value="15" <?php if(isset($_GET['keyword']) && $_GET['keyword']==15){echo"selected ";}?>>业务类型</option>
									<option value="17" <?php if(isset($_GET['keyword']) && $uparr['keyword']==17){echo "selected";}?>>星座</option>
									<option value="18" <?php if(isset($_GET['keyword']) && $uparr['keyword']==18){echo "selected";}?>>行业</option>
								</select>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button  type="submit" class="btn_a">搜索</button></p>
				 </form>
				</div>
				<div class="common_main">
				<h2>房源参数列表<a href="/hizhu/Paramhouse/addhousetemp.html?type=0&no=1&leftno=22" class="btn_a">新增</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>类型编号</th>
								<th>房源详细类型</th>
								<th>名称</th>
								<th>数据状态</th>
								<th>排序</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['type_no']); ?></td>
								<td><?php if($vo['info_type']==0){echo"装修";}elseif($vo['info_type']==1){echo"付款方式";}elseif($vo['info_type']==2){echo"房间类型";}elseif($vo['info_type']==3){echo"公共设施";}elseif($vo['info_type']==4){echo"房屋类型";}elseif($vo['info_type']==5){echo"房东喜欢的租客";}elseif($vo['info_type']==6){echo"租金";}elseif($vo['info_type']==7){echo"面积";}elseif($vo['info_type']==8){echo"性别";}elseif($vo['info_type']==9){echo"年龄范围";}elseif($vo['info_type']==15){echo"业务类型";}elseif($vo['info_type']==16){echo"品牌";}elseif($vo['info_type']==17){echo"星座";}elseif($vo['info_type']==18){echo"行业";}?></td>
								<td><?php echo ($vo['name']); ?></td>
								<td><?php if($vo['is_display']==1){echo"显示";}else{echo"隐藏";}?></td>
								<td><?php echo ($vo['index_no']); ?></td>
								<td><a href="<?php echo U('Paramhouse/delParamHouse');?>?paid=<?php echo ($vo['id']); ?>">删除</a>&nbsp;&nbsp;&nbsp;
								<a href="/hizhu/Paramhouse/upParamHouse.html?no=1&leftno=22&paid=<?php echo ($vo['id']); ?>&type=1">修改</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			</div>
			
		</div>
	</div>
	<script type="text/javascript">
	/*提交表单*/
 function check(){
	   var type_no=$("input[name='type_no']").val();
	   var name=$("input[name='name']").val();
	   var index_no=$("input[name='index_no']").val();
	   if(type_no==""){
		    alert("类型编号不能为空！");
		    $("#type_no").focus();
		    return false;
	   }else if(name==""){
		   alert("名称不能为空！");
		   $("#name").attr("value","");
		   $("#name").focus();
		   return false;
	   }else if(index_no==""){
		   alert("排序不能为空！");
		   $("#index_no").attr("value","");
		   $("#index_no").focus();
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