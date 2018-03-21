<?php
namespace Logic;
use Think\Controller;
class SmssendLogic extends Controller{
    //统计总条数
	 public function modelSmssendCount($where){
    	$modelDal=new \Home\Model\smssend();
    	$result=$modelDal->modelSmssendCount($where);
    	return $result;
    }
    //获取分页数据
    public function modelSmssendList($where,$firstrow,$listrows){
  		$modelDal=new \Home\Model\smssend();
        $result=$modelDal->modelSmssendList($where,$firstrow,$listrows);
        return $result;     
    }
    /*生成短链接 */
    public function getShorturl($long_url){
        $short_id=$this->createShortid();
        set_couchebase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$short_id,$long_url,3600*72);
        return 'hizhu.com/'.$short_id;
    }
    private function createShortid(){
        $coding = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $short_id=substr($coding, rand(0,61),1).substr($coding, rand(0,61),1).substr($coding, rand(0,61),1).substr($coding, rand(0,61),1).substr($coding, rand(0,61),1).substr($coding, rand(0,61),1).substr($coding, rand(0,61),1);
    
        if(C('IS_REDIS_CACHE')){
            $long_url=get_couchbase_data(C('COUCHBASE_BUCKET_GAODUDATA'),$short_id);
            if(empty($long_url)){
                return $short_id;
            }
            return $this->createShortid();
        }
    }
    
}
?>