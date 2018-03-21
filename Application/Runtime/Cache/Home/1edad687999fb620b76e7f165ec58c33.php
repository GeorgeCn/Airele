<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>楼盘字典列表</title>
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
				<h2>楼盘查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Estate/EstateList.html" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="61">
						<table class="table_one">
							<tr>
								<td class="td_title">楼盘名称：</td>
								<td class="td_main"><input type="text" name="estate_name" value="<?php echo isset($_GET['estate_name'])?$_GET['estate_name']:'';?>"></td>
						
								<td class="td_title">业务类型：</td>
								<td class="td_main">
									<select id="business_type" name="business_type">
									    <option value="">全部</option>
										<?php echo ($businessTypeList); ?>
									</select>
								</td>
								<td class="td_title">品牌公寓：</td>
								<td class="td_main">
									<select id="brand_type" name="brand_type">
									    <option value="">全部</option>
										<?php echo ($brandtype); ?>
									</select>
								</td>
							</tr>
					     <tr>
							
							<td class="td_title">楼盘地址：</td>
							<td class="td_main"><input type="text" name="address" value="<?php echo I('get.address'); ?>"></td>
							<td class="td_title">区域&板块：</td>
							<td class="td_main">
								<select id="ddl_region" name="region" style="width:100px">
										<option value=""></option>
										<?php echo ($regionList); ?>
									</select>
									<select id="ddl_scope" name="scope" style="width:100px">
										<?php echo ($scopeList); ?>
									</select>
							</td>
							<td class="td_title">房屋类型：</td>
							<td class="td_main">
								<select  name="housetype" id="js_house_type">
								   <option value="">请选择</option>
								  <?php echo ($housetype); ?>
						     	</select>
							</td>
						</tr>
						<tr>
							<td class="td_title">楼盘编号：</td>
							<td class="td_main"><input type="text" name="estatecode" value="<?php echo I('get.estatecode'); ?>"></td>
							
							<td class="td_title">创建人：</td>
							<td class="td_main">
								<input type="text" name="create_man" value="<?php echo I('get.create_man'); ?>">
							</td>
								<td class="td_title">创建时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="starttime" value="<?php echo I('get.starttime'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endtime" value="<?php echo I('get.endtime'); ?>"></td>
						</tr>
						</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>楼盘列表<a href="javascript:;" class="btn_a" id="btnSubmitOne">合并处理</a>
					<a style="margin-left:150px;" target="_blank" href="/hizhu/Estate/addestate.html?no=3&leftno=61" class="btn_a">新增楼盘</a>
					<a style="margin-left:270px;" href="/hizhu/Estate/downloadExcel?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th><label><input type="checkbox" id="checkall">合并</label></th>
								<th>保留一个</th>
								<th>楼盘名称</th>
								<th>楼盘编号</th>
								<th>楼盘地址</th>
								<th>品牌</th>
								<th>坐标(经度)</th>
								<th>坐标(纬度)</th>
								<th>区域</th>
								<th>商圈</th>
								<th>创建时间</th>
								<th>业务类型</th>
								<th>房屋类型</th>
								<th>创建人</th>
								<th>操作</th><th>地铁</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox" name="checkAll" value="<?php echo ($vo["id"]); ?>"></td>
								<td><input type="checkbox" name="checkOne" value="<?php echo ($vo["id"]); ?>"></td>
								<td><?php echo ($vo["estate_name"]); ?></td>
								<td><?php echo ($vo["estate_code"]); ?></td>
								<td><?php echo ($vo["estate_address"]); ?></td>
								<td><?php echo ($vo["brand_type"]); ?></td>
								<td><?php echo ($vo["lpt_x"]); ?></td>
								<td><?php echo ($vo["lpt_y"]); ?></td>
								<td><?php echo ($vo["region_name"]); ?></td>
								<td><?php echo ($vo["scope_name"]); ?></td>
								<td><?php echo (date("Y-m-d H:i",$vo['create_time'])); ?></td>
								<td><?php echo ($vo["business_type"]); ?></td>
								<td><?php echo ($vo["house_type"]); ?></td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><a target="_blank" href="/hizhu/Estate/editestate?no=3&leftno=61&estate_id=<?php echo ($vo["id"]); ?>">修改</a></td>
								<td><a target="_blank" href="/hizhu/Estate/editsubway?no=3&leftno=61&estate_id=<?php echo ($vo["id"]); ?>">更新地铁</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?></button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');
	$("#js_house_type").val("<?php echo I('get.housetype'); ?>");

$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2020,format:"Y-m-d"});
	$("#business_type").val('<?php echo isset($_GET["business_type"])?$_GET["business_type"]:"" ?>');
	$("#brand_type").val('<?php echo isset($_GET["brand_type"])?$_GET["brand_type"]:"" ?>');
	$("#dataDiv table tr").each(function(){
		var td_object=$(this).children("td:eq(11)");
		var b_type_name=$("#business_type option[value="+td_object.text()+"]").text();
		td_object.text(b_type_name);
		var td_object1=$(this).children("td:eq(12)");
		console.log(td_object1.text())
		var b_type_name1=$("#js_house_type option[value="+td_object1.text()+"]").text();
		if(b_type_name1!="请选择"){
		td_object1.text(b_type_name1);
	    }
	    var td_object2 = $(this).children("td:eq(5)");
	    var b_type_name2 = $("#brand_type option[value="+td_object2.text()+"]").text();
	    if(b_type_name2 !="全部"){
		td_object2.text(b_type_name2);
	    }
	});
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			return $("#ddl_scope").html("");
		}
		$.get("/hizhu/HouseResource/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});
	/*勾选 */
	$("#checkall").click(function(){
		if($(this).attr("checked")=="checked"){
			$("input[name='checkAll']").attr("checked","checked");
		}else{
			$("input[name='checkAll']").removeAttr("checked");
		}
	});
	/*提交合并 */
	$("#btnSubmitOne").bind("click",function(){
		submitEdit();
	});
	function submitEdit(){
		var ids="";var one_id="";
		var select_object;
		$("#dataDiv table tr").each(function(){
			select_object=$(this).children("td:eq(0)").find("input");
			if(select_object.attr("checked")=="checked"){
				ids+=select_object.val()+",";
			}
			select_object=$(this).children("td:eq(1)").find("input");
			if(select_object.attr("checked")=="checked"){
				one_id=select_object.val();
			}
		});
		if(ids==""){
			alert("需勾选合并的项");return;
		}
		if(one_id==""){
			alert("需勾选保留的项");return;
		}
		$("#btnSubmitOne").unbind("click").text("处理中");
		$.post("/hizhu/Estate/mergeEstate",{ids:ids,one_id:one_id},function(data){
			alert(data.message);
			if(data.status=="200"){
				//document.location.reload();
				$("#btnSubmitOne").text("处理完成");
			}else{
				$("#btnSubmitOne").bind("click",function(){
					submitEdit();
				}).text("合并处理");
			}
		},"json");
	}
</script>
</html>