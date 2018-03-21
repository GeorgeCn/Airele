 
$(function(){
		$(".close-alert1").click(function(){
			$(".alert-box1").hide();
		})
	})
	
	function loginowner(userid){
	
		var ctx = $('#ctx').val();
 	  	$.get(ctx+"/user/checkFrozenAccount?frozenOwnerid="+userid,function(re){
			
			if(re==1){
				$(".alert-box1").show();
			}else{
				var ctx = $('#ctx').val();
		     	location.href =ctx+"/landlord/"+userid+"/orders";	
			}
	   }); 
    }
    
    function publish(userid){
	
		var ctx = $('#ctx').val();
 	  	$.get(ctx+"/user/checkFrozenAccount?frozenOwnerid="+userid,function(re){
			
			if(re==1){
				$(".alert-box1").show();
			}else{
				var ctx = $('#ctx').val();
		     	location.href =ctx+"/room/publish/basicinfo";	
			}
	   }); 
    }
    
    function menufrozen(userid,url,frozentype){
		
		var ctx = $('#ctx').val();
		var furl = ctx+"/user/checkFrozenAccount?frozenOwnerid="+userid;
		furl += "&frozentype="+frozentype;
  		$.get(furl,function(re){
			if(re==1){
				if(frozentype=='user'){
					$(".frozeninfo").text("对不起，用户账号被封禁");
				}
				$(".alert-box1").show();
			}else{
		     	location.href =url;	
			}
	  	 }); 
    }
    function getSuggest(e){       
		var s = $('#searchcityin').val().trim();		
		var ctx = $('#ctx').val();
		if(!e) var e=window.event;
		var code = e.keyCode;
		if(code==27){
			$('.error_tip_list').css('display','none');
			$('.suggest_results').css('display','none');
			return false;
		}		
		if(code==13||code==37||code==38||code==39||code==40){
			return false;
		}
		if(null!=s && s.length>0 && s!='目的地、景点、商圈等'){		   
			var sugurl = ctx+'/getSuggest';
			getSuggestResult(sugurl,s,0,'list');
		}else{		   
			$('.error_tip_list').html('请输入关键字');
			$('.error_tip_list').css('display','block');
			$('.suggest_results').css('display','none');			
		}
    }
function pressEve(e){
	var e=e||window.event;
	var code = e.keyCode;
	var sugcss = $('.suggest_results').css('display');
	
	if(sugcss!='none'){
		if(code==13){
			doSearch();
		}else if(code==38){
			movePrev();
		}else if(code==40){
			moveNext();
		}
	}
}

$(function() {	
  	var userName=$("#head_userName").val();
  	if(userName!='' && userName.length>0){
  		var realLength = 0;
  		var len = userName.length;
  		var charCode = -1;
		for (var i = 0; i < len; i++) {
			charCode = userName.charCodeAt(i);
			if (charCode >= 0 && charCode <= 128){ 
				realLength += 1;
			}else{
				realLength += 2;
			}
			if(realLength>20){
				$("#head_nickname").html(userName.substring(0,i)+"...");
				break;
			}
		}
		if(realLength <= 20){
			$("#head_nickname").html(userName);
		}
  	}
  	
  	$(".showinfo").hover(function(){
		$(this).children(".head_pop").css("display","block");		
	}).mouseleave(function(){
		$(this).children(".head_pop").css("display","none");
	})
	
});