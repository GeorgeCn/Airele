<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link href="/Public/Home/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/Public/Home/js/jquery.min.js"></script>
<!-- Custom Theme files -->
<!--menu-->
<script src="/Public/Home/js/scripts.js"></script>
<link href="/Public/Home/css/styles.css" rel="stylesheet">
<!--//menu-->
<!--theme-style-->
<link href="/Public/Home/css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Real Home Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- slide -->
<script src="/Public/Home/js/responsiveslides.min.js"></script>
   <script>
    $(function () {
      $("#slider").responsiveSlides({
      	auto: true,
      	speed: 500,
        namespace: "callbacks",
        pager: true,
      });
    });
  </script>
 
</head>
<body >
<!--header-->
	<!-- <?php unset($_SESSION['home']) ?> -->
	<!-- <?php echo var_dump($cimage);?> -->
	
	<div class="navigation">
		<div class="container-fluid">
			<nav class="pull">
				<ul>
					<li><a  href="index.html">Home</a></li>
					<li><a  href="about.html">About Us</a></li>
					<li><a  href="blog.html">Blog</a></li>
					<li><a  href="terms.html">Terms</a></li>
					<li><a  href="privacy.html">Privacy</a></li>
					<li><a  href="contact.html">Contact</a></li>
				</ul>
			</nav>			
		</div>
	</div>

<div class="header">
	<div class="container">
		<!--logo-->
			<div class="logo">
				<h1><a href="<?php echo U('Index/index');?>">REAL HOME</a></h1>
			</div>
		<!--//logo-->
		<div class="top-nav">
			<ul class="right-icons">
				
					<?php if(($_SESSION['user'] == 0 ) ): ?><li><a  href="<?php echo U('Public/login');?>"><i class="glyphicon glyphicon-user"> </i>Login</a></li>

					<?php else: ?> 

					<li><a  href="<?php echo U('Personal/index');?>"><i class="glyphicon glyphicon-user"> </i><?php echo($_SESSION['user']['nickname'])?></a></li>

					 <li><a href="<?php echo U('Public/logout');?>"><span ><i class="glyphicon glyphicon-off"> 退出 </i></span></a></li><?php endif; ?>
<!-- 
				<li><a  href="<?php echo U('Public/login');?>"><i class="glyphicon glyphicon-user"> </i>Login</a></li>


				<li><a  href="<?php echo U('Public/login');?>"><i class="glyphicon glyphicon-user"> </i>123</a></li>
 -->
				

				<li><a class="play-icon popup-with-zoom-anim" href="#small-dialog"><i class="glyphicon glyphicon-search"> </i> </a></li>
				
			</ul>
			<div class="nav-icon">
				<div class="hero fa-navicon fa-2x nav_slide_button" id="hero">
						<a href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> </a>
					</div>	
				<!---
				<a href="#" class="right_bt" id="activator"><i class="glyphicon glyphicon-menu-hamburger"></i>  </a>
			--->
			</div>
		<div class="clearfix"> </div>
			<!---pop-up-box---->
			   
				<link href="/Public/Home/css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
				<script src="/Public/Home/js/jquery.magnific-popup.js" type="text/javascript"></script>
			<!---//pop-up-box---->
				<div id="small-dialog" class="mfp-hide">
					    <!----- tabs-box ---->
				<div class="sap_tabs">	
				     <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
						  <ul class="resp-tabs-list">
						  	  <li class="resp-tab-item " aria-controls="tab_item-0" role="tab"><span>All Homes</span></li>
							  <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span>For Sale</span></li>
							  <li class="resp-tab-item" aria-controls="tab_item-2" role="tab"><span>For Rent</span></li>
							  <div class="clearfix"></div>
						  </ul>				  	 
						  <div class="resp-tabs-container">
						  		<h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0"><span class="resp-arrow"></span>All Homes</h2><div class="tab-1 resp-tab-content resp-tab-content-active" aria-labelledby="tab_item-0" style="display:block">
								 	<div class="facts">
									  	<div class="login">
											<input type="text" value="Search Address, Neighborhood, City or Zip" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search Address, Neighborhood, City or Zip';}">		
									 		<input type="submit" value="">
									 	</div>        
							        </div>
						  		</div>
							     <h2 class="resp-accordion" role="tab" aria-controls="tab_item-1"><span class="resp-arrow"></span>For Sale</h2><div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
									<div class="facts">									
										<div class="login">
											<input type="text" value="Search Address, Neighborhood, City or Zip" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search Address, Neighborhood, City or Zip';}">		
									 		<input type="submit" value="">
									 	</div> 
							        </div>	
								 </div>									
							      <h2 class="resp-accordion" role="tab" aria-controls="tab_item-2"><span class="resp-arrow"></span>For Rent</h2><div class="tab-1 resp-tab-content" aria-labelledby="tab_item-2">
									 <div class="facts">
										<div class="login">
											<input type="text" value="Search Address, Neighborhood, City or Zip" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search Address, Neighborhood, City or Zip';}">		
									 		<input type="submit" value="">
									 	</div> 
							         </div>	
							    </div>
					      </div>
					 </div>
					 <script src="/Public/Home/js/easyResponsiveTabs.js" type="text/javascript"></script>
				    	<script type="text/javascript">
						    $(document).ready(function () {
						        $('#horizontalTab').easyResponsiveTabs({
						            type: 'default', //Types: default, vertical, accordion           
						            width: 'auto', //auto or any width like 600px
						            fit: true   // 100% fit in a container
						        });
						    });
			  			 </script>	
				</div>
				</div>
				 <script>
						$(document).ready(function() {
						$('.popup-with-zoom-anim').magnificPopup({
							type: 'inline',
							fixedContentPos: false,
							fixedBgPos: true,
							overflowY: 'auto',
							closeBtnInside: true,
							preloader: false,
							midClick: true,
							removalDelay: 300,
							mainClass: 'my-mfp-zoom-in'
						});
																						
						});
				</script>
					
	
		</div>
		<div class="clearfix"> </div>
		</div>	
</div>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wb="http://open.weibo.com/wb"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<link href="//staticnew.mayi.com/resourcesWeb/ordernew/css/order_public.css" rel="stylesheet">
<link href="//staticnew.mayi.com/resourcesWeb/ordernew/css/order.css" rel="stylesheet">
<!-- <link href="//staticnew.mayi.com/resourcesWeb/v201510/css/public_element.css" rel="stylesheet"> -->
<link href="//staticnew.mayi.com/resourcesWeb/ordernew/css/order_money.css" rel="stylesheet">
<title>订单-支付订金</title>
<script charset="utf-8" src="http://trust.baidu.com/vcard/v.js?siteid=1700199&amp;url=http%3A%2F%2Fwww.mayi.com%2Forder%2Ffastwaitpay%2F850955921%3FisVisitorFlag%3Dfalse&amp;source=http%3A%2F%2Fbzclk.baidu.com%2Fadrc.php%3Ft%3D06KL00c00fDGLK60okqy0aHS56DD4wum00000axhpW300000YlZDoT.THLaePQ5V_1g36K85yF9pywd0ZnqrHwbuW9WuWTsnj0sP19-r0Kd5HIDrjbsPWbLwHTYrRcvnDnYwj97fR7jPHR3fW63njc30ADqI1YhUyPGujYzrjc4P1mdnW0vFMKzUvwGujYkP6K-5y9YIZ0lQzqLILT8Uy74pi4WUvYE5vP9gLnqIAIxmh7GuZRhmv7xUWdspy4lpZN9U-qbX-qBIauWmNqG5y7b0APzm1Yvnjmd%26tpl%3Dtpl_10085_14394_1%26l%3D1047193127%26ie%3Dutf-8%26f%3D8%26tn%3Dbaidu%26wd%3D%25E8%259A%2582%25E8%259A%2581%25E7%259F%25AD%25E7%25A7%259F%26oq%3DSQLSTAT%2526gt%253B%255BHY000%255D%2520%255B1045%255D%2520Access%2520denied%2520for%2520user%2520%2526%252339%253Broot%2526%252339%253B%2540%2526%252339%253Blocalhost%2526%252339%253B%2520(using%2520pass%26rqlang%3Dcn%26inputT%3D1055%26bs%3DSQLSTATE%255BHY000%255D%2520%255B1045%255D%2520Access%2520denied%2520for%2520user%2520%2527root%2527%2540%2527localhost%2527%2520(using%2520pass&amp;rnd=527116347&amp;hm=1"></script><script src="//hm.baidu.com/hm.js?0294bbb72b1c6a6b342da076397c9af2"></script><script type="text/javascript" async="" src="//staticnew.mayi.com/resourcesWeb/js/statistics/stmy.js?v=1311111130"></script><script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/v201510/js/commom.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/js/layer/layer.min.js"></script><link type="text/css" rel="stylesheet" href="http://staticnew.mayi.com/resourcesWeb/js/layer/skin/layer.css">


<link type="text/css" rel="stylesheet" href="http://staticnew.mayi.com/resourcesWeb/js/layer/skin/layer.css"><link type="text/css" rel="stylesheet" href="http://staticnew.mayi.com/resourcesWeb/js/layer/skin/layer.css"></head>
<body lim:visitorcapacity="1">
	<!-- Header -->
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/js/searchlist/index_searchlist_public.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/js/pub/list_header.js"></script> 
<style>	
.logo58{background:url(//staticnew.mayi.com/resourcesWeb/images/index/58logo.png) no-repeat;left:14px !important;top:16px !important;}
.logomayi{left:200px !important;}
.alert-box1{width:100%;height: 100%;z-index: 300000;position: absolute;display:none;line-height:40px;}
.surveYY1{background: #000;width:100%;height:100%;opacity: 0.7;position: fixed;top: 0px;left: 0px;}
.offmax_no{width:400px;height:186px;position:fixed;top:50%;margin-top:-93px;left:50%;margin-left:-200px;background-color:#fff;z-index:999;text-align:center;box-shadow:0px 0px 4px #ccc;border-radius:2px;} 
.offmax_no p{padding:0 20px;line-height:25px;}
.alert_tit1{border-bottom:1px solid #e0e0e0;font-size:18px;margin-bottom:20px;}
.close-alert1{cursor:pointer;width:50%;margin:20px auto;background-color:#22bb62;text-align:center;color:#fff;border-radius:2px;}
</style>

<input type="hidden" name="subdomain" id="subdomain" value="">
<input type="hidden" name="mainsite" id="mainsite" value="">
<input type="hidden" name="ctx" id="ctx" value="">
<input type="hidden" name="ctx1" id="ctx1" value="//staticnew.mayi.com">
<input type="hidden" name="uid" id="uid" value="852638523">
<input type="hidden" name="loginurl" id="loginurl" value="none">
<input type="hidden" name="head_userName" id="head_userName" value="用户3927">
 
 


<!-- <script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/js/c.js"></script>   
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/sdk/strophe.js"></script> 
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/sdk/easemob.im-1.1.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/sdk/easemob.im-1.1.shim.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/easemob.im.config.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/bootstrap.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/add_reply.js"></script>
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/jquery-ui.js"></script>  
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/IM.js"></script>  
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/js/account/ajaxfileupload.js"></script>  
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/operator.js"></script>  
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/webim.js"></script>  
<script type="text/javascript" src="//staticnew.mayi.com/resourcesWeb/im1/chat.js"></script>  
<link rel="stylesheet" href="//staticnew.mayi.com/resourcesWeb/im/css/IM.css?v=1">  
<link rel="stylesheet" href="//staticnew.mayi.com/resourcesWeb/im/css/jquery-ui.css">   -->
 
   
		<input type="hidden" id="MAYIUID" value="852638523">
	<div id="point" class="contacts_landlord clearfloat IM_content ui-draggable" style="display:none;">
		<span class="right_open_btn"></span>  
	<div class="fl contacter_left"><h3>最近联系人</h3><div class="" id="noContact"><p class="null_list">联系人列表是空的</p><a target="_blank" class="check_near" href="/user/tenant/msgmanager">查看最近联系人</a></div><ul class="contacter_ul"></ul></div><div class="contacter_right clearfloat fl"><div class="p_talk_right" id="contacter_right_0"><div class="fl contacter_right_talk" id="talk_0"><h3 class="clearfloat head_talk"></h3><div class="contacter_talk clearfloat"><div class="talk_parent"></div></div> <div class="xiaoxi_record"><a target="_blank" href="/user/tenant/msgmanager" class="xiaoxi_record_a clearfloat"><i class="fr">消息记录</i><span class="xiaoxi_bj fr"></span></a></div><textarea disabled="" class="xiaoxi_text xiaoxi_text_none" cols="" rows="" name=""></textarea><div class="xiaoxi_btn clearfloat"><button class="contacts_null send fr send_none" a="0">发送</button></div></div></div><div class="swiper_wrap_div fl" style=""><ul class="font_inner_ul" style="top: 0px;"><li class="tooltip_warm_li" style=""></li></ul></div><div class="fl auto_reply_hover about"><span class="auto_reply_img"></span></div><div class="about auto_reply_tan" style="display: none;"><div class="fl auto_reply_hover about"><span class="auto_reply_img"></span></div><ul id="auto_reply_tan_ul" class="auto_reply_tan_ul"><li><span class="text_reply">您好，请问几人入住呢？</span><!--<span class="reply_x"></span>--></li><li><span class="text_reply">抱歉，您看中的房源已经订出去了。</span><!--<span class="reply_x"></span>--></li><li><span class="text_reply" title="抱歉，蚂蚁禁止透露联系方式，您预订成功后蚂蚁会自动把我的联系方式发送给您。">抱歉，蚂蚁禁止透露联系方式，您预订成功后蚂蚁会自动把我的...</span><!--<span class="reply_x"></span>--></li><li><span class="text_reply">照片都是实地拍摄的，请放心下单。</span><!--<span class="reply_x"></span>--></li></ul></div><div class="fl auto_reply_hover about"><span class="auto_reply_img"></span></div></div></div>
	<!-- <a class="IM_btn" style="display: block;" href="javascript:;"><span class="IM_btn_span"><i style="display:none;">0</i></span>在线聊天</a> -->
<div class="im_sfz_tan" style="display: none;">
<span></span>
		<img src="" alt="">
</div>
<style>
.im_sfz_tan{
	position:fixed;
	left:0;
	top:0;
	width:100%;
	height:100%;
	background:rgba(0,0,0,0.6);
	z-index: 1000001;
	line-height:100%;
	text-align: center;
	display:none;
	
}
.im_sfz_tan span{
	display:inline-block;
	height:100%;
	vertical-align:middle;
}
.im_sfz_tan img{
	display:inline;
	max-width:1190px;
	max-height:700px;
	min-width:600px;
	min-height:220px;
	vertical-align: middle;
	border:10px solid #fff;
}
</style>
 
    <script>
// 	var uid=$('#MAYIUID').val();
// 	if(uid!='')
// 	{
// 		$('.IM_btn').css('display','block');
// 	}
// </script>

		
	
 	<!-- Header END -->
	<!-- Content -->
	<!--MY统计所需域 -->
	<input type="hidden" name="my_p_t" id="my_p_t" value="paying">
	<input type="hidden" name="my_b_id" id="my_b_id" value="850955921">
	<input type="hidden" name="my_b_s" id="my_b_s" value="1">
	<input type="hidden" name="my_p_y" id="my_p_y" value="shanghai">
	<!--MY统计所需域 -->
	<!-- <div class="one_workflow">
		<div class="workflow relave">
			<div class="progress progress_1"></div>
				<b class="workflow1">提交订单</b>
				<b class="workflow2">支付订金</b>
				<b class="workflow3">房东确认</b>
				<b class="workflow4">预订成功</b>
				<span class="workflow1_1"><a href="javascript:;" class="a_after">1</a></span>
				<span class="workflow1_2"><a href="javascript:;" class="a_after">2</a></span>
				<span class="workflow1_3"><a href="javascript:;">3</a></span>
				<span class="workflow1_4"><a href="javascript:;" class="duigo"></a></span>
		
		</div>
	</div> -->
    <!-- <?php echo dump($orders);?> -->

	<form action="<?php echo U('Orders/zhifu');?>" method="post">
	
	<div class="content clearfloat min_h">
		<div class="cnt_tix clearfloat">
			<div class="fl duigo_par"><span></span></div>
			<div class="fl you_ti">
					<p class="you_p1">订单提交成功</p>
					<p class="you_p2">请您在24小时内支付金额,否则订单会自动取消&nbsp;&nbsp;<a href="<?php echo U('PersonOrders/index');?>" class="a_more">查看订单</a></p>
				
			</div>
		</div>
		<div class="pay_parent">
			<dl class="clearfloat">
				<dt class="fl">线上支付</dt>
				<dd class="fl color_tao"><span id="onlinePayAmountShow"><?php echo $orders[0]['amount'];?></span>元</dd>
			</dl>
			<div id="coupon"></div>
			<!--选择支付方式-->
			<dl class="clearfloat">
				<dt class="fl bank_dt">选择支付方式</dt>
				<dd class="bank fl">
					<ul class="clearfloat bank_ul1">
						<li class="bank_radio clearfloat"><label><input type="radio" name="paymethod" value="1"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/zhifubao.jpg" title="支付宝"></label></li>
						<li class="bank_radio clearfloat"><label><input type="radio" name="paymethod" value="4"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/weixin.jpg" title="微信支付"></label></li>
						<li class="bank_radio clearfloat"><label class="yinhk"><input type="radio" name="paymethod" value="2"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_ka.jpg" title="银行卡"></label></li>
						<li class="bank_radio clearfloat"><label><input type="radio" name="paymethod" value="3"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/caifutong.jpg" title="财付通"></label></li>
					</ul>
					<ul class="clearfloat bank_ul2">
					  	<input type="hidden" id="item">
						<li class="bank_radio clearfloat"><label><input id="icbc" type="radio" name="SelectPay" value="icbc"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_gongs.jpg" title="工商银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="ccb" type="radio" name="SelectPay" value="ccb"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_jians.jpg" title="建设银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="abc" type="radio" name="SelectPay" value="abc"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_nongy.jpg" title="农业银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="cmb" type="radio" name="SelectPay" value="cmb"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_zhaos.jpg" title="招商银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="postgc" type="radio" name="SelectPay" value="postgc"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_youz.jpg" title="邮政银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="boc" type="radio" name="SelectPay" value="boc"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_china.jpg" title="中国银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="comm" type="radio" name="SelectPay" value="comm"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_jiaot.jpg" title="交通银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="citic" type="radio" name="SelectPay" value="citic"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_zhongx.jpg" title="中信银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="bjbank" type="radio" name="SelectPay" value="bjbank"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_beij.jpg" title="北京银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="cmbc" type="radio" name="SelectPay" value="cmbc"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_mins.jpg" title="民生银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="cib" type="radio" name="SelectPay" value="cib"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/bank_xingy.jpg" title="兴业银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="ceb" type="radio" name="SelectPay" value="ceb"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/guangda.jpg" title="中国光大银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="spdb" type="radio" name="SelectPay" value="spdb"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/pufa.jpg" title="浦发银行"></label></li>
						<li class="bank_radio clearfloat"><label><input id="gdb" type="radio" name="SelectPay" value="gdb"><img src="//staticnew.mayi.com/resourcesWeb/ordernew/images/guangdong.jpg" title="广东发展银行"></label></li>
					</ul>
				</dd>
			</dl>
		</div>
		
		<input type="hidden" name="uuid" value="<?php echo ($orders['0']['ordernum']); ?>">
		<input type="hidden" name="gid" value="<?php echo ($orders['0']['gid']); ?>">	

		<!-- <div class="go_pay"><input href="">去支付</input></div> -->
		<input type="submit" class='submit fl' value="去支付"></input>

		</form>
	</div>
	</form>

	
	<style>

	</style>
	<!-- 支付后弹窗 -->
	<!-- <div id="goPayShow" class="alert-box">
		<div class="alert-title">
			在线支付<!-- 名字可动态自定义 -->
			<!-- <a class="alert-close" rel="nofollow" href="#"></a>
		</div> -->
		<!-- <div class="alert-con">
			<div class="pat-hint">
				<h3>请在新打开的页面完成付款！</h3>
				<p>完成付款后请根据您的情况点击下面的按钮。</p>
			</div>
			<div class="btn-box">
				<input type="button" class="green-btn mgrt30" name="" onclick="goPaysuccess();" value="已完成付款">
				<input type="button" class="gray-btn" name="" id="problems" value="付款遇到问题？">
			</div>
			<p class="select-again"><a href="#" rel="nofollow">返回选择其他支付方式&gt;&gt;</a></p>
		</div>
	</div> --> 
	<!-- 支付后弹窗 END -->
	
	<!-- Content END -->
	<!-- Footer -->


<!--footer-->
<div class="footer">
	<div class="container">
		<div class="footer-top-at">
			<div class="col-md-3 amet-sed">
				<h4>Our Company</h4>
				<ul class="nav-bottom">
					<li><a href="about.html">About Us</a></li>
					<li><a href="blog.html">For Sale By Owner Blog</a></li>
					<li><a href="mobile_app.html">Mobile</a></li>
					<li><a href="terms.html">Terms & Conditions</a></li>
					<li><a href="privacy.html">Privacy Policy</a></li>	
					<li><a href="blog.html">Blog</a></li>
					
				</ul>	
			</div>
			<div class="col-md-3 amet-sed ">
				<h4>Work With Us</h4>
					<ul class="nav-bottom">
						<li><a href="single.html">Real Estate Brokers</a></li>
						<li><a href="single.html">Business Development</a></li>
						<li><a href="single.html">Affiliate Programs</a></li>
						<li><a href="contact.html">Sitemap</a></li>
						<li><a href="career.html">Careers</a></li>
						<li><a href="feedback.html">Feedback</a></li>	
					</ul>	
			</div>
			<div class="col-md-3 amet-sed">
				<h4>友情链接</h4>
				<p>177-869-6559</p>
					<ul class="nav-bottom">
						<?php if(is_array($Blogroll)): $i = 0; $__LIST__ = $Blogroll;if( count($__LIST__)==0 ) : echo "虚位以待" ;else: foreach($__LIST__ as $key=>$var): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($var['italic']); ?>" target="_blank"><?php echo ($var['name']); ?></a></li><?php endforeach; endif; else: echo "虚位以待" ;endif; ?>
					</ul>	
			</div>
			<div class="col-md-3 amet-sed ">
				<h4>Property Services</h4>
				   <ul class="nav-bottom">
						<li><a href="single.html">Residential Property</a></li>
						<li><a href="single.html">Commercial Property</a></li>
						<li><a href="login.html">Login</a></li>
						<li><a href="register.html">Register</a></li>
						<li><a href="typo.html">Short Codes</a></li>	
					</ul>	
					<ul class="social">
						<li><a href="#"><i> </i></a></li>
						<li><a href="#"><i class="gmail"> </i></a></li>
						<li><a href="#"><i class="twitter"> </i></a></li>
						<li><a href="#"><i class="camera"> </i></a></li>
						<li><a href="#"><i class="dribble"> </i></a></li>
					</ul>
			</div>
		<div class="clearfix"> </div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="col-md-4 footer-logo">
				<h2><a href="index.html">REAL HOME</a></h2>
			</div>
			<div class="col-md-8 footer-class">
				<p >Copyright &copy; 2015.Company name All rights reserved.</p>
			</div>
		<div class="clearfix"> </div>
	 	</div>
	</div>
</div>
<!--//footer-->
</body>
</html>