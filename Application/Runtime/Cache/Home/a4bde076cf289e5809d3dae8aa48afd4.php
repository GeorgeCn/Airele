<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房间列表</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css">
       <style>
	.title_filter{margin:10px 0;padding:10px 1em;background:#fff;border-top:1px solid #eee;border-bottom:1px solid #eee;display:none;}
	.title_filter label{display: inline-block;line-height:30px;margin-right:18px;}
	.title_filter label input{display: inline-block;vertical-align:-2px;}
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
				<h2>房间查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseRoom/searchroom" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="44"> 
						<input type="hidden" id="jump" name="p">
						<input type="hidden" name="searchtype">
						<table class="table_one">
							<tr>
								<td class="td_title">房间状态</td>
								<td class="td_main">
									<select id="roomStatus" name="roomStatus" style="width:130px;">
										<option value="">全部</option>
										<option value="2" <?php if(I('get.roomStatus')=='2' || !isset($_GET['delState'])){echo "selected";} ?>>未入住</option>
										<option value="3" <?php if(I('get.roomStatus')=='3'){echo "selected";} ?>>已出租</option>
										<option value="4" <?php if(I('get.roomStatus')=='4'){echo "selected";} ?>>待维护</option>
										<option value="0" <?php if(I('get.roomStatus')=='0'){echo "selected";} ?>>待审核</option>
										<option value="1" <?php if(I('get.roomStatus')=='1'){echo "selected";} ?>>审核未通过</option>
									</select>&nbsp;	
								</td>
								<td class="td_title">区域板块：</td>
								<td class="td_main">
									<select id="ddl_region" name="region" style="width:100px">
										<option value=""></option>
										<?php echo ($regionList); ?>
									</select>
									<select id="ddl_scope" name="scope" style="width:100px">
										<?php echo ($scopeList); ?>
									</select>
								</td>
								<td class="td_title">房间负责人：</td>
								<td class="td_main">
									<!--可输入的下拉列表-->
									<input type="text" id="createman_input" style="width:100px">
									<div id="estate_div" class="plotbox" style="width:98px;">
										<ul>
										</ul>
									</div>
									<select id="create_man" name="create_man" style="width:80px">
										<option value=""></option>
										<?php echo ($createManList); ?>
									</select> 
								</td>
							</tr>
							<tr>
								<td class="td_title">删除状态：</td>
								<td class="td_main"><select name="delState" style="width:120px;">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.delState')=='1' || !isset($_GET['delState'])){echo "selected";} ?>>未删除</option>
										<option value="0"<?php if(I('get.delState')=='0'){echo "selected";} ?>>已删除</option>
									</select>
								</td>
								<td class="td_title">小区名称：</td>
								<td class="td_main"><input type="text" name="estateName" value="<?php echo isset($_GET['estateName'])?$_GET['estateName']:'' ?>">
								</td>
								<td class="td_title">发布人负责人：</td>
								<td class="td_main">
									<!--可输入的下拉列表-->
									<input type="text" id="txt_principal_man" style="width:100px">
									<div id="div_principal_man" class="plotbox" style="width:98px;">
										<ul>
										</ul>
									</div>
									<select id="principal_man" name="principal_man" style="width:80px">
										<option value=""></option>
										<?php echo ($createManList); ?>
									</select> 
								</td>
							</tr>
							<tr>
								<td class="td_title">创建日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_create" value="<?php echo isset($_GET['startTime_create'])?$_GET['startTime_create']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_create" value="<?php echo isset($_GET['endTime_create'])?$_GET['endTime_create']:'' ?>">
								</td>
								<td class="td_title">租金范围：</td>
								<td class="td_main">
									<input type="tel" name="moneyMin" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMin');?>">~
									<input type="tel" name="moneyMax" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMax');?>">
								</td>
								<td class="td_title">最近操作人：</td>
								<td class="td_main">
									<!--可输入的下拉列表-->
									<input type="text" id="txt_update_man" style="width:100px">
									<div id="div_update_man" class="plotbox" style="width:98px;">
										<ul>
										</ul>
									</div>
									<select id="update_man" name="update_man" style="width:80px">
										<option value=""></option>
										<?php echo ($createManList); ?>
									</select> 
								</td>	
							</tr>
							<tr>
								<td class="td_title">更新日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:'' ?>">
								</td>
								<td class="td_title">租赁类型：</td>
								<td class="td_main">
									<select id="rent_type" name="rent_type">
										<option value="">全部</option>
										<option value="1">合租</option>
										<option value="2">整租</option>
									</select> 
								</td>
								<td class="td_title">发布人电话：</td>
								<td class="td_main"><input type="text" name="clientPhone" value="<?php echo isset($_GET['clientPhone'])?$_GET['clientPhone']:'' ?>">
								</td>
							</tr>
							<tr>
								<td class="td_title">数据来源：</td>
								<td class="td_main">
									<select name="info_resource_type" style="width:100px;">
										<?php echo ($infoResourceTypeList); ?>
									</select>
									<select name="info_resource" style="width:100px;">
										<option value=""></option>
										<?php echo ($infoResourceList); ?>
									</select>
								</td>
								<td class="td_title">户型（室）：</td>
								<td class="td_main">
									<select id="room_num" name="room_num">
										<option value="">全部</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="2+">2室及以上</option>
										<option value="3+">3室及以上</option>
									</select> 
								</td>
								<td class="td_title">发布人属性：</td>
								<td class="td_main">
									<select id="is_owner" name="is_owner">
										<option value="">全部</option>
										<option value="3">个人房东</option>
										<option value="4">职业房东</option>
										<option value="5">中介经纪人</option>
									</select> 
								</td>	
							</tr>
							<tr>	
								<td class="td_title">房间编号：</td>
								<td class="td_main"><input type="text" name="roomNo" value="<?php echo isset($_GET['roomNo'])?$_GET['roomNo']:'' ?>">
								</td>
								<td class="td_title">房源面积：</td>
								<td class="td_main">
									<input type="tel" name="houseareaMin" maxlength="6" style="width:100px;" value="<?php echo I('get.houseareaMin');?>">~
									<input type="tel" name="houseareaMax" maxlength="6" style="width:100px;" value="<?php echo I('get.houseareaMax');?>">
								</td>
								<td class="td_title">品牌：</td>
								<td class="td_main">
									<select id="brand_type" name="brand_type">
										<option value="">全部</option>
										<?php echo ($brandTypeList); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">第三方编号：</td>
								<td class="td_main"><input type="text" name="third_no" value="<?php echo isset($_GET['third_no'])?$_GET['third_no']:''; ?>">
								</td>
								<td class="td_title">房间面积：</td>
								<td class="td_main">
									<input type="tel" name="roomareaMin" maxlength="6" style="width:100px;" value="<?php echo I('get.roomareaMin');?>">~
									<input type="tel" name="roomareaMax" maxlength="6" style="width:100px;" value="<?php echo I('get.roomareaMax');?>">
								</td>
								<td class="td_title">付费：</td>
								<td class="td_main">
									<select name="isFee">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.isFee')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.isFee')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>	
							</tr>
							<tr>
								<td class="td_title">业务类型：</td>
								<td class="td_main">
									<select id="business_type" name="business_type">
										<option value="">全部</option>
										<?php echo ($businessTypeList); ?>
									</select>
								</td>
								<td class="td_title">聚合状态：</td>
								<td class="td_main">
									<select name="isGroup">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.isGroup')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.isGroup')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>
								<td class="td_title">包月：</td>
								<td class="td_main">
									<select name="isMonth">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.isMonth')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.isMonth')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>
								
							</tr>
							<tr>
								<td class="td_title">视频房源：</td>
								<td class="td_main">
									<select name="isVedio">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.isVedio')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.isVedio')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>
								<td class="td_title">转租房源：</td>
								<td class="td_main">
									<select name="isRental">
										<option value="">全部</option>
										<option value="1"<?php if(I('get.isRental')=="1"){echo"selected";}?>>是</option>
										<option value="0"<?php if(I('get.isRental')=="0"){echo"selected";}?>>否</option>
									</select>
								</td>
								<td class="td_title">佣金：</td>
								<td class="td_main">
									<select id="is_commission" name="is_commission">
										<option value="">全部</option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>	
							</tr>
						</table>
					</form>
					<select id="roomtype" style="display:none;"><?php echo ($roomTypeList); ?></select>
					<p class="head_p"><button class="btn_a" id="btn_summary">统计</button>&nbsp;&nbsp;<button class="btn_a" id="btn_search">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>房间列表<a href="/hizhu/HouseRoom/downloadExcel?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a><span class="btn_a mes_filter" style="margin-left:200px;">表格筛选</span></h2>
				<div class="title_filter"><!-- 表格标题筛选 -->
					<label><input type="checkbox" checked name="name1"> 序号</label>
					<label><input type="checkbox" checked name="name2"> 房源编号</label>
					<label><input type="checkbox" checked name="name3"> 房间编号</label>
					<label><input type="checkbox" checked name="name4"> 数据来源</label>
					<label><input type="checkbox" checked name="name5"> 小区名称</label>
					<label><input type="checkbox" checked name="name6"> 区域板块</label>
					<label><input type="checkbox" checked name="name7"> 业务类型</label>
					<label><input type="checkbox" checked name="name8"> 户型</label>
					<label><input type="checkbox" checked name="name9"> 租赁类型</label>
					<label><input type="checkbox" checked name="name10"> 房源面积</label>
					<label><input type="checkbox" checked name="name11"> 单间名称</label>
					<label><input type="checkbox" checked name="name12"> 房间面积</label>
					<label><input type="checkbox" checked name="name13"> 租金</label>
					<label><input type="checkbox" checked name="name14"> 发布人属性</label>
					<label><input type="checkbox" checked name="name15"> 发布人姓名</label>
					<label><input type="checkbox" checked name="name16"> 发布人电话</label>
					<label><input type="checkbox" checked name="name17"> 房间状态</label>
					<label><input type="checkbox" checked name="name18"> 创建日期</label>
					<label><input type="checkbox" checked name="name19"> 更新日期</label>
					<label><input type="checkbox" checked name="name20"> 最近操作人</label>
					<label><input type="checkbox" checked name="name21"> 房间负责人</label>
					<label><input type="checkbox" checked name="name22"> 发布人负责人</label>
					<label><input type="checkbox" checked name="name23"> 佣金</label>
					<label><input type="checkbox" checked name="name24"> 包月</label>
					<label><input type="checkbox" checked name="name25"> 付费</label>
					<label><input type="checkbox" checked name="name26"> 更新操作</label>
					<label><input type="checkbox" checked name="name27"> 维护状态</label>
					<label><input type="checkbox" checked name="name28"> 修改房间</label>
					<label><input type="checkbox" checked name="name29"> 历史信息</label>
					<label><input type="checkbox" checked name="name30"> 报价</label>
					<button class="btn_a">确定</button>
				</div>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房源编号</th>
								<th>房间编号</th>
								<th>数据来源</th>
								<th>小区名称</th>
								<th>区域板块</th>
								<th>业务类型</th>
								<th>户型</th>
								<th>房间类型</th>
								<th>房源面积</th>
								<th>单间名称</th>
								<th>房间面积</th>
								<th>租金</th>
								<th>发布人属性</th>
								<th>发布人姓名</th>
								<th>发布人电话</th>
								<th>房间状态</th>
								<th>创建日期</th>
								<th>更新日期</th>
								<th>最近操作人</th>
								<th>房间负责人</th>
								<th>发布人负责人</th>
								<th>佣金</th>
								<th>包月</th>
								<th>付费</th>
								<th>视频房源</th>
								<th>转租房源</th>
								<th>更新操作</th>
								<th>维护状态</th>
								<th>修改房间</th>
								<th>历史信息</th>
								<th>报价</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><a target="_blank" href="/hizhu/HouseResource/addresource?resource_id=<?php echo ($list["resource_id"]); ?>"><?php echo ($list["house_no"]); ?></a></td>
								<td><?php echo ($list["room_no"]); ?></td>
								<td><?php echo ($list["info_resource"]); ?></td>
								<td><?php echo ($list["estate_name"]); ?></td>
								<td><?php echo ($list["region_name"]); ?>-<?php echo ($list["scope_name"]); ?></td>
								<td data-bus="<?php echo ($list["business_type"]); ?>" data-status="<?php echo ($list["status"]); ?>"></td>
								<td><?php echo ($list["room_num"]); ?>室<?php echo ($list["hall_num"]); ?>厅<?php echo ($list["wei_num"]); ?>卫</td>
								<td><?php switch($list["rent_type"]): case "1": ?>合租<?php break; case "2": ?>整租<?php break; endswitch;?></td>
								<td><?php echo ($list["area"]); ?></td><td><?php echo ($list["room_name"]); ?></td><td><?php echo ($list["room_area"]); ?></td>
								<td><?php echo ($list["room_money"]); ?></td>
								<td><?php switch($list["is_owner"]): case "3": ?>个人房东<?php break; case "4": ?>职业房东<?php break; case "5": ?>中介经纪人<?php break; default: endswitch;?></td>
								<td><?php echo ($list["client_name"]); ?></td>
								<td><?php echo ($list["client_phone"]); ?></td>
								<?php if($list["status"] == '3'): ?><td style="color:green;"></td>
								<?php elseif($list["status"] == '2'): ?>
									<td style="color:red;"></td>
								<?php else: ?>
									<td></td><?php endif; ?>
								<td><?php if(($list["create_time"]) > "0"): echo (date("Y-m-d H:i",$list["create_time"])); endif; ?></td>
								<td><?php if(($list["update_time"]) > "0"): echo (date("Y-m-d H:i",$list["update_time"])); endif; ?></td>
								<td><?php echo ($list["update_man"]); ?></td>
								<td><?php echo ($list["create_man"]); ?></td>
								<td><?php echo ($list["principal_man"]); ?></td>
								<td><?php if(($list["is_commission"] == '1')): ?>是<?php else: ?>否<?php endif; ?></td>
								<td><?php if(($list["is_monthly"] == '1')): ?>是<?php else: ?>否<?php endif; ?></td>
								<td><?php if(($list["is_commission"] == '0' and $list["is_monthly"] == '0')): ?>否<?php else: ?>是<?php endif; ?></td>
								<td><?php if(($list["had_vedio"] == '1')): ?>是<?php else: ?>否<?php endif; ?></td>
								<td><?php if(($list["rental_type"] == '1')): ?>是<?php else: ?>否<?php endif; ?></td>
								<td><?php if(($list["record_status"] == '1' and $list["status"] == '2')): ?><a href="javascript:;" onclick="reflushTime('<?php echo ($list["id"]); ?>')">刷新</a><?php endif; ?></td>
								<td>
									<?php if($list["record_status"] == '1' ): if($list["status"] == '3'): ?><a href="javascript:;" onclick="chuzuAgain('<?php echo ($list["id"]); ?>')">重新出租</a>
										<?php elseif($list["status"] == '2'): ?>
										<a href="javascript:;" onclick="chuzu('<?php echo ($list["id"]); ?>')">已出租</a>
										<?php else: ?>--<?php endif; ?>
									<?php else: ?><a href="javascript:;" onclick="unsetDelete('<?php echo ($list["id"]); ?>',this)">恢复删除</a><?php endif; ?>
								</td> 
								<td><?php if($list["record_status"] == '1'): ?><a href="/hizhu/HouseRoom/modifyroom?no=3&leftno=44&room_id=<?php echo ($list["id"]); ?>&handle=search">修改</a><?php else: ?>已删除<?php endif; ?></td>
								<td><a target="_blank" href="/hizhu/HouseResource/houseupdatelog?house_id=<?php echo ($list["id"]); ?>&house_type=2">历史记录</a></td>
								<td><a target="_blank" href="/hizhu/HouseOffer/houseroomOfferlist?cuid=<?php echo ($list["customer_id"]); ?>&room_id=<?php echo ($list["id"]); ?>">报价</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<span style="color:red;"><?php echo ($totalcnt); ?></span>条记录，每页8条。&nbsp;总数量：<span style="color:red;"><?php echo ($roomcnt); ?></span>,可租数量：<span style="color:red;"><?php echo ($roomupcnt); ?></span>,房东数：<span style="color:red;"><?php echo ($ownercnt); ?></span></p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>&nbsp;<input type="text" style="width:50px" maxlength="4" id="jumpPage" name="jumpPage">&nbsp;<button onclick="jump()">跳转</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery-1.9.0.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">

	$("#is_commission").val('<?php echo isset($_GET["is_commission"])?$_GET["is_commission"]:"" ?>');
	$("#create_man").val('<?php echo isset($_GET["create_man"])?$_GET["create_man"]:"" ?>');
	$("#update_man").val('<?php echo isset($_GET["update_man"])?$_GET["update_man"]:"" ?>');
	$("#principal_man").val('<?php echo I("get.principal_man"); ?>');
	$("#business_type").val('<?php echo isset($_GET["business_type"])?$_GET["business_type"]:"" ?>');
	$("#brand_type").val('<?php echo isset($_GET["brand_type"])?$_GET["brand_type"]:"" ?>');
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');
	$("#rent_type").val('<?php echo I("get.rent_type"); ?>');
	$("#room_num").val('<?php echo I("get.room_num"); ?>');
	$("select[name='info_resource_type']").val('<?php echo I("get.info_resource_type"); ?>');
	$("select[name='info_resource']").val('<?php echo I("get.info_resource"); ?>');
	$("select[name='is_owner']").val('<?php echo I("get.is_owner"); ?>');
	/*键值转换，业务类型、房间状态*/
	$("#dataDiv table tbody tr").each(function(){
		var td_object=$(this).children("td:eq(6)");
		var business_type=$("#business_type option[value="+td_object.attr('data-bus')+"]").text();

		var status=$("#roomStatus option[value="+td_object.attr('data-status')+"]").text();
		td_object.text(business_type);
		$(this).children("td:eq(16)").html(status);
	});
	$('.inpt_a').datetimepicker({validateOnBlur:true,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});

	$("#btn_search").click(function(){
		$(this).unbind('click').text('搜索中..');
		$("input[name='searchtype']").val('select');
		$("#searchForm").submit();
	});
	$("#btn_summary").click(function(){
		$(this).unbind('click').text('统计中..');
		$("input[name='searchtype']").val('summary');
		$("#searchForm").submit();
	});

	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	function reflushTime(room_id){
		$.get("/hizhu/HouseRoom/reflushUpdatetime",{room_id:room_id},function(data){
			alert(data.msg);
		},"json");
	}
	function chuzu(room_id){
		if(confirm("房间“已出租”，将不展示到前台出租列表中，是否确认？")){
			$.post("/hizhu/HouseRoom/rentupdate",{room_id:room_id},function(data){
				alert(data.msg);
				if(data.status=="200"){
					window.location.reload();
				}
			},"json");
		}
	}
	function chuzuAgain(room_id){
		if(confirm("房间“重新出租”，将展示到前台出租列表中，是否确认？")){
			$.post('/hizhu/HouseRoom/rentupdate',{room_id:room_id,rentagain:"1"},function(data){
				alert(data.msg);
				if(data.status=="200"){
					window.location.reload();
				}
			},'json');
		}
	}
	//恢复删除
	function unsetDelete(room_id,obj){
		if(confirm("房间将会被还原，是否确认？")){
			$.get('/hizhu/HouseRoom/resetDelete',{room_id:room_id},function(data){
				alert(data.msg);
				if(data.status=="200"){
					$(obj).parent().text('').next().text('');
				}
			},'json');
		}
	}
	//下拉联动，来源
	$("select[name='info_resource_type']").change(function(){
		if($(this).val()==""){
			$("select[name='info_resource']").html("");
			return;
		}
		$.get("/hizhu/HouseResource/getInforesourceByType",{type:$(this).val()},function(data){
			$("select[name='info_resource']").html('<option value=""></option>'+data);
		},"html");
	});
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseRoom/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});
	/*房间负责人 */
	$("#createman_input").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#estate_div ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectMen('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#estate_div").show();
				}else{
					$("#estate_div").hide();
				}
			}
		},"json");
	});
	function selectMen(userName,realName){
		$("#createman_input").val(realName);
		$("#create_man").val(userName);
		$("#estate_div").hide();
	}
	/*更新人 */
	$("#txt_update_man").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#div_update_man ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectUpdateman('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#div_update_man").show();
				}else{
					$("#div_update_man").hide();
				}
			}
		},"json");
	});
	function selectUpdateman(userName,realName){
		$("#txt_update_man").val(realName);
		$("#update_man").val(userName);
		$("#div_update_man").hide();
	}
	/*房东负责人 */
	$("#txt_principal_man").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#div_principal_man ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectPrincipal('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#div_principal_man").show();
				}else{
					$("#div_principal_man").hide();
				}
			}
		},"json");
	});
	function selectPrincipal(userName,realName){
		$("#txt_principal_man").val(realName);
		$("#principal_man").val(userName);
		$("#div_principal_man").hide();
	}

		// 表格信息筛选
		$(".mes_filter").click(function(){
			$(".title_filter").slideToggle(200);
		});
		$(".title_filter .btn_b").click(function(){
			$(".title_filter").slideUp(200);
		});

		var getLocal = JSON.parse(window.localStorage.getItem("mess2"));
		if (getLocal) {
			$(".title_filter label input").each(function(i){
				var name = $(this).prop("name");
				$(this).prop("checked",getLocal[name]);
				if (getLocal[name]) {
					$(".table tr").each(function(){
						$(this).find("td").eq(i).show();
						$(this).find("th").eq(i).show();
					})
				}else{
					$(".table tr").each(function(){
						$(this).find("td").eq(i).hide();
						$(this).find("th").eq(i).hide();
					})
				};
			})
		};

		$(".title_filter .btn_a").click(function(){
			var input = $(".title_filter label input");
			var Obj = {};
			input.each(function(i){
				var name = $(this).prop("name");
				Obj[name] = $(this).prop("checked");
				console.log(Obj);
				if (Obj[name]) {
					$(".table tr").each(function(){
						$(this).find("td").eq(i).show();
						$(this).find("th").eq(i).show();
					})
				}else{
					$(".table tr").each(function(){
						$(this).find("td").eq(i).hide();
						$(this).find("th").eq(i).hide();
					})
				};
			})
			$(".title_filter").slideUp(200);
			window.localStorage.setItem("mess2",JSON.stringify(Obj));
		});
</script>
</html>