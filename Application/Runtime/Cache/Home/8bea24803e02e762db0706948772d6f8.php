<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>举报管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
<style>
        td{word-wrap:break-word;word-break:break-all;}
    	th.number{width:25%;}
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
				<h2>举报查询</h2>
				<div class="common_head_main">
					<form action="/hizhu/Report/reportlist.html" method="get">
					<input type="hidden" name="no" value="3"/>
					<input type="hidden" name="leftno" value="62"/>
						<table class="table_one">
							<tr>
								<td class="td_title">举报时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo $_GET['startTime'];?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo $_GET['endTime'];?>"></td>
								<td class="td_title">房间编号：</td>
						        <td class="td_main"><input type="text" name="roomno" value="<?php echo $_GET['roomno'] ?>"></td>
								<td class="td_title">房东电话：</td>
								<td class="td_main"><input  type="text" name="ownermobile" value="<?php echo $_GET['ownermobile'] ?>"></td>
								
							</tr>
							<tr>
						    	<td class="td_title">举报人电话：</td>
								<td class="td_main"><input type="text" name="customermobile" value="<?php echo $_GET['customermobile'] ?>"></td>
								<td class="td_title">状态：</td>
						        <td class="td_main">
						        	<select name="dealflag">
										<option value=""<?php if($_GET['dealflag']===""){echo "selected";}?>>全部</option>
										<option value="0"<?php if(strlen($_GET['dealflag'])==1){echo "selected";}?>>待审核</option>
										<option value="1"<?php if($_GET['dealflag']==1){echo "selected";}?>>已通过</option>
										<option value="2"<?php if($_GET['dealflag']==2){echo "selected";}?>>已拒绝</option>
									</select>
						        </td>
								<td class="td_title">举报类型：</td>
								<td class="td_main">
									<select name="reporttype">
										<option value=""<?php if($_GET['reporttype']===""){echo "selected";}?>>全部</option>
										<option value="1"<?php if($_GET['reporttype']==1){echo "selected";}?>>房间已出租</option>
										<option value="2"<?php if($_GET['reporttype']==2){echo "selected";}?>>房东不接电话</option>
										<option value="3"<?php if($_GET['reporttype']==3){echo "selected";}?>>房东是中介</option>
										<option value="5"<?php if($_GET['reporttype']==5){echo "selected";}?>>房间地址错误</option>
										<option value="6"<?php if($_GET['reporttype']==6){echo "selected";}?>>房间信息错误</option>
										<option value="4"<?php if($_GET['reporttype']==4){echo "selected";}?>>其他</option>
									</select>

								</td>
								
							</tr>
						</table>
						<p class="head_p"><button class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>举报列表<a href="/hizhu/Report/downloadExcel.html?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房源编号</th>
								<th>房间编号</th>
								<th>房间来源</th>
								<th>负责人</th>
								<th>房东电话</th>
								<th>举报人电话</th>
								<th>举报类型</th>
								<th class="number">举报内容</th>
								<th>举报时间</th>
								<th>处理时间</th>
								<th>状态</th>
								<th>审核</th>
								<th>操作人</th>
							</tr>
						</thead>
						<tbody>
							  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo ($i); ?></td>
									<td><a href="/hizhu/HouseResource/addresource?resource_id=<?php echo ($vo["resource_id"]); ?>" target="_blank"><?php echo ($vo["resource_no"]); ?></a></td>
									<td><a href="/hizhu/HouseRoom/modifyroom?room_id=<?php echo ($vo["room_id"]); ?>&handle=search" target="_blank"><?php echo ($vo["room_no"]); ?></a></td>
									<td></td>
									<td></td>
									<td><?php echo ($vo["owner_mobile"]); ?></td>
									<td><?php echo ($vo["customer_mobile"]); ?></td>
									<td>
										<?php if(strtoupper($vo['report_type']) == '1'): ?>房间已出租
										<?php elseif($vo['report_type'] == '2'): ?>房东不接电话
										<?php elseif($vo['report_type'] == '3'): ?>房东是中介
										<?php elseif($vo['report_type'] == '4'): ?>其他
										<?php elseif($vo['report_type'] == '5'): ?>房间地址错误
										<?php elseif($vo['report_type'] == '6'): ?>房间信息错误<?php endif; ?>
									</td>
									<td><?php echo ($vo["report_content"]); ?></td>
									<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
									<td><?php if($vo['deal_time'] != 0): echo (date("Y-m-d H:i:s",$vo['deal_time'])); endif; ?></td>
									<td>
										<?php if(strtoupper($vo['deal_flag']) == '0'): ?>待审核
										<?php elseif($vo['deal_flag'] == '1'): ?>已通过
										<?php elseif($vo['deal_flag'] == '2'): ?>已拒绝<?php endif; ?>
									</td>
									<td>
								    	<a href="<?php echo U('Report/reportaudit');?>?pid=<?php echo ($vo["id"]); ?>&no=3&leftno=62">审核</a>
									</td>
									<td><?php echo ($vo["oper_name"]); ?></td>
									<input type="hidden" name="room_id" value="<?php echo ($vo["room_id"]); ?>">
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left"><?php if(strtoupper($pagecount) != ''): ?>共<?php echo ($pagecount); ?>条记录，每页15条<?php endif; ?></p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
    </script>

    <script type="text/javascript">
    		  $(".table table tr").each(function(index,object){
		      var room_id=$(object).find("input[name='room_id']").val();
		      if(room_id!="undefined"&&room_id!=""){
			       $.get("/hizhu/Report/gethousesource.html",{room_id:room_id,index:index},function(data){
			         	var info_resource=data.info_resource;
			         	var create_man=data.create_man;
					   if(info_resource!=null){
							   $(".table table").find("tr:eq("+index+")").children("td:eq(3)").text(info_resource);
						}
						if(create_man!=""){
							 $(".table table").find("tr:eq("+index+")").children("td:eq(4)").text(create_man);
						}
					},"json");
			    }
			});

    </script>
</body>
</html>