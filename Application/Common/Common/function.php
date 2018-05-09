<?php 
require ('Application/Common/Common/CCPRestSDK.php');
//公共函数库
    /** 
     * 发送 容联云通讯 验证码 
     * @param  int $phone 手机号 
     * @param  int $code  验证码 
     * @return boole      是否发送成功
     * @author 乔治 <923143925@qq.com> 
     */  
    function send_sms_code($phone,$code){  
        //请求地址，格式如下，不需要写https://  
        $serverIP='app.cloopen.com';  
        //请求端口  
        $serverPort='8883';  
        //REST版本号  
        $softVersion='2013-12-26';  
        //主帐号  
        $accountSid=C('RONGLIAN_ACCOUNT_SID');  
        //主帐号Token  
        $accountToken=C('RONGLIAN_ACCOUNT_TOKEN');  
        //应用Id  
        $appId=C('RONGLIAN_APPID');  
        $rest = new REST($serverIP,$serverPort,$softVersion);  
        $rest->setAccount($accountSid,$accountToken);  
        $rest->setAppId($appId);  
        // 发送模板短信  
        $result=$rest->sendTemplateSMS($phone,array($code,5),1);  
        if($result==NULL) {  
            return false;  
        }  
        if($result->statusCode!=0) {  
            return  false;  
        }else{  
            return true;  
        }  
    }



/**
 * 格式化输出数组
 * @param mixed $data
 * @return null
 * @author  乔治 
 */
function V($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author  乔治
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                //如果存在父父类
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    V($tree);
    return $tree;
}

/**
 * 将 list_to_tree 的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author  乔治
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * @author 普修米洛斯
 * @param int $width 宽度
 * @param int $height 高度
 * @param int $font_size 字体大小
 * @param int $code_len 验证码长度
 * @param int $line_num 线条长度
 * @param string $font 字体名称
 * @param int $interference 雪花数量
 */
function code($width = 100, $height = 32, $font_size = 13, $code_len = 4, $line_num = 5, $font = './Public/assets/font/yahoo.ttf', $interference = 40,$verifyName = 'code'){
    $image = imagecreatetruecolor($width, $height);
    $image_color = imagecolorallocate($image,mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
    imagefilledrectangle($image,0,$height,$width,0,$image_color);
    $x = $width/$code_len;
    $codeStrs = '';
    for($i = 0; $i<$code_len;$i++){
        $str = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $font_color = imagecolorallocate($image,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
        $codeStrs .= $codeStr = utf8_encode($str[mt_rand(0,strlen($str)-1)]);

        imagettftext($image,$font_size,mt_rand(-30,30),$x*$i+mt_rand(1,3),$height / 1.4,$font_color,$font,$codeStr);
    }
    session($verifyName,md5(strtolower($codeStrs)));
    //生成线条
    for($i = 0;$i<$line_num;$i++) {
        $line_color = imagecolorallocate($image, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
        imageline($image, mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height), $line_color);
    }
   /* for($i=0;$i<$interference;$i++){
        $color = imagecolorallocate($image, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagestring($image,mt_rand(1,5),mt_rand(0,$width),mt_rand(0,$height),'*',$color);
    }*/
    header("Content-type: image/png");
    imagepng($image);
    imagedestroy($image);
}

/**
 * randNum 生成随机数
 * @author 刘中胜
 * @time 2015-08-14
 **/
function randNum(){
    return mt_rand(1000,99999999);
}

/**
 * md5Encrypt 加密函数
 * @param string $str 要加密的字符串
 * @return string $chars 加密后的字符串
 * @author 刘中胜
 * @time 2015-04-13
 **/
function md5Encrypt($str='',$rand=''){
    $hash = $str.$rand;
    $chars =  MD5(hash('sha256', $hash));
    return $chars;
}
/**
 * 删除缓存文件
 * @param string $dir 默认temp目录
 * @author 刘中胜
 **/
function delTemp($dir = TEMP_PATH){
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
       if ($file != "." && $file != "..") {
           $fullpath = $dir . "/" . $file;
           if (!is_dir($fullpath)) {
                unlink($fullpath);
           } else {
                delTemp($fullpath);
           }
       }
    }
    closedir($dh);
    if (rmdir($dir))
    {
        return true;
    }
    return false;
}

/**
 * 将key相同的数组合并为新的数组
 * @param array $arr 接收要组装的二维数组
 * @author 刘中胜
 **/
function arrAssembly($arr)
{
    $arr_new = array();
    foreach($arr as $item){
        foreach($item as $key=>$val){
            $arr_new[$key][] = $val;
        }
    }
    return $arr_new;
}

/**
 * 格式化时间
 * @param mixed $date 传入要格式化的时间
 * @param int $type 1：年月日时分秒如：2015-12-07 0:22:12
 * @return mixed 处理好的时间
 * @author 刘中胜
 * @time 2015-12-07
 **/
function formatTime($date, $type=1)
{
    switch($type){
        case 1:
            $date = date('Y-m-d H:i:s',$date);
            break;
        case 2:
            $date = date('Y-m-d',$date);
            break;
        case 3:
            $date = date('y-m-d',$date);
            break;
    }
  return $date;
}


/**
 * 切割图片
 * @author 刘中胜
 * @trim 2015-05-22
 **/
function getThumb($url='', $width=null, $height=null){
    if(empty($url)){
        return '';
    }
    if(is_null($width)){
        $width = 100;
    }
    if(is_null($height)){
        $height = $width;
    }
    $tmpArr = explode('/', $url);
    $name = array_pop($tmpArr);
    $allname = implode('/', $tmpArr) ."/thumb/{$width}x{$height}/" . $name;
    return $allname;
}
/**
 * cut_str 字符串截取
 * @param string $sourcestr 要截取的内容
 * @param string $cutlength 指定长度
 * @author 刘中胜
 * @time 2015-5-19
 **/
function cut_str($sourcestr,$cutlength){
    $returnstr='';
    $i=0;
    $n=0;
    $str_length=strlen($sourcestr);//字符串的字节数
    while (($n<$cutlength) and ($i<=$str_length)){
        $temp_str=substr($sourcestr,$i,1);
        $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
        if ($ascnum>=224){ //如果ASCII位高与224，
            $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
            $i=$i+3; //实际Byte计为3
            $n++; //字串长度计1
        }elseif ($ascnum>=192){ //如果ASCII位高与192，

            $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
            $i=$i+2; //实际Byte计为2
            $n++; //字串长度计1
        }elseif ($ascnum>=65 && $ascnum<=90){ //如果是大写字母，
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1; //实际的Byte数仍计1个
            $n++; //但考虑整体美观，大写字母计成一个高位字符
        }else{ //其他情况下，包括小写字母和半角标点符号，
            $returnstr=$returnstr.substr($sourcestr,$i,1);
            $i=$i+1; //实际的Byte数计1个
            $n=$n+0.5; //小写字母和半角标点等与半个高位字符宽...
        }
    }
    if ($str_length>$cutlength){
        $returnstr = $returnstr."...";//超过长度时在尾处加上省略号
    }
    return $returnstr;
}
/**
 * 生成随机字符串
 * @author 普修米洛斯
 **/
function getRandStr($length=8) {
    $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $randString = ''; 
    $len = strlen($str)-1; 
    for($i = 0;$i < $length;$i ++){ 
        $num = mt_rand(0, $len); 
        $randString .= $str[$num]; 
    } 
    return $randString ; 
}

/**
 * 逗号中文转英文
 **/
function bianma($str)
{
   return str_replace('，',',',$str);
}
/**
 * 邮件发送函数
 */
function sendMail($to, $title, $content) {
    require APP_PATH . 'Common/Lib/PHPMailer/class.smtp.php';
    require APP_PATH . 'Common/Lib/PHPMailer/class.phpmailer.php';

    $mail = new \PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}

/**
 * @param $str 要加密的字符串
 * @return string 加密后的字符串
 */
function homeUserPwd($str)
{
    $hash = Md5($str);
    $str = MD5(hash('sha256', $hash));
    return $str;
}

/**
 * @author 普修米洛斯 www.php63.cc
 * @param $file 缓存文件名
 * @param int $time 缓存时间
 */
function check_cache($file, $time = 0){
    if($time == 0){
        $time = C('CACHE_TIME');
    }
    if (is_file($file) && (time() - filemtime($file)) < $time) {
        require_once $file;
        exit;
    }
}

/**
 * @author 普修米洛斯 www.php63.cc
 * @param $file 生成静态页面
 */
function create_cache($file){
    file_put_contents($file,ob_get_contents());
}