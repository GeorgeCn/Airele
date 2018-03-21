<?php if (!defined('THINK_PATH')) exit();?> <html>
<head>
	<meta charset="utf-8">
	<title>端口配置管理</title>
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
				<h2>端口配置查询</h2>
				<div class="common_head_main">
				<form action="<?php echo U('HizhuParameter/portConfigureList');?>" method="get">
						<input type="hidden" name="no" value="1">
						<input type="hidden" name="leftno" value="209">
					<table class="table_one">
						<tr>
							<td class="td_title">类型：</td>
							<td class="td_main">
								<select name="is_owner">
									<option value=""<?php if(I('get.is_owner')== ""){echo"selected";}?>>全部</option>
									<option value="4"<?php if(I('get.is_owner')== 4){echo"selected";}?>>职业房东</option>
									<option value="5"<?php if(I('get.is_owner')== 5){echo"selected";}?>>中介</option>
								</select>
							</td>
							<td class="td_title">是否删除：</td>
							<td class="td_main">
								<select name="record_status">
									<option value="1"<?php if(I('get.record_status')=="1"){echo"selected";}?>>全部</option>
									<option value="1"<?php if(I('get.record_status')=="1"){echo"selected";}?>>未删除</option>
									<option value="0"<?php if(I('get.record_status')=="0"){echo"selected";}?>>已删除</option>
								</select>
							</td>
							<td class="td_title"></td>
							<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button type="submit" class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>配置列表<a href="/hizhu/HizhuParameter/portConfigureAdd.html?no=1&leftno=209" class="btn_a" style="min-width: 50px">新增</a>
				</h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>端口类型</th>
								<th>时间长度(月)</th>
								<th>可在架房源数</th>
								<th>价格</th>
								<th>排序</th>
								<th>优惠</th>
								<th>状态</th>
								<th>添加人</th>
								<th>添加时间</th>
								<th>删除</th>
							</tr>
						</thead>
						<tbody>
						  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<td>
									<?php switch($vo["is_owner"]): case "4": ?>职业房东<?php break;?>
										<?php case "5": ?>中介<?php break;?>
										<?php default: ?>空<?php endswitch;?></td>
								<td><?php echo ($vo['timelimit']); ?></td>
								<td><?php echo ($vo['house_num']); ?></td>
								<td><?php echo ($vo['price']); ?></td>
								<td><?php echo ($vo['sort_index']); ?></td>
								<td><?php echo ($vo['coupon_title']); ?></td>
								<td>
									<?php switch($vo["record_status"]): case "0": ?>已删除<?php break;?>
										<?php case "1": ?>未删除<?php break; endswitch;?></td>
								</td>
								<td><?php echo ($vo['create_man']); ?></td>
								<td>
									<?php if(($vo["create_time"]) > "0"): echo (date("Y-m-d H:i",$vo['create_time'])); endif; ?>
								</td>
								<td>
									<?php if($vo["record_status"] == 1): ?><a href="javascript:;" onclick="DeleteById('<?php echo ($pagecount); ?>','<?php echo ($vo["id"]); ?>')" class="btn_a" style="margin:0px 20px 5px 20px">&nbsp;删除&nbsp;</a>
									<?php elseif($vo["record_status"] == 0): ?>已删除<?php endif; ?>
								</td>
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
	function DeleteById(count,id,obj){
 	  if(confirm('确定删除吗？')){
			$.get("/hizhu/HizhuParameter/portConfigureDelete.html",{"id":id,"record_status":0},function(data){
				if(data.code == 404) {
				        alert(data.message);
				    } 
					if(data.code == 400) {
				        alert(data.message);
				    }
				    if(data.code == 200) {
				        alert(data.message);	
					$(obj).parent().parent().remove();
	            }
			},"json");
			$('#count').html("共"+(count-1)+"条记录，每页10条");
		}
   	}
	</script>
</body>
</html>