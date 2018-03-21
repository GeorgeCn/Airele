<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>店铺信用分</title>
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
				<h2>更改信用分</h2>
				<div class="common_head_main">
					<table class="table_one">
						<tr>
							<td class="td_title">店铺名称：</td>
							<td class="td_main" ><?php echo ($detail['name']); ?>
							</td>
							<td class="td_title">创建时间：</td>
							<td class="td_main"><?php echo (date("Y-m-d H:i:s",$detail['create_time'])); ?></td>
						</tr>
						<tr>
							<td class="td_title">信用分：</td>
							<td class="td_main" ><?php echo ($detail['credit_score']); ?>分</td>
							<td class="td_title">保证金：</td>
							<td class="td_main" ><?php echo ($detail['earnestmoney']); ?>元</td>
						</tr>
						<tr>
							<td class="td_title">店铺类型：</td>
							<td class="td_main">
								<?php if(strtoupper($detail['medal_type']) == '0'): ?>普通
									<?php elseif(strtoupper($detail['medal_type']) == '1'): ?>
									 金牌
									<?php elseif(strtoupper($detail['medal_type']) == '2'): ?>
									 银牌<?php endif; ?>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>	
						</tr>	
					</table>
				</div>
			</div>
			<div class="common_main">
				<!-- 表单 -->
				<form action="<?php echo U('stores/modifyCreScore');?>" name="regForm" method="post">
				<table class="table_one table_two" style="margin-top:80px;max-width:680px">
				<input type="hidden" name="id" value="<?php echo ($detail['id']); ?>">
				<input type="hidden" name="now_score" value="<?php echo ($detail['credit_score']); ?>">
					<tr>
						<td class="td_title" >
							<select name="sign" style="min-width:105px">
						    	<option value="-">扣除信用分</option>
						    	<option value="+">增加信用分</option>
						    </select>
						</td>
						<td class="td_main"><input type="text" name="score_num" style="min-width:150px"></td>
					</tr>
					<tr>
						<td class="td_title" >房间编号：</td>
						<td class="td_main"><input type="text" name="room_no" style="min-width:150px" value="<?php echo I('get.room_no');?>"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>原&nbsp;&nbsp;&nbsp;&nbsp;因: </td> 
						<td class="td_main" >
							<select name="score_type" style="min-width:350px" id="select" onchange="tempShow()">
						    	<option value="5">因平台展示房源的地址误差距离超过1000米,扣10分</option>
						    	<option value="6">因平台展示房源实际已出租，扣10分</option>
						    	<option value="7">因平台展示租金与实际租金上浮超过10%，扣10分</option>
						    	<option value="8">因平台展示房源面积与实际面积下浮超过5㎡，扣10分</option>
						    	<option value="9">因平台展示的图片与实际情况不符，扣10分</option>
						    	<option value="10">因将合租写成整租，扣10分</option>
						    	<option value="11">因夸大平台展示房源的户型，扣10分</option>
						    	<option value="12">因服务过程中恶意辱骂租客，扣50分</option>
						    	<option value="13">因任何违反国家法律的行为，扣至0分</option>
						    	<option value="14">缴纳保证金</option>
								<option value="15">其他原因</option>
						    </select>
						    <span>请选择,原因会推送给客户</span>
						</td>
					</tr>
					<tr id='reason'>
						<td class="td_title">输入其他原因</td>
						<td class="td_main"><input type="text" name="msg_txt" style="min-width:350px" placeholder="请输入更改信用分原因，原因会推送给用户"></td>
					</tr>
					<input type="hidden" name="id" value="<?php echo ($detail['id']); ?>">
				</table>
				<div class="addhouse_last addhouse_last_room">
					<input type="submit" class="btn_a" value="更改" style="min-width: 680px;min-height:40px;line-height:40px;margin-top:30px">
				</div>
				</form>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script>
$('#reason').hide();
function tempShow() {
	var temp = $('#select').val();
	if(temp == 15) {
		$('#reason').show();
	} else {
		$('#reason').hide();
	}
}
</script>
</html>