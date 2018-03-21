<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>白名单列表</title>
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
				<h2>查询</h2>
				<div class="common_head_main">
					<form id="searchForm" action="/hizhu/BlackList/whiteuserlist" method="get">
						<input type="hidden" name="no" value="6">
						<input type="hidden" name="leftno" value="186">
						<input type="hidden" id="jump" name="p">
						<table class="table_one">
							<tr>
								<td class="td_title">手机号：</td>
								<td class="td_main"><input type="text" name="mobile" value="<?php echo I('mobile'); ?>"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>列表<a href="#" class="btn_a" onclick="addWhite()">新增</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>手机号</th>
								<th>备注信息</th>
								<th>操作时间</th>
								<th>操作人</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
								<td><?php echo ($list['mobile']); ?></td>
								<td><?php echo ($list['bak_info']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$list['create_time'])); ?></td>
								<td><?php echo ($list['create_man']); ?></td>
								<td><a href="#" onclick="removeWhite('<?php echo ($list["mobile"]); ?>',this)">删除</a></td>
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
	<!--遮罩层 -->
	<div id="dialog_div" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:450px;height:130px;background:#fff;position:absolute;left:55%;margin-left:-300px;top:50%;margin-top:-55px;border-radius:10px;overflow:hidden;padding:30px;">
			<label style="height:30px;line-height:30px;">手机：<input type="text" name="txtMobile" maxlength="20" style="width:50%;height:30px;"></label><br><br>
			<label style="height:50px;line-height:50px;">备注：<input type="text" name="txtBakInfo" maxlength="50" style="width:80%;height:50px;"></label>
			<div  style="text-align:center;margin-top:20px;">
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
	function removeWhite(phone,obj){
		if(confirm("确认移除吗？")){
			$.post("/hizhu/BlackList/removeWhiteuser",{mobile:phone},function(data){
				alert(data.msg);
				if(data.status=="200"){
					$(obj).parent().parent().remove();
				}
			},"json");
		}
	}
	/*新增 */
	function addWhite(){
		$("#dialog_div").show();
	}
	$("#btn_cancel").click(function(){
		$("#dialog_div").hide();
	});
	$("#btn_submit").click(function(){
		addSubmit();
	});
	function addSubmit(){
		var mobile=$("input[name='txtMobile']").val();
		var bakInfo=$("input[name='txtBakInfo']").val();
		var regMobile=/^1[34578]\d{9}$/;
		if(!regMobile.test(mobile)){
			alert("请输入有效手机");return false;
		}
		if(bakInfo==''){
			alert("请输入备注");return false;
		}
		$("#btn_submit").unbind('click').text('提交中');
		$.post("/hizhu/BlackList/addWhiteSubmit",{mobile:mobile,bak_info:bakInfo},function(data){
			alert(data.msg);
			if(data.status=="200"){
				$("#dialog_div").hide();
				window.location.reload();
			}
			$("#btn_submit").bind('click',function(){
				addSubmit();
			}).text('提交');
		},"json");
		
	}
</script>

</html>