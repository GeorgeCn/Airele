var defaultText="";
function initTicket(re){
	var checkin =  $('#checkinday').val();
	var checkout =  $('#checkoutday').val();
	fcheckin=null;
	fcheckout=null;
	 
	// 用ajax做真正的删除
	var url = $("#ctx").val() + "/order/validtickettime"; 
	$.get(url, {
		'checkin': checkin,
		'checkout':checkout
	}, function(data) { 
	    var jsonData = eval(data);
	    fcheckin=jsonData.result[0]; 
	    fcheckout=jsonData.result[1];
	    if(re)
		{
	    	if(oCal1){
	    		oCal1.set('minDate', fcheckin).set('maxDate', fcheckout);	
	    	} 
		}else{
			createCalendar(fcheckin,fcheckout);
		}   
	}); 
}
var oCal1;
function createCalendar(fcheckin,fcheckout){
	try{
	  	YUI({}).use('trip-calendar', function(Y) {
				/**
				 * 弹出式日历实例
				 * 将日历与指定的触发元素绑定
				 * 日历可根据浏览器窗口大小，自动调整显示位置
				 */
		  		oCal1 = new Y.TripCalendar({
		  		//绑定日历的节点，支持选择器模式，可批量设置（必选）
					triggerNode: '.ticket_date',
					minDate: fcheckin,
					maxDate: fcheckout,
					count : '1'
				});
	
				oCal1.on('dateclick', function(e) {
					this.getCurrentNode().setAttribute('data-date', e.date);
				});
	
				//显示日历时自定义事件
				oCal1.on('show', function() {
					var v = this.getCurrentNode().getAttribute('data-date');
					this.set('date', v || new Date);
					this.set('selectedDate', v).render();
				});
	
				//解决chrome的foucs事件bug
				Y.on('click', function(e) {e.currentTarget.focus();}, 'button, .J_Link');
			}); 
	}catch(e){
		console.log(e);
	}
}




//联系人相关设置错误信息
function setErrorMess(obj,mess){
	obj.siblings('.error').css('display','block').find('b').show();
	obj.siblings('.error').find('i').show();
	obj.addClass('no_wans');
	obj.siblings('.error').css('display','block').find('b').html(mess);
}
//联系人相关取消设置错误信息
function concelErrorMess(obj){
	obj.siblings('.error').css('display','none').find('b').hide();
	obj.siblings('.error').find('i').hide();
	obj.removeClass('no_wans');
}
//处理日历控件
function proccessDateChange(){		
	ajaxOrderDetial();
}

//更新图片验证码		     
function changeBookAuthSrc(){
    var randomNum = makeBookRand();
    var ctx = $('#ctx').val();
    $("#bookauthimage").attr("src",ctx+"/common/authimage?random="+randomNum+"&width=130&height=38");
}

//调用绑定的方法
function bangding(){
	layer.close(k);
	var uid=$("#tenantid").val();
	var mobile=$("#tenantmobile").val();
	var url="/user/"+uid+"/bandingmobile.do?mobile="+mobile;
	jQuery.post(url,{},function(){});
}

function makeBookRand(){ 
	var Num=""; 
	for(var i=0;i<4;i++){ 
			Num+=Math.floor(Math.random()*10); 
	} 
	return Num;
} 

//设置验证码标记
var flag2=0;
var i,j;
//验证验证码
function validCode(){
    var mobile=$("#tenantmobile").val();
    var phonecode=$("#phonecode").val();
    if(phonecode!=null&phonecode!=""){
		var url="/prebook/validauthcode.do";
		url+="?mobile="+mobile+"&phonecode="+phonecode;
		
		jQuery.post(url,{},function(result){
			if(result.error){
				$("#errorMessage").text(result.error.message);
				showErrorDiv();
				//layer.close(i);
			}else {
				$("#tenantid").val(result.data.id);
				$("#validingMobile").attr("validResult",1);
				var mobileno = $('#mobileno').val();
				if(false==result.needbanding){
					showSuccessDiv();
					 $('#mobileno').val(mobile);
				}else{
				 	showSuccessBangdingDiv();
				 	 $('#mobileno').val(mobile);
				}
				if(mobileno!=undefined && mobileno.length>0){
					//$('#tellphoneSpan').val(mobile);
					$('#tenantmobile').val(mobile);
					$('#imgcode').css('display','none');
					$('#mobilecode').css('display','none');
					$('#editMobile').text('修改');
					if(bookwait!=0){
						bookwait=0;
					}
				}else{
					window.location.href = window.location.href;
				}
			}
		});
	}else{
	    layer.alert("请输手机验证码！",8,"温馨提示");
	}
}
	
$(document).ready(function(){
	//倒计时方法
	var bookwait=60;
	function time(){
		if (bookwait == 0) {
			$('#egetmobilecode').val("获取验证码");  			
			$('#egetmobilecode').removeClass("sending");
			$('#egetmobilecode').addClass("defaultsend");
			changeBookAuthSrc();
			bookwait =60;
		}else{
			$('#egetmobilecode').val(bookwait+"s");
			$('#egetmobilecode').removeClass("defaultsend");
			$('#egetmobilecode').addClass("sending");
			bookwait--;
			setTimeout(function() {time();},1000);
		}
	}	

	
	//加载订房日志控件
	YUI({
	}).use('trip-calendar', function(Y) {
			var oCal = new Y.TripCalendar({
		    minDate         : new Date,     //最小时间限制
		    triggerNode     : '#checkinday', //第一个触节点
		    finalTriggerNode: '#checkoutday',  //最后一个触发节点
	    	calPrice:2,
	        roomid:m.roomid,
	        minday:m.minday,
	        ctx:''
		}); 
		oCal.on('startDateChange', function(e) {
	    	 initTicket(true); 
		});
		oCal.on('endDateChange', function(e) {
			proccessDateChange();   
			// 门票信息
			initTicket(true);
		});
		oCal._setDefaultValue();
	});
	//初始化门票 日历
	callTimeout('',initTicket,200);		
	$('#tenantmobile').blur(function(){
		var mobile = $(this).val();
		if(mobile.length>0){
			concelErrorMess($(this));
		}else{
			setErrorMess($(this),'手机号不能为空');
		}
	});
	
	$('#bookimagecode').blur(function(){
		var imgcode = $(this).val();
		if(imgcode.length>0){
			concelErrorMess($(this));
		}else{
			setErrorMess($(this),'图片验证码不能为空');
		}
	});
	
	$('#phonecode').on('keyup',function(){
		var phonecode = $(this).val();
		if(phonecode.length==6){
			var mobileno=$("#tenantmobile").val();
			var reg =/^((\+86)|(86))?(1)\d{10}$/;
			if(!mobileno.match(reg)){
				layer.alert("请输入正确有效的手机号码！",8,"温馨提示");
				$('#egetmobilecode').val("获取手机验证码"); 
	            return false;
	        }
			validCode();
		}else{
		  
		}
	});
	  
	//点击更新
	$('#bookauthimage').on('click',function(){
		changeBookAuthSrc();	  	
	});
	
	//细则
	$('#totalpriceDetial').hover(function(){
		$('.xize').show();
	},function(){
		$('.xize').hide();
	});
	
	//初始化订单页详细数据
	var detialJson=m.detialJson;
	initOrderPageInfo(detialJson);
	
	//重新获取手机验证码
	$('#egetmobilecode').on('click',function(){
			var mobileno = $('#tenantmobile').val();
			var reg =/^((\+86)|(86))?(1)\d{10}$/;
			if(mobileno.length>0){
				if(!mobileno.match(reg)){
					var mess = '请输入正确有效的手机号码';
					setErrorMess($('#tenantmobile'),mess);
					$('#egetmobilecode').val("获取手机验证码"); 
					return false;
				}
			}else{
				var mess = '手机号不能为空';
				setErrorMess($('#tenantmobile'),mess);
				return false;
			}
			
	      if($('#egetmobilecode').hasClass("sending")){
		      		return false;
		    }
		    var val_imagecode = $('#bookimagecode').val();
		    if(val_imagecode!=undefined && val_imagecode.length>0){
		    	
		    }else{
		    	var mess = '图片验证码不能为空';
				setErrorMess($('#bookimagecode'),mess);
				return false;
		    }
		    if(val_imagecode!=null&val_imagecode!=""){
			    	time();
			  	 	var mobile=$("#tenantmobile").val();
			  	 	var url="/mobile/"+mobileno+"/phonecode.do?imagecode="+val_imagecode;
					jQuery.get(url,{},function(re) {
								if(re.error!=null){							
									if(re.error.errorCode==1106){
										 layer.alert(re.error.message,8,"温馨提示");
										 bookwait=60-re.error.second;					
										 return false;
									}else{							
										 layer.alert(re.error.message,8,"温馨提示");
										 changeBookAuthSrc();
										 bookwait=0;					
										 return false;
									}
								}
							}
			      	);
	      }else{
		      	   layer.alert("请填写图片中的验证码！",8,"温馨提示");
		      	   $('#egetmobilecode').val("获取手机验证码"); 
		    }
	  });
	$('#editMobile').click(function(){
		  var text = $(this).text();
		  var mobileno = $('#mobileno').val();
		  if(text=='修改'){
			  $(this).text('取消修改');
			  $('#tenantmobile').attr('readonly',false);
			  $('#bookimagecode').val('');
			  $('#phonecode').val('');
			  $('#imgcode').css('display','block');
			  $('#mobilecode').css('display','block');
		  }else{
			  $(this).text('修改');
			  $('#tenantmobile').val(mobileno);
			  $('#tenantmobile').attr('readonly',true);
			  $('#imgcode').css('display','none');
			  $('#mobilecode').css('display','none');
			  $('.error_photo').css('display','none');
			  $('#tenantmobile').removeClass('no_wans');
		  }
	});
	
})