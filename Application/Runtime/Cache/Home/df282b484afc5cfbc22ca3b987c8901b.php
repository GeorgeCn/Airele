<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>APP首页参数管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/parameter_management_house.css">

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
			<a class="blue" href="javascript:">欢迎您 <?php echo getLoginName();?></a>
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
				<h2>首页入口</h2>
					<form action="/hizhu/ParamSet/appindexview.html" method="get">
				   <input type="hidden" name="no" value="1">
				    <input type="hidden" name="leftno" value="86">
						<table class="table_one" style="margin-top:0px">
						<tr>
							<td class="td_title">版本：</td>
							<td class="td_main">
								<select name="ver_no">
								 <option value="">全部</option>
								  <?php if(is_array($curverarr)): $i = 0; $__LIST__ = $curverarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['curver']); ?>" <?php if($_GET['ver_no']==$vo['curver']){echo "selected";}?>><?php echo ($vo['curver']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>&nbsp;&nbsp;&nbsp;
								
							</td>
							<td class="td_title">入口名：</td>
							<td class="td_main"><input name="name" value="<?php echo I('get.name');?>"></td>
						</tr>
					</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
					 </form>
				</div>
				<div class="common_main">
					<h2>首页入口列表 <a href="/hizhu/ParamSet/addtemp.html?no=1&leftno=86" class="btn_a">新增入口</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>入口名</th>
								<th>图标</th>
								<th>排序</th>
								<th>显示/隐藏</th>
								<th>跳转地址</th>
								<th>模块</th><th>版本号</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo['module_name']); ?></td>
								<td><img style="width:100px;heigth:40px;" src="<?php echo ($vo['img_url']); ?>"></td>
								<td><?php echo ($vo['sort_index']); ?></td>
								<td><?php if(($vo['is_display']) == "1"): ?>显示<?php else: ?>隐藏<?php endif; ?></td>
								<td><a href="<?php echo ($vo['module_url']); ?>" target="_blank"><?php echo ($vo['module_url']); ?></a></td>
								<td><?php switch($vo["mid"]): case "1": ?>合租<?php break; case "1": ?>合租<?php break; case "2": ?>整租<?php break; case "3": ?>付房租<?php break; case "4": ?>服务<?php break; case "5": ?>发房<?php break; case "6": ?>看房日程<?php break; case "7": ?>收藏<?php break; case "8": ?>在线签约<?php break; case "8": ?>在线签约<?php break; case "9": ?>房东推荐<?php break; case "10": ?>公寓<?php break; case "999": ?>首页广告<?php break; endswitch;?></td><td><?php echo ($vo['ver_no']); ?></td>
								<td><a href="javascript:;" onclick="if(confirm('确定要删除吗？')){deletedata(<?php echo ($vo['id']); ?>);}">删除</a>&nbsp;&nbsp;<a href="/hizhu/ParamSet/updatetemp.html?id=<?php echo ($vo['id']); ?>no=1&leftno=86">修改</a></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				
				</div>
			</div>
			</div>
			
		</div>
	</div>
 <script src="/hizhu/Public/js/jquery.js"></script>
 <script src="/hizhu/Public/js/common.js"></script>
 <script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
	$("#fileupload").change(function(){
		$("#submitForm").ajaxSubmit({
			dataType:  'json',
			data:{submitType:'upload'},
			beforeSend: function() {
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(result) {
				//console.log(result);
				$("#imglist").append('<li><img style="dispaly:inline-block;" src="'+result.data.imgUrl+'"><input type="hidden" name="bright" value="'+result.data.imgUrl+'" /></li>');
				$("#fileupload").val('');
				$("input[name='img_url']").val(result.data.imgUrl);
			},
			error:function(xhr){
				alert(xhr.responseText);
			}
		});
	});
	$(".btn_a").bind("click",function(){
		submitdata();
	});
	function submitdata(){
		var info=$("input[name='module_name']").val().replace(/\s+/g,'');
		if(info==""){
			alert("入口名必填项");return;
		}
		info=$("input[name='img_url']").val();
		if(info==""){
			alert("图标必填项");return;
		}
		info=$("input[name='sort_index']").val();
		if(info==""){
			alert("排序必填项");return;
		}
		if($("#ver_no").val()==""){
			alert("版本号必填项");return;
		}
		var regNum=/^\d{1,3}$/;
		if(!regNum.test(info)){
			alert("排序填写有误");return;
		}
		$(".btn_a").unbind("click").text("提交中");
		$("form").submit();
	}
	function deletedata(pid){
		$.post('/hizhu/ParamSet/removeAppindex',{pid:pid},function(data){
			if(data.status!="200"){
				alert(data.msg);
			}window.location.reload();
		},'json');
	}
	function editdata(pid,name,img_url,sort,isshow,url,mid,ver_no){
		$("input[name='pid']").val(pid);
		$("input[name='module_name']").val(name);
		$("input[name='module_url']").val(url);
		$("input[name='img_url']").val(img_url);
		$("input[name='sort_index']").val(sort);
		$("input[name='is_display'][value="+isshow+"]").attr("checked","checked");
		$("#mid").val(mid);
		$("#ver_no").val(ver_no);
	}
</script>
</body>
</html>