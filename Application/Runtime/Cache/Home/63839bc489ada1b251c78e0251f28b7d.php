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

<div class=" banner-buying">
	<div class=" container">
	<h3><span>Lor</span>em</h3> 
	<!---->
	<div class="menu-right">
		 <ul class="menu">
			<li class="item1"><a href="#"> Menu<i class="glyphicon glyphicon-menu-down"> </i> </a>
			<ul class="cute">
				<li class="subitem1"><a href="buy.html">Buy </a></li>
				<li class="subitem2"><a href="buy.html">Rent </a></li>
				<li class="subitem3"><a href="buy.html">Hostels </a></li>
				<li class="subitem1"><a href="buy.html">Resale</a></li>
				<li class="subitem2"><a href="loan.html">Home Loan</a></li>
				<li class="subitem3"><a href="buy.html">Apartment </a></li>
				<li class="subitem3"><a href="dealers.html">Dealers</a></li>
			</ul>
		</li>
		</ul>
	</div>
	<!-- <?php echo var_dump($list);?> -->

	<div class="clearfix"> </div>
		<!--initiate accordion-->
		<script type="text/javascript">
			$(function() {
			    var menu_ul = $('.menu > li > ul'),
			           menu_a  = $('.menu > li > a');
			    menu_ul.hide();
			    menu_a.click(function(e) {
			        e.preventDefault();
			        if(!$(this).hasClass('active')) {
			            menu_a.removeClass('active');
			            menu_ul.filter(':visible').slideUp('normal');
			            $(this).addClass('active').next().stop(true,true).slideDown('normal');
			        } else {
			            $(this).removeClass('active');
			            $(this).next().stop(true,true).slideUp('normal');
			        }
			    });
			
			});
		</script>
      		
	</div>
</div>
<!--//header-->
<!---->
<!-- <div class="single">
	<div class="container">
	
		<div class="single-buy">
			<div class="col-sm-3 check-top-single">
				<div class="single-bottom">
					<h4>Property Type</h4>
						<ul>
							<li>
								<input type="checkbox"  id="brand" value="">
								<label for="brand"><span></span> Duplex</label>
							</li>
							<li>
								<input type="checkbox"  id="brand1" value="">
								<label for="brand1"><span></span> Apartment</label>
							</li>
							<li>
								<input type="checkbox"  id="brand2" value="">
								<label for="brand2"><span></span>Villa</label>
							</li>
							<li>
								<input type="checkbox"  id="brand3" value="">
								<label for="brand3"><span></span> Pent House</label>
							</li>
							
						</ul>
					</div>
			</div>
			<div class="col-sm-3 check-top-single">
				<div class="single-bottom">
					<h4>BHK</h4>
						<ul>
							<li>
								<input type="checkbox"  id="brand5" value="">
								<label for="brand5"><span></span> 1 BHK</label>
							</li>
							<li>
								<input type="checkbox"  id="brand6" value="">
								<label for="brand6"><span></span> 2 BHK</label>
							</li>
							<li>
								<input type="checkbox"  id="brand7" value="">
								<label for="brand7"><span></span>3 BHK</label>
							</li>
							<li>
								<input type="checkbox"  id="brand8" value="">
								<label for="brand8"><span></span> 3+ BHK</label>
							</li>
							
						</ul>
					</div>
			</div>
			<div class="col-sm-3 check-top-single">
				<div class="single-bottom">
					<h4>Amenities</h4>
						<ul>
							<li>
								<input type="checkbox"  id="brand9" value="">
								<label for="brand9"><span></span>Lift </label>
							</li>
							<li>
								<input type="checkbox"  id="brand10" value="">
								<label for="brand10"><span></span>GYM </label>
							</li>
							<li>
								<input type="checkbox"  id="brand11" value="">
								<label for="brand11"><span></span>Swimming Pool</label>
							</li>
							<li>
								<input type="checkbox"  id="brand12" value="">
								<label for="brand12"><span></span> Gas Pipeline</label>
							</li>
							
						</ul>
					</div>
			</div>
			<div class="col-sm-3 check-top-single">
				<div class="single-bottom">
					<h4>Property Status</h4>
						<ul>
							<li>
								<input type="checkbox"  id="brand13" value="">
								<label for="brand13"><span></span> Under Construction</label>
							</li>
							<li>
								<input type="checkbox"  id="brand14" value="">
								<label for="brand14"><span></span> Ready to Move</label>
							</li>
							
						</ul>
					</div>
			</div>
			<div class="clearfix"> </div>
	</div>
</div> -->

<!---->
<div class="container">
	
	<!--price-->
	<form action="<?php echo U('Search/search');?>" method="post">
	<div class="price">
		<div class="price-grid">
			<div class="col-sm-3 price-top">
				<h4>province</h4>
				<select class="pro in-drop" name="province">
				</select>
			</div>
			<div class="col-sm-3 price-top">
				<h4>city</h4>
				<select class="city in-drop" name="city">
				</select>
			</div>
			<div class="col-sm-4 price-top">
				<h4>Rooms</h4>
				<select class="in-drop" name="bed">
					<!-- <option>No. of Bedrooms</option> -->
					<option value="1">1 居</option>
					<option value="2">2 居</option>
					<option value="3">3 居</option>
					<!-- <option value="4">4 居</option> -->
					<!-- <option value="">4+ 居</option> -->
				</select>
			</div>
			<div class="col-sm-2 price-top">
				<h4 style='color:#F7F7F7'>立即搜索</h4>
				<input type="submit" class="hvr-sweep-to-right"  value="立即搜索">
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	</form>

				  <script>
			    //获取省份信息
			    $.ajax({
			        type:'get',
			        url:"<?php echo U('Search/address');?>",
			        success:function(data){
			            //先清空原先的数据
			            //遍历省份数据
			            console.log(data);
			            for (var i = 0; i < data.length; i++) {
			                $('<option value="'+data[i].id+'">'+data[i].name+'</option>').appendTo('.pro');
			            }
			        },
			        dataType:'json',
			        async:false,//同步!!!!!!
			    })


			    //绑定事件
			    $('.pro').change(function(){
			        //获取当前的vale值
			        var pid = $(this).val();
			        
			        // 一触发change事件,就清空后面所有的数据
			        // $(this).next('select').show().empty();
			        	$('.city').show().empty();
			        // 保留$(this)变量
			        var _this = $(this);

			        // 请求下一级数据
			        $.ajax({
			            type:'get',
			            url: "<?php echo U('Search/address');?>",
			            data:"pid="+pid,
			            success:function(data){
			                // 如果下一级没数据,就隐藏后面的下拉框
			                if (!data) {
			                    _this.nextAll('select').hide();
			                    return;

			                };
			                // console.log(data);
			                // console.log($(this).constructor);
			                // 填充下一级的数据
			                // console.log(data);
			                for (var i = 0; i < data.length; i++) {
			                	// console.log(_this.next('select'));
			                    $('<option value="'+data[i].id+'">'+data[i].name+'</option>').appendTo($('.city'));
			                }
			                //自动触发后面的select的change事件
			                _this.next('select').trigger('change');
			            },
			            dataType:'json',
			        
			    	})
				})

			    //自动加载省份的change事件
			    $('.pro').trigger('change');

			    </script>
	<!---->

</div>

<div class="container">
	
	<div class="buy-single">
		
		<div class="box-sin">

		<h4><?php echo ($title); ?></h4>
		
		<h3>房源基本信息</h3>
			<div class="col-md-9 single-box">
				<div class="box-col">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class=" col-sm-7 left-side ">
						<a href="single.html"> <img class="img-responsive" src="/Public/Uploads/<?php echo ($v["filename3"]); ?>" alt=""></a>
					</div>				
					<div class="  col-sm-5 middle-side">
					     <h4><?php echo ($v["name"]); ?></h4>
					     <p><span class="bath5">卧室 </span>: <span class="two"><?php echo ($v["beds"]); ?></span></p>
					     <p>  <span class="bath5">浴室 </span>: <span class="two"><?php echo ($v["toilets"]); ?></span></p>
					     <p><span class="bath3">房屋类型</span>: <span class="two"><?php echo ($v["type"]); ?></span></p>
					     <p><span class="bath5">地址</span>:<span class="two"><?php echo ($v["address"]); ?></span></p>
						 <p><span class="bath3">出租时间</span> : <span class="two"><?php echo ($v["months"]); ?></span></p>
						 <p><span class="bath5">价格</span>:<span class="two">¥<?php echo ($v["price"]); ?></span></p>				 
						<div class="   right-side">
							  <a href="<?php echo U('Display/index',array('id'=>$v['id']));?>" class="hvr-sweep-to-right more" >查看详情</a>         
						 </div>
					 </div>
				 <div class="clearfix"> </div><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
		
				<!-- <div class="box-col">
				     <div class=" col-sm-7 left-side ">
						 <a href="single.html"><img class="img-responsive" src="images/sb1.jpg" alt=""></a>
					</div>				
					<div class="  col-sm-5 middle-side">
					     <h4>Possession: Immediate</h4>
					     <p><span class="bath">Bed </span>: <span class="two">2 BHK</span></p>
					     <p>  <span class="bath1">Baths </span>: <span class="two">2</span></p>
					     <p><span class="bath2">Built-up Area</span>: <span class="two">100 Sq.Yrds</span></p>
					     <p><span class="bath3">Plot Area </span>:<span class="two"> 150 Sq.Yrds</span></p>
						 <p><span class="bath4">Age of property</span> : <span class="two">4 - 10 Years</span></p>
						 <p><span class="bath5">Price </span>:<span class="two"> 30-40 Lacs</span></p>				 
						<div class="   right-side">
							 <a href="contact.html" class="hvr-sweep-to-right more" >Contact Builder</a>     
						</div>
					 </div>
				 <div class="clearfix"> </div>
				</div> -->
				<!-- <div class="box-col">
				     <div class=" col-sm-7 left-side ">
						<a href="single.html"> <img class="img-responsive" src="images/sb2.jpg" alt=""></a>
					</div>				
					<div class="  col-sm-5 middle-side">
					     <h4>Possession: Immediate</h4>
					     <p><span class="bath">Bed </span>: <span class="two">2 BHK</span></p>
					     <p>  <span class="bath1">Baths </span>: <span class="two">2</span></p>
					     <p><span class="bath2">Built-up Area</span>: <span class="two">100 Sq.Yrds</span></p>
					     <p><span class="bath3">Plot Area </span>:<span class="two"> 150 Sq.Yrds</span></p>
						 <p><span class="bath4">Age of property</span> : <span class="two">4 - 10 Years</span></p>
						  <p><span class="bath5">Price </span>:<span class="two"> 30-40 Lacs</span></p>				 			 
						<div class="   right-side">
							 <a href="contact.html" class="hvr-sweep-to-right more" >Contact Builder</a>     
						 </div>
					 </div>
				 <div class="clearfix"> </div>
				</div>
				<div class="box-col">
				     <div class=" col-sm-7 left-side ">
						<a href="single.html"> <img class="img-responsive" src="images/sb3.jpg" alt=""></a>
					</div>				
					<div class="  col-sm-5 middle-side">
					     <h4>Possession: Immediate</h4>
					     <p><span class="bath">Bed </span>: <span class="two">2 BHK</span></p>
					     <p>  <span class="bath1">Baths </span>: <span class="two">2</span></p>
					     <p><;span class="bath2">Built-up Area</span>: <span class="two">100 Sq.Yrds</span></p>
					     <p><span class="bath3">Plot Area </span>:<span class="two"> 150 Sq.Yrds</span></p>
						 <p><span class="bath4">Age of property</span> : <span class="two">4 - 10 Years</span></p>
						 <p><span class="bath5">Price </span>:<span class="two"> 30-40 Lacs</span></p>				 			 
						<div class="   right-side">
							 <a href="contact.html" class="hvr-sweep-to-right more" >Contact Builder</a>     
						 </div>
					 </div>
				 <div class="clearfix"> </div>
				</div>
				<div class="box-col">
				     <div class=" col-sm-7 left-side ">
						<a href="single.html"> <img class="img-responsive" src="images/sb4.jpg" alt=""></a>
					</div>				
					<div class="  col-sm-5 middle-side">
					     <h4>Possession: Immediate</h4>
					     <p><span class="bath">Bed </span>: <span class="two">2 BHK</span></p>
					     <p>  <span class="bath1">Baths </span>: <span class="two">2</span></p>
					     <p><span class="bath2">Built-up Area</span>: <span class="two">100 Sq.Yrds</span></p>
					     <p><span class="bath3">Plot Area </span>:<span class="two"> 150 Sq.Yrds</span></p>
						 <p><span class="bath4">Age of property</span> : <span class="two">4 - 10 Years</span></p>
						  <p><span class="bath5">Price </span>:<span class="two"> 30-40 Lacs</span></p>				 				 
						<div class="   right-side">
							 <a href="contact.html" class="hvr-sweep-to-right more" >Contact Builder</a>          
						 </div>
					 </div>
				 <div class="clearfix"> </div>
				</div> -->
				<!-- <div class="box-col">
				     <div class=" col-sm-7 left-side ">
						 <a href="single.html"><img class="img-responsive" src="images/sb5.jpg" alt=""></a>
					</div>				
					<div class="  col-sm-5 middle-side">
					     <h4>Possession: Immediate</h4>
					     <p><span class="bath">Bed </span>: <span class="two">2 BHK</span></p>
					     <p>  <span class="bath1">Baths </span>: <span class="two">2</span></p>
					     <p><span class="bath2">Built-up Area</span>: <span class="two">100 Sq.Yrds</span></p>
					     <p><span class="bath3">Plot Area </span>:<span class="two"> 150 Sq.Yrds</span></p>
						 <p><span class="bath4">Age of property</span> : <span class="two">4 - 10 Years</span></p>
						 <p><span class="bath5">Price </span>:<span class="two"> 30-40 Lacs</span></p>				 			 
						<div class="   right-side">
							 <a href="contact.html" class="hvr-sweep-to-right more" >Contact Builder</a>     
						 </div>
					 </div>
				 <div class="clearfix"> </div>
				</div> -->
			</div>
		</div>
		<div class="col-md-3 map-single-bottom">
			<div class="map-single">
						<!-- <iframe src="https://www.baidu.com/maps/embed?pb=!1m18!1m12!1m3!1d37494223.23909492!2d103!3d55!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x453c569a896724fb%3A0x1409fdf86611f613!2sRussia!5e0!3m2!1sen!2sin!4v1415776049771"></iframe> -->
			</div>
			<div class="single-box-right">
		     	<h4>Featured Communities</h4>
				<div class="single-box-img">
					<div class="box-img">
						<a href="<?php echo U('Display/index',array('id'=>5));?>"><img class="img-responsive" src="/Public/Uploads/<?php echo ($file[0]); ?>" alt=""></a>
					</div>
					<div class="box-text">
						<p><a href="single.html">Lorem ipsum dolor sit amet</a></p>
						<a href="single.html" class="in-box">More Info</a>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="single-box-img">
					<div class="box-img">
						<a href="<?php echo U('Display/index',array('id'=>6));?>"><img class="img-responsive" src="/Public/Uploads/<?php echo ($file[1]); ?>" alt=""></a>
					</div>
					<div class="box-text">
						<p><a href="single.html">Lorem ipsum dolor sit amet</a></p>
						<a href="single.html" class="in-box">More Info</a>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="single-box-img">
					<div class="box-img">
						<a href="<?php echo U('Display/index',array('id'=>1));?>"><img class="img-responsive" src="/Public/Uploads/<?php echo ($file[2]); ?>" alt=""></a>
					</div>
					<div class="box-text">
						<p><a href="single.html">Lorem ipsum dolor sit amet</a></p>
						<a href="single.html" class="in-box">More Info</a>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="single-box-img">
					<div class="box-img">
						<a href="<?php echo U('Display/index',array('id'=>7));?>"><img class="img-responsive" src="/Public/Uploads/<?php echo ($file[3]); ?>" alt=""></a>
					</div>
					<div class="box-text">
						<p><a href="single.html">Lorem ipsum dolor sit amet</a></p>
						<a href="single.html" class="in-box">More Info</a>
					</div>
					<div class="clearfix"> </div>
				</div>
		 </div>
	  </div>
		<div class="clearfix"> </div>
		<div class="nav-page">
		<nav>
      <ul class="pagination">
        <!-- <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> -->
<!--         <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li> -->
        <li><?php echo ($page); ?></li>
        <!-- <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> -->
     </ul>
   </nav>
   </div>
		</div>
		
	</div>
	
</div>


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