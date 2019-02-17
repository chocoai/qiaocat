<?php
namespace app\dresser\controller;
use think\Controller;
use think\Db;
use think\console\Input;

/**
 * 优惠券类
 */
class Coupon extends Controller{
    
    
    
    /**
     * @api {post} dresser/dr_coupon_onoff 优惠券开启暂停[dresser/dr_coupon_onoff]
     * @apiVersion 2.0.0
     * @apiName dr_coupon_onoff
     * @apiGroup dresser_Coupon
     * @apiSampleRequest dresser/dr_coupon_onoff
     *
     * @apiParam {int} id     优惠券id
     * @apiParam {int} type    开启传1 暂停传0
     */
    public function coupon_onoff(){
        if(if_cookie()==true){
          if(if_meiye()==true){
           $id = input('id');
           $type = input('type');
           $data=['id'=>$id,'type'=>$type];
           $validate = validate('CouponOnOff');
           if(!$validate->check($data)){
               return json(['status'=>'error','msg'=>$validate->getError()]);
           }
           $res = Db::name('coupon')->where('id',$id)->setField('allow_user_fetch',$type);
           if($res){
               return json(['status'=>'ok','msg'=>'修改成功']);
           }else{
               return json(['status'=>'error','msg'=>'修改失败']);
           }
          }else{
             return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
          }
        }else{
          return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_coupon_index 优惠券管理[dresser/dr_coupon_index]
     * @apiVersion 2.0.0
     * @apiName dr_coupon_index
     * @apiGroup dresser_Coupon
     * @apiSampleRequest dresser/dr_coupon_index
     *
     */
    public function coupon_index(){
        if(if_cookie()==true){
            if(if_meiye()==false){
               return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
          $time = date('Y-m-d H:i:s',time());
          $data_you = Db::name('coupon')
            ->where('store_id',get_cookie()['id'])
            ->where('end_time','>=',$time)
            ->select(); 
          $data_guo = Db::name('coupon')
            ->where('store_id',get_cookie()['id'])
            ->where('end_time','<',$time)
            ->select(); 
          return json(['status'=>'ok','you'=>['count'=>count($data_you),'data'=>$data_you],'guo'=>['count'=>count($data_guo),'data'=>$data_guo]]);
        }else{
          return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_set_coupon 美业师创建优惠券[dresser/dr_set_coupon]
     * @apiVersion 2.0.0
     * @apiName dr_set_coupon
     * @apiGroup dresser_Coupon
     * @apiSampleRequest dresser/dr_set_coupon
     *
     * @apiParam {string} name    优惠券名称
     * @apiParam {string} coupon_value    适用范围，全部传0，其他传商品id用，分开
     * @apiParam {int} base_amount    最低满多少元（使用条件）
     * @apiParam {int} coupon_amount   优惠券面额
     * @apiParam {int} total_count    发行张数
     * @apiParam {string} start_time    有效开始时间
     * @apiParam {string} end_time    有效结束时间
     * 
     */
    public function set_coupon(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $name = input('name');
            $coupon_value = input('coupon_value');
            $base_amount= input('base_amount');
            $coupon_amount = input('coupon_amount');
            $total_count = input('total_count');
            $start_time = input('start_time');
            $end_time = input('end_time');
            $time = strtotime($end_time) - strtotime($start_time);
            $description = '消费满'.$base_amount.'元可用的'.$name.'优惠券';
            $coupon_type = 2;
            $data=['name'=>$name,'coupon_value'=>$coupon_value,'coupon_type'=>$coupon_type,'coupon_amount'=>$coupon_amount,
                   'start_time'=>$start_time,'end_time'=>$end_time,'total_count'=>$total_count,'min_amount'=>$base_amount,
                   'expired_time'=>$time,'per_count'=>1,'base_amount'=>$base_amount,'allow_user_fetch'=>1,
                   'online'=>1,'description'=>$description,'store_id'=>get_cookie()['id'],'created_at'=>date('Y-m-d H:i:s',time()),
                  ];
            
            $validate = validate('SetCoupon');
            if(!$validate->check($data)){
                return json(['status'=>'error','msg'=>$validate->getError()]);
            }
            
            $res = Db::name('coupon')->insert($data);
            if($res){
                return json(['status'=>'ok','msg'=>'添加成功']);   
            }else{
                return json(['status'=>'error','msg'=>'添加失败']);   
            }
            
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
        
    }
    
    /**
     * @api {post} dresser/dr_get_product_type 美业获取商品有哪些类型[dresser/dr_get_product_type]
     * @apiVersion 2.0.0
     * @apiName dr_get_product_type
     * @apiGroup dresser_Coupon
     * @apiSampleRequest dresser/dr_get_product_type
     *
     */
    public function get_product_type(){
        if(if_cookie()==true){
            $id = get_cookie()['id'];
            $cate_id = Db::name('stylist_service')->where(['stylist_id'=>$id,'online'=>1,'is_del'=>0])->group('cate_id')->field('cate_id')->select();
            $arr=[];
            foreach ($cate_id as $v){
                $type = Db::name('product_category')->where('id',$v['cate_id'])->field(['id','name'])->find();
                array_push($arr, $type);
            }
            return json(['status'=>'ok','data'=>$arr]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} dresser/dr_get_product_to 根据类型获取对应商品[dresser/dr_get_product_to]
     * @apiVersion 2.0.0
     * @apiName dr_get_product_to
     * @apiGroup dresser_Coupon
     * @apiSampleRequest dresser/dr_get_product_to
     *
     * @apiParam {id} cate_id  类型id
     */
    public function get_product_to(){
        if(if_cookie()==true){
            $cate_id = input('cate_id');
            if(empty($cate_id)==true){
                return json(['status'=>'error','msg'=>'类型不能为空']);
            }
            $id = get_cookie()['id'];
            $product = Db::name('stylist_service')->where(['stylist_id'=>$id,'online'=>1,'is_del'=>0,'cate_id'=>$cate_id])->field('product_id')->select();
            $arr=[];
            foreach ($product as $v){
                $name = Db::name('product')->where('id',$v['product_id'])->field(['id','name'])->find();
                array_push($arr, $name);
            }
            return json(['status'=>'ok','data'=>$arr]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
        
    }
    
    
    
    
}