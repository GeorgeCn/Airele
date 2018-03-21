<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>包月佣金管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css">
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
				<h2>用户&nbsp;>&nbsp;<?php echo I('get.mobile'); ?>&nbsp;>&nbsp;包月</h2>
				<input type="hidden" id="customer_id" value="<?php echo I('get.customer_id'); ?>">
			</div>
			<div class="common_main">
				<h2>列表展示<a href="#" class="btn_a" id="btn_add">新增</a></h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>启用时间</th>
								<th>天数</th>
								<th>金额</th>
								<th>备注</th>
								<th>合同类型</th>
								<th>是否延期</th>
								<th>创建人</th>
								<th>创建时间</th>
								<th>修改人</th>
								<th>修改时间</th>
								<th>操作</th>
								<th>历史记录</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td><?php if(($vo["monthly_start"] > 0)): echo (date("Y-m-d",$vo["monthly_start"])); endif; ?></td>
								<td><?php echo ($vo["monthly_days"]); ?></td>
								<td><?php echo ($vo["monthly_money"]); ?></td>
								<td><?php echo ($vo["monthly_bak"]); ?></td>
								<td><?php if(($vo["contract_type"] == 0)): ?>空
									<?php elseif(($vo["contract_type"] == 1)): ?>普通发房
									<?php elseif(($vo["contract_type"] == 2)): ?>置顶<?php endif; ?>
								</td>
								<td>
									<?php if(($vo["is_delay"]) == "0"): ?>否<?php endif; ?>
									<?php if(($vo["is_delay"]) == "1"): ?>是<?php endif; ?>
								</td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><?php if(($vo["create_time"] > 0)): echo (date("Y-m-d H:i",$vo["create_time"])); endif; ?></td>
								<td><?php echo ($vo["update_man"]); ?></td>
								<td><?php if(($vo["update_time"] > 0)): echo (date("Y-m-d H:i",$vo["update_time"])); endif; ?></td>
								<td>
								<?php if(($vo["is_open"]) == "0"): ?>停用<?php endif; ?>
								<?php if(($vo["is_open"]) == "1"): ?><a href="javascript:;" onclick="startDelay('<?php echo ($vo["id"]); ?>','<?php echo ($vo["monthly_end"]); ?>','<?php echo ($vo["monthly_days"]); ?>')" class="btn_a" id="delay">延期&nbsp;</a><a href="javascript:;" onclick="stopdown('<?php echo ($vo["id"]); ?>','<?php echo ($vo["customer_id"]); ?>')" class="btn_a" style="margin:0px 20px 5px 20px">&nbsp;停用&nbsp;</a><a href="javascript:;" onclick="startJump('<?php echo ($vo["id"]); ?>','<?php echo ($vo["monthly_end"]); ?>')" class="btn_a">&nbsp;编辑</a><?php endif; ?>
								</td>
								<td><a href="<?php echo U('Commission/contractCheckHistoryLog',array('relation_id'=>$vo['id']));?>" target="_blank">查看</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
	<!--浮层 -->
	<div id="dialogDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:660px;height:330px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<table class="table_one">
				<tr>
					<td class="td_title"><span>*</span>合同时长：</td> 
					<td><input type="text" name="monthly_days" maxlength="4" style="width:120px;">&nbsp;天</td>
				</tr>
				<tr>
					<td class="td_title"><span>*</span>合同金额：</td> 
					<td><input type="text" name="monthly_money" maxlength="6" style="width:120px;">&nbsp;元</td>
				</tr>
				<tr>
					<td class="td_title"><span></span>合同类型：</td> 
					<td><select name="contract_type" style="width:120px;">
						<option value="0">--选择--</option>
						<option value="1">普通发房</option>
						<option value="2">置顶</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="td_title"><span>*</span>启用时间：</td>
					<td class="td_main"><input class="inpt_a" type="text" name="monthly_start"></td>
				</tr>
				<tr>
					<td class="td_title"><span></span>备注信息：</td>
					<td class="td_main">
						<input type="text" name="monthly_bak" maxlength="60" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class="td_title"><span></span>是否停用佣金规则：</td>
					<td class="td_main">
						<label><input type="checkbox" name="is_stopcomm" checked="checked">是</label>
					</td>
				</tr>
			</table>
			<div class="addhouse_last addhouse_last_room" style="text-align:center;padding:20px;">
				<a href="javascript:;" class="btn_b" style="margin-right:30px;">取消</a>
				<a href="javascript:;" class="btn_a" id="submit_add">提交</a>
			</div>
		</div>
	</div>
	<div id="delayDiv" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:660px;height:300px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<table class="table_one" style="margin-top:15%">
				<tr>
					<td class="td_title"><span>*</span>合同延期：</td> 
					<td><input type="text" name="monthly_delay" maxlength="4" style="width:120px;">&nbsp;天</td>
				</tr>
				<tr>
					<td class="td_title"><span></span>备注信息：</td>
					<td class="td_main">
						<input type="text" name="monthly_bak_delay" maxlength="60" style="width:100%">
					</td>
				</tr>
			</table>
			<div class="addhouse_last addhouse_last_room" style="text-align:center;padding:20px;">
				<a href="javascript:;" class="btn_b" id="cancel_delay" style="margin-right:30px;">取消</a>
				<a href="javascript:;" class="btn_a" id="submit_add_delay">提交</a>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2016,yearEnd:2020,format:"Y-m-d"});

	function stopdown(pid,custid){
		if(confirm('确认停用吗？')){
			$.get('/hizhu/Commission/stopMonthly?id='+pid+'&customer_id='+custid,function(data){
				alert(data);document.location.reload();
			});
		}
	}
	/*新增包月信息 */
	$("#btn_add").click(function () {
		$("#dialogDiv").show();
	});
		
	$(".btn_b").click(function(){
		$("#dialogDiv").hide();
	});
	$("#submit_add").click(function(){
		submitdata();
	});

	function submitdata(){
		var monthly_days=$("input[name='monthly_days']").val();
		var monthly_money=$("input[name='monthly_money']").val();
		var monthly_start=$("input[name='monthly_start']").val();
		var monthly_bak=$("input[name='monthly_bak']").val();
		var contract_type = $("select[name='contract_type']").val();
		if(monthly_days=='' || monthly_money=='' || monthly_start==''){
			alert("请输入完整信息");return;
		}
		$("#submit_add").unbind("click").text('提交中');
		var is_stopcomm=0;
		if($("input[name='is_stopcomm']").attr("checked")=="checked"){
			is_stopcomm=1;
		}
		$.post('/hizhu/Commission/addMonthlySubmit',{monthly_days:monthly_days,monthly_money:monthly_money,monthly_start:monthly_start,monthly_bak:monthly_bak,contract_type:contract_type,is_stopcomm:is_stopcomm,customer_id:$("#customer_id").val()},function(data){
			alert(data.message);document.location.reload();
		},'json');
	}
	
</script>
<script type="text/javascript">
	$("#cancel_delay").click(function () {
		$("#delayDiv").hide();
	});
	commissionID = endTime = monthDays ='';
	function startDelay (id,monthly_end,monthly_days) {
		commissionID = id;
		endTime = monthly_end;
		monthDays = monthly_days;
		var timestamp = Date.parse(new Date());
		if(endTime*1000 <timestamp) {
			alert("该合同已失效,请先手动停用,再重新新增合同！");
			return;
		} else {
			$("#delayDiv").show();	
		}
	}
	$("#submit_add_delay").click(function(){
		submitDelayData();
	});
	function submitDelayData(){
		var monthly_delay = $("input[name='monthly_delay']").val();
		var monthly_bak_delay = $("input[name='monthly_bak_delay']").val();
		var customer_id = $("#customer_id").val();
		$.ajax({
		            type:"post",
		            url: "<?php echo U('Commission/contractModifyType');?>",
		            data:{"id":commissionID,"monthly_delay":monthly_delay,"monthly_bak_delay":monthly_bak_delay,"monthly_end":endTime,"customer_id":customer_id,"monthly_days":monthDays},
		            success:function(data){
		            	var obj = eval('('+data+')');
			            if(obj.status == 404) {
					        alert(obj.message);
					    } 
						if(obj.status == 400) {
					        alert(obj.message);
					        window.location.reload(true);
					    }
					    if(obj.status == 200) {
					        alert(obj.message);
		            		window.location.reload(true);
		            	}
		            }	
				})
	}
	function startJump (id,monthly_end,monthly_days) {
		var query = window.location.search.substring(1);
       	var vars = query.split("&");
        var pair = vars[2].split("=");
		var timestamp = Date.parse(new Date());
		if(monthly_end*1000 <timestamp) {
			alert("该合同已失效,请先手动停用,再重新新增合同！");
			return;
		} else {
			if(pair[1] == 1) {
				window.open("/hizhu/Commission/contractEditInfo.html?no=6&leftno=192&id="+id,'_blank');
			} else {
				window.open("/hizhu/Commission/contractEditInfo.html?no=6&leftno=111&id="+id,'_blank');	
			}
		}
	}
</script>
</html>