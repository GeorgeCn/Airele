<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>版本信息</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <style type="text/css">
   .js_days{display: none;}
    </style>
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
				<h2>APP类型</h2>
				<form action="/hizhu/VersionInfo/versioninfolist" method="get">
					<input type="hidden" name="no" value="1">
					<input type="hidden" name="leftno" value="158">
					<table class="table_one">
						<tr>
							<td class="td_title">软件类型：</td>
							<td class="td_main ">
								<select name="softtype">
									<option value="0" <?php echo ($type == 0?'selected':''); ?>>租客版</option>
									<option value="1" <?php echo ($type == 1?'selected':''); ?>>房东版</option>
									<option value="2" <?php echo ($type == 2?'selected':''); ?>>hi租房pro</option>
								</select>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
				 </form>	  
			</div>
				<div class="common_main">
				<h2>版本信息<a href="/hizhu/VersionInfo/addinfo.html?no=1&leftno=158" class="btn_a">新增</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>版本号</th>
								<th>标题</th>
								<th>内容</th>
								<th>更新类型</th>
								<th>URL地址</th>
								<th>操作时间</th>
								<th>操作人</th>
								<th>平台</th>
								<th>状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['curver']); ?></td>
								<td><?php echo ($vo['title']); ?></td>
								<td><?php echo ($vo['content']); ?></td>
								<td>
									<?php if($vo['update_type'] == 0 ): ?>提示更新
									<?php elseif($vo['update_type'] == 1 ): ?>
									强制更新
									<?php else: ?>无需更新<?php endif; ?>
								</td>
								<td><?php echo ($vo['url']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td><?php echo ($vo['create_man']); ?></td>
								<td><?php echo ($vo['platform']); ?></td>
								<td><a href="javascript:;" onclick="startSet('<?php echo ($type); ?>','<?php echo ($vo[id]); ?>','<?php echo ($vo[is_using]); ?>')" class="btn_a" style="min-width:50px">
									<?php if($vo["is_using"] == 0): ?>待启用
									<?php elseif($vo["is_using"] == 1): ?>启用中<?php endif; ?>
								</a></td>
								<td><a href="javascript:;" onclick="DeleteById('<?php echo ($pagecount); ?>','<?php echo ($type); ?>','<?php echo ($vo[id]); ?>',this);">删除</a>
								<a href="/hizhu/VersionInfo/modifyinfo.html?no=1&leftno=158&id=<?php echo ($vo['id']); ?>&type=<?php echo ($type); ?>">修改</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				        <div class="skip cf">
						<p class="fl skip_left" id="count">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right" >
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
			</div>
			
		</div>
	</div>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">
    function DeleteById(count,type,id,obj){
 	  if(confirm('确定删除吗？')){
			$.get("/hizhu/VersionInfo/deletebyid.html",{type:type,id:id,},function(data){
				alert(data);
				$(obj).parent().parent().remove();
			});
			$('#count').html("共"+(count-1)+"条记录，每页10条");
		}
   	}
   	function startSet(type,id,is_using) {
   		$.get("<?php echo U(modifyVersionUsing);?>",{type:type,id:id,is_using},function(data){
   			var obj = eval('('+data+')');
   			if(obj.status==400) alert(data.message);
   			if(obj.status==200) location.reload(true); 			
   		});
   	}
</script>
</body>
</html>