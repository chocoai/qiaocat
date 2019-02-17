<?php 
namespace app\dresser\validate;
use think\Validate;


class EditStore extends Validate{
    
    protected $rule = [
        'store_name|店铺名称'=>'require|max:50',
        'intro|店铺介绍'=>'require|max:350',
        'advance|预约时间' =>  'require|number|max:2',
        'business_start|营业开始时间' =>  'require|max:30',
        'business_end|营业结束时间' =>  'require|max:30',
        'business_week|营业工作日'=> 'require|max:100',
        'province_id|省份'=>'require',
        'city_id|城市'=>'require',
        'street_id|商圈'     =>'require',
        'up_store|是否提供到店服务'=>'require|in:0,1',
    ];
    
    
}