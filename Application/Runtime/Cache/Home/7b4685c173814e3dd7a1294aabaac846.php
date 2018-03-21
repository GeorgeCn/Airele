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

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>下单页</title>
    
    <link rel="stylesheet" href="/Public/Home/css/order.css" />
    <!-- <link href="/Public/Home/css/public_element.css" rel="stylesheet"> -->
    <link href="/Public/Home/css/order_public.css" rel="stylesheet">
    <link href="/Public/Home/css/index_list_calendar.css" rel="stylesheet" type="text/css">
    <link href="/Public/Home/css/layer.css" rel="stylesheet" type="text/css">
    <link href="/Public/Home/css/fdbx.css" rel="stylesheet">
    <script type="text/javascript" src="/Public/Home/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" language="javascript">  
		$(function(){
		    m={
		        roomid:'850578725',
		   	 	minday:'3',
		    	detialJson:'{"checkinday":"2016-11-21","checkoutday":"2016-11-24","checkinOfWeek":"周一","checkoutOfWeek":"周四","nights":3,"roomNum":1,"totalPrice":22800,"showtotalprice":228.0,"onlinePayAmount":228.0,"onlineAmount":22800,"payRuleRate":100,"refunddays":1,"allrefundday":"2016-11-20","promotionModel":{"userCouponEntityList":[],"accountEntityList":[]},"priceDetailModel":{"sum":22800,"showtotalPrice":228.0,"originalPrice":7600,"items":[{"date":"2016-11-21","originalPrice":76,"price":7600,"priceShow":76.0,"type":6,"dayAmount":76.0},{"date":"2016-11-22","originalPrice":76,"price":7600,"priceShow":76.0,"type":6,"dayAmount":76.0},{"date":"2016-11-23","originalPrice":76,"price":7600,"priceShow":76.0,"type":6,"dayAmount":76.0}]},"haveStock":1,"from":2,"deposit":30000}' 
		    };
		    $('.App_download').mouseover(function(){
		        $(this).find('.order_head_pop').show();
		    })
		    $('.App_download').mouseout(function(){
		        $(this).find('.order_head_pop').hide();
		    })
		});
	</script>   
    <script type="text/javascript" src="/Public/Home/js/c.js" ></script>  
    <script type="text/javascript" src="/Public/Home/js/ticket.js" ></script>
    <!--kgj add保险JS START-->
    <script type="text/javascript" src="/Public/Home/js/insurance.js"></script>
    <script type="text/javascript" src="/Public/Home/js/idcard.js"></script>
    <script type="text/javascript" src="/Public/Home/js/mayi.validate.js"></script>
    <script type="text/javascript" src="/Public/Home/js/maputil.js"></script>
    <script type="text/javascript" src="/Public/Home/js/usercontact.js"></script>
    <!--kgj add保险JS END-->
    <!--日历-->
    <script type="text/javascript" src="/Public/Home/js/yui-min.js" ></script>
    <script type="text/javascript" src="/Public/Home/js/index_list_calendar.js" ></script>
    
    <script type="text/javascript" src="/Public/Home/js/order.js"></script>
    <script type="text/javascript" src="/Public/Home/js/bookorder.js"></script>
    <!--右侧滚动效果-->
    <script type="text/javascript" src="/Public/Home/js/scroll_zi.js"></script>
    <script type="text/javascript" src="/Public/Home/js/scroll_zi.js"></script>
    <script type="text/javascript" src="/Public/Home/js/util.js"></script>
    

	<style>
	    .birthdayp{display:inline-block;}
	    .tab input,.inspersonDetail .selectIdcard,.selectsex,.selectNation{margin-left:5px;}
	    .ntd_div2{width:116px;}
	    .ntd_div3{width:185px;}
	    .ntd_div4{width:94px;}
	    .ntd_div1 input{width:83px;}
	    .ntd_div5{width:105px;}
	    .ntd_div1{width:100px;}
	    .tab input,.inspersonDetail .selectIdcard{padding-left:5px !important;}
	    .tab input{padding-right:5px !important;}
	    .calendar-bounding-box .content-box .inner h4 select{font-size:15px;}
	    .calendar_birth{margin-left:5px;}
	    
        .des_tan{position: absolute;top: 2px;width: 15px;height: 15px;background: url(images/bj2.png) no-repeat;background-position: 0 -20px;cursor:pointer;}
		.deposit_detail_layer{
			display:none;
			border:1px solid #e0e0e0;
			position:absolute;
			left:299px;
			top:28px;
			padding:8px;
			width:370px;
			background:#fff;
			color:#313442;
			ox-shadow: 0 0 10px #e1e1e1;
		}
		.tri_rig{
			position:absolute;
			width:0;
			height:0;
			border-width:6px; 
			border-color:transparent transparent #e0e0e0 transparent; 
			border-style:dashed dashed solid dashed; 
			overflow:hidden; 
			top:-12px; 
			left:226px;
		}
		.tri_rig_b{
			position:absolute;
			width:0; 
			height:0; 
			border-width:6px; 
			border-color:transparent transparent #fffaf4 transparent; 
			border-style:dashed dashed solid dashed; 
			overflow:hidden; 
			top:-11px; 
			left:226px;
		}
	</style>

<body>
    
    <!--header-->
<script type="text/javascript" src="/Public/Home/js/index_searchlist_public.js"></script>
<script type="text/javascript" src="/Public/Home/js/list_header.js"></script> 
<style>	
.logo58{background:url(images/58logo.png) no-repeat;left:14px !important;top:16px !important;}
.logomayi{left:200px !important;}
.alert-box1{width:100%;height: 100%;z-index: 300000;position: absolute;display:none;line-height:40px;}
.surveYY1{background: #000;width:100%;height:100%;opacity: 0.7;position: fixed;top: 0px;left: 0px;}
.offmax_no{width:400px;height:186px;position:fixed;top:50%;margin-top:-93px;left:50%;margin-left:-200px;background-color:#fff;z-index:999;text-align:center;box-shadow:0px 0px 4px #ccc;border-radius:2px;} 
.offmax_no p{padding:0 20px;line-height:25px;}
.alert_tit1{border-bottom:1px solid #e0e0e0;font-size:18px;margin-bottom:20px;}
.close-alert1{cursor:pointer;width:50%;margin:20px auto;background-color:#22bb62;text-align:center;color:#fff;border-radius:2px;}
</style>
<input  type="hidden" name="ctx" id="ctx" value="" />

	<!--公共头部结束-->
	<div class="alert-box1">
    <div class="surveYY1"></div> 	
    <div class="offmax_no">
        <div class="alert_tit1">温馨提示</div>
        <p class="frozeninfo">对不起，房东账号被封禁</p>
        <p>如有疑问，请联系蚂蚁短租客服400-069-6060</p>
        <div class="close-alert1">我知道了</div>
    </div>
</div>
<input  type="hidden" name="subdomain" id="subdomain" value="" />
<input  type="hidden" name="mainsite" id="mainsite" value="" />
<input  type="hidden" name="ctx" id="ctx" value="" />
<input  type="hidden" name="ctx1" id="ctx1" value="//staticnew.mayi.com" />
<input  type="hidden" name="uid" id="uid" value="0" />
<input  type="hidden" name="loginurl" id="loginurl" value="none" />
<input type="hidden" name="head_userName" id="head_userName" value="">
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><html xmlns:wb="http://open.weibo.com/wb">
<head> 
<link rel="stylesheet" href="css/im.css" />    
</head> 
<body>   
</body>	 

</html>	<div style="" class="Online_btn Only_Online">
    	<span class="border-left"></span>
        <a href="#">
			<div style='display:none;'><a href='http://www.live800.com'  rel="nofollow" >live800Link.webpagechat</a></div><script language="javascript" src="js/staticbutton.js"></script><div style='display:none;'><a href='http://en.live800.com' rel="nofollow">live chat</a></div>
        </a>
    </div>	
     <!--header-->
    
    <!-- 蚂蚁统计所需 隐藏域 -->
    <!-- <?php echo dump($orders);?> -->
    <div class='content clearfloat'>
        <div class='fl content_left'>
            <div class='cnt'>
                
                <div class='cnt1 clearfloat'>
                    <!--预订信息-->
                    <h2>预订</h2>
                    <div class='fl'>
                        <dl class='cnt1_dl clearfloat'>
                            <dt class='fl'>预订日期</dt>
                            <dd class='fl roomer_cnt'><input type="text" placeholder="一个月" class='import fl' tabindex="3" id="tenantmobile" name="tenantmobile" value=""    autocomplete="off"  disabled/> 
                            </dd>
                        </dl>
                        <!--预订套数-->
                        <dl class='cnt1_dl clearfloat'>
                            <dt class='fl'>预订套数</dt>
                            <dd class='fl relave'><div class='dianj2 fl'><i id="roomNum">1</i></div>
                            </dd>
                            <b class='fl room_pice relave'>房费&nbsp;¥<?php echo $orders['amount'];?></strong>
                             
                            </b> 
                        </dl>

                        
                    
                        
                    </div>
                </div>
                
            </div>
            
            <form action="<?php echo U('Orders/successs');?>" method="post">  
            <div class='cnt1 cnt2 clearfloat'>
                <h2>联系人</h2>
                <div class="fl">
                    <dl class='cnt1_dl clearfloat'>
                        <dt class='fl'>姓名</dt>
                        <dd class='fl'><input type="text" placeholder="<?php echo $orders['nickname'];?>" tabindex="2" value="" id="tenantname" name="tenantname" maxlength="20" onkeypress="cannotInputNumber(event, this)" onblur="checkIntegerNumber(event,this)" onkeyup="checkIntegerNumber(event,this)" disabled/></dd>
                    </dl>
                    <dl class='cnt1_dl clearfloat'>
                        <dt class='fl'>手机号</dt>
                        <dd class='fl'>
                            <input type="text" placeholder="<?php echo $orders['phone'];?>" class='import fl' tabindex="3" id="tenantmobile" name="tenantmobile" value=""   autocomplete="off" disabled/>
                            
                            <span class='relave fl error'><i class='absot gou'></i><b>手机号错误，请重新尝试！</b></span>
                        </dd>
                    </dl>
                    
                </div>
            </div>
            <div class='cnt_foot' style="position:relative;">
                <!--温馨提示暂时无特色服务相关的费用 ，以及您选定房东提供的特色服务费用 -->

                <div class='order_sub_parent'>
                     <input type="hidden" name="gid" value="<?php echo $orders['gid'];?>">
                     <input type="hidden" name="uid" value="<?php echo $orders['uid'];?>">
                     <input type="hidden" name="photo" value="<?php echo $orders['photo'];?>">
                     <input type="hidden" name="amount" value="<?php echo $orders['amount'];?>">
                     <input type="hidden" name="persons" value="<?php echo $orders['persons'];?>"> 
                     <input type="hidden" name="address" value="<?php echo $orders['address'];?>">
                     <input type="hidden" name="phone" value="<?php echo $orders['phone'];?>"> 
                    <input type="submit" class='submit fl' value="提交订单">
                    <div class='App_download fl'> 
                        
                    </div>
                </div>
            </div>
            </form> 
            <!--优惠券-->


            <!--门票-->
            <!--特色服务-->
        

        </div>
        <!--右侧开始-->     
        <div class="fr content_right  pin" id="pin1">
            <div class='right_cnt'>
                <!--右侧房间开始-->
                <div class='room_intro relave clearfloat'>
                        <img class="fl" src="/Public/uploads/<?php echo $orders['photo'];?>"/>
                    <strong><?php echo $orders['address'];?></strong>
                    <!-- <span>上海市徐汇区其他街道岳阳路320号</span> -->
                </div>
                <div class='time_true'>
                    <!-- <p><span id="checkindayr"></span><span id="checkinOfWeekr"></span>&nbsp;至&nbsp;<span id="checkoutdayr"></span><span id="checkoutOfWeekr"></span>&nbsp;共<span id="totlenight3"></span>晚</p>  -->
                    <p><span id="roomNumr"></span>1套<span id="guestnum" ></span></p>
                </div>
                <!--右侧表格开始-->
                <table class='tab_fr'>
                    <tr class='room_tr'>
                        <td>
                            <div style='width:178px;'>房费</div>
                        </td>
                        <td class='relave bon tab_tex'>
                            <div style='width:130px;'>¥<?php echo $orders['amount'];?><i id="showtotalprice2"></i><!-- <span class='tab_tan tab_tan2'></span> -->
                                <!--房费弹出层-->
                                <div class='asote price_par price_par2'  style='display:none;'>
                                <p class="sanj sanj2 asote"></p>
                                <table class='price price_fixed'>
                                    <tr class='relave'>
                                        <th width=92><div style='width:92px;'>日期</div></th>
                                        <th width=126><div style='width:126px;'>单价</div></th>
                                        <th width=43><div style='width:43px;'>数量</div></th>
                                        <th width=75 class='bon'><div style='width:75px;' >小计</div></th>
                                    </tr>
                                </table>
                                <div class='tab_par'>
                                    <table class='price' id='righttable'>
                                        
                                            
                                        </table>
                                    </div>
                                    <div class='tfoot relave'> 
                                        <div class='fr_fu absot'>共<b id='totlenight2'></b>晚&nbsp;合计¥<b id='totleprice2'></b></div>
                                        <ul class='fl_fu' id='rlandlordrule'>
                                            <li>房东规定：</li>
                                            <li>·&nbsp;满7天9.0折，满30天8.0折 </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr id="tr_coupon">
                        <td>
                            <div style='width:174px;' ><span id="ctip">优惠券</span>&nbsp;</div>
                        </td>
                        <td class='relave bon tab_ipt'>
                            <div style='width:98px;margin-left:3px;'><i class='jianmq'></i>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style='width:174px;'>保险</div></td>
                        <td class='bon tab_tex'>
                            <div style='width:104px;' id="rightInsurancePrice">免费</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style='width:174px;'>门票</div>
                        </td>
                        <td class='relave bon tab_tex'>
                            <div style='width:104px;'>￥<i id="show_ticket_price">0</i></div>
                        </td>
                    </tr>
                </table>
                
                <!--支付方式-->
                <div class='on-line'>
                    <div class='online_1 relave clearfloat' >
                        <!-- <div class="clearfloat"><b class='color font'>订单总额</b>¥<i class='font2' id="actuallytotalprice"></i></div> -->
                        <div class="clearfloat"><b class='color font3'>线上支付</b><i style='float:left;line-height:35px;margin-right:4px;font-size:24px;color:#ff5d51;'>¥<?php echo $orders['amount'];?></i><i class='font4' id="onlinePayAmountShow" style='color:#ff5d51'></i><!-- <span class='asote dingw4'></span> --></div>
                        <div class='asote online_asote'>
                                    <p class="sanj sanj3 asote"></p>
                                    预付比例由房东设置，当前房间的预付比例为支付总房费的<i id="payRuleRate"></i>%
                                </div>
                    </div>
                    <p>(房租*预付比例-优惠券+保险+门票)</p>
                </div>
                
            </div>
            <div class='online_2'>
                REALHOME承诺到店无房赔付&nbsp;&nbsp;<!-- <a href="/supportplan/">查看详情</a> -->
            </div>
        </div>
    </div>
    </form>


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