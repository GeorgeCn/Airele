<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>问题房东</title>
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
				<h2>问题房东查询</h2>
				<div class="common_head_main">
					<form action="<?php echo U('IssueOwner/issueownerlist');?>" method="get">
					<input type="hidden" name="no" value="3"/>
					<input type="hidden" name="leftno" value="99"/>
						<table class="table_one">
							<tr>
								<td class="td_title">处理时间：</td>
								<td class="td_main"><input class="inpt_a" type="text" name="startTime" id="datetimepicker" value="<?php echo $_GET['startTime'] ?>">&nbsp;~&nbsp;<input class="inpt_a" type="text"  name="endTime" id="datetimepicker1" value="<?php echo $_GET['endTime'] ?>"></td>
								<td class="td_title">房东手机号：</td>
								<td class="td_main"><input type="text" name="ownermobile" value="<?php echo $_GET['ownermobile'] ?>"></td>
								<td class="td_title"></td>
								<td class="td_main"></td>
							</tr>
						</table>
						<p class="head_p"><button class="btn_a">搜索</button></p>
					</form>
				</div>
			</div>
			<div class="common_main">
				<h2>问题房东列表 <a href="/hizhu/IssueOwner/downloadExcel?<?php echo $_SERVER['QUERY_STRING'];?>" class="btn_a">下载</a></h2>
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>序号</th>
								<th>房东手机</th>
								<th>400号码</th>
								<th>问题次数</th>
								<th>是否付费</th>
								<th>房东负责人</th>
								<th>查看联系记录</th>
								<th>是否处理</th>
								<th>备注</th>
								<th>处理人</th>
								<th>处理时间</th>
							</tr>
						</thead>
						<tbody>
							  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?></td>
								<?php if(strtoupper($ruleauth['roomauth']) == '1'): ?><td><a href="/hizhu/HouseRoom/searchroom.html?no=3&leftno=44&clientPhone=<?php echo ($vo['owner_mobile']); ?>&delState=1" target="_blank"><?php echo ($vo['owner_mobile']); ?></a></td>
								<?php else: ?>
								   <td><?php echo ($vo['owner_mobile']); ?></td><?php endif; ?>
								<td><?php if(strtoupper($vo['big_code']) != ''): echo ($vo['big_code']); ?>-<?php echo ($vo['ext_code']); endif; ?></td>
								<td><?php echo ($vo['times']); ?></td>
								<td></td>
								<td></td>
								<?php if(strtoupper($ruleauth['conowner']) == '1'): ?><td><a href="/hizhu/ContactOwner/contactOwnerList.html?no=3&leftno=28&temp=q&ownerphone=<?php echo ($vo['owner_mobile']); ?>&unknown=on&abandon=on" target="_blank">查看联系记录</a></td>
								<?php else: ?>
							    	<td>查看联系记录</td><?php endif; ?>
							    <td><?php if($vo['status_code'] == '0'): ?><a href="javascript:;" onclick="upstatus('<?php echo ($vo['id']); ?>','<?php echo ($vo['owner_id']); ?>',1,this);">批量下架</a>&nbsp&nbsp&nbsp&nbsp<a href="javascript:;" onclick="upstatus('<?php echo ($vo['id']); ?>','<?php echo ($vo['owner_id']); ?>',2,this);">通过</a><?php elseif($vo['status_code'] == '1'): ?>已处理<?php endif; ?></td>
							   	<td>
							   		<?php if(strtoupper($vo['memo']) == ''): ?><a href="javascript:;" onclick="AddMemo('<?php echo ($vo['id']); ?>',this);">添加备注</a>
							   		<?php else: ?>
							   		<?php echo ($vo['memo']); endif; ?>
							   	</td>
							   	<td><?php echo ($vo['handle_man']); ?></td>
								<td><?php if(strtoupper($vo['handle_time']) != 0): echo (date("Y-m-d H:i:s",$vo['handle_time'])); endif; ?></td>
								<input type="hidden" name="owner_id" value="<?php echo ($vo['owner_id']); ?>">
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							<input type="hidden" name="pid" value="" id="js_pid">
						</tbody>
					</table>
					<div class="skip cf">
						<p class="fl skip_left">共<?php echo ($pagecount); ?>条记录，每页15条 &nbsp;&nbsp;</p>
						<p class="fr skip_right">
							<?php echo ($show); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="addReply" style="display:none;">
		<div class="addReply_main" style="height:230px;">
				<div class="cf reply_text">
					<span></span>
					<textarea name="reply_content" id="reply_content" style="margin-left:100px;"></textarea>
				</div>
				
				<div class="anniu cf">	
					<a href="javascript:;" class="anniu_back">取消</a>
					<button class="anniu_add">提交</button>
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
    </script>
    <script type="text/javascript">
		   function upstatus(problems_id,owner_id,type,object){
		   	     if(type==1){
		   	        var message="确认批量下架所有房间?";
		   	     }else if(type==2){
		   	     	var message="确认通过？";
		   	     }
		   		if(confirm(message)){
	               $.get("/hizhu/IssueOwner/upproblemsstatus.html",{problems_id:problems_id,owner_id:owner_id,type:type},function(data){
	               	    if(data.status=="200"){
	               	    	$(object).parent().text("已处理");
	               	    }
					},"json");
              }
           }

          function AddMemo(problems_id,object){
               $(".addReply").show();
                $("#js_pid").val(problems_id);
               $(".anniu_add").click(function(){
               	  var reply_content=$("#reply_content").val();
               	  var pb_id=$("#js_pid").val();
               	  if(reply_content==""){
               	  	alert("请填写备注");
               	  	return false;
               	  }
                  $.get("/hizhu/IssueOwner/addmemodata.html",{problems_id:pb_id,content:reply_content},function(data){
		       			if(data.status=200){
		       				$(object).parent().text(reply_content);
		       				$(".addReply").hide();
		       				$("#reply_content").val("");
		       				 $("#js_pid").val("");
		       			}
			       },"json");
               })
          }

         $(".anniu_back").on("click",function(){
		       $(".addReply").hide();
		       $("#reply_content").val("");
		        $("#js_pid").val("");
		        location.reload();
		   })

       $(".table table tr").each(function(index,object){
		  	var reply='';
		    var owner_id=$(object).find("input[name='owner_id']").val();
	      if(owner_id!="undefined"&&owner_id!=""){
		    $.get("/hizhu/IssueOwner/getownerdata.html",{owner_id:owner_id,index:index},function(data){
		          $(".table table").find("tr:eq("+index+")").children("td:eq(4)").text(data.pay_type);
		       	  $(".table table").find("tr:eq("+index+")").children("td:eq(5)").text(data.principal_man);
			  },"json");
		    }
	   });


    </script>
</body>
</html>