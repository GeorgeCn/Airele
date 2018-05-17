# Airele
This is my first standard project

3-29  author:George  start reconstruction 
		--init Public directory structure

5-17  naming format(命名格式) 注意：以下符号都是在英文输入法下
	 
	  前端: class - 中划线 
	 	    id    _ 下划线 (推荐)
	 	    	  - 中划线 (国外网站使用较多，例：gitHub)
	 	    input[name]             小写         例：name 
	 	    			            多单词也小写  例：username password
	 	    			            多单词小写无法快速识别 添加下划线(_) 例：rep_new_pwd
	 	    jQuery变量              小驼峰法
	 	    			            变量名称前加符号($) 代表是jQuery变量   例:$var
	 	    ajax-variable           下划线

	  后端: classController         控制器类 大驼峰法(别名:帕斯卡命名法)
	  										属性 私有 变量前加下划线(_)
	        action                  方法    单个词表述      小写
	        						        两个词易识别    小写/小驼峰法
	        						        多词           小驼峰法
	       	actionHtml              自带路由 小写  多单词 添加下划线(_)
	       					        非路由   小写  驼峰处理成下划线(_)
	       	model/repository        同控制器类
	       	folder                  文件夹   国产   帕斯卡命名
	       	                                舶来品  小写
	       	export template-variable        输出模板变量    小写/下划线
	       	session                 键      大写 多个单词下划线隔开

	  Mysql 库名称                  小写
	        表名称                  小写     多个单词  添加下划线
	        					   同类表添加统一前缀
	        索引                    小写     格式: 类型_表名称缩写_字段名称 最好不要超过15个字母
