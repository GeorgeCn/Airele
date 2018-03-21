$(document).ready(function() {		
	//登陆弹窗
	var loginboxlayer,login_flag = false;
	function showLoginboxDiv(){
		// kgj add 判断二级域名
		var subdomain = $("#subdomain").val();
		if(subdomain!=null&&subdomain!='')
		{
			resetLoginUrl();
		}
		else
		{
			loginboxlayer = $.layer({
				closeBtn : [0 , false],
				type : 1,
				title : false,
				offset:['150px' , ''],
				border : [0,0,'',false],
				area : ['auto','auto'],
				move : ['.login-type',false],
				page : {dom : '#loginboxdiv'}
			});
			$('#loginclose').on('click',function(){
				layer.close(loginboxlayer);
				$(this).css({
					"background-color":"#E6E7EB",
				});
			});
			$('#loginclose').on('mouseover',function(){
				$(this).css({
					"background-color":"#A8A8A8",
				});
			});
			$('#loginclose').on('mouseout',function(){
				$(this).css({
					"background-color":"#E6E7EB",
				});
			});
			login_flag = false;
			changeAuthSrc();
		}
	}

	//后台跳转首页并弹出登陆框
	var headlogin =  function headlogin(){
		var nexturl = $('#loginurl').val();    
		var autologin = getParameterByName("autologin"); 
		if(nexturl!=null&&nexturl!="none"){
			$('#loginboxdiv').attr("nexturl",nexturl);
			showLoginboxDiv();
		}	
		// kgj add 判断二级域名自动弹出登陆框
		else if(autologin!=null&&autologin!='')
		{				
			if($("#head_nickname").html()==null)		
				showLoginboxDiv();
		}		
		else{
			return false;
		}
	}

	//未登录点击站内信显示登陆框	
	$('#talksLogin').on('click',function(){
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});

	//列表页点击房东图像显示登陆框	
	$('.searchLogin').on('click',function(){
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});

	//调用一次自动登录
	headlogin();

	//显示登陆框	
	$('#loginshow').on('click',function(){		  
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});

	//其它地方要调登陆
	$('.loginatother').on('click',function(e){
		var nexturl = $(e.target).attr("nexturl");
		if(nexturl!=null&&nexturl!="none"){
			$('#loginboxdiv').attr("nexturl",nexturl);
		}
		showLoginboxDiv();
	});

	//切换到手机号码登录
	$('#changeloginbymwa,#changeloginbyma').on('click',function(){
		//去蚂蚁登陆样式
		$('#changeloginbyup').removeClass('mayiway_current');   
		$('#changeloginbyup').addClass('mayiway'); 
		$("#loginbyupdiv").css("display","none");
		$("#loginbymadiv").css("display","block");	
		changeAuthSrc();
		$('#changeloginbyma').removeClass('phoneway');   
		$('#changeloginbyma').addClass('phoneway_current'); 
	});

	//切换到蚂蚁账号登录
	$('#changeloginbyup').on('click',function(){
		//去手机 登陆样式
		$('#changeloginbyma').removeClass('phoneway_current');   
		$('#changeloginbyma').addClass('phoneway'); 	
		$("#loginbymadiv").css("display","none");
		$("#loginbyupdiv").css("display","block");
		changeAuthSrc(1);
		$('#changeloginbyup').removeClass('mayiway');   
		$('#changeloginbyup').addClass('mayiway_current'); 
	});
	//显示登陆框	
	$('.btn-img').on('click',function(){	
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});

	//倒计时方法
	var loginwait=60;
	function logintime(){
		if (loginwait == 0) {
			$('#getloginphonecode').val("获取验证码");				
			$('#getloginphonecode').removeClass("sending");
			$('#getloginphonecode').addClass("defaultsend");
			changeAuthSrc();
			loginwait =60;
		} else {
			$('#getloginphonecode').val(loginwait+"s");
			$('#getloginphonecode').removeClass("defaultsend");
			$('#getloginphonecode').addClass("sending");
			loginwait--;
			setTimeout(
					function() {
						logintime();
					},
					1000
			);
		}
	}

	//make random
	function makeRand(){ 
		var Num=""; 
		for(var i=0;i<4;i++){ 
			Num+=Math.floor(Math.random()*10); 
		} 
		return Num;
	} 

	//更新图片验证码		     
	function changeAuthSrc(type){
		var randomNum = makeRand();
		var ctx = $('#ctx').val();
		if(type){
			$("#loginauthimage1").attr("src",ctx+"/common/authimage?random="+randomNum+"&width=130&height=38");
		}
		$("#loginauthimage").attr("src",ctx+"/common/authimage?random="+randomNum+"&width=130&height=38");
	}

	//点击更新
	$('#loginauthimage').on('click',function(){
		changeAuthSrc();	  	
	});
	//点击更新
	$('#loginauthimage1').on('click',function(){
		changeAuthSrc(1);	  	
	});

	//登陆时获取手机验证码
	$('#getloginphonecode').click(function(){
		if($('#getloginphonecode').hasClass("sending")){
			return false;
		}
		var val_mobile = $('#loginmobile').val();			      
		var val_imagecode = $('#imagecode').val();
		if(val_imagecode!=null&val_imagecode!=""){
			var phone_number_regex = /^0?1[34758]\d{9}$/;
			if (phone_number_regex.test(val_mobile)) {			      	    
				logintime();//加入倒计时
				var ctx = $('#ctx').val();
				$.get(ctx+"/mobile/"+val_mobile+"/phonecode.do?imagecode="+val_imagecode,function(re) {
					if(re.error!=null){							
						if(re.error.errorCode==1106){
							layer.alert(re.error.message,8,"温馨提示");
							loginwait=60-re.error.second;					
							return false;
						}else{							
							layer.alert(re.error.message,8,"温馨提示");
							changeAuthSrc();
							loginwait=0;					
							return false;
						}
					}
				},'JSON');
			}else{
				layer.alert("请输入合法的手机号！",8,"温馨提示");
			}
		}else{
			layer.alert("请填写图片中的验证码！",8,"温馨提示");
		}
	});

	//登陆方法
	function logindo(param1,param2,logintype){
		if(login_flag){
			return ;
		}
		login_flag = true;
		var ctx = $('#ctx').val();
		var val_autologin = true;
		if(logintype=="up"&&$("input[name='rememberpass']").is(':checked')==false){
			val_autologin = false; 
		}	else if(logintype=="ma"&&$("input[name='rememberloginstate']").is(':checked')==false){
			val_autologin = false; 
		}
		var val_imagecode = $('#imagecode1').val();
		$.ajax({
			url : ctx+"/userlogin.do",
			type : 'POST',
			async:true,
			data : {param1:param1,param2:param2,logintype:logintype,auto_login:val_autologin,imagecode:val_imagecode},
			dataType:'json',
			timeout: 5000,
			success : function(data){
				login_flag = false;
				if(data.error){
					var span = '<span class="errorprompt">'+data.error.message+'</span>';
					if(logintype=="ma"){
						$('#maerrordiv').append(span);
						changeAuthSrc();
						// layer.alert("data.error.message",8,"温馨提示");
					}else{
						$('#uperrordiv').append(span);
						changeAuthSrc(1);
						// $('#uperrordiv').append(span);
						//layer.alert("data.error.message",8,"温馨提示");
					}
				}else{
					//游客标记。从游客订单登录
					var visit_flag=$('#visit_flag').val();
					var nexturl = $('#loginboxdiv').attr("nexturl");
					//此flag是用于是在顶端点击登录还是在中部点击登录。（“我的订单”页，按照产品要求有不同的跳转）
					var flag=$('#flag').val();
					if(flag!=null){
						if(flag=='mid'){
							nexturl=ctx+'/tenant/'+getCookie('MAYIUID')+'/orders';
						}else if(flag=='head'){
							nexturl=ctx+"/";
						}
					}
					if(nexturl!=null&&nexturl!="none"){
						location.href = nexturl;
					}else{
						if(visit_flag!=null){
							location.href=$('#ctx').val(); 
						}else{
							resetDomain();								
						}
					}
				}
			}
		});
	}

	//点击手机号输入框	
	$('#loginmobile').on('click',function(){
		$('#maerrordiv .errorprompt').remove();
	});	 

	//点击手机验证码输入框	
	$('#loginphonecode').on('click',function(){
		$('#maerrordiv .errorprompt').remove();
	});

	//手机验证码输入框 回车事件
	$("#loginphonecode").keydown(function(e){
		var curKey = e.which; 
		if(curKey == 13){
			var mobile = $('#loginmobile').val();
			var phonecode = $('#loginphonecode').val();
			if(mobile==null||mobile==""
				||phonecode==null||phonecode==""){
				$('#maerrordiv .errorprompt').remove();
				var span = '<span class="errorprompt">手机号或验证码不能为空</span>';
				$('#maerrordiv').append(span);
				return false;
			}else{		    	
				var phone_number_regex = /^0?1[34758]\d{9}$/;
				if (phone_number_regex.test(mobile)) {
					$('#maerrordiv .errorprompt').remove();
					logindo(mobile,phonecode,'ma');
				}else{
					layer.alert("请输入合法的手机号！",8,"温馨提示");
				}
			}
		}
	});


	//点击用户名输入框
	$('#loginnamein').on('click',function(){
		$('#uperrordiv .errorprompt').remove();
	});
	//点击用户名输入框
	$('#imagecode1').on('click',function(){
		$('#uperrordiv .errorprompt').remove();
	});

	//用户名输入框 回车事件
	$("#loginnamein").keydown(function(e){
		var curKey = e.which; 
		if(curKey == 13){
			var username = $('#loginnamein').val();
			if(username!=null&&username!=""){
				$("#loginpassin").focus(); 
			}
		}
	});

	//点击密码输入框
	$('#loginpassin').on('click',function(){
		$('#uperrordiv .errorprompt').remove();
	});

	//密码输入框 回车事件
	$("#loginpassin").keydown(function(e){
		var curKey = e.which; 
		if(curKey == 13){       	
			var username = $('#loginnamein').val();
			var pass = $('#loginpassin').val();
			var val_imagecode = $('#imagecode1').val();
			if(val_imagecode==null||val_imagecode==""){
				$('#uperrordiv .errorprompt').remove();
				var span = '<span class="errorprompt">验证码不能为空</span>';
				$('#uperrordiv').append(span);
				return false;
			}
			if(username==null||username==""||pass==null||pass==""){
				// $('#uperrordiv.errorprompt').remove();
				//var span = '<span class="errorprompt">用户名或密码不能为空</span>';
				//$('#uperrordiv').append(span);
				$('#uperrordiv .errorprompt').remove();
				var span = '<span class="errorprompt">用户名或密码不能为空</span>';
				$('#uperrordiv').append(span);
				return false;
			}else{
				$('#uperrordiv.errorprompt').remove();
				var encrynewpass = $.md5(pass);
				logindo(username,encrynewpass,'up');
			}
		}
	});

	//手机登陆按钮
	$('#loginbymado').on('click',function(){
		var mobile = $('#loginmobile').val();
		var phonecode = $('#loginphonecode').val();
		if(mobile==null||mobile==""
			||phonecode==null||phonecode==""){
			$('#maerrordiv .errorprompt').remove();
			var span = '<span class="errorprompt">手机号或验证码不能为空</span>';
			$('#maerrordiv').append(span);
			return false;
		}else{		    	
			var phone_number_regex = /^0?1[34758]\d{9}$/;
			if (phone_number_regex.test(mobile)) {
				$('#maerrordiv .errorprompt').remove();
				logindo(mobile,phonecode,'ma');
			}else{
				layer.alert("请输入合法的手机号！",8,"温馨提示");
			}
		}
	});

	//蚂蚁账号登录按钮
	$('#loginbyupdo').on('click',function(){
		var username = $('#loginnamein').val();
		var pass = $('#loginpassin').val();
		var val_imagecode = $('#imagecode1').val();
		if(val_imagecode==null||val_imagecode==""){
			$('#uperrordiv .errorprompt').remove();
			var span = '<span class="errorprompt">验证码不能为空</span>';
			$('#uperrordiv').append(span);
			return false;
		}
		if(username==null||username==""
			||pass==null||pass==""){
			//$('#uperrordiv .errorprompt').remove();
			// var span = '<span class="errorprompt">用户名或密码不能为空</span>';
			// $('#uperrordiv').append(span);
			$('#uperrordiv .errorprompt').remove();
			var span = '<span class="errorprompt">用户名或密码不能为空</span>';
			$('#uperrordiv').append(span);
			return false;
		}else{
			//$('#uperrordiv .errorprompt').remove();
			$('#uperrordiv .errorprompt').remove();
			var encrynewpass = $.md5(pass);
			logindo(username,encrynewpass,'up');
		}
	});

	//qq登陆
	$('#loginbyqq').on('click',function(){
		var nexturl = window.location.href;
		var tempurl = $('#loginboxdiv').attr("nexturl");
		if(tempurl!=null&&tempurl!=""&&tempurl!="none"){
			nexturl = tempurl;
		}
		var ctx = $('#ctx').val();
		location.href =  ctx+"/userloginfromqq.html?next="+nexturl;	      
	});

	//sina登陆
	$('#loginbysina').on('click',function(){
		var nexturl =window.location.href;
		var tempurl = $('#loginboxdiv').attr("nexturl");
		if(tempurl!=null&&tempurl!=""&&tempurl!="none"){
			nexturl = tempurl;
		}
		var ctx = $('#ctx').val();
		location.href =  ctx+"/userloginfromsina.html?next="+nexturl;	  
	});
	
	//微信登陆
	$('#loginbywx').on('click',function(){
		var nexturl = window.location.href;
		var tempurl = $('#loginboxdiv').attr("nexturl");
		if(tempurl!=null&&tempurl!=""&&tempurl!="none"){
			nexturl = tempurl;
		}
		var ctx = $('#ctx').val();
		location.href =  ctx+"/userloginfromweixin.html?next="+nexturl;	      
	});

	//退出
	$('#loginoutbut').on('click',function(){
		var ctx = $('#ctx').val();
		$.get(ctx+"/user/loginout.do",function(re){
			if(re=="success"){
				resetDomain();
				//location.reload(); 
			}
		},'text'); 
	});

	//点击“我的订单”(游客)
	/**$('#myorder').on('click',function(){
	 	  var ctx = $('#ctx').val();
	 	  location.href =ctx+"/user/myorder";	  
	 });*/
	$('#loginnow').on('click',function(){
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});
	$('#loginshowhead').on('click',function(){
		$('#flag').val('head');
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});
	$('#loginnowmid').on('click',function(){
		$('#flag').val('mid');
		$('#loginboxdiv').attr("nexturl","none");
		showLoginboxDiv();
	});
	//首页banner图片自动
	var $banner=$('.banner');
	var $banner_ul=$('.banner-img');
	var $btn=$('.banner-btn');
	var $btn_a=$btn.find('a')
	var v_width=$banner.width();

	var page=1;

	var timer=null;
	var btnClass=null;

	var page_count=$banner_ul.find('li').length;//把这个值赋给小圆点的个数

	var banner_cir="<li class='selected' ><a href='javascript:void(0);'></a></li>";
	for(var i=1;i<page_count;i++){
		//动态添加小圆点
		banner_cir+="<li><a href='javascript:void(0);'></a></li>";
	}
	$('.banner-circle').append(banner_cir);

	var cirLeft=$('.banner-circle').width()*(-0.5);
	$('.banner-circle').css({'marginLeft':cirLeft});

	$banner_ul.width(page_count*v_width);

	function move(obj,classname){
		//手动及自动播放
		if(!$banner_ul.is(':animated')){
			if(classname=='prevBtn'){
				if(page==1){
					$banner_ul.animate({left:-v_width*(page_count-1)});
					page=page_count; 
					cirMove();
				}
				else{
					$banner_ul.animate({left:'+='+v_width},"slow");
					page--;
					cirMove();
				}        
			}
			else{
				if(page==page_count){
					$banner_ul.animate({left:0});
					page=1;
					cirMove();
				}
				else{
					$banner_ul.animate({left:'-='+v_width},"slow");
					page++;
					cirMove();
				}
			}
		}
	}

	function cirMove(){
		//检测page的值，使当前的page与selected的小圆点一致
		$('.banner-circle li').eq(page-1).addClass('selected')
		.siblings().removeClass('selected');
	}

	$banner.mouseover(function(){
		$btn.css({'display':'block'});
		clearInterval(timer);
	}).mouseout(function(){
		$btn.css({'display':'none'});                
		clearInterval(timer);
		timer=setInterval(move,2000);
	}).trigger("mouseout");//激活自动播放

	$btn_a.mouseover(function(){
		//实现透明渐变，阻止冒泡
		$(this).animate({opacity:0.6},'fast');
		$btn.css({'display':'block'});
		return false;
	}).mouseleave(function(){
		$(this).animate({opacity:0.3},'fast');
		$btn.css({'display':'none'});
		return false;
	}).click(function(){
		//手动点击清除计时器
		btnClass=this.className;
		clearInterval(timer);
		timer=setInterval(move,4000);
		move($(this),this.className);
	});
	$('.banner-circle li').click(function(){
		var index=$('.banner-circle li').index(this);
		$banner_ul.animate({left:-v_width*index},'slow');
		page=index+1;
		cirMove();
	}); 

	/**针对二级域名做处理**/
	var resetDomain = function() {
		var host = window.location.host;
		var subdomain = $("#subdomain").val();
		var url = window.location.href;
		if (subdomain != '') {
			window.location.href = url.replace(host, $("#mainsite").val());
		} else {
			var autologin = getParameterByName("autologin");
			if (autologin != null && autologin != '') {
				window.location.href = url.replace('autologin=true', '');
			} else {
				location.reload();
			}
		}
	}

	var resetLoginUrl = function() {
		var url = window.location.href;
		var host = window.location.host;
		if (url.indexOf("?") > 0) url += "&autologin=true";
		else url += "?autologin=true";
		window.location.href = url.replace(host,  $("#mainsite").val());
	}
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.search);
		if (results == null) return "";
		else return decodeURIComponent(results[1].replace(/\+/g, " "));
	}

});

