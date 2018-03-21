//保险单价
var payunitpriceYuan = 0.29;
var idCardCode = "111";
var hkmacaoCode = "516";
var taiwanCode = "511";
var passportCode = "414";
var militaryIDCode = "233";
//初始化JS
$(function() {	
    $('.permanent').hover(function() {
        $(this).children(".orange").show();
    }, function() {
        $(this).children(".orange").hide();
    });    
    //常用联系人删除
    $(".permanent .orange").click(function() { 
    	if(confirm("确定删除该联系人信息？"))
    	{
	        $(this).parent().remove();
	        if ($(".permanent").length == 0) {
	            $(".permanentcol").css("display", "none");
	        }        
	        var deleteUrl = $("#ctx").val() + "/order/deleteUserContact";
	        var userContactId = $(this).attr("id").replace("orange_", "");        
	        $.get(deleteUrl, {
	            userContactId: userContactId
	        }, function(data) {  
	            $("#add_person").find("tr").each(
	        		    function() {
	        		        if ($(this).attr("class") == "inspersonDetail") {
	        		            var tdArr = $(this).children();
	        		            var personname = tdArr.eq(0).find("input"); // 名称        		           
	        		            var unitid=personname.attr('id').replace("person_name","");
	        		            var idval=$(this).attr("id").replace("source_user_","");        		          
	        		            if(userContactId==idval){        		            	    			                
	    			                if(unitid==1){
	    			                	initInsuranceInput();			            		
	    			                }else{
	    			                	removeInsuranceInputIds(unitid);
	    				                $(this).remove();
	    				                setPrice('remove');
	    			                }
	        		            }
	        		        }
	        		 })
	        });
    	}
    })
    /**
     * $(".submit").click(function(){ $(".add_person_details").show(); })
     */
    $(".cancel_btn").click(function() {
        checkPolicyholder('cancel');
    })
    $(".makeSure_btn").click(function() {
        checkPolicyholder('makeSure');
    })

    $('#safeticket').hover(function() {
        $('.saferule').show();
    }, function() {
        $('.saferule').hide();
    });
    $("#safeticket").hover(function() {
        $(".safeticket_details_cover").show();
        $(".safeticket_details_cover").hover(function() {
            $(".safeticket_details_cover").show();
        }, function() {
            $('.safeticket_details_cover').hide();
    });
    }, function() {
        $('.safeticket_details_cover').hide();
    })
    $(".details_link").click(function() {
		$(".iframe_for_rule").show();
        $('.details_link_details').show();
    })
	
    $(".makeSure").click(function() {
        $('.details_link_details').hide();
    })    
	$(".selectIdcard").change(function(){ 
		changeidtype("1","");
	}); 
	//添加被保人
	$(".add_person_btn").on("click",function() {
		if(checkInput())
		addInsuranceInputHtml("", idCardCode,"","","","","0");			
	});
	$('.insurance_label input').click(function() {
		if ($(this).parent().next().css('display') == 'inline') {
			$(this).attr('checked', false);
			$(this).parent().next().css('display', 'none');
			$(this).parent().parent().parent().children('.optional').hide();
			$(this).parent().siblings('i').show();
			for (var i = 0; i < $('.tick_math').length; i++) {
				var ticketinput = $('.tick_math')[i];
				var tickets = ticketinput.value;
				if (tickets > 0) {
					ticketinput.value = 0;
					ticketinput.onkeyup();
				}
			}
		   if($(this).attr("id")=="insuranceCB")
		   {
			   removeInsurance();
		   }
			
		} else {
			$(this).attr('checked', true);
			$(this).parent().next().css('display', 'inline');
			$(this).parent().parent().parent().children('.optional').show();
			$(this).parent().siblings('i').hide();
		}
	})	
	//清空
	$(".insExpenses1").click(function() {        
        var checkboxid = $(this).parents(".inspersonDetail").attr("id").replace("source_","");
        // 让checkbox不选中
        if ($("#" + checkboxid)) {
            $("#" + checkboxid).attr("checked", false);
        }            
        initInsuranceInput();
    })       
	checkCity();	
	//初始化选中身份证
    changeidtype("1","");
   //初始化保险日历
	callTimeout('',initInsuranceDate,200); 	
});
/**
 * 初始化页面，选择身份证隐藏生日性别 20160302
 */
function changeidtype(idparam,nation){		
	var nationoption = usercontactManager.nationOption(nationlist);
	var countryoption = usercontactManager.countryOption(countrylist);
	$(".selectIdcard").each(function(){		
		var selectValue = $(this).val();
		var id = $(this).attr("id").replace("person_idtype","");
		if(id==idparam)
		{
			var selectsex = $(this).parent().siblings().children(".selectsex");
			var sexP =selectsex.siblings("p");
			var birthday = $(this).parent().siblings().find(".birthday");			
			var birthdayP = $(this).parent().siblings().children(".birthdayp");	
			var selectNation = $(this).parent().siblings().children(".selectNation");
			    //如果选中的是身份证
		        if(selectValue==idCardCode){	        	        	        	
		        	sexP.html(selectsex.val());
		        	sexP.show();	
		        	selectsex.hide();		        	
		        	birthdayP.html(birthday.val());
		        	birthdayP.show();
		        	birthday.hide();		       
				}else{					
					selectsex.show();
					sexP.html("");
					sexP.hide();
					birthday.show();
					birthdayP.html("");
					birthdayP.hide();
				}		      
		        if(selectValue==passportCode)
		        {
		        	selectNation.html(countryoption);
		        }
		        else
		        {
		        	selectNation.html(nationoption);
		        }
		        if(nation!=null&&nation!='')
		        selectNation.val(nation);
		}
	        
	})
} 
/**
 * 检查城市，，默订打开保险，必须购买
 */
function checkCity()
{
	var cityid = $('#cityid').val();
	//if(cityid!=13 && cityid!=15 && cityid!=45 && cityid!=56 && cityid!=114 && cityid!=144 && cityid!=176){
	if(true){
		$('.insurance_label input').eq(0).click();	
		$('.insurance label input').eq(0).attr("disabled",true);
	}	
}
//全部移除保险
function removeInsurance()
{
	 $("#add_person").find("tr").each(function(index) {		    
	        if ($(this).attr("class") == "inspersonDetail") {	        	
	        	if(index==2)
	        	{
	        		initInsuranceInput();
	        	}
	        	else
	        	{
	        		$(this).remove();
	        	}	
	        }
	 });
	 $("#insuranceInputIds").val("1");
	 $("#usercontactDiv input:checkbox").attr("checked", false);  
	 setPrice("remove");	
}
/**
 * 检查一下身份证类型的合法性
 */
function checkPapertype(papertype,value)
{
	if(papertype==idCardCode)
	{
		var checkFlag = new clsIDCard(value);
		return checkFlag.IsValid();
	}
	else if(papertype==hkmacaoCode)
	{
		return isHKMacao(value);
	}
	else if(papertype==taiwanCode)
	{
		return isTaiwan(value);
	}
	else if(papertype==passportCode)
	{
		return isPassport(value);
	}
	else if(papertype==militaryIDCode)
	{
		return ismilitaryID(value);
	}
	return true;
}
/**
 * 初始化人员输入
 */
function initInsuranceInput()
{
	 $("#person_name1").val("");
     $("#person_idcard1").val("");
     $("#person_birthday1").val("");
     $("#person_sex1").val("");
     //选中身份类型
     $("#person_idtype1").val(idCardCode);
     changeidtype("1","");
}
function checkInput()
{
	//未选择
	if(!$('.insurance label input')[0].checked){		
		return true;
	}	
	else
	$("#isInsurance").val("1");
	var message="";
	var flag=false;
	var focusid="";
	$("#add_person").find("tr").each(
	    function() {
	        if ($(this).attr("class") == "inspersonDetail") {
	            var tdArr = $(this).children();
	            var personname = tdArr.eq(0).find("input"); // 名称		
	            var personsex = tdArr.eq(3).find("select"); // 性别	
	            var personbirthday = tdArr.eq(4).find("input"); //生日	
	            var unitid=personname.attr('id').replace("person_name","");
	            var unitprefix= "person_";
	            var nameval=$("#person_name"+unitid).val();
	            var typeval =$("#person_idtype"+unitid).val();
	            var numberval=$("#person_idcard"+unitid).val();	           
	            if(nameval==""){
	            	message="请填写真实姓名！";
	            	flag =true;
	            	focusid=unitprefix+"name"+unitid;
	            	return false;
	            }	
	            var myreg = /^[a-zA-Z\u4e00-\u9fa5]+$/; // 真实姓名只能添加英文和汉字
	            if(nameval.length<=1 || !myreg.test(nameval)){
	            	message="真实姓名不合法！";
	            	flag =true;
	            	focusid=unitprefix+"name"+unitid;
	            	return false;
	            }
	           if(numberval==""){
        		    focusid=unitprefix+"idcard"+unitid;
        		  	message="请填写证件号码！";
	            	flag =true;
	            	return false;
        	  }
	          else
	          {
	        	  if(!checkPapertype(typeval,numberval))
	        	  {
		        	  focusid=unitprefix+"idcard"+unitid;
		        	  message="填写的证件号码格式不正确！";
		        	  flag =true;
		              return false;
	        	  }
	          }	          
	          if(typeval!=idCardCode){
		            var sexval=$("#"+unitprefix+"sex"+unitid).val();		            
		            if(sexval==""){
		            	  	focusid=unitprefix+"sex"+unitid;
	            		  	message="请选择性别！";
			            	flag =true;
			            	return false;
		            }		  
		            var birthdayval=$("#"+unitprefix+"birthday"+unitid).val();	
		            if(birthdayval==""){
		            	focusid=unitprefix+"birthday"+unitid;
            		  	message="请选择出生日期！";
		            	flag =true;
		            	return false;
		            }
		            var r = /^(\d{4})-(\d{2})-(\d{2})$/;		            
		            if(!r.test(birthdayval)){
		            	focusid=unitprefix+"birthday"+unitid;
            		  	message="出生日期不正确！";
		            	flag =true;
		            	return false;
		            }		
                    var checkinday  = $('#checkinday').val();
                    if(checkinday!='')
                    {
                    	var start =  Date.parse(new Date().format("yyyy-MM-dd"));
			            var end = Date.parse(birthdayval);
			            if( end > start )
			            {
			               //layer.alert('开始时间应小于结束时间！',8);
			            	focusid=unitprefix+"birthday"+unitid;
	            		  	message="出生日期不正确！";
			            	flag =true;
			            	return false;
			            }
                     }
		            //console.log(nameval+"-"+typeval+"-"+numberval+"-"+sexval+"-"+timeval);
	           }    
	          else
	          {
	        	  var idCardObject = new clsIDCard(numberval);
	        	  var birthday = idCardObject.GetBirthDate();	        	 
	        	  personbirthday.val(birthday);	        	 
	        	  var sex = idCardObject.GetSex();	        	
	        	  if(sex==0)
	        		  personsex.val("女");
	        	  else
	        		  personsex.val("男");
	          }
	        }
	 })  	
	 if(flag){
		 $("#"+focusid).focus();
		 alert(message);
		 return false;
	 }	
	 else
	{
		 if(checkSame())
		 {
			alert("证件号码重复");
	    	return false;
		 }
	}
	return true;
}
//自动增加一个输入框
function addInsuranceInputHtml(name,idtype,idcard,sex,birthday,nation,checkboxid) {
	var paperoption = usercontactManager.paperOption(papertypemap);	
    var id = getRandomInputId(2, 1000);
    var td_1 = $("<td class='ntd_div1'></td>");
    	td_1.append($("<input id='person_name"+id+"'  value='" + name + "'  class='name_person'  maxlength=10  autocomplete='off'/>"));
    var td_2 = $("<td class='ntd_div2'></td>");
		td_2.append($("<select id='person_idtype"+id+"'  class='selectIdcard'>"+paperoption+"</select>"));		
	var td_3=	$("<td class='ntd_div3'></td>");
		td_3.append($("<input id='person_idcard" + id + "'  value='" + idcard + "'  class='ID_number'   autocomplete='off'/>"));
	var td_4 = $("<td class='ntd_div4'></td>");
		td_4.append($("<p  style=\"text-indent: 20px;\"></p><select id='person_sex" + id + "'  value='" + name + "'  class='selectsex'><option value=''>请选择</option><option value='男'>男</option><option value='女'>女</option></select>"));
	var td_5 = $("<td class='ntd_div5'></td>");
		td_5.append($("<p  class='birthdayp'  style=\"text-indent: 20px;\"></p><input type=\"text\"   readonly=\"true\"  class=\"J_Select birthday\" autocomplete=\"off\" id=\"person_birthday"+id+"\" style='display:none'>"));
	var td_6=$("<td class='ntd_div6'></td>");
		td_6.append($("<b class='orange'>￥" + payunitpriceYuan + "×" + "<span>"+$("#nights").text() + "</span>天</b>"));
	var td_7 = $("<td class='ntd_div7 bon' id='del_" + id + "'></td>");
		td_7.append("<a class='insExpenses'  rel='nofollow' id='del_" + id + "'>删除</a>");		
	var td_8 = $("<td class='ntd_div2'></td>"); 
	    td_8.append($("<select  class='selectNation' id='person_nation" + id + "'></select>"))
    var newDiv = $("<tr class='inspersonDetail' id='source_" + checkboxid + "' ></tr>");
    newDiv.append(td_1);
    newDiv.append(td_2);
	newDiv.append(td_3);
    newDiv.append(td_4);
	newDiv.append(td_5);
    newDiv.append(td_6);
    newDiv.append(td_8);
	newDiv.append(td_7);
    $("#add_person").append(newDiv);
    //选中身份类型
    $("#person_idtype"+id).val(idtype);
    //选中性别
    $("#person_sex" + id).val(sex); 
    //选中生日
    $("#person_birthday" + id).val(birthday); 
    // 防止某些浏览器取不到值
    $("#source_" + checkboxid).attr("class", "inspersonDetail");
    $("#source_" + checkboxid).attr("id", "source_" + checkboxid);
    $("#person_idcard" + id).attr("id", "person_idcard" + id);
    $("#person_name" + id).attr("id", "person_name" + id);
    $("#person_sex" + id).attr("id", "person_sex" + id);
    $("#person_birthday" + id).attr("id", "person_birthday" + id);
    // 重新设置一下属性,删除的时候
    $(".insExpenses").unbind();
    $(".insExpenses").click(function() {    
	        var id = $(this).attr("id").replace("del_", "");       
	        var checkboxid = $(this).parents(".inspersonDetail").attr("id").replace("source_","");
	        // 让checkbox不选中
	        if ($("#" + checkboxid)) {
	            $("#" + checkboxid).attr("checked", false);
	        }    
	        removeInsuranceInputIds(id);
	        $(this).parents(".inspersonDetail").remove();
	        setPrice('remove');    	
    })
    addInsuranceInputIds(id);   
    setPrice('add');
    $("#person_idtype"+id).unbind().on("change",function() {
	   changeidtype(id,nation);
    });     	
   //如果是身份证隐藏生日和性别
    changeidtype(id,nation);
   //初始化保险日历
	callTimeout('',initInsuranceDate,200); 
}
/**
 * 用常用联系人来设置被保人
 *
 * @param obj
 */

function setUserContact(obj) {
	var hasInsur = $('.insurance label input')[0].checked;
	if(hasInsur){
	    var defaultstr = "";
	    var checkboxid = obj.id;
	    var name = $("#" + checkboxid).val().split("_")[0];
	    var idtype = $("#" + checkboxid).val().split("_")[1];
	    var idcard = $("#" + checkboxid).val().split("_")[2];	
	    var sex = $("#" + checkboxid).val().split("_")[3];
	    var birthday = $("#" + checkboxid).val().split("_")[4];	
	    var country= $("#" + checkboxid).val().split("_")[5];
	    var nation= $("#" + checkboxid).val().split("_")[6];
	    nation = usercontactManager.defaultValue(country,nation);
	    // 增加
	    if (obj.checked) {
	        var ishave = false;
	        // 先看有没有空的，如果有空的就填，没有就新增一个
	        $("#add_person").find("tr").each(function() {
	            if ($(this).attr("class") == "inspersonDetail") {
	                var tdArr = $(this).children();
	                var personname = tdArr.eq(0).find("input"); // 名称
	                var personidtype = tdArr.eq(1).find("select"); 	                
	                var personidcard = tdArr.eq(2).find("input"); // idcardnumber
	                var personsex = tdArr.eq(3).find("select"); // sex
	                var personbirth = tdArr.eq(4).find("input"); // birth	
	                var id = personname.attr("id").replace("person_name","");
	                if (!ishave && (personname.val() == "" || personname.val() == defaultstr) && (personidcard.val() == "" || personidcard.val() == defaultstr)) {
	                    personname.val(name);
	                    //选中身份类型
	                    personidtype.val(idtype);	                                       	                  
	                    personidcard.val(idcard);	                    
	                    //选中性别
	                    personsex.val(sex);
	                    personbirth.val(birthday);	                  
	                    $(this).attr("id", "source_" + checkboxid);	                   
	                    ishave = true;
	                    changeidtype(id,nation);	
	                }
	            }
	        });
	        if (!ishave) {	        
	            addInsuranceInputHtml(name, idtype,idcard,sex,birthday,nation,checkboxid);	            
	        }
	      
	    }else {// 删除
	        if ($("#source_" + checkboxid)) {	        	
	            var tdArr = $("#source_" + checkboxid);
	            var personname = tdArr.eq(0).find("input"); // 名称
	            var personnameid = (personname.attr("id")).replace("person_name", "");	           
	            if (personnameid == "1") {
	            	initInsuranceInput();
	            } else {
	                removeInsuranceInputIds(personnameid);
	                $("#source_" + checkboxid).remove();
	                setPrice('remove');
	            }
	        }
	    }
	}
}
/**
 * 提交订单时获得保险人的数据
 * @returns {String}
 */
function getInsuranceJson()
{
	var insuranceJson = '';
	var ids = $("#insuranceInputIds").val();
	var commonStr = "person";
	for (var i = 0; i < ids.split(",").length; i++) {
		var realid = ids.split(",")[i];
		var realname = $("#" + commonStr + "_name" + realid).val();
		var idtype = $("#" + commonStr + "_idtype" + realid).val();
		var idcard = $("#" + commonStr + "_idcard" + realid).val();
		var sex = $("#" + commonStr + "_sex" + realid).val();
		var birthday = $("#" + commonStr + "_birthday" + realid).val();
		var nation = $("#" + commonStr + "_nation" + realid).val();
		var country="";
		if(idtype==passportCode)
		{
			country = nation;
			nation = "";
		}
		else
		{
			country="中国";
		}
		var id = $("#" + commonStr + "_birthday" + realid).parent().parent().parent().attr("id");			
		if(id.indexOf("source_user_")>-1)
		{
			id = id.replace("source_user_","");
		}
		else
		{
			id="0";
		}		
		insuranceJson += '{realname:"' + realname + '",idtype:' + idtype
				+ ',idcard:"' + idcard + '",sex:"' + sex + '",birthday:"'
				+ birthday + '",id:"'+id+'",country:"'+country+'",nation:"'+nation+'"},';
	}
	insuranceJson = '['+ insuranceJson.substring(0, insuranceJson.length - 1) + ']';
	return insuranceJson;
}
////////////////因为涉及到删除,ID重复/////////////////
/**
 * 获得随机ID
 *
 * @param from
 * @param to
 * @returns {String}
 */

function getRandomInputId(from, to) {
    var ids = $("#insuranceInputIds").val();
    var id = "";
    while (id == "") {
        var randomid = Math.ceil(Math.random() * (to - from)) + from;
        if (("," + ids + ",").indexOf("," + randomid + ",") < 0) id = randomid;
    }
    return id;
}
/**
 * 增加ID串
 *
 * @param id
 * @returns
 */

function addInsuranceInputIds(id) {
    var ids = $("#insuranceInputIds").val();
    if (ids == "") {
        ids += id;
    } else {
        ids += "," + id;
    }
    $("#insuranceInputIds").val(ids);
    return ids;
}
/**
 * 删除ID串
 *
 * @param id
 * @returns
 */

function removeInsuranceInputIds(id) {
    var ids = $("#insuranceInputIds").val();
    var idsarry = ids.split(",");
    var newids = "";
    for (var i = 0; i < idsarry.length; i++) {
        if (id == idsarry[i]) continue;
        if (newids == "") {
            newids += "" + idsarry[i];
        } else {
            newids += "," + idsarry[i];
        }
    }
    $("#insuranceInputIds").val(newids);
    return ids;
}
////////////////////////////////////////////
// 改变价格
function setPrice(type) {
    var peopleNum = $(".inspersonDetail").length;
    var dayNum = parseFloat($("#nights").text());
    var moneyunitYuan = parseFloat(payunitpriceYuan);
    //var insuranceStr = '￥' + moneyunitYuan + '/天×' + dayNum + '天×' + peopleNum + '人-蚂蚁赠送1人份';
    var insurancePriceShow = ((peopleNum - 1) * dayNum * moneyunitYuan).toFixed(2);
    var ordertotalPriceShow = (parseFloat($("#showtotalprice").text()) + parseFloat(insurancePriceShow)).toFixed(2);
    $("#insurancePriceShow").html(insurancePriceShow);
    //$("#actuallytotalprice").html(ordertotalPriceShow);
   
    if(insurancePriceShow&&insurancePriceShow!='0.00'){
		//$('#s_insurance').show();
		$("#insuranceprice").html("￥"+insurancePriceShow);
		//$("#insurancestr").html(insuranceStr);
	}else{    
		//$('#s_insurance').hide();
		$("#insuranceprice").html("免费");
   	    //$("#insurancestr").html("");
	} 
    if(peopleNum>=1){
    	$('#tr_insurance').show();
	}else{
    	$('#tr_insurance').hide();
	}    
    //$("#insurance_price_2").html(insurancePriceShow);
    var ordertotalprice = 0;
    var onlineAmount = 0;
    // 以分为单位，
    var insurancePrice = (peopleNum - 1) * dayNum * moneyunitYuan * 100;
    
    var onlinePayAmountShow = null;
    
    if (type != 'init') {
        if (type == 'add') {
            onlinePayAmountShow = (parseFloat($("#onlinePayAmountShow").text()) + parseFloat(dayNum * moneyunitYuan)).toFixed(2);
            ordertotalprice = parseInt($("#totalPrice").val()) + parseInt(dayNum * moneyunitYuan * 100);
            onlineAmount = parseInt($("#onlineAmount").val()) + parseInt(dayNum * moneyunitYuan * 100);
        } else {
            onlinePayAmountShow = (parseFloat($("#onlinePayAmountShow").text()) - parseFloat(dayNum * moneyunitYuan)).toFixed(2);
            ordertotalprice = parseInt($("#totalPrice").val()) - parseInt(dayNum * moneyunitYuan * 100);
            onlineAmount = parseInt($("#onlineAmount").val()) - parseInt(dayNum * moneyunitYuan * 100);
        }
    } else {
        onlinePayAmountShow = (parseFloat($("#onlinePayAmountShow").text()) + parseFloat(insurancePriceShow)).toFixed(2);
        ordertotalprice = parseInt($("#totalPrice").val()) + parseInt(insurancePrice);
        onlineAmount = parseInt($("#onlineAmount").val()) - parseInt(insurancePrice);
        var insuranceInputIds = $("#insuranceInputIds").val();
        if (peopleNum != insuranceInputIds.split(",").length) $("#insuranceInputIds").val("1");
        $(".ntd_div6").find("span").html($("#nights").text());
    }    
    //$("#onlinePayAmountShow").html(onlinePayAmountShow);
    //$("#onlinePayAmount").val(onlinePayAmountShow);
    // 重新初始化价格，给隐藏域赋值
    // $("#showtotalprice").text(detialJson.showtotalprice);   
    $("#peopleNum").html(peopleNum);
    $("#totalPrice").val(ordertotalprice);
    $("#onlineAmount").val(onlineAmount);
     //￥<i id="show_ticket_price">0</i>   
    if(peopleNum>1)
        $("#rightInsurancePrice").html("￥"+insurancePriceShow);
    else
    	$("#rightInsurancePrice").html("免费");
    setCuponPrice();
}

function getInsurancePriceShow()
{
	 var peopleNum = $(".inspersonDetail").length;
	 var dayNum = parseFloat($("#nights").text());
	 var moneyunitYuan = parseFloat(payunitpriceYuan);
	 var insurancePriceShow = ((peopleNum - 1) * dayNum * moneyunitYuan).toFixed(2);
	 
	 return insurancePriceShow;
}
//选择优惠券的时候对价格的影响  
function setCuponPrice() {
    var isRadio = false;
    var amountShow = 0;
    /**
    $("#coupon").find(":radio:checked").each(function() {
        amountShow = $(this).attr("amountShow");
        isRadio = true;
    });
    if (!isRadio) {
        $("#coupon").find(":checkbox:checked").each(

        function() {
            amountShow = (parseFloat(amountShow) + parseFloat($(this).attr("amountShow"))).toFixed(2);
        });
    }*/
    var couponval = $('.jianmq').attr('couponval');
    if(typeof(couponval)!='undefined'){
    	amountShow = couponval;
    } 
    var insurancePriceShow=getInsurancePriceShow();
    var ticketPriceShow = ticketManager.sumPrice/100  ; 
    
    var ordertotalPriceShow = (parseFloat($("#orderroomprice").val()) + parseFloat(insurancePriceShow)+parseFloat(ticketPriceShow)).toFixed(2);
    $("#actuallytotalprice").html(ordertotalPriceShow);
    
    var onlinePayAmountShow = (parseFloat($("#onlinePayAmount").val())  - parseFloat(amountShow)).toFixed(2);   
    if (onlinePayAmountShow < 0) {
        onlinePayAmountShow = '0.00';
        $("#promotionAmount").text('-' + (parseFloat($("#onlinePayAmount").val())).toFixed(2));
    } else {
        $("#promotionAmount").text('-' + amountShow);
    }    
    onlinePayAmountShow = (parseFloat(onlinePayAmountShow) + parseFloat(insurancePriceShow)+ parseFloat(ticketPriceShow)).toFixed(2);    
    $("#onlinePayAmountShow").html(onlinePayAmountShow);
}
//检查是否有重复的身份证号码
function checkSame() {
    var idcardArray = new Array();
    var i = 0;
    var error = false;
    $("#add_person").find("tr").each(function() {
        if ($(this).attr("class") == "inspersonDetail") {
            var tdArr = $(this).children();
            var personidcard = tdArr.eq(2).find("input"); // idcard			
            // alert(obj.parent(".safe_half_col").children("span").html());
            if (contains(idcardArray, personidcard.val())) {
                error = true;
                return;
            }
            idcardArray[i] = personidcard.val();
            i++;
        }
    })
    return error;
}
///////////////////////保险日期/////
function initInsuranceDate(){
	var checkin = '1910-01-01';
	//var checkout =  getYesterday($('#checkinday').val());
	var checkout =  new Date().format("yyyy-MM-dd");
	birthdayCalendar(checkin,checkout);	
}
var oCalBirthday;
function birthdayCalendar(fcheckin,fcheckout){
	try{
	  	YUI({}).use('trip-calendar', function(Y) {
				/**
				 * 弹出式日历实例
				 * 将日历与指定的触发元素绑定
				 * 日历可根据浏览器窗口大小，自动调整显示位置
				 */
	  		oCalBirthday = new Y.TripCalendar({
		  		//绑定日历的节点，支持选择器模式，可批量设置（必选）
					triggerNode: '.birthday',					
					minDate: fcheckin,
					maxDate: fcheckout,
					count : '1',
					isSelect: true
				});
	
	  		oCalBirthday.on('dateclick', function(e) {
					//this.getCurrentNode().setAttribute('data-date', e.date);
				});
	
				//显示日历时自定义事件
	  		oCalBirthday.on('show', function() {					
					//this.set('date','');					
				});
	
				//解决chrome的foucs事件bug
				Y.on('click', function(e) {e.currentTarget.focus();}, 'button, .J_Link');
			}); 
	}catch(e){
		console.log(e);
	}
}
function getYesterday(datetime)
{		
	var today=new Date(datetime); //月份为0-11
	var yesterday_milliseconds=today.getTime()-1000*60*60*24;
	var yesterday=new Date();
	yesterday.setTime(yesterday_milliseconds);

	var strYear=yesterday.getFullYear();
	var strDay=yesterday.getDate();
	var strMonth=yesterday.getMonth()+1;
	if(strMonth<10)
	{
	  strMonth="0"+strMonth;
	}
	var strYesterday=strYear+"-"+strMonth+"-"+strDay;
	return strYesterday;
}
//判断数组内是否存在
function contains(arr, obj) {
    var i = arr.length;
    while (i--) {
        if (arr[i] === obj) {
            return true;
        }
    }
    return false;
}
Date.prototype.format = function(format) {
    var o = {
        "M+": this.getMonth() + 1,
        //month
        "d+": this.getDate(),
        //day
        "h+": this.getHours(),
        //hour
        "m+": this.getMinutes(),
        //minute
        "s+": this.getSeconds(),
        //second
        "q+": Math.floor((this.getMonth() + 3) / 3),
        //quarter
        "S": this.getMilliseconds() //millisecond
    }

    if (/(y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }

    for (var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
 }
