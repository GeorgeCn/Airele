<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>添加楼盘</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/audit_rent_orders.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=f8RAB6WGc4OEdZLAl4t0kcdt"></script>
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
			<div id="allmap" style="width:800px;height:400px;display:none;"></div>
			<div class="common_main">
				<form id="submitForm" action="/hizhu/Estate/submitestate.html" method="post">
				<table class="table_one table_two">
					<tr>
						<td class="td_title"><span>*</span>楼盘名称：</td>
						<td class="td_main">
							<input type="text" id="estate_name" name="estate_name"  class="plotIpt" style="width:50%;">&nbsp;<!-- <a href="#" class="btn_a" id="btnGetinfo">获取信息</a> -->
							<div id="estate_div" class="plotbox" style="width:90%;">
								<ul>
									
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼盘地址：</td>
						<td class="td_main"><input type="text" name="estate_address" class="smallwidth" style="width:50%;"></td>
					</tr>
					<tr>
						<td class="td_title">&nbsp;品牌公寓：</td>
						<td class="td_main">
							<select  name="brand_type" id="js_brand_type">
								<option value="">请选择</option>
								<?php echo ($brandtype); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>区域：</td>
						<td>
							<input type="hidden" name="region_name">
							<select name="region" id="js_region">
							   <option value="">请选择</option>
							   <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['id']); ?>"><?php echo ($vo['cname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						   </select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>板块：</td>
						<td class="td_main">
							<input type="hidden" name="scope_name">
							<select name="scope" id="js_scope">
							   <option value="">请选择</option>
							   
						   </select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼盘名称全拼：</td>
						<td class="td_main"><input type="text" name="full_py" class="smallwidth" style="width:50%;"><span>*  填写小写字母</span></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>楼盘首字母：</td>
						<td class="td_main"><input type="text" name="first_py" class="smallwidth" style="width:50%;"><span>*  填写大写字母</span></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>坐标（经度）：</td>
						<td class="td_main"><input type="text" name="lpt_x" class="smallwidth" style="width:30%;"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>坐标（纬度）：</td>
						<td class="td_main"><input type="text" name="lpt_y" class="smallwidth" style="width:30%;"></td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>业务类型：</td>
						<td class="td_main">
							<select  name="business_type" id="js_business_type">
								<option value="">请选择</option>
								<?php echo ($businessTypeList); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_title"><span>*</span>房屋类型：</td>
						<td class="td_main">
							<select  name="house_type" id="js_house_type">
								<option value="">请选择</option>
								<?php echo ($housetype); ?>
							</select>
						</td>
					</tr>
					<tr><td rowspan="5" class="td_title"><span>&nbsp;</span>地铁：</td>
						<td class="td_main">
						<select  name="subwayline1" data-index="#subway1" id="subwayline1"><option value="">请选择</option><?php echo ($subwaylineList); ?></select>&nbsp;
						<select  name="subway1" id="subway1"><option value="">请选择</option></select>&nbsp;
						<input type="text" name="subway_distance1" maxlength="5">&nbsp;(距离：米)
						</td></tr>
					<tr><td class="td_main">
						<select  name="subwayline2" data-index="#subway2" id="subwayline2"><option value="">请选择</option><?php echo ($subwaylineList); ?></select>&nbsp;
						<select  name="subway2" id="subway2"><option value="">请选择</option></select>&nbsp;
						<input type="text" name="subway_distance2" maxlength="5">&nbsp;(距离：米)
						</td></tr>
					<tr><td class="td_main">
						<select  name="subwayline3" data-index="#subway3" id="subwayline3"><option value="">请选择</option><?php echo ($subwaylineList); ?></select>&nbsp;
						<select  name="subway3" id="subway3"><option value="">请选择</option></select>&nbsp;
						<input type="text" name="subway_distance3" maxlength="5">&nbsp;(距离：米)
					</td></tr>
					<tr><td class="td_main">
						<select  name="subwayline4" data-index="#subway4" id="subwayline4"><option value="">请选择</option><?php echo ($subwaylineList); ?></select>&nbsp;
						<select  name="subway4" id="subway4"><option value="">请选择</option></select>&nbsp;
						<input type="text" name="subway_distance4" maxlength="5">&nbsp;(距离：米)
					</td></tr>
					<tr><td class="td_main">
						<select  name="subwayline5" data-index="#subway5" id="subwayline5"><option value="">请选择</option><?php echo ($subwaylineList); ?></select>&nbsp;
						<select  name="subway5" id="subway5"><option value="">请选择</option></select>&nbsp;
						<input type="text" name="subway_distance5" maxlength="5">&nbsp;(距离：米)
					</td></tr>
				</table>
				</form>
				<div class="addhouse_next"><button class="btn_a" id="btn_submit">提交</button></div>
				
			</div>
		</div>
</body>
<script src="/hizhu/Public/js/jquery.js"></script>
<script src="/hizhu/Public/js/common.js"></script>
<script src="/hizhu/Public/js/jquery.form.js"></script>
<script type="text/javascript">
	//TODO;新增城市
	var select_city=$(".citySelect").find('select').val();
	if(select_city=="2"){
		select_city="北京";
	}else if(select_city=="3"){
		select_city="杭州";
	}else if(select_city=="4"){
		select_city="南京";
	}else if(select_city=="6"){
		select_city="深圳";
	}else{
		select_city="上海";
	}
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var mPoint = new BMap.Point(121.476,31.240);
	map.centerAndZoom(mPoint, 12);
	$("#btnGetinfo").click(function () {
		getSearchEstate();
	});
	function getSearchEstate(){
		var input_value=$("input[name='estate_name']").val();
       	if(input_value==""){
       		return;
       	}
       	$("#btnGetinfo").unbind('click').text('获取中');
		var local = new BMap.LocalSearch(select_city, 
						{onSearchComplete: function(results){    
							if (local.getStatus() == BMAP_STATUS_SUCCESS){      
					            // 判断状态是否正确        
					            var obj=$("#estate_div ul");
					            obj.html("");
					            for (var i = 0; i < results.getCurrentNumPois(); i ++){       
					                obj.append("<li onclick=\"getinfo('"+results.getPoi(i).title+"','"+results.getPoi(i).address+"','"+results.getPoi(i).point.lng+"','"+results.getPoi(i).point.lat+"')\" >"+results.getPoi(i).title+"--"+results.getPoi(i).address+"</li>");
					            }    
					            $("#estate_div").show();        
					         }else{
								$("#estate_div").hide();
								alert("没有搜索结果");
							  }
							  $("#btnGetinfo").bind('click',function(){
							  	getSearchEstate();
							  }).text('获取信息');
	                      	}

                      	}
		         	); 
		local.search(input_value,{forceLocal:true});
	}
	//map.addOverlay(new BMap.Marker(mPoint));
    function getinfo(name,address,lpt_x,lpt_y){
    	$("#estate_div").hide();
       	//clear data
       	map.clearOverlays();
       	$("input[name='estate_name']").val(name);
       	$("input[name='estate_address']").val(address);
       	$("input[name='lpt_x']").val(lpt_x);
       	$("input[name='lpt_y']").val(lpt_y);
       	$("input[name='full_py']").val("");
       	$("input[name='first_py']").val("");
       	$("select[name^='subwayline']").each(function(){
       		$(this).val('');
       	});
       	$("select[name^='subway']").each(function(){
       		$(this).val('');
       	});
       	$("input[name^='subway_distance']").each(function(){
       		$(this).val('');
       	});

       	$.get('/hizhu/Estate/convert_pinyin?estate_name='+name,function(data){
       		$("input[name='full_py']").val(data.full_py);
       		$("input[name='first_py']").val(data.first_py);
       	},'json');
       		//地铁信息 
       		/*point=[];//JSON.parse('{"lng":'+lpt_x+',"lat":'+lpt_y+'}');
       		point.push(['lng',lpt_x]);
       		point.push(['lat',lpt_y]);*/
       		var point = new BMap.Point(lpt_x,lpt_y);
       		
       		/*map.centerAndZoom(point, 15);
       		map.addOverlay(new BMap.Marker(point));*/
       		var options = {      
       		      onSearchComplete: function(results){      
       		      	//console.log(JSON.stringify(results));
       		          if (local.getStatus() == BMAP_STATUS_SUCCESS){      
       		                // 判断状态是否正确      
       		                var s = [];      var list=[];
       		                for (var i = 0; i < results.getCurrentNumPois(); i ++){      
       		                	list = list.concat(results.getPoi(i));
       		                }      
       		                 list = list.sort(function(p1, p2){
       		                        return map.getDistance(point, p1.point) - map.getDistance(point, p2.point);
       		                    });
       		                if(list.length>0){
       	                 	   //s.push(list[j].title + ", " + list[j].address+ ", " + map.getDistance(point, list[j].point).toFixed()+"米");   
       	                 	   var subway_line=list[0].address.replace(/地铁/g,''); 
       	                 	   var subway=list[0].title;
       	                 	   var distance= map.getDistance(point, list[0].point).toFixed();
       	                 	   console.log(subway_line+'|'+subway+'|'+distance);
       	                 	   if(subway_line.split('; ').length>1){
       	                 	   		//多个地铁线路
       	                 	   		var line_array=subway_line.split('; ');
       	                 	   		if(line_array.length==2){
       	                 	   			bindSubway_1(line_array[0],subway,distance);
       	                 	   			bindSubway_2(line_array[1],subway,distance);
       	                 	   		}else if(line_array.length>=3){
       	                 	   			bindSubway_1(line_array[0],subway,distance);
       	                 	   			bindSubway_2(line_array[1],subway,distance);
       	                 	   			bindSubway_3(line_array[2],subway,distance);
       	                 	   		}
       	                 	   }else{
       	               				bindSubway_1(subway_line,subway,distance);
       	                 	   }
       	                 	}
       		          }      
       		      }      
       		 };      
       		var local = new BMap.LocalSearch(select_city, options); 
       		var circle = new BMap.Circle(point, 3000, {strokeColor: "transparent", fillColor: "transparent" });
       		var bounds = getSquareBounds(circle.getCenter(), circle.getRadius());
       	    local.searchInBounds("地铁站", bounds);
       
       }
    /**
     * 得到圆的内接正方形bounds
     * @param {Point} centerPoi 圆形范围的圆心
     * @param {Number} r 圆形范围的半径
     * @return 无返回值
     */
    function getSquareBounds(centerPoi, r) {
        var a = Math.sqrt(2) * r; //正方形边长
        mPoi = getMecator(centerPoi);
        var x0 = mPoi.x, y0 = mPoi.y;

        var x1 = x0 + a / 2, y1 = y0 + a / 2;//东北点
        var x2 = x0 - a / 2, y2 = y0 - a / 2;//西南点

        var ne = getPoi(new BMap.Pixel(x1, y1)), sw = getPoi(new BMap.Pixel(x2, y2));
        return new BMap.Bounds(sw, ne);
    }
    //根据球面坐标获得平面坐标。
    function getMecator(poi) {
        return map.getMapType().getProjection().lngLatToPoint(poi);
    }
    //根据平面坐标获得球面坐标。
    function getPoi(mecator) {
        return map.getMapType().getProjection().pointToLngLat(mecator);
    }
</script>
<script type="text/javascript">
	function bindSubway_1(subway_line,subway,distance){
		$('#subwayline1 option:contains('+subway_line+')').each(function(){
		  if ($(this).text() == subway_line) {
		     $(this).attr('selected', true);
		  }
		});
		if($("#subwayline1").val()==''){
			return;
		}
		$.get("/hizhu/Estate/getSubwayByLine",{subwayline_id:$("#subwayline1").val()},function(data){
			$("#subway1").append(data);
			$('#subway1 option:contains('+subway+')').each(function(){
			  if ($(this).text() == subway) {
			     $(this).attr('selected', true);
			  }
			});
			$("input[name='subway_distance1']").val(distance);
		},"html");
	}
	function bindSubway_2(subway_line,subway,distance){
		$('#subwayline2 option:contains('+subway_line+')').each(function(){
		  if ($(this).text() == subway_line) {
		     $(this).attr('selected', true);
		  }
		});
		$.get("/hizhu/Estate/getSubwayByLine",{subwayline_id:$("#subwayline2").val()},function(data){
			$("#subway2").append(data);
			$('#subway2 option:contains('+subway+')').each(function(){
			  if ($(this).text() == subway) {
			     $(this).attr('selected', true);
			  }
			});
			$("input[name='subway_distance2']").val(distance);
		},"html");
	}
	function bindSubway_3(subway_line,subway,distance){
		$('#subwayline3 option:contains('+subway_line+')').each(function(){
		  if ($(this).text() == subway_line) {
		     $(this).attr('selected', true);
		  }
		});
		$.get("/hizhu/Estate/getSubwayByLine",{subwayline_id:$("#subwayline3").val()},function(data){
			$("#subway3").append(data);
			$('#subway3 option:contains('+subway+')').each(function(){
			  if ($(this).text() == subway) {
			     $(this).attr('selected', true);
			  }
			});
			$("input[name='subway_distance3']").val(distance);
		},"html");
	}
	$("#js_region").change(function(){
		if($(this).val()==""){
			$("#js_scope").html("");
			return;
		}
		var js_region=$("#js_region").val();
		$.get("/hizhu/Estate/searcheregion",{region:js_region},function(result){
			if(result.status=="200"){
			var attr=result.data;
			var len=attr.length;
			var obj=$("#js_scope");
			obj.html("");
			for (var i = len-1; i >= 0; i--){
				obj.append("<option value="+attr[i].id+">"+attr[i].cname+"</option>");
			};
			if(len>0){
				$("#js_scope").show();
			}else{
				$("#js_scope").hide();
			}
		}
	    },"json");

	});
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
	$("#btn_submit").bind("click",function(){
		check();
	})
    function check(){
	   var estate_name=$("input[name='estate_name']").val();
	   var estate_address=$("input[name='estate_address']").val();
	   var js_region=$("#js_region").val();
	   var js_scope=$("#js_scope").val();
	   var full_py=$("input[name='full_py']").val();
	   var first_py=$("input[name='first_py']").val();
	   var lpt_x=$("input[name='lpt_x']").val();
	   var lpt_y=$("input[name='lpt_y']").val();
	   var js_business_type=$("#js_business_type").val();
	   var js_house_type=$("#js_house_type").val();
	     var regExp = /[a-z]$/;
	     var regOr = /[A-Z]$/;
	   if(estate_name==""){
		    alert("楼盘名称不能为空");
		    return false;
	   }else if(estate_address==""){
		   alert("楼盘地址不能为空");
		   return false;
	   }else if(js_region==""){
		   alert("区域不能为空");
		   return false;
	   }else if(js_scope==""){
		   alert("板块不能为空");
		   return false;
	   }else if(full_py==""){
		   alert("楼盘名称全拼不能为空");
		   return false;
	   }else if(!regExp.test(full_py)){
		   alert("楼盘名称全拼必须是字母且小写");
		   return false;
	   }else if(first_py==""){
		   alert("楼盘首字母不能为空");
		   return false;
	   }else if(!regOr.test(first_py)){
		   alert("楼盘首字母必须是字母且大写");
		   return false;
	   }else if(lpt_x==""){
		   alert("坐标(经度)不能为空");
		   return false;
	   }else if(lpt_y==""){
		   alert("坐标(纬度)不能为空");
		   return false;
	   }else if(js_business_type==""){
		   alert("业务类型不能为空");
		   return false;
	   }else if(js_house_type==""){
		   alert("房屋类型不能为空");
		   return false;
	   }else{
	   	   $("#btn_submit").unbind("click").text("提交中");
	   	   var region_name=$("#js_region option[value='"+js_region+"']").text();
	   	   var scope_name=$("#js_scope option[value='"+js_scope+"']").text();
	   	   $("input[name='region_name']").val(region_name);
	   	   $("input[name='scope_name']").val(scope_name);
		   $("#submitForm").submit();
	   } 
   }

</script>
</html>