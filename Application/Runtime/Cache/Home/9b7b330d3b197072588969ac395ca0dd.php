<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>商家优惠劵列表</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
    <style type="text/css">
   .js_days{display: none;}
    </style>
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
				<h2>优惠劵搜索</h2>
				<form action="/hizhu/CouponManage/couponList.html?no=77&leftno=42" method="get">
				  	<input type="hidden" name="no" value="77">
				  	<input type="hidden" name="leftno" value="42">
					<table class="table_one">
						<tr>
							<td class="td_title">优惠劵名称：</td>
							<td class="td_main"><input type="text" name="name" value="<?php echo I('get.name')?>"></td>
							<td class="td_title">活动编号：</td>
							<td class="td_main"><input type="text" name="hdid" value="<?php echo I('get.hdid')?>"></td>
							<td class="td_title">优惠劵总量：</td>
							<td class="td_main"><input type="text" name="total_count" value="<?php echo I('get.total_count')?>"></td>
						</tr>
						<tr>
							<td class="td_title">活动金额：</td>
							<td class="td_main"><input type="text" name="price" value="<?php echo I('get.price')?>"></td>
							<td class="td_title">房东电话：</td>
							<td class="td_main"><input type="text" name="owner_mobile" value="<?php echo I('get.owner_mobile')?>"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
				 </form>
				  
				</div>
				<div class="common_main">
				<h2>商家优惠劵列表<a href="/hizhu/CouponManage/addnewtemp.html?no=77&leftno=42" class="btn_a">新增优惠劵</a></h2>

				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>优惠劵类型</th>
								<th>优惠劵名称</th>
								<th>房东手机号</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>优惠劵金额</th>
								<th>有效期</th>
								<th>优惠劵总量</th>
								<th>使用条件</th>
								<th>是否可叠加使用</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="tb1">
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td>
									<?php if(strtoupper($vo['coupon_type']) == '1'): ?>普通优惠劵
									<?php else: ?>
									  商家优惠劵<?php endif; ?>
								</td>
								<td><?php echo ($vo['name']); ?></td>
								<td><?php if(strtoupper($vo['coupon_type']) == '2'): echo ($vo['relation_id']); endif; ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['start_date'])); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['end_date'])); ?></td>
								<td><?php echo ($vo['price']); ?></td>
								<td>
								   <?php if(strtoupper($vo['effective_type']) == '0'): echo (date("Y-m-d H:i:s",$vo['effective_date'])); ?>
								   <?php else: ?>
									   <?php echo ($vo['effective_date']); endif; ?>
								</td>
								<td><?php echo ($vo['total_count']); ?></td>
								<td><?php echo ($vo['limit_txt']); ?></td>
								<td>
								     <?php if(strtoupper($vo['use_type']) == '0'): ?>不可叠加
									<?php else: ?>
									   可叠加<?php endif; ?>
								</td>
								<td>
							
								<!-- <a href="<?php echo U('CouponManage/delCouponManage');?>?delid=<?php echo ($vo['id']); ?>?no=77&leftno=42">删除</a>&nbsp;&nbsp;&nbsp; -->
								<a href="<?php echo U('CouponManage/upnewtemp');?>?upid=<?php echo ($vo['id']); ?>?no=77&leftno=42">修改</a>
								
								</td>
								<input name="activity_id" type="hidden" class="activity_id" value="<?php echo ($vo['id']); ?>">
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				        <div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页20条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
			</div>
			
		</div>
	</div>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:true,format:"Y-m-d h:m"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:true,format:"Y-m-d h:m"});
	$('#datetimepickertimes').datetimepicker({step:10,lang:'ch',timepicker:true,format:"Y-m-d h:m"});
	/*提交表单*/
 function check(){
	   var cname=$("input[name='cname']").val();
	   var startTime=$("input[name='startTime']").val();
	   var cmoney=$("input[name='cmoney']").val();
	   var total_count=$("input[name='total_count']").val();
	   var hdid=$("input[name='hdid']").val();
	   if(cname==""){
		    alert("活动名称不能为空！");
		    return false;
	   }else if(startTime==""){
		   alert("活动开始时间不能为空！");
		   return false;
	   }else if(cmoney==""){
		   alert("活动金额不能为空！");
		   $("#index_no").focus();
		   return false;
	   }else if(total_count==""){
		   alert("活动领取个数不能为空！");
		   return false;
	   }else if(hdid==""){
		   alert("活动编号不能为空！");
		   return false;
	   }else{
		   $("#form").submit();
	   } 
   }


</script>
<script>
$.each($("#tb1").find("input.activity_id"), function(){
       		GetCouponCount($(this).val());
    });
function GetCouponCount(activity_id){
    var UrlParam ={
	 	activity_id: activity_id
	  };
	 $.ajax({
	        type: "GET",
	        cache: false,
	        url: "/hizhu/CouponManage/getCouponCount.html",
	        data: UrlParam,
	        dataType: "json",       
	        success: function(json){
				$("#"+json.activity_id).text(json.count);
	        }
	  });
}
</script>
</body>
</html>