<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>未听录音</title>
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
				<h2>未听录音查询</h2>
				<div class="common_head_main">
					<form action="<?php echo U('ContactOwner/nothearlist');?>" method="get">
					<input type="hidden" name="no" value="3"/>
					<input type="hidden" name="leftno" value="97"/>
					<input type="hidden" name="isday" value="<?php echo I('get.isday');?>"/>
						<table class="table_one">
							<tr>
								<td class="td_title">拨打时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo I('get.startTime'); ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" id="datetimepicker1" value="<?php echo I('get.endTime'); ?>"></td>
								<td class="td_title">租客手机号：</td>
								<td class="td_main"><input type="text" name="loginphone" value="<?php echo I('get.loginphone'); ?>"></td>
								<td class="td_title">房东手机号：</td>
								<td class="td_main"><input type="text" name="ownerphone" value="<?php echo I('get.ownerphone'); ?>"></td>
							</tr>
							<tr>
								<td class="td_title">拨打人员</td>
								<td class="td_main">
									<select name="makcall" id="js_makcall">
									   <option value="">全部人员</option>
									   <option value="0">外部人员</option>
									   <option value="1">内部人员</option>
									</select>
								</td>
								<td class="td_title">400号码：</td>
								<td class="td_main"><input type="text" name="bigphone" value="<?php echo I('get.bigphone'); ?>"></td>
								<td class="td_title">来源平台：</td>
								<td class="td_main">
									<select name="platform" id="js_platform">
									   <option value="">全部</option>
									   <option value="6">h5</option>
									   <option value="1">android</option>
									   <option value="2">iphone</option>
									   <option value="3">400系统</option>
										<option value="8">小程序</option>
									 <option value="9">百度推广</option>
									   <option value="0">微信</option>
									    <option value="10">hi租房pro</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_title">来源：</td>
								<td class="td_main">
								      <select name="info_resource_type" style="width:110px;">
								      	<?php echo ($infoResourceTypeList); ?>
								      </select>
								      <select name="info_resource" style="width:110px;">
								      	<option value=""></option>
								      	<?php echo ($infoResourceList); ?>
								      </select>
							    </td>
							    <td class="td_title">是否中介:</td>
								<td class="td_main">
									<select name="is_owner">
										<option value="">全部</option>
										<option value="5" <?php if(I('get.is_owner')==5)echo 'selected'; ?>>是</option>
										<option value="999" <?php if(I('get.is_owner')==999)echo 'selected'; ?>>否</option>
									</select>
								</td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
							
						</table>

					</form>
					<p class="head_p"><button class="btn_a" id="btnSearch">搜索</button></p>
				</div>
			</div>
			<div class="common_main">
				<h2>未听录音列表</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房间编号</th>
								<th>房源编号</th>
								<th>房间来源</th>
								<th>价格</th>
								<th>租客手机</th>
								<th>房东手机</th>
								<th>房东姓名</th>
								<th>电话来源</th>
								<th>负责人</th>
								<th>是否有佣金</th>
								<th>电话状态</th>
								<th>主叫时长(秒)</th>
								<th>房间状态</th>
								<th>录音</th>
								<th>职业房东</th>
								<th>中介用户</th>
								<th>已出租</th>
								<th>更新房源</th>
								<th>操作人</th>
								<th>拨打时间</th>
								<th>租客信息录入</th>
								<th>录音内容</th>
								<th>是否中介录音</th>
							</tr>
						</thead>
						<tbody>

							  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td></td>
								<td></td>
								<td><?php echo ($vo["info_resource"]); ?></td>
								<td></td>
								<td><?php echo ($vo["mobile"]); ?></td>
								<td><?php echo ($vo["owner_mobile"]); ?></td>
								<td><?php echo ($vo["owner_name"]); ?></td>
								<td>
								<?php if(strtoupper($vo['gaodu_platform']) == '0'): ?>h5
								<?php elseif(strtoupper($vo['gaodu_platform']) == '1'): ?>
								  android
							    <?php elseif(strtoupper($vo['gaodu_platform']) == '2'): ?>
									iphone
								<?php elseif(strtoupper($vo['gaodu_platform']) == '3'): ?>
									400系统
								<?php elseif(strtoupper($vo['gaodu_platform']) == '8'): ?>
									小程序
								<?php elseif(strtoupper($vo['gaodu_platform']) == '9'): ?>
									百度推广
								<?php elseif(strtoupper($vo['gaodu_platform']) == '10'): ?>
									微信<?php endif; ?>
								</td>
								<td class="<?php echo ($vo['room_id']); ?>"></td>
								<td></td>
								<td>
								<?php if(strtoupper($vo['status_code']) == '0'): ?>成功
								<?php elseif(strtoupper($vo['status_code']) == '1'): ?>
								    忙
							    <?php elseif(strtoupper($vo['status_code']) == '2'): ?>
								    无应答
								<?php elseif(strtoupper($vo['status_code']) == '3'): ?>
									客户提前挂机
								
								<?php elseif(strtoupper($vo['status_code']) == '201'): ?>
									无效分机号
								<?php elseif(strtoupper($vo['status_code']) == '555'): ?>
									黑名单
								<?php elseif(strtoupper($vo['status_code']) == '777'): ?>
									回呼外线失败
								<?php elseif(strtoupper($vo['status_code']) == '1000'): ?>
								   非工作时间
								<?php elseif(strtoupper($vo['status_code']) == '1002'): ?>
									欠费
								<?php else: ?>
								   未知<?php endif; ?>
								</td>
								<td><?php echo ($vo['caller_length']); ?></td>
							
								<td></td>
								<?php if(strtoupper($vo['source']) == '10'): ?><td><?php if($vo['status_code']==0&&$vo['is_down']==1){?><audio <?php if($vo['is_read']==0){?>  onplaying="recordState('<?php echo$vo['id'];?>','<?php echo$vo['room_id'];?>',this);"<?php }?> controls="controls" preload="none" style="width:42px;height:30px;"  src="<?php echo C('CALL_RECORD_URL');?>/virtual/<?php echo substr($vo['call_id'],0,2);?>/<?php echo substr($vo['call_id'],2,2);?>/<?php echo ($vo['call_id']); ?>.mp3"/>请升级浏览器版本</audio><?php }else{if(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']>=20){echo'<a href="javascript:;" onclick="virtualanewdowload(';echo"'".$vo['call_id']."'";echo');">重新下载</a>';}elseif(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']<20){echo"等待下载";}}?></td>
								<?php else: ?>	
									 <td><?php if($vo['status_code']==0&&$vo['is_down']==1){?><audio <?php if($vo['is_read']==0){?>  onplaying="recordState('<?php echo$vo['id'];?>','<?php echo$vo['room_id'];?>',this);"<?php }?> controls="controls" preload="none" style="width:42px;height:30px;"  src="<?php echo C('CALL_RECORD_URL');?>/<?php echo ($vo['call_id']); ?>.mp3"/>请升级浏览器版本</audio><?php }else{if(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']>=20){echo'<a href="javascript:;" onclick="anewdowload(';echo"'".$vo['call_id']."'";echo');">重新下载</a>';}elseif(strlen($vo['status_code'])==1&&$vo['status_code']<1&&$vo['fail_times']<20){echo"等待下载";}}?></td><?php endif; ?>
								<td><?php if($vo['is_owner']!=5){?><a href="#" onclick="confirmJobowner(<?php echo $vo['owner_mobile']?>)">新增职业房东</a><?php }?></td>
								<td><?php if($vo['is_owner']!=4){?><a href="#" onclick="confirmMiddleman(<?php echo $vo['owner_mobile']?>)">新增中介用户</a><?php }?></td>
								<td><?php if($vo['status_code']==0&&$vo['is_down']==1&&$vo['room_id']!=""){?><a href="javascript:;" <?php if($vo['is_read']==0){?> style="display:none;"<?php }?> onclick="yetRent('<?php echo ($vo['room_id']); ?>','<?php echo ($vo['id']); ?>',this);">已出租</a><?php }?>
								<?php if($vo['room_id']==""&&$vo['is_read']!=0){?><a href="javascript:;" onclick="alreadyListen('<?php echo$vo['id'];?>');">已听</a><?php }?></td>
								<td><?php if($vo['status_code']==0&&$vo['is_down']==1&&$vo['room_id']!=""){?><a href="javascript:;"<?php if($vo['is_read']==0){?> style="display:none;"<?php }?> onclick="upHouse('<?php echo ($vo['room_id']); ?>','<?php echo ($vo['id']); ?>');">更新房源</a><?php }?></td>
								<td><?php echo ($vo['updata_man']); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<td><span  class="btn_a" id="btn_add" onclick="startRecord('<?php echo ($vo["mobile"]); ?>')">录入</span></td>
								<td><?php if(strtoupper($vo['memo']) == ''): ?><a href="javascript:;"<?php if($vo['is_read']==0){?> style="display:none;"<?php }?> onclick="addcontent('<?php echo ($vo['id']); ?>');">添加</a><?php else: echo ($vo['memo']); endif; ?></td>
							   <td><?php if(strtoupper($vo['is_owner']) == '5'): ?>是<?php else: ?>否<?php endif; ?></td>
								<input name="room_id" type="hidden" value="<?php echo ($vo['room_id']); ?>">
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

	<div class="addReply" style="display:none;">
		<div class="addReply_main" style="width:400px;height:200px;">
			 <input type="hidden" name="callid">
				<div class="cf reply_text">
					<textarea name="reply_content" id="reply_content" style="margin-left:10%;width:80%;border:1px solid #eee;"></textarea>
				</div>
				<div class="anniu cf">	
					<a href="#" class="anniu_back" style="margin:0 50px;">取消</a>
					<button class="anniu_add" onclick="return check1();" style="border:none;width:100px;margin:0 50px;">添加</button>
				</div>
		</div>
	</div>

	<div id="infoAdd" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:999;display:none;">
		<div style="width:600px;height:470px;background:#fff;position:absolute;left:50%;margin-left:-300px;top:50%;margin-top:-235px;border-radius:10px;">
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">租客电话：</label>
				<input type="text" readonly class="fl" id="renterMoblie" style="width:200px;height:36px;">
				<input type="hidden" name="city_code" id="cityCode">
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">性别:</label>
				<select id="sexType" style="width:300px;height:36px;">
					<option value="0">选择</option>
					<option value="1">男</option>
					<option value="2">女</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">是否介意隔断：</label>
				<select id="cutoffType" style="width:300px;height:36px;">
					<option value="0">选择</option>
					<option value="1">是</option>
					<option value="2">否</option>
					<option value="3">不关注</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">是否需要独立卫生间：</label>
				<select id="bathroomType" style="width:300px;height:36px;">
					<option value="0">选择</option>
					<option value="1">需要</option>
					<option value="2">不需要</option>
					<option value="3">不关注</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">是否需要厨房：</label>
				<select id="kitchenType" style="width:300px;height:36px;">
					<option value="0">选择</option>
					<option value="1">需要</option>
					<option value="2">不需要</option>
					<option value="3">不关注</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">看房选择：</label>
				<select id="lookroomType" style="width:300px;height:36px;">
					<option value="0">选择</option>
					<option value="1">立即看房</option>
					<option value="2">预约看房时间</option>
				</select>
			</div>
			<div style="margin:20px;" class="cf">
				<label class="fl" style="height:36px;line-height:36px;width:150px;text-align:right;">是否排斥二房东：</label>
				<select id="rejectType" style="width:300px;height:36px;">
					<option value="0">选择</option>
					<option value="1">是</option>
					<option value="2">否</option>
				</select>
			</div>
			<div  style="text-align:center;">
				<button class="btn_b" style="margin-right:50px;">取消</button>
				<button class="btn_a" id="btn_submit">提交</button>
			</div>
		</div>
	</div>
	
    <script src="/hizhu/Public/js/jquery.js"></script>
    <script src="/hizhu/Public/js/common.js"></script>
    <script src="/hizhu/Public/js/listdata.js"></script>
    <script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
	<script>
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$("#js_makcall").val('<?php echo I("makcall"); ?>');
	$("#js_platform").val('<?php echo I("platform"); ?>');
	$("select[name='info_resource_type']").val('<?php echo I("get.info_resource_type"); ?>');
	$("select[name='info_resource']").val('<?php echo I("get.info_resource"); ?>');

if($("input[name='startTime']").val()==''){
	$("input[name='startTime']").val('<?php echo date("Y-m-d",time()-3600*24*7); ?>');
	$("input[name='endTime']").val('<?php echo date("Y-m-d",time()); ?>');
}
$("#btnSearch").click(function(){
	$(this).unbind('click').text('搜索中');
	$("form").submit();
});
	//下拉联动，来源
	$("select[name='info_resource_type']").change(function(){
		if($(this).val()==""){
			$("select[name='info_resource']").html("");
			return;
		}
		$.get("/hizhu/HouseResource/getInforesourceByType",{type:$(this).val()},function(data){
			$("select[name='info_resource']").html('<option value=""></option>'+data);
		},"html");
	});
     function recordState(id,roomid,object){
     		$.get("/hizhu/ContactOwner/recordState.html",{id:id},function(data){
    	   			if(data.status==201){
    	   				alert("该条录音已听");
    	   			}else{
    	   				if(roomid!=""){
					     	$(object).parent().nextAll('td').eq(1).html('<a href="javascript:;" onclick="yetRent('+"'"+roomid+"','"+id+"',this"+');">已出租</a>');
					        $(object).parent().nextAll('td').eq(2).html('<a href="javascript:;" onclick="upHouse('+"'"+roomid+"','"+id+"'"+');">更新房源</a>');
					        $(object).parent().nextAll('td').eq(3).html('<?php echo cookie("admin_user_name");?>');
					     $(object).parent().nextAll('td').eq(6).html('<a href="javascript:;" onclick="addcontent('+"'"+id+"'"+');">添加</a>');
				        }else{
				        	$(object).parent().nextAll('td').eq(1).html('<a href="javascript:;" onclick="alreadyListen('+"'"+id+"'"+');">已听</a>');
				        	$(object).parent().nextAll('td').eq(3).html('<?php echo cookie("admin_user_name");?>');
				         $(object).parent().nextAll('td').eq(6).html('<a href="javascript:;" onclick="addcontent('+"'"+id+"'"+');">添加</a>');
				        }
				        
    	   			}
				},"json");
     }
      $(function(){
		   $(".anniu_back").on("click",function(){
		       $(".addReply").hide();
		   })
		});
      function check1(){
      	   var reply_content=$("#reply_content").val();
      	   var callid=$("input[name='callid']").val();
           if(reply_content==""){
           		alert("内容不能为空");
           		return false;
    	   }else{
    	   		$.get("/hizhu/ContactOwner/remarkscontent.html",{callid:callid,content:reply_content},function(data){
    	   			if(data.status==201){
    	   				alert("该条录音已经添加内容");
    	   				$(".addReply").hide();
    	   			     location.reload();
    	   			}else if(data.status==200){
    	   			   $(".addReply").hide();
    	   			   location.reload();
    	   			}
				},"json");
    	   }
      }
     function addcontent(callid){
    		$("input[name='callid']").val(callid);
		    $(".addReply").show();
     }
     function yetRent(roomid,id,obj){
     	if(confirm("确认将该房源下架吗？")){
     		$.get("/hizhu/ContactOwner/uphouserroom.html",{roomid:roomid,id:id,uptype:1},function(data){
	   			if(data.status==201){
	   				alert("该条录音已听");
	   			    // location.reload(); 
	   			}else if(data.status==200){
	   			    $(obj).parent().parent().remove();
	   			    $.ajax({
				            type:"post",
				            url: "<?php echo U('ContactOwner/findStoreID');?>",
				            data:{"room_no":roomid},
				            dataType: "json",
				            success:function(info) {
				            	if(info.code == 404) {
				            		alert(info.message);
				            	}
				            	if(info.code == 200) {
				            		if(confirm('是否去扣信用分')) {
				            			window.open("/hizhu/Stores/storeModifyCreScore.html?no=162&leftno=164&id="+info.id.store_id+"&room_no="+info.no.room_no,'_blank');
				            		} 
				            	}
				            }	
				    	})
	   			}
			},"json");
     	}
     		
     }
     function upHouse(roomid,id){
     	$.get("/hizhu/ContactOwner/uphouserroom.html",{roomid:roomid,id:id,uptype:2},function(data) {
     		if(data.status==201) {
     			alert("该条录音已听");
    	   		location.reload();
     		} else if (data.status==200) {
	            	$.ajax({
			            type:"post",
			            url: "<?php echo U('ContactOwner/findStoreID');?>",
			            data:{"room_no":roomid},
			            dataType: "json",
			            success:function(info) {
			            	if(info.code == 404) {
			            		alert(info.message);
			            		location.reload();
			            	}
			            	if(info.code == 200) {
			            		if(confirm('是否去扣信用分')) {
			            			window.open("/hizhu/Stores/storeModifyCreScore.html?no=162&leftno=164&id="+info.id.store_id+"&room_no="+info.no.room_no,'_blank');
			            		} else {
			            			location.reload(); 
			            		}
			            	}
			            	if(info.code == 201) {
			            		location.reload();
			            	}
			            }	
		    		})
		    	}	
     		},'json');
	}
     function alreadyListen(id){
     		$.get("/hizhu/ContactOwner/alreadylisten.html",{id:id},function(data){
    	   			 if(data.status==200){
    	   			     location.reload();
    	   			}
				},"json");

     }
    </script>
   <script type="text/javascript">
    $(".table table tr").each(function(index,object){
    	var room_id=$(object).find("input[name='room_id']").val();
    	if(room_id!="undefined"&&room_id!=""){
	        $.get("/hizhu/ContactOwner/jsonhouseroom.html",{room_id:room_id,index:index},function(data){
					if(data!=null){
					   var room_id=data.id;
					   var room_no=data.room_no;
					   var resource_id=data.resource_id;
					   var create_man=data.create_man;
					    var status=data.status;
					    var is_commission=data.is_commission;
					    var room_money=data.room_money;
					     if(status==2){
					    	var roomstatus="未入住";
					    }else if(status==3){
					    	var roomstatus="已出租";
					    }else if(status==4){
					    	var roomstatus="待维护";
					    }else if(status==0){
					    	var roomstatus="待审核";
					    }else if(status==1){
					    	var roomstatus="审核未通过";
					    }
					    if(is_commission==1){
					        is_commission="是";
					    }else{
					    	is_commission="否";
					    }
					    $(".table table").find("tr:eq("+index+")").children("td:eq(1)").html('<a href="/hizhu/HouseRoom/modifyroom?no=3&leftno=44&room_id='+room_id+'&handle=search" target="_blank">'+room_no+'</a>');
					   $(".table table").find("tr:eq("+index+")").children("td:eq(2)").html('<a href="/hizhu/HouseResource/addresource?resource_id='+resource_id+'" target="_blank">修改房源</a>');
					   $(".table table").find("tr:eq("+index+")").children("td:eq(4)").text(room_money);
					   $(".table table").find("tr:eq("+index+")").children("td:eq(9)").text(create_man);
					   $(".table table").find("tr:eq("+index+")").children("td:eq(10)").text(is_commission);
					   $(".table table").find("tr:eq("+index+")").children("td:eq(13)").text(roomstatus);
					}
				},"json");
	    }
	});
	function anewdowload(callid){
	     if(callid!=""){
	        $.get("/hizhu/ContactOwner/anewdowload.html",{callid:callid},function(data){
			             	
			},"json");
			location.reload();
	    }
	}

	function virtualanewdowload(callid){
	     if(callid!=""){
	        $.get("/hizhu/ContactOwner/virtualanewdowload.html",{callid:callid},function(data){
			             	
			},"json");
			location.reload();
	    }
	}
	function confirmJobowner(ownermobile){
	     	$.get("/hizhu/Asklistsendlog/setConfirmJobowner?ownermobile="+ownermobile+"&source=电话录音",function(data){
				alert(data.message);
			},"json");
  	}
  	function confirmMiddleman(ownermobile){
  		if(confirm('确定新增中介吗？')) {
		 	$.get("/hizhu/AgentsManage/setAgentsInfo?mobile="+ownermobile+"&source=电话录音",function(data){
				alert(data.message);
			},"json");
		}
  	}
  	//添加租客信息录入
  	function startRecord(mobile) {
  		$.ajax({
	            type:"post",
	            url: "<?php echo U('ContactOwner/socializeInfoList');?>",
	            data:{"mobile":mobile},
	            success:function(data){
	            	var object = eval('('+data+')');
	            	if(object.status == 404) {
	            		alert(object.message);return;
	            	}
		            if(object.status == 400) {
		            	alert(object.message);return;
		            }
					$("#renterMoblie").val(mobile);
					$("#cityCode").val(object.city_code);
					$("#sexType").val(object.sex);
					$("#cutoffType").val(object.if_cut_off);
					$("#bathroomType").val(object.if_bathroom);
					$("#kitchenType").val(object.if_kitchen);
					$("#lookroomType").val(object.look_room);
					$("#rejectType").val(object.if_reject_landlord);
					$("#infoAdd").show();
				    }, 
				datatype:'json',
		    })
	};
	$(".btn_b").click(function(){
		$("#infoAdd").hide();
	});
	$("#btn_submit").click(function(){
		var mobile = $("#renterMoblie").val();
		var cityCode = $("#cityCode").val();
		var sex = $("#sexType").val();
		var cutoff = $("#cutoffType").val();
		var bathroom = $("#bathroomType").val();
		var kitchen = $("#kitchenType").val();
		var lookroom = $("#lookroomType").val();
		var reject = $("#rejectType").val(); 
		$.ajax({
	            type:"post",
	            url: "<?php echo U('ContactOwner/socializeInfo');?>",
	            data:{"mobile":mobile,"cityCode":cityCode,"sex":sex,"ifCutOff":cutoff,"ifBathroom":bathroom,"ifKitchen":kitchen,"lookRoom":lookroom,"ifRejectLandlord":reject},
	            success:function(data){
	            	var object = eval('('+data+')');
	            	if(object.status == 404) alert(object.message);
		            if(object.status == 400) alert(object.message);
		            if(object.retCode == "001" || object.retCode == "002") alert(object.retMsg);
		            $("#infoAdd").hide();
				    }, 
				datatype:'json',
		    })
	})
   </script>
</body>
</html>