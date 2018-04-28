/*自动获取订单列表优惠金额*/
function OrderCouponList(order_id)
{
	 var UrlParam ={
	 	order_id: order_id
	  };
	 $.ajax({
	        type: "GET",
	        async:true, 
	        url: "/GaoDuAdmin/Orders/tenantCoupon.html",
	        data: UrlParam,
	        dataType: "json",       /*设置返回值类型为json*/
	        success: function(json) {
	          if(json!=null){
				$("#"+json.order_id).text(json.coupon_money);
	    	  }
	        }
	  });	
}


/*自动获取订单列表操作人*/
function OrderOperator(order_id)
{
	 var UrlParam ={
	 	order_id: order_id
	  };
	 $.ajax({
	        type: "GET",
	         async:true, 
	        url: "/GaoDuAdmin/Orders/orderOperator.html",
	        data: UrlParam,
	        dataType: "json",       
	        success: function(json){
     	      	$("."+json.order_id).text(json.oper_id);
	        }
	  });	
}

/*获取房东姓名*/
function OrderLandlord(order_id)
{
	 var UrlParam ={
	 	order_id: order_id
	  };
	 $.ajax({
	        type: "GET",
	        cache: false,
	        url: "/GaoDuAdmin/Finance/orderLandlord.html",
	        data: UrlParam,
	        dataType: "json",       
	        success: function(json) {
	        console.log(json);
				$("#"+json.order_id).text(json.name);
	        }
	  });	
}


/*联系获取房东姓名*/
function LandlordName(mobile)
{  
	 var UrlParam ={
	 	mobile: mobile
	  };
	 $.ajax({
	        type: "GET",
	        cache: false,
	        url: "/GaoDuAdmin/ContactOwner/landlordName.html",
	        data: UrlParam,
	        dataType: "json",       
	        success: function(json) {
				$("."+json.mobile).text(json.true_name);
	        }
	  });	
}

/*获取回复数*/
function CircleReply(replay_id){
    var UrlParam ={
	 	id: replay_id
	  };
	 $.ajax({
	        type: "GET",
	        cache: false,
	        url: "/GaoDuAdmin/CircleManage/getAjaxCircleReply.html",
	        data: UrlParam,
	        dataType: "json",       
	        success: function(json) {
				$("#"+json.circle_id).text(json.sumreplay_cnt);
	        }
	  });
}
