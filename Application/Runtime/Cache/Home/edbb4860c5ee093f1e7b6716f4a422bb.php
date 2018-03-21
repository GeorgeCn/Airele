<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>修改地铁交通信息</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
</head>
<body>
	<div class="main">
		<div class="main_right">
			<div class="common_main">
				<form id="submitForm" action="/hizhu/Estate/editsubwaySubmit" method="post">
				<input type="hidden" name="estate_id" value="<?php echo I('get.estate_id'); ?>">
				<table class="table_one table_two">
					<?php if(is_array($subways_list)): foreach($subways_list as $key=>$vo_item): ?><tr><td class="td_main">
						<select  name="subwayline<?php echo ($vo_item); ?>" data-index="#subway<?php echo ($vo_item); ?>" id="subwayline<?php echo ($vo_item); ?>"><option value="">请选择</option><?php echo ($subwaylineList); ?></select>&nbsp;
						<select  name="subway<?php echo ($vo_item); ?>" id="subway<?php echo ($vo_item); ?>"><option value="">请选择</option></select>&nbsp;
						<input type="text" id="subway_distance<?php echo ($vo_item); ?>" name="subway_distance<?php echo ($vo_item); ?>" maxlength="5">&nbsp;(距离：米)
						</td></tr><?php endforeach; endif; ?>
				</table>
				</form>
				<div class="addhouse_next"><button class="btn_a">提交</button></div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">

	//填充地铁信息
	var subways_str='<?php echo ($subways_str); ?>';
	if(subways_str!='null'){
		//console.log(subways_str);
		var subways_json = JSON.parse(subways_str);
		for (var j = 0; j < subways_json.length; j++) {
			var subwayline_id="#subwayline"+j;
			var subway_id="#subway"+j;
			var subway_distanceid="#subway_distance"+j;
			//console.log(subwayline_id);
			$(subwayline_id).val(subways_json[j].subwayline_id+","+subways_json[j].subwayline_name);
			$(subway_distanceid).val(subways_json[j].subway_distance);
			var subway_select=subways_json[j].subway_id+","+subways_json[j].subway_name;
			$.get("/hizhu/Estate/getDifferentSubwayByLine",{subwayline_id:subways_json[j].subwayline_id,sid:subway_id,svalue:subway_select},function(data){
				$(data.sid).html(data.contents);
				$(data.sid).val(data.svalue);
				//console.log(data.sid);
			},"json");
		};
	}
	
	//下拉联动(地铁线)
	$("select[name^='subwayline']").change(function(){
		var subway=$(this).attr("data-index");
		//console.log(subway);
		if($(this).val()==""){
			$(this).next("select").html("");
			return;
		}
		$.get("/hizhu/Estate/getSubwayByLine",{subwayline_id:$(this).val()},function(data){
			//console.log(data);
			$(subway).html(data);
		},"html");
	});
	$(".btn_a").click(function () {
		$(this).unbind('click').text('提交中');
		$("form").submit();
	});

</script>
</html>