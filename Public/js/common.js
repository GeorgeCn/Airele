// 左侧导航栏展开收缩
$(function(){
	$(".subNav").click(function(){
				$(this).toggleClass("currentDd").siblings(".subNav").removeClass("currentDd")
				$(this).toggleClass("currentDt").siblings(".subNav").removeClass("currentDt")
				
				// 修改数字控制速度， slideUp(400)控制卷起速度
				$(this).next(".navContent").slideToggle(300).siblings(".navContent").slideUp(300);
		})	
	})
/*// 小区名称显示隐藏
$(function(){
	$(".plotIpt").focus(function(){
		$(".plotbox").show();
	});
	$(".plotIpt").blur(function(){
		$(".plotbox").show();
	});
})*/

var leftno =GetRequest('leftno');
$.each($(".main_left").find("li"), function () {
if(leftno!=null)
  {
  	$(this).removeClass("show");
  	$(this).parent().hide();
  }
});

$.each($(".main_left").find("li"), function () {
  var no=$(this).attr("ref");
  if(leftno!=null)
  {
  	if(no==leftno)
  	{
  		$(this).parent().show();
  		$(this).addClass("show");
  	}
  }


});

function GetRequest(name)
{
	var paramValue=getUrlParam(name);
	if(paramValue!=null)
	{
		return paramValue;
	}
	else
	{
		var url=window.location.href;
		url=url.toLowerCase();
		var indexno=url.indexOf("leftno");
		if(indexno>-1)
		{
			url=url.substr(indexno+7);
			url=url.substr(0,url.indexOf("/"));
			return url;
		}
		else
		{	
			return null;
		}
	}

}


//获取url中的参数
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

$(function(){
	var getLocal = window.localStorage.getItem("sidebarStatus");
			if(getLocal == 1){
				$("#hdnTemp").val("2");
				$(".main_left").css({left:"-15%"});
				$(".main_right").css({left:"0",width:'100%'});
				$("#btn").css({left:'25px','border-radius':'0 25px 25px 0'});
				$("#btn").find("img").attr("src","/GaoDuAdmin/Public/images/jt_r.png");
			}
		$("#btn").click(function(){
			if ($("#hdnTemp").val()=="1") {
				$(".main_left").animate({left:"-15%"},300);
				$(".main_right").animate({left:"0",width:'100%'},300);
				$("#btn").find("img").attr("src","/GaoDuAdmin/Public/images/jt_r.png");
				$(this).animate({left:'25px'},300).css("border-radius",'0 25px 25px 0');
				window.localStorage.setItem("sidebarStatus", 1);
				$("#hdnTemp").val("2");
			}else{
				$(".main_left").animate({left:"0"},300);
				$(".main_right").css("width","85%").animate({left:"15%"},300);
				$('#btn').find("img").attr("src","/GaoDuAdmin/Public/images/jt_l.png");
				$(this).animate({left:'15%'},300).css("border-radius","25px 0 0 25px");
				window.localStorage.setItem("sidebarStatus", 0);
				$("#hdnTemp").val("1");
			};

			
		});
	})
