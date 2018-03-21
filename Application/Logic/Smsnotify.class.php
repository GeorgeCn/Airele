<?php
namespace Logic;
class Commonsms{
	public function Commonsms($orderId)
	{
			/*发送租客*/
			$sendArr['phonenumber']=$modelOrder['renter_phone'];
			$sendArr['smstype']='EFW004';
			$sendArr['timestamp']=time();
			$sendArr['name']=$modelOrder['renter_name'];
			$sendArr['money']=$modelOrder['price_cnt'];
			$sendArr['orderid']=$modelOrder['order_num'];
			sendPhoneContent($sendArr);
			//发送老夏
			/*
			$xiaArr['phonenumber']="13816506627"; 
			$xiaArr['smstype']='EFM002';
			$xiaArr['timestamp']=time();
			$xiaArr['name']=$modelOrder['renter_name'];
			$xiaArr['money']=$modelOrder['price_cnt'];
			$xiaArr['orderid']=$modelOrder['order_num'];
			
			sendPhoneContent($xiaArr);
			//发送颖
			$yinArr['phonenumber']="13795419927";
			$yinArr['smstype']='EFM002';
			$yinArr['timestamp']=time();
			$yinArr['name']=$modelOrder['renter_name'];
			$yinArr['money']=$modelOrder['price_cnt'];
			$yinArr['orderid']=$modelOrder['order_num'];
			sendPhoneContent($yinArr);*/
		
	}
		
}

?>