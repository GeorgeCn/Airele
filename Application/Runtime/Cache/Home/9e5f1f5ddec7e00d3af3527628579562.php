<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>我负责的包月客户</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css">
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
				<h2>查询条件</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/Summary/sumlandlordmonth" method="get">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="183">
						<input type="hidden" name="handle">
						  <input type="hidden" name="pagecount" value="<?php echo ($pagecount); ?>"> 
						<table class="table_one">
							<tr>
								<td class="td_title">房东负责人：</td>
								<td class="td_main">
									<input type="text" name="principal_man" value="<?php echo I('get.principal_man'); ?>">
								</td>
								<td class="td_title">房东手机号：</td>
								<td class="td_main">
									<input type="text" name="mobile" value="<?php echo I('get.mobile'); ?>">
								</td>
								<td class="td_title">上线日期：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="monthStart" value="<?php echo I('get.monthStart'); ?>">~<input class="inpt_a" type="text" name="monthEnd" value="<?php echo I('get.monthEnd'); ?>">
								</td>
							</tr>
						
						</table>
						
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>统计列表<a href="#" class="btn_a" id="btnDownload">下载</a><label style="margin-left:150px;font-size:10px;font-weight:normal;">最多150条</label></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>客户名称</th>
								<th>客户手机号</th><th>负责人</th>
								<th>合作状态</th>
								<th>上线日期</th>
								<th>合作时长（天）</th>
								<th>总金额</th>
								<th>租客数</th>
								<th>电话连接数</th>
								<th>预约连接数</th>
								<th>总连接数</th>
								<th>上线时长</th><th>累计费用</th><th>连接数单价</th>
								<th>备注</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php echo ($vo["true_name"]); ?></td>
								<td><?php echo ($vo["mobile"]); ?></td><td><?php echo ($vo["principal_man"]); ?></td>
								<td><?php echo ($vo["status"]); ?></td>
								<td><?php echo ($vo["monthly_start"]); ?></td>
								<td><?php echo ($vo["monthly_days"]); ?></td>
								<td><?php echo ($vo["monthly_money"]); ?></td>

								<td><?php echo ($vo["renter_cnt"]); ?></td>
								<td><?php echo ($vo["contact_cnt"]); ?></td>
								<td><?php echo ($vo["reserve_cnt"]); ?></td>
								<td><?php echo ($vo["all_cnt"]); ?></td>

								<td><?php echo ($vo["online_days"]); ?></td>
								<td><?php echo ($vo["online_money"]); ?></td>
								<td><?php echo ($vo["online_price"]); ?></td>
								<td><a href="#" onclick="showlist('<?php echo ($vo["customer_id"]); ?>')">编辑</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页5条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--遮罩层（备注列表） -->
	<div id="baklistDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:440px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<table id="tbllist" style="width:90%;margin:20px;">
				<thead>
					<tr>
						<th>跟进时间</th>
						<th>操作人</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<div  style="text-align:center;position:absolute;bottom:30px;left:50%;margin-left:-100px;">
				<button class="btn_b" style="margin-right:50px;" id="btn_close">关闭</button>
				<button class="btn_a" id="btn_addbak">新增</button>
				<input type="hidden" name="customer_id">
			</div>
		</div>
	</div>
	<!--遮罩层（备注） -->
	<div id="addbakDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:120px;background:#fff;position:absolute;left:55%;margin-left:-300px;top:50%;margin-top:-55px;border-radius:10px;overflow:hidden;padding:30px;">
			<label style="height:50px;line-height:50px;">备注：<input type="text" name="bak_info" maxlength="50" style="width:80%;height:50px;" ></label>
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancel">取消</button>
				<button class="btn_a" id="btn_submit">保存</button>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2020,format:"Y-m-d"});

$("#btnSearch").click(function(){
	$("input[name='handle']").val("query");
	$(this).unbind('click').text('搜索中');
	$("form").submit();
});
$("#btnDownload").click(function(){
	$(this).unbind('click');
	window.location.href="/hizhu/Summary/downloadSumlandlordmonth.html?<?php echo $_SERVER['QUERY_STRING'];?>";
});
$("#btn_close").click(function(){
	$("#baklistDiv").hide();
});
$("#btn_cancel").click(function(){
	$("#addbakDiv").hide();
});

$("#btn_addbak").click(function(){
	$("#addbakDiv").show();
});
$("#btn_submit").click(function(){
	submitbak();
});
function submitbak(){
	var bak=$("input[name='bak_info']").val();
	if(bak==''){
		return false;
	}
	$("#btn_submit").unbind('click').text('保存中');
	$.post('/hizhu/Summary/modifyLandlordbak',{customer_id:$("input[name='customer_id']").val(),remark:bak},function(result){
		alert(result);$("#addbakDiv").hide();$("#baklistDiv").hide();$("input[name='bak_info']").val('');
		$("#btn_submit").bind('click',function(){
			submitbak();
		}).text('保存');
	});

}
function showlist(cuid){
	$("#baklistDiv").show();
	$("input[name='customer_id']").val(cuid);
	$.get('/hizhu/Summary/getlandlordlog?customer_id='+cuid,function(data){
		$("#tbllist tbody").html(data);
	},'html');
}
</script>
</html>