<?php


namespace app\qiaomao\model;
use think\Model;
use think\Db;



class UseCouponBehavior extends Model {
  

    
    
    /**
     * @param $params
     * @return bool
     */
    public function fake_submit(&$params)
    {
        $res = $this->coupon_calculate($params);
        
        if($res && isset($res['status']) && $res['status']=='error')
        {
            return $res;
        }
        $this->balance_calculate($params);
        return ['status'=>'ok','msg' =>""];;
    }

    protected function coupon_calculate(&$params)
    {
        $data = &$params ['data'];
        $order = &$params ['order'];

        $coupon_sn = array_get($data, 'coupon_sn', false);

        if ($coupon_sn)
        {
            $user_coupon = Db::name('user_coupon_cash')->where([
                'user_id' => $order['buyer_id'],
                'sn' => $coupon_sn,
                'status' => 0,
            ])->find();

            if (empty ($user_coupon))
            {
                
                return ['status'=>'error','msg' =>'优惠券无效[' . $coupon_sn . ']'];
               
            }

            $end_time = strtotime($user_coupon['end_time']);
            $start_time = strtotime($user_coupon['start_time']);
            if ($start_time > time())
            {
                return ['status'=>'error','msg' =>"优惠卷使用时间[${user_coupon['start_time']}]还未到"];
                

            }
            if ($end_time < time())
            {
                Db::name('user_coupon_cash')->where('id', $user_coupon['id'])->update(['status' => 2]);
                return ['status'=>'error','msg' =>'优惠券已经过期[' . $coupon_sn . ']'];
               
            }
            $coupon = Db::name('coupon')->where(['id'=>$user_coupon['coupon_id']])->field(['coupon_value', 'id', 'min_amount','base_amount','coupon_type'])->find();

            if ($coupon['coupon_value'])
            {
                $prod_limits = explode(',', $coupon['coupon_value']);
                foreach ($order['products'] as $prod)
                {
                    if (!in_array($prod['product_id'], $prod_limits))
                    {
                        return ['status'=>'error','msg' =>"服务产品${prod['product_name']}不可使用对应优惠券"];
                        
                    }
                }
            }

            /* $ext = Db::name('coupon')->metadata($coupon['id']);
            $ext = array_filter($ext);
            if (!empty($ext) && $coupon_province_id  = array_get($ext, 'province_id', 0))
            {
                \Log::info('coupon province limit: ' . $coupon_province_id);
                if($order['seller_id'] > 0 && !D($this->tb_stylist)->exist(array_add($ext, 'id', $order['seller_id'])))
                {
                    throw new BehaviorException('提供服务的美业师不能使用优惠券[' . $coupon_sn . ']');
                }
                $coupon_city_id = array_get($ext, 'city_id', 0);
                $addr_prov_id = array_get($data, 'contact.province_id', 0);
                $addr_city_id = array_get($data, 'contact.city_id', 0);

                if($addr_city_id && $coupon_province_id && ($addr_prov_id != $coupon_province_id || $addr_city_id != $coupon_city_id))
                {
                    throw new BehaviorException('所请求服务的地区不能使用优惠券[' . $coupon_sn . ']');
                }
            } */
            
            //优惠券可使用造型师范围
           /*  $coupon_stylist = array_get($ext,'stylist_value');
            if($coupon_stylist && !empty($ext)){
                $prod_limits = explode(',', $coupon_stylist);
                if(!$order['seller_id'])
                {
                    throw new BehaviorException('该优惠券只能指定造型师使用哦');
                }
                if(!in_array($order['seller_id'],$prod_limits)){
                    throw new BehaviorException('该造型师不满足该优惠券使用范围');
                }
            } */
          
            // 金额限制
            if(  $order['need_to_pay']  && (   $coupon['min_amount'] > $order['need_to_pay']) && in_array($coupon['coupon_type'], [1,3])){
                
               
                return ['status'=>'error','msg' =>"优惠券[${user_coupon['sn']}]，最低消费${coupon['min_amount']}元方可使用"];
                
               // throw new BehaviorException("优惠券[${user_coupon['sn']}]，必须满${coupon['min_amount']}元方可使用");
            }
            
            // 满减金额限制
            if(  $order['need_to_pay']  && ( $coupon['base_amount'] > $order['need_to_pay']) && in_array($coupon['coupon_type'], [2,4])){
            
                 
                return ['status'=>'error','msg' =>"优惠券[${user_coupon['sn']}]，必须满${coupon['base_amount']}元方可使用"];
            
                // throw new BehaviorException("优惠券[${user_coupon['sn']}]，必须满${coupon['min_amount']}元方可使用");
            }

            switch ($user_coupon['type'])
            {
                case 3:
                    $amount = $order ['order_amount'] * ((100 - $user_coupon['amount']) / 100);
                    break;
                case 4:
                    $amount = $order ['order_amount'] * ((100 - $user_coupon['amount']) / 100);
                    break;
                case 5:
                    $amount = $order ['order_amount'] - $user_coupon['amount'];
                    break;
                default:
                    $amount = $user_coupon ['amount'];

            }

            //$amount = $user_coupon['type'] == 5 ? ($order ['order_amount'] - $user_coupon['amount']) : $user_coupon ['amount'];
            $amount = $amount > 0 ? $amount : 0;
            $amount = $amount > $order ['need_to_pay'] ? $order ['need_to_pay'] : $amount;

            $order ['coupon_paid'] = $amount;
            $order ['already_paid'] += $amount;
            $order ['need_to_pay'] = round($order['need_to_pay'] - $amount, 2);

            $user_coupon ['order_sn'] = $order ['sn'];
            $user_coupon ['order_amount'] = $order ['order_amount'];
            $user_coupon ['discount_amount'] = $amount;
            $user_coupon ['status'] = 1;

            return [
                'order' => &$order,
                'user_coupon' => $user_coupon,
                'coupon' => $coupon
            ];
        }
        else
        {
            return [
                'order' => &$order,
                'user_coupon' => false,
                'coupon' => false
            ];
        }
    }

    /**
     * must in a transaction
     * @param  $params
     */
    public function after_submit(&$params)
    {
        $data = &$params ['data'];
        $order = &$params ['order'];
        $now = date('Y-m-d H:i:s');

        $coupon_sn = array_get($data, 'coupon_sn', false);
        $is_use_coupon = false;

        if ($coupon_sn)
        {
           
           $res = $this->coupon_calculate($params); 
           
           if($res && isset($res['status']) && $res['status']=='error')
           {
               return $res;
           }

            $user_coupon = $res['user_coupon'];

            Db::name('user_coupon_cash')->where(['id'=>$user_coupon['id']])->update(array_only($user_coupon, [
                'id',
                'order_sn',
                'order_amount',
                'discount_amount',
                'status'
            ]));

            Db::name('order')->where(['id'=>$order['id']])->update(array_only($order, [
                'id',
                'coupon_paid',
                'already_paid',
                'need_to_pay'
            ]));

            $pay_serial = [
                'order_id' => $order ['id'],
                'order_sn' => $order ['sn'],
                'user_id' => $user_coupon ['user_id'],
                'user_name' => '优惠券支付',
                'three_order_id' => $user_coupon ['sn'],
                'pay_type_name' => 'COUPON',
                'pay_type' => 'COUPON',
                'pay_time' => $now,
                'money_paid' => $order['coupon_paid'],
                'status' => 1,
                'return_msg' => $coupon_sn
            ];
            Db::name('order_pay_history')->insert($pay_serial);
            $is_use_coupon = true;
        }

        $is_use_balance = $this->pay_by_balance($params);
        
        

        if ($is_use_coupon || $is_use_balance)
        {
           
            $this->payAdjust($order['id'], $order['sn'], true);

            $params['order'] = array_replace($params['order'], Db::name('order')->where(['id'=>$order['id']])->find());
        }
        
        //var_dump($params); exit;
    }

    protected function balance_calculate(&$params)
    {
        $data = &$params['data'];
        $order = &$params['order'];

        $user_balance = array_get($data, 'use_balance', false);

        // 使用用户的余额
        // 还需支付余额大于0块钱才使用余额
        if ($user_balance)
        {
            // 查出用户的信息
            $user_info = Db::name('user')->where(['id'=>$order['buyer_id']])->field(['id', 'balance'])->find();

            $order ['balance_paid'] = 0;

            // 如果用户有余额就扣掉
            if ($user_info ['balance'] > 0)
            {

                // 如果用户的余额大于还需支付金额
                $balance_amount = $user_info ['balance'] > $order['need_to_pay'] ? $order['need_to_pay'] : $user_info['balance'];

                $order['already_paid'] += $balance_amount;
                $order['balance_paid'] = $balance_amount;
                $order['need_to_pay'] = round($order['need_to_pay'] - $balance_amount, 2);


                return $balance_amount;

            }
        }
        return 0;
    }

    private function pay_by_balance(&$params)
    {
        $order = &$params ['order'];
        $now = date('Y-m-d H:i:s');

        $is_use_balance = false;

        $order['balance_paid'] = 0;
        $balance_amount = $this->balance_calculate($params);
        
        if($balance_amount > 0)
        {
           
           Db::name('order')->where(['id'=>$order['id']])->update(array_only($order, [
                'id',
                'balance_paid',
                'already_paid',
                'need_to_pay',
                'pay_time'
            ]));

            if ($serial = $this->balance_out($order['buyer_id'], $order['balance_paid'], "余额支付[${order['sn']}]", $order['sn']))
            {
                // 支付流水记录
                $pay_balance = [
                    'order_id' => $order ['id'],
                    'order_sn' => $order ['sn'],
                    'user_id' => $order['buyer_id'],
                    'user_name' => '余额支付',
                    'three_order_id' => $serial,
                    'pay_type_name' => '余额',
                    'pay_type' => 'BALANCE',
                    'pay_time' => $now,
                    'money_paid' => $order ['balance_paid'],
                    'status' => 1,
                    'return_msg' => '成功支付余额' . $order ['balance_paid']
                ];
                Db::name('order_pay_history')->insert($pay_balance);
                $is_use_balance = true;
            }
            else
            {
                return ['status'=>'error','msg'=>'余额支付失败'];
                
            }
        }else{
            $order['balance_paid'] += $balance_amount;
        }

        return $is_use_balance;
    }
    
    /**
     * internal used
     * @param $uid
     * @param $amount
     * @param $note
     * @param bool $sn
     * @return array|bool
     */
    private function balance_out($uid, $amount, $note, $sn = false)
    {
        $latest_balance = Db::name('user_balance')->where(['user_id' => $uid])->sum('amount');
        $lb = $latest_balance - abs($amount);
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
            'in_out' => 1,
            'amount' => 0 - $amount,
            'latest_balance' => $lb,
            'note' => $note,
            'sn' => $sn ?: (date('YmdHis') . rand(10000, 99999)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    private function payAdjust($order_id = false, $order_sn = false, $adjust = false, $force = false)
    {
        
    
        $conds = $order_id ? [
            'id' => $order_id
        ] : [
            'sn' => $order_sn
        ];
    
        $pay_fields = [
            'id',
            'sn',
            'pay_status',
            'pay_type',
            'order_amount',
            'already_paid',
            'need_to_pay',
            'three_paid',
            'coupon_paid',
            'points_paid',
            'balance_paid'
        ];
    
        $order = Db::name('order')->where($conds)->find();
        if (!$order) {
            return ['status'=>'error','msg'=>'订单不存在'];
          
        }
    
        $conds = [
            'order_id' => $order ['id'],
            'money_paid' => [
                '>',
                0
            ],
            'status' => 1
        ];
    
        $calc ['already_paid'] = Db::name('order_pay_history')->where($conds)->sum('money_paid');
        $calc ['balance_paid'] = Db::name('order_pay_history')->where(array_add($conds, 'pay_type', 'BALANCE'))->sum('money_paid');
        $calc ['points_paid'] = Db::name('order_pay_history')->where(array_add($conds, 'pay_type', 'POINTS'))->sum('money_paid');
        $calc ['coupon_paid'] = Db::name('order_pay_history')->where(array_add($conds, 'pay_type', 'COUPON'))->sum('money_paid');
        $order ['three_paid'] = $order ['already_paid'] - $order ['coupon_paid'] - $order ['points_paid'] - $order ['balance_paid'];
        $calc ['need_to_pay'] = $order ['order_amount'] - $calc ['already_paid'];
    
        $latest = Db::name('order_pay_history')->order([
            'pay_time' => 'desc'
        ])->where($conds)->find();
    
        $order = array_replace($order, $calc);
        $res = [
            'now ' => array_only($order, $pay_fields),
            'calc' => $calc,
            'latest' => $latest
        ];
    
        if ($adjust && $order ['order_status'] == 0 && $order ['pay_status'] < 2 && $order ['pay_type'] != 'COD') {
            $res ['adjust'] = true;
            if ($calc ['need_to_pay'] < 0.001) {
                $this->finishPay($order, $latest ['money_paid'], $latest ['id']);
                
            } else {
                $info = array_only($order, $pay_fields);
                Db::name('order')->where(['id'=>$info['id']])->update(array_except($info, [
                    'order_status',
                    'pay_status'
                ]));
            }
        } else {
           /*  if ($force) {
                $info = array_only($order, $pay_fields);
                $res ['force'] = Db::name('order_info')->where(['order_id'=>$info['id']])->updateBy(array_except($info, [
                    'order_status',
                    'pay_status'
                ]), [
                    'order_id'
                ]);
            } */
        }
    
        return $res;
    }
    
    private function finishPay($order, $fee, $serial_id)
    {
        // 更新订单信息
        $order_sn = array_get($order, 'sn', '');
       
        
        //$this->_beginTransaction();
        Db::startTrans();
        try {
            $old_status = array_get($order, 'order_status', 0);
            // update order pay info
            //@6/1 美塑订单状态
            if($order['order_type'] == 8){
                $norder = Db::name('order')->where(['id'=>$order ['id']])->update([
                    'id' => $order ['id'],
                    'order_status' => $old_status ?: ($order ['seller_id'] > 0 ? 300 : 1),
                    'pay_status' => 2,
                    'three_paid' => $order ['three_paid'],
                    'already_paid' => $order ['already_paid'],
                    'need_to_pay' => $order ['need_to_pay'],
                    'pay_time' => date('Y-m-d H:i:s',time()+10)
                ]);
            }else{
                $norder = Db::name('order')->where(['id'=>$order['id']])->update([
                    'id' => $order ['id'],
                    'order_status' => $old_status ?: ($order ['seller_id'] > 0 ? 202 : 1),
                    'pay_status' => 2,
                    'three_paid' => $order ['three_paid'],
                    'already_paid' => $order ['already_paid'],
                    'need_to_pay' => $order ['need_to_pay'],
                    'pay_time' => date('Y-m-d H:i:s',time()+10)
                ]);
                
                
               
            }
            if($norder)
            {
                $norder = Db::name('order')->where(['id'=>$order['id']])->find();
            }
            //
            //Log::info("norder_pay_status sql:".serialize($norder));
    
            $norder = $norder ? array_replace($order, $norder) : $order;
            $sub_order_count = Db::name('order')->where(['parent_id' => $norder['id']])->count();
            if ($sub_order_count < 10 && $sub_order_count > 0) {
                Db::name('order')->where(['parent_id'=>$norder['parent_id'],'order_status'=>$norder['order_status']])->update([
                    'parent_id' => $norder['id'],
                    'order_status' => $norder['order_status'],
                    'pay_status' => $norder['pay_status'],
                    'pay_time' => $norder['pay_time']
                ]);
            }
    
            $params = [
                'order' => $norder,
                'pay_serial_id' => $serial_id
            ];
           // tag('order.pay.after', $params);
            //$this->_commit($params);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            //Log::error('finish pay error: ' . $e->getLine() . ': ' . $e->getMessage());
           // $this->_rollback($e->getMessage());
           // throw $e;
            // 回滚事务
            Db::rollback();
          
            $return = [
                'status' => 'error',
                'msg' => 'Exception',
                'data' => $e,
                'code' =>'',
            ];
            return $return;
        }
    }
}