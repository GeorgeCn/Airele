<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>小区映射关系列表</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
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
			<a class="blue" href="javascript:;">欢迎您 <?php echo cookie("admin_user_name");?></a>
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
				<h2>查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Estate/EstatemapList.html" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="110">
						<input type="hidden" name="totalCount" value="<?php echo ($totalCount); ?>"> 
						<table class="table_one">
							<tr>
								<td class="td_title">第三方：</td>
								<td class="td_main">
									<select id="third_name" name="third_name">
										<option value="">全部</option>
										<?php echo ($flats); ?>
									</select>
								</td>
								<td class="td_title">第三方小区名称：</td>
								<td class="td_main"><input type="text" name="estatename" value="<?php echo I('get.estatename'); ?>"></td>
								<td class="td_title">处理状态</td>
								<td class="td_main">
									<select name="type">
							    	<option value="1" <?php if(I('get.type')=="1"){echo "selected";}?>>待处理</option>
							    	<option value="2" <?php if(I('get.type')=="2"){echo "selected";}?>>已完成</option>
							    	</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">区域：</td>
								<td class="td_main">
									<select name="region_third">
										<option value="">全部</option>
										<?php echo ($regionThirdList); ?>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表<a target="_blank" href="/hizhu/Estate/addestatemap.html?no=3&leftno=110" class="btn_a">新增</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>第三方</th>
								<th>第三方小区名称</th>
								<th>第三方区域板块</th>
								<th>嗨住楼盘</th>
								<th>嗨住楼盘区域板块</th>
								<th>处理状态</th>
								<th>修改时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo["third_name"]); ?></td>
								<td><?php echo ($vo["estate_name_third"]); ?></td>
								<td><?php echo ($vo["region_third"]); ?>-<?php echo ($vo["scope_third"]); ?></td>
								<td><?php echo ($vo["estate_name"]); ?></td>

								<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
								<td>
									<?php if(($vo["estate_name"] == '')): ?>待处理
									<?php elseif(($vo["estate_name"] != '')): ?>
									 已完成<?php endif; ?>
								</td>
								<td><?php if(($vo["update_time"] > 0)): echo (date("Y-m-d H:i:s",$vo['update_time'])); endif; ?></td>
								<td><a target="_black" href="/hizhu/Estate/editestatemap?no=3&leftno=110&id=<?php echo ($vo["id"]); ?>">修改</a>
								<a href="javascript:;" onclick="DeleteById('<?php echo ($totalCount); ?>','<?php echo ($vo["id"]); ?>',this);">删除</a></td>							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				<div class="skip cf">
						<p class="fl skip_left" id="count">共<?php echo ($totalCount); ?>条记录，每页20条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">
	$('#btnSearch').click(function(){
		$(this).unbind('click').text('搜索中');
		$('form').submit();
	});
	$("#third_name").val('<?php echo I("get.third_name"); ?>');
	$("select[name='region_third']").val('<?php echo I("get.region_third"); ?>');
	function DeleteById(count,mid,obj) {
 	  	if(confirm('确定删除吗？')){
			$.post("/hizhu/Estate/removeEstatemap.html",{id:mid},function(data){
				alert(data.message);
				$(obj).parent().parent().remove();
				$('#count').html("共"+(count-1)+"条记录，每页20条");
			},'json');
			
		}
   }
</script>
</html>