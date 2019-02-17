<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;
use app\qiaomao\model\Calculator;
use app\qiaomao\model\Stylist;
use app\qiaomao\model\UseCouponBehavior;
use think\Log;

/**
 * 俏猫订单类
 */
class Order extends Controller{
    protected $tb_user = 'user';
    private $tb_product = 'product';
    private $meta_sets = array();
    protected $tb_stylist_service = 'stylist_ser';
    protected $tb_stylist_product = 'stylist_product';
    protected $tb_stylist = 'stylist';
    protected $tb_order_status = 'order_status';
    protected $tb_order = 'order';
    protected $tb_order_product = 'order_product';
    protected $tb_order_contact = 'order_shipping';
    
    const STATUS_CREATE = 0;
    const STATUS_PAID = 1;
    const STATUS_SYS_CONFIRM = 200;
    const STATUS_DISPATCH = 201;
    const STATUS_WAIT_SELLER_CONFIRM = 202;
    const STATUS_SELLER_CONFIRM = 300;
    const STATUS_BUYER_CONFIRM = 301;
    const STATUS_PRODUCT_FINISH = 1000;
    const STATUS_FINISH = 1000;
    const STATUS_CANCEL_CHARGE = 10000;
    const STATUS_CLOSE = 11000;
    const STATUS_CANCEL = 11000;
    const TAG_SELLER_CONFIRM = 'order.seller.confirm';
    const TAG_BUYER_CONFIRM = 'order.buyer.confirm';
    const TAG_CANCEL = 'order.cancel';
    
   
    /**
     * 评论商品
     * @param array $data ['order_id' => '', 'product_id' => '', 'content' => '', 'score' => 1, 'attitude' => 1, 'images' ＝> [], parent_id => 0, 'top_parent_id' => 0]
     * @return array|bool
     */
    
    /**
     * @api {post} qiaomao/qm_order_comment 俏猫-订单评论[qiaomao/qm_order_comment
     * @apiVersion 2.0.0
     * @apiName qm_order_comment
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_comment
     *
     * @apiParam {int} order_id            订单id
     * @apiParam {int} product_id          商品id
     * @apiParam {String} content          评论内容
     * @apiParam {int} score               评分
     * @apiParam {String} images           images 多张图’,‘隔开
     * @apiParam {int} parent_id           parent_id
     * @apiParam {int} top_parent_id       top_parent_id
     * 
     * 
     *
     */
    public function order_comment()
    {
        $data['order_id'] = (input("order_id")) ?input("order_id"):'';
        $data['product_id'] = (input("product_id")) ?input("product_id"):'';
        $data['content'] = (input("content")) ?input("content"):'';       
        $data['score'] = (input("score")) ?input("score"):1;
        $data['attitude'] = (input("attitude")) ?input("attitude"):1;
        $data['images'] = (input("images")) ?input("images"):'';
        $data['parent_id'] = (input("parent_id")) ?input("parent_id"):0;
        $data['top_parent_id'] = (input("top_parent_id")) ?input("top_parent_id"):0;
        //$data['images'] = explode(',', $data['images']);
        
        if (!if_cookie()) {
            return json_nologin();
        } else {
            $user = user_info();
            $user_id = $user['id'];
            
        }
        $parent_id = array_get($data, 'parent_id', 0);
        if ($parent_id) {
            //check parent id
            $parent = Db::name('comment')->where(['id'=>$parent_id])->field(['top_parent_id'])->find();
            if ($parent) {
                $top_parent_id = $parent['top_parent_id'];
            } else {
                return json_error('评论回复对象不存在');
            }
        } else {
            $top_parent_id = array_get($data, 'top_parent_id', 0);
            $parent_id = $top_parent_id;
        }
    
        $order = Db::name('order')->where(['id'=>intval($data['order_id'])])->find();
        $pid = intval($data['product_id']);
        if ($order && ($user_id == $order['buyer_id'] || $user_id == $order['seller_id'])) {
            if ($pid > 0 && !Db::name('order_product')->where(['order_id' => $order['id'], 'product_id' => $pid])->find()) {
                return json_error("所评论产品并不属于订单[${order['sn']}]");
        }
       // $client = $this->client();
        $cmt = [
            'parent_id' => $parent_id,
            'cont_type' => ($parent_id>0)?2:1,
            'top_parent_id' => $top_parent_id,
            'order_id' => $order['id'],
            'product_id' => $data['product_id'],
            'stylist_id' => $order['seller_id'],
            'add_time' => floor(time() / 2) * 2,
            'user_id' => $user_id,
            'status' =>1,
            'score' => array_get($data, 'score', 5),
            'top' => 0,
            'good' => 0,
            'is_show' => array_get($data, 'is_show',1),
            'useful' => 0,
            'comment' => array_get($data, 'content', ''),
            'user_img' => array_get($user, 'avatar', ''),
            'user_name' => $user['nick'] ?: $user['user_name'],
            'user_ip' => request()->ip(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        /* if (array_only($data, ['images'], false)) {
            $cmt['images'] = $data['images'];
        } */
        
        $cmt['images'] = $data['images'];
        $obj = $cmt;
        $cri = ['user_id', 'add_time', 'product_id', 'order_id'];
        $conds = array_only($obj, $cri);
        $old = (empty($cri) || empty($conds)) ? false : Db::name('comment')->where($conds)->find();
        $res = $old ?: Db::name('comment')->insert($obj);
        
        
       // $res = Db::name('comment')->add($cmt, ['user_id', 'add_time', 'product_id', 'order_id']);
    
        $score_detail = array_get($data, 'score_detail', false);
        if ($score_detail && $res) {
            //评分细则
            $d_score = ['effect', 'time', 'service', 'health', 'brand'];
            $sum = 0;
    
            $score_detail = array_only($score_detail, $d_score);
            if (count($score_detail) != 5) {
                return json_error('请填写完整评分');
            }
    
            //todo limit score max
             foreach ($score_detail as $k => $v) {
                 $this->metadata('comment',$res['id'], $k, $v);
                
                $sum += intval($v);
            } 
    
            $score = $sum / 5;
    
            Db::name('comment')->where(['id' => $res['id']])->update(['id' => $res['id'], 'score' => $score]);
            $stylist_score = Db::name('comment')->where(['stylist_id' => $order['seller_id']])->field("sum(m2_comment.score) as count_score,count(m2_comment.id) as num")->select();
            if ($stylist_score) {
                $stylist_new_score = round($stylist_score[0]['count_score'] / $stylist_score[0]['num'], 1);
                Db::name('stylist_stats')->where(['id' => $order['seller_id']])->update(['id' => $order['seller_id'], 'score' => $stylist_new_score]);
            }
        }
    
        return json_ok($res);
    } else {
        return json_error('订单不存在');
    }
    }
    
    /**
     * @api {post} qiaomao/qm_order_detail 俏猫-订单详情[qiaomao/qm_order_detail
     * @apiVersion 2.0.0
     * @apiName qm_order_detail
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_detail
     *
     * @apiParam {int} order_id            订单id
     * @apiParam {String} order_sn            订单sn
     *
     */
    public function order_detail(){
        if(if_cookie()==true){
            $order_id = input('order_id')?input("order_id"):false;
            $order_sn = input('order_sn')?input("order_sn"):false;
           
            //$order_id = 7115;
            $user_id = user_info()['id'];
            if($order_id)
            {
                $sql = "select o.*,o.id,o.sn,o.buyer_id,o.seller_id,o.order_status,o.to_buyer,o.note,o.order_time,o.cancem_time,o.created_at,o.pay_time,mc.created_at as com_time,o.start_service_time,end_service_time,u.id as uid,u.mobile,u.nick,os.address,os.send_time,lp.name as lpname,lc.name as lcname,la.name as laname from m2_order as o left join m2_user as u ON o.buyer_id = u.id left join m2_order_shipping as os ON o.id = os.order_id left join m2_location_province as lp ON os.province = lp.province_id left join m2_location_city as lc ON os.city = lc.city_id left join m2_location_area as la ON os.district = la.area_id left join m2_comment as mc ON o.id = mc.order_id where o.id = '{$order_id}' and o.buyer_id ='{$user_id}' group by o.id";
                 
            }elseif ($order_sn)
            {
                $sql = "select o.*,o.id,o.sn,o.buyer_id,o.seller_id,o.order_status,o.to_buyer,o.note,o.order_time,o.cancem_time,o.created_at,o.pay_time,mc.created_at as com_time,o.start_service_time,end_service_time,u.id as uid,u.mobile,u.nick,os.address,os.send_time,lp.name as lpname,lc.name as lcname,la.name as laname from m2_order as o left join m2_user as u ON o.buyer_id = u.id left join m2_order_shipping as os ON o.id = os.order_id left join m2_location_province as lp ON os.province = lp.province_id left join m2_location_city as lc ON os.city = lc.city_id left join m2_location_area as la ON os.district = la.area_id left join m2_comment as mc ON o.id = mc.order_id where o.sn = '{$order_sn}'  and o.buyer_id ='{$user_id}' group by o.id";
                
            }else {
                return json_error('参数不能为空或错误');
            }
            $data = Db::query($sql);
            //根据订单id查询出该订单拥有的商品
            if(!$data)
            {
                return json_error('订单不存在',$data);
            }
            try {
                $order = $data[0];
                $sql2 = "select p.id,p.service_form,op.product_name,product_number,op.market_price,product_price,p.thumb,p.images from m2_order_product as op left join m2_product as p ON op.product_id = p.id where op.order_id = {$data[0]['id']}";
                
                $sql3 = "select id,nick,real_name,user_img,store_name,mobile from m2_stylist as st where st.id = {$data[0]['seller_id']}";
                
                
                $product_detail = Db::query($sql2);
                $data[0]['order_product'] = $product_detail;
                $data[0]['stylist'] = Db::query($sql3);
                $data[0]['comments_num'] = Db::name('comment')->where(['order_id' => $order['id'],'cont_type'=>['<>',3]])->count();
                
                $data[0]['comments'] = Db::name('comment')->where([
                    'order_id' => $order ['id'],
                    'is_show' => 1,
                    'cont_type'=>['<>',3]
                ])->select();
                
               $data[0]['contact'] = Db::name($this->tb_order_contact)
                ->where(['order_id' => $data[0]['id']])
                ->field([
                    'consignee',
                    'province',
                    'city',
                    'district',
                    'address',
                    'mobile',
                    'send_time',
                    'postscript'
                ])
                ->find();
                //dump($data);
                return json_ok($data);
            } catch (\Throwable $e) {
                return json_error('',$e);
            }
        }else {
            return json_nologin();
        }
    }
    
    /**
     * 顾客确认接受服务
     *
     * @param
     *            $order_id
     * @param
     *            $order_sn
     * @return array bool
     * @throws \Exception
     */
    /**
     * @api {post} qiaomao/qm_order_confirm_by_buyer 俏猫-顾客确认接受服务[qiaomao/qm_order_confirm_by_buyer
     * @apiVersion 2.0.0
     * @apiName qm_order_confirm_by_buyer
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_confirm_by_buyer
     *
     * @apiParam {int} order_id            订单id
     * @apiParam {String} order_sn            订单sn
     *
     */
    
    public function order_confirm_by_buyer() {
        $order_id = input('order_id')?input("order_id"):false;
        $order_sn = input('order_sn')?input("order_sn"):false;
        
        if (intval($order_id) || $order_sn) {
            $conds = $order_id ? [
                'id' => intval($order_id)
            ] : [
                'sn' => $order_sn
            ];
        
        $conds ['order_status'] = static::STATUS_SELLER_CONFIRM;
        if (!if_cookie()) {
            return json_nologin();
        }
        if ($order = Db::name($this->tb_order)->where($conds)->find()) {
            if ($order ['buyer_id'] == get_cookie()['id']) {
                $order ['order_status'] = static::STATUS_BUYER_CONFIRM;
                $order ['start_service_time'] = date('Y-m-d H:i:s');
                $order ['updated_at'] = date('Y-m-d H:i:s');
                
             
                    if (Db::name('order_status')->where(['id'=>$order['order_status']])->find()) {
                       
                        $return = Db::name($this->tb_order)->where(['id'=>$order['id']])->update(array_only($order, [
                            'id',
                            'order_status',
                            'updated_at',
                            'start_service_time',
                        ]));
                        return json_ok(array_only($order, [
                        'id',
                        'order_status',
                        'updated_at'
                    ]));
                    } else {
                        return json_error('设置状态有误');
                    }
                }
                
            } else {
                return json_error('订单状态不符');
            }
        } else {
            return json_error('订单不可确认');
        }
    }
    
    /**
     * 顾客确认服务完成，更改订单状态为服务完成，等待结算
     * @param bool $order_id
     * @param bool $order_sn
     * @return array
     */
    
    /**
     * @api {post} qiaomao/qm_order_product_finish_confirm 俏猫-顾客确认服务完成[qiaomao/qm_order_product_finish_confirm
     * @apiVersion 2.0.0
     * @apiName qm_order_product_finish_confirm
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_product_finish_confirm
     *
     * @apiParam {int} order_id            订单id
     * @apiParam {String} order_sn            订单sn
     *
     */
    
    public function order_product_finish_confirm() {
        
       $order_id = input('order_id')?input("order_id"):false;
       $order_sn = input('order_sn')?input("order_sn"):false;
        
       
        if (intval($order_id) || $order_sn) {
            $conds = $order_id ? [
                'id' => intval($order_id)
            ] : [
                'sn' => $order_sn
            ];
            
        } else {
            json_error('缺少订单信息');
        }
        $conds ['order_status'] = [
            'in',
            [
                static::STATUS_BUYER_CONFIRM,
                static::STATUS_SELLER_CONFIRM
            ]
        ];
        if (!if_cookie()) {
            return json_nologin();
        }
        $user_info = user_info();
        if ($order = Db::name($this->tb_order)->where($conds)->find()) {
            if ($order ['buyer_id'] == $user_info['id']) {
                $order ['order_status'] = static::STATUS_PRODUCT_FINISH;
                $order ['end_service_time'] = date('Y-m-d H:i:s');
                $order ['updated_at'] = date('Y-m-d H:i:s');
                
                
                //$res = $this->_toggle($order);
                if (Db::name('order_status')->where(['id'=>$order['order_status']])->find()) {
                     
                    $return = Db::name($this->tb_order)->where(['id'=>$order['id']])->update(array_only($order, [
                        'id',
                        'order_status',
                        'updated_at',
                        'end_service_time',
                    ]));
                    if ($order['order_type'] && $order['order_type'] == 8)//医美确认订单
                    {
                        $msg = "再次感谢小主选择俏猫医美，在您项目体验完成后请到俏猫APP平台确认服务完成，也欢迎您对本次体验服务进行评价。俏猫医美还会不断提供更多的超值体验项目，期待小主的下次宠幸。俏猫医美客服（微信同号）：18922408091。";
                        $mobile = $user_info['mobile'];
                        send_yun_text($mobile,$msg);
                    }
                    return json_ok(array_only($order, [
                        'id',
                        'order_status',
                        'updated_at'
                    ]));
                    
                } else {
                    return json_error('设置状态有误');
                }
                
               // $params = ['toggle' => &$res, 'order' => &$order];
               // tag('order.product.finish', $params);
               // return $res;
            } else {
                return json_error('缺少订单信息!');
            }
        } else {
            return json_error('订单不可确认');
        }
    }
    
    /**
     * 取消订单
     *
     * @param bool $order_id
     * @param bool $order_sn
     * @return array bool
     */
    
    /**
     * @api {post} qiaomao/qm_order_cancel 俏猫-顾客取消订单[qiaomao/qm_order_cancel
     * @apiVersion 2.0.0
     * @apiName qm_order_cancel
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_cancel
     *
     * @apiParam {int} order_id            订单id
     * @apiParam {String} order_sn         订单sn
     * @apiParam {String} type             取消类型如user
     * @apiParam {String} reason             取消原因
     *
     */
    public function order_cancel() {
        $order_id = input('order_id')?input("order_id"):false;
        $order_sn = input('order_sn')?input("order_sn"):false;
        $type = input('type')?input("type"):'';
        $reason = input('reason')?input("reason"):'';
        

       // $contact = $contact = D('order_shipping')->leftjoinon("location_province", "province_id", "province")->leftjoinon("location_city", "city_id", "city")->leftjoinon("location_area", "area_id", "area_id")->findByOne(['order_id' => $order_id], ["order_shipping.*", 'location_city.name as city_name', "location_area.name as area_name", "location_province.name as province_name"]);
       
    
        $product = Db::name('order_product')->where(['order_id' => $order_id])->find();
        $send_time = Db::name($this->tb_order_contact)->where(['order_id' => $order_id])->find()['send_time'];
       
        if (!if_cookie()) {
            return json_nologin();
        }
        
        $user_info = user_info();
        $conds = $this->one($order_id, $order_sn);
        if(!$conds)
        {
            return  json_error('缺少订单信息');
        }
        
        $conds ['order_status'] = [
            'in',
            [
                static::STATUS_CREATE,
                static::STATUS_PAID,
                static::STATUS_WAIT_SELLER_CONFIRM,
                static::STATUS_DISPATCH,
                static::STATUS_SELLER_CONFIRM
            ]
        ];
        if ($order = Db::name($this->tb_order)->where($conds)->find()) {
            $order_status = $order["order_status"];
          
                if ($order['buyer_id'] != $user_info['id'])
                {
                    return json_error('[' . $user_info['id'] . ']无权访问');
                }
    
           $order ['order_status'] = ($order['pay_status'] == 2 && $order['three_paid'] >0)? static::STATUS_CANCEL_CHARGE : static::STATUS_CANCEL;             
           $order['updated_at'] = date("Y-m-d H:i:s", time());
            $res = $this->_toggle($order);
            
            if($res)
            {
                // 优惠券返还
                $this->ReturnUserCoupon($order['sn']);
                
                // 余额返还
                $this->ReturnBalance($order['id']);
            }
    
        
            return json($res);
        } else {
            return json_error("无法取消订单[$order_id:$order_sn]");
        }
    }
    
    /**
     * 优惠券返还
     *
     * @param string $order_sn
     */
    private function ReturnUserCoupon($order_sn) {
        // 判断该订单是否有使用优惠券
        $user_coupon_cash = Db::name('user_coupon_cash')->where('order_sn', $order_sn)->select();
    
        if (!empty($user_coupon_cash)) {
            // 存在该订单使用的优惠券,将该优惠券返还
            // ->whereIn('id', array(1, 2, 3))->get();
            $id = [];
            foreach ($user_coupon_cash as $value) {
                if ($value ['status'] == 1) { // 优惠券必须是使用在该订单上
                    $id [] = $value ['id'];
                }
            }
            Db::name('log')->insert([
                'type' => '返券',
                'content' => '返还该优惠券,订单号为：' . $order_sn . '~~返还时间:' . date('Y-m-d H:i:s')
            ]);
            $where_ =['id'=>['in',$id]];
            Db::name('user_coupon_cash')->where($where_)->update([
                'status' => 0,
                'order_sn' => '',
                'order_amount' => 0,
                'discount_amount' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * 订单取消余额返还
     * @param bool|string $order_id 订单号的id
     */
    private function ReturnBalance($order_id) {
    
        //获取该订单的余额支付流水记录
        $balance = Db::name('order_pay_history')->where(['order_id' => $order_id,
            'pay_type' => 'BALANCE',
            'status' => 1])->select();
    
        if (!empty($balance)) {
    
            //返还余额
            foreach ($balance as $value) {
                //验证用户的有效性
                $user = Db::name('user')->where('id', $value['user_id'])->find();
    
                if (!empty($user)) {
    
                    Db::name('log')->insert([
                        'type' => 'BALANCE',
                        'content' => '返还该余额,订单号为：' . $value['order_sn'] . '~~流水id:' . $value['id'] . '~~返还余额：' . $value['money_paid'] . '～～返还前余额为' . $user['balance'] . '返还时间:' . date('Y-m-d H:i:s')
                    ]);
                    //返还余额
                    $this->balance_in($value['user_id'], $value['money_paid'], '取消订单[' . $value['order_sn'] . ']返还', $value['order_sn']);
                }
            }
        }
    }
    
    /**
     * internal used
     * @param $uid
     * @param $amount
     * @param $note
     * @param bool $sn
     * @return array|bool
     */
    private function balance_in($uid, $amount, $note, $sn = false)
    {
        $latest_balance =Db::name('user_balance')->where(['user_id' => $uid])->sum('amount');
        $lb = $latest_balance + abs($amount);
        if ($lb < 0)
        {
            return false;
        }
    
        Db::name('user')->where(['id'=>$uid])->update([
            'id' => $uid,
            'balance' => $lb
        ]);
    
        return Db::name('user_balance')->insertGetId([
            'user_id' => $uid,
            'in_out' => 0,
            'amount' => $amount,
            'latest_balance' => $lb,
            'note' => $note,
            'sn' => $sn ?: date('YmdHis') . rand(10000, 99999),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * @api {post} qiaomao/qm_order_cancel_delect 俏猫-顾客取消后删除订单[qiaomao/qm_order_cancel_delect
     * @apiVersion 2.0.0
     * @apiName qm_order_cancel_delect
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_cancel_delect
     *
     * @apiParam {int} order_id            订单id
     * @apiParam {String} order_sn         订单sn    
     *
     */
    public function order_cancel_delect() {
        
        $order_id = input('order_id')?input("order_id"):false;
        $order_sn = input('order_sn')?input("order_sn"):false;
        if (!if_cookie()) {
            return json_nologin();
        }
        $user_info = user_info();
        $conds = $this->one($order_id, $order_sn);
        if(!$conds)
        {
            return  json_error('缺少订单信息');
        }
        
        $conds ['order_status'] = [
            'in',
            [
             static::STATUS_CANCEL
            ]
        ];
        
        if ($order = Db::name($this->tb_order)->where($conds)->find()) {
            $order_status = $order["order_status"];
        
            if ($order['buyer_id'] != $user_info['id'])
            {
                return json_error('[' . $user_info['id'] . ']无权访问');
            }
        
            $date = date("Y-m-d H:i:s", time());         
            $order['updated_at'] = $date;
            $order['deleted_time'] = $date;
            
            $return = Db::name($this->tb_order)->where(['id'=>$order['id']])->update(array_only($order, [
                'id',
                'deleted_time',
                'updated_at'
            ]));
            $return = ['status'=>'ok','msg'=>'','data'=>array_only($order, [
                'id',
                'order_status',
                'deleted_time'
            ])];
            
        
        
            return json($return);
        } else {
            return json_error("无法删除订单[$order_id:$order_sn]");
        }
        
      
        
    }
    
    /**
     * 帮助函数
     *
     * @param
     *            $order_id
     * @param
     *            $order_sn
     * @return array
     */
    private function one($order_id, $order_sn) {
        if (intval($order_id) || $order_sn) {
            $order = $order_id ? [
                'id' => intval($order_id)
            ] : [
                'sn' => $order_sn
            ];
            return $order;
        } else {
           return false;
        }
    }
    public function status($id) {
        return Db::name($this->tb_order_status)->where(['id'=>$id])->find();
    }
    /**
     * 改变订单状态, internal used
     *
     * @param array $order
     *            ['id', 'order_status']
     * @return array bool
     * @throws \Exception
     */
    protected function _toggle($order) {
        if ($status = $this->status($order ['order_status'])) {
            
            $return = Db::name($this->tb_order)->where(['id'=>$order['id']])->update(array_only($order, [
                'id',
                'order_status',
                'updated_at'
            ]));
            return ['status'=>'ok','msg'=>'','data'=>array_only($order, [
                'id',
                'order_status',
                'updated_at'
            ])];
        } else {
            return ['status'=>'error','msg'=>'设置状态有误','data'=>''];
        }
    }
    
    /**
     * find user's order
     *
     * @param bool $start_time
     * @param bool $end_time
     * @param bool $status
     * @param bool $is_seller
     * @param int $page
     * @param int $page_size
     * @param string $order_by
     * @param string $order_rule
     * @param string $action
     * @param string $sum
     * @return array
     *  |     1 | 订单已经支付成功，等待审核                                   | 支付成功，等待系统审核                  | 支付订单                      | 已支付        |                |
     * |   200 | 客户提交了货到付款订单,等待审核                              | 订单提交成功，等待系统审核              | 下[货到付款类型]订单          | 待审核        |                |
     * |   201 | 货到付款订单审核已经通过，等待服务商确认                     | 等待商家确认                            | 等待商家确认                  | 指派服务      |                |
     * |   202 | 商家指派完成,等待商家确认                                    | 等待商家确认                            | 等待商家确认                  | 待审核        |                |
     * |   300 | 商家完成确认                                                 | 商家已确认，等待上门                    | 客服审核通过                  | 上门          |                |
     * |   301 | 客户确认服务                                                 | 服务中                                  | 正在服务                      | 正在服务      |                |
     * |  1000 | 订单完成，等待结算                                           | 完成订单                                | 服务完毕                      | 服务完毕      |                |
     * |  1200 | 完成结算                                                     | 完成订单                                | 结算                          | 结算          |                |
     */
    
    /**
     * @api {post} qiaomao/qm_order_find 俏猫-订单查询[qiaomao/qm_order_find]
     * @apiVersion 2.0.0
     * @apiName qm_order_find
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_find
     *
     * @apiParam {Int} page page
     * @apiParam {Int} page_size page_size
     * @apiParam {Int} status 订单状态 多个‘,’隔开
     * @apiParam {Int} comment_status 评论状态
     * 
     *
     */
    public function order_find() {
        $start_time = (input("start_time")) ?input("start_time"):false;
        $end_time = (input("end_time")) ?input("end_time"):false;
        $status = (input("status")) ?input("status"):((input("status")==='0')?0:'');
        $comment_status = (input("comment_status")) ?input("comment_status"):false;
        $is_seller = (input("is_seller")) ?input("is_seller"):false;
        $page = (input("page")) ?input("page"):1;
        $page_size = (input("page_size")) ?input("page_size"):10;
        $order_by = (input("order_by")) ?input("order_by"):'created_at';
        $order_rule = (input("order_rule")) ?input("order_rule"):'desc';
        $action = (input("action")) ?input("action"):'find';
        $sum = (input("sum")) ?input("sum"):'abc';
        $server_start_time = (input("server_start_time")) ?input("server_start_time"):false;
        $server_end_time = (input("server_end_time")) ?input("server_end_time"):false;
        
        
        
       
        static $users = [];
        $comment_order = [];
    
        if ($uid = (get_cookie()['id'])) {
            
             $users[$uid] = user_info();
         
            if ($status != '') {
                $status = explode(',', $status);
                $conds ['order_status'] = count($status) > 1 ? [
                    'in',
                    $status
                ] : head($status);
            }
            //未支付订单
    
            if (isset($status)) {
                if($status===0){
                    $conds ['order_status'] = 0;
                   
                }
            }
            // --end
    
            $conds ['created_at'] = [
                'between',
                [
                    $start_time ? : '1970-01-01 00:00:00',
                    $end_time ? : date('Y-m-d H:i:s')
                ]
            ];
            $conds [($is_seller ? 'seller_id' : 'buyer_id')] = $uid;
            if ($is_seller) {
                //$conds['pay_status'] = 2;
                $conds['order_status'] = $status == '' ? ['in', [
                    static::STATUS_PAID,
                    static::STATUS_SYS_CONFIRM,
                    static::STATUS_DISPATCH,
                    static::STATUS_WAIT_SELLER_CONFIRM,
                    static::STATUS_SELLER_CONFIRM,
                    static::STATUS_BUYER_CONFIRM,
                    static::STATUS_PRODUCT_FINISH,
                    static::STATUS_FINISH,
                    static::STATUS_BUYER_CONFIRM,
                    static::STATUS_CANCEL_CHARGE,
                    static::STATUS_CLOSE
                ]] : $conds['order_status'];
            }
            
           
            
           $conds['deleted_time'] = ['exp',"is null or `deleted_time` ='0000-00-00 00:00:00'"];
            
            switch ($action) {
                case 'find' :
                    $query = Db::name($this->tb_order)->alias('o')->page($page, $page_size);
                    if ($server_start_time || $server_end_time) {
                        $conds [$this->tb_order_contact . '.send_time'] = [
                            'between',
                            [
                                $server_start_time ? : '1970-01-01 00:00:00',
                                ///$server_end_time ?: date('Y-m-d H:i:s')
                                $server_end_time ? : '2099-01-01 00:00:00'
                            ]
                        ];
                        $query = $query->join("$this->tb_order_contact c", 'c.order_id=o.id','LEFT');
                    }
    
                    $orders = $query->order([
                        $order_by => $order_rule
                    ])->where($conds)->field([
                        'o.deleted_time',
                        'o.service_form',
                        'o.id',
                        'sn',
                        'buyer_id',
                        'seller_id',
                        'pay_status',
                        'pay_type',
                        'order_status',
                        'shipping_status',
                        'created_at',
                        'updated_at',
                        'confirm_time',
                        'pay_time',
                        'order_amount',
                        'need_to_pay',
                        'already_paid',
                        'coupon_paid',
                        'balance_paid',
                        'three_paid',
                        'to_buyer',
                        'order_type',
                        'shipping_fee',
                    ])//->fetchSql(true)
                    ->select();
                    
                   // return json($orders);
                    
                    
                    
    
                    foreach ($orders as &$order) {
                        //评论详情
                        $order['comments_num'] = Db::name('comment')->where(['order_id' => $order['id'],'cont_type'=>['<>',3]])->count();
                       
                        //过滤造型师不该显示的订单
                        $order ['buyer'] = array_get($users, $order ['buyer_id'], Db::name($this->tb_user)->where(['id'=>$order ['buyer_id']])->field([
                            'id',
                            'user_name',
                            'real_name',
                            'nick',
                            'mobile',
                            'avatar'
                        ])->find());
                     //   var_dump($order ['buyer']); exit();
                        $order ['seller'] = $order ['seller_id'] > 0 ? Db::name($this->tb_stylist)->where(['id'=>$order ['seller_id']])->field([
                            'id',
                            'type',
                            'real_name',
                            'mobile',
                            'user_img',
                            'level',
                            'store_name'
                        ])->find() : [];
                        
                        if($order ['seller'] === null)
                        {
                            $order ['seller'] =[];
                        }
                        
                        $order ['products'] = Db::name($this->tb_order_product)->alias('op')->join("$this->tb_product p", 'p.id=op.product_id','LEFT')
                        ->where(['order_id' => $order ['id']])
                        ->field(['*', 'p.images','p.cate_id','p.duration'])
                        ->select();
                        
                        if(!empty($order ['products']))
                        {
                            foreach ($order ['products'] as &$prod_) {
                            
                                if (isset($prod_['thumb']) && !empty($prod_['thumb'])) {
                                    $prod_['thumb'] = $this->url($prod_['thumb']);
                                }
                            }
                               
                        }
                            
                        
                        $order ['contact'] = Db::name($this->tb_order_contact)
                        ->where(['order_id' => $order ['id']])
                        ->field([
                            'consignee',
                            'province',
                            'city',
                            'district',
                            'address',
                            'mobile',
                            'send_time',
                            'postscript'
                        ])
                        ->find() ? : [];
    
                        if ($comment_status) {
                            if ($order['comments_num'] == 0  || $order['comments_num'] == 1) {
                                $comment_order[] = $order;
                            }
                        }
                    }
                   // $orders['row'] = Db::name($this->tb_order)->where($conds)->count();
    
                    $orders = $comment_status ? $comment_order : $orders;
                  
                   $date['count'] = Db::name($this->tb_order)->where($conds)->count();
                   
                   $date['page'] = $page;
                   $date['page_size'] = $page_size;
                   $date['result'] = $orders;
                   
                  
                    return json_ok($date);
                case 'row' :
                   
                    $return  = array(
                    'rows' => Db::name($this->tb_order)->where($conds)->count(),
                    'query' => $conds
                    );
                    return json_ok($return);
                case 'sum' :
                    
                   
                   $return  = in_array($sum, [
                    'need_to_pay',
                    'already_paid',
                    'order_amount',
                    'three_paid'
                        ]) ? array(
                        'sum' => Db::name($this->tb_order)->where($conds)->sum($sum),
                        'query' => $conds
                        ) : false;
                        
                        if(!$return)
                        {
                           return  json_error('不支持统计: ' . $sum);
                        }
                       
                        
                        return json_ok($return);
                default :
                    return json_error('不支持参数: ' . $action);
            }
        } else {
            return json_nologin();
        }
    }
    
    /**
     * @api {post} qiaomao/qm_order_calculate 俏猫-购物车验证接口[qiaomao/qm_order_calculate]
     * @apiVersion 2.0.0
     * @apiName qm_order_calculate
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_calculate
     *
     * @apiParam {Array} data data数据: {"items":[{"id":"1000370","number":"1"}],"service_form":1,"use_balance":false,"contact":{"consignee":"测试","address":"广州市 海珠区 测试","mobile":"15017580819","send_time":"2017-07-13 22:35:00","province_id":"440000","city_id":"440100","district_id":"440105","postscript":"测试"},"coupon_sn":"","stylist_id":null,"from_ad":"m站"}
     *
     */
    
    public function order_calculate()
    {
        $data = input();
        $data = isset($data['data'])?$data['data']:$data;
        if(!is_array($data))
        {
            $data = json_decode($data,true);
        }
        
        if(!if_cookie())
        {
            return json_nologin();
        }
        $self = $this;
        $items = array_get($data, 'items',[]);
    
        if (empty($items))
        {
            return json_error('购物车为空，无法提交');
        }
        else
        {
            $data['items'] = $items;
            $data['fake'] = true;
            $data = array_add($data, 'contact', [
                'consignee' => '-',
                'address' => '-',
                'mobile' => '15918658642',
                'send_time' => date('Y-m-d H:i:s', time() + 7200)
            ]);
            return $this->order_create($data);
        }
    }
    
    
    /**
     * @api {post} qiaomao/qm_order_create 俏猫-下单接口[qiaomao/qm_order_create]
     * @apiVersion 2.0.0
     * @apiName qm_order_create
     * @apiGroup qiaomao_Order
     * @apiSampleRequest qiaomao/qm_order_create
     *
     * @apiParam {String} data data数据: {"items":[{"id":"1000370","number":"1"}],"service_form":1,"use_balance":false,"contact":{"consignee":"测试","address":"广州市 海珠区 测试","mobile":"15017580819","send_time":"2017-07-13 22:35:00","province_id":"440000","city_id":"440100","district_id":"440105","postscript":"测试"},"coupon_sn":"","stylist_id":null,"from_ad":"m站"}
     *    
     */
    public function order_create($data_=[]) {
        
        $data = input();
        $data = isset($data['data'])?$data['data']:$data;
        
        
        if(is_array($data_) && !empty($data_) ){
            $data =$data_;
       
        }else {
            $data = json_decode($data,true);
        }
        
        
        
        //return json($data);
        if(empty($data))
        {
             $return = [
                'status' => 'error',
                'msg' => '参数不能为空',
                'data' => $data,
            ];
            return json($return);
        }
        if (if_cookie()) {
            //美睫指定城市
            $m_city = ['0', '110100', '310100', '440100', '330100', '510100',
                '230100', '440400', '120100',
                '500100', '520100', '440300', '441900', '442000', '420100', '530100',
                '320200', '440600', '210200', '210100', '610100', '410100', '130100',
                '370100', '370200', '220100', '440700', '320500'
            ];
            // 纹绣指定城市
            $w_city = ['440100'];
    
            //众筹产品
            $zc_pro = [1000153, 1000154, 1000155, 1000156, 1000157];
            
            $user_id = get_cookie()['id'];
            $conds["id"]= ["=" , $user_id];
            $user =Db::name('user')->where($conds)->find();
            
    
            //$user = $this->user();
            $calculator = new Calculator ();
            
            $items = array_get($data, 'items', []);
            $seller_id = array_get($data, 'stylist_id', false);
            $stylist_ser = Db::name($this->tb_stylist_service)->where(['stylist_id' => $seller_id])->field(['product_id'])->find();
            
            $pids = explode(',', $stylist_ser['product_id']);
            $pay_type = strtoupper(array_get($data, 'pay_type', 'ALIPAY'));
            $service_form = array_get($data, 'service_form', 1);
            //            $pay_type = $pay_type == 'WECHAT' ? 'WECHAT' : 'ALIPAY';
    
            if ($pay_type == "WECHAT") {
                $pay_type = "WECHAT";
            } elseif ($pay_type == "ALIPAY") {
                $pay_type = "ALIPAY";
            } elseif ($pay_type == "CMB") {
                $pay_type = "CMB";
            } elseif ($pay_type == "JD") {
                $pay_type = "JD";
            }
    
            //兼容m2_stylist_product
            $stylist_product = Db::name($this->tb_stylist_product)->where([
                'stylist_id' => $seller_id,
                'status' => 1,
                'action' => 1
            ])->select();
            
           
    
            $pidss = [];
            if ($stylist_product) {
                foreach ($stylist_product as $v) {
                    $pidss[] = $v['product_id'];
                }
            }
    
            if ($seller_id && !Db::name($this->tb_stylist)->where([
                'id' => $seller_id
            ])->find()
                ) {
                    return json_error('指派商家并不存在');
                }
    
               
                
                foreach ($items as $i => $item) {
                    //众筹产品限制
                    if (in_array($item['id'], $zc_pro)) {
                        //不能使用优惠券
                        if ($data['coupon_sn']) {
                            return json_error('众筹产品不能使用优惠券');
                        }
                    }
    
                    $pid = $item ['id'];
                    $item ['number'] = intval($item ['number']);
                    $prod = intval($pid) ? Db::name('product')->where(['id'=>$pid])->find() : false;
                    if (isset($data['from_ad']) && $data['from_ad'] == 'yx') {
                        $prod = intval($pid) ? Db::name('ms_product')->where(['id'=>$pid])->find() : false;
                    }
                    //var_dump($prod);die;
                    if ($seller_id && (!$stylist_ser || !in_array($pid, $pids)) && (!$stylist_product || !in_array($pid, $pidss))) {
                        ///return $this->_error('化妆师不支持该服务');
                    }
                    if ($prod) {
                        $item ['product'] = $prod;
                    } else {
                        unset($items [$i]);
                    }
                    $items[$i] = $item;
    
                    //秒杀产品判断
                    if ($prod['type'] == 1024) {
                        //活动开始时间
                        $m = intval(date('i'));
                        if ($m > 2) {
                            return json_error('秒杀已结束');
                        }
    
                        //不能使用优惠券
                        if ($data['coupon_sn']) {
                            return json_error('秒杀产品不能使用优惠券');
                        }
                    }
                }
                if (empty($items)) {
                    return json_error('没有购买任何产品，无法创建订单');
                }
    
                $order = [
                    'sn' => date('YmdHis') . rand(1000, 9999),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'buyer_id' => $user_id,
                    'pay_type' => $pay_type,
                    'service_form' =>$service_form,
                    'order_status' => 0,
                    'seller_id' => $seller_id ? : 0,
                    'from_ad' => array_get($data, 'from_ad', ''),
                    'shipping_fee' => 0.0,
                    'order_type' => ($items[0]['product']['cate_id']==2048)?8:$items[0]['product']['type'],
                    'share_user_id' => isset($data['share_user_id']) ? $this->getParentidByAlias($data['share_user_id']) : 0 //添加分享用户id
                ];
                
                
                // order_amount, product_amount, need_to_pay
                $res = $calculator->calculate($data ['items']);
                
               
    
                /* 如果是从专题halloween的订单打折 */
                if ($order['from_ad'] == "#topic_halloween") {
                    $res = $calculator->topic_cart_calculate($data ['items'], "halloween", $data['money'], $data['money_after']);
                }
                if ($order['from_ad'] == "#topic-annualMeeting") {
                    $res = $calculator->topic_cart_calculate($data ['items'], "annualMeeting");
                } /* 如果是从专题halloween的订单打折结束 */
                /*年会bd_0710_satrt*/
                /*  if ($order['from_ad'] == "年会bd3") {
                 $topicOrder = new \Api\Model\Order\TopicOrder();
                 $topicOrder->TopicReg($data['contact']['mobile'], "annualMakeup", "年会bd");
                 }
                 if ($order['from_ad'] == "年会bd2") {
                 $topicOrder = new \Api\Model\Order\TopicOrder();
                 $topicOrder->TopicReg($data['contact']['address'], "annualMakeup", "年会bd");
                 } */
                /*年会bd_end_0710*/
                
                //38妇女节专题
                if ($order['from_ad'] == "38妇女节") {
                    $res = $calculator->topic_cart_calculate($data ['items'], "queensday");
                }
                //艺星
                if ($order['from_ad'] == "yx") {
                    $prod = Db::name('ms_product')->where(['id' => $data ['items'][0]['id']])->field(['id', 'down_payment'])->find();
                    $res = [
                        'number' => 1,
                        'total' => $prod['down_payment']
                    ];
                    // $res = $calculator->topic_cart_calculate($data ['items'], "yx");
                }
                $order ['order_amount'] = $res['total'];
                $order ['product_amount'] = $res['total'];
                $order ['need_to_pay'] = $res['total'];
                $order ['already_paid'] = 0;
                $order ['coupon_paid'] = 0;
    
                $contact = $data ['contact'];
                if (!preg_match("/1[0123456789]{10}$/", $contact['mobile'])) {
                    return json_error('手机号格式错误！');
                }
                if(!isset($contact['area_id']) && isset($contact['district_id']))
                {
                    $contact['area_id'] = $contact['district_id'];
                }
                $contact = [
                    'order_id' => '',
                    'order_sn' => '',
                    'consignee' => array_get($contact, 'consignee', array_get($user, 'real_name', false)),
                    'mobile' => array_get($contact, 'mobile', $user['mobile']),
                    'buyer_id' => $user_id,
                    'province' => array_get($contact, 'province_id', 0),
                    'city' => array_get($contact, 'city_id', 0),
                    'district' => array_get($contact, 'area_id', 0),
                    'street' => isset($contact['street_id']) ? $contact['street_id'] : 0,
                    'address' => array_get($contact, 'address', ''),
                    'send_time' => $contact ['send_time'],
                    'postscript' => array_get($contact, 'postscript', ''),
                ];
                if (empty($contact['consignee']) && empty($contact['address'])) {
                    return json_error('缺少下单人信息');
                }
    
                /**
                 * 凌晨不允许下单
                 */
                $hour = date('H', strtotime($contact['send_time']));
                
                ///  170419 接口去掉服务时间限制
                /* if ($hour > 22 || $hour < 9) {
                 ////return json_error('三更半夜小心有怪蜀黍出没，请选择6:00-22:00时间内下单哦！');
                 ////return json_error('超出可预约服务时间9:00-22:00,请联系客服帮您解决');
                 } */
    
             
    
                /**
                 * 检查造型师从send_time往后四个小时是否有空
                 */
                $order_send_time_start = $contact['send_time'];
                $order_send_time_end = date('Y-m-d H:i:s', strtotime($contact['send_time']) + 3600 * 4);
    
                $busy_time = (new Stylist())->getTime($seller_id, $order_send_time_start, $order_send_time_end, 2);
    
                $busy_time_new = (new Stylist())->getTimeNew($seller_id, $order_send_time_start, $order_send_time_end, 2);
    
                ///print_r($seller_id .  " 88899") ;
                ///die() ;
                if (!empty($busy_time['data']) || !empty($busy_time_new['data'])) {
                    if ($seller_id && !in_array($seller_id, array('324251793', '324249662'))) {
                        
                        
                    }
                }
    
                if (strtotime($contact ['send_time']) < time() + 3 * 3600) {
                    return json_error('请预约' . date("Y-m-d H:i", time() + 3 * 3660) . '之后的时间');
                }
    
                /**
                 * 检查产品是否可售卖
                 */
                foreach ($items as $item) {
                    $prod = $item['product'];
    
                    if ($prod['type'] == 64) {
                        if (!in_array($contact['city'], $m_city)) {
                            return json_error('您所在城市尚未开通美睫服务');
                        }
                    } elseif ($prod['type'] == 128) {
                        if (!in_array($contact['city'], $w_city)) {
                            return json_error('您所在城市尚未开通纹绣服务');
                        }
                    }
    
                    //年会产品ID
                    $pids = [1000133, 1000134, 1000135, 1000136];
    
                    if ($prod['online'] < 1 && !in_array($prod['id'], $pids)) {
                       
                    }
                }
    
                $tag_params = [
                    'order' => &$order,
                    'buyer' => &$user,
                    'user' => &$user,
                    'contact' => &$contact,
                    'items' => &$items,
                    'data' => $data
                ];
    
                $products = array();
                foreach ($items as $item) {
                    $prod = $item ['product'];
                    $products[] = [
                        'cate_id'=>$item['product']['cate_id'],
                        'cate_id_2'=>$item['product']['cate_id_2'],//@6/19
                        'type' => $prod['type'],
                        'relation' => isset($data['from_ad']) && $data['from_ad'] == 'yx' ? '' : $prod['relation'],
                        'order_id' => 0,
                        'order_sn' => '',
                        'buyer_id' => $user_id,
                        'seller_id' => $order ['seller_id'],
                        'product_id' => $prod ['id'],
                        'product_name' => $prod ['name'],
                        'product_sn' => $prod ['sn'],
                        'product_number' => $item ['number'],
                        'product_summary' => isset($data['from_ad']) && $data['from_ad'] == 'yx' ? '' : '',//$prod['summary'],
                        'discount' => 100,
                        'market_price' => $prod ['market_price'],
                        'b2c_price' => $prod ['price'],
                        'product_price' => $prod ['price'],
                        'product_attr' => isset($data['from_ad']) && $data['from_ad'] == 'yx' ? json_encode(['type' => $data['type'], 'format' => $data['format'], 'city' => $data['city']]) : json_encode($this->metadata($this->tb_product,$prod['id'])),
                        'parent_id' => 0,
                        'comment_id' => 0
                    ];
                }
                if (array_get($data, 'fake', false)) {
                    $order['products'] = $products;
                    $order['items'] = $items;
                    try {
                        //tag('order.submit.fake', $tag_params);
                        //order_product
                        $order_submit_fake = new UseCouponBehavior();
                        $res_= $order_submit_fake->fake_submit($tag_params);
                        if($res_ && isset($res_['status']) && $res_['status']=='error')
                        {
                            return json($res_);
                        }
                        
                        
                    } catch (\Exception $e) {
                        return json_error($e->getMessage());
                    }
    
                    return $tag_params;
                }
                $this->OrderNoticeForService($order['sn']);
               // $this->_beginTransaction();
                // 启动事务
                
                Db::startTrans();
                
                try {
                    
                   // tag('order.submit.before', $tag_params);
                    
                   
                   
    
                    $order_ = Db::name($this->tb_order)->insert($order);
                    $order_id= Db::name($this->tb_order)->getLastInsID();
                    
                    $order = Db::name($this->tb_order)->where(['id'=>$order_id])->find();
                    //$order =[];
                    
                    $order['items'] = $items;
                   
                   
                    foreach ($products as $index => $product) {
                        $product['order_id'] = $order['id'];
                        $product['order_sn'] = $order['sn'];
                        Db::name($this->tb_order_product)->insert($product);
                        $pid_ = Db::name($this->tb_order_product)->getLastInsID();
                        
                        $order ['products'][$index] = Db::name($this->tb_order_product)->where(['id'=>$pid_])->find();
                       
                    }
                    
                   
                    //代表有余额支付
                    $contact_ = $contact;
                    $contact_ ['order_id'] = $order ['id'];
                    $contact_ ['order_sn'] = $order ['sn'];
                    $contact = Db::name($this->tb_order_contact)->insert($contact_);
                    $contact_id= Db::name($this->tb_order_contact)->getLastInsID();
                    
                    $contact = Db::name($this->tb_order_contact)->where(['id'=>$contact_id])->find();
                    
                    $order ['contact'] = $contact;
                    
                    //order_product
                    $order_submit_after = new UseCouponBehavior();
                    $res_ = $order_submit_after->after_submit($tag_params);
                    if($res_ && isset($res_['status']) && $res_['status']=='error')
                    {
                        // 回滚事务 为不影响下单先注释后期考虑
                        Db::rollback();
                        return json($res_); 
                    }
                    
    
                    //tag('order.submit.after', $tag_params);
                    $user_nums = Db::name('user')->where(['id' => $user_id])->field(['order_nums'])->find();
                    $new_order_nums = $user_nums['order_nums'] + 1;
                    Db::name('user')->update(['id' => $user_id, 'order_nums' => $new_order_nums]);
                    
                    if(if_cookie())
                    {
                        $user_info = user_info();
                        $this->postDataAnalysis(4, '创建定单|' . $order["sn"], $_SERVER['REQUEST_URI'], $user_info["id"], $user_info["mobile"], 0, date("Y-m-d H:i:s"), isset($order['from_ad']) ? $order['from_ad'] : '', $user_info['last_login_ip']); ////提交数据分析数据
                    }
                    // 提交事务
                    Db::commit();
                    
                    Log::record('jg_seller_id_S'.$seller_id);
                    $seller_id = array_get($data, 'stylist_id', false);
                    if($seller_id && $seller_id > 0)
                    {
                        /*  $PHPJpush =  new \app\common\method\PHPJpush();
                         $PHPJpush->sendNotifySpecial($userid,$message); */
                       /*  Log::record('Jg_seller_id_OK'.$seller_id);
                        
                        $userid = $seller_id;
                        $message ="您有新订单了哦，亲亲，请尽快接单吧!"; 
                       
                        $PHPJpush =controller('common/PHPJpush','method')->sendNotifySpecial($userid,$message);
                        Log::record('Jg_seller_id_return'.json_encode($PHPJpush)); */
                    }
                    //如果指定美业师推送极光消息
                    
                    return  json_ok($order);
                   
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    
                  
                    return json_error('Exception',$e);
                }
        } else {
            return json_nologin();
        }
        
    }
    
    
    
   
       protected function getParentidByAlias($alias = '')
        {
            ///  根据推广链接码,取得父级用户ＩＤ　　
            if ($alias) {
                $row =Db::query(" select  id  from  m2_user where  md5(id) =  '$alias'  ");
            }
            ////print_r($row);
            return isset($row[0]["id"]) ? $row[0]["id"] : '';
        }
        
        /*     * 订单通知客服
         * @param $sn
         * @return array
         */
        
        protected function OrderNoticeForService($sn) {
            $info['id'] = get_cookie()['id'];
            ///  通知客服
            $msg["title"] = "用户$info[id]有一个新的订单待你处理,单号为:$sn.";
            $msg["content"] = "用户$info[id]有一个新的订单待你处理，请及时处理,单号为:$sn.";
            $msg["created_at"] = date("Y-m-d H:i:s");
            $msg['status'] = 1;
            $msg["href"] = "/admin/order/info?sn=$sn";
            Db::name("service_message")->insert($msg);
        }
        
        /**
         * Get/update all the meta data of the object
         * @param int|string $iid object id
         * @param bool|array $data
         * @return array
         */
        protected function metadata($table,$iid, $data = false)
        {
            $meta_op = Db::name($table . '_meta');
            if (!empty($data))
            {
        
                $data = empty($this->meta_sets) ? $data : array_only($data, $this->meta_sets);
                foreach ($data as $k => $v)
                {
                    $this->meta($iid, $k, $v);
                }
            }
            $data = $meta_op->where(['iid' => $iid])->select();
            $meta = [];
            foreach ($data as $kv)
            {
                $kv['value'] = json_decode($kv['value'], true);
                if (isset($meta[$kv['key']]))
                {
                    $meta[$kv['key']] = (array)$meta[$meta[$kv['key']]];
                    array_push($meta[$kv['key']], $kv['value']);
                }
                else
                {
                    $meta[$kv['key']] = $kv['value'];
                }
            }
            return $meta;
        }
        
        /**
         * 活动对应得meta值，例如order，则会从表order_meta中读取或者设置meta值
         * @param string $iid
         * @param bool|string $key
         * @param mixed $val
         * @return mixed
         */
        protected function meta($table,$iid, $key, $val = null)
        {
            $iid = is_array($iid) ? $iid['id'] : $iid;
            $meta_op = Db::name($table . '_meta');
            $obj = [$this->mkey => $iid];
            if (!$key)
            {
                return $this->metadata($iid, $val);
            }
            else
            {
                $obj = array_add($obj, 'key', $key);
            }
        
            if ($val === null)
            {
                $one = $meta_op->where($obj)->findByOne(['value']);
            }
            else
            {
                $val = json_encode($val);
                
                
                
                $one = $this->upsertBy($table . '_meta',array_add($obj, 'value', $val), ['iid', 'key']);
            }
        
            return $one ? json_decode($one['value'], true) : false;
        }
        
        /**
         * 更新记录，若不存在则插入新记录
         * @param array $obj 条件只能包含等于的判断，不支持比较操作符号
         * @param array $cri 作为约束的字段, 如: ['order_id', 'created_at']
         * @param bool $insert 如果不存在是否创建新对象
         * @return array|bool 成功返回$obj，失败返回false
         */
        public function upsertBy($table,array $obj, array $cri, $insert = true)
        {
            $conds = array_only($obj, $cri);
            $old = Db::name($table)->where($conds)->field(['id'])->find();
            if ($old)
            { //exist, so just update
                $obj['id'] = $old['id'];
                $obj = Db::name($table)->where(['id'=>$obj['id']])->update($obj);
            }
            else
            {
                if ($insert)
                {
                    return Db::name($table)->insert($obj);
                }
            }
            return $obj;
        }
        
        protected function postDataAnalysis($type = '1', $note = 'test', $action = 'test', $user_id = '', $mobile = '', $residence_time = '', $date_added = '', $ad_source = '', $last_login_ip = '', $data_ext = '')
        {
        
            ///  保存数据分析基础数据
            $dev = 0;  //  是否调试模式
            if ($user_id && $dev == 0) {
                $row = Db::name("data_analysis")->order(["id" => 'desc'])->where("type", ">", 1) ->where(["user_id" => $user_id])
                ->field(["id", 'date_added'])->find();
                ///print_r($row);
                if (isset($row["id"]) && isset($row['date_added']) && $row['date_added']) {
                    $residence_time = time() - strtotime($row['date_added']);
                    Db::query(" update m2_data_analysis    set   residence_time= '$residence_time'  where id ='$row[id]'  ");
                }
                return Db::query("  insert into  m2_data_analysis set   `type`='$type' ,  note='$note' ,  action='$action' ,    user_id ='$user_id' , mobile='$mobile' , residence_time='$residence_time' ,   date_added=now() ,  ad_source='$ad_source', last_login_ip='$last_login_ip', data_ext='$data_ext'    ");
            }
        }
        
        protected function url($url)
        {
        
            return starts_with($url, 'http://') ? $url : config('image.urlinfo') . '/upload' . $url;
        }
        
        
   
    
   
   
}