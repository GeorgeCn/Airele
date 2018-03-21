<?php
namespace Home\Controller;
use Think\Controller;
class SearchCountController extends Controller {
    
    //数据监控
    public function searchlist(){
             $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new \Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"141");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"141");
            //$handleMenu->jurisdiction();

            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }
    public function searchcount(){
          $handsearch=new \Home\Model\searchresult();
          $daytime=I('get.daytime');
          if($daytime!=""){  
               $searchtotal=$handsearch->searchtotal($daytime);//总搜索次数
               $searchresult=$handsearch->searchresult($daytime);//有结果搜索次数
               $totalnum=$searchtotal[0]['countnum'];//总搜索次数
               $resultnum=$searchresult[0]['countnum'];//有结果搜索次数
               $replyrate=round((float)($resultnum/$totalnum)*100,2);
               $array=array('totalnum'=>$totalnum,'resultnum'=>$resultnum,'replyrate'=>$replyrate);
               echo json_encode($array);
          }
    }
    //每日热词
    public function hotwords(){
          $handleCommonCache=new \Logic\CommonCacheLogic();
             if(!$handleCommonCache->checkcache()){
                return $this->error('非法操作',U('Index/index'),1);
             }
            $switchcity=$handleCommonCache->cityauthority();
            $this->assign("switchcity",$switchcity);
            $handleMenu = new \Logic\AdminMenuListLimit();
            $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"141");
            $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"141");
            $handsearch=new \Home\Model\searchresult();
            $wordtime=I('get.wordtime');
            if($wordtime!=""){  
                  $rearr=$handsearch->searchhotwords($wordtime);
                  foreach ($rearr as $key => $value) {
                     $su[]=$value['key_words'];
                  }
                  $ary=array_count_values($su);
                  arsort($ary);//倒序排序             
                  $wordsarr=$handsearch->gethotwords($wordtime);
                  $i=0;
                    foreach($ary as $ary_key=>$ary_value){
                      if($i<200){
                      foreach ($wordsarr as $key1 => $value1) {
                           if($ary_key==$value1['key_words']){
                             $newvalue['key_words']=$ary_key;
                             $newvalue['is_reult']=$value1['is_reult'];
                             $newvalue['countnum']=$ary_value;
                             $newvalue['id']=$value1['id'];
                             $newvalue['city_code']=$value1['city_code'];
                             $newarr[]=$newvalue;
                           }
                      }
                    }
                      $i++;
                  } 
            }
            $this->assign("newarr",$newarr);
            $this->assign("menutophtml",$menu_top_html);
            $this->assign("menulefthtml",$menu_left_html);
            $this->display();
    }
    //房间列表
    public function roomlist(){
      $handleCommonCache=new \Logic\CommonCacheLogic();
      if(!$handleCommonCache->checkcache()){
         return $this->error('非法操作',U('Index/index'),1);
      }
      $switchcity=$handleCommonCache->cityauthority();
      $this->assign("switchcity",$switchcity);
      $handleMenu = new \Logic\AdminMenuListLimit();
      $menu_top_html=$handleMenu->menuTop(cookie("admin_user_name"),"141");
      $menu_left_html=$handleMenu->menuLeft(cookie("admin_user_name"),"141");
      $handsearch=new \Home\Model\searchresult();
      $searchid=I('get.searchid');
      if($searchid!=""){
         $searcharr=$handsearch->modelfind($searchid);
         $roomidarr=explode(",",$searcharr[0]['room_ids']);
         for ($i=0; $i <count($roomidarr); $i++) {
             $roomarr=$handsearch->modelGetView($roomidarr[$i]);
             if(!empty($roomarr)){
              $newarr[]=$roomarr;
             }
         }
      }
      $this->assign("newarr",$newarr);
      $this->assign("menutophtml",$menu_top_html);
      $this->assign("menulefthtml",$menu_left_html);
      $this->display();

    }
}
?>