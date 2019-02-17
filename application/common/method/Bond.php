<?php
namespace app\common\method;
use think\Controller;

/**
 * 保证金算法
 */
class Bond extends Controller{
    
    
      //计算美业师的保证金总额
     public function set_bond($str){
         
         $arr = explode(',',$str);
         
         $this->m=0;
         
         if(in_array('1',$arr)===true){
             $this->m=1000;
         }
         if(in_array('64',$arr)===true){
             $this->m=1500;
         }
         if(in_array('128',$arr)===true){
             $this->m=3000;
         }
         
         return $this->m;
     }
    
    
    
    
    
    
    
    
    
    
    
    
    
}