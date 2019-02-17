<?php

namespace app\qiaomao\model;
use think\Model;
use think\Db;

class Calculator extends Model
{
    protected $tb_product = 'product';
  
    /**
     * @param $items
     * @throws \Exception
     * @return array
     */
    public function calculate($items, $user_coupon_sn = false)
    {
        $number = 0;
        $total = 0.0;
    
        //年会产品ID
        $pids = [1000133,1000134,1000135,1000136];
        foreach ($items as $item)
        {
            $number += $item['number'];
    
            $conds['id'] = $item['id'];
    
            if(!in_array($item['id'],$pids))
            {
                $conds['online'] = 1;
            }
    
            $prod = Db::name($this->tb_product)->where($conds)->field(['id', 'price'])->find();
    
    
            if (  1== 2 &&    !$prod)
            {
                throw new \Exception('服务即将开通');
            }
    
            else
            {
                $total += $item['number'] * $prod['price'];
            }
        }
    
        return [
            'number' => $number,
            'total' => $total
        ];
    }
    
    /**
     * @param $items
     * @throws \Exception
     * @return array
     */
    public function topic_cart_calculate($items, $topic = false, $money = false, $mid_money = false, $user_coupon_sn = false)
    {
        $number = 0;
        $total = 0.0;
    
        //年会产品ID
        $pids = [1000133, 1000134, 1000135, 1000136];
        foreach ($items as $item) {
            $number += $item['number'];
    
            $conds['id'] = $item['id'];
    
            if (!in_array($item['id'], $pids)) {
                $conds['online'] = 1;
            }
    
            $prod = Db::name($this->tb_product)->where($conds)->field(['id', 'price'])->find();
            if ($topic == "halloween2") {
                /*20161029万圣节产品ID
                 *产品ID：
                 *0.01元：1000122
                 *30元：1000303
                 *万圣节简单特效妆1000123
                 *万圣节普通特效妆1000121
                 *万圣节高级定制特效妆1000302
                 * $hallo = [1000122, 1000303, 1000123, 1000121, 1000302];
                 */
                switch ($conds['id']) {
                    case "1000122":
                        $prod['price'] = 0.01;
                        break;
                    case "1000303":
                        $prod['price'] = 30;
                        break;
                    case "1000123":
                        $prod['price'] = 188;
                        break;
                    case "1000121":
                        $prod['price'] = 268;
                        break;
                    case "1000302":
                        $prod['price'] = 328;
                        break;
                    default :
                        break;
                }
            }
            /*20161029万圣节结束*/
            if (!$prod) {
                throw new \Exception('服务即将开通');
            } else {
                $total += $item['number'] * $prod['price'];
            }
    
        }
    
        if ($topic == "halloween") {
            //  保留两位小数点
            ////$beforMoney = floor($total);
            $beforMoney = round($total, 2 );
            if ($number == 1) {
                $totals = $total;
            } elseif ($number == 2) {
                $totals = $total * 0.9;
            } elseif ($number == 3) {
                $totals = $total * 0.85;
            } elseif ($number == 4) {
                $totals = $total * 0.8;
            } elseif ($number == 5) {
                $totals = $total * 0.75;
            } elseif ($number == 6) {
                $totals = $total * 0.70;
            } elseif ($number == 7) {
                $totals = $total * 0.65;
            } elseif ($number == 8) {
                $totals = $total * 0.60;
            } elseif ($number == 9) {
                $totals = $total * 0.55;
            } elseif ($number == 10) {
                $totals = $total * 0.5;
            } else {
                $totals = $total;
            }
            ///$totals = floor($totals);
            $totals = round($totals, 2);
            //echo "<pre>"; dd($total);
            if ($money == $beforMoney && $mid_money == $totals) {
    
                return [
                    'number' => $number,
                    'total' => $totals
                ];
            } else {
                echo "js计算前+++" . $money . "+++++++++++js计算后" . $mid_money . "++++php计算前++++" . $beforMoney . "++++后++" . $totals;
                exit;
                return;
            }
        }
        if ($topic == "annualMeeting") {
            if ($number == 1) {
                $totals = $total;
            } elseif ($number > 1 && $number < 6) {
                $totals = $total * 0.9;
            } elseif ($number > 5 && $number < 10) {
                $totals = $total * 0.8;
            } elseif ($number > 9 && $number < 16) {
                $totals = $total * 0.7;
            } elseif ($number > 15 && $number < 21) {
                $totals = $total * 0.6;
            } else {
                $totals = $total;
            }
            ///$totals = floor($totals);
            $totals = round($totals, 2 );
            return [
                'number' => $number,
                'total' => $totals
            ];
        }
        /// 合并嘉帆代码
        if ($topic == "queensday") {
    
            if($total==936){  //268+668
                $totals=836;
            }elseif($total==536){ //268+268
                $totals=486;
            }elseif($total==1036){ //268+768
                $totals=936;
            }elseif($total==1336){ //668+668
                $totals=1136;
            }elseif($total==1436){ //668+768
                $totals=1236;
            }elseif($total==1536){ //768 +768
                $totals=1336;
            }else{
                $totals=$total;
            }
            return [
                'number' => $number,
                'total' => $totals
            ];
        }
    
    }


}