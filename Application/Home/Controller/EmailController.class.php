<?php
namespace Home\Controller;
use \Think\Controller;

class EmailController extends Controller
{
 	public function index () 
 	{
 		send_email();
 		$this->display('index');
 	}

}