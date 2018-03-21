<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>修改房间</title>
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
				<h2>修改房间</h2>
			</div>

			<div class="common_main">
				<!-- 表单 -->
				<form id="submitForm" action="/hizhu/HouseRoom/submitRoomModify" method="post" enctype='multipart/form-data'>
					<input type="hidden" name="handle" value="<?php echo isset($_GET['handle'])?$_GET['handle']:'' ?>">
				<table class="table_one table_two">
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
						<td><input type="text" id="room_area" name="room_area" value="<?php echo ($roomModel['room_area']); ?>" maxlength="3" class="smallwidth">平方米</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>租金：</td>
						<td class="td_main"><input type="text" id="room_money" name="room_money" maxlength="5" value="<?php echo ($roomModel['room_money']); ?>" class="smallwidth">元/月</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>总数量：</td>
						<td><input type="text" id="total_count" name="total_count" value="<?php echo ($roomModel['total_count']); ?>" maxlength="3" class="smallwidth"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>可租数量：</td>
						<td><input type="text" id="up_count" name="up_count" value="<?php echo ($roomModel['up_count']); ?>" maxlength="3" class="smallwidth"></td>
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
							<label><input type="radio" name="girl_tag" value="0">无</label>&nbsp;
							<label><input type="radio" name="girl_tag" value="1">限女生</label>&nbsp;
							<label><input type="radio" name="girl_tag" value="2">限男生</label>
						</td>
					</tr>
					<tr>
						<td class="td_title">房间介绍：</td>
						<td class="td_main"><textarea id="room_description" name="room_description"><?php echo ($roomModel['room_description']); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="2">房间照（<span>必须上传真实照片</span>）&nbsp;&nbsp;
						</td>
					</tr>
				</table>
				<div class="roompic">
					<div class="cf photos">
						<p class="fl">房间照（<span id="imgcount">0</span>/9）&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>至少上传1张，建议上传16：9的横向照片(最大<span style="color:red;">5M</span>)</span></p>

						<div class="uploadPhotos fl">
							<span>上传照片</span>
							<input id="fileupload" type="file" name="mypic[]" multiple="multiple">
							<input type="hidden" id="room_id" name="room_id" value="<?php echo ($roomModel['id']); ?>">
							<input type="hidden" id="uploadcount" name="uploadcount"><input type="hidden" name="maxSort" value="<?php echo ($roomModel['maxSort']); ?>">
						</div>
						
						<p id="upload_warn" style="margin-left:35px;line-heigth:50px;color:red;display:none;">上传中...</p>
					</div>
					<ul class="cf" id="imglist"><?php echo ($imgString); ?></ul>
				</div>
				<div class="roompic">
					<div class="cf photos">
						<p class="fl">房间视频&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>视频转码会有延迟,上传错误可重新上传(最大<span style="color:red;">50M</span>)</span><span id="countNum" style="color:red;margin-left:20px"></span></p>

						<div class="uploadPhotos uploadVideos fl" >
							<span>上传视频</span>
							<input id="files" type="file" name="file">
						</div>				
						<p id="upload_warning" style="margin-left:35px;line-heigth:50px;color:red;display:none;">上传中...</p>
					</div>
					<ul class="cf" id="videolist"><?php echo ($videoImgString); echo ($videoString); ?></ul>
				</div>
				<table class="table_one table_two">
					<tr>
						<td colspan="2">房间状态</td>
					</tr>
					<tr>
						<td class="td_title"><span></span>房间状态：</td>
						<td class="td_main">
							<label><input type="radio" name="status" value="4" checked="checked" />待维护</label>&nbsp;
							<label><input type="radio" name="status" value="2" />未入住</label>&nbsp;
							<label><input type="radio" name="status" value="3" />已出租</label>&nbsp;
						</td>
					</tr>
					<tr>
						<td class="td_title"><span></span>房间备注：</td>
						<td class="td_main"><input type="text" name="room_bak" value="<?php echo ($roomModel['room_bak']); ?>" style="width:80%"></td>
					</tr>
				</table>
				</form>
				<div class="addhouse_last addhouse_last_room"><a href="javascript:window.history.back();" class="btn_b">返回</a><a href="javascript:;" id="submit_a" class="btn_a">提交</a></div>
			</div>
		</div>
	<!-- 	<div class="bigImg">
	<div class="opacity"></div>
	<div class="bigImg-div">&nbsp;
		<img class="housePic" src="">
		<button class="rotate btn_a">旋转</button>
		<button class="save btn_a" id="js_save">保存</button>
		<input type="hidden" id="js_rotate">
	</div>
		</div> -->
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

	/*绑定数据 */
	$("#room_name").val('<?php echo ($roomModel["room_name"]); ?>');
	$("#commission_type").val('<?php echo ($roomModel["commission_type"]); ?>');
	var room_direction='<?php echo ($roomModel["room_direction"]); ?>';
	var room_equipment='<?php echo ($roomModel["room_equipment"]); ?>';
	if("1"=='<?php echo ($roomModel["feature_tag"]); ?>'){
		$("#feature_tag").attr("checked","checked");
	}
	var girl_tag='<?php echo ($roomModel["girl_tag"]); ?>';
	$("input[name=girl_tag][value="+girl_tag+"]").attr("checked","checked");
	$("#room_direction").val(room_direction);
	if(room_equipment !=''){
		var equipment_array=room_equipment.split(",");
		for (var i = equipment_array.length - 1; i >= 0; i--) {
			$("input[name^=room_equipment][value="+equipment_array[i]+"]").attr("checked","checked");
		};
	}
	var imgcount=$("#imglist li").length;
	$("#imgcount").text(imgcount);
	//主图片绑定
	var main_imgid='<?php echo ($roomModel["main_img_id"]); ?>';
	$("input[name=main_img][value^="+main_imgid+"]").attr("checked","checked");
	//房间状态
	var room_status='<?php echo ($roomModel["status"]); ?>';
	$("input[name=status][value="+room_status+"]").attr("checked","checked");
	/*删除图片*/
	function removePic(img_id,obj){
		if($("#imglist li:visible").length==1){
			alert('请至少保留1张图片');return;
		}
		if(confirm("确定要删除吗？")){
			$.get('/hizhu/HouseRoom/deleteImage',{img_id:img_id},function(data){
				if(data.status=="200"){
					$(obj).parent().hide();
					var img_count=parseInt($("#imgcount").text());
					$("#imgcount").text(img_count-1);
					$("#uploadcount").val(img_count-1);
				}else{
					alert(data.msg);
				}
			},'json');
		}
	}
	function downloadImgs(){
		if(confirm("确定要下载所有图片到本地吗？")){
			$("#upload_warn").html("下载中...").show();
			$.get('/hizhu/HouseRoom/downloadImgs',{room_id:$("#room_id").val()},function(data){
				$("#upload_warn").hide();
				if(data.status=="200"){
					alert("下载成功");
				}else{
					alert(data.msg);
				}
			},'json');
		}
	}
	function deleteImgs(){
		if(confirm("确定要删除房间下所有图片吗？")){
			$("#upload_warn").html("删除中..").show();
			$.get('/hizhu/HouseRoom/deleteImgs',{room_id:$("#room_id").val()},function(data){
				$("#upload_warn").hide();
				if(data.status=="200"){
					window.location.reload();
				}else{
					alert(data.msg);
				}
			},'json');
		}
	}

$(function () {
	/*上传图片*/
    $("#fileupload").change(function(){
    	var imgcount=parseInt($("#imgcount").text());
    	if(imgcount>=9){
    		alert("最多上传9张图片");return;
    	}
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
				$("#upload_warn").html("上传中..").show();
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
				};
				$("#imgcount").text(imgcount+img_data.length);
				$("#uploadcount").val(imgcount+img_data.length);$("input[name='maxSort']").val(maxSort);
				$("#fileupload").val('');
				$("#upload_warn").hide();
			},
			error:function(xhr){
				$("#upload_warn").hide();
				if(xhr.responseText!=''){
					alert(xhr.responseText);
				}
			}
		});
	});
});
</script>
<script type="text/javascript">
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
				var videoImgUrl = 'https://vodappout.oss-cn-hangzhou.aliyuncs.com/Hizhu_IMG/'+roomID+'.jpg';
				$.ajax({
				type:"post",
				url:"<?php echo U('VODClient/videoUpdateImgInfo');?>",
				data:{"room_id":roomID},
				success:function (data) {	
					window.location.reload(true);
					}
				})
			}
            $.ajax({
					type:"post",
					url:"<?php echo U('VODClient/videoCreateInfo');?>",
					data:{"room_id":roomID},
					success:function (data) {	
						$("#upload_warning").html("视频转码中,请稍后...").show();
						$("#submitForm").submit(false);
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
<script type="text/javascript">
var house_area='<?php echo ($house_area); ?>';
	/*提交表单*/
	$("#submit_a").bind("click",function(){
		btnSubmit();
	});
	function btnSubmit(){
		if($("#room_name").val()==""){
			alert('请选择房间名称');
			return;
		}
		var numExp=/^\d{1,5}$/;
		var floatExp=/^([1-9]\d*\.\d*|0\.\d+|[1-9]\d*|0)$/;
		var room_area=parseFloat($("#room_area").val());
		var roomMoney=parseInt($("#room_money").val());

		if(room_area<5 || isNaN(room_area)){
			alert('房间面积不能<5㎡');
			return;
		}

		if(room_area>parseFloat(house_area)){
			alert('房间面积不能大于房屋总面积'+house_area);return;
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
			alert('请至少上传1张图片');return;
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
		/*视频上传，禁止提交*/
		var content = $("#upload_warning").text();
		if(content =="视频转码中,请稍后...") {
			return;
		}
		$("#submit_a").unbind("click").text("提交中..");
		$("#submitForm").submit();
	}


	var  rotate = 0;//初始化旋转角度
		//点击图片显示大图
		$("#imglist li").click(function(){
			/*var src=$(this).find('img').attr('src');
			var srcUrl=src.substring(0,src.indexOf('_'));
			var srcSuffix=src.slice(-4);
			var srcNew=srcUrl+srcSuffix;
			$(".bigImg").show();
			$(".housePic").attr("src",srcNew);*/
		});
		//点击旋转 旋转图片
		$(".rotate").click(function(){
			$(".housePic").css("transform","rotate("+(++rotate)*90+"deg)");
			$("#js_rotate").val(rotate);
		});
		$(".opacity").click(function(){
			rotate=0;
			$("#js_rotate").val("");
			$(this).parent().hide();
		})
		//保存上传
		$("#js_save").click(function(){
			var n_rotate=$("#js_rotate").val();
			var ImgUrl=$(".housePic").attr('src');
          	$.get("/hizhu/HouseRoom/rotateupload.html",{rotate:n_rotate,imgurl:ImgUrl},function(data){
          		     $("#js_save").text("上传中...");
    	   			 if(data.status==200){
    	   			 	 alert("上传成功");
    	   			     location.reload(); 
    	   			 }else{
    	   			 	 alert("上传失败");
    	   			 }
				},"json");
		});


</script>
</html>