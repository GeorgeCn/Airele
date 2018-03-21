<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>添加房间</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/video-js.min.css">
    <style>
		.uploadVideos {
   		    margin-left: 100px !important;
		}
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
				<h2>新增房间</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form id="submitForm" action="/hizhu/HouseRoom/submitroom" method="post" enctype="multipart/form-data">
				<input type="hidden"  name="resource_id" value="<?php echo ($houseModel['id']); ?>">
				<input type="hidden" name="source_type" value="<?php echo I('get.source_type'); ?>">
				<table class="table_one table_two">
					<?php if(($houseModel['rental_type'] == 5)): ?><tr>
							<td colspan="2">中介信息</td>
						</tr>
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
							<td><input type="text" name="client_name" value="<?php echo ($houseModel['client_name']); ?>" maxlength="10"></td>
						</tr>
						<tr>
							<td class="td_title">手机号：</td>
							<td><input type="text" name="client_phone" value="<?php echo ($houseModel['client_phone']); ?>" maxlength="20"></td>
						</tr>
						<tr>
							<td class="td_title">中介费比率：</td>
							<td><input type="tel" name="agent_fee" maxlength="3" class="smallwidth">%</td>
						</tr><?php endif; ?>
					<tr>
						<td colspan="2">房间信息</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间名称：</td>
						<td class="td_main">
							<select id="room_name" name="room_name">
								<option value="">请选择</option>
								<?php echo ($roomNames); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间面积：</td>
						<td><input type="text" id="room_area" name="room_area" maxlength="3" class="smallwidth">平方米</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>租金：</td>
						<td class="td_main"><input type="text" id="room_money" maxlength="5" name="room_money" class="smallwidth">元/月</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>总数量：</td>
						<td><input type="text" id="total_count" name="total_count" value="1" maxlength="3" class="smallwidth"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>可租数量：</td>
						<td><input type="text" id="up_count" name="up_count" value="1" maxlength="3" class="smallwidth"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间朝向：</td>
						<td class="td_main">
							<select id="room_direction" name="room_direction">
								<option value="">请选择</option>
								<?php echo ($roomDirectionList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房间设施：</td>
						<td class="td_main">
							<?php echo ($room_equipment); ?>
						</td>
					</tr>
					<tr>
						<td class="td_title">特色标签：</td>
						<td class="td_main">
							<label><input type="checkbox" id="feature_tag" name="feature_tag[]">随意退（3天内退押金与剩余租金，提前30天退押金）</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">特色标签：</td>
						<td class="td_main">
							<label><input type="radio" name="girl_tag" value="0" checked="checked">无</label>&nbsp;
							<label><input type="radio" name="girl_tag" value="1">限女生</label>&nbsp;
							<label><input type="radio" name="girl_tag" value="2">限男生</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">房间介绍：</td>
						<td class="td_main"><textarea id="room_description" name="room_description"></textarea></td>
					</tr>
					<tr>
						<td class="td_title">房间状态：</td>
						<td class="td_main">
							<label><input type="radio" name="status" value="4" />待维护</label>&nbsp;
							<label><input type="radio" name="status" value="2" checked="checked" />未入住</label>&nbsp;
							<label><input type="radio" name="status" value="3" />已出租</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan="2">房间照（<span>必须上传真实照片</span>）</td>
					</tr>
				</table>
				<div class="roompic">
					<div class="cf photos">
						<p class="fl">房间照（<span id="imgcount">0</span>/9）&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>至少上传1张，建议上传16：9的横向照片(最大<span style="color:red;">5M</span>)</span></p>
						<div class="uploadPhotos fl">
							<span>上传照片</span>
							<input id="fileupload" type="file" name="mypic[]" multiple="multiple">
							<input type="hidden" id="room_id" name="room_id" value="<?php echo ($room_id); ?>">
							<input type="hidden" id="uploadcount" name="uploadcount"><input type="hidden" name="maxSort" value="0">
						</div>
						<p id="upload_warn" style="margin-left:35px;line-heigth:50px;color:red;display:none;">上传中..</p>
					</div>
					<ul class="cf" id="imglist">
					</ul>
				</div>
				<div class="roompic">
					<div class="cf photos">
						<p class="fl">房间视频&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>视频转码会有延迟,上传错误可重新上传(最大<span style="color:red;">50M</span>)</span><span id="countNum" style="color:red;margin-left:20px"></span></p>

						<div class="uploadPhotos uploadVideos fl" >
							<span>上传视频</span>
							<input id="files" type="file" name="file">
							<input type="hidden" id="had_vedio" name="had_vedio" value="0">
						</div>				
						<p id="upload_warning" style="margin-left:35px;line-heigth:50px;color:red;display:none;">上传中...</p>
					</div>
					<ul class="cf" id="videolist"></ul>
				</div>
				</form>
				<div class="addhouse_last addhouse_last_room"><a href="javascript:window.history.back();" class="btn_b">返回</a><a href="javascript:;" class="btn_a">提交</a></div>
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>
<script src="/hizhu/Public/plug/js-sdk/aliyun-sdk.min.js"></script>
<script src="/hizhu/Public/plug/js-sdk/vod-sdk-upload.min.js"></script>
<script src="/hizhu/Public/plug/video.min.js"></script>
<script type="text/javascript">
$('.inpt_a').datetimepicker({step:5,lang:'ch',timepicker:false,yearStart:2015,yearEnd:2018,format:"Y-m-d"});

/*删除图片*/
function removePic(img_id,obj){
	if(confirm("确定要删除吗？")){
		$.get('/hizhu/HouseRoom/deleteImage',{img_id:img_id},function(data){
			if(data.status=="200"){
				$(obj).parent().hide();
				var imgcount=parseInt($("#imgcount").text());
				$("#imgcount").text(imgcount-1);
				$("#uploadcount").val(imgcount-1);
			}else{
				alert(data.msg);
			}
		},'json');
	}
}

$(function () {
    $("#fileupload").change(function(){
    	var imgcount=parseInt($("#imgcount").text());
    	if(imgcount>=9){
    		alert("最多上传9张图片");
    		return;
    	}
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
				$("#upload_warn").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				var img_data=result.data;
				var maxSort=0;
				for (var i = 0; i < img_data.length; i++) {
					maxSort=img_data[i].imgSort;
					var img_url=img_data[i].imgUrl;
					var point_index=img_url.lastIndexOf(".");
					var corp_img_url=img_url.substring(0,point_index)+"_200_130"+img_url.substring(point_index);
					$("#imglist").append('<li><img src="'+corp_img_url+'"><br/><a href="javascript:;" onclick="removePic(\''+img_data[i].imgId+'\',this)">删除</a><br/><label><input type="radio" value="'+img_data[i].imgId+','+img_url+'" name="main_img">封面</label></li>');
				}
				$("#imgcount").text(imgcount+img_data.length);
				$("#uploadcount").val(imgcount+img_data.length);$("input[name='maxSort']").val(maxSort);
				$("#fileupload").val('');
				$("#upload_warn").hide();
			},
			error:function(xhr){
				$("#upload_warn").hide();
				if(xhr.responseText!='' && xhr.responseText!='数据无效'){
					alert(xhr.responseText);
				}
				
			}
		});
	});
});
</script>
<script type="text/javascript">
$("#company_id").change(function(){
	var company_id=$(this).val();
	var company_name=$("#company_id option[value="+company_id+"]").text();
	$("input[name='company_name']").val(company_name);
});
	var house_area=parseFloat("<?php echo ($houseModel['area']); ?>");
	var rent_type="<?php echo ($houseModel['rent_type']); ?>";
	var business_type="<?php echo ($houseModel['business_type']); ?>";
	var rental_type="<?php echo ($houseModel['rental_type']); ?>";
	if(rent_type==2){
		$("#room_area").val(house_area);
	}
	$(".btn_a").click(function(){
		btnSubmit();
	});
	/*提交表单*/
	function btnSubmit(){
		if($("#room_name").val()==""){
			alert('请选择房间名称');return;
		}
		//var numExp=/^\d{1,5}$/;
		
		var room_area=parseFloat($("#room_area").val());
		var roomMoney=parseInt($("#room_money").val());

		if(room_area<5 || isNaN(room_area)){
			alert('房间面积不能<5㎡');return;
		}
		if(room_area>house_area){
			alert('房间面积不能大于房屋总面积'+house_area);return;
		}
		if(rent_type==2 && room_area!=house_area && business_type!='1502'){
			alert('整租类型下房间面积不能修改');return;
		}else if(rent_type==1 && room_area==house_area){
			alert('合租类型下房间面积不能等于房屋总面积');return;
		}
		if(roomMoney<100 || isNaN(roomMoney)){
			alert('租金不能<100元');
			return;
		}
		if($("#room_direction").val()==""){
			alert('请选择房间朝向');
			return;
		}
		var equipment_count=$("input[name^=room_equipment]:checked").length;
		if(equipment_count==0){
			alert('请勾选房间设施');
			return;
		}
		var imgsObj=$("#imglist li:visible");
		if(imgsObj.length==0){
			alert('至少上传1张图片');return;
		}
		var mainimg_count=imgsObj.find("input[name=main_img]:checked").length;
		if(mainimg_count==0){
			alert('请设置房间照封面');
			return;
		}
		/*新增提醒 */
		var cityId=$(".citySelect select").val();
		var areaMoney=parseInt(roomMoney/room_area);
		if(cityId==1 || cityId==2) {
			if(areaMoney<=25 || areaMoney>=300){
				if(!confirm('北京/上海的正常房租在[￥25/㎡，￥300/㎡]之间，本房间的租金异常，是否确认提交？')){return;}
			}
		}else if(cityId==3 || cityId==4){
			if(areaMoney<=15 || areaMoney>=200){
				if(!confirm('南京/杭州的正常房租在[￥15/㎡，￥200/㎡]之间，本房间的租金异常，是否确认提交？')){return;}
			}
		}
		/*报价信息录入 */
		if(rental_type==5){
			if($("#company_id").val()==''){
				alert('请选择中介公司');return;
			}
			var isTel=/^1[34578]\d{9}$/;
			if(!isTel.test($("input[name='client_phone']").val())){
				alert('请输入有效的手机号');return;
			}
			if($("input[name='client_name']").val()==''){
				alert('请输入姓名');return;
			}
			var agent_fee=parseFloat($("input[name='agent_fee']").val());
			if(isNaN(agent_fee) || agent_fee>100){
				alert('请输入有效的中介费比率');return;
			}
		}
		/*视频上传，禁止提交*/
		var content = $("#upload_warning").text();
		if(content =="视频转码中,请稍后...") {
			return;
		}
		$(".btn_a").unbind("click").text("提交中");
		$("#submitForm").submit();
	}
</script>
<script type="text/javascript">
function removeAppend(obj){
 	if(confirm('确定删除视频吗？')){
			$('#videoParent1').remove();
			$('#videoParent2').remove();
			var roomID = $("#room_id").val();
			$.ajax({
					type:"post",
					url:"<?php echo U('VODClient/videoDeleteInfo');?>",
					data:{"room_id":roomID},
					success:function (data) {	
					}
				})	
		}
   	}
$(function () {
	uploadNum = '';
	$.ajax({
			type:"post",
			url:"<?php echo U('VODClient/videoCountNum');?>",
			success:function (data) {	
				uploadNum = data ;
				$("#countNum").html("今日已上传"+data+"次");
				}
			})
	/*上传视频*/
    var uploader = new VODUpload({
        // 文件上传失败
        'onUploadFailed': function (fileName, code, message) {
            // console.log("onUploadFailed: " + fileName + code + "," + message);
            $("#upload_warning").html("上传失败: " + fileName + code + "," + message).show();
        },
        // 文件上传完成
        'onUploadSucceed': function (fileName) {
            // console.log("onUploadSucceed: " + fileName);
            $("#upload_warning").hide();
            var roomID = $("#room_id").val();
            function uploadImg () {
				var roomID = $("#room_id").val();
				$.ajax({
				type:"post",
				url:"<?php echo U('VODClient/videoUpdateImgInfo');?>",
				data:{"room_id":roomID},
				success:function (data) {
					var videoUrl = 'https://vodappout.oss-cn-hangzhou.aliyuncs.com/Hizhu_MP4_HD/'+roomID+'/'+roomID+'.mp4';
					var videoImgUrl = 'https://vodappout.oss-cn-hangzhou.aliyuncs.com/Hizhu_IMG/'+roomID+'.jpg';
					$("#videolist").append('<li id="videoParent1"><img src="'+videoImgUrl+'" alt=""><br/><a href="javascript:;" onclick="removeAppend();">删除&nbsp;&nbsp;&nbsp;</a>封面</li><li id="videoParent2"><video class="video-js vjs-default-skin" controls    preload="auto"width="250"height="130"   data-setup="{}"><source src="'+videoUrl+'" type="video/mp4"></video>视频</li>');	
					$("#upload_warning").html('').hide();
					$("#had_vedio").val(1);
					uploadNum = parseInt(uploadNum)+1;
					}
				})
			}
            $.ajax({
					type:"post",
					url:"<?php echo U('VODClient/videoCreateInfo');?>",
					data:{"room_id":roomID},
					success:function (data) {	
						$("#upload_warning").html("视频转码中,请稍后...").show();
					}
				})	
			setTimeout(uploadImg,10000);			
        },
        // 文件上传进度
        'onUploadProgress': function (fileName, totalSize, uploadedSize) {
            console.log("file:" + fileName + ", " + totalSize, uploadedSize, "percent:", Math.ceil(uploadedSize * 100 / totalSize));
            $("#upload_warning").show();
        },
        // token超时
        'onUploadTokenExpired': function (callback) {
            console.log("onUploadTokenExpired");
        }
    });
    uploader.init("LTAIP4XBZGMB2Rs8", "kxsvFE5VikpwMN1odb4oUurYKcaQWq");
    document.getElementById("files").addEventListener('change', function (event) {
    	var roomID = $("#room_id").val();
    	if(uploadNum >64) {
    		$("#upload_warning").html("上传次数超过最大上限65次").show();
    		return;
    	}
    	var arr = event.target.files['0'].type.split("/");
    	if(arr['0'] != 'video') {
    		$("#upload_warning").html("上传失败:视频格式错误").show();
    		return;
    	}
    	if(event.target.files['0'].size > 52428800) {
    		$("#upload_warning").html("上传失败:视频不能超过50M").show();
    		return;
    	} else {
	        for(var i=0; i<event.target.files.length; i++) {
	            uploader.addFile(event.target.files[i],"http://oss-cn-hangzhou.aliyuncs.com","vodapp",roomID);
	        }
			uploader.startUpload();  	  		
    	}
    });
})
</script>
</html>