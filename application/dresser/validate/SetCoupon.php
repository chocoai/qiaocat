<?php
namespace app\dresser\validate;
use think\Validate;

class SetCoupon extends Validate{
    
    protected $rule = [
        'name|优惠券名称' =>'require',
        'coupon_value|适用范围' =>'require',
        'base_amount|使用最低条件' =>  'require|integer',
        'coupon_amount|优惠券面额'=> 'require|integer',
        'total_count|发行数量' =>'require|integer',
        'start_time|有效开始时间' =>'require|date',
        'end_time|有效结束时间' => 'require|date',
    ];
    
}