<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>小区映射关系维护</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
</head>
<body>
   
	<div class="main">

		<div class="main_right">
			<div class="common_main">
				
				<table class="table_one" style="width:100%">
					<input type="hidden" name="id" value="<?php echo ($Model['id']); ?>">
					<input type="hidden" name="estate_id" value="<?php echo ($Model['estate_id']); ?>">
					<input type="hidden" name="region_id" value="<?php echo ($Model['region_id']); ?>">
					<input type="hidden" name="scope_id" value="<?php echo ($Model['scope_id']); ?>">
					<input type="hidden" name="region_name" value="<?php echo ($Model['region_name']); ?>">
					<input type="hidden" name="scope_name" value="<?php echo ($Model['scope_name']); ?>">
					<tr>
						<td class="td_title"><span>*</span>第三方：</td>
						<td class="td_main"><?php echo ($Model['third_name']); ?></td>
						<td class="td_title"><span>*</span>修改人：</td>
						<td class="td_main"><?php echo ($Model['update_man']); ?></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>第三方小区：</td>
						<td class="td_main"><?php echo ($Model['estate_name_third']); ?></td>
						<td class="td_title"><span>*</span>已映射嗨住小区名称：</td>
						<td class="td_main"><?php echo ($Model['estate_name']); ?></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>第三区域板块：</td>
						<td class="td_main"><?php echo ($Model['region_third']); ?>-<?php echo ($Model['scope_third']); ?></td>
						<td class="td_title"><span>*</span>已映射嗨住区域板块：</td>
						<td class="td_main"><?php echo ($Model['region_name']); ?>-<?php echo ($Model['scope_name']); ?></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>修改映射嗨住小区名称：</td>
						<td class="td_main" colspan='3'>
							<input type="text"  name="estate_name" value="<?php echo ($Model['estate_name']); ?>" class="plotIpt" style="width:99%;">
							<div id="estate_div" class="plotbox" style="width:99%;">
								<ul>
								</ul>
							</div>
						</td>
					</tr>
				</table>
				
				<div class="addhouse_next"><button class="btn_a" id="btn_submit" style="margin:0px 20px ">提交</button>&nbsp;<button class="btn_a" onclick="window.close()" style="margin:0px 20px 0px 200px">取消</button></div>
				
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	var last;
	$("input[name='estate_name']").keyup(function(event){
		//利用event的timeStamp来标记时间，这样每次的keyup事件都会修改last的值，注意last必需为全局变量
		last = event.timeStamp;
		setTimeout(function(){    
			//如果时间差为0（也就是你停止输入0.5s之内都没有其它的keyup事件发生）则做你想要做的事
			if(last-event.timeStamp==0){
				var key_word=$("input[name='estate_name']").val();
				if(key_word.length<1){
					return;
				}
				/*检索小区*/
	           $.get("/hizhu/HouseResource/searchestate",{keyword:key_word,type:''},function(result){
	           	console.log(key_word);
	           	if(result.status=="200"){
	           		var attr=result.data;
	           		var len=attr.length;
	           		var obj=$("#estate_div ul");
	           		obj.html("");
	           		for (var i = len-1; i >= 0; i--) {
	           			obj.append("<li onclick=\"selectEstate('"+attr[i].id+"','"+attr[i].estate_name+"','"+attr[i].region+"','"+attr[i].scope+"','"+attr[i].region_name+"','"+attr[i].scope_name+"')\" >"+attr[i].estate_name+"--"+attr[i].estate_address+"--"+attr[i].business_typename+"--"+attr[i].region_name+"-"+attr[i].scope_name+"</li>");
	           		};
	           		if(len>0){
	           			$("#estate_div").show();
	           		}else{
	           			$("#estate_div").hide();
	           		}
	           	}
	           },"json");             
	        }
		},500);
	});
});
	

	/*选择小区*/
	function selectEstate(estate_id,estate_name,region,scope,regionName,scopeName){
		$("input[name='estate_id']").val(estate_id);
		$("input[name='estate_name']").val(estate_name);
		$("input[name='region_id']").val(region);
		$("input[name='scope_id']").val(scope);
		$("input[name='region_name']").val(regionName);
		$("input[name='scope_name']").val(scopeName);
		$("#estate_div").hide();
	}
	$("#btn_submit").click(function () {
		var estateId=$("input[name='estate_id']").val();
		var estateName=$("input[name='estate_name']").val();
		var regionName=$("input[name='region_name']").val();
		var scopeName=$("input[name='scope_name']").val();
		if(estateId=="" || estateName==""){
			alert("请选中一个小区");return;
		}
		$(this).unbind('click');
		$.post('/hizhu/Estate/saveEstatemap',{estate_id:estateId,estate_name:estateName,region_name:regionName,scope_name:scopeName,id:$("input[name='id']").val(),region_id:$("input[name='region_id']").val(),scope_id:$("input[name='scope_id']").val()},function (data) {
			if(data.status==400) {
				alert(data.message);
			}
			if(data.status==200) {
				window.close();
			}
			
		},'json');
	});
</script>
</html>