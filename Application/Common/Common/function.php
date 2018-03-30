<?php 
require ('Application/Common/Common/CCPRestSDK.php');
//公共函数库
/** 
     * 发送 容联云通讯 验证码 
     * @param  int $phone 手机号 
     * @param  int $code  验证码 
     * @return boole      是否发送成功 
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
     * @author 普修米洛斯 www.php63.cc
     * @param int $width 宽度
     * @param int $height 高度
     * @param int $font_size 字体大小
     * @param int $code_len 验证码长度
     * @param int $line_num 线条长度
     * @param string $font 字体名称
     * @param int $interference 雪花数量
     */
    function code($width = 100, $height = 32, $font_size = 13, $code_len = 4, $line_num = 5, $font = './Public/assets/fonts/5.ttf', $interference = 40,$verifyName = 'code'){
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