<?php
namespace Logic;
class PushemailLogic{
	   /*下架房源，邮件推送 */
     public function housepushemail($room_id){
        if($room_id!=""){
          $house = new \Logic\HouseRoomLogic();
          $roomarr=$house->getModelById($room_id);
          if($roomarr!=null && $roomarr['customer_id']!=""){
                $housecustomerinfo = new \Logic\CustomerInfo();
                $customerinfo=$housecustomerinfo->modelFind(array('customer_id'=>$roomarr['customer_id']));
                if($customerinfo!=null && $customerinfo['principal_man']!=""){
                     $houseadmin = new \Logic\AdminLogin();
                     $adminarr=$houseadmin->modelAdminFind(array('user_name'=>$customerinfo['principal_man']));
                     if($adminarr!=null && $adminarr['email']!=""){
                        //$customerlogic = new \Logic\CustomerLogic();
                        //$ownerarr=$customerlogic->getModelById($roomarr['customer_id']);
                        $data['id']=create_guid();
                        $data['customer_id']="";
                        switch ($roomarr['city_code']) {
                          case '001009001':
                            $data['mail_to']=$adminarr['email'].",suhongye@hizhu.com,xuwenhua@hizhu.com";
                            break;
                          case '001001':
                            $data['mail_to']=$adminarr['email'].",suhongye@hizhu.com,haotongrui@hizhu.com";
                            break;
                          case '001011001':
                            $data['mail_to']=$adminarr['email'].",yantaojie@hizhu.com,sunwenpei@hizhu.com";
                            break;
                          case '001010001':
                            $data['mail_to']=$adminarr['email'].",xujin@hizhu.com,zhanglu@hizhu.com,chenqi@hizhu.com";
                            break;
                          case '001019002':
                            $data['mail_to']=$adminarr['email'].",yantaojie@hizhu.com,zhouqihao@hizhu.com,dingyuanxue@hizhu.com";
                            break;
                          default:
                            $data['mail_to']=$adminarr['email'];
                            break;
                        }
                        //$data['mail_to']="hudong@hizhu.com";//todo;注释
                        //读取房源信息
                        $house = new \Home\Model\houseresource();
                        $resourceModel=$house->getModelById($roomarr['resource_id']);
                        $mail_subject='房源下线通知';
                        //置顶房源判断
                        $house = new \Home\Model\houseselect();
                        $toplist=$house->getTopList(" room_id='$room_id' and top_type>0","",0,1);
                        if($toplist!=null && count($toplist)>0){
                          $mail_subject='置顶房源下线通知';
                        }
                        if($mail_subject=='房源下线通知'){
                          return;
                        }
                        $data['mail_to_name']=$adminarr['user_name'];
                        $data['mail_subject']=$mail_subject;
                        $data['mail_content']=$roomarr['room_no'].$resourceModel['estate_name'].$roomarr['room_money']."元的房源已下线，房东手机号为".$resourceModel['client_phone']."，房东姓名为".$resourceModel['client_name']."，房源负责人为".$roomarr['create_man']."，操作人为".$roomarr['update_man']."，房东负责人为".$customerinfo['principal_man'];
                        $data['mail_type']=0;
                        $modelemail=new \Home\Model\customeremail();
                        $modelemail->modelAdd($data);
                        log_result("pushemaillog.txt",$mail_subject."：".$data['mail_content']);
                     }
                }
            }
        }
     }
     /*拉黑用户，邮件推送 */
     public function addBlackuserPushemail($mobile,$handle_man){
        if(empty($mobile)){
           return false;
        }
         $modelDal=new \Home\Model\customer();
         $customerModel = $modelDal->getResourceClientByPhone($mobile);
          if($customerModel!=null && $customerModel['is_owner']==4){
              $housecustomerinfo = new \Logic\CustomerInfo();
              $customerinfo=$housecustomerinfo->modelFind(array('customer_id'=>$customerModel['id']));
              if($customerinfo['principal_man']!=""){
                 $houseadmin = new \Logic\AdminLogin();
                 $adminarr=$houseadmin->modelAdminFind(array('user_name'=>$customerinfo['principal_man']));
                 if($adminarr['email']!=""){
                    $data['id']=create_guid();
                    $data['customer_id']="";
                    switch ($customerModel['city_code']) {
                      case '001009001':
                        $data['mail_to']=$adminarr['email'].",suhongye@hizhu.com";
                        break;
                      case '001001':
                        $data['mail_to']=$adminarr['email'].",suhongye@hizhu.com";
                        break;
                      case '001011001':
                        $data['mail_to']=$adminarr['email'].",yantaojie@hizhu.com";
                        break;
                      case '001010001':
                        $data['mail_to']=$adminarr['email'].",xujin@hizhu.com";
                        break;
                      case '001019002':
                        $data['mail_to']=$adminarr['email'].",yantaojie@hizhu.com";
                        break;
                      default:
                        $data['mail_to']=$adminarr['email'];
                        break;
                    }
               
                    //$data['mail_to']="hudong@hizhu.com";//todo;注释

                    $data['mail_to_name']=$adminarr['user_name'];
                    $data['mail_subject']="拉黑用户通知";
                    $data['mail_content']=$mobile."用户已拉黑，操作人为".$handle_man."，房东负责人为".$customerinfo['principal_man'];
                    $data['mail_type']=0;
                    $modelemail=new \Home\Model\customeremail();
                    $modelemail->modelAdd($data);
                    log_result("pushemaillog.txt","拉黑用户通知：".$data['mail_content']);
                 }
              }
         }
        
     }
}
?>