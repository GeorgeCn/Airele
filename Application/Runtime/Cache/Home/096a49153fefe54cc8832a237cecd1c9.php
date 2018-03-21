<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>已回复列表</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/plug/jquery.datetimepicker.css"/>
    <style type="text/css">
   .js_days{display: none;}
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
				<h2>已回复搜索</h2>
				<form action="/hizhu/Asklistsendlog/yetreply.html" method="get">
					<input type="hidden" name="no" value="141">
					<input type="hidden" name="leftno" value="106">
					<table class="table_one">
						<tr>
							<td class="td_title">处理状态：</td>
							<td class="td_main">
								<select name="handlestatus">
									<option value="0" <?php if(strlen($_GET['handlestatus'])==1&&$_GET['handlestatus']!=1){echo "selected";}?>>未处理</option>
									<option value="1" <?php if($_GET['handlestatus']==1){echo "selected";}?>>已处理</option>
								</select>	
							</td>
							<td class="td_title" >回复时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo $_GET['startTime'];?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="endTime" id="datetimepicker1" value="<?php echo $_GET['endTime'];?>"></td>
							<td class="td_title">接收手机：</td> 
					    	<td class="td_main"><input type="text"  name="mobile"  value="<?php echo I('get.mobile');?>"/></td>
						</tr>
						<tr>
							<td class="td_title" >收到短信：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="content" value="<?php echo I('get.content');?>"></td>
							<td class="td_title" >发送手机：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="sendno" value="<?php echo I('get.sendno');?>"></td>
							<td class="td_title" >操作状态：</td>
							<td class="td_main">
								<select name="opstatus">
									<option value="">全部</option>
									<option value="1" <?php if($_GET['opstatus']==1){echo"selected";}?>>已出租</option>
									<option value="2" <?php if($_GET['opstatus']==2){echo"selected";}?>>更新房间</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="td_title" >发送时间：</td>
							<td class="td_main"><input class="inpt_a" type="text" name="pushstartTime" id="datetimepicker2" value="<?php echo $_GET['pushstartTime'];?>">&nbsp;~&nbsp;<input class="inpt_a" type="text" name="pushendTime" id="datetimepicker3" value="<?php echo $_GET['pushendTime'];?>"></td>
							<td class="td_title"></td>
							<td class="td_main"></td>
							<td class="td_title"></td> 
					    	<td class="td_main"></td>
						</tr>
					</table>
					<p class="head_p"><button class="btn_a">搜索</button></p>
				 </form>
				  
				</div>
				<div class="common_main">
				<h2>已回复列表<a href="/hizhu/Asklistsendlog/downloadExcel.html?<?php echo $_SERVER["QUERY_STRING"];?>" class="btn_a">下载</a>
				<a href="javascript:;" class="btn_a" style="min-width: 80px;margin-left:100px" onclick="oneKeyUpHouse();">一键更新房间</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								
								<th>房间编号</th>
								<th>房间名称</th>
								<th>价格</th>
								<th>创建日期</th>
								<th>更新日期</th>
								<th>数据来源</th>
								<th>发送手机</th>
								<th>接收手机</th>
								<th>发送短信</th>
					            <th>收到短信</th>
					            <th>查看房源</th>
					             <th>职业房东</th>
								<th>已出租</th>
								<th>更新房间</th>
								
								<th>发送时间</th>
							   <th>回复时间</th>
							  
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><?php echo ($vo['send_no']); ?></td>
								<td><?php echo ($vo['mobile']); ?></td>
								<td><?php echo ($vo['push_content']); ?></td>
								<td><?php echo ($vo['content']); ?></td>
								<td></td>
								<td></td>
								<td></td>
								<?php if($vo['is_update'] == '1'): ?><td>更新房间</td>
								<?php else: ?>	
								<td><a href="javascript:;" onclick="upHouse('<?php echo$vo['room_id'];?>','<?php echo$vo['id'];?>');">更新房间</a></td><?php endif; ?>
								
								<td><?php echo (date("Y-m-d H:i:s",$vo['push_time'])); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
								<input name="id" type="hidden" value="<?php echo ($vo['id']); ?>">
								<input name="room_id" type="hidden" value="<?php echo ($vo['room_id']); ?>">
								<input name="ownermobile" type="hidden" value="<?php echo ($vo['mobile']); ?>">
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				        <div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页5条</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
			</div>
			
		</div>
	</div>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/plug/jquery.datetimepicker.js"></script>

<script type="text/javascript">
	$('#datetimepicker').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker1').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker2').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
	$('#datetimepicker3').datetimepicker({step:10,lang:'ch',timepicker:false,format:"Y-m-d"});
</script>
<script type="text/javascript">
    $(".table table tr").each(function(index,object){
    	var id=$(object).find("input[name='id']").val();
    	var room_id=$(object).find("input[name='room_id']").val();
    	var reply='<?php echo $_GET['reply']?>';
    	if(room_id!="undefined"&&room_id!=""){
	        $.get("/hizhu/Asklistsendlog/jsonhouseroom.html",{room_id:room_id,index:index},function(data){
	        		
					if(data!=null){	
						$(".table table").find("tr:eq("+index+")").children("td:eq(11)").html('<a href="/hizhu/HouseResource/addresource?resource_id='+data.resource_id+'" target="_blank">查看房源</a>');
						$(".table table").find("tr:eq("+index+")").children("td:eq(1)").html('<a href="/hizhu/HouseRoom/modifyroom?no=3&leftno=44&room_id='+room_id+'&handle=search" target="_blank">'+data.room_no+'</a>');
						$(".table table").find("tr:eq("+index+")").children("td:eq(2)").text(data.room_name);
						$(".table table").find("tr:eq("+index+")").children("td:eq(3)").text(data.room_money);
						$(".table table").find("tr:eq("+index+")").children("td:eq(4)").text(data.create_time);
					    $(".table table").find("tr:eq("+index+")").children("td:eq(5)").text(data.update_time);
					    $(".table table").find("tr:eq("+index+")").children("td:eq(6)").text(data.info_resource);
					   if(data.status==3){
					   	   	     $(".table table").find("tr:eq("+index+")").children("td:eq(13)").text("已出租");
						   		 $(".table table").find("tr:eq("+index+")").children("td:eq(14)").text("更新房间");
					   }else if(data.status==2){
					   	     	$(".table table").find("tr:eq("+index+")").children("td:eq(13)").html('<a href="javascript:;" onclick="yetRent('+"'"+id+"','"+room_id+"'"+');">已出租</a>');
					   	    // $(".table table").find("tr:eq("+index+")").children("td:eq(10)").html('<a href="javascript:;" onclick="upHouse('+"'"+room_id+"'"+');">更新房间</a>');
					   }
					}
				},"json");
	    }
	});

 function yetRent(id,roomid){
 	  if(confirm("确认更新房间状态为已出租？")){
     		$.get("/hizhu/Asklistsendlog/uphouserroom.html",{id:id,roomid:roomid,uptype:1},function(data){
    	   		  alert(data.msg);
    	   		  location.reload(); 
				},"json");
     	}
     }
     function upHouse(roomid,id){
     	if(confirm("确认更新房间时间？")){
     		$.get("/hizhu/Asklistsendlog/uphouserroom.html",{roomid:roomid,id:id,uptype:2},function(data){
    	   			 alert(data.msg);
    	   			 location.reload(); 
				},"json");
     	}
     }

   function upLogHouse(roomid,id){
   		if(confirm("确认更新房间时间？")){
     		$.get("/hizhu/Asklistsendlog/uploghouserroom.html",{roomid:roomid,id:id},function(data){
    	   			 alert(data.msg);
				},"json");
     	}
   }

   function oneKeyUpHouse() {
   		if(confirm("确认一键更新所有房间？")) {
   			$.ajax({
					type:"get",
					url:"<?php echo U('Asklistsendlog/uphouserroom');?>",
					data:{"uptype":3},
					dataType:"json",
					success:function (data) {	
						alert(data.msg);
					}
				})
     	}
   }

  $(".table table tr").each(function(index,object){
  	var reply='<?php echo $_GET['reply']?>';
    var ownermobile=$(object).find("input[name='ownermobile']").val();
      if(ownermobile!="undefined"&&ownermobile!=""){
	    $.get("/hizhu/Asklistsendlog/professionalowner.html",{ownermobile:ownermobile,index:index},function(data){
	      var is_owner=data.is_owner;
	       if(is_owner==4){
	          $(".table table").find("tr:eq("+index+")").children("td:eq(12)").text("职业房东");
	       }else if(is_owner==9){
	       	  $(".table table").find("tr:eq("+index+")").children("td:eq(12)").text("疑似职业房东");
	       }else{	
		      	/*疑似职业房东*/
		      $(".table table").find("tr:eq("+index+")").children("td:eq(12)").html('<a href="#" onclick="confirmJobowner(\''+ownermobile+'\')">新增职业房东</a>');
	       }
	  
		  },"json");
	    }
	});

  function prOwner(id,ownermobile){
  	if(confirm("确认设置为职业房东？")){
     	$.get("/hizhu/Asklistsendlog/upprowner.html",{id:id,ownermobile:ownermobile},function(data){
    	   	 if(data.status==200){
    	   	     location.reload(); 
    	   	 }
		},"json");
     }
  }
  function confirmJobowner(ownermobile){
     	$.get("/hizhu/Asklistsendlog/setConfirmJobowner?ownermobile="+ownermobile,function(data){
			alert(data);
			//location.reload(); 
		});
     
  }

</script>
</body>
</html>