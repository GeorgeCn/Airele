<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>更改店铺名称</title>
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
				<h2>更改店铺名称</h2>
				<div class="common_head_main">
					<table class="table_one">
						<tr>
							<td class="td_title">店铺名称：</td>
							<td class="td_main"><?php echo ($detail['name']); ?></td>
							<td class="td_title">创建时间：</td>
							<td class="td_main text-center"><?php echo (date("Y-m-d H:i:s",$detail['create_time'])); ?></td>
						<tr>
							<td class="td_title">店铺类型：</td>
							<td class="td_main">
								<?php if(strtoupper($detail['medal_type']) == '0'): ?>普通
									<?php elseif(strtoupper($detail['medal_type']) == '1'): ?>
									 金牌
									<?php elseif(strtoupper($detail['medal_type']) == '2'): ?>
									 银牌<?php endif; ?>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
						</tr>	
					</table>
				</div>
			</div>
			<div class="common_main">
				<!-- 表单 -->
				<form action="<?php echo U('stores/modifyStoreTitle');?>" name="regForm" method="post">
				<table class="table_one table_two" style="margin-top:80px;max-width:680px">
					<tr>
						<td class="td_title"><span>*</span>店铺新名称: </td> 
						<td class="td_main" ><input type="text" name="name" onblur="checkTitle()" id="titles" style="min-width:360px"><span id="ttab">&nbsp;* 必填项,请输入名称</span></td>
					</tr>
					<input type="hidden" name="id" value="<?php echo ($detail['id']); ?>">
				</table>
				</form>
				<div class="addhouse_last addhouse_last_room">
					<a href="javascript:;" class="btn_a" style="min-width: 640px;min-height:40px;line-height:40px;margin-top:30px">更改</a>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
   //js：
   		//验证标题函数
        function checkTitle() {
            var title = document.getElementById('titles').value;
            var ttab = document.getElementById('ttab');
            if (title == "") {
                // 匹配失败
                ttab.innerHTML = '* 内容不能为空!';
                ttab.style.color = '#f00';
                return false;
            } else{
                ttab.innerHTML = '* √通过验证!';
                ttab.style.color = '#0a0';
                return true;
            }
        }
        $(".btn_a").bind("click",function(){
			if(checkTitle()) {
				$("form").submit();
			}
		})
</script>	
</html>