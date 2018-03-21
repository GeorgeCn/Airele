<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>房源报价</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
</head>
<body>

	<div class="main">
	
		<div class="main_right">
			
			<div class="common_main">
			
				<div class="table" id="dataDiv">
					<table style="width:90%">
						<thead>
							<tr>
								<th>所属公司</th>
								<th>姓名</th>
								<th>手机号</th>
								<th>租金</th>
								<th>中介费比率</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
										<td><?php echo ($vo['company']); ?></td>
										<td><?php echo ($vo['name']); ?></td>
										<td><?php echo ($vo['phone']); ?></td>
										<td><?php echo ($vo['room_price']); ?></td>	
										<td><?php echo ($vo['comm_price']); ?></td>
										<td><a href="#" onclick="editShow('<?php echo ($vo["id"]); ?>',<?php echo ($vo["comm_price"]); ?>,<?php echo ($vo["room_price"]); ?>)">编辑</a>&nbsp;<a href="#" onclick="removeHandle('<?php echo ($vo["id"]); ?>',this)">删除</a></td>							
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
			
				</div>
				<div  style="text-align:left;margin-top:10px;">
					<input type="hidden" name="room_id" value="<?php echo I('get.room_id'); ?>">
					
					<?php echo ($show_addbutton); ?>
				</div>
			</div>
		</div>
	</div>
	<!--浮层(新增) -->
	<div id="dialogAdd" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:300px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<table class="table_one">
				<tr>
					<td class="td_title">所属公司：</td>
					<td class="td_main">
						<select id="company_id" name="company_id">
							<option value=""></option>
							<?php echo ($companyList); ?>
						</select>
						<input type="hidden" name="company_name">
					</td>
				</tr>
				<tr>
					<td class="td_title">姓名：</td>
					<td><input type="text" name="client_name" maxlength="10"></td>
				</tr>
				<tr>
					<td class="td_title">手机号：</td>
					<td><input type="text" name="client_phone" maxlength="20"></td>
				</tr>
				<tr>
					<td class="td_title">租金：</td>
					<td><input type="tel" name="room_money" maxlength="5"></td>
				</tr>
				<tr>
					<td class="td_title">中介费比率：</td>
					<td><input type="tel" name="agent_fee" maxlength="3">%</td>
				</tr>

			</table>
			<div class="addhouse_last addhouse_last_room" style="text-align:center;padding:20px;">
				<a href="javascript:;" class="btn_b" style="margin-right:30px;">取消</a>
				<a href="javascript:;" class="btn_a" id="submit_add">提交</a>
			</div>
		</div>
	</div>
	<!--浮层(编辑) -->
	<div id="dialogEdit" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:550px;height:230px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-135px;border-radius:10px;">
			<table class="table_one">
				<tr>
					<td class="td_title">租金：</td>
					<td><input type="tel" name="room_money_edit" maxlength="5"></td>
				</tr>
				<tr>
					<td class="td_title">中介费比率：</td>
					<td><input type="tel" name="agent_fee_edit" maxlength="3">%</td>
				</tr>

			</table>
			<div class="addhouse_last addhouse_last_room" style="text-align:center;padding:20px;">
				<a href="javascript:;" class="btn_b" style="margin-right:30px;">取消</a>
				<a href="javascript:;" class="btn_a" id="submit_edit">提交</a>
				<input type="hidden" id="offer_id">
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">
$("#btn_add").click(function(){
	$("#dialogAdd").show();
});
$(".btn_b").click(function(){
	$("#dialogAdd").hide();
	$("#dialogEdit").hide();
});
$("#company_id").change(function(){
	var company_id=$(this).val();
	var company_name=$("#company_id option[value="+company_id+"]").text();
	$("input[name='company_name']").val(company_name);
});
	/*新增 */
	$('#submit_add').click(function(){
		var company_id=$("#company_id").val();
		if(company_id==''){
			alert('请选择中介公司');return;
		}
		var phone=$("input[name='client_phone']").val();
		var isTel=/^1[34578]\d{9}$/;
		if(!isTel.test(phone)){
			alert('请输入有效的手机号');return;
		}
		var name=$("input[name='client_name']").val();
		if(name==''){
			alert('请输入姓名');return;
		}
		var agent_fee=parseFloat($("input[name='agent_fee']").val());
		if(isNaN(agent_fee) || agent_fee>100){
			alert('中介费比率必须是0-100');return;
		}
		var room_money=parseFloat($("input[name='room_money']").val());
		if(isNaN(room_money) || room_money<100){
			alert('租金必须大于100');return;
		}
		$(this).unbind('click').text('提交中');
		$.post('/hizhu/HouseOffer/addOfferSubmit',{company_id:company_id,company_name:$("input[name='company_name']").val(),client_name:name,client_phone:phone,
			agent_fee:agent_fee,room_money:room_money,room_id:$("input[name='room_id']").val()},function(result){
			alert(result);window.location.reload();
		});
	});
	/*编辑 */
	function editShow(offer_id,comm_price,room_price){
		$("#offer_id").val(offer_id);
		$("input[name='agent_fee_edit']").val(comm_price);
		$("input[name='room_money_edit']").val(room_price);
		$("#dialogEdit").show();
	}
	$('#submit_edit').click(function(){
		var agent_fee=parseFloat($("input[name='agent_fee_edit']").val());
		if(isNaN(agent_fee) || agent_fee>100){
			alert('中介费比率必须是0-100');return;
		}
		var room_money=parseFloat($("input[name='room_money_edit']").val());
		if(isNaN(room_money) || room_money<100){
			alert('租金必须大于100');return;
		}
		$(this).unbind('click').text('提交中');
		$.post('/hizhu/HouseOffer/editOfferSubmit',{agent_fee:agent_fee,room_money:room_money,offer_id:$("#offer_id").val(),room_id:$("input[name='room_id']").val()},function(result){
			alert(result);window.location.reload();
		});
	});
	/*删除 */
	function removeHandle(offer_id,obj){
		if(confirm("确定删除此报价吗？")){
			$.post('/hizhu/HouseOffer/removeOffer',{offer_id:offer_id,room_id:$("input[name='room_id']").val()},function(data){
				alert(data.message);
				if(data.status=="200"){
					$(obj).parent().parent().remove();
				}
			},'json');
		}
	}
</script>
</html>