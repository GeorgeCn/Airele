<?php
namespace Logic;
use Think\Controller;
class CustomerNotifyLogic extends Controller{
    public function modelAdd($data){
        $modelDal=new \Home\Model\customernotify();
        $result=$modelDal->modelAdd($data);
        return $result; 
    }
    //发消息
    public function sendCustomerNotify($customer_id,$notify_type,$title,$content,$push_title=''){
    	if($customer_id=='' || $notify_type=='' || $content==''){
    		return false;
    	}
    	$notifyData['id']=guid();
    	$notifyData['customer_id']=$customer_id;
    	$notifyData['notify_type']=$notify_type;
    	$notifyData['title']=$title;
        $notifyData['push_title']=$push_title;
    	$notifyData['content']=$content;
    	$notifyData['create_time']=time();
    	$modelDal=new \Home\Model\customernotify();
    	$result=$modelDal->modelAdd($notifyData);
    	if($result && C("IS_REDIS_CACHE")){
    		#消息推送，红点
    	    $house_no_key=set_cache_public_key($customer_id."house_verify_no");
            if($notify_type==1009){
                $house_no_key=set_cache_public_key($customer_id."_message_no");
            }
    	    $house_no_value=get_couchbase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$house_no_key);
    	    $house_no_value=intval($house_no_value)+1;
    	    set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$house_no_key,$house_no_value,0);
    	}
    	return $result;
    }
}
?>