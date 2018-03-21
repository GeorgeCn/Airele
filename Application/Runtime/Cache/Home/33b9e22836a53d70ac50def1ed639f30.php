<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>职业房东跟进页面</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
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
			
			<div class="common_main">
				<div  style="font-size:16px;margin:20px 0 10px 50px;">拥有房间(只展示最新的10间)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>房间编号</th>
							<th>区域板块</th>
							<th>小区</th>
							<th>价格</th>
							<th>状态</th>
							<th>房间来源</th>
							<th>是否有佣金</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($roomarr)): foreach($roomarr as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_no"]); ?></td>
							<td><?php echo ($vo["region_name"]); ?>-<?php echo ($vo["scope_name"]); ?></td>
							<td><?php echo ($vo["estate_name"]); ?></td>
							<td><?php echo ($vo["room_money"]); ?></td>
							<td>
								<?php if($vo['status'] == '0'): ?>待审核
								<?php elseif($vo['status'] == '1'): ?>
							     审核未通过
								<?php elseif($vo['status'] == '2'): ?>
								 未入住
								<?php elseif($vo['status'] == '3'): ?>
								 已出租
								 <?php elseif($vo['status'] == '4'): ?>
								 待维护<?php endif; ?>
							</td>
							<td><?php echo ($vo["info_resource"]); ?></td>
							<td>
								<?php if($vo['is_commission'] == '0'): ?>否
								<?php elseif($vo['is_commission'] == '1'): ?>
								是<?php endif; ?>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				
				<!-- 联系记录 -->
				<div  style="font-size:16px;margin:20px 0 10px 50px;">跟进记录(最多展示最近10条)</div>
				<table  class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;text-align:center;">
					<thead>
						<tr>
							<th>状态</th>
							<th>备注</th>
							<th>处理时间</th>
							<th>处理人</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($statusarr)): foreach($statusarr as $key=>$vo): ?><tr>
							<td>
							<?php switch($vo["status"]): case "0": ?>待跟进<?php break; case "1": ?>非职业房东<?php break;?>
								<?php case "2": ?>已签约<?php break; case "3": ?>跟进中<?php break; case "5": ?>不合作<?php break; endswitch;?>
							</td>
							<td><?php echo ($vo['remark']); ?></td>
							<td><?php echo (date("Y-m-d H:i",$vo['create_time'])); ?></td>
							<td><?php echo ($vo['create_man']); ?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			
			<form method="post" action="/hizhu/Jobowner/jobownerfollow_submit">
				<input type="hidden" name="customer_id" value="<?php echo I('get.customer_id');?>">
				<div  style="font-size:16px;margin:20px 0 10px 50px;">新增跟进记录</div>
				<table class="table_one table_two" style="margin:10px 0 30px 50px;width:70%;">
					<tr>
						<td class="td_title">跟进状态：</td>
						<td class="td_main">
							<select id="jstrailstatus" name="trailstatus">
								<option value="0">待跟进</option>
								<option value="3">跟进中</option>
								<option value="2">已签约</option>
								<?php if($origin == 0): ?><option value="1">非职业房东</option><?php endif; ?>
								<option value="5">不合作</option>
							</select>
						</td>
						
					</tr>
					<tr style="display:none;">
						<td class="td_title">签约方式：</td>
						<td class="td_main">
							<select name="sign_way">
								<option value="1">短信签约</option>
								<option value="2">书面签约</option>
								<option value="3">口头签约</option>
							</select>
						</td>
					</tr>
					<tr style="display:none;">
						<td class="td_title">付费方式：</td>
						<td class="td_main">
							<select name="commissiontype" id="renter_source">
								<option value="">无</option>
								<option value="1">月租比例</option>
								<option value="2">固定金额</option>
								<option value="3">包月</option>
							</select>&nbsp;<input type="input" name="commissionmoney" style="display:none;width:120px;">&nbsp;<b id="btype"></b>
							&nbsp;<p id="settlementP" style="display:none;">结算方式：<label><input type="radio" name="settlement_method" value="1" checked="checked">次结</label>&nbsp;
								<label><input type="radio" name="settlement_method" value="2">月结</label></p>
						</td>
					</tr>


					<tr style="display:none;" id="tr_monthday">
						<td class="td_title">合同时长：</td> 
						<td class="td_main"><input type="text" name="monthly_days" maxlength="4" style="width:120px;">&nbsp;天</td>
					</tr>
					<tr style="display:none;" id="tr_monthstart">
						<td class="td_title">启用时间：</td>
						<td class="td_main"><input class="inpt_a" type="text" name="monthly_start" style="width:140px;"></td>
					</tr>
					<tr style="display:none;">
						<td class="td_title">保证金：</td>
						<td class="td_main">
							<input type="input" name="margin">
						</td>
					</tr>
					<tr style="display:none;" id="tr_principal_man">
						<td class="td_title">负责人：</td>
						<td class="td_main">
						    <input type="text" name="principal_man"  style="width:140px">
							<div id="div_principal_man" class="plotbox" style="width:150px;">
								<ul>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_title">备注：</td>
						<td class="td_main"><input type="text" name="remark" style="width:98%"></td>
					</tr>
				</table>
		    
				</form>
			</div>
			<div style="margin-left:35%;"><a href="javascript:;" class="btn_a">提交</a></div>
		</div>
	</div>
	                    
</body>
 <script src="/hizhu/Public/js/jquery.js"></script>
 <script src="/hizhu/Public/js/common.js"></script>
 <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
	$('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2020,format:"Y-m-d"});

	$("#renter_source").change(function(){
		var btypenum=$(this).val();
		if(btypenum==1){
			$("#btype").text("%");
			$("input[name='commissionmoney']").show();
			$("#tr_monthday").hide();
			$("#tr_monthstart").hide();
			$("#settlementP").show();
		}else if(btypenum==2){
			$("#btype").text("元");
			$("input[name='commissionmoney']").show();
			$("#tr_monthday").hide();
			$("#tr_monthstart").hide();
			$("#settlementP").show();
		}else if(btypenum==3){
			$("#btype").text("元");
			$("input[name='commissionmoney']").show();
			$("#tr_monthday").show();
    		$("#tr_monthstart").show();
    		$("#settlementP").hide();
		}else{
			$("#btype").text("");
			$("input[name='commissionmoney']").val("").hide();
			$("#tr_monthday").hide();
			$("#tr_monthstart").hide();
			$("#settlementP").hide();
		}
		
	});

    $("#jstrailstatus").change(function(){
    	if($(this).val()==2){
    		$(this).parent().parent().nextAll().show();
    		$("#tr_monthday").hide();
    		$("#tr_monthstart").hide();
    	} else if($(this).val()==3) {
    		$(this).parent().parent().nextUntil("tr:nth-child(8)").hide();
    		$("#tr_principal_man").show();
    	}
    	else{
    		$(this).parent().parent().nextUntil("tr:nth-child(8)").hide();
    		$("#btype").text("");
    		$("input[name='commissionmoney']").val("").hide();
    		$("#renter_source").val("");
    	}
    });

	$('.btn_a').bind('click',function(){
		var renter_source=$("#renter_source").val();
		var commissionmoney=$("input[name='commissionmoney']").val();
		if(renter_source!=""&&commissionmoney==""){
			alert("请填写佣金");
		    return false;
		}
		if(renter_source==3){
			if($("input[name='monthly_days']").val()==''){
				alert("请填写合同时长");return false;
			}
			if($("input[name='monthly_start']").val()==''){
				alert("请填写启用时间");return false;
			}
		}
		if($("input[name='principal_man']").val()!=''){
			if(!confirm("请先核实负责人是否输入正确，继续提交？")){
				return false;
			}
		}
		$(this).unbind('click').text('提交中');
		$("form").submit();
	});
	/*房东负责人 */
	$("input[name='principal_man']").keyup(function(){
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
		$("input[name='principal_man']").val(userName);
		$("#div_principal_man").hide();
	}
</script>
</html>