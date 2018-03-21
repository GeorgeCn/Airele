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

    <!-- <?php echo dump($_SESSION);?> -->
    <div>
        <h2 style="text-align:center;line-height:80px;">个人中心</h2>
    </div><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-md-4 main-sidebar">
                <div class="view3">
                    <div class="card sidebar-nav">
                        <ul class="nav">
                            <li class="is-current">
                                <a href="<?php echo U('Personal/index');?>"><span class="icon icon-user nav-icon"></span><br>
                                <span class="nav-title">个人信息</span></a>
                            </li>

                            <li>
                                <a href="<?php echo U('Personal/avatar');?>"><span class="icon icon-eye nav-icon"></span><br>
                                <span class="nav-title">修改头像</span></a>
                            </li>

                            <li>
                                <a href="<?php echo U('Personal/security');?>"><span class="icon icon-lock2 nav-icon"></span><br>
                                <span class="nav-title">安全设置</span></a>
                            </li>

                            <li>
                                <a href="<?php echo U('Collect/index');?>"><span class="icon icon-th-stroke nav-icon"></span><br><span class="nav-title">我的收藏</span></a>
                            </li>

                            <li>
                                <a href="<?php echo U('PersonOrders/index');?>"><span class="icon icon-switch nav-icon"></span><br>
                                <span class="nav-title">我的订单</span></a>
                            </li>

                            <li>
                                <a href="<?php echo U('Comment/index');?>"><span class="icon icon-switch nav-icon"></span><br>
                                <span class="nav-title">我的评论</span></a>
                            </li>

                        </ul>
                    </div><!--END sidebar-nav -->
                </div>
            </div>
            <!-- *********************************************** -->
            <div class="col-sm-10 col-md-8 main-content">
                <div class="layer">
                    <div class="view5 is-loaded">
                        <div class="card profile-manager">
                            <div class="card-content">
                                <caption>个人信息</caption>
                        		<table class="table table-hover table-border">
                                    <tr>
                                        <th>用户名：</th>
                                        <td>
                                            <?php if($vo['nickname'] == ''): ?>Air·小冰
                                            <?php else: ?>
                                                <?php echo ($vo['nickname']); endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>手机号：</th>
                                        <td>
                                            <?php echo ($vo['tel']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>性别：</th>
                                        <td>
                                            <?php if($vo['sex'] == '0'): ?>女
                                            <?php elseif($vo['sex'] == '1'): ?>男
                                            <?php else: ?>保密<?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>头像：</th>
                                        <td>
                                            <?php if($vo['icon'] == false): ?><img src="/Public/img/Home/lufei.gif" style='width:150px;height:150px'>
                                            <?php else: ?>
                                                <img src="/Public/Uploads/<?php echo ($vo['icon']); ?>" style='width:150px;height:150px'><?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>邮箱：</th>
                                        <td>
                                            <?php echo ($vo['email']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>破壳日：</th>
                                        <td>
                                            <?php echo ($vo['birthday']); ?>
                                        </td>
                                    </tr>
                                </table>
                                <form action="<?php echo U('Personal/edit');?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo ($vo['id']); ?>">
                                    <button class="btn btn-primary btn-lg">编辑</button>
                                </form>
                            </div>
                        </div>
                    </div><!-- END view5-->
                    <!-- ********************公告栏************************** -->
                    <div class="table-responsive">
                        <table class="table table-condensed table-border">
                            <th colspan="2" class="col-sm-2">
                                公告
                            </th>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><tr>
                                <td><span class="msg"><?php echo ($vi['content']); ?></span></td>
                                <td><?php echo ($vi['time']); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </table>
                        <div  style="float:right;width:420px;height:300px;" >
                            <button onclick="alert('啊,关闭')" id='btn0' style="margin-right:-100px">关闭</button>
                            <img src="/Public/Uploads/<?php echo ($result[filename2]); ?>" frameborder="0" style="width:440px;height:220px;float:right"></img>
                        </div>

                    </div>
                </div><!-- END layer-->
            </div>
        </div><!--END row-->
    </div><!--END container-->



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