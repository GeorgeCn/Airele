<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>批量修改负责人</title>
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
				<h2>搜索</h2>
				<div class="common_head_main">
				<form action="/hizhu/Jobowner/principaledit" method="get">
				   <input type="hidden" name="no" value="6">
				    <input type="hidden" name="leftno" value="149">
					<table class="table_one">
						<tr>
							<td class="td_title">房东姓名：</td>
							<td class="td_main"><input type="text" name="name" value="<?php echo I('get.name');?>"></td>
							<td class="td_title">房东手机：</td>
							<td class="td_main"><input type="tel" name="mobile" maxlength="11" value="<?php echo I('get.mobile');?>"></td>
							</td>
							<td class="td_title">来源</td>
							<td class="td_main">
							      <select id="js_source" name="source">
										<option value="">全部</option>
										<option value="app签约">app签约</option>
										<option value="短信问房">短信问房</option>
										<option value="BD添加">BD添加</option>
										<option value="上房添加">上房添加</option>
										<option value="电话录音">电话录音</option>
										<option value="系统添加">系统添加</option>
										<option value="app房东版本签约">app房东版本签约</option>
										<option value="房源大于等于5套">房源大于等于5套</option>
										<option value="empty">空</option>
									</select>
							</td>
						</tr>
						<tr>
							<td class="td_title">操作人：</td>
							<td class="td_main"><input type="text" name="update_man" value="<?php echo I('get.update_man');?>"></td>
							<td class="td_title">负责人：</td>
							<td class="td_main"><input type="text"  name="principal_man" value="<?php echo I('get.principal_man');?>"></td>
							<td class="td_title">创建时间</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime');?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime');?>"></td>
						</tr>
						<tr>
							<td class="td_title">是否有佣金：</td>
							<td class="td_main"><select id="is_commission" name="is_commission">
								<option value="">全部</option>
								<option value="1"<?php if(I('get.is_commission')=="1"){echo"selected";}?>>是</option>
								<option value="0"<?php if(I('get.is_commission')=="0"){echo"selected";}?>>否</option>
							</select>
							</td>
							<td class="td_title">是否包月：</td>
							<td class="td_main">
								<select name="isMonth">
									<option value="">全部</option>
									<option value="1"<?php if(I('get.isMonth')=="1"){echo"selected";}?>>是</option>
									<option value="0"<?php if(I('get.isMonth')=="0"){echo"selected";}?>>否</option>
								</select>
							</td>
							<td class="td_title">主营区域：</td>
							<td class="td_main">
								<select name="region_id" style="width:120px">
									<option value=""></option>
									<?php echo ($regionList); ?>
								</select>
							</td>
						
						</tr>
					</table>
					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2><m style="font-weight:normal;">共选中&nbsp;<span id="selectNum">0</span>条，修改负责人为</m>&nbsp;
					<!--可输入的下拉列表-->
					<input style="width:140px;height:28px;" id="handleMan">
					<div id="estate_div" class="plotbox" style="width:130px;margin-left:205px;">
						<ul>
						</ul>
					</div>
					<a style="margin-left:300px;" href="#" class="btn_a" id="editman">修改</a></h2>
				<div id="dataDiv" class="table">
					<table>
						<thead>
							<tr>
								<th><input type="checkbox" id="checkall"></th>
								<th>序号</th>
								<th>房东姓名</th>
								<th>房东手机</th><th>主营区域</th>
								<th>创建时间</th>
								<th>负责人</th>
								<th>来源</th>
								<th>备注</th>
								<th>操作人</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox" value="<?php echo ($vo["customer_id"]); ?>"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($vo['true_name']); ?></td>
								<td><?php echo ($vo['mobile']); ?></td><td><?php echo ($vo['region_name']); ?></td>
								<td><?php if(($vo["create_time"]) > "0"): echo (date("Y-m-d H:i",$vo['create_time'])); endif; ?></td>
								<td><?php echo ($vo['principal_man']); ?></td>
								<td><?php echo ($vo['source']); ?></td>
								<td><?php echo ($vo['owner_remark']); ?></td>
								<td><?php echo ($vo['update_man']); ?></td>
								
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($totalCount); ?>条记录，每页50条</p>
						<p class="fr skip_right">
							<?php echo ($pageSHow); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
<script>
	$('.inpt_a').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$("#js_source").val("<?php echo I('get.source'); ?>");
	$("select[name='region_id']").val("<?php echo I('get.region_id'); ?>");

	$("#btnSearch").click(function(){
		$("form").submit();
		$(this).unbind('click').text('搜索中');
	})
	/*修改负责人 */
	$("#handleMan").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#estate_div ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectMen('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#estate_div").show();
				}else{
					$("#estate_div").hide();
				}
			}
		},"json");
	});
	function selectMen(userName,realName){
		$("#handleMan").val(userName);
		$("#estate_div").hide();
	}
	/*勾选 */
	$("#dataDiv table tr").each(function(){
		var select_object=$(this).children("td:eq(0)").find("input");
		select_object.bind("click",function(){
			getSelectNum();
		})
	});
	function getSelectNum(){
		var selectNum=0;
		$("#dataDiv table tr").each(function(){
			var select_object=$(this).children("td:eq(0)").find("input");
			if(select_object.attr("checked")=="checked"){
				selectNum+=1;
			}
		});
		$("#selectNum").text(selectNum);
	}
	$("#checkall").click(function(){
		if($(this).attr("checked")=="checked"){
			$("input[type='checkbox']").attr("checked","checked");
		}else{
			$("input[type='checkbox']").removeAttr("checked");
		}
		getSelectNum();
	})
	/*提交方法 */
	$("#editman").bind("click",function(){
		submitEdit();
	});
	function submitEdit(){
		var handleMan=$("#handleMan").val();
		if(handleMan==""){
			alert("先填写修改负责人");return;
		}
		var regName=/^[a-zA-Z0-9]{2,30}$/;
		if(!regName.test(handleMan)){
			alert("修改负责人填写有误");return;
		}
		var ids="";
		$("#dataDiv table tr").each(function(){
			var select_object=$(this).children("td:eq(0)").find("input");
			if(select_object.attr("checked")=="checked"){
				ids+=select_object.val()+",";
			}
		});
		if(ids==""){
			alert("需勾选修改的项");return;
		}
		$("#editman").unbind("click").text("修改中");
		$.post("/hizhu/Jobowner/principaleditSubmit",{ids:ids,principal_man:handleMan},function(data){
			alert(data.message);
			if(data.status=="200"){
				$("#editman").text("修改成功");
			}else{
				$("#editman").bind("click",function(){
					submitEdit();
				}).text("修改");
			}
		},"json");
	}

</script>
</body>
</html>