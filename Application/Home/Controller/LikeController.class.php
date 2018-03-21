<?php 
namespace Home\Controller;
use Think\Controller;
class LikeController extends HomeController 
{
    public function doadd()
    {
     	$id = $_GET['gid'];
        $model= M('like');
        $num=$model
        ->where('gid='.$id)
        ->field("like.like")
        ->select();
        if (empty($num)) 
        {
            $data['gid']=$id;
            $data['like']=0;
            $data['bad']=0;

            $model
            ->add($data);
            $num[0]['like'] = 0;
        }
        $sum = $num[0]['like'];
        $sum += 1;


        $data['like'] = $sum;
        $model
        ->where('gid='.$id)
        ->save($data);
        $this->success('点赞成功');
     	
    }
    public function step()
    {
        $id = $_GET['gid'];
        $model= M('like');
        $num=$model
        ->where('gid='.$id)
        ->field("like.bad")
        ->select();
        // var_dump($num);exit;
        if (empty($num)) 
        {
            $data['gid']=$id;
            $data['like']=0;
            $data['bad']=0;

            $model
            ->add($data);
            $num[0]['bad'] = 0;
        }
        $sum = $num[0]['bad'];
        $sum += 1;


        $data['bad'] = $sum;
        $model
        ->where('gid='.$id)
        ->save($data);
        $this->success('你残忍地踩了一下');
        
    }
}