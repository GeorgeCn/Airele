<?php
namespace Home\Model;
use Think\Model;
class comment{
    const connecdata = 'DB_DATA';
    //总条数
   public function modelCommentPageCount($where){
     $ModelTable = M("houseownercomment");
     $result = $ModelTable->field('count(owner_id) as count')->where($where)->group('owner_id')->select();
     return $result;
   }
    //获取分页数据
   // public function modelCommentList($firstrow,$listrows,$where){
   //    $ModelTable = M("houseownercomment");
   //    $datalist = $ModelTable->field('houseownercomment.owner_id,count(houseownercomment.owner_id) as count,view_customer.true_name,view_customer.mobile')->join('view_customer on view_customer.id=houseownercomment.owner_id')->where($where)->group('houseownercomment.owner_id')->order('count(houseownercomment.owner_id) desc')->limit($firstrow,$listrows)->select();
   //   return $datalist;
   // }
   public function modelCommentList($firstrow,$listrows,$where){
       $ModelTable = M("houseownercomment");
       $datalist = $ModelTable->field('owner_id,count(owner_id) as count')->where($where)->group('owner_id')->order('count(owner_id) desc')->limit($firstrow,$listrows)->select();
       return $datalist;
    }


   public function modelDetailedPageCount($where){
     $ModelTable = M("houseownercomment");
     $result = $ModelTable->where($where)->count();
     return $result;
   }
   //获取房东姓名
   public function modelDetailedComment($firstrow,$listrows,$where){
     $ModelTable=M('houseownercomment');
     $result = $ModelTable->where($where)->order('create_time desc')->limit($firstrow,$listrows)->select();
     return $result;
   }
    //删除评论
  public function modeldelComment($delid){
     $ModelTable = M("houseownercomment");
     $condition['id'] =$delid;
     $data['record_status']=0;
     $data['delete_id']=getLoginName();
     $data['delete_time']=time();
     $result = $ModelTable->where($condition)->save($data);
     return $result;
   }
   public function modelCustomerById($condition){
     $ModelTable=M('customer','',self::connecdata);
     $result = $ModelTable->where($condition)->find();
     return $result;
   }
    public function modelCustomer($where){
     $ModelTable=M('customer','',self::connecdata);
     $result = $ModelTable->where($where)->select();
     return $result;
   }
   public function modelAdd($data){
     $ModelTable=M('houseownercomment');
     $result = $ModelTable->data($data)->add();
     return $result;
   }
   public function modelFind($where){
      $ModelTable = M("houseownercomment");
      $result = $ModelTable->where($where)->find();
      return $result;
   }
}
?>