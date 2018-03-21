<?php
namespace Admin\Controller;

class GoodsController extends AdminController
{
	public function index ()
	{
		echo '111';
		send_sms_code('18516051096','4456');
	} 
}