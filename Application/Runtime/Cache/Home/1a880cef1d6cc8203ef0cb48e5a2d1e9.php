<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>首页置顶</title>
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
			
			<div class="common_main" style="padding:40px;">
				<h2><m style="font-weight:normal;">房间编号&nbsp;</m><input type="text" id="addRoomno" style="width:200px;height:28px;">&nbsp;&nbsp;<a style="margin-left:150px;" href="#" class="btn_a" id="addToproomBtn">新增置顶</a>&nbsp;</h2>
				<div class="table" id="dataDiv">
					<table>
						<thead>
							<tr>
								<th>房间编号</th>
								<th>小区名称</th><th>租金</th>
								<th>排序</th>
								<th>创建人</th>
								<th>创建时间</th>
								<th>取消置顶</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td data-id="<?php echo ($vo["id"]); ?>" data-sort="<?php echo ($vo["is_top"]); ?>"><?php echo ($vo["room_no"]); ?></td>
								<td><?php echo ($vo["estate_name"]); ?></td><td><?php echo ($vo["room_money"]); ?></td>
								<td><a href="javascript:;" class="moveup"><img src="/hizhu/Public/images/up.png" alt=""></a>&nbsp;&nbsp;<a href="javascript:;" class="movedown"><img src="/hizhu/Public/images/down.png" alt=""></a></td>
								<td><?php echo ($vo["create_man"]); ?></td>
								<td><?php if(($vo["toproom_createtime"] > 0)): echo (date("Y-m-d H:i",$vo["toproom_createtime"])); endif; ?></td>
								<td><a href="javascript:;" onclick="cancelSettopRoom('<?php echo ($vo["id"]); ?>')">取消置顶</a></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				
				</div>
			</div>
		</div>
	</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script type="text/javascript">

	/*新增置顶*/
	$("#addToproomBtn").click(function(){
		submit_addToproom();
	});
	function submit_addToproom(){
		var roomno=$("#addRoomno").val().replace(/\s+/g,"");
		if(roomno==""){
		    alert("请输入房间编号！");return false;
		}
		$("#addToproomBtn").unbind("click").text("提交中");
		$.post("/hizhu/HouseRoom/addToproomIndex",{room_no:roomno},function(data){
			alert(data.msg);
			if(data.status=="200"){
				window.location.reload();
			}else{
				$("#addToproomBtn").bind("click",function(){
					submit_addToproom();
				}).text("新增置顶");
			}
		},"json");
	}
	function cancelSettopRoom(pid){
		if(confirm("确认取消置顶吗？")){
			$.get("/hizhu/HouseRoom/unsetToproom",{id:pid},function(data){
				alert(data.msg);
				if(data.status=="200"){
					window.location.reload();
				}
			},"json");
		}
	}

</script>
<script type="text/javascript">
    $(document).ready(function () {
    	$('.movefirst').bind('click', function (e) {
            var obj = $(e.target).closest('tr');
            //c_to_first($(obj[0]));
        });
        $('.moveup').bind('click', function (e) {
            var obj = $(e.target).closest('tr');
            c_pre($(obj[0]));
        });
        $('.movedown').bind('click', function (e) {
            var obj = $(e.target).closest('tr');
            c_next($(obj[0]));
        });
    });
  
    function c_pre(o) {
        var pres = o.prevAll('tr');
        if (pres.length > 0) {
            var tmp = o.clone(true);
            var oo = pres[0];
            /*id,sort*/
            var idOne=$(oo).find('td:eq(0)').attr('data-id');
            var idTwo=$(o).find('td:eq(0)').attr('data-id');
            var sortOne=$(oo).find('td:eq(0)').attr('data-sort');
            var sortTwo=$(o).find('td:eq(0)').attr('data-sort');
            $.get("/hizhu/HouseRoom/moveUpDownTopRoom_v2",{id:idOne,sort_index:sortTwo,id2:idTwo,sort_index2:sortOne},function(data){
            	if(data.status!="200"){
            		alert(data.msg);
            	}
            },"json");
            $(tmp).find('td:eq(0)').attr('data-sort',sortOne);
            $(oo).find('td:eq(0)').attr('data-sort',sortTwo);
            o.remove();
            $(oo).before(tmp);
        }
    }
    function c_next(o) {
        var nexts = o.nextAll('tr');
        if (nexts.length > 0) {
            var tmp = o.clone(true);
            var oo = nexts[0];
            /*id,sort*/
            var idOne=$(oo).find('td:eq(0)').attr('data-id');
            var idTwo=$(o).find('td:eq(0)').attr('data-id');
            var sortOne=$(oo).find('td:eq(0)').attr('data-sort');
            var sortTwo=$(o).find('td:eq(0)').attr('data-sort');
            $.get("/hizhu/HouseRoom/moveUpDownTopRoom_v2",{id:idOne,sort_index:sortTwo,id2:idTwo,sort_index2:sortOne},function(data){
            	if(data.status!="200"){
            		alert(data.msg);
            	}
            },"json");
            $(tmp).find('td:eq(0)').attr('data-sort',sortOne);
            $(oo).find('td:eq(0)').attr('data-sort',sortTwo);
            o.remove();
            $(oo).after(tmp);
        }
    }
    function c_end(o) {
        var nexts = o.nextAll('tr.queue');
        if (nexts.length > 0) {
            var tmp = o.clone(true);
            var oo = nexts[nexts.length - 1];
            o.remove();
            $(oo).after(tmp);
        }
    }
    function addToQue(e) {
        var otd = $(e).closest('td');
        var otr = $(e).closest('tr');
        $(otd).empty();
        $(otr).find('td.sort').append($('#MovContHid').children().clone(true));
        $(otr).attr('class', "queue");
        $(otr).find('.status').html('排队等候');
        var checkStr = "";
        if ($('#CheckAll').attr('checked')) checkStr = 'checked="checked"';
        $(otr).find('td.sel').html('<input type="checkbox" ' + checkStr + '/>');
        c_end($(otr));
        return false;
    }
    function removeTR() {
        $('tr.queue>td.sel>:input:checked').closest('tr').remove();
    }
</script>
</html>