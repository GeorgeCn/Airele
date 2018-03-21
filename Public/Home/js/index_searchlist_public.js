/*首页、搜索列表页公共JS方法*/
$(document).click(function(ev){
	ev = ev || window.event;
	var target = ev.target || ev.srcElement;
	if (!/^(landmarkBtn)|(tosearchlist)|(searchcityin)|(searchcityb)|(searchcitydiv)|(hotcity)|(a_b_c_d_e_f_g)|(h_i_j_k_l_m_n_o)|(p_q_r_s_t_u_v)|(w_x_y_z)|(cityselecttitleul)|(cityselectul)$/.test(target.id)&&!$(target).hasClass("citylili")){
		$("#searchcitydiv").css("display","none");
		if($('.error_tip_list').css('display')!='none'){
			$('.error_tip_list').css('display','none');
		}
		if($('.suggest_results').css('display')!='none'){
			$('.suggest_results').css('display','none');
		}
		if($('.people').css('display')!=='none'){
			$('#nav_p_num').click();
		}
		if($('.key_word_list').css('display')!='none'){
			$('.key_word_list').css('display','none');
		}
	} 
	
	if (!/^(startenddate)|(calendar_btn_s)|(calendar-box)|(preMonth)|(nextMonth)|(clearSelect)$/.test(target.id) && !$(target).is("#index_list_calendar-box,#index_list_calendar-box *")) {
        if( $('#checkinday').val() !='' && $("#checkoutday").val() == '') {
            endDateWarn($('#startenddate'));
        }
        else {
            if( $('#checkinday').val() =='' && $("#checkoutday").val() == '') {
                $('#startenddate').val(defaultText);
            }
            $("#index_list_calendar-box").hide();
        }
    }
});

document.onkeydown=function(event){
	var e = event || window.event || arguments.callee.caller.arguments[0];
	if(e && e.keyCode==27){ // 按 Esc 
		//要做的事情
		$("#biaoji").removeClass("map_biaoji");
		$(".BMap_mask").parent().removeClass("map_bj");	
		mapBj_flag = false;
	}
	if(e && e.keyCode==113){ // 按 F2 
		//要做的事情
	}            
	if(e && e.keyCode==13){ // enter 键
		if($('#loginboxdiv')&&$('#loginboxdiv').css("display")!='none'){
			return ; //FIXME 登录框自动登录
		}
		else if($('#tosearchlist'))
		{
			$('#tosearchlist').click();
		}

	}
}; 
var version = 0; 

var lastKeyword = "";
function getSuggestResult(sugurl,s,cityid,page,k){
	if(s!=lastKeyword)
	{
		if(k){
			$('#searchcityin1').attr("surl","");
		}else
		{
			$('#searchcityin').attr("surl","");
		}
		lastKeyword=s; 
	}
	version++;
	s = replaceSpecialChat(s);
	if(page=='list'&&!k)
	{
		$('#searchcityin1').val("");
	}
	_getSuggestResult(sugurl,s,cityid,page,k,version);

} 
function _getSuggestResult(sugurl,s,cityid,page,k,v)
{
	var f = 1;
	$.ajax({
		url:sugurl,
		data:{searchkey:s,
			  cityid:cityid,
			  pagefrom:page,
			  platfrom:1
		},
		type:'GET',
		dataType:'json',
		success:function(data){
			if(version!=v)
			{ 
				return;
			} 

			if(null!=data.error&&data.error.length>0){
				if(page=='list'){
					f = 2;
					$(".error_tip_list").html('<p>'+data.error+'</p>');
				}
				if(page=='index'){
					$(".error_tip_list").html(data.error);
				}
				$('.error_tip_list').css('display','block');
				if(k)
				{
					$('.error_tip_list').css('left',$("#searchcityin1").offset().left-$(".time-nav").offset().left);
				}
				else
				{
					if(page=='list'){
						$('.error_tip_list').css('left',$("#searchcityin").offset().left-$(".time-nav").offset().left);
					}
				}
				$('.suggest_results').css('display','none');
			}else{
				var list = data.list;
				var data = '<ul>';
				var hasNick = false;
				var hasAddr = false;
				var hasOther = false;
				var noSIcon = false;
				var type = "";
				
				for(var i=0;i<list.length;i++){
					var sug = list[i];
					var name = sug.name;
					if(name.indexOf(s)!=-1){
						name = name.replace(s,'<font class="c22bb62">'+s+'</font>');
					}
					var sugurl = sug.url;
					//district 和street重新组装URL
					if(sugurl.indexOf('district')!=-1 || sugurl.indexOf('street')!=-1){
						var newds = sugurl.split('-')[1];
						sugurl = sugurl.substring(0,sugurl.lastIndexOf('/'))+'_'+newds;
					}
					var liClass = "";
					if(type!=sug.sort)
					{ 
						liClass = "have_label";
						type=sug.sort; 
					}
				
					var sIcon='';
				
					if(liClass!=''||i==0)
					{
						if(sug.sort==1)
						{
							sIcon='<label>城市<i class="city_icon"></i></label>';
						}
						else 	if(sug.sort==2)
						{
							sIcon='<label>目的地<i class="arim_icon"></i></label>';
						}
						else if(sug.sort==3)
						{
							sIcon='<label>地铁<i class="subway_icon"></i></label>';
						}
						else if(sug.sort==4)
						{
							sIcon='<label>机场/车站<i class="station_icon"></i></label>';
						}
						else if(sug.sort==5)
						{
							sIcon='<label>行政区<i class="regions_icon"></i></label>';
						}
						else if(sug.sort==6)
						{
							sIcon='<label>商圈<i class="circle_icon"></i></label>';
						}
						else if(sug.sort==7)
						{
							sIcon='<label>街道<i class="street_icon"></i></label>';
						}
						else if(sug.sort==8)
						{
							sIcon='<label>景点<i class="views_icon"></i></label>';
						}
						else if(sug.sort==9)
						{
							sIcon='<label>医院<i class="hospital_icon"></i></label>';
						}
						else if(sug.sort==10)
						{
							sIcon='<label>学校<i class="school_icon"></i></label>';
						}
						
					} 
					if(sug.sort==0&&sug.type!=-1&&sug.type!=-2)
					{
						noSIcon = true;
					}
					if(i==0||i==1){ 
						if(sug.type==-1)
						{
							var name = sug.name;
							if(name.indexOf(s)!=-1){
								name = name.replace(s,'<font class="c22bb62">“'+s+'”</font>');
							}
							hasNick = true;
							var vkeyword = $('#searchcityin1').val().replace(/'/g,'').replace(/"/g,'');
							data+='<li class="tit_about '+liClass+'" rel="guang" style="cursor: pointer;" class="hover" )"><a url="'+sugurl+'" type="'+sug.type+'"><span class="leftspan" kw="'+vkeyword+'">标题&nbsp;或&nbsp;房东昵称&nbsp;含&nbsp;'+name+'&nbsp;的全部房源</span>'+(noSIcon?"":'<label><i class="tit_icon"></i></label>')+'</a></li>';
						}else if(sug.type==-2)
						{
							var name = sug.name;
							if(name.indexOf(s)!=-1){
								name = name.replace(s,'<font class="keyword">“'+s+'”</font>');
							}
							hasAddr = true;
							var vkeyword = $('#searchcityin1').val().replace(/'/g,'').replace(/"/g,'');
							data+='<li class="address_about'+liClass+'" rel="guang" '+((hasNick)?'':'style="cursor: pointer;" class="hover"')+'"><a url="'+sugurl+'" type="'+sug.type+'"><span class="leftspan" kw="'+vkeyword+'">地址&nbsp;含&nbsp;'+name+'&nbsp;的全部房源</span>'+(noSIcon?"":'<label><i class="address_icon"></i></label>')+'</a></li>';
						}
						else if(sug.type==0)
						{
							hasOther = true;
							data+='<li class="'+liClass+'" rel="guang" '+((hasNick||hasAddr||hasOther)?'':'style="cursor: pointer;" class="hover"')+'"><a url="'+sugurl+'" type="'+sug.type+'"><span class="leftspan"  kw="'+sug.name+'" >'+name+'</span><span class="rightspan">'+sug.desc+'</span></a></li>';
						}
						else
						{
							hasOther = true;
							data+='<li class="'+liClass+'" rel="guang" '+((hasNick||hasAddr||hasOther)?'':'style="cursor: pointer;" class="hover"')+'"><a url="'+sugurl+'" type="'+sug.type+'"><span class="leftspan"  kw="'+sug.name+'" >'+name+','+sug.genre+'</span>'+sIcon+'</a></li>';
							
						}
					}else{
						
						if(sug.type==-1)
						{
							var name = sug.name;
							if(name.indexOf(s)!=-1){
								name = name.replace(s,'<font class="c22bb62">“'+s+'”</font>');
							}
							hasNick = true;
							var vkeyword = $('#searchcityin1').val().replace(/'/g,'').replace(/"/g,'');
							data+='<li class="tit_about '+liClass+'" rel="guang" style="cursor: pointer;" class="hover" )"><a url="'+sugurl+'" type="'+sug.type+'"><span class="leftspan" kw="'+vkeyword+'">标题&nbsp;或&nbsp;房东昵称&nbsp;含&nbsp;'+name+'&nbsp;的全部房源</span>'+(noSIcon?'':'<label><i class="tit_icon"></i></label>')+'</a></li>';
						}else if(sug.type==-2)
						{
							var name = sug.name;
							if(name.indexOf(s)!=-1){
								name = name.replace(s,'<font class="keyword">“'+s+'”</font>');
							}
							hasAddr = true;
							var vkeyword = $('#searchcityin1').val().replace(/'/g,'').replace(/"/g,'');
							data+='<li class="address_about '+liClass+'" rel="guang" '+((hasNick)?'':'style="cursor: pointer;" class="hover"')+'"><a url="'+sugurl+'" type="'+sug.type+'"><span class="leftspan" kw="'+vkeyword+'">地址&nbsp;含&nbsp;'+name+'&nbsp;的全部房源</span>'+(noSIcon?'':'<label><i class="address_icon"></i></label>')+'</a></li>';
						}
						else if(sug.type==0)
						{
							data+='<li style="cursor: pointer;" ><a url="'+sugurl+'"  type="'+sug.type+'"><span class="leftspan"  kw="'+sug.name+'" >'+name+'</span><span class="rightspan">'+sug.desc+'</span></a></li>';
						}
						else
						{
							data+='<li class="'+liClass+'" style="cursor: pointer;" ><a url="'+sugurl+'"  type="'+sug.type+'"><span class="leftspan"  kw="'+sug.name+'" >'+name+','+sug.genre+'</span>'+sIcon+'</a></li>';
						}
					}
				}
				if(cityid!=0){
					//data +='<div class="other_city" style="cursor: pointer;" onclick="getOtherSug()">搜索其他城市</div>';
				}
				data+='</ul>';
				$('.suggest_results').html(data);
				$('.suggest_results').css('display','block');
				if(k)
				{
					$('.suggest_results').css('left',$("#searchcityin1").offset().left-$(".time-nav").offset().left);
				}
				else
				{
					if(page=='list'){
						$('.suggest_results').css('left',$("#searchcityin").offset().left-$(".time-nav").offset().left);	
					}

				}
				$('.error_tip_list').css('display','none');
				/*搜索猜测展示*/
				$(".suggest_results li").hover(function(){
					if(!$(this).hasClass("hover")){
						$(this).addClass("hover").siblings().removeClass("hover");
					}
				});
				/*搜索猜测选择 首页点击不调整URL*/
				$('.suggest_results ul li').click(function(){
					var ctx=$('#ctx').val();
					var search_kw = '';
					$('.suggest_results').css('display','none');
					if(k)
					{
						search_kw = $('#searchcityin1').val();
						$('#searchcityin1').val($(this).children().children(".leftspan").attr("kw"));
					}
					else
					{
						search_kw = $('#searchcityin').val();
						$('#searchcityin').val($(this).children().children(".leftspan").attr("kw"));
					}
					var url = $(this).children().attr('url')+'/';
					var log_ext = "-";
					var typeid=$(this).children().attr('type');
					var parmStr = '';
					var checkinday ='';
					var checkoutday='';
					var surl = $(this).children().attr('url')+'/';
					if(page=='index'){ 
						$('#searchcityin').attr("surl",surl);
						checkinday = $('#checkinday').val();
						checkoutday = $('#checkoutday').val();
						if(checkinday == undefined || checkinday == '' || checkinday == '入住时间'
							|| checkoutday == undefined || checkoutday == '' || checkoutday == '退房时间'){
							$('#startenddate').click();
						}
						$('#searchcityin').attr("search",search_kw);
						return false;
					}
					if(page=='list'){
						var guestnum = $('#nav_p_num').attr('name');
						if(guestnum!='' && guestnum!=0){
							url+='g'+guestnum+'/';
						}
						checkinday =  $('#checkinday').val();
						checkoutday = $('#checkoutday').val(); 
					}

					var skey = ''; 
					var sugvalue = $(this).children().children(".leftspan").attr("kw");
					if(parmTypeid(typeid)){
						skey = sugvalue;
					}
					if(!parmTypeid(typeid)){
						setSearchCookie($(this).children().children(".leftspan").attr("kw"),surl);	
					}
					if(skey.length>0){
						parmStr = '?s='+encodeURIComponent(skey)+"";
						if(typeid==-2){
							parmStr+='&t=2';
						}
					}
					if(checkinday!=undefined && checkinday!='' && checkinday!='入住时间'){
						if(parmStr.length>0){
							parmStr +='&d1='+checkinday;
						}else{
							parmStr +='?d1='+checkinday;
						}
						log_ext = checkinday;
						if(checkoutday!='' && checkoutday!='退房时间'){
							parmStr += '&d2='+checkoutday;
							log_ext += '_'+checkoutday;
						}
					}
					if(page=='list'){
						var mapNo = $("#map_no").val();
						if(mapNo=="no"){
							parmStr +=  (parmStr.length>0) ? "&map=no" : "?map=no";
						}
					}

					if(parmStr!=''){
						url = url +parmStr;
					}
					//平台日志
					send_log(2,$('#searchcityin').val()+"_"+skey,log_ext)
					//搜索日志
					save_search_log(search_kw,skey,url,typeid,1,page,1);
					
					window.location.href=ctx+url;
				});
			}
			$(".select-hotcity").css('display','none');
			$(".key_word_list").css('display','none');
		},
		error:function(){
			console.log('请求异常，请稍后再试！');
		}
	});
}


function searchBtnClick(value,cityid,page){
	var ctx = $('#ctx').val();
	var sugdis = $('.suggest_results').css('display');
	var sugurl = $('.suggest_results .hover a').attr('href');
	var url = '';
	var checkinday = '';
	var checkoutday = '';
	var f = 1;
	var sugvalue=''; 
	var log_ext = "-";
	if(value!=null && value.length>0  && value!='目的地' && value!='目的地、景点、商圈等'&& value!='关键词：位置、标题、房东等' )
	{
		var spinyin = '';
		var ctx = $('#ctx').val(); 
		var search_kw = $('#searchcityin').attr('search');
		var skey = '';
		var skey_type = -1;
		var spinyin = $('#searchcityin').attr("surl");
		if(page=='index'){
			var sugcss = $('.suggest_results').css('display');
			if(sugcss!='none'){
				search_kw = $('#searchcityin').val();
				skey = $(".suggest_results li.hover a .leftspan").text();
				skey_type = $(".suggest_results li.hover a").attr('type');
				$("#searchcityin").val($(".suggest_results li.hover a .leftspan").text());
				spinyin = $(".suggest_results li.hover a").attr('url');
			}else{
				skey = $('#searchcityin').val();
			}
		}
		if(spinyin=="")
		{
			return;
		}
		if(spinyin.substring(spinyin.length-1,spinyin.length)!="/"){
			url =ctx+spinyin+'/';
		}
		else
		{
			url =ctx+spinyin;
		}
		if(page=='index'){ 
			checkinday = $('#checkinday').val();
			checkoutday = $('#checkoutday').val();
			if(checkinday!=null&&checkinday!=""&&checkinday!="入住时间"){ 
				if(checkoutday!=null&&checkoutday!=""&&checkoutday!="退房时间"){
					url = url + "?d1="+checkinday;
					url = url + "&d2="+checkoutday;
					log_ext = checkinday+"_"+checkoutday;
				}
			}
			//平台日志
			send_log(2,skey,log_ext)
			//搜索日志
			save_search_log(search_kw,skey,url,skey_type,1,page,2);
		} 
		else if(page=='list')
		{
			f = 2;
			checkinday =  $('#checkinday').val();
			checkoutday = $('#checkoutday').val();
			var peoplenum = $('#nav_p_num').attr('name');
			if(peoplenum!=''&&peoplenum!=0){
				url += 'g'+peoplenum+'/';
			}
			//追加关键词
			var sKw = $('#searchcityin1').val();
			if(url.indexOf('_')==-1&&sKw.length>0)
			{
				url+="?s="+sKw;
			}
			if(checkinday!=null&&checkinday!=""&&checkinday!="入住时间")
			{ 
				if(checkoutday!=null&&checkoutday!=""&&checkoutday!="退房时间"){
					if(url.indexOf('?')!=-1)
					{
						url = url + "&d1="+checkinday;		
					}else{
						url = url + "?d1="+checkinday;		
					}
					url = url + "&d2="+checkoutday;
					log_ext = checkinday+"_"+checkoutday;
				}
			}
			var mapNo = $("#map_no").val();
			if(mapNo == "no"){
				url += (url.indexOf('?')!=-1) ? "&map=no" : "?map=no";
			}
			
			//平台日志
			send_log(2,$('#searchcityin').val()+"_"+sKw,log_ext)
			//搜索日志
			save_search_log(sKw.length>0?sKw:search_kw,skey,url,skey_type,1,page,2);
		}  

		setSearchCookie(value,spinyin);
		setCookie_('searchBtnClick',2,10);
		setCookie_('keywords_searchBtnClick',value ,10);
		setCookie_('pagefrom',page,10);
		window.location.href=url;
	} 
	else{
		$('.suggest_results').html('');
		$('.error_tip_list').html('请输入关键字');
		$('.error_tip_list').css('display','block');
		$('.select-hotcity').css('display','none');
		$('.suggest_results').css('display','none');
		if($('.people').css('display')!=='none'){
			$('#nav_p_num').click();
		}
	}
}

function send_log(log_type,ext_1,ext_2){
	MY.log_type=log_type;
	MY.ext_1=ext_1;
	MY.ext_2=ext_2;
	MY.send_p();
}

function save_search_log(search_kw,skey,url,type,platfrom,page,searchType){
	$.ajax({
		type : "GET",
		async:false,
		data:{search_kw:search_kw,skey:skey,url:url,type:type,platfrom:platfrom,page:page,searchType:searchType},
		url : $('#ctx').val() +"/search/log",
		success : function(data) {
		}
	});
}

function setSearchCookie(keyword,url){
	//将搜索词放入cookie
	var value = keyword+"&"+url;
	var seakey = getCookie('searchkey');
	if(null!=seakey&&seakey.length>0){
		if(seakey.indexOf(value)==-1){
			var keys = seakey.split(',');
			seakey += ","+value;
			if(keys.length>9){
				seakey = seakey.substring(seakey.indexOf(',')+1,seakey.length);
			}
		}
	}else{
		seakey = value;
	}
	setCookie('searchkey',seakey,365*20);
}

//通过城市名找
/*
function getCityPinyinbyName(cityname){
	for(var city in citys){
		var cityinfo = citys[city];
		if(cityinfo[1]==cityname||cityinfo[2]==cityname){
			return cityinfo[2];
			break;
		}
	}
	return "";
}*/

//校验是否关键字
function parmTypeid(typeid){
	if(typeid!='1'&&typeid!='2'&&typeid!='3'&&typeid!='5'&&typeid!='6'&&typeid!='7'&&typeid!='8'&&typeid!='9'&&typeid!='10'){
		return true;
	}else{
		return false;
	}
}

function Bind_Click(ele) {
	setCookie('searchkey','',-1);
	$(".cleartrace").parent(".searh-recent").remove();
	return false;
}

//Suggest提示按上下键盘移动光标
var movePrev = function(){
	var index = $("li.hover").prevAll().length;
	if(index == 0) $(".suggest_results li").removeClass('hover').eq($(".suggest_results li").length-1).addClass('hover');            //可循环移动
	// if(index == 0) return false;                                                            //不可循环移动
	else $(".suggest_results li").removeClass('hover').eq(index-1).addClass('hover');
	if($('#suggest').css('left')=='82px' ){
		$("#searchcityin").val($("li.hover a .leftspan").attr('kw'));	
	}else
	{
		$("#searchcityin1").val($("li.hover a .leftspan").attr('kw'));
	}
}

var moveNext = function(){
	var index = $("li.hover").prevAll().length;
	if(index == $(".suggest_results li").length-1) $(".suggest_results li").removeClass('hover').eq(0).addClass('hover');            //可循环移动
	// if(index == $("li").length-1) return false;                                                //不可循环移动
	else $(".suggest_results li").removeClass('hover').eq(index+1).addClass('hover');
	if($('#suggest').css('left')=='82px' ){
		$("#searchcityin").val($("li.hover a .leftspan").attr('kw'));	
	}else
	{
		$("#searchcityin1").val($("li.hover a .leftspan").attr('kw'));
	}

}

function getCookie(name){
	var arr = document.cookie.split("; ");
	for(var i=0,len=arr.length;i<len;i++){
		var item = arr[i].split("=");
		if(item[0]==name){
			return unescape(item[1]);
		}
	}
	return "";
}

function setCookie(c_name, value, exdays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function setCookie_(c_name, value, exdays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = encodeURI(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
//替换输入框中特殊字符
function replaceSpecialChat(ch){
	var reg = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？〇]");
	var rv = "";
	for (var i = 0; i < ch.length; i++) {
		rv += ch.substr(i,1).replace(reg,'');
	}

	return rv;
}

String.prototype.trim = function () {
	return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' );
}
