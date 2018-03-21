<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>抓取房源管理</title>
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
					<form id="searchForm" action="/hizhu/HouseResourcerob/resourcelistV2" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="178">
						<input type="hidden" id="jump" name="p">
						<table class="table_one">
							<tr>
								<td class="td_title">发布日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo isset($_GET['startTime'])?$_GET['startTime']:'' ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" id="datetimepicker1" value="<?php echo isset($_GET['endTime'])?$_GET['endTime']:'' ?>"></td>
								<td class="td_title">小区名称：</td>
								<td class="td_main"><input type="text" name="estateName" value="<?php echo isset($_GET['estateName'])?$_GET['estateName']:'' ?>"></td>
								<td class="td_title">房东电话：</td>
								<td class="td_main"><input type="text" name="clientPhone" value="<?php echo isset($_GET['clientPhone'])?$_GET['clientPhone']:'' ?>"></td>
							</tr>
							<tr>
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
								<td class="td_title">租金：</td>
								<td class="td_main">
									<input type="tel" name="moneyMin" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMin');?>">~
									<input type="tel" name="moneyMax" maxlength="6" style="width:100px;" value="<?php echo I('get.moneyMax');?>">
								</td>
								<td class="td_title">数据来源：</td>
								<td class="td_main">
									<select id="info_resource" name="info_resource">
										<option value=""></option>
										<?php echo ($infoResourceList); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">房间类型：</td>
								<td class="td_main">
									<select id="room_type" name="room_type">
										<option value=""></option>
										<option value="0205">整租</option>
										<option value="0201">合租</option>
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
								<td class="td_title">异常号码：</td>
								<td class="td_main">
									<select id="phoneStatus" name="phoneStatus">
										<option value=""></option>
										<option value="1">是</option>
										<option value="0">否</option>
									</select> 
								</td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表</h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>小区名称</th>
								<th>区域板块</th>
								<th>户型</th>
								<th>发布日期</th>
								<th>数据来源</th> <th>房间类型</th> 
								<th>房东姓名</th><th>房东手机</th><th>租金</th>
								<th>已有房源数量</th>
								<th>操作人</th><th>分数</th><th>拉黑操作</th><th>新增中介</th>
								<th>来源URL</th>
								<th>修改房源</th>
								<th>删除房源</th>
								<th>修改号码</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><?php echo ($list["estate_name"]); ?></td>
								<td><?php echo ($list["region_name"]); ?>-<?php echo ($list["scope_name"]); ?></td>
								<td><?php echo ($list["room_num"]); ?>室<?php echo ($list["hall_num"]); ?>厅<?php echo ($list["wei_num"]); ?>卫</td>
								<td><?php if(($list["create_time"]) > "0"): echo (date("Y-m-d H:i",$list["create_time"])); endif; ?></td><td><?php echo ($list["info_resource"]); ?></td>
								 <td><?php switch($list["room_type"]): case "0205": ?>整租<?php break; case "0201": ?>合租<?php break; endswitch;?></td>
								<td><?php echo ($list["client_name"]); ?></td><td><?php echo ($list["client_phone"]); ?></td><td><?php echo ($list["room_money"]); ?></td>
								<td data-phone="<?php echo ($list["client_phone"]); ?>" data-estate="<?php echo ($list["estate_id"]); ?>"></td>
								<td><?php echo ($list["update_man"]); ?></td><td><?php echo ($list["ext_score"]); ?></td><td><a href="javascript:;" onclick="addBlack('<?php echo ($list["client_phone"]); ?>')">拉黑</a></td>
								<td><a href="javascript:;" onclick="addAgent('<?php echo ($list["client_phone"]); ?>',this)">新增中介</a></td>
								<td><?php if(($list["info_resource_url"]) != ""): ?><a target="_blank" href="<?php echo ($list["info_resource_url"]); ?>">来源URL</a><?php endif; ?></td>
								<td><a target="_blank" href="/hizhu/HouseResourcerob/uprobhouse?no=3&leftno=81&resource_id=<?php echo ($list["id"]); ?>">修改</a></td>
								<td><a href="#" onclick="deleteHouse('<?php echo ($list["id"]); ?>',this)">删除</a></td> 
								<td><a href="#" onclick="modifyPhone('<?php echo ($list["id"]); ?>','<?php echo ($list["client_phone"]); ?>','<?php echo ($list["info_resource_url"]); ?>',this)">修改号码</a></td> 
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalcnt); ?>条记录，每页7条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>&nbsp;<input type="text" style="width:50px" maxlength="4" id="jumpPage" name="jumpPage">&nbsp;<button onclick="jump()">跳转</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--浮层 -->
	<div id="dialogDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:800px;height:420px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<table class="table_one">
				<tr>
					<td class="td_title"><span>*</span>联系电话：</td> 
					<td><input type="text" name="mobile" maxlength="20"></td>
				</tr>
				<tr>
					<td class="td_title">限制登录：</td>
					<td class="td_main">
						<label><input type="checkbox" checked="checked" name="no_login">是</label>
					</td>
				</tr>
				<tr>
					<td class="td_title">限制回复：</td>
					<td class="td_main">
						<label><input type="checkbox" checked="checked" name="no_post_replay">是</label>
					</td>
				</tr>
				<tr>
					<td class="td_title">限制拨打房东电话：</td>
					<td class="td_main">
						<label><input type="checkbox" checked="checked" name="no_call">是</label>
					</td>
				</tr>
				<tr>
					<td class="td_title">操作房源：</td>
					<td class="td_main">
						<label><input type="radio" name="soldouthouse" value="0">无</label>&nbsp;
						<label><input type="radio" name="soldouthouse" value="1">下架</label>&nbsp;
						<label><input type="radio" name="soldouthouse" value="2" checked="checked">删除</label>
					</td>
				</tr>
				<tr>
						<td class="td_title">是否发送短信：</td>
						<td class="td_main">
							<label><input type="checkbox" name="is_sendmessage">是</label>
						</td>
					</tr>
				<tr>
						<td class="td_title"><span>*</span>拉黑原因：</td> 
						<td>
							<select name="bak_type">
								<option value="0">请选择</option>
								<option value="1">骗子/钓鱼/微商</option>
								<option value="2">违规操作</option>
								<option value="3">商务需求</option>
								<option value="4">中介/托管</option>
								<option value="6">其他</option>
							</select>
						</td>
					</tr>
				<tr>
					<td class="td_title"><span></span>备注信息：</td>
					<td class="td_main">
						<input type="text" name="bak_info" maxlength="50" style="width:100%">
					</td>
				</tr>
			</table>
			<input type="hidden" name="is_owner">
			<div class="addhouse_last addhouse_last_room" style="text-align:center;padding:20px;">
				<a href="javascript:;" class="btn_b" style="margin-right:30px;">取消</a>
				<a href="javascript:;" class="btn_a" id="submit_black">提交</a>
			</div>
		</div>
	</div>
	<!--遮罩层（修改号码） -->
	<div id="modifyPhone_div" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:120px;background:#fff;position:absolute;left:55%;margin-left:-300px;top:50%;margin-top:-55px;border-radius:10px;overflow:hidden;padding:30px;">
			<label style="height:30px;line-height:30px;">号码：<input type="text" name="new_phone" maxlength="20" style="width:80%;height:30px;"></label><br>
			<label style="height:30px;line-height:30px;">地址：<a target="_blank" href="#" id="targetUrl">来源URL</a></label>
			<div  style="text-align:center;margin-top:20px;">
				<input type="hidden" name="modify_id" data-index="">
				<input type="hidden" id="old_phone">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancel">取消</button>
				<button class="btn_a" id="btn_submit">更新</button>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
$("#phoneStatus").val('<?php echo isset($_GET["phoneStatus"])?$_GET["phoneStatus"]:"0" ?>');
$("#room_num").val('<?php echo I("get.room_num"); ?>');
	$("#room_type").val('<?php echo I("get.room_type"); ?>');
	$("#ddl_region").val('<?php echo isset($_GET["region"])?$_GET["region"]:"" ?>');
	$("#ddl_scope").val('<?php echo isset($_GET["scope"])?$_GET["scope"]:"" ?>');
	$("#info_resource").val('<?php echo isset($_GET["info_resource"])?$_GET["info_resource"]:"" ?>');
	$('#datetimepicker,#datetimepicker1').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,format:"Y-m-d"});

	$("#btnSearch").click(function(){
		$(this).unbind("click").text("搜索中");
		$("#searchForm").submit();
	});
	var regMobile=/^1[34578]\d{9}$/;
	$("#dataDiv table tbody tr").each(function(){
		var td_source=$(this).children("td:eq(9)");
		var phone=td_source.attr("data-phone");
		if(regMobile.test(phone)){
			$.get('/hizhu/HouseResourcerob/getHouseCountByPhone?mobile='+phone,function(data){
				if(data.count>0){
					td_source.html('<a href="/hizhu/HouseRoom/searchroom.html?no=3&leftno=44&clientPhone='+phone+'" target="_blank">'+data.count+'</a>');
				}else{
					td_source.html(data.count);
				}
			},'json');
		}
		
	});
	/*修改号码 */
	function modifyPhone(mid,phone,tgUrl,obj){
		$("#modifyPhone_div").show();
		$("input[name='new_phone']").val(phone);
		$("#old_phone").val(phone);
		$("#targetUrl").attr("href",tgUrl);
		$("input[name='modify_id']").val(mid).attr('data-index',$(obj).parent().parent().index());
	}
	$("#btn_cancel").click(function(){
		$("#modifyPhone_div").hide();
	});
	$("#btn_submit").click(function(){
		modifyPhoneSubmit();
	});
	function modifyPhoneSubmit(){
		var new_phone=$("input[name='new_phone']").val();
		if(new_phone==''){
			return false;
		}else if(new_phone==$("#old_phone").val()){
			return false;
		}
		var regPhone=/^1[34578]\d{9}$/;
		if(!regPhone.test(new_phone)){
			alert("请填写有效手机号");return false;
		}
		$("#btn_submit").unbind('click').text('更新中');
		$.post('/hizhu/HouseResourcerob/modifyClientphone',{resource_id:$("input[name='modify_id']").val(),client_phone:new_phone},function(data){
			if(data.status!='200'){
				alert(data.message);
			}else{
				/*处理结果 */
				var tr_index=$("input[name='modify_id']").attr('data-index');
				tr_index=parseInt(tr_index)+1;
				var tr_obj=$("#dataDiv table tr:eq("+tr_index+")");
				tr_obj.children('td:eq(7)').html(new_phone);
				tr_obj.children('td:eq(17)').html("修改成功");
				$("#modifyPhone_div").hide();
			}
			$("#btn_submit").bind('click',function(){
				modifyPhoneSubmit();
			}).text('更新');
		},'json');
	}
	function deleteHouse(resource_id,delete_obj){
		if(confirm("删除房源后，其下的房间也将被删除，是否确认？")){
			$.get("/hizhu/HouseResourcerob/removeResource",{resource_id:resource_id},function(data){
				alert(data.msg);
				if(data.status=="200"){
					$(delete_obj).parent().parent().remove();
				}
			},"json");
		}
	}
	/*新增中介 */
	function addAgent(phone,obj){
		if(confirm('确定是中介吗？')){
			$.post('/hizhu/HouseResourcerob/addAgentOutrob',{mobile:phone},function(data){
				alert(data.message);
				if(data.status=='200'){
					$(obj).parent().parent().remove();
				}
			},'json');
			
		}
	}
	/*拉黑 */
	function addBlack(phone){
		$("#dialogDiv").show();
		$("input[name='mobile']").val(phone);
	}
	$(".btn_b").click(function(){
		$("#dialogDiv").hide();
		$("input[name='mobile']").val('');
		$("select[name='bak_type']").val('0');
		$("input[name='bak_info']").val('');
	});
	$("#submit_black").click(function(){
		submitBlack();
	});
	function submitBlack(){
		var mobile=$("input[name='mobile']").val().replace(/\s+/g,'');
		var isTel=/^[023456789]+\,{0,1}\d*$/;
		var isMobile=/^1[34578]\d{9}$/;
		if(!isTel.test(mobile) && !isMobile.test(mobile)){
			alert("无效的联系电话");return;
		}
		var bak_type=$("select[name='bak_type']").val();
		if(bak_type=='0'){
			alert("请选择拉黑原因");return;
		}
		$("#submit_black").unbind("click").text('提交中');
		$.get('/hizhu/BlackList/checkOwnerUser?mobile='+mobile,function(result){
			if(result.status=="200"){
				if(confirm('此用户是职业房东，确认拉黑吗？')){
					submitBlackPost(mobile,bak_type,1);
				}else{
					$("#submit_black").bind('click',function(){
						submitBlack();
					}).text('提交');
				}
			}else if(result.status=="300"){
				alert(result.message);
				$("#submit_black").bind('click',function(){
					submitBlack();
				}).text('提交');
			}else{
				submitBlackPost(mobile,bak_type,0);
			}
		},'json');
	}
	function submitBlackPost(mobile,bak_type,is_owner){
		var no_login=0;
		var no_post_replay=0;
		var no_call=0;
		var is_sendmessage=0;
		if($("input[name='no_login']").attr("checked")=="checked"){
			no_login=1;
		}
		if($("input[name='no_post_replay']").attr("checked")=="checked"){
			no_post_replay=1;
		}
		if($("input[name='no_call']").attr("checked")=="checked"){
			no_call=1;
		}
		if($("input[name='is_sendmessage']").attr("checked")=="checked"){
			is_sendmessage=1;
		}
		var soldouthouse=$('input:radio[name="soldouthouse"]:checked').val();
		if(soldouthouse==undefined){
			soldouthouse=0;
		}
		$.post('/hizhu/BlackList/saveBlackUser',{addType:'other',mobile:mobile,bak_type:bak_type,bak_info:$("input[name='bak_info']").val(),is_owner:is_owner,no_login:no_login,no_post_replay:no_post_replay,no_call:no_call,soldouthouse:soldouthouse,is_sendmessage:is_sendmessage},function(data){
			if(data.status=="200"){
				alert('操作成功');window.location.reload();
			}else{
				alert('操作失败');
			}
		},'json');
	}
	function getFourCode(phone,resource_id,obj){
		$(obj).unbind('click').text('获取中');
		$.get("/hizhu/HouseResourcerob/getFourHundredCode",{resource_id:resource_id,mobile:phone},function(data){
			$(obj).parent().html(data);
		});
	}
	function jump(){
		if(/^\d{1,4}$/.test($("#jumpPage").val())){
			$("#jump").val($("#jumpPage").val());
			$("#searchForm").submit();
		}
	}
	//下拉联动
	$("#ddl_region").change(function(){
		if($(this).val()==""){
			$("#ddl_scope").html("");
			return;
		}
		$.get("/hizhu/HouseResourcerob/getScopes",{region_id:$(this).val()},function(data){
			$("#ddl_scope").html(data);
		},"html");
	});
</script>
</html>