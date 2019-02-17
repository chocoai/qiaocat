<?php
namespace app\dresser\controller;

use think\Controller;
use think\Db;
use think\View;
use think\Cache;

/**
*服务的接口
*/

class Order extends Controller{

      /**
       * @api {post} dresser/dr_order_status 查询各种订单状态列表[dresser/dr_order_status
       * @apiVersion 2.0.0
       * @apiName dr_order_status
       * @apiGroup dresser_Order
       * @apiSampleRequest dresser/dr_order_status
       *
       * @apiParam {int} order_type    订单的状态类型  2待确定 3待服务 4进行中  all所有的 
       *
       */
      
       public function order_status(){
          if(if_cookie()==true && if_meiye()==true){
               $id = get_cookie()['id'];
               //判断该美业师是否营业和在线
               $res_type = Db::name('stylist')->where('id',$id)->find();
               if($res_type['is_business'] == 1) return json(['status'=>'error','code' => -6,'msg'=>get_msg(-6)]);
               if($res_type['is_online'] == 1) return json(['status'=>'error','code' => -7,'msg'=>get_msg(-7)]);
               //$id = 324248948;
               $order_type = input('order_type');
               //$order_type = 1;
               $sql = "select o.id,o.sn,o.buyer_id,o.service_form,o.seller_id,o.order_status,o.created_at,o.need_to_pay,o.pay_time,o.to_buyer,o.already_paid,o.start_service_time,end_service_time,u.id as uid,u.nick,u.mobile,os.address,os.send_time,lp.name as lpname,lc.name as lcname,la.name as laname from m2_order as o left join m2_user as u ON o.buyer_id = u.id left join m2_order_shipping as os ON o.id = os.order_id left join m2_location_province as lp ON os.province = lp.province_id left join m2_location_city as lc ON os.city = lc.city_id left join m2_location_area as la ON os.district = la.area_id";
               //$id = 324248948;   //类型是 2 3 4 用这个id测试
               //$id = 324248408;   //类型是 1 用这个id测试
               if($order_type == 1){
                $res = Db::name('stylist')->where('id',$id)->field('province_id,city_id,area_id,street_id')->find();
                $sql .= " where o.order_status = 0 and os.province = '{$res['province_id']}' and os.city = '{$res['city_id']}' and os.district = '{$res['area_id']}' and os.street in ({$res['street_id']}) order by id desc";
               }elseif($order_type == 2){
                $sql .= " where o.seller_id = '{$id}' and o.order_status in (201,202) order by id desc";
               }elseif($order_type == 3){
                $sql .= " where o.seller_id = '{$id}' and o.order_status = 300 order by send_time asc";
               }elseif($order_type == 4){
                $sql .= " where o.seller_id = '{$id}' and o.order_status = 301 order by id desc";
               }elseif($order_type == 'all'){
                $sql .= " where o.seller_id = '{$id}' order by id desc";
               }
               
              
                try {
                  $data = Db::query($sql);
                  foreach ($data as $k => $v) {
                       $sql2 = "select op.product_name,product_number,op.market_price,product_price,p.thumb from m2_order_product as op left join m2_product as p ON op.product_id = p.id where op.order_id = {$v['id']}";
                       $data[$k]['order_product'] =  Db::query($sql2);
                  }
                  //dump($data);
                  return json(['status' => 'ok','data' => $data]);
                } catch (\Throwable $e) {
                  return json(['status'=>'error','code' => -5,'msg'=>get_msg(-5)]);
                }

          }else {
              return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
          }



       }


       /**
       * @api {post} dresser/dr_order_detail 订单详情[dresser/dr_order_detail
       * @apiVersion 2.0.0
       * @apiName dr_order_detail
       * @apiGroup dresser_Order
       * @apiSampleRequest dresser/dr_order_detail
       *
       * @apiParam {int} order_id            订单id
       *
       */
      public function order_detail(){
            if(if_cookie()==true && if_meiye()==true){
                 $order_id = input('order_id');
                 //$order_id = 7115;
                 $sql = "select o.id,o.sn,o.buyer_id,o.seller_id,o.service_form,o.order_status,o.created_at,o.balance_paid,o.coupon_paid,o.to_buyer,o.already_paid,o.note,o.order_time,o.cancem_time,o.created_at,o.pay_time,mc.created_at as com_time,o.start_service_time,end_service_time,u.id as uid,u.nick,os.mobile,os.address,os.send_time,lp.name as lpname,lc.name as lcname,la.name as laname from m2_order as o left join m2_user as u ON o.buyer_id = u.id left join m2_order_shipping as os ON o.id = os.order_id left join m2_location_province as lp ON os.province = lp.province_id left join m2_location_city as lc ON os.city = lc.city_id left join m2_location_area as la ON os.district = la.area_id left join m2_comment as mc ON o.id = mc.order_id where o.id = '{$order_id}' ";
                  $data = Db::query($sql);
                  //根据订单id查询出该订单拥有的商品
                  $sql2 = "select op.product_name,product_number,op.market_price,product_price,p.thumb,p.images from m2_order_product as op left join m2_product as p ON op.product_id = p.id where op.order_id = {$data[0]['id']}";
                 try {
                   $product_detail = Db::query($sql2);
                   $data[0]['order_product'] = $product_detail;
                   //dump($data);
                   return json(['status' => 'ok','data' => $data]);
                 } catch (\Throwable $e) {
                   return json(['status'=>'error','code' => -5,'msg'=>get_msg(-5)]);
                 }
            }else {
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
      }


      
      /**
       * @api {post} dresser/dr_cancel_order 美业师拒绝订单[dresser/dr_cancel_order
       * @apiVersion 2.0.0
       * @apiName dr_cancel_order
       * @apiGroup dresser_Order
       * @apiSampleRequest dresser/dr_cancel_order
       *
       * @apiParam {int} order_id            订单id
       *
       */


       public function cancel_order(){
              if(if_cookie()==true && if_meiye()==true){
                //美业师id
                $map['seller_id'] = get_cookie()['id'];
                //$map['seller_id'] = 324248948;
                //订单id
                $map['id'] = input('order_id');
                try {
                  Db::name('order')->where($map)->update(['order_status' => 302]);
                  return json(['status' => 'ok','msg' => '取消订单成功']);
                } catch (\Throwable $e) {
                  return json(['status' => 'error','msg' => '取消订单失败']);
                }

              }else {
                return json(['status'=>'error','msg'=>'账号未登录或不是美业师']);
              }
       }


       /**
       * @api {post} dresser/dr_make_sure_order 美业师接单[dresser/dr_make_sure_order
       * @apiVersion 2.0.0
       * @apiName dr_make_sure_order
       * @apiGroup dresser_Order
       * @apiSampleRequest dresser/dr_make_sure_order
       *
       * @apiParam {int} order_id            订单id
       *
       */
       
       public function make_sure_order(){
              if(if_cookie()==true && if_meiye()==true){
                //美业师id
                $map['seller_id'] = get_cookie()['id'];
                //$map['seller_id'] = 324248948;
                //订单id
                $map['id'] = input('order_id');
                try {
                  Db::name('order')->where($map)->update(['order_status' => 300,'order_time' => date('Y-m-d H:i:s')]);
                  return json(['status' => 'ok','msg' => '确认订单成功']);
                } catch (\Throwable $e) {
                  return json(['status' => 'error','msg' => '确认订单失败']);
                }

              }else {
                return json(['status'=>'error','msg'=>'账号未登录或不是美业师']);
              }
       }

      
       




 }