var usercontactManager = { 
	nation:"汉族", //默认民族
	country:"中国", //默认民族
	//取得证件类型的OPTION
	paperOption:function(papertypemap)
	{
		var str = "";
		var length = parseFloat(papertypemap._entrys.length);
		for(var i=0;i<length;i++)
		{
			  var entry = papertypemap._entrys[i];
			  var datakey = entry.key;
			  var datavalue = entry.value;
			  str +="<option value='"+entry.key+"' name='cardtypevalue'>"+datavalue+"</option>";
		}
	    return str;
	},
	nationOption:function(nationlist)
	{
		var str = "";
		for(var m=0;m<nationlist.length;m++){
			var nation = nationlist[m];
			str += "<option value='"+nation.name+"'>"+nation.name+"</option>";			
		}		
	    return str;
	},
    countryOption:function(nationlist)
	{
		var str = "";
		for(var n=0;n<countrylist.length;n++){
			var country = countrylist[n];
			var option = "<option value='"+country.cname+"'>"+country.cname+country.englishname+"</option>";
			str+=option;
		}	
	    return str;
	},
	defaultValue:function (country,nation)
	{
		if(country=='')
			country = usercontactManager.country;
		if(nation=='')
			nation = usercontactManager.nation;
		if(country!=usercontactManager.country)
			return country;
		else
			return nation;
	}
	

		
}