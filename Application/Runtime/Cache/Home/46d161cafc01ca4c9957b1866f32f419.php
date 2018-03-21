<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>banner配置</title>
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
			<h2></h2>
				<!-- 	<form action="<?php echo U('Paramappico/paramAppIcoList');?>" method="get">
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
					 </form> -->
				</div>
				<div class="common_main">
					<h2>Banner列表<a href="/hizhu/AdConfiguration/addtemp.html?no=2&leftno=139" class="btn_a">新增banner</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>banner图片</th>
								<th>跳转地址</th>
								<th>排序</th>
								<th>显示/隐藏</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><img src="<?php echo ($vo['img_url']); ?>" style="width:180px;height:120px;margin:5px;"/></td>
								<td><?php echo ($vo['link']); ?></td>
								<td><?php echo ($vo['sort_index']); ?></td>
								<td><?php if($vo['is_display']==0){echo"隐藏";}elseif($vo['is_display']==1){echo"显示";}?></td>
								<td><a href="javascript:;" onclick="if(confirm('确定要删除吗？')){deletedata('<?php echo ($vo['id']); ?>');}">删除</a>&nbsp;&nbsp;&nbsp;
								<a href="/hizhu/AdConfiguration/updatetemp.html?no=1&leftno=139&upid=<?php echo ($vo['id']); ?>">修改</a></td>
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
   <script>
   	function deletedata(pid){
		$.post('/hizhu/AdConfiguration/removeAdindex.html',{pid:pid},function(data){
			if(data.status!="200"){
				alert(data.msg);
			}window.location.reload();
		},'json');
	}

   </script>
</body>
</html>