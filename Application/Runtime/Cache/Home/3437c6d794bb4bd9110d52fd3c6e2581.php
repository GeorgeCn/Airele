<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>黑名单列表</title>
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
				<h2>黑名单查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/BlackList/blackuserlist" method="get">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="71">
						<input type="hidden" id="jump" name="p">
						<table class="table_one">
							<tr>
								<td class="td_title">手机号：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo I('mobile'); ?>"></td>
								<td class="td_title">日期：</td>
								<td class="td_main">
									<input class="inpt_a" type="text" name="startTime" value="<?php echo I('get.startTime');?>">~<input class="inpt_a" type="text"  name="endTime"  value="<?php echo I('get.endTime');?>">
								</td>
								<td class="td_title">移除过黑名单：</td>
								<td class="td_main">
									<select name="removeBlack">
										<option value=""></option>
										<option value="1"<?php if(I('get.removeBlack')=="1"){echo"selected";}?>>是</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">拉黑原因：</td>
								<td class="td_main">
									<select name="bak_type">
										<option value=""></option>
										<option value="1">骗子/钓鱼/微商</option>
										<option value="2">违规操作</option>
										<option value="3">商务需求</option>
										<option value="4">中介/托管</option>
										<option value="6">其他</option>
									</select>
								</td>
								<td class="td_title">查设备号：</td>
								<td class="td_main">
									<select name="appType" style="width:90px">
										<option value="1"<?php if(I('get.appType')=="1"){echo"selected";}?>>房东版</option>
										<option value="2"<?php if(I('get.appType')=="2"){echo"selected";}?>>租客版</option>
									</select>&nbsp;<input type="text" style="width:120px" placeholder="输入手机号" name="mobileTwo" value="<?php echo I('mobileTwo'); ?>">
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
				<h2>黑名单列表<a href="/hizhu/BlackList/addBlackUser?no=6&leftno=71" class="btn_a">新增黑名单</a><a href="#" class="btn_a" id="btnDownload" style="margin-left:140px;">下载</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>手机号</th>
								<th>限制登录</th>
								<th>限制回复</th>
								<th>限制拨打电话</th>
								<th>操作房源</th>
								<th>拉黑原因</th>
								<th>备注信息</th>
								<th>操作时间</th>
								<th>操作人</th>
								<th>操作</th><th>历史记录</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><?php echo ($list["mobile"]); ?></td>
								<td><?php echo $list['no_login']=="1"?"是":"否" ?></td>
								<td><?php echo $list['no_post_replay']=="1"?"是":"否" ?></td>
								<td><?php echo $list['no_call']=="1"?"是":"否" ?></td>
								<td><?php switch($list["out_house"]): case "1": ?>已下架<?php break; case "2": ?>已删除<?php break; endswitch;?></td>
								<td><?php switch($list["bak_type"]): case "1": ?>骗子/钓鱼/微商<?php break; case "2": ?>违规操作<?php break; case "3": ?>商务需求<?php break; case "4": ?>中介/托管<?php break; case "6": ?>其他<?php break; endswitch;?></td>
								<td><?php echo ($list['bak_info']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$list['update_time'])); ?></td>
								<td><?php echo ($list["oper_name"]); ?></td>
								<td><?php switch($list["handle_type"]): case "2": ?><a href="javascript:;" onclick="removeBlackUser('<?php echo ($list["id"]); ?>','<?php echo ($list["mobile"]); ?>',this)">删除</a><?php break;?>
									<?php case "1": ?>恢复<?php break; case "0": ?>拉黑<?php break; endswitch;?></td>
								<td><a target="__blank" href="/hizhu/BlackList/blackuserlog?mobile=<?php echo ($list["mobile"]); ?>">查看</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalCount); ?>条记录</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--遮罩层（删除拉黑，备注） -->
	<div id="remove_div" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:120px;background:#fff;position:absolute;left:55%;margin-left:-300px;top:50%;margin-top:-55px;border-radius:10px;overflow:hidden;padding:30px;">
			<label style="height:30px;line-height:30px;">备注信息：<input type="text" name="bakInfo" maxlength="50" style="width:80%;height:30px;"></label>
			<div  style="text-align:center;margin-top:20px;">
				<input type="hidden" name="modify_id" data-index="">
				<input type="hidden" name="modify_phone">
				<button class="btn_b" style="margin-right:50px;" id="btn_cancel">取消</button>
				<button class="btn_a" id="btn_submit">提交</button>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
	$('.inpt_a').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$("#btnSearch").click(function(){
		$(this).unbind("click").text("搜索中");
		$("#searchForm").submit();
	});
	$("select[name='bak_type']").val('<?php echo I("get.bak_type"); ?>');
$("#btnDownload").click(function(){
	$(this).unbind('click');
	window.location.href="/hizhu/BlackList/downloadBlacklist.html?<?php echo $_SERVER['QUERY_STRING'];?>";
});
	/*删除拉黑 */
	function removeBlackUser(blackId,mobile,obj){
		$("#remove_div").show();
		$("input[name='modify_phone']").val(mobile);
		$("input[name='modify_id']").val(blackId).attr('data-index',$(obj).parent().parent().index());
	}
	$("#btn_cancel").click(function(){
		$("#remove_div").hide();
	});
	$("#btn_submit").click(function(){
		removeBlackSubmit();
	});
	function removeBlackSubmit(){
		var bakInfo=$("input[name='bakInfo']").val();
		if(bakInfo==''){
			return false;
		}
		$("#btn_submit").unbind('click').text('提交中');
		$.post("/hizhu/BlackList/removeBlackUser",{blackId:$("input[name='modify_id']").val(),phone:$("input[name='modify_phone']").val(),bak_info:bakInfo},function(data){
			alert(data.msg);
			if(data.status=="200"){
				$("#remove_div").hide();
				$("input[name='bakInfo']").val('');
				var tr_index=$("input[name='modify_id']").attr('data-index');
				tr_index=parseInt(tr_index)+1;
				$("#dataDiv table tr:eq("+tr_index+")").remove();
			}
			$("#btn_submit").bind('click',function(){
				removeBlackSubmit();
			}).text('提交');
		},"json");
		
	}
</script>

</html>