<?php
namespace Home\Model;
use Think\Model\ViewModel;
class OrderslistViewModel extends ViewModel {
   public $viewFields = array(
     'orders'=>array('id','name','title'),
     'orderstatus'=>array('title'=>'category_name', '_on'=>'Blog.category_id=Category.id'),
     'customerclient'=>array('name'=>'username', '_on'=>'Blog.user_id=User.id'),
   );
 }
?>