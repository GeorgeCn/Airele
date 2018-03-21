<?php
namespace Logic;
class VODClientLogic
{
	//根据room_id查找resource_id
	public function findHouseRoom ($id)
	{
		$modelDal = new \Home\Model\stores();
		$fields = 'room_no,city_code';
		$where['id'] = $id;
		$result = $modelDal->modelFindHouseRoom($fields,$where);
		return $result;
	}
	//新建视频信息
	public function createHousevideo ($data)
	{
		$modelDal = new \Home\Model\vodclient();
		$info['id'] = guid();
		$info['room_id'] = $data['room_id'];
		$roomInfo = $this->findHouseRoom($data['room_id']);
		if($roomInfo == null) {
			$roomInfo['room_no'] = '';
			$roomInfo['city_code'] = C('CITY_CODE');
		}
        $info['room_no'] = $roomInfo['room_no'];
		$info['video_url'] = C('VOD_VIDEO_URL').$data['room_id'].'/'.$data['room_id'].'.mp4';
		$info['video_h5url'] = C('VOD_H5VIDEO_URL').$data['room_id'].'/'.$data['room_id'].'.mp4';
		$info['video_img_url'] = C('VOD_IMG_URL').$data['room_id'].'.jpg';
		$info['expired_time'] = 0;
        $info['create_time'] = time();
        $login_name = trim(getLoginName());
        $info['create_man'] = $login_name;
        $info['city_code'] = $roomInfo['city_code'];
        $info['video_myimg_url'] = '';  
		$result = $modelDal->modelAddHouseVideo($info);
		return $result;
	}	
	//根据房间ID修改houseroom视频状态
	public function modifyHouseRoomVideo ($rid)
	{
		$modelDal = new \Home\Model\vodclient();
		$where['id'] = $rid;
		$data['had_vedio'] = 1; 
		$result = $modelDal->modelUpdateHouseRoom($where,$data);
		return $result;
	}
	//根据房间ID修改houseroom视频状态为0
	public function modifyHouseRoomVideoZero ($rid)
	{
		$modelDal = new \Home\Model\vodclient();
		$where['id'] = $rid;
		$data['had_vedio'] = 0; 
		$result = $modelDal->modelUpdateHouseRoom($where,$data);
		return $result;
	}
	//根据房间ID获得视频信息
	public function findHousevideo ($rid)
	{
		$modelDal = new \Home\Model\vodclient();
		$fields = 'id,video_url,video_img_url';
		$where['room_id'] = $rid;
		$result = $modelDal->modelFindHouseVideo($fields,$where);
		return $result;
	} 
	//根据房间ID更改视频图片信息
	public function updateHousevideoImg ($data)
	{
		$modelDal = new \Home\Model\vodclient();
		$where['room_id'] = $data['room_id'];
		$fileName = $data['room_id'].'.jpg';
		$videoImgUrl = C('VOD_IMG_URL').$data['room_id'].'.jpg';
        $obj = $this->uploadImageToServer($videoImgUrl,$fileName);
        $array = json_decode($obj,true);
        if($array['status'] == 200) {
        	$temp['video_myimg_url'] = $array['data']['imgUrl'];	
        } else {
        	$temp['video_myimg_url'] = '';
        }
        $result = $modelDal->modelUpdateHouseVideo($where,$temp);
        return $result;
	}
	//根据房间ID删除视频信息
	public function deleteHousevideoInfo ($data)
	{
		$modelDal = new \Home\Model\vodclient();
		$where['room_id'] = $data['room_id'];
        $result = $modelDal->modelDeleteHouseVideo($where);
        return $result;
	}
	//统计上传次数
	public function countHouseVideo ()
	{
		$modelDal = new \Home\Model\vodclient();
		$startTime=strtotime(date('Y-m-d',time()));
		$where['create_time']=array(array('gt',$startTime),array('lt',$startTime+86400));
		$result = $modelDal->modelCountHouseVideo($where);
		return $result;
	}
	//根据房间ID查找房间NO
	public function findHouseRoomNO ($data)
	{
		$modelDal = new \Home\Model\vodclient();
		$fields = 'room_no';
		$where['id'] = $data['id'];
		$result = $modelDal->modelFindHouseRoom($fields,$where);
		return $result; 
	}
	//根据房间ID更新房间编号
	public function updateHousevideoRoomNo ($data) 
	{
		$modelDal = new \Home\Model\vodclient();
		$where['room_id'] = $data['id'];
		$info['room_no'] = $data['room_no']; 
		$result = $modelDal->modelUpdateHouseVideo($where,$info);
	}
	//上传图片到服务器
	function uploadImageToServer($img,$img_name){
	ob_clean();
	ob_start();
	readfile($img);
	$img_data = ob_get_contents();
	ob_end_clean();
    // post提交
    $fileName=$img_name;
    $post_data = array ();
    $post_data ['relationId'] = "xxxxxRobxxxxx";
    $post_data ['fileName'] = $fileName;
    $post_data ['data']=base64_encode($img_data);
    $post_data ['fileSize'] = "10000";
    $url ='http://img.loulifang.com.cn/room/web/upload';
    $o = "";
    foreach ( $post_data as $k => $v ) {
      $o .= "$k=" . urlencode ( $v ) . "&";
    }
    $post_data = substr ( $o, 0, - 1 );
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
    $output=curl_exec ( $ch );
    curl_close($ch);
	return $output;
	}
}
?>