//景点服务数量
$(function() {
	$('.jia')
			.click(
					function() {
						var t = $(this).parents('td').prev().children('i')
								.text();
						var d = $(this).parents('tr').prev()
						$(this).prevAll('.jian').removeClass('jian_no');
						i = parseInt($(this).prev().val());
						i++;

						fn_Jiaj2();
						if ($(this).parents('td').next().find('.ticket_date')
								.val() == '') {

							$(this).parents('td').next().find('.ticket_date')
									.addClass('no_wans');
						} else {
							$(this).parents('td').next().find('.ticket_date')
									.removeClass('no_wans');
						}
					})

	$('.jian')
			.click(
					function() {
						var t = $(this).parents('td').prev().children('i')
								.text();
						i = parseInt($(this).next().val()) - 1;

						if (i < 0) {
							$(this).addClass('jian_no');
							$('.ticket_date').blur(function() {
								$(this).removeClass('no_wans');
							})
							$(this).parents('td').next().find('.ticket_date')
									.removeClass('no_wans');
							return false;
						}
						if ($(this).parents('td').next().find('.ticket_date')
								.val() == '') {

							$(this).parents('td').next().find('.ticket_date')
									.addClass('no_wans');
						} else {
							$(this).parents('td').next().find('.ticket_date')
									.removeClass('no_wans');
						}
						i--;
						fn_Jiaj2();
					})
	function fn_Jiaj2() {
		$('.ticket_date').focus(function() {
			$(this).removeClass('no_wans');
		})
		$('.ticket_date').blur(
				function() {
					var this_i = $(this)
					setTimeout(function() {
						if (this_i.val() == '') {
							if (this_i.parents('td').prev().find('.tick_math')
									.val() >= 1) {
								this_i.addClass('no_wans');
							}

							this_i.removeClass('no_wans');
						}
					}, 200)

				})
	}
})

$(function() {

	/* 无可用代金券时文本框的颜色 */
	if ($('.dianj4').parent().next().text() == '无优惠券可用') {
		$('.dianj4').children('i').addClass('no_dian4');
	} else {
		$('.dianj4').children('i').removeClass('no_dian4');
	}
	// 预订信息点击更多

	$('.more').click(function() {
		$('.c_bar_box').show();
		$(this).hide();
	})

	// 点击选择人数
	fn1('.dianj');
	fn1('.dianj2');
	fn1('.dianj4');
	fn1('.dianj5');
	fn1('.dianj6');
	fn1('.dianj7');
	function fn1(obj) {
		$(obj)
				.on(
						'click',
						function(event) {
							
							event.stopPropagation();
							
							var po = $(this).children('.dingw').css(
									'background-position');
							if ($(this).hasClass('dianj4')) {

							}
							if (po == '0px 0px') {

								/* 有无优惠券可用 */
								if (obj == '.dianj4') {
									if ($(obj).parent().next().text() == '无优惠券可用') {
										$('.dingw').css('background-position',
												'0 0');

										$('.people').hide();
										$(this).children('.dingw').css(
												'background-position',
												'-26px 0');
										$(this).next().next().show();
										$('.noQuan li')
												.click(
														function() {

															$('.dingw')
																	.css(
																			'background-position',
																			'0 0');
															$('.noQuan').css(
																	'display',
																	'none');
														})
										return false;
									} 
								} 
								
								$('.noQuan').hide();
								$('.people').hide();
								$('.dingw').css('background-position', '0 0');
								$(this).children('.dingw').css(
										'background-position', '-26px 0');
								$(this).next().show();

								$(this).next().children('li').click(
										function() {
											var change = false;
											if ($(this).parent().hasClass(
													'havDai')) {
												try
												{ 
													change = $(this).parent().find('.on').val()==1;
												}catch(e)
												{ 
													console.log(e);
												}
												$(this).siblings().removeClass(
														'on');
												$(this).addClass('on');
											}
											var couponid = $(this).attr('value')
											var amountShow = $(this).attr('amountShow');
											var coupontype = $(this).attr('coupontype');
											var litext = $(this).text(); 
											if(change&&couponid!=1)
											{ 
												if(couponid==0)
												{
													ajaxOrderDetial(0,couponid);
												}else
												{
													ajaxOrderDetial(0);
												}
											}
											else if(couponid==1)
											{ 
												ajaxOrderDetial(1);
											}  
											else
											{
												$('.jianmq').text('-￥' + amountShow); 
												$('.dianj4 i').text(litext); 
												$('#ctip').text('优惠券');
											} 
											$('.jianmq').attr('id', couponid);
											$('.jianmq').attr('couponval',amountShow);
											if (coupontype == 1) {
												$('#coupon_checkbox').val(couponid);
												$('#promotiontype').val(1);
											}
											if (coupontype == 2) {
												$('#coupon_checkbox').val(couponid);
												$('#promotiontype').val(2);
											}
											if (coupontype == 0) {
												$('#coupon_checkbox').val('');
												$('#coupon_radio').val('');
												$('#promotiontype').val(0);
											}
											if(change||couponid==1){
												
											}else{
												setCuponPrice();
											}
											$(this).parent().css('display',
													'none');
											$(this).parent().prev().children(
													'span').css(
													'background-position',
													'0px 0px');
										})

							} else {
								$('.people').hide();
								$('.noQuan').hide();
								$('.dingw').css('background-position', '0 0');
								if ($.browser.version == "8.0") {
									$(this).children('span').css(
											'background-position-x', '0px');
									$(this).children('span').css(
											'background-position-y', '0px');
									$('.people').hide();
									$('.noQuan').hide();
								}
							}

						})

	}
	$(document).click(function() {
		$('.people').hide();
		$('.noQuan').hide();
		$('.dingw').css('background-position', '0px 0px');
	})

	/* 入住人信息 */

	var t = "<tr>";
	t += "<td class='td2_1'><input type='text' value='' class='name_person'/></td>";
	t += "<td class='td2_2'><div class='fl relave people_in1 in_tab IE_border'><div class='dianj5 dianj_tab' style='background:#fff;'><i>身份证</i><span class='asote dingw dingw_tab'></span></div>";
	t += "<ul class='people people_tab'><li class='on'>身份证</li><li>港澳通行证</li><li>台湾通行证</li><li>军官证</li><li>护照</li></ul></div></td>";
	t += "<td class='td2_1 td2_1_sfzh relave'><input type='text' value='' class='shenfz'/><div class='yout absot'><span class='absot'></span>格式错误，请重新输入</div></td>";
	t += "<td class='td2_2'><div class='fl relave people_in people_in1 in_tab IE_border'><div class='dianj6 dianj_tab' style='background:#fff;'><i>汉族</i><span class='asote dingw dingw_tab'></span></div>";
	t += "<ul class='people people_tab'><li class='on'>汉族</li><li>2人</li><li>3人</li></ul>";
	t += "</div></td><td class='td3 bon'><div class='td_div3 td_div_5'><span>删除</span></div></td></tr>";

	/* 添加入住人数 */
	$('.add_btn').on('click', function() {
		var tab = $(this).parent().next();
		tab.append(t);
		tab.find('tr').eq(1).find('.td_div_5 span').text('删除');
		$('.sub_ruz').addClass('on_sub').removeClass('no_sub');
	})
	$('.check_peo input')
			.on(
					'click',
					function() {
						var this_T = $(this);
						var offOn = true;
						var onOff = true;
						var d = $(this).parent().text();
						var t = "<tr>";
						t += "<td class='td2_1'><input type='text' value='" + d
								+ "' class='name_person'/></td>";
						t += "<td class='td2_2'><div class='fl relave people_in1 in_tab IE_border'><div class='dianj5 dianj_tab' style='background:#fff;'><i>身份证</i><span class='asote dingw dingw_tab'></span></div>";
						t += "<ul class='people people_tab'><li class='on'>身份证</li><li>港澳通行证</li><li>台湾通行证</li><li>军官证</li><li>护照</li></ul></div></td>";
						t += "<td class='td2_1 td2_1_sfzh relave'><input type='text' value='' class='shenfz'/><div class='yout absot'><span class='absot'></span>格式错误，请重新输入</div></td>";
						t += "<td class='td2_2'><div class='fl relave people_in people_in1 in_tab IE_border'><div class='dianj6 dianj_tab' style='background:#fff;'><i>汉族</i><span class='asote dingw dingw_tab'></span></div>";
						t += "<ul class='people people_tab'><li class='on'>汉族</li><li>2人</li><li>3人</li></ul>";
						t += "</div></td><td class='td3 bon'><div class='td_div3 td_div_5'><span>删除</span></div></td></tr>";

						if (this_T.attr('checked') == 'checked') {
							$('.sub_ruz').addClass('on_sub').removeClass(
									'no_sub');
							/* 如果表格内有此人信息 */
							$('.tab_in tr').each(function() {
								var i = $(this).find('.name_person').val();
								if (i == d) {
									offOn = false;
									return false;
								}
							})

							/* 如果表格中无此人信息 */
							if (offOn) {
								$('.check_in1 .tab_in tr')
										.each(
												function() {
													if ($(this).find(
															'.name_person').length >= 1) {

														var j = $(this).find(
																'.name_person')
																.val();
														if (j == ''
																|| j == ' '
																|| j == 'undefined'
																|| j == null) {

															onOff = false;
															var index = $(this)
																	.index();
															$(this).remove();
															if (index - 1 == 0) {
																$(
																		'.check_in1 .tab_in tr')
																		.eq(
																				index - 1)
																		.after(
																				t);
																$(
																		'.check_in1 .tab_in tr')
																		.eq(
																				index)
																		.find(
																				'.td_div_5 span')
																		.text(
																				'清空');
																return false;
															}
															$(
																	'.check_in1 .tab_in tr')
																	.eq(1)
																	.find(
																			'.td_div_5 span')
																	.text('删除');
															$(
																	'.check_in1 .tab_in tr')
																	.eq(
																			index - 1)
																	.after(t);
															return false;
														}
													}

												})

								if (onOff) {
									$('.check_in1 .tab_in tr').eq(1).find(
											'.td_div_5 span').text('删除');
									$('.check_in1 .tab_in').append(t);
								}

							}

						} else {
							var num = $('.tab_in tr').length;
							if (num > 3) {
								$('.tab_in tr').each(function() {
									var i = $(this).find('.name_person').val();
									if (i == d) {
										$(this).remove();
									}
								})
							} else if (num == 3) {
								$('.tab_in tr').each(function() {
									var i = $(this).find('.name_person').val();
									if (i == d) {
										$(this).remove();
									}
								})
								$('.check_in1 .tab_in tr').eq(1).find(
										'.td_div_5 span').text('清空');
							} else if (num == 2) {
								$('.tab_in tr').each(function() {
									var i = $(this).find('.name_person').val();
									if (i == d) {
										$(this).remove();
									}
								})
								$('.check_in1 .tab_in tr').eq(1).remove();
								$('.check_in1 .tab_in tr').eq(0).after(t);
								$('.check_in1 .tab_in tr').eq(1).find(
										'.name_person').val('');
								$('.check_in1 .tab_in tr').eq(1).find(
										'.td_div_5 span').text('清空');
								$('.sub_ruz').addClass('no_sub').removeClass(
										'on_sub');

							}
						}

					})

	/* 删除按钮点击删除tr */
	fn2();

	function fn2() {
		$('.td_div_5').on(
				'click',
				function() {

					var s = $(this).parents('tr').find('.name_person').val();

					$('.insurance_xix1 li').each(
							function() {
								var m = $(this).children('label').text();
								if (m == s) {
									$(this).find('input:checkbox').attr(
											'checked', false);

								}
							})
					var l = $('.check_in1 tr').length;
					if (l <= 3) {
						if (l <= 2) {
							$('.check_in1 .tab_in tr').eq(1).remove();
							$('.check_in1 .tab_in').append(t);
							$('.check_in1 .tab_in tr').eq(1).find(
									'.td_div_5 span').text('清空');
							$('.sub_ruz').addClass('no_sub').removeClass(
									'on_sub');
							return false;
						}
						$(this).parents('tr').remove();
						$('.check_in1 .tab_in tr').eq(1).find('.td_div_5 span')
								.text('清空');
					} else {
						$(this).parents('tr').remove();
					}

				})
	}

});
/* 入住人 */
$(function() {

	$('.on_sub').click(function() {
		if ($('.sub_ruz').hasClass('on_sub')) {
			$('.check_in1').hide();
			$('.check_in2').show();
		}
	})

	/* 可选入住人删除 */
	layer($('.insurance_xix1 li'), '确定删除该入住人信息吗？');
	layer($('.insurance_xix2 li'), '确定删除该被保人信息吗？');
	function layer(obj, text) {
		obj.hover(function() {
			$(this).siblings().children('span').hide();
			$(this).children('span').show();
			$(this).children('span').click(function() {
				var a_this = $(this);
				var userid = a_this.prev().children('input').attr('id');
				userid = userid.split('_')[1];
				$('#layer_rz').show();
				$('#layer_rz .ruzT').find('p').text(text);
				$('#layer_rz .sure').click(function() {
					var delcontacturl = '/order/delusercontac';
					$('#layer_rz').hide();
					$.get(delcontacturl, {
						userid : userid
					}, function(data) {
						if (data.success == 1) {
							// alert('删除成功！');
							if ($('#user_' + userid)[0].checked) {
								$('#person1_name').val('');
								$('#person1_idcard').val('');
							}
							a_this.parent().remove();
						} else {
							// alert('删除失败！');
						}
					});
				})
				$('#layer_rz .cancel').click(function() {

					$('#layer_rz').hide();
				})

			})
		}, function() {
			$('.insurance_xix  li').children('span').hide();
		})
	}

})
$(function() {
	var a = '';
	$('.mingxi li').click(function() {

		$(this).toggleClass('li_click');

	})

})

/* 选择被保人 */
$(function() {
	$('input[name="instro_people"]').click(function() {
		if ($(this).attr('checked') == 'checked') {
			var name = $(this).parent().text();
			$(this).parents('ul').next().find('.name_person').val(name);
		}
	})

})
$(function() {
	// 住宿意外险,门票说明
	fn('.safeticket1', '.safeticket_details_cover1');
	fn('.safeticket2', '.rick2');

	// 右侧按钮点击出现table
	fn('.tab_tan1', '.price_par1');
	fn('.tab_tan2', '.price_par2');
	fn('.dingw4', '.online_asote');
	function fn(obj1, obj2) {
		var oTime = '';
		$(obj1).hover(function() {

			$(obj2).show();
			var hight = $('.tab_par tr').length / 2 * 45;

			var h = $(obj2).find('.tab_par').height();
			if (hight > 210) {
				$(obj2).find('.tab_par').height(210);
			} else {
				$(obj2).find('.tab_par').height(hight);
			}
			/* 判断是否是IE浏览器 */
			if ($('.tab_par').height() >= 210) {
				$('.tab_par').height(210);
			}
			if (!!window.ActiveXObject || "ActiveXObject" in window) {
				var h = $('.tab_par table').height();
			}

		}, function() {
			oTime = setTimeout(function() {
				$(obj2).hide();
			}, 200)
		})
		$(obj2).hover(function() {
			clearTimeout(oTime);
		}, function() {
			$(this).hide();
		})
	}

	/* 保险按钮关闭图层 */
	fn2('.makeSure1', '.details_link_details1', '.details_link');

	/* 门票按钮 */
	fn2('.makeSure2', '.details_link_details2', '.safeticket2');
	function fn2(pnt1, pnt2, pnt3) {
		$(pnt1).click(function() {
			$(pnt2).hide();
		})
		$(pnt3).click(function() {
			$(pnt2).show();
		})
	}

})

// 底部展开收起

$(function() {

	$('.rens').change(function() {
		var maxnum = $('#maxguest').val();
		if ($(this).val().length > 0) {
			$('#guestnum').text('×' + $(this).val() + '人');
			$('#checkinnum').val($(this).val());
		} else {
			// $('#guestnum').text(maxnum);
		}
	});

})

window.onload = function() {
	var oUl = document.getElementById('mingxi');
	var oLi = oUl.getElementsByTagName('li');

	var Gong = document.getElementById('ser_gong');
	var str = 0;
	var Num = 0;
	for (var i = 0; i < oLi.length; i++) {
		oLi[i].onclick = function() {
			var oSpan = this.getElementsByTagName('span')[0];
			if (oSpan == undefined || oSpan == null) {
				return false;
			}
			Num = parseInt(oSpan.innerHTML);
			if (this.className == 'li_click') {

				str += Num;
			} else if (this.className == ' ' || this.className == '') {
				str -= Num;
			}
			Gong.innerHTML = str;
		}
	}

}

/* 填写手机号 */
$(function() {
	$('.tel_int').blur(function() {
		if ($(this).val() == '') {
			$(this).next().text('输入正确的手机号并验证成功，预订成功后会向您发送短信通知');
		} else {
			$(this).next().text('预订成功后会向您发送短信通知');
		}
	})
})

$(function() {

	/* 验证身份证号 */
	$('.shenfz').on('focus', function() {
		$(this).removeClass('input_h');
		$(this).next().hide();
		if (!$(this).val() == '') {
			$(this).siblings('.sfzTk').hide();
		}
		$(this).siblings('.sfzTk').show();
	})
	$('.shenfz').on('blur', function() {
		var a = $(this).val();
		var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X x)$)/;
		$(this).siblings('.sfzTk').hide();
		if (reg.test(a) === false) {
			if (a == '' || a == ' ') {
				return false;
			}
			$(this).addClass('input_h');
			$(this).next().show();
			return false;
		}

	})
	$('.shenfz').on(
			'keyup',
			function() {
				var a = $(this).val();
				var b = a.substring(0, 3) + ' ' + a.substring(3, 6) + ' '
						+ a.substring(6, 10) + ' ' + a.substring(10, 14) + ' '
						+ a.substring(14, 18);
				$(this).siblings('.sfzTk').show();
				$(this).siblings('.sfzTk').text(b);
			})
})
var extDiscount = 1;
// 日历价格变动时，要对前后的日期进行处理
function ajaxOrderDetial(a,cid) {
	var url = "/order/ajaxwaitinit/";
	var tenant = $("#tenantid").val();
	var room = $("#luid").val();
	var roomnum = $("#roomNum").text();
	// 要对开始日期和结束日期进行处理
	var checkinday = $("#checkinday").val();
	var checkoutday = $("#checkoutday").val();

	if(a==0)
	{
		extDiscount = a;
	}else if(a==1)
	{
		extDiscount=1;
	}
	// 检查库存
	var checkUrl = "/order/checkstock";
	jQuery.post(checkUrl, {
		roomid : room,
		roomnum : roomnum,
		checkinday : checkinday,
		checkoutday : checkoutday
	}, function(data) {
		if (data.status != 1) {
			$("#hasStock").val('0');
			alert(data.tipmsg);
			return;
		} else {
			$("#hasStock").val('1');
			url += "room-" + room + "_roomnum-" + roomnum + "_checkinday-"
					+ checkinday + "_checkoutday-" + checkoutday+"?extdiscount="+extDiscount;
			$('#lefttable').empty();
			$('#righttable').empty();
			jQuery.post(url, function(result) {
				result = decodeURIComponent(result);
				initOrderPageInfo(result,cid); 
			})
		}
	})
}
var hasSpec;
// 初始化页面方法
function initOrderPageInfo(detialJson,cid) {
	// <!--1.原始JS-->
	// detialJson =JSON.parse(detialJson);
	detialJson = eval("(" + detialJson + ")");
	var checkinday = detialJson.checkinday;
	var checkoutday = detialJson.checkoutday;
	$("#checkinday").val(checkinday);
	$("#checkoutday").val(checkoutday);
	$("#checkinOfWeek").text(detialJson.checkinOfWeek);
	$("#checkoutOfWeek").text(detialJson.checkoutOfWeek);
	$("#checkindayr").text(checkinday.replace('-', '.').replace('-', '.'));
	$("#checkoutdayr").text(checkoutday.replace('-', '.').replace('-', '.'));
	$("#checkinOfWeekr").text(detialJson.checkinOfWeek);
	$("#checkoutOfWeekr").text(detialJson.checkoutOfWeek);
	$("#nights").text(detialJson.nights);
	$("#roomNum").text(detialJson.roomNum);
	$("#roomNumr").text(detialJson.roomNum);
	$("#showtotalprice").text(detialJson.showtotalprice);
	$("#totalPrice").val(detialJson.totalPrice);
	$("#onlineAmount").val(detialJson.onlineAmount);
	$("#onlinePayAmount").val(detialJson.onlinePayAmount);
	$("#specialdiscount").val(detialJson.specialdiscount);
	var offlinePayAmount = detialJson.offlinePayAmount;
	if (!offlinePayAmount) {
		offlinePayAmount = 0;
	}
	if (2 == detialJson.from) {
		$("#hasStock").val(detialJson.haveStock);
	}
	$("#offlinePayAmount").text(offlinePayAmount);
	$("#showtotalpriceText").text(detialJson.showtotalprice);
	$("#payRuleRate").text(detialJson.payRuleRate);
	$("span[name=allrefundday]").text(detialJson.allrefundday);
	$("span[name=checkindayShow]").text(detialJson.checkinday);
	$("span[name=checkoutdayShow]").text(detialJson.checkoutday);

	if (detialJson.deposit) {
		$("span[name=deposit]").text(detialJson.deposit / 100);
	}
	if (offlinePayAmount == 0) {
		$('#sOflinePay').css('display', 'none');
	}
	if (offlinePayAmount > 0 || detialJson.deposit > 0) {
		$("#reminder").css('display', 'block');
	}

	var priceDetialJson = detialJson.priceDetailModel;
	$('#lefttable').empty();
	$('#righttable').empty();
	for (var i = 0, length = priceDetialJson.items.length; i < length; i++) {
		var item = priceDetialJson.items[i];
		var priceShow = item.priceShow;
		if (!priceShow) {
			priceShow = 0;
		}
		var dayAmount = item.dayAmount;
		if (!dayAmount) {
			dayAmount = 0;
		}

		if (priceShow < item.originalPrice) {
			priceShow += '&nbsp;<i>￥' + (item.originalPrice) + '</i>';
		}
		var tr = '<tr><td><div style="width:92px;">' + item.date
				+ '</div></td><td><div style="width:126px;">￥' + priceShow
				+ '</div></td><td><div style="width:43px;">'
				+ detialJson.roomNum
				+ '</div></td><td class="bon"><div style="width:75px;" title="'
				+ dayAmount + '">￥' + dayAmount + '</div></td></tr>'
		$('#lefttable').append(tr);
		$('#righttable').append(tr);
	}
	
	$('#orderroomprice').val(priceDetialJson.showtotalPrice);
	$('#totlenight1').html(detialJson.nights);
	$('#totlenight2').text(detialJson.nights);
	$('#totlenight3').text(detialJson.nights);
	$('#totleprice1').text(priceDetialJson.showtotalPrice);
	$('#totleprice2').text(priceDetialJson.showtotalPrice);

	var specialdiscount = $("#specialdiscount").val();
	if (!specialdiscount) {
		// ltr=ltr+'<font style="margin-right:200px;">房东规定：特殊价不参与打折</font>';

		if (!hasSpec) {
			$('#llandlordrule')
					.append('<li id="lspecial">·&nbsp;特殊价不参与打折</li>');
			$('#rlandlordrule').append('<li>·&nbsp;特殊价不参与打折</li>');
			hasSpec = true;
		}

	}
	// 促销相关的处理逻辑
	promotionModelJson = detialJson.promotionModel;
	
	if (promotionModelJson && promotionModelJson.type) {
		$("#promotionAmount").text(-promotionModelJson.promotionAmount);
		$("#typeAlias").text(promotionModelJson.typeAlias);
		$("#selectOnline").val(promotionModelJson.typeAlias);
		var userCouponEntityList = promotionModelJson.userCouponEntityList;
		// 初始化
		var couponnum = 0;
		var select = "";
		var maxcoupon = 0;
		var couponid;
		$('.people').empty();
		$('.people').append(
				'<li id="cid_0" value="0" amountShow="0" coupontype="0">不使用</li>'); 
		// 代金券
		var accountEntityList = promotionModelJson.accountEntityList;
		for (var i = 0; i < accountEntityList.length; i++) { 
			if (maxcoupon < accountEntityList[i].amountShow) {
				select = accountEntityList[i].amountShow + '代金券';
				maxcoupon = accountEntityList[i].amountShow;
				couponid = accountEntityList[i].id;
				$("#promotiontype").val(1);
			}

			var coupon = '<li id="cid_'+accountEntityList[i].id+'" value="' + accountEntityList[i].id
					+ '" amountShow="' + accountEntityList[i].amountShow
					+ '" coupontype="1">' + accountEntityList[i].amountShow
					+ '代金券';
			$('.people').append(coupon);
			couponnum++;
		}
		var discountMoney = 0;
		// 优惠券
		for (var i = 0; i < userCouponEntityList.length; i++) {
			if (userCouponEntityList[i].show == 1) {
				 
				var coupon="";
				if(userCouponEntityList[i].id==1)
				{
					if(extDiscount){
						select = userCouponEntityList[i].typeAlias;
						couponid=userCouponEntityList[i].id;
						maxcoupon=0;	
						$("#promotiontype").val(2);
					}
					coupon = '<li id="cid_'+userCouponEntityList[i].id+'" value="' + userCouponEntityList[i].id
					+ '" amountShow="' + userCouponEntityList[i].amountShow
					+ '" coupontype="2">'+userCouponEntityList[i].typeAlias +'</li>';
				}else
				{
					if (maxcoupon < userCouponEntityList[i].amountShow) {
						select = "满" + userCouponEntityList[i].useconditionShow
								+ '减' + userCouponEntityList[i].amountShow;
						maxcoupon = userCouponEntityList[i].amountShow;
						couponid = userCouponEntityList[i].id;
						$("#promotiontype").val(2);
					}
					coupon = '<li id="cid_'+userCouponEntityList[i].id+'" value="' + userCouponEntityList[i].id
					+ '" amountShow="' + userCouponEntityList[i].amountShow
					+ '" coupontype="2">满'
					+ userCouponEntityList[i].useconditionShow + '减'
					+ userCouponEntityList[i].amountShow + '</li>';
				} 
				$('.people').append(coupon);
				couponnum++;
			}
		}
		
		$('#showtotalprice2').text(priceDetialJson.showtotalPrice);
		
		 
		if(typeof(cid) != "undefined"){
			var select =	$('#cid_'+cid).text();  
			$('.jianmq').text('-￥0');
			$('.dianj4 i').text(select); 
			$('#ctip').text("优惠券");
		}else
		{
			if(extDiscount&&couponid==1){
				$('#ctip').text("早订8折");
				$('.jianmq').text('-￥'+(priceDetialJson.showtotalPrice/8*2));
				$('#showtotalprice').text(priceDetialJson.showtotalPrice*10/8);
				$('#showtotalprice2').text(priceDetialJson.showtotalPrice*10/8);
				
//				$('.jianmq').text('8折');
			}else{
				$('#showtotalprice').text(priceDetialJson.showtotalPrice);
				$('#showtotalprice2').text(priceDetialJson.showtotalPrice);
				$('.jianmq').text('-￥' + maxcoupon);
				$('#ctip').text("优惠券");
			}
			$('.jianmq').attr('id', couponid);
			$('#coupon_checkbox').val(couponid);
			$('.jianmq').attr('couponval', maxcoupon);
			if(select!='')
			{
				$('.dianj4 i').text(select); 
			} 
		} 
		if (couponnum > 0) {
			$('.cnt1').css('display', 'block');
			$('.couponcun').text('有' + couponnum + '张');
		} else {
			$('.couponcun').text('无');
		}

		$('.havDai li').each(function() {
			var stt = $(this).text();
			if (stt == select) {
				$(this).addClass('on');
				return false;
			}
		})
		 
		$('#tr_coupon').show();
	} else {
		$('#showtotalprice').text(priceDetialJson.showtotalPrice);
		$('#showtotalprice2').text(priceDetialJson.showtotalPrice);
		$("#promotionAmount").val(0);
		$('#tr_coupon').hide();
	}
	// 仅仅展示钱数
	var onlinePayAmountShow = (parseFloat(detialJson.onlinePayAmount) + parseFloat($(
			"#promotionAmount").val())).toFixed(2)
	if (onlinePayAmountShow < 0) {
		onlinePayAmountShow = '0.00';
	}
	$("#onlinePayAmountShow").text(onlinePayAmountShow);
	// <!--原始结束-->
	// <!--增加保险20150731-->
	setPrice('init');
	// <!--增加保险结束-->
}

// 显示失败
function showErrorDiv() {
	return;
	/*
	 * j = $.layer({ type : 1, title : false, offset:['150px' , ''], border :
	 * false, closeBtn:false, time : 1, area : ['auto','auto'], page : {dom :
	 * '#valid_error'} }); $('.checking-btn').on('click',function(){
	 * layer.close(j); }); $('.alert-close').on('click',function(){
	 * layer.close(j); });
	 */
}
// 显示成功
function showSuccessDiv() {
	var x = $.layer({
		type : 1,
		title : false,
		offset : [ '150px', '' ],
		border : false,
		closeBtn : false,
		area : [ 'auto', 'auto' ],
		time : 3,
		page : {
			dom : '#valid_success'
		}
	});
	$('.alert-close').on('click', function() {
		layer.close(x);
	});
	$('#valid_success_close').on('click', function() {
		layer.close(x);
	});
}
// 显示绑定
var k;
function showSuccessBangdingDiv() {
	k = $.layer({
		type : 1,
		title : false,
		offset : [ '150px', '' ],
		border : false,
		closeBtn : false,
		area : [ 'auto', 'auto' ],
		page : {
			dom : '#valid_success_bangding'
		}
	});
	$('.alert-close').on('click', function() {
		layer.close(k);
	});
	$('.laterhandle').on('click', function() {
		layer.close(k);
	});

	$('#nobangding').on('click', function() {
		layer.close(k);
	});
	$('#valid_success_bangding_close').on('click', function() {
		layer.close(k);
	});
}

// 下单
function submitOrder() {	
	var lodgeunitState = $("#lodgeunitState").val();
	var room = $("#luid").val();
	var roomnum = $("#roomNum").text();
	var checkinday = $("#checkinday").val();
	var checkoutday = $("#checkoutday").val();
	if (lodgeunitState != 4) {
		alert('房间处于非上线状态，不允许下单！');
		return;
	}
	if (!checkinday) {
		alert('入住日期不可以为空！');
		return;
	}
	if (!checkoutday) {
		alert('退房日期不可以为空！');
		return;
	}
	if (checkinday >= checkoutday) {
		alert('退房日期不能小于或等于入住日期');
		return;
	}
	//maxguest
	var checkinnum = $.trim($(".rens").val());
	//var checkinnum = $.trim($("#checkinnum").val());
	if (checkinnum == "填写人数") {
		checkinnum = "";
	}
	// if(checkinngetInsuranceJson()um==""){
	// alert('请填写入住人数');
	// $("#checkinnum").focus();
	// return;
	// }
	var cityId = $("#cityid").val();
	if(cityId==16||cityId==61)
	{
		if(checkinnum==""||isNaN(parseInt(checkinnum))  )
		{
			alert("请输入正确有效的入住人数！"); 
			$(".rens").focus();
			return;
		}
		checkinnum = parseInt(checkinnum);
	}
	if (checkinnum != "" && checkinnum <= 0) {
		alert("请输入正确有效的入住人数！");
		//$("#checkinnum").focus();
		$(".rens").focus();
		return;
	}
	if (!checkInput()) {
		return;
	}
	// kgj add insurance start
	var insuranceJson = getInsuranceJson();
	$("#insuranceJson").val(insuranceJson);
	//var personStr = "insuranceJson:"+ getInsuranceJson();
	var personStr ="";
	var ids = $("#insuranceInputIds").val();
	var insurancePeopleNum = $(".inspersonDetail").length;
	$("#insurancePeopleNum").val(insurancePeopleNum);
	var isInsurance = $("#isInsurance").val();
	// kgj add insurance end
	var tickList = $('#ticketList').val();
	var oldparam = "'roomid':'" + room + "',";
	oldparam += "'roomnum':'" + roomnum + "',";
	oldparam += "'checkinday':'" + checkinday + "',";
	oldparam += "'checkoutday':'" + checkoutday + "',";
	oldparam += "'insuranceInputIds':'" + ids + "',";
	oldparam += "'insurancePeopleNum':'" + insurancePeopleNum + "',";
	oldparam += "'ticketList':'" + tickList + "',";
	oldparam += "'isInsurance':'" + isInsurance + "',";
	var paramStr = "{" + oldparam + personStr + "}";
	var param = eval('(' + paramStr + ')');
	$("#dayNum").val(parseFloat($("#nights").text()));	
	var tenantname = $("#tenantname").val();
	var dateTip = ticketManager.dateValid();
	if (dateTip != '') {
		alert(dateTip);
		return;
	}

	var mobile = $("#tenantmobile").val();
	if (mobile.length == 0) {
		mobile = $("#tenantmobile").val();
	}
	var reg = /^((\+86)|(86))?(1)\d{10}$/;
	if (!mobile.match(reg)) {
		alert("请输入正确有效的手机号码！");
		$("#tenantmobile").focus();
		return false;
	}

	// 判断房间库存是否足够多的标记	
	var tenant = $("#tenantid").val();
	// 检查库存
	var checkUrl = "/order/checkOrderSubmit";
	$.get(checkUrl, param, function(data) {
		var jsonData = eval(data);
		if (jsonData.status != 1) {
			$("#hasStock").val('0');
			alert(jsonData.tipmsg);
			return;
		} else {
			var hasStock = $("#hasStock").val();
			if (hasStock != 1) {
				alert('房间包含不可租日期或库存不满足条件！');
				return;
			}
			/**
			 * var isSelf = $('input:radio[name="isSelf"]:checked').val();
			 * if(isSelf==2){ var mobile=$("#tenantmobileNoself").val(); var reg
			 * =/^((\+86)|(86))?(1)\d{10}$/; if(!mobile.match(reg)){
			 * alert("111请输入入住人正确有效的手机号码！"); return false; } var
			 * tenantnameNoself=$("#tenantnameNoself").val();
			 * if(!tenantnameNoself){ alert("请输入入住人姓名！"); return false; } }
			 */
			// var imgcode
			if (getCookie("MAYIUID") == null) {
				alert('请输入手机号并获取验证码！');
				return false;
				/**
				 * imgcode=$.layer({ closeBtn : [0 , false], type : 1, title :
				 * false, offset:['150px' , ''], border : [0,0,'',false], area :
				 * ['auto','auto'], // move : ['.d-h3',true], page : {dom :
				 * '#imgcodediv'} }); $('#book-colse1').on('click',function(){
				 * layer.close(imgcode); });
				 */
			} else {

				var action_form = "/order/init/";
				// 统计从海洋专题过来的订单
				var fromsea = '';
				// 统计从海洋专题过来的订单结束
				action_form += "tenant-" + tenant + "_room-" + room
						+ "_roomnum-" + roomnum + "_checkinday-" + checkinday
						+ "_checkoutday-" + checkoutday + fromsea;
				jQuery("#orderForm").first().attr("action", action_form)
						.submit();
			}
		}
	});
}