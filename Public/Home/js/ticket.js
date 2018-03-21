/**
 * 门票管理
 * */
var ticketManager = { 
	selectTicketItems:new ItemList(),	//选中的门票
	tItems:new ItemList(), //门票对象列表
	
	sumPrice:0, //选中门票总价
	sumTickets:0,//选中的票张数   add by xuwei
	/**
	 * 门票数量更改
	 * */
	increaseNum:function (id,num,max)
	{
		var fNum=0; 
		try
		{ 
			var sNum = $('#num_'+id).val().replace(/[^\d.]/g,'');
			var tNum =0;
			if(sNum!='')
			{
				tNum =  parseInt(sNum); 
			} 
			
			if(num==0)
			{ 
				fNum = tNum;
			}else
			{
			 		fNum = tNum+num;
			}
			if(fNum<=0)
			{
	 			fNum=0;
			}else if(fNum>max)
			{
				fNum=max;
			}
		}
		catch(e)
		{
		 
		}
		
		$('#num_'+id).val(fNum);
		if(fNum==0)
		{
			var d = this.selectTicketItems.get(id);
			if(d)
			{
				$('#'+d.dateObjId+'_tip').text('');
				this.selectTicketItems.del(id);	
			}
		}else{
			var d = this.selectTicketItems.get(id);
			if(d)
			{
				d.num=fNum;
			}else
			{
				var ticketDetail=$('#ticket_detail_'+id);
				var specialP = parseInt(ticketDetail.attr('specialPrice'));
				var discountP = parseInt(ticketDetail.attr('discountPrice'));
				d =  {"code":id,
					  "num":fNum,
					  "specialPrice":specialP,
					  "discountP":discountP,
					  "dateObjId":'ticket_date_'+id
					  };
				this.selectTicketItems.put(d);
			}
		}
		 
		this.buildParam();
		//计算价格
		this.calculation()
		//重新绘制
		this.redrawPrice();
		setCuponPrice();
	},
	/**
	 * 创建参数
	 * */
	buildParam:function()
	{
		this.tItems.empty();
		var ticketStr='';
		for(var i=0;i<this.selectTicketItems.length;i++)
		{
			var item = this.selectTicketItems.items[i];
			var dateObjId = item.dateObjId;
			var useDate = $('#'+dateObjId).val();
			if(useDate==''||useDate=='请选择')
			{
				//$('#'+dateObjId+'_tip').text('日期不可空');
			}
			var isSpecialPrice= false;
			var usedSp = $('#usedSpecial').val();
			if(i==0&&usedSp!='used')
			{
				isSpecialPrice = true;
			}
			var d={'code':item.code,
				   'id':item.code,
				   'isSpecialPrice':isSpecialPrice,
				   "bookNum":item.num,
				   "useDate":item.useDate
				   }
			this.tItems.put(d);
		}
		if(this.tItems.length==0)
		{
			$('#tr_ticket').hide();
		}else
		{
			$('#tr_ticket').show();
		}
		ticketStr= JSON.stringify(this.tItems.items); 
		
		$('#ticketList').val(ticketStr);
	},
	/**
	 * 日期验证
	 * */
	dateValid:function()
	{
		for(var i=0;i<this.selectTicketItems.length;i++)
		{
			var item = this.selectTicketItems.items[i];
			var dateObjId = item.dateObjId;
			var useDate = $('#'+dateObjId).val();
			var sCheckIn = $('#checkinday').val();
			var sCheckOut = $('#checkoutday').val();
			if(useDate==''||useDate=='请选择')
			{
				//$('#'+dateObjId).focus();
				return '请选择门票游览日期';
			} 
			else if(useDate<fcheckin||useDate>fcheckout)
			{
				return '门票游览日期必须在指定期间内';
			}
			else
			{
				 item.useDate=useDate;
			}
		}
		this.buildParam();
		return '';
	},
	
	/**
	 * 
	 * 金额计算
	 * */
	calculation:function(id)
	{
		var items = this.selectTicketItems.items;
		ticketManager.sumPrice=0;
		ticketManager.sumTickets=0;
		for(var i=0;i<this.selectTicketItems.length;i++)
		{
			var tSumPrice = 0;
			var d= items[i];
			var usedSp = $('#usedSpecial').val();
			if(i==0&&usedSp!='used')
			{
				d.sumPrice =parseInt(d.specialPrice)+parseInt((d.num-1)*d.discountP);
			}else
			{
				d.sumPrice = parseInt(d.num*d.discountP);
			}
			ticketManager.sumPrice+=d.sumPrice;
			ticketManager.sumTickets+=d.num;
		} 
	},
	/**
	 * 门票数据修改后重绘价格相关
	 * */
	redrawPrice:function()
	{
		 var oldPayTicketP = parseFloat($('#pay_ticket_price').text()).toFixed(2);
		 var onlinePayAmountShow = parseFloat( $('#onlinePayAmountShow').text()).toFixed(2)-oldPayTicketP+ticketManager.sumPrice/100;
		 $('#onlinePayAmountShow').text(onlinePayAmountShow.toFixed(2));
		 
		 
		 $('#sum_ticket_price').text(ticketManager.sumPrice/100);
		 $('#selectedTotal').text(ticketManager.sumTickets);
		 $('#ticketspriceTot').text(ticketManager.sumPrice/100);
		 if(ticketManager.sumPrice/100==0){ 
			 $('#s_ticket').hide();
		 }else
		 {
			 $('#s_ticket').show();
		 }
		 
		 $('#pay_ticket_price').text(ticketManager.sumPrice/100);
		 
		 $('#show_ticket_price').text(ticketManager.sumPrice/100);
		 
		 //遍历所有门票
		 var stids = $('#stids').val();
		 if(stids!='')
		 {
			var stidArray = stids.split(',')
			for(var i=0;i<stidArray.length;i++)
			{ 
				var ticketDetail=$('#ticket_detail_'+stidArray[i]);
				var specialP = parseInt(ticketDetail.attr('specialPrice'));
				var discountP = parseInt(ticketDetail.attr('discountPrice'));
				
				var originalP = parseInt(ticketDetail.attr('originalPrice'));
				var usedSp = $('#usedSpecial').val();
				if(this.selectTicketItems.length==0&&usedSp!='used')
				{
					 $('#ticket_s_price_'+stidArray[i]).text('￥'+specialP/100);
					 $('#ticket_d_price_'+stidArray[i]).text('￥'+discountP/100);
					 $('#ticket_d_price_'+stidArray[i]).removeClass(); 
					 $('#ticket_d_price_'+stidArray[i]).addClass("c999 linethrough fontsize12"); 
					 //$('#ticket_o_price_'+stidArray[i]).text('￥'+originalP/100);
				}
				else
				{
					//去掉所有特殊价
					 $('#ticket_s_price_'+stidArray[i]).text(''); 
					 
					 //折扣价变红
					 $('#ticket_d_price_'+stidArray[i]).removeClass();
					 $('#ticket_d_price_'+stidArray[i]).addClass("cf80");
					 // $('#ticket_d_price_'+stidArray[i]).css("text-decoration","none");
					  // $('#ticket_d_price_'+stidArray[i]).css("color","red");
					  
					// $('ticket_o_price_'+stidArray[i]).text(''); 
				} 
			}
		 }
		 
	}
	
}
$(function(){
	$('#ticketinfo').hover(function() {
		$('.ticketinfo').show();
	}, function() {
		 $('.ticketinfo').hide();
	});
	$(".ticketinfo").hover(function() {
			$(this).show();
	}, function() {
			 $(this).hide();
	});
	$(".ticket_link").click(function() {
		$('.ticket_link_details').show();
	})
	$(".makeSure").click(function(){
		$(this).parent(".offmax1").parent(".ticket_link_details").hide();
	}) 
});

