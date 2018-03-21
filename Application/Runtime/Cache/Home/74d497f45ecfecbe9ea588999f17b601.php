<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>聚合房源举报审核</title>
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
				<h2>查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/HouseOffer/aggregatreportAuditList.html" method="get">
						<input type="hidden" name="no" value="3">
						<input type="hidden" name="leftno" value="197">
						<input type="hidden" name="totalCount" value="<?php echo ($totalCount); ?>"> 
						<table class="table_one">
							<tr>
								<td class="td_title">举报时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime"  value="<?php echo I('get.startTime'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" value="<?php echo I('get.endTime'); ?>"></td>
								<td class="td_title">状态：</td>
								<td class="td_main">
									<select name="handle_status">
										<option value="">全部</option>
										<option value="0">待审核</option>
										<option value="1">通过</option>
										<option value="2">拒绝</option>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
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
								<th>序号</th>
								<th>房间编号</th>
								<th>举报内容</th>
								<th>举报时间</th>
								<th>状态</th>
								<th>处理时间</th>
								<th>处理人</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td><a target="_blank" href="/hizhu/HouseRoom/modifyroom?no=3&leftno=44&room_id=<?php echo ($vo["room_id"]); ?>"><?php echo ($vo["room_no"]); ?></a></td>
								<td><?php echo ($vo["feedback_desc"]); ?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i:s",$vo['create_time'])); endif; ?></td>
								<td><?php switch($vo["handle_status"]): case "0": ?>待审核<?php break; case "1": ?>通过<?php break; case "2": ?>拒绝<?php break; endswitch;?></td>
								<td><?php if(($vo["handle_time"] > 0)): echo (date("Y-m-d H:i:s",$vo['handle_time'])); endif; ?></td>
								<td><?php echo ($vo["handle_man"]); ?></td>
								<td><?php if(($vo["handle_status"] == 0)): ?><a href="#" onclick="showDialog('<?php echo ($vo["id"]); ?>',this)">审核</a><?php endif; ?></td>							
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				<div class="skip cf">
						<p class="fl skip_left" id="count">共<?php echo ($totalCount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--浮层(审核) -->
	<div id="dialogAudit" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:120px;background:#fff;position:absolute;left:55%;margin-left:-300px;top:50%;margin-top:-55px;border-radius:10px;overflow:hidden;padding:30px;">
			<label style="height:30px;line-height:30px;">拒绝理由：
				<select id="ddlReason" style="width:60%;height:25px;">
					<option value=""></option>
					<option value="聚合房间信息无误">聚合房间信息无误</option>
					<option value="发布房源和其他房源相同，聚合关系成立">发布房源和其他房源相同，聚合关系成立</option>
					<option value="房源依然可租">房源依然可租</option>
				</select>
			</label><br>
			<label style="height:30px;line-height:30px;margin-left:70px"><input type="text" id="txtReason" maxlength="40" style="width:80%;height:30px;"></label>
			<div  style="text-align:center;margin-top:20px;">
				<input type="hidden" name="modify_id" data-index="">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancel">取消</button>
				<button class="btn_a" id="btn_pass">通过</button>
				<button class="btn_a" id="btn_nopass">拒绝</button>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
$('.inpt_a').datetimepicker({validateOnBlur:false,step:5,lang:'ch',timepicker:false,format:"Y-m-d"});
var status='<?php echo isset($_GET["handle_status"])?$_GET["handle_status"]:""; ?>';
$("select[name='handle_status']").val(status);
$('#btnSearch').click(function(){
	$(this).unbind('click').text('搜索中');
	$('form').submit();
});
	
	function showDialog(mid,obj){
		$("#dialogAudit").show();
		$("input[name='modify_id']").val(mid).attr('data-index',$(obj).parent().parent().index());
	}
	$("#btn_cancel").click(function(){
		$("#dialogAudit").hide();
	});
	$("#ddlReason").change(function(){
		$("#txtReason").val($(this).val());
	});
	/*审核通过 */
	$("#btn_pass").click(function(){
		auditPass();
	});
	function auditPass(){
		$("#btn_pass").unbind('click').text('操作中');
		$.post('/hizhu/HouseOffer/aggregatreportSubmit',{id:$("input[name='modify_id']").val(),handle_status:1,handle_result:'通过'},function(data){
			alert(data.message);
			if(data.status=='200'){
				var tr_index=$("input[name='modify_id']").attr('data-index');
				tr_index=parseInt(tr_index)+1;
				var tr_obj=$("#dataDiv table tr:eq("+tr_index+")");
				tr_obj.children('td:eq(4)').html('通过');
				tr_obj.children('td:eq(7)').html('');
				$("#dialogAudit").hide();
			}
			$("#btn_pass").bind('click',function(){
				auditPass();
			}).text('通过');
		},'json');
	}
	/*审核拒绝 */
	$("#btn_nopass").click(function(){
		auditnoPass();
	});
	function auditnoPass(){
		var reason=$("#txtReason").val();
		if(reason==''){
			alert('请输入拒绝理由');return false;
		}
		$("#btn_nopass").unbind('click').text('操作中');
		$.post('/hizhu/HouseOffer/aggregatreportSubmit',{id:$("input[name='modify_id']").val(),handle_status:2,handle_result:reason},function(data){
			alert(data.message);
			if(data.status=='200'){
				var tr_index=$("input[name='modify_id']").attr('data-index');
				tr_index=parseInt(tr_index)+1;
				var tr_obj=$("#dataDiv table tr:eq("+tr_index+")");
				tr_obj.children('td:eq(4)').html('拒绝');
				tr_obj.children('td:eq(7)').html('');
				$("#dialogAudit").hide();
				$("#txtReason").val('');$("#ddlReason").val('');
			}
			$("#btn_nopass").bind('click',function(){
				auditnoPass();
			}).text('拒绝');
		},'json');
	}
	</script>

</html>