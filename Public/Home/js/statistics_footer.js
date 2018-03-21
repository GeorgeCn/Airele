/**需放入到footer中的统计代码*/
// 蚂蚁统计所需js  
   var _maq = _maq || [];
    _maq.push(['_setAccount', 'mayi']);
	(function ()
	{ 
	        var ma = document.createElement('script');
	    ma.type = 'text/javascript';
	    ma.async = true;
	    var ctx1 = $('#ctx1').val();
	    ma.src =ctx1+'/resourcesWeb/js/statistics/stmy.js?v=1311111130';
	    var s = document.getElementsByTagName('script')[0];
	        s.parentNode.insertBefore(ma, s);
	})();
	
//	<!-- 百度统计所需js
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?0294bbb72b1c6a6b342da076397c9af2";
	  var s = document.getElementsByTagName("script")[0];
	  s.parentNode.insertBefore(hm, s);
	})();
