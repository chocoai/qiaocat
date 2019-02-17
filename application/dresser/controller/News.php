<?php
namespace app\dresser\controller;
use think\Controller;
use think\Db;

/**
 *消息类接口
 */
class News extends Controller{
    
    
    /**
     * @api {post} dresser/dr_order_news 订单消息[dresser/dr_order_news]
     * @apiVersion 2.0.0
     * @apiName dr_order_news
     * @apiGroup dresser_News
     * @apiSampleRequest dresser/dr_order_news
     *
     * @apiParam {int} page_no    第几页
     * @apiParam {int} per_page    一页几条
     */
    public function order_news(){
        if(if_cookie()==true){
          $id=get_cookie()['id'];
          $page_no  = input('page_no')?input('page_no'):1;
          $per_page = input('per_page')?input('per_page'):10;
          $field=['order_sn','buyer_id','is_reade','send_time','order_status','c.name','c.images'];
          $data = Db::name('user_message')->alias('a')->where(['receive_uid'=>$id,'sender_id'=>0,'message_type'=>4])
                  ->join('order b','a.order_sn = b.sn','INNER')
                  ->join('product c','a.related_id = c.id','INNER')
                  ->field($field)
                  ->page($page_no,$per_page)
                  ->order('send_time','desc')
                  ->select();
            return json(['status'=>'ok','data'=>$data]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}