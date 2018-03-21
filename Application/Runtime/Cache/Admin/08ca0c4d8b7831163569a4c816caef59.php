<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>控制台 - 后台管理系统</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		<link href="/RealHome2/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/RealHome2/Public/assets/css/font-awesome.min.css" />
		<script src="/RealHome2/Public/js/jquery.min.js"></script>

		<!--[if IE 7]>
		  <link rel="stylesheet" href="/RealHome2/Public/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->
		<!--
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
		-->
		<!-- ace styles -->

		<link rel="stylesheet" href="/RealHome2/Public/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/RealHome2/Public/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/RealHome2/Public/assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/RealHome2/Public/assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="/RealHome2/Public/assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		
		
		
		
		
	<script src="/RealHome2/Public/js/jquery.min.js"></script>
	<script src="/RealHome2/Public/assets/js/ace-extra.min.js"></script>

		


		<!--[if lt IE 9]>
		<script src="/RealHome2/Public/assets/js/html5shiv.js"></script>
		<script src="/RealHome2/Public/assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							LAMP兄弟连 后台管理系统
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-ok"></i>
									还有4个任务完成
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">软件更新</span>
											<span class="pull-right">65%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:65%" class="progress-bar "></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">硬件更新</span>
											<span class="pull-right">35%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:35%" class="progress-bar progress-bar-danger"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">单元测试</span>
											<span class="pull-right">15%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:15%" class="progress-bar progress-bar-warning"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">错误修复</span>
											<span class="pull-right">90%</span>
										</div>

										<div class="progress progress-mini progress-striped active">
											<div style="width:90%" class="progress-bar progress-bar-success"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										查看任务详情
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-warning-sign"></i>
									8条通知
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												新闻评论
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary icon-user"></i>
										切换为编辑登录..
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success icon-shopping-cart"></i>
												新订单
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info icon-twitter"></i>
												粉丝
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										查看所有通知
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-envelope-alt"></i>
									5条消息
								</li>

								<li>
									<a href="#">
										<img src="/RealHome2/Public/assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Alex:</span>
												不知道写啥 ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>1分钟以前</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#">
										<img src="/RealHome2/Public/assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Susan:</span>
												不知道翻译...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>20分钟以前</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#">
										<img src="/RealHome2/Public/assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Bob:</span>
												到底是不是英文 ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>下午3:15</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="inbox.html">
										查看所有消息
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/RealHome2/Public/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small>
									<?php echo ($_SESSION['admin_user']['username']); ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										重置密码
									</a>
								</li>

								<li>
									<a href="<?php echo U('Profile/index');?>">
										<i class="icon-user"></i>
										个人资料
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo U('Public/logout');?>">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li <?php if((CONTROLLER_NAME) == "Index"): ?>class="active"<?php endif; ?>>
							<a href="<?php echo U('Index/index');?>">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 控制台 </span>
							</a>
						</li>

						<li> <!-- 地域管理 -->
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 地域管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Categorys"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Categorys') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Categorys/index');?>">
										<i class="icon-double-angle-right"></i>
										城市列表
									</a>
								</li>

								<li <?php if((CONTROLLER_NAME== 'Categorys') and (ACTION_NAME== 'treeLists')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Categorys/treeList');?>">
										<i class="icon-double-angle-right"></i>
										区域树列表
									</a>
								</li>

								<li <?php if((CONTROLLER_NAME== 'Categorys') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Categorys/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										区域添加
									</a>
								</li>
							</ul>
						</li>
						
						<!-- 房屋管理 -->
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 房屋管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Goods"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Goods') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Goods/index');?>">
										<i class="icon-double-angle-right"></i>
										房屋列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Goods') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Goods/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										房屋添加
									</a>
								</li>
							</ul>
						</li>

						<!--房源图片管理-->
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 房源图片管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "GoodsImg"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'GoodsImg') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('GoodsImg/index');?>">
										<i class="icon-double-angle-right"></i>
										图片列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'GoodsImg') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('GoodsImg/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										图片添加
									</a>
								</li>
							</ul>
						</li>
						<!--图片管理-->


						<li><!--首页管理-->
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 轮播图管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Header"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Header') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Header/index');?>">
										<i class="icon-double-angle-right"></i>
										图片详情
									</a>
								</li>


								<li <?php if((CONTROLLER_NAME== 'Header') and (ACTION_NAME== 'upload')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Header/upload');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										添加图片
									</a>
								</li>
							</ul>
						</li>


						
						<li><!--首页管理-->
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 热门城市管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "City"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'City') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('City/index');?>">
										<i class="icon-double-angle-right"></i>
										热门城市详情
									</a>
								</li>
							</ul>
						</li>											
							

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 后台用户管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "User"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'User') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('User/index');?>">
										<i class="icon-double-angle-right"></i>
										管理员列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'User') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('User/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										添加管理员
									</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="<?php echo U('Yonghu/index');?>" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 前台用户管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 订单管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Orders"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Orders') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Orders/index');?>">
										<i class="icon-double-angle-right"></i>
										订单列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Orders') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Orders/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										订单处理
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 角色管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Role"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Role') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Role/index');?>">
										<i class="icon-double-angle-right"></i>
										角色列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Role') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Role/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										角色添加
									</a>
								</li>
							</ul>
						</li>
						

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 节点管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Node"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Node') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Node/index');?>">
										<i class="icon-double-angle-right"></i>
										节点列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Node') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Node/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										节点添加
									</a>
								</li>
							</ul>
						</li>
					
					<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 投诉管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Complain"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Complain') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Complain/index');?>">
										<i class="icon-double-angle-right"></i>
										待处理投诉
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Complain') and (ACTION_NAME== 'finish')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Complain/finish');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										已处理投诉
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="<?php echo U('Comment/index');?>" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 评论 </span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 友情链接管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Blogroll"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Blogroll') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Blogroll/index');?>">
										<i class="icon-double-angle-right"></i>
										友情链接列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Blogroll') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Blogroll/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										友情链接添加
									</a>
								</li>

							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 公告管理 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu" <?php if((CONTROLLER_NAME) == "Notice"): ?>style="display:block"<?php endif; ?>>
								<li <?php if((CONTROLLER_NAME== 'Notice') and (ACTION_NAME== 'index')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Notice/index');?>">
										<i class="icon-double-angle-right"></i>
										公告列表
									</a>
								</li>
								<li <?php if((CONTROLLER_NAME== 'Notice') and (ACTION_NAME== 'add')): ?>class="active"<?php endif; ?>>
									<a href="<?php echo U('Notice/add');?>"  >
										<i class="icon-double-angle-right icon-plus"></i>
										公告添加
									</a>
								</li>

							</ul>
						</li>
					
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							
	<li>
		<i class="icon-home home-icon"></i>
		<a href="#">首页</a>
	</li>
	<li class="active">个人管理</li>

						</ul><!-- .breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
							
	<h1>
		个人中心
		<small>
			<i class="icon-double-angle-right"></i>
			 资料管理
		</small>
	</h1>

						</div><!-- /.page-header -->
							
	<div id="user-profile-3" class="user-profile row">
		<div class="col-sm-offset-1 col-sm-10">
			<div class="well well-sm">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				&nbsp;
				<div class="inline middle blue bigger-110"> 你的个人资料已完成70%</div>

				&nbsp; &nbsp; &nbsp;
				<div style="width:200px;" data-percent="70%" class="inline middle no-margin progress progress-striped active">
					<div class="progress-bar progress-bar-success" style="width:70%"></div>
				</div>
			</div><!-- /well -->

			<div class="space"></div>

			<form action="<?php echo U('Profile/infoAdd');?>" method="post" class="form-horizontal">
				<div class="tabbable">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a data-toggle="tab" href="#edit-basic">
								<i class="green icon-edit bigger-125"></i>
								基本信息设置
							</a>
						</li>

						<li>
							<a data-toggle="tab" href="#edit-settings">
								<i class="purple icon-cog bigger-125"></i>
								功能设置
							</a>
						</li>

						<li>
							<a data-toggle="tab" href="#edit-password">
								<i class="blue icon-key bigger-125"></i>
								密码重置
							</a>
						</li>
					</ul>

					<div class="tab-content profile-edit-tab-content">
						<div id="edit-basic" class="tab-pane in active">
							<h4 class="header blue bolder smaller">综合</h4>
							<input type="hidden" name="uid" value="<?php echo ($data["id"]); ?>">
							<div class="row">
								<div class="col-xs-12 col-sm-4">
									<input type="file" />
								</div>

								<div class="vspace-xs"></div>

								<div class="col-xs-12 col-sm-8">
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-username">昵称</label>

										<div class="col-sm-8">
											<input readonly class="col-xs-12 col-sm-10" type="text" id="form-field-username" placeholder="Username" value="<?php echo ($data["username"]); ?>" />
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-first">真实姓名</label>
										<div class="col-sm-8">
											<input readonly class="input-small" type="text" id="form-field-first" placeholder="名字" value="<?php echo ($data["name"]); ?>" />
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-username">身份</label>
										<div class="col-sm-8">
											<input readonly type="text" id="form-field-username" placeholder="贫农" value="<?php echo ($data["degree"]); ?>" />
										</div>
									</div>
								</div>
							</div>

							<hr />
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-date">出生日期</label>

								<div class="col-sm-9">
									<div class="input-medium">
										<div class="input-group">
											<input name="birthday" class="input-medium date-picker" id="form-field-date" type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
											value="<?php echo ($data["birthday"]); ?>" />
											<span class="input-group-addon">
												<i class="icon-calendar"></i>
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right">性别</label>

								<div class="col-sm-9">
								<if condition="$data.">
									<label class="inline">
										<input name="sex" type="radio" class="ace" <?php echo ($data['sex'] == 0?'checked':''); ?>/>
										<span class="lbl"> 男</span>
									</label>

									&nbsp; &nbsp; &nbsp;
									<label class="inline">
										<input name="sex" type="radio" class="ace" />
										<span class="lbl" <?php echo ($data['sex'] == 1?'checked':''); ?>> 女</span>
									</label>
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-comment">自我介绍</label>

								<div class="col-sm-9">
									<textarea name="desc" id="form-field-comment"><?php echo ($data["desc"]); ?></textarea>
								</div>
							</div>

							<div class="space"></div>
							<h4 class="header blue bolder smaller">联系方式</h4>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-email">邮箱</label>

								<div class="col-sm-9">
									<span class="input-icon input-icon-right">
										<input name="email" type="email" id="form-field-email" value="<?php echo ($data["email"]); ?>" />
										<i class="icon-envelope"></i>
									</span>
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-website">博客</label>

								<div class="col-sm-9">
									<span class="input-icon input-icon-right">
										<input name="web" type="url" id="form-field-website" value="<?php echo ($data["web"]); ?>" />
										<i class="icon-globe"></i>
									</span>
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-phone">电话</label>

								<div class="col-sm-9">
									<span class="input-icon input-icon-right">
										<input name="phone" class="input-medium input-mask-phone" type="text" id="form-field-phone" value="<?php echo ($data["phone"]); ?>"/>
										<i class="icon-book icon-flip-horizontal"></i>
									</span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-phone">手机</label>

								<div class="col-sm-9">
									<span class="input-icon input-icon-right">
										<input name="telephone" class="input-medium input-mask-telephone" type="text" id="form-field-phone" value="<?php echo ($data["telephone"]); ?>"/>
										<i class="icon-phone icon-flip-horizontal"></i>
									</span>
								</div>
							</div>

							<div class="space"></div>
							<h4 class="header blue bolder smaller">社交媒体</h4>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-facebook">Facebook</label>

								<div class="col-sm-9">
									<span class="input-icon">
										<input name="facebook" type="text"  id="form-field-facebook" placeholder="facebook_account" value="<?php echo ($data["facebook"]); ?>"/>
										<i class="icon-facebook blue"></i>
									</span>
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-weibo">微博</label>

								<div class="col-sm-9">
									<span class="input-icon">
										<input name="weibo" type="text" placeholder="weibo_account" value="<?php echo ($data["weibo"]); ?>" id="form-field-twitter" />
										<i class="icon-adjust light-blue"></i>
									</span>
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-gplus">微信</label>

								<div class="col-sm-9">
									<span class="input-icon">
										<input name="weixin" type="text" placeholder="weixin_account" value="<?php echo ($data["weixin"]); ?>" id="form-field-gplus" />
										<i class="icon-comments red"></i>
									</span>
								</div>
							</div>
						</div>

						<div id="edit-settings" class="tab-pane">
							<div class="space-10"></div>

							<div>
								<label class="inline">
									<input type="checkbox" name="form-field-checkbox" class="ace" />
									<span class="lbl">公开个人资料</span>
								</label>
							</div>

							<div class="space-8"></div>

							<div>
								<label class="inline">
									<input type="checkbox" name="form-field-checkbox" class="ace" />
									<span class="lbl">推送最新状态</span>
								</label>
							</div>

							<div class="space-8"></div>

							<div>
								<label class="inline">
									<input type="checkbox" name="form-field-checkbox" class="ace" />
									<span class="lbl">简讯记录</span>
								</label>

								<label class="inline">
									<span class="space-2 block"></span>

									持续
									<input type="text" class="input-mini" maxlength="3" />
									天
								</label>
							</div>
						</div>

						<div id="edit-password" class="tab-pane">
							<div class="space-10"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">手机号码</label>

								<div class="col-sm-9">
									<input type="text" name="myphone" id="form-field-pass1" />
								</div>
							</div>

							<div class="space-4"></div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-pass2"><a href="<?php echo U('Profile/reset');?>">发送短信</a></label>

								<div class="col-sm-9">
									<input type="text" name="mes" id="form-field-pass2" />
								</div>
							</div>

							<div class="space-4"></div>
	
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">重置密码</label>

								<div class="col-sm-9">
									<input type="password" name="psw" id="form-field-pass2" />
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="submit">
							<i class="icon-ok bigger-110"></i>
							保存
						</button>

						&nbsp; &nbsp;
						<button class="btn" type="reset">
							<i class="icon-undo bigger-110"></i>
							重置
						</button>
					</div>
				</div>
			</form>
		</div><!-- /span -->
	</div><!-- /user-profile -->
								

		<!-- basic scripts -->

		<!--[if !IE]> -->
	<script>
    //绑定事件
    $('label').click(function() {
    	//请求后台响应
        $.ajax({
            type:'get',
            url: "<?php echo U('Profile/reset');?>",
            success:function(data){
            },
            dataType:'json',
       		 })
        	return false;
   		 })
    </script>	
	<script src="/RealHome2/Public/Js/jquery.min.js"></script>

	<!-- <![endif]-->

	<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

	<!--[if !IE]> -->

	<script type="text/javascript">
		window.jQuery || document.write("<script src='/RealHome2/Public/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
	</script>

	<!-- <![endif]-->

	<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='/RealHome2/Public/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

	<script type="text/javascript">
		if("ontouchend" in document) document.write("<script src='/RealHome2/Public/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
	</script>
	<script src="/RealHome2/Public/assets/js/bootstrap.min.js"></script>
	<script src="/RealHome2/Public/assets/js/typeahead-bs2.min.js"></script>

	<!-- page specific plugin scripts -->

	<!--[if lte IE 8]>
	  <script src="/RealHome2/Public/assets/js/excanvas.min.js"></script>
	<![endif]-->

	<script src="/RealHome2/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="/RealHome2/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
	<script src="/RealHome2/Public/assets/js/jquery.gritter.min.js"></script>
	<script src="/RealHome2/Public/assets/js/bootbox.min.js"></script>
	<script src="/RealHome2/Public/assets/js/jquery.slimscroll.min.js"></script>
	<script src="/RealHome2/Public/assets/js/jquery.easy-pie-chart.min.js"></script>
	<script src="/RealHome2/Public/assets/js/jquery.hotkeys.min.js"></script>
	<script src="/RealHome2/Public/assets/js/bootstrap-wysiwyg.min.js"></script>
	<script src="/RealHome2/Public/assets/js/select2.min.js"></script>
	<script src="/RealHome2/Public/assets/js/date-time/bootstrap-datepicker.min.js"></script>
	<script src="/RealHome2/Public/assets/js/fuelux/fuelux.spinner.min.js"></script>
	<script src="/RealHome2/Public/assets/js/x-editable/bootstrap-editable.min.js"></script>
	<script src="/RealHome2/Public/assets/js/x-editable/ace-editable.min.js"></script>
	<script src="/RealHome2/Public/assets/js/jquery.maskedinput.min.js"></script>

	<!-- ace scripts -->

	<script src="/RealHome2/Public/assets/js/ace-elements.min.js"></script>
	<script src="/RealHome2/Public/assets/js/ace.min.js"></script>

	<!-- inline scripts related to this page -->

	<script type="text/javascript">
		jQuery(function($) {
		
			//editables on first profile page
			$.fn.editable.defaults.mode = 'inline';
			$.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
		    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="icon-ok icon-white"></i></button>'+
		                                '<button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>';    
			
			//editables 
		    $('#username').editable({
				type: 'text',
				name: 'username'
		    });
		
		
			var countries = [];
		    $.each({ "CA": "Canada", "IN": "India", "NL": "Netherlands", "TR": "Turkey", "US": "United States"}, function(k, v) {
		        countries.push({id: k, text: v});
		    });
		
			var cities = [];
			cities["CA"] = [];
			$.each(["Toronto", "Ottawa", "Calgary", "Vancouver"] , function(k, v){
				cities["CA"].push({id: v, text: v});
			});
			cities["IN"] = [];
			$.each(["Delhi", "Mumbai", "Bangalore"] , function(k, v){
				cities["IN"].push({id: v, text: v});
			});
			cities["NL"] = [];
			$.each(["Amsterdam", "Rotterdam", "The Hague"] , function(k, v){
				cities["NL"].push({id: v, text: v});
			});
			cities["TR"] = [];
			$.each(["Ankara", "Istanbul", "Izmir"] , function(k, v){
				cities["TR"].push({id: v, text: v});
			});
			cities["US"] = [];
			$.each(["New York", "Miami", "Los Angeles", "Chicago", "Wysconsin"] , function(k, v){
				cities["US"].push({id: v, text: v});
			});
			
			var currentValue = "NL";
		    $('#country').editable({
				type: 'select2',
				value : 'NL',
		        source: countries,
				success: function(response, newValue) {
					if(currentValue == newValue) return;
					currentValue = newValue;
					
					var new_source = (!newValue || newValue == "") ? [] : cities[newValue];
					
					//the destroy method is causing errors in x-editable v1.4.6
					//it worked fine in v1.4.5
					/**			
					$('#city').editable('destroy').editable({
						type: 'select2',
						source: new_source
					}).editable('setValue', null);
					*/
					
					//so we remove it altogether and create a new element
					var city = $('#city').removeAttr('id').get(0);
					$(city).clone().attr('id', 'city').text('Select City').editable({
						type: 'select2',
						value : null,
						source: new_source
					}).insertAfter(city);//insert it after previous instance
					$(city).remove();//remove previous instance
					
				}
		    });
		
			$('#city').editable({
				type: 'select2',
				value : 'Amsterdam',
		        source: cities[currentValue]
		    });
		
		
		
			$('#signup').editable({
				type: 'date',
				format: 'yyyy-mm-dd',
				viewformat: 'dd/mm/yyyy',
				datepicker: {
					weekStart: 1
				}
			});
		
		    $('#age').editable({
		        type: 'spinner',
				name : 'age',
				spinner : {
					min : 16, max:99, step:1
				}
			});
			
			//var $range = document.createElement("INPUT");
			//$range.type = 'range';
		    $('#login').editable({
		        type: 'slider',//$range.type == 'range' ? 'range' : 'slider',
				name : 'login',
				slider : {
					min : 1, max:50, width:100
				},
				success: function(response, newValue) {
					if(parseInt(newValue) == 1)
						$(this).html(newValue + " hour ago");
					else $(this).html(newValue + " hours ago");
				}
			});
		
			$('#about').editable({
				mode: 'inline',
		        type: 'wysiwyg',
				name : 'about',
				wysiwyg : {
					//css : {'max-width':'300px'}
				},
				success: function(response, newValue) {
				}
			});
			
			
			
			// *** editable avatar *** //
			try {//ie8 throws some harmless exception, so let's catch it
		
				//it seems that editable plugin calls appendChild, and as Image doesn't have it, it causes errors on IE at unpredicted points
				//so let's have a fake appendChild for it!
				if( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ) Image.prototype.appendChild = function(el){}
		
				var last_gritter
				$('#avatar').editable({
					type: 'image',
					name: 'avatar',
					value: null,
					image: {
						//specify ace file input plugin's options here
						btn_choose: 'Change Avatar',
						droppable: true,
						/**
						//this will override the default before_change that only accepts image files
						before_change: function(files, dropped) {
							return true;
						},
						*/
		
						//and a few extra ones here
						name: 'avatar',//put the field name here as well, will be used inside the custom plugin
						max_size: 110000,//~100Kb
						on_error : function(code) {//on_error function will be called when the selected file has a problem
							if(last_gritter) $.gritter.remove(last_gritter);
							if(code == 1) {//file format error
								last_gritter = $.gritter.add({
									title: 'File is not an image!',
									text: 'Please choose a jpg|gif|png image!',
									class_name: 'gritter-error gritter-center'
								});
							} else if(code == 2) {//file size rror
								last_gritter = $.gritter.add({
									title: 'File too big!',
									text: 'Image size should not exceed 100Kb!',
									class_name: 'gritter-error gritter-center'
								});
							}
							else {//other error
							}
						},
						on_success : function() {
							$.gritter.removeAll();
						}
					},
				    url: function(params) {
						// ***UPDATE AVATAR HERE*** //
						//You can replace the contents of this function with examples/profile-avatar-update.js for actual upload
		
		
						var deferred = new $.Deferred
		
						//if value is empty, means no valid files were selected
						//but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
						//so we return just here to prevent problems
						var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
						if(!value || value.length == 0) {
							deferred.resolve();
							return deferred.promise();
						}
		
		
						//dummy upload
						setTimeout(function(){
							if("FileReader" in window) {
								//for browsers that have a thumbnail of selected image
								var thumb = $('#avatar').next().find('img').data('thumb');
								if(thumb) $('#avatar').get(0).src = thumb;
							}
							
							deferred.resolve({'status':'OK'});
		
							if(last_gritter) $.gritter.remove(last_gritter);
							last_gritter = $.gritter.add({
								title: 'Avatar Updated!',
								text: 'Uploading to server can be easily implemented. A working example is included with the template.',
								class_name: 'gritter-info gritter-center'
							});
							
						 } , parseInt(Math.random() * 800 + 800))
		
						return deferred.promise();
					},
					
					success: function(response, newValue) {
					}
				})
			}catch(e) {}
			
			
		
			//another option is using modals
			$('#avatar2').on('click', function(){
				var modal = 
				'<div class="modal hide fade">\
					<div class="modal-header">\
						<button type="button" class="close" data-dismiss="modal">&times;</button>\
						<h4 class="blue">Change Avatar</h4>\
					</div>\
					\
					<form class="no-margin">\
					<div class="modal-body">\
						<div class="space-4"></div>\
						<div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
					</div>\
					\
					<div class="modal-footer center">\
						<button type="submit" class="btn btn-small btn-success"><i class="icon-ok"></i> Submit</button>\
						<button type="button" class="btn btn-small" data-dismiss="modal"><i class="icon-remove"></i> Cancel</button>\
					</div>\
					</form>\
				</div>';
				
				
				var modal = $(modal);
				modal.modal("show").on("hidden", function(){
					modal.remove();
				});
		
				var working = false;
		
				var form = modal.find('form:eq(0)');
				var file = form.find('input[type=file]').eq(0);
				file.ace_file_input({
					style:'well',
					btn_choose:'Click to choose new avatar',
					btn_change:null,
					no_icon:'icon-picture',
					thumbnail:'small',
					before_remove: function() {
						//don't remove/reset files while being uploaded
						return !working;
					},
					before_change: function(files, dropped) {
						var file = files[0];
						if(typeof file === "string") {
							//file is just a file name here (in browsers that don't support FileReader API)
							if(! (/\.(jpe?g|png|gif)$/i).test(file) ) return false;
						}
						else {//file is a File object
							var type = $.trim(file.type);
							if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif)$/i).test(type) )
									|| ( type.length == 0 && ! (/\.(jpe?g|png|gif)$/i).test(file.name) )//for android default browser!
								) return false;
		
							if( file.size > 110000 ) {//~100Kb
								return false;
							}
						}
		
						return true;
					}
				});
		
				form.on('submit', function(){
					if(!file.data('ace_input_files')) return false;
					
					file.ace_file_input('disable');
					form.find('button').attr('disabled', 'disabled');
					form.find('.modal-body').append("<div class='center'><i class='icon-spinner icon-spin bigger-150 orange'></i></div>");
					
					var deferred = new $.Deferred;
					working = true;
					deferred.done(function() {
						form.find('button').removeAttr('disabled');
						form.find('input[type=file]').ace_file_input('enable');
						form.find('.modal-body > :last-child').remove();
						
						modal.modal("hide");
		
						var thumb = file.next().find('img').data('thumb');
						if(thumb) $('#avatar2').get(0).src = thumb;
		
						working = false;
					});
					
					
					setTimeout(function(){
						deferred.resolve();
					} , parseInt(Math.random() * 800 + 800));
		
					return false;
				});
						
			});
		
			
		
			//////////////////////////////
			$('#profile-feed-1').slimScroll({
			height: '250px',
			alwaysVisible : true
			});
		
			$('.profile-social-links > a').tooltip();
		
			$('.easy-pie-chart.percentage').each(function(){
			var barColor = $(this).data('color') || '#555';
			var trackColor = '#E2E2E2';
			var size = parseInt($(this).data('size')) || 72;
			$(this).easyPieChart({
				barColor: barColor,
				trackColor: trackColor,
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(size/10),
				animate:false,
				size: size
			}).css('color', barColor);
			});
		  
			///////////////////////////////////////////
		
			//show the user info on right or left depending on its position
			$('#user-profile-2 .memberdiv').on('mouseenter', function(){
				var $this = $(this);
				var $parent = $this.closest('.tab-pane');
		
				var off1 = $parent.offset();
				var w1 = $parent.width();
		
				var off2 = $this.offset();
				var w2 = $this.width();
		
				var place = 'left';
				if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';
				
				$this.find('.popover').removeClass('right left').addClass(place);
			}).on('click', function() {
				return false;
			});
		
		
			///////////////////////////////////////////
			$('#user-profile-3')
			.find('input[type=file]').ace_file_input({
				style:'well',
				btn_choose:'Change avatar',
				btn_change:null,
				no_icon:'icon-picture',
				thumbnail:'large',
				droppable:true,
				before_change: function(files, dropped) {
					var file = files[0];
					if(typeof file === "string") {//files is just a file name here (in browsers that don't support FileReader API)
						if(! (/\.(jpe?g|png|gif)$/i).test(file) ) return false;
					}
					else {//file is a File object
						var type = $.trim(file.type);
						if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif)$/i).test(type) )
								|| ( type.length == 0 && ! (/\.(jpe?g|png|gif)$/i).test(file.name) )//for android default browser!
							) return false;
		
						if( file.size > 110000 ) {//~100Kb
							return false;
						}
					}
		
					return true;
				}
			})
			.end().find('button[type=reset]').on(ace.click_event, function(){
				$('#user-profile-3 input[type=file]').ace_file_input('reset_input');
			})
			.end().find('.date-picker').datepicker().next().on(ace.click_event, function(){
				$(this).prev().focus();
			})
			$('.input-mask-phone').mask('(999) 999-9999');
			$('.input-mask-telephone').mask('(999) 9999-9999');
		
		
		
			////////////////////
			//change profile
			$('[data-toggle="buttons"] .btn').on('click', function(e){
				var target = $(this).find('input[type=radio]');
				var which = parseInt(target.val());
				$('.user-profile').parent().addClass('hide');
				$('#user-profile-'+which).parent().removeClass('hide');
			});
		});
	</script>

					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; 选择皮肤</span>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl">切换到左边</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">
								切换窄屏
								<b></b>
							</label>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<!--
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		-->
		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='/RealHome2/Public/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/RealHome2/Public/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="/RealHome2/Public/assets/js/bootstrap.min.js"></script>
		<script src="/RealHome2/Public/assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="/RealHome2/Public/assets/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="/RealHome2/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/RealHome2/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="/RealHome2/Public/assets/js/jquery.slimscroll.min.js"></script>
		<script src="/RealHome2/Public/assets/js/jquery.easy-pie-chart.min.js"></script>
		<script src="/RealHome2/Public/assets/js/jquery.sparkline.min.js"></script>
		<script src="/RealHome2/Public/assets/js/flot/jquery.flot.min.js"></script>
		<script src="/RealHome2/Public/assets/js/flot/jquery.flot.pie.min.js"></script>
		<script src="/RealHome2/Public/assets/js/flot/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->

		<script src="/RealHome2/Public/assets/js/ace-elements.min.js"></script>
		<script src="/RealHome2/Public/assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
				});
			
			
			
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
			
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').slimScroll({
					height: '300px'
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
				
			
			})
		</script>
	<div style="display:none">
		<!--
		<script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script>
		-->
		</div>
</body>
</html>