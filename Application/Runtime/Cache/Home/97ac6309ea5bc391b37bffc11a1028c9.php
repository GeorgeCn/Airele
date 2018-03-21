<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>中介管理</title>
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
				<h2>中介用户查询</h2>
				<div class="common_head_main">
				<form action="/hizhu/AgentsManage/agentsManageList.html" method="get" id="searchForm">
				    <input type="hidden" name="no" value="6">
				    <input type="hidden" name="leftno" value="192">
					<table class="table_one">
						<tr>
							<td class="td_title">中介姓名：</td>
							<td class="td_main"><input type="text" name="true_name" value="<?php echo I('get.true_name');?>"></td>
							<td class="td_title">中介手机：</td>
							<td class="td_main"><input type="tel" name="mobile" maxlength="11" value="<?php echo I('get.mobile');?>"></td>
							<td class="td_title">中介来源</td>
							<td class="td_main">
							    <select name="source">
									<option value="" <?php if(I('get.source') == ""){echo "selected";}?>>全部</option>
									<option value="BD添加" <?php if(I('get.source') == "BD添加"){echo "selected";}?>>BD添加</option>
									<option value="系统添加" <?php if(I('get.source') == "系统添加"){echo "selected";}?>>系统添加</option>
									<option value="app房东版本签约" <?php if(I('get.source') == "app房东版本签约"){echo "selected";}?>>app房东版签约</option>
									<option value="empty" <?php if(I('get.source') == "empty"){echo "selected";}?>>空</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="td_title">中介负责人：</td>
							<td class="td_main">
								<input type="text" name="principal_man" value="<?php echo I('get.principal_man');?>">
							</td>
							<td class="td_title">主营区域：</td>
							<td class="td_main">
								<select name="region_id" style="width:120px">
									<option value="">全部</option>
									<?php echo ($regionList); ?>
								</select>
							</td>
							<td class="td_title">创建时间</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime"  value="<?php echo I('get.endTime');?>"></td>
						</tr>
						<tr>
							<td class="td_title">中介公司：</td>
							<td class="td_main">
								<select name="company_id" style="width:120px">
									<option value="">全部</option>
									<?php echo ($companyList); ?>
								</select>
							</td>
							<td class="td_title">是否包月：</td>
							<td class="td_main">
								<select name="is_monthly">
									<option value="">全部</option>
									<option value="1"<?php if(I('get.is_monthly')=="1"){echo"selected";}?>>是</option>
									<option value="0"<?php if(I('get.is_monthly')=="0"){echo"selected";}?>>否</option>
								</select>
							</td>
							<td class="td_title">跟进状态：</td>
							<td class="td_main"> 
								<select name="status">
									<option value="">全部</option>
									<option value="0"<?php if(I('get.status')=="0"){echo"selected";}?>>待跟进</option>
									<option value="3"<?php if(I('get.status')=="3"){echo"selected";}?>>跟进中</option>
									<option value="5"<?php if(I('get.status')=="5"){echo"selected";}?>>不合作</option>
								</select>
							</td>
						</tr>
					</table>		
					</form>
					<p class="head_p"><button class="btn_a" id="btn_search">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>中介用户列表
				<a style="margin-left:20px;" class="btn_a" href="/hizhu/AgentsManage/agentsAdd.html?no=6&leftno=192">新增中介用户</a>
				<a style="margin-left:150px;" href="/hizhu/AgentsManage/downloadExcel?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a>
				</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>中介姓名</th>
								<th>中介手机</th>
								<th>主营区域</th>
								<th>中介公司</th>
								<th>跟进状态</th>
								<th>创建时间</th>
								<th>中介负责人</th>
								<th>来源</th>
								<th>备注</th>
								<th>操作人</th>
								<th>修改</th>
								<th>包月</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['true_name']); ?></td>
								<td><a href="/hizhu/HouseRoom/searchroom?no=3&leftno=44&clientPhone=<?php echo ($vo['mobile']); ?>" target="_blank"><?php echo ($vo['mobile']); ?></a></td>
								<td><?php echo ($vo['region_name']); ?></td>
								<td><?php echo ($vo['agent_company_name']); ?></td>
								<td>
									<?php switch($vo["status"]): case "0": ?><a href="/hizhu/Jobowner/jobownerfollow.html?no=6&leftno=192&origin=1&customer_id=<?php echo ($vo["customer_id"]); ?>" target="_blank">待跟进</a><?php break;?>
										<?php case "3": ?><a href="/hizhu/Jobowner/jobownerfollow.html?no=6&leftno=192&origin=1&customer_id=<?php echo ($vo["customer_id"]); ?>" target="_blank">跟进中</a><?php break;?>
										<?php case "5": ?><a href="/hizhu/Jobowner/jobownerfollow.html?no=6&leftno=192&origin=1&customer_id=<?php echo ($vo["customer_id"]); ?>" target="_blank">不合作</a><?php break; endswitch;?>
								</td>
								<td><?php if(($vo["create_time"]) > "0"): echo (date("Y-m-d H:i",$vo['create_time'])); endif; ?></td>
								<td><?php echo ($vo['principal_man']); ?></td>
								<td><?php echo ($vo['source']); ?></td>
								<td><?php echo ($vo['owner_remark']); ?></td>
								<td><?php echo ($vo['update_man']); ?></td>
								<td><a target="_blank" href='/hizhu/AgentsManage/agentsUpdate.html?no=6&leftno=192&id=<?php echo ($vo["customer_id"]); ?>'>修改信息</a></td>
								<td><a target="_blank" href="/hizhu/Commission/commissionMonthly.html?no=6&leftno=192&origin=1&mobile=<?php echo ($vo['mobile']); ?>&customer_id=<?php echo ($vo['customer_id']); ?>">修改付费</a></td>

							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--遮罩层（拉黑） -->
	<div id="blackDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:180px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<div style="margin:20px;" class="cf">共拉黑<span id="blackcount" style="color:red">正在查询</span>名职业房东。<br>（太多拉黑可能需要些许时间，请耐性等待..）
			</div>
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancelblack">取消</button>
				<button class="btn_a" id="btn_submitblack">确认拉黑</button>
			</div>
		</div>
	</div>
	<!--遮罩层（职业房东检测） -->
	<div id="checkDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:180px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<div style="margin:20px;" class="cf">确定将个人房东中≥5套房的<span id="checkcount" style="color:red">正在查询</span>人拉入职业房东吗？
			</div>
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancelcheck">取消</button>
				<button class="btn_a" id="btn_submitcheck">确认操作</button>
			</div>
		</div>
	</div>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/listdata.js"></script>
<script>
$('.inpt_a').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
$("select[name='region_id']").val("<?php echo I('get.region_id');?>");
$("select[name='company_id']").val("<?php echo I('get.company_id');?>");

var login_name='<?php echo cookie("admin_user_name");?>';
if(login_name=='admin' || login_name=='jianghao' || login_name=='suhongye' || login_name=='yantaojie' || login_name=='xujin' || login_name=='haotongrui'){
	$("#btn_batchBlack").show();
	$("#btn_checkIsowner").show();
}
$("#btn_search").click(function(){
		$(this).unbind('click').text('搜索中..');
		$("#searchForm").submit();
	});
function flushRoom(customer_id,obj){
	if(confirm('确认刷新该房东下面的所有房源？')){
		$(obj).unbind('click').text('');
		$.get('/hizhu/AgentsManage/reflushRoomForOwner?cuid='+customer_id,function(data){
			alert(data.message);
		},'json');
	}
}

/*拉黑一个 */
function pull_blackone(customer_id,mobile,obj){
	if(confirm('确定要将该房东商务拉黑吗？')){
		$.get('/hizhu/AgentsManage/pullblack_submit?customer_id='+customer_id+'&mobile='+mobile,function(data){
			alert(data.message);
			if(data.status=="200"){
				$(obj).parent().html('是');
			}
		},'json');
	}
}
/*非佣拉黑 */
function batchBlack(){
	if(confirm("你正在操作非佣拉黑，是否继续？")){
		$("#blackDiv").show();
		$.get('/hizhu/AgentsManage/batchblack_count?handle=getcount',function(content){
			$("#blackcount").text(content);
		});
	}
}
$("#btn_submitblack").bind("click",function(){
	var count=parseInt($("#blackcount").text());
	if(count==0){
		alert("没有可以拉黑的用户");return;
	}
	$(this).unbind("click").text("正在拉黑..");
	$.get('/hizhu/AgentsManage/batchblack_submit',function(data){
		alert(data.message);
		$("#btn_submitblack").text("已完成");
		$("#blackDiv").hide();
	},'json');
});
$("#btn_cancelblack").bind("click",function(){
	$("#blackDiv").hide();
});
/*职业房东检测 */
function checkIsowner(){
	if(confirm("你正在操作职业房东检测，是否继续？")){
		$("#checkDiv").show();
		$.get('/hizhu/AgentsManage/checkIsowner_count?handle=getcount',function(content){
			$("#checkcount").text(content);
		});
	}
}
$("#btn_submitcheck").bind("click",function(){
	var count=parseInt($("#checkcount").text());
	if(count==0){
		alert("没有可以操作的房东");return;
	}
	$(this).unbind("click").text("正在处理..");
	$.get('/hizhu/AgentsManage/checkIsowner_submit',function(data){
		alert(data.message);
		$("#btn_submitcheck").text("已完成");
		$("#checkDiv").hide();
	},'json');
});
$("#btn_cancelcheck").bind("click",function(){
	$("#checkDiv").hide();
});
</script>
</body>
</html>