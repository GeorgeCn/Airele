<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>个人信息修改</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
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
				<h2>职业房东信息</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form method="post" action="/hizhu/Jobowner/ownersModifyInfo.html">	
				<input type="hidden" name="customer_id" value="<?php echo ($info['id']); ?>">
				<table class="table_one table_two">	
					<tr>
						<td class="td_title">用户身份：</td> 
						<td>
							<?php switch($info['is_owner']): case "0": ?>租客<?php break; case "3": ?>个人房东<?php break; case "4": ?>职业房东<?php break; case "5": ?>中介经纪人<?php break; endswitch;?>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>姓名：</td> 
						<td><input type="text" name="true_name" maxlength="8" value="<?php echo ($info['true_name']); ?>"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>手机号：</td>
						<td class="td_main">
							<label><input type="tel" name="mobile" maxlength="11" value="<?php echo ($info['mobile']); ?>"  readonly="readonly"></label>
						</td>
					</tr>
					<tr>
						<td class="td_title">跟进状态：</td> 
						<td>
							<select name="status" style="width:120px">
								<option value="0">待跟进</option>
								<option value="3">跟进中</option>
								<option value="5">不合作</option>
								<option value="2">已签约</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>城市：</td> 
						<td>
							<select id="ddl_city" name="city_code" style="width:120px">
								<option value=""></option>
								<option value="001009001">上海</option>
								<option value="001001">北京</option>
								<option value="001010001">南京</option>
								<option value="001011001">杭州</option>
								<option value="001019002">深圳</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">主营区域：</td>
						<td class="td_main">
							<input type="hidden" name="region_name" value="<?php echo ($info['region_name']); ?>">
							<select id="ddl_region" name="region_id" style="width:120px">
								<option value="0"></option>
								<?php echo ($regionList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">房东负责人：</td>
						<td class="td_main">
							<label>
							    <input type="text" name="principal_man" style="width:140px" value="<?php echo ($info['principal_man']); ?>">
								<div id="div_principal_man" class="plotbox" style="width:150px;">
									<ul>
									</ul>
								</div>
							</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">所属公司：</td> 
						<td class="td_main">
							<input type="hidden" name="agent_company_name" value="<?php echo ($info['agent_company_name']); ?>">
							<select id="ddl_company" name="agent_company_id" style="width:180px">
								<option value=""></option>
								<?php echo ($companyList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">所属门店：</td> 
						<td>
							<input type="hidden" name="company_store_name" value="<?php echo ($info['company_store_name']); ?>">
							<select id="ddl_store" name="company_store_id" style="width:180px">
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title">保证金：</td> 
						<td><input type="text" name="margin" maxlength="5" style="width:140px"></td>
					</tr>
					<tr>
						<td class="td_title">权益：</td> 
						<td>
							<?php switch($info["owner_verify"]): case "1": ?>未认证<?php break;?>
										<?php case "2": ?>已认证<?php break;?>
										<?php case "3": ?>拒绝<?php break;?>
										<?php case "4": ?>已取消<?php break;?>、
										<?php case "5": ?>拉黑<?php break;?>
										<?php default: ?>空<?php endswitch;?>
						</td>
					</tr>
					<tr>
						<td class="td_title">是否开启IM：</td> 
						<td>
							<?php if($info["im_open"] == 1): ?>是
							<?php else: ?>否<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td class="td_title">备注：</td>
						<td class="td_main">
							<label><textarea name="owner_remark" maxlength="255"><?php echo ($info['owner_remark']); ?></textarea></label>
						</td>
					</tr>
				</table>
				</form>
				<div class="addhouse_last addhouse_last_room"><a href="javascript:;" class="btn_a">提交</a></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
	$("#ddl_city").val("<?php echo ($info['city_code']); ?>");
	$("select[name='status']").val("<?php echo ($info['status']); ?>");
	var _status = "<?php echo ($info['status']); ?>";
	if( _status != 0) {
		$("input[name='principal_man']").attr("disabled","disabled");
	}
	$(".btn_a").click(function(){
		submitData();
	});
	function submitData(){
	    var mobile=$("input[name='mobile']").val();
	    if($("input[name='true_name']").val().replace(/\s+/g,'')==""){
		  	return alert("请输入房东姓名");
	    } else if($("input[name='principal_man']").val() == "") {
	    	return alert("请选择房东负责人");
	    } else {
		    $(".btn_a").unbind('click').text('提交中');
		    $('form').submit();    	
	    }  
	}
	//区域
	$("#ddl_region").val("<?php echo ($info['region_id']); ?>");
	$("#ddl_region").change(function(){
		var region_id=$(this).val();
		var region_name=$("#ddl_region option[value="+region_id+"]").text();
		$("input[name='region_name']").val(region_name);
	});

	//中介公司
	// $("#ddl_company").val("<?php echo ($info['agent_company_id']); ?>");
	$("#ddl_company option[value=<?php echo ($info['agent_company_id']); ?>]").attr("selected",true);
	$("#ddl_company").change(function(){
		var company_id=$(this).val();
		var company_name=$("#ddl_company option[value="+company_id+"]").text();
		$("input[name='agent_company_name']").val(company_name);

		//自动加载门店
		var pid = company_id;
		if(pid) {
			$('#ddl_store').show().empty();
			// 请求下一级数据
			$.ajax({
		            type:'post',
		            url: "<?php echo U('AgentsManage/companyStoreAjaxInfo');?>",
		            data:"id="+pid,
		            async:"false",
		            dataType:'json',	        
		            success:function(data){
		            	$('<option value=""></option>').appendTo($('#ddl_store'));
		            	if(data != null) {
			                for (var i = 0; i < data.length; i++) {
			                    $('<option value="'+data[i].id+'">'+data[i].company_store+'</option>').appendTo($('#ddl_store'));
			                }
		            	}
		            },
			})		
		}     
	});
	//门店
	$("#ddl_company").trigger('change');
	id = "<?php echo ($info['company_store_id']); ?>";
	name = "<?php echo ($info['company_store_name']); ?>";
	$('<option value="'+id+'">'+name+'</option>').appendTo($('#ddl_store'));
	$("#ddl_store").change(function() {
		var company_store_id=$(this).val();
		var company_store_name=$("#ddl_store option[value="+company_store_id+"]").text();
		$("input[name='company_store_name']").val(company_store_name);
	});

	/*房东负责人 */
	$("input[name='principal_man']").keyup(function(){
		var key_word=$(this).val();
		if(key_word.length<1){
			return;
		}
		$.get("/hizhu/HouseResource/searchHandleMen",{keyword:key_word},function(result){
			if(result.status=="200"){
				var attr=result.data;
				var len=attr.length;
				var obj=$("#div_principal_man ul");
				obj.html("");
				for (var i = len-1; i >= 0; i--) {
					obj.append("<li onclick=\"selectPrincipal('"+attr[i].user_name+"','"+attr[i].real_name+"')\" >"+attr[i].real_name+"</li>");
				};
				if(len>0){
					$("#div_principal_man").show();
				}else{
					$("#div_principal_man").hide();
				}
			}
		},"json");
	});
	function selectPrincipal(userName,realName){
		$("input[name='principal_man']").val(userName);
		$("#div_principal_man").hide();
	}
</script>
</html>