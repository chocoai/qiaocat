<?php
namespace app\dresser\validate;
use think\Validate;

class CouponOnOff extends Validate{
    
    protected $rule = [
        'id|优惠券id' =>  'require|number',
        'type|状态'  =>  'require|in:0,1'
    ];   
    
}