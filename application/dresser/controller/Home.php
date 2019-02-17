<?php
namespace app\dresser\controller;
use think\Controller;
use think\Db;

/**
 * 美业师首页各接口
 */
class Home extends Controller{
    
    
    /**
     * @api {post} dresser/dr_rob_order 美业师抢单首页[dresser/dr_rob_order]
     * @apiVersion 2.0.0
     * @apiName dr_rob_order
     * @apiGroup dresser_Home
     * @apiSampleRequest dresser/dr_rob_order
     *
     * @apiParam {int} page_no    第几页
     * @apiParam {int} per_page    一页几条
     */
    public function rob_order(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
              }
            $id = get_cookie()['id'];
            $page_no  = input('page_no')?input('page_no'):1;
            $per_page = input('per_page')?input('per_page'):10;
            //查出美业师所在城市
            $city_id = Db::name('stylist')->where('id',$id)->value('city_id');
            
//             //查出美业师发布了哪些服务(暂时不开此条件)
//             $sql= Db::name('stylist_service')->where(['stylist_id'=>$id,'online'=>1])->field('product_id')->select();
//             if(count($sql)<1){
//                 return json(['status'=>'ok','data'=>[]]);
//             }
//             $product='';
//             foreach ($sql as $v){
//                 $product = $product.','.$v['product_id'];
//             }
//             $product=trim($product,','); 

            $field=['a.id','a.sn','a.order_status','a.buyer_id','a.created_at','a.order_amount','a.product_amount',
                    'b.province','b.city','b.district','b.address','b.send_time','c.product_number','d.name','d.thumb'
                   ];
            //超过30分钟过期不显示
            $s_time = date('Y-m-d H:i:s',time()-1800);
            $e_time = date('Y-m-d H:i:s',time());
            $res = Db::name('order')->alias('a')
                  ->where('a.seller_id','in',[0,324251793])
                  ->where(['b.city'=>$city_id])->where('a.order_status','in',[1,201,202])
                  ->where('a.created_at','between',[$s_time,$e_time])
                  ->join('order_shipping b','a.sn = b.order_sn','INNER')
                  ->join('order_product c','a.sn = c.order_sn','INNER')
                  ->join('product d','c.product_id = d.id','INNER')
                  ->field($field)
                  ->page($page_no,$per_page)
                  ->order('a.created_at','desc')
                  ->select();
            if(count($res)>0){
                 for($i=0;$i<count($res);$i++){
                      $province = Db::name('location_province')->where('province_id',$res[$i]['province'])->value('name');
                      $city = Db::name('location_city')->where('city_id',$res[$i]['city'])->value('name');
                      $district = Db::name('location_area')->where('area_id',$res[$i]['district'])->value('name');
                      $res[$i]['add'] = $province.$city.$district.$res[$i]['address'];
                   }
               return json(['status'=>'ok','data'=>$res]);
            }else{
                return json(['status'=>'ok','data'=>[]]);
            }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} dresser/dr_confirm_order 美业师确认抢单[dresser/dr_confirm_order]
     * @apiVersion 2.0.0
     * @apiName dr_confirm_order
     * @apiGroup dresser_Home
     * @apiSampleRequest dresser/dr_confirm_order
     *
     * @apiParam {int} id   订单主键id   
     */
    public function confirm_order(){
       if(if_cookie()==true){
         if(if_meiye()==false){
            return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
         }
         if(if_online()==false){
            return json(['status'=>'error','code'=>-4,'msg'=>get_msg(-4)]);
         }
         if(if_business()==false){
            return json(['status'=>'error','code'=>-6,'msg'=>get_msg(-6)]);
         }
         $id = input('id');
         $seller_id = Db::name('order')->where('id',$id)->lock(true)->value('seller_id');
         if($seller_id!=0 && $seller_id!=324251793){
           return json(['status'=>'error','msg'=>'此订单已被确认，请抢其他订单']);
         }
         $time = date('Y-m-d H:i:s',time());
         $data=['seller_id'=>get_cookie()['id'],'order_status'=>300,'confirm_time'=>$time,'updated_at'=>$time];
         $res = Db::name('order')->where('id',$id)->update($data);
         if($res){
             return json(['status'=>'ok','msg'=>'抢单成功']);
         }else{
             return json(['status'=>'error','msg'=>'抢单失败']);
         }
            
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    
}