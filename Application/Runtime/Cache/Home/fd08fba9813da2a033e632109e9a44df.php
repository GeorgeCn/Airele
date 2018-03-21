<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>租客追踪列表</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
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
				<h2>搜索条件</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/CustomerTracking/trackinglist" method="get">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="105">
						<input type="hidden" id="jump" name="p">
						<input type="hidden" name="totalCount" value="<?php echo ($totalCount); ?>"> 
						<input type="hidden" id="handleType" name="handleType">
						<table class="table_one">
							<tr>
								<td class="td_title">手机号：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo isset($_GET['mobile'])?$_GET['mobile']:'' ?>"></td>
								<td class="td_title">租住状态：</td>
								<td class="td_main">
									<select id="status" name="status">
										<option value=""></option>
										<option value="1">未租到</option>
										<option value="2">已租到</option>
										<option value="3">拒绝回访</option>
										<option value="4">未接听</option>
										<option value="5">不租了</option>
									</select>
								</td>
								<td class="td_title">看房时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_look" value="<?php echo isset($_GET['startTime_look'])?$_GET['startTime_look']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_look" value="<?php echo isset($_GET['endTime_look'])?$_GET['endTime_look']:'' ?>"></td>
							</tr>
							<tr>
								<td class="td_title">预约时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_appoint" value="<?php echo isset($_GET['startTime_appoint'])?$_GET['startTime_appoint']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_appoint" value="<?php echo isset($_GET['endTime_appoint'])?$_GET['endTime_appoint']:'' ?>"></td>
								<td class="td_title">联系时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_contact" value="<?php echo isset($_GET['startTime_contact'])?$_GET['startTime_contact']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_contact" value="<?php echo isset($_GET['endTime_contact'])?$_GET['endTime_contact']:'' ?>"></td>
								
								<td class="td_title">回访过：</td>
								<td class="td_main">
									<select id="is_tracking" name="is_tracking">
										<option value=""></option>
										<option value="1">是</option>
										<option value="2">否</option>
									</select></td>
							</tr>
							<tr>
								<td class="td_title">预约过：</td>
								<td class="td_main">
									<select id="is_appoint" name="is_appoint">
										<option value=""></option>
										<option value="1">是</option>
										<option value="2">否</option>
									</select></td>
								<td class="td_title">联系过：</td>
								<td class="td_main">
									<select id="is_contact" name="is_contact">
										<option value=""></option>
										<option value="1">是</option>
										<option value="2">否</option>
									</select>
								</td>
								<td class="td_title">回访时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime_tracking" value="<?php echo isset($_GET['startTime_tracking'])?$_GET['startTime_tracking']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime_tracking" value="<?php echo isset($_GET['endTime_tracking'])?$_GET['endTime_tracking']:'' ?>"></td>
							</tr>
							<tr>
								<td class="td_title">城市：</td>
								<td class="td_main">
									<select id="city_code" name="city_code">
										<option value=""></option>
										<option value="001009001">上海</option>
										<option value="001001">北京</option>
										<option value="001011001">杭州</option>
										<option value="001010001">南京</option>
										<option value="001019001">广州</option>
										<option value="001019002">深圳</option>
									</select></td>
								<td class="td_title">是否联系或预约包月房源：</td>
								<td class="td_main">
									<select id="is_monthly" name="is_monthly">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>
								<td class="td_title">是否联系或预约佣金房源：</td>
								<td class="td_main">
									<select id="is_commission" name="is_commission">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">是否看房：</td>
								<td class="td_main">
									<select id="is_look" name="is_look">
										<option value=""></option>
										<option value="1">是</option>
										<option value="2">否</option>
									</select>
								</td>
								<td class="td_title">租房渠道：</td>
								<td class="td_main">
									<select id="renter_sourcetype" name="renter_sourcetype" style="width:100px;">
										<option value=""></option>
										<option value="1">嗨住</option>
										<option value="2">其他</option>
									</select>&nbsp;<input type="input" name="renter_source"  style="width:120px;" value="<?php echo I('get.renter_source'); ?>">
								</td>
								<td class="td_title">筛选：</td>
								<td class="td_main">
									<label>不包含未知<input type="checkbox" id="jsunknown" name="unknown" checked="checked"></label>&nbsp;&nbsp; <label>不包含客户主动放弃<input type="checkbox" id="jsabandon" name="abandon" checked="checked"></label> 
								</td>
							</tr>
							<tr>
								<td class="td_title">申请返现时间：</td>
								<td class="td_main">
									<input class="inpt_a" type="text" name="startTime_applyback" value="<?php echo I('get.startTime_applyback');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime_applyback" value="<?php echo I('get.endTime_applyback');?>">
								</td>
								<td class="td_title">申请返现：</td>
								<td class="td_main">
									<select name="applyback_status">
										<option value=""<?php if($_GET['applyback_status']===""){echo "selected";}?>></option>
										<option value="1"<?php if($_GET['applyback_status']==="1"){echo "selected";}?>>是</option>
										<option value="4"<?php if($_GET['applyback_status']==="4"){echo "selected";}?>>否</option>
									</select>
								</td>
								<td class="td_title">二次回访：</td>
								<td class="td_main">
									<select name="second_visit">
										<option value=""<?php if($_GET['second_visit']===""){echo "selected";}?>></option>
										<option value="1"<?php if($_GET['second_visit']==="1"){echo "selected";}?>>需要</option>
										<option value="2"<?php if($_GET['second_visit']==="2"){echo "selected";}?>>不需要</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">回访来源：</td>
								<td class="td_main">
									<select name="visit_source">
										<option value=""<?php if($_GET['visit_source']===""){echo "selected";}?>></option>
										<option value="1"<?php if($_GET['visit_source']==="1"){echo "selected";}?>>电话回访</option>
										<option value="2"<?php if($_GET['visit_source']==="2"){echo "selected";}?>>房东反馈</option>
										<option value="3"<?php if($_GET['visit_source']==="3"){echo "selected";}?>>保障房源</option>
										<option value="4"<?php if($_GET['visit_source']==="4"){echo "selected";}?>>短信回访</option>
										<option value="5"<?php if($_GET['visit_source']==="5"){echo "selected";}?>>返现申请</option>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button>&nbsp;<button class="btn_a" id="btnSearchAll">并集统计</button>&nbsp;<button class="btn_a" id="btnSearchIn">交集统计</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表展示<a style="margin-left:0px;" href="/hizhu/CustomerTracking/trackingadd.html" target="_blank" class="btn_a">新增</a>&nbsp;<a style="margin-left:90px;" href="/hizhu/CustomerTracking/downloadTracking?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a><span class="btn_a mes_filter" style="margin-left:260px;">表格筛选</span></h2>
				<div class="title_filter"><!-- 表格标题筛选 -->
					<label><input type="checkbox" checked name="name1"> 序号</label>
					<label><input type="checkbox" checked name="name2"> 手机号</label>
					<label><input type="checkbox" checked name="name3"> 注册时间</label>
					<label><input type="checkbox" checked name="name4"> 租住状态</label>
					<label><input type="checkbox" checked name="name5"> 租房渠道类型</label>
					<label><input type="checkbox" checked name="name6"> 租房渠道</label>
					<label><input type="checkbox" checked name="name7"> 继续服务</label>
					<label><input type="checkbox" checked name="name8"> 回访人</label>
					<label><input type="checkbox" checked name="name9"> 最近回访时间</label>
					<label><input type="checkbox" checked name="name10"> 备注</label>
					<label><input type="checkbox" checked name="name11"> 是否看房</label>
					<label><input type="checkbox" checked name="name12"> 是否满意</label>
					<label><input type="checkbox" checked name="name13"> 是否推荐</label>
					<label><input type="checkbox" checked name="name14"> 是否收到佣金</label>
					<label><input type="checkbox" checked name="name15"> 最近联系时间</label>
					<label><input type="checkbox" checked name="name16"> 联系次数</label>
					<label><input type="checkbox" checked name="name17"> 最近看房时间</label>
					<label><input type="checkbox" checked name="name18"> 最近预约时间</label>
					<label><input type="checkbox" checked name="name19"> 预约次数</label>
					<label><input type="checkbox" checked name="name20"> 预约处理人</label>
					<label><input type="checkbox" checked name="name21"> 是否包月</label>
					<label><input type="checkbox" checked name="name22"> 是否佣金</label>
					<label><input type="checkbox" checked name="name23"> 举报次数</label>
					<label><input type="checkbox" checked name="name24"> 城市</label>
					<label><input type="checkbox" checked name="name25"> 申请返现时间</label>
					<label><input type="checkbox" checked name="name26"> 申请返现</label>
					<label><input type="checkbox" checked name="name27"> 是否符合返现条件</label>
					<label><input type="checkbox" checked name="name28"> 二次回访</label>
					<label><input type="checkbox" checked name="name29"> 回访来源</label>
					<label><input type="checkbox" checked name="name30"> 修改</label>
					<button class="btn_a">确定</button>
				</div>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>手机号</th>
								<th>注册时间</th>
								<th>租住状态</th>
								<th>租房渠道类型</th>
								<th>租房渠道</th>
								<th>继续服务</th>
								<th>回访人</th>
								<th>最近回访时间</th>
								<th>备注</th>
								<th>是否看房</th>
								<th>是否满意</th>
								<th>是否推荐</th>
								<th>是否收到佣金</th>
								<th>最近联系时间</th>
								<th>联系次数</th>
								<th>最近看房时间</th>
								<th>最近预约时间</th>
								<th>预约次数</th>
								<th>预约处理人</th>
								<th>是否包月</th>
								<th>是否佣金</th>
								<th>举报次数</th>
								<th>城市</th>
								<th>申请返现时间</th>
								<th>申请返现</th>
								<th>是否符合返现条件</th>
								<th>二次回访</th>
								<th>回访来源</th>
								<th>修改</th>
							</tr>
						</thead>
						<tbody>
							<?php $indx=1; ?>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo $indx;$indx++; ?></td>
								<td><?php echo ($vo["mobile"]); ?></td>
								<td><?php if(($vo["register_time"] > 0)): echo (date("Y-m-d H:i",$vo["register_time"])); endif; ?></td>
								<td><?php switch($vo["renter_status"]): case "1": ?>未租到<?php break; case "2": ?>已租到<?php break; case "3": ?>拒绝回访<?php break; case "4": ?>未接听<?php break; case "5": ?>不租了<?php break; default: endswitch;?></td>
								<td><?php switch($vo["renter_sourcetype"]): case "1": ?>嗨住<?php break; case "2": ?>其他<?php break; endswitch;?></td>
								<td><?php echo ($vo["renter_source"]); ?></td>
								<td><?php switch($vo["is_service"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
								<td><?php echo ($vo["update_man"]); ?></td>
								<td><?php if(($vo["update_time"] > 0)): echo (date("Y-m-d H:i",$vo["update_time"])); endif; ?></td>
								<td><?php echo ($vo["bakinfo"]); ?></td><td><?php switch($vo["is_look"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td><td><?php switch($vo["is_satisfied"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td><td><?php switch($vo["is_recommend"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
								<td><?php switch($vo["is_getcommission"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
								
							<?php switch($vo["city_code"]): case "001001": ?><td><?php if(($vo["contact_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["contact_lasttime"])); endif; ?></td>
									<td><?php if(($vo["contact_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminbj/ContactOwner/contactOwnerList.html?no=3&leftno=28&unknown=0&abandon=0&temp=q&loginphone=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["contact_count"]); ?></a><?php endif; ?></td>
									<td><?php if(($vo["appoint_looktime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_looktime"])); endif; ?></td>
									<td><?php if(($vo["appoint_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_lasttime"])); endif; ?></td>
									<td><?php if(($vo["appoint_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminbj/Appointment/alllist.html?no=87&leftno=89&mobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["appoint_count"]); ?></a><?php endif; ?></td><td><?php echo ($vo["appoint_handleman"]); ?></td><td><?php if(($vo["is_monthly"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td><td><?php if(($vo["is_commission"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td>
									<td><?php if(($vo["report_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminbj/Report/reportlist.html?no=3&leftno=62&customermobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["report_count"]); ?></a><?php endif; ?></td><td>北京</td><?php break;?>
								<?php case "001009001": ?><td><?php if(($vo["contact_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["contact_lasttime"])); endif; ?></td>
									<td><?php if(($vo["contact_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/admin/ContactOwner/contactOwnerList.html?no=3&leftno=28&unknown=0&abandon=0&temp=q&loginphone=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["contact_count"]); ?></a><?php endif; ?></td>
									<td><?php if(($vo["appoint_looktime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_looktime"])); endif; ?></td>
									<td><?php if(($vo["appoint_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_lasttime"])); endif; ?></td>
									<td><?php if(($vo["appoint_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/admin/Appointment/alllist.html?no=87&leftno=89&mobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["appoint_count"]); ?></a><?php endif; ?></td><td><?php echo ($vo["appoint_handleman"]); ?></td><td><?php if(($vo["is_monthly"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td><td><?php if(($vo["is_commission"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td>
									<td><?php if(($vo["report_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/admin/Report/reportlist.html?no=3&leftno=62&customermobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["report_count"]); ?></a><?php endif; ?></td><td>上海</td><?php break;?>
								<?php case "001011001": ?><td><?php if(($vo["contact_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["contact_lasttime"])); endif; ?></td>
									<td><?php if(($vo["contact_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminhz/ContactOwner/contactOwnerList.html?no=3&leftno=28&unknown=0&abandon=0&temp=q&loginphone=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["contact_count"]); ?></a><?php endif; ?></td>
									<td><?php if(($vo["appoint_looktime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_looktime"])); endif; ?></td>
									<td><?php if(($vo["appoint_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_lasttime"])); endif; ?></td>
									<td><?php if(($vo["appoint_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminhz/Appointment/alllist.html?no=87&leftno=89&mobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["appoint_count"]); ?></a><?php endif; ?></td><td><?php echo ($vo["appoint_handleman"]); ?></td><td><?php if(($vo["is_monthly"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td><td><?php if(($vo["is_commission"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td>
									<td><?php if(($vo["report_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminhz/Report/reportlist.html?no=3&leftno=62&customermobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["report_count"]); ?></a><?php endif; ?></td><td>杭州</td><?php break;?>
								<?php case "001010001": ?><td><?php if(($vo["contact_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["contact_lasttime"])); endif; ?></td>
									<td><?php if(($vo["contact_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminnj/ContactOwner/contactOwnerList.html?no=3&leftno=28&unknown=0&abandon=0&temp=q&loginphone=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["contact_count"]); ?></a><?php endif; ?></td>
									<td><?php if(($vo["appoint_looktime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_looktime"])); endif; ?></td>
									<td><?php if(($vo["appoint_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_lasttime"])); endif; ?></td>
									<td><?php if(($vo["appoint_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminnj/Appointment/alllist.html?no=87&leftno=89&mobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["appoint_count"]); ?></a><?php endif; ?></td><td><?php echo ($vo["appoint_handleman"]); ?></td><td><?php if(($vo["is_monthly"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td><td><?php if(($vo["is_commission"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td>
									<td><?php if(($vo["report_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminnj/Report/reportlist.html?no=3&leftno=62&customermobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["report_count"]); ?></a><?php endif; ?></td><td>南京</td><?php break;?>
								<?php case "001019002": ?><td><?php if(($vo["contact_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["contact_lasttime"])); endif; ?></td>
									<td><?php if(($vo["contact_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminsz/ContactOwner/contactOwnerList.html?no=3&leftno=28&unknown=0&abandon=0&temp=q&loginphone=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["contact_count"]); ?></a><?php endif; ?></td>
									<td><?php if(($vo["appoint_looktime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_looktime"])); endif; ?></td>
									<td><?php if(($vo["appoint_lasttime"] > 0)): echo (date("Y-m-d H:i",$vo["appoint_lasttime"])); endif; ?></td>
									<td><?php if(($vo["appoint_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminsz/Appointment/alllist.html?no=87&leftno=89&mobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["appoint_count"]); ?></a><?php endif; ?></td><td><?php echo ($vo["appoint_handleman"]); ?></td><td><?php if(($vo["is_monthly"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td><td><?php if(($vo["is_commission"] > 0)): ?>是<?php else: ?>否<?php endif; ?></td>
									<td><?php if(($vo["report_count"]) > "0"): ?><a target="_blank" href="http://120.26.119.103/adminsz/Report/reportlist.html?no=3&leftno=62&customermobile=<?php echo ($vo["mobile"]); ?>"><?php echo ($vo["report_count"]); ?></a><?php endif; ?></td><td>深圳</td><?php break;?>
								<?php default: ?>
									<td></td>
									<td></td>
									<td></td>
									<td></td><td></td><td></td><td></td>
									<td></td><td></td><td></td><?php endswitch;?>
								
								<td><?php if(($vo["applyback_time"] > 0)): echo (date("Y-m-d H:i",$vo["applyback_time"])); endif; ?></td>
								<td><?php switch($vo["applyback_status"]): case "1": ?>是<?php break; case "0": ?>否<?php break; default: endswitch;?></td>
								<td><?php switch($vo["is_cashback"]): case "1": ?>是<?php break; case "2": ?>否<?php break; default: endswitch;?></td>
								<td><?php switch($vo["second_visit"]): case "1": ?>需要<?php break; case "2": ?>不需要<?php break; default: endswitch;?></td>
								<td><?php switch($vo["visit_source"]): case "1": ?>电话回访<?php break; case "2": ?>房东反馈<?php break; case "3": ?>保障房源<?php break; case "4": ?>短信回访<?php break; case "5": ?>返现申请<?php break; default: endswitch;?></td>
								<td><a target="_blank" href="/hizhu/CustomerTracking/trackingedit?no=6&leftno=105&pid=<?php echo ($vo["id"]); ?>">修改</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<span style="color:red;"><?php echo ($totalCount); ?></span>条记录，每页10条</p>
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
$('#status').val("<?php echo isset($_GET['status'])?$_GET['status']:'' ?>");
$('#is_appoint').val("<?php echo isset($_GET['is_appoint'])?$_GET['is_appoint']:'' ?>");
$('#is_contact').val("<?php echo isset($_GET['is_contact'])?$_GET['is_contact']:'' ?>");
$('#is_tracking').val("<?php echo isset($_GET['is_tracking'])?$_GET['is_tracking']:'' ?>");
$('#city_code').val("<?php echo isset($_GET['city_code'])?$_GET['city_code']:'' ?>");

$('#is_monthly').val("<?php echo isset($_GET['is_monthly'])?$_GET['is_monthly']:'' ?>");
$('#is_commission').val("<?php echo isset($_GET['is_commission'])?$_GET['is_commission']:'' ?>");
$('#is_look').val("<?php echo isset($_GET['is_look'])?$_GET['is_look']:'' ?>");
$('#is_getcommission').val("<?php echo isset($_GET['is_getcommission'])?$_GET['is_getcommission']:'' ?>");
$('#is_satisfied').val("<?php echo isset($_GET['is_satisfied'])?$_GET['is_satisfied']:'' ?>");
$('#is_recommend').val("<?php echo isset($_GET['is_recommend'])?$_GET['is_recommend']:'' ?>");
$('#renter_sourcetype').val("<?php echo I('get.renter_sourcetype'); ?>");

var unknown="<?php echo I('get.unknown'); ?>";
var abandon="<?php echo I('get.abandon'); ?>";
if(unknown=='' || unknown=='0'){
	$('#jsunknown').removeAttr('checked');
}
if(abandon=='' || abandon=='0'){
	$('#jsabandon').removeAttr('checked');
}
   $('.inpt_a').datetimepicker({validateOnBlur:false,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2020,format:"Y-m-d"});

	$("#btnSearch").click(function(){
		$(this).unbind('click').text('搜索中');
		$("#handleType").val('search');
		$("#searchForm").submit();
	});
	$("#btnSearchAll").click(function(){
		$(this).unbind('click').text('统计中');
		$("#handleType").val('outer');
		$("#searchForm").submit();
	});
	$("#btnSearchIn").click(function(){
		$(this).unbind('click').text('统计中');
		$("#handleType").val('inner');
		$("#searchForm").submit();
	});

	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}

		// 表格信息筛选
		$(".mes_filter").click(function(){
			$(".title_filter").slideToggle(200);
		});
		$(".title_filter .btn_b").click(function(){
			$(".title_filter").slideUp(200);
		});

		var getLocal = JSON.parse(window.localStorage.getItem("mess"));
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
			window.localStorage.setItem("mess",JSON.stringify(Obj));
		});
</script>

</html>