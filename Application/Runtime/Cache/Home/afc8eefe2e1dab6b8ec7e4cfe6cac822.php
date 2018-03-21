<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>职业房东</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
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
				<h2>职业房东查询</h2>
				<div class="common_head_main">
				<form action="/hizhu/Jobowner/ownersManageList.html" method="get" id="searchForm">
				    <input type="hidden" name="no" value="6">
				    <input type="hidden" name="leftno" value="204">
					<table class="table_one">
						<tr>
							<td class="td_title">姓名：</td>
							<td class="td_main"><input type="text" name="true_name" value="<?php echo I('get.true_name');?>"></td>
							<td class="td_title">手机号：</td>
							<td class="td_main"><input type="tel" name="mobile" maxlength="11" value="<?php echo I('get.mobile');?>"></td>
							<td class="td_title">主营区域：</td>
							<td class="td_main">
								<select name="region_id" style="width:120px">
									<option value="">全部</option>
									<?php echo ($regionList); ?>
								</select>
							</td>
							
						</tr>
						<tr>
							<td class="td_title">房东负责人：</td>
							<td class="td_main">
								<input type="text" name="principal_man" value="<?php echo I('get.principal_man');?>">
							</td>
							<td class="td_title">跟进状态：</td>
							<td class="td_main"> 
								<select name="status">
									<option value="">全部</option>
									<option value="0"<?php if(I('get.status')=="0"){echo"selected";}?>>待跟进</option>
									<option value="3"<?php if(I('get.status')=="3"){echo"selected";}?>>跟进中</option>
									<option value="5"<?php if(I('get.status')=="5"){echo"selected";}?>>不合作</option>
									<option value="2"<?php if(I('get.status')=="2"){echo"selected";}?>>已签约</option>
								</select>
							</td>
							<td class="td_title">来源：</td>
							<td class="td_main">
							    <select name="source" id="js_source">
									<option value="">全部</option>
										<option value="房源审核">房源审核</option>
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
							<td class="td_title">公司门店：</td>
							<td class="td_main">
								<select name="agent_company_id" style="width:120px" id="ddl_company">
									<option value="">全部</option>
									<?php echo ($companyList); ?>
								</select>
								<select name="company_store_id" style="width:120px" id="ddl_store">
								</select>
							</td>			
						</tr>
						<tr>
							<td class="td_title">权限类型：</td>
							<td class="td_main">
								<label><input type="checkbox" name="is_port" value="1">&nbsp;端口&nbsp;</label>
								<label><input type="checkbox" name="is_monthly" value="1">&nbsp;包月&nbsp;</label>
								<label><input type="checkbox" name="is_commission" value="1">佣金</label>
							</td>			
						</tr>
					</table>		
					</form>
					<p class="head_p"><button class="btn_a" id="btn_search">查询</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>职业房东列表
				<a style="margin-left:20px;" class="btn_a" href="/hizhu/Jobowner/ownersAdd.html?no=6&leftno=204">新增</a>
				<a style="margin-left:150px;" href="/hizhu/Jobowner/downloadExcel?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">数据下载</a>
				</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>姓名</th>
								<th>手机号</th>
								<th>来源</th>
								<th>房东负责人</th>
								<th>跟进状态</th>
								<th>主营区域</th>
								<th>公司门店</th>
								<th>创建时间</th>
								<th>操作人</th>
								<th>端口状态</th>
								<th>包月状态</th>
								<th>佣金状态</th>
								<th>备注</th>
							</tr>
						</thead>
						<tbody id="tbody">
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<input type="hidden" value="<?php echo ($vo["customer_id"]); ?>">
								<td><?php echo ($vo['true_name']); ?></td>
								<td><?php echo ($vo['mobile']); ?></a></td>
								<td><?php echo ($vo['source']); ?></td>
								<td><?php echo ($vo['principal_man']); ?></td>
								<td>
									<?php switch($vo["status"]): case "0": ?>待跟进<?php break;?>
										<?php case "3": ?>跟进中<?php break;?>
										<?php case "5": ?>不合作<?php break;?>
										<?php case "2": ?>已签约<?php break;?>、
										<?php case "4": ?>职业房东<?php break;?>
										<?php default: ?>空<?php endswitch;?>
								</td>
								<td><?php echo ($vo['region_name']); ?></td>
								<td><?php echo ($vo['agent_company_name']); ?>-<?php echo ($vo['company_store_name']); ?></td>
								<td><?php if(($vo["create_time"]) > "0"): echo (date("Y-m-d H:i",$vo['create_time'])); endif; ?></td>
								<td><?php echo ($vo['update_man']); ?></td>
								<td><?php if($vo["is_port"] == 1): ?>端口
									<?php else: ?>无<?php endif; ?>
								</td>
								<td><?php if($vo["is_monthly"] == 1): ?>包月
									<?php else: ?>无<?php endif; ?>
								</td>
								<td><?php if($vo["is_commission"] == 1): ?>佣金
									<?php else: ?>无<?php endif; ?>
								</td>
								<td><?php echo ($vo['owner_remark']); ?></td>
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
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/listdata.js"></script>
<script>
$('.inpt_a').datetimepicker({validateOnBlur:false,step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
$("select[name='region_id']").val("<?php echo I('get.region_id');?>");
$("select[name='source']").val("<?php echo I('get.source');?>");
$("select[name='company_id']").val("<?php echo I('get.company_id');?>");
$(document).ready(function(e) {
	var port = '<?php echo I('get.is_port')?>'; 
	var monthly = '<?php echo I('get.is_monthly')?>'; 
	var commission = '<?php echo I('get.is_commission')?>'; 
    if(port == "1") {  
        $("input[name='is_port']").attr("checked","checked");
    } else if(monthly == "1") {
    	$("input[name='is_monthly']").attr("checked","checked");
    } else if(commission == "1") {
    	$("input[name='is_commission']").attr("checked","checked");
    } 
})
// $("input[name='is_port']").val("<?php echo I('get.is_port');?>");
// $("input[name='is_monthly']").val("<?php echo I('get.is_monthly');?>");
// $("input[name='is_commission']").val("<?php echo I('get.is_commission');?>");
// $(document).ready(function(e) {
// 	var rightArr = [];
// 	var right = '<?php echo json_encode(I('get.right_type'))?>';
// 		rightArr = eval(right);
// 	for(i=0;i<rightArr.length;i++){  
// 	        if(rightArr[i] == "1") {  
// 	            $("input[name='right_type[]'][value='1']").attr("checked","checked");
// 	        } else if(rightArr[i] == "2") {
// 	        	$("input[name='right_type[]'][value='2']").attr("checked","checked");
// 	        } else if(rightArr[i] == "3") {
// 	        	$("input[name='right_type[]'][value='3']").attr("checked","checked");
// 	        }
// 	}  
// })
$("#btn_search").click(function(){
		$(this).unbind('click').text('搜索中..');
		$("#searchForm").submit();
});
$(document).ready(function(e) {
	var trList = $("#tbody").children("tr");
	trList.click(function() {
		var obj = $(this);
		customer_id = obj.children("input").val();
		window.open("/hizhu/Jobowner/ownersManageDetail.html?no=6&leftno=204&id="+customer_id,'_blank');
	})

})
//中介公司
	$("#ddl_company").change(function(){
		var company_id=$(this).val();

		//自动加载门店
		var pid = company_id;
		if(pid) {
			$('#ddl_store').show().empty();
			// 请求下一级数据
			$.ajax({
		            type:'post',
		            url: "<?php echo U('AgentsManage/companyStoreAjaxInfo');?>",
		            data:"id="+pid,
		            success:function(data){
		            	$('<option value=""></option>').appendTo($('#ddl_store'));
		            	if(data != null) {
			                for (var i = 0; i < data.length; i++) {
			                    $('<option value="'+data[i].id+'">'+data[i].company_store+'</option>').appendTo($('#ddl_store'));
			                }
		            	}
		            },
		            dataType:'json',	        
			})		
		} else {
			$('#ddl_store').show().empty();
		}	     
	});
</script>
</body>
</html>