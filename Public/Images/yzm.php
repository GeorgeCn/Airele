<?php 
	// 验证码
	session_start();
	/**
	 * [验证码]
	 * @param  int   $width    	宽度
	 * @param  int   $height    高度
	 * @param  int   $length    字符个数
	 * @param  int   $type    	1:数字  2:字母  3: 数字字母
	 * @param  int   $img_type  图片类型
	 */
	function yzm($width=250,$height=40, $length=4, $type=3, $img_type='png'){
		// 1. 创建图片资源
		$img = imagecreatetruecolor($width, $height);

		// 2. 分配颜色(在函数外部调用两个颜色函数,分别返回亮色,暗色)

		// 3. 填充背景色
		imagefilledrectangle($img, 0,0, $width,$height, lightColor($img));

		// 4. 写字
		switch($type){
			case 1: 
				$str = join(array_rand( array_flip(range(0,9)),$length));
				break;
			case 2: 
				$str = join(array_rand( array_flip(range('a','z')),$length));
				break;
			case 3: 
				$str = '';
				for($i=0; $i<$length; $i++){
					//  0~9: 48~57  a~z:97~122   A~Z:65~90
					$num = mt_rand(1,3);
					switch($num){
						case 1:
							$str .= chr(mt_rand(48,57));
							break;
						case 2:
							$str .= chr(mt_rand(97,122));
							break;
						case 3:
							$str .= chr(mt_rand(65,90));
							break;
					}
				}
				break;
		}

		// 将产生的字符串 写入session中,  在未来会用到
		$_SESSION['v_code'] = $str;


		// 干扰信息
		for($i=0; $i<30; $i++){
			imagesetpixel($img, mt_rand(0,$width),mt_rand(0,$height),darkColor($img));
		}

		// 让每个字符都可以旋转, 否则是整个字符串旋转
		for($i=0; $i<$length; $i++){
			$x = ($width/$length)*$i + 30;
			$y = mt_rand(20,$height);
			imagettftext($img, 16, mt_rand(-10,50), $x,$y, darkColor($img) , './msyhbd.ttf' ,   $str[$i] );
		}
		

		// 5. 输出
		// imagejpeg
		// imagepng
		// imagegif
		$func = 'image'.$img_type;

		if( function_exists($func) ){
			header('content-type:image/'.$img_type);
			$func($img);
		}

		// 6.销毁图片资源
		imagedestroy($img);

	}	

	yzm();

	// 亮色  做背景用
	function lightColor($img){
		return imagecolorallocate($img, mt_rand(130,250), mt_rand(130,250), mt_rand(130,250));
	}

	// 暗色  做字体颜色
	function darkColor($img){
		return imagecolorallocate($img, mt_rand(0,129), mt_rand(0,129), mt_rand(0,129));
	}

 ?>