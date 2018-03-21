<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>视频管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
   	<link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/video-js.min.css">
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
				<h2>视频查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('VODClient/VODClientList');?>" method="get">
						<input type="hidden" name="no" value="26">
						<input type="hidden" name="leftno" value="181">
					<table class="table_one">
						<tr>
							<td class="td_title">上传时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
							</td>
							<td class="td_title">上传人：</td>
							<td class="td_main"><input type="text" name="createMan" value="<?php echo I('get.createMan');?>"></td>
							<td class="td_title">房间编号：</td>
							<td class="td_main"><input type="text" name="roomNO" value="<?php echo I('get.roomNO');?>"></td>
						</tr>
					</table>
					<p class="head_p"><button type="submit" class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>视频列表</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房间编号</th>
								<th>房间视频</th>
								<th>视频截图</th>
								<th>上传时间</th>
								<th>上传人</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						  	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo ($i); ?></td>
									<td><?php echo ($vo['room_no']); ?></td>
									<td><video class="video-js vjs-default-skin" controls    preload="auto"width="300"height="130"   data-setup="{}"><source src="<?php echo ($vo['video_url']); ?>" type="video/mp4"></video></td>
									<td><img style="width:200px;height:130px" src="<?php echo ($vo['video_myimg_url']); ?>" alt="秘密"></td>
									<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
									<td><?php echo ($vo['create_man']); ?></td>
									<td><a href="javascript:;" class="btn_a" onclick="startDeleteHousevideo('<?php echo ($vo["room_id"]); ?>','<?php echo ($vo["video_url"]); ?>','<?php echo ($vo["video_img_url"]); ?>','<?php echo ($vo["video_h5url"]); ?>',this)">删除</a></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页10条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="/hizhu/Public/js/jquery.js"></script>
	<script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/plug/video.min.js"></script>
    <script src="/hizhu/Public/plug/js-sdk/aliyun-oss-sdk.min.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"}); 
	</script>
	<script type="text/javascript">
    function startDeleteHousevideo (roomID,url,imgUrl,h5url,obj) {
		if(confirm('确定永久删除视频吗？')) {
		    var client = new OSS.Wrapper({
				region: "oss-cn-hangzhou",
				accessKeyId: "LTAIP4XBZGMB2Rs8",
				accessKeySecret: "kxsvFE5VikpwMN1odb4oUurYKcaQWq",
				bucket: "vodappout"
		    });			
			var result = client.delete(url.substring(47));
			console.log(result);	
      		var result2 = client.delete(imgUrl.substring(47));
      		console.log(result2);
    		var result3 = client.delete(h5url.substring(47));
    		console.log(result3);
			$.ajax({
	            type:"post",
	            url: "<?php echo U('VODClient/videoDeleteInfoForever');?>",
	            data:{"room_id":roomID},
	            success:function(data) {
	            	$(obj).parent().parent().remove();
	            }	
		    })
		}
	}
  	</script>
</body>
</html>