<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta charset="utf-8">
	<title>嗨住-后台登录界面</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- 最新版本渲染 -->
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/login.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/hizhu/Public/css/common.css">
    <script>
    function check(){
       var name=document.getElementById("name").value;
        if(name==""){
            alert("请输入用户名！")
            return false;
        }
         var mima=document.getElementById("pwd").value;
         if(mima==""){
            alert("请输入密码！");
             return false;
         }
          var yzm=document.getElementById("code_id").value;
         if(yzm==""){
            alert("请输入验证码！");
             return false;
         }
    }
    </script>
</head>
<body>
    <div class="main1">
    	<p>嗨住后台管理系统</p>
    	<form action="<?php echo U('Index/login');?>" method="post" onsubmit="return check()">
    		<p class="cf"><span>用户名：</span><input type="text" name="user_name" id="name" tabindex="1"></p>
    		<p class="cf"><span>密&nbsp;&nbsp;&nbsp;码：</span><input type="password" name="password" id="pwd" tabindex="2"></p>
            <p class="cf"><span>验证码：</span><input type="text" name="code" class="code" id="code_id" placeholder="请输入验证码" tabindex="3">
            <img src="<?php echo U('admin.php/Index/verufy');?>" id="code"  onclick="this.src='/hizhu/admin.php/Index/verufy?d='+Math.random();"></p> 
    		<p class="cf"><button type="reset">重置</button><button>登录</button></p>
    	</form>
    </div>
</body>
</html>