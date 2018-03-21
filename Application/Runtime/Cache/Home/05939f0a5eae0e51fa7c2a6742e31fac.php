<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>举报审核</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
		<style>
		.jubao{padding:50px 5%;width:60%;text-align:center;}
		.jubao a{display:inline-block;margin:0 10px;}
		.jubao select{width:180px;display:inline-block;height:30px;}
		.btn_c{background:#e52c53;}
		.btn_c:hover{background:#db0936;}
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
			<a class="blue" href="javascript:;">欢迎您 <?php echo cookie("admin_user_name");?></a>
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
				<h2>举报审核</h2>
			</div>
			<div class="common_main">
			<table class="table_one table_two">
					<tr>
						<td class="td_title"><span>*</span>房源编号</td>
						<td class="td_main"><p style="line-height:24px;"><?php echo ($data['resource_no']); ?></p></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间编号</td>
						<td><p style="line-height:24px;" id="room_no"><?php echo ($data['room_no']); ?></p></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房东电话</td>
						<td class="td_main"><p style="line-height:24px;"><?php echo ($data['owner_mobile']); ?></p></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>举报人电话</td>
						<td class="td_main"><p style="line-height:24px;"><?php echo ($data['customer_mobile']); ?></p></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>举报类型</td>
						<td class="td_main"><p style="line-height:24px;">
							<?php if(strtoupper($data['report_type']) == '1'): ?>房间已出租
							<?php elseif($data['report_type'] == '2'): ?>房东不接电话
							<?php elseif($data['report_type'] == '3'): ?>房东是中介
							<?php elseif($data['report_type'] == '4'): ?>其他
							<?php elseif($data['report_type'] == '5'): ?>房间地址错误
							<?php elseif($data['report_type'] == '6'): ?>房间信息错误<?php endif; ?>
						</p></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>举报内容</td>
						<td class="td_main"><p style="line-height:24px;"><?php echo ($data['report_content']); ?></p></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>拒绝理由</td>
						<td class="td_main"><p style="line-height:24px;"><?php echo ($data['deal_content']); ?></p></td>
					</tr>
				</table>
				<div class="jubao" style="position:relative;padding-bottom:200px">
					<a href="/hizhu/Report/reportlist.html?no=3&leftno=62" class="btn_b">返回</a>
						<a href="javascript:;" class="btn_a" <?php if($data['deal_flag']==0){echo'id="js_tongguo"';}?>>通过</a>
					<label>拒绝理由：</label>
					<select name="deal_content" id="js_liyou">
						<option value="房源仍然可租">房源仍然可租</option>
						<option value="房东是自如，非中介">房东是自如，非中介</option>
						<option value="房东是青客，非中介">房东是青客，非中介</option>
						<option value="房东电话可打通">房东电话可打通</option>
						<option value="已核实非中介，不收取任何中介费用哦~">已核实非中介，不收取任何中介费用哦~</option>
						<option value="manual">其他</option>
					</select>
					<textarea id="txtReson" name="ma_reject" placeholder="请输入拒绝原因" style="display:inline-block;position:absolute;left:36%;top:90px;width:250px;height:80px;display:none;"></textarea>
					<a href="javascript:;" class="btn_a btn_c" <?php if($data['deal_flag']==0){echo'id="js_jujue"';}?> >拒绝</a>
				
				</div>
			</div>
		</div>
	</div>
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script type="text/javascript">
		$(function(){
			$("#js_liyou").change(function(){
				if ($(this).val()=="manual"){
					$("#txtReson").show();
				}else{
					$("#txtReson").hide();
				};
			})
		})
    </script>
    <script type="text/javascript">
      var pid="<?php echo ($data['id']); ?>";
      var cid="<?php echo ($data['customer_id']); ?>";
    $("#js_jujue").click(function(){
    	var deal_content=$("#js_liyou").val();
    	var qita=$("#txtReson").val();
    	if(deal_content=='manual'){
    		if(qita==""){
    		  alert("拒绝原因不能为空");
    		  return false;
    	    }else{
    	    	deal_content=qita;
    	    }
    	}
    	if(confirm('确定拒绝？')){
	    	window.location.href="/hizhu/Report/disposeaudit.html?type=2&pid="+pid+"&cid="+cid+"&deal_content="+deal_content;
		}
	});
	$("#js_tongguo").click(function(){
		var room_no = $("#room_no").text();
		if(confirm('确定通过？')){
			
				
			$.ajax({
			            type:"get",
			            url: "<?php echo U('Report/disposeaudit');?>",
			            data:{"type":1,"pid":pid,"cid":cid},
			            dataType: "json",
			            success:function() {
			            	$.ajax({
					            type:"post",
					            url: "<?php echo U('Report/findStoreID');?>",
					            data:{"room_no":room_no},
					            dataType: "json",
					            success:function(data) {
					            	if(data.code == 404) {
					            		alert(data.message);
					            	}
					            	if(data.code == 200) {
					            		if(confirm('是否去扣信用分')) {
					            			window.open("/hizhu/Stores/storeModifyCreScore.html?no=162&leftno=164&id="+data.id.store_id+"&room_no="+data.no.room_no,'_blank');
					            		} else {
					            			window.location.href="/hizhu/Report/reportlist.html?no=3&leftno=62";
					            		}
					            	}
					            	if(data.code == 201) {
					            		window.location.href="/hizhu/Report/reportlist.html?no=3&leftno=62";
					            	}
					            }	
				    		})
			            },	
			            async:false,
				    })
			
	     	// window.location.href="/hizhu/Report/disposeaudit.html?type=1&pid="+pid+"&cid="+cid;
     	}
	});
    </script>
</body>
</html>