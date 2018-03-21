<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>修改认证房东</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/add_landlord.css">

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
				<h2>认证房东</h2>
			</div>
			<div class="common_main">
			   <form action="<?php echo U('Customer/upSubLandlord');?>" method="post"  id="form">
			     <input type="hidden" name="b_id" value="<?php echo ($bankarr[b_id]); ?>"/>
			     <input type="hidden" name="p_id" value="<?php echo ($bankarr[p_id]); ?>"/>
			     <input type="hidden" name="c_id" value="<?php echo ($bankarr[c_id]); ?>"/>
			     <input type="hidden" name="mobile" value="<?php echo ($customer[mobile]); ?>"/>
				<table class="table_one table_two">
					<tr>
						<td colspan="2">房东信息</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房东电话：</td>
						<td class="td_main"><?php echo ($customer[mobile]); ?></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房东姓名：</td>
						<td class="td_main"><input type="text" name="name" value="<?php echo ($customer[true_name]); ?>"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>性别：</td>
						<td class="td_main">
							<label><input type="radio" name="sex" value="1"<?php if($customer['sex']==1){echo"checked";}?>/>&nbsp;男</label>&nbsp;&nbsp;&nbsp;
							<label><input type="radio" name="sex" value="0"<?php if($customer['sex']==0){echo"checked";}?>/>&nbsp;女</label>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>年龄段：</td>
						<td class="td_main">
					<label><input type="radio" name="age" value="0905"<?php if($customer['age']=='0905'){echo"checked";}?>/>&nbsp;60后</label>&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="age" value="0904"<?php if($customer['age']=='0904'){echo"checked";}?>/>&nbsp;70后</label>&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="age" value="0903"<?php if($customer['age']=='0903'){echo"checked";}?>/>&nbsp;80后</label>&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="age" value="0902"<?php if($customer['age']=='0902'){echo"checked";}?>/>&nbsp;90后</label>&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="age" value="0901"<?php if($customer['age']=='0901'){echo"checked";}?>/>&nbsp;00后</label>
					</td>
					</tr>
						<tr>
						<td colspan="2">房东收款账号信息</td>
					</tr>
					<tr>
						<td class="td_title">私人银行卡号：</td>
						<td class="td_main"><input type="text" name="bankaccount" value="<?php echo ($bankarr[bankaccount]); ?>"></td>
					</tr>
					<tr>
						<td class="td_title">支付宝账号：</td>
						<td class="td_main"><input type="text" name="paytreasure" value="<?php echo ($bankarr[paytreasure]); ?>"></td>
					</tr>
					<tr>
						<td class="td_title">对公账号：</td>
						<td class="td_main"><input type="text" name="companyaccount" value="<?php echo ($bankarr[companyaccount]); ?>"></td>
					</tr>
					<tr>
						<td colspan="2">证件照（<span>必须上传真实照片</span>）</td>
					</tr>
				  </table>
		
				<div class="idcard">
					<ul class="cf">
						<li>
							<p>身份证正面</p><img src="images/xx.jpg" alt="身份证正面">
							<a href="javascript:">删除</a>
							<div class="upload_photo">
								<span>上传照片</span>
								<input type="file">
							</div>
						</li>
						<li>
							<p>身份证反面</p><img src="images/xx.jpg" alt="身份证反面">
							<a href="javascript:">删除</a>
							<div class="upload_photo">
								<span>上传照片</span>
								<input type="file">
							</div>
						</li>
						<li>
							<p>手持身份证</p><img src="images/xx.jpg" alt="手持身份证">
							<a href="javascript:">删除</a>
							<div class="upload_photo">
								<span>上传照片</span>
								<input type="file">
							</div>
						</li>
					</ul>
				</div>
				<div class="addhouse_last addhouse_last_room">
					<a href="<?php echo U('Customer/authenticationList');?>" class="btn_a">返回</a>
						<button class="btn_a" onclick="return check();">确定认证</button>
					</div>
				</form>
			</div>
		</div>
 <script src="/hizhu/Public/js/jquery.js"></script>
 <script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">
	/*提交表单*/
 function check(){
 	   var isMobile=/^1[34578]\d{9}$/;
 	   var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	   var mobile=$("input[name='mobile']").val();
	   var name=$("input[name='name']").val();
	   var bankaccount=$("input[name='bankaccount']").val();
	   var paytreasure=$("input[name='paytreasure']").val();
	   var companyaccount=$("input[name='companyaccount']").val();
	   if(name==""){
		   alert("房东姓名不能为空！");
		   return false;
	   }
	   if(bankaccount!=""){
    	  if(!isNaN(bankaccount)){	
		   	 if(bankaccount.length<12 || bankaccount.length>19){
		   	 	 alert("银行卡号需为12到19位的数字");
			    return false;
		   	 }
		  }else{
		   		 alert("银行卡号需为12到19位的数字");
				    return false;
	   	  }
	   }
	    if(paytreasure!=""){
	   	 if(!isMobile.test(paytreasure)&&!myreg.test(paytreasure)){
	   	 	 alert("支付宝账号需为邮箱或手机号");
		    return false;
	   	 }
	   }
	   if(companyaccount!=""){ 
	   	 if(!isNaN(companyaccount)){	
	   	   if(companyaccount.length<9 || companyaccount.length>24){
	   	 	 alert("对公账号需为9-24位数字");
	   	 	  return false;
	   	   }
	   	}else{
		   	 alert("对公账号需为9-24位数字");
		    return false;
	    }
	  }
   }
</script>
</body>
</html>