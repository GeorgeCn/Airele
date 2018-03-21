$(function(){
	var d = $('#pin1').offset().left;
	var yg = $('#pin1').height();
	var h = $('#pin1').offset().top;
	var j = $('.foot').offset().top-yg;
	$(window).resize(function(){
	
		setTimeout(function(){
			d1 = $('#pin1').offset().left;
			d = $('#pin1').offset().left;
			j = $('.foot').offset().top-yg;
			scroll();
		},300)
	})
	
	$('.insurance_label,.more,#editMobile').click(function(){
		
		if($('#tenantmobile'))
		{
			var t=$('#tenantmobile').val();
			$('#tenantmobile').val('').focus().val(t);
			//$('#tellphoneSpan').textFocus();
		}
		setTimeout(function(){
			d = $('#pin1').offset().left;
			j = $('.foot').offset().top-yg;
			scroll();
		},30)
	})
	
	
	$(window).scroll(function(){
		
		scroll();
		
	})
	
	function scroll(){
		var p = $(window).scrollTop();
		var t = $('.foot').offset().top-p;
		if(p<=h){
			$('#pin1').css({
				position:'static'
			})
		}
		else if(p>=h){
			if(t>=yg+20){
				$('#pin1').css({
					position:'fixed',
					left:d,
					top:0
				})
			}else{
				var jH = p-(p-j)-74;
				$('#pin1').css({
					position:'absolute',
					left:d,
					top:jH
				})
			}
		}
	}
}) 