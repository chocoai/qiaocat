<?php
namespace app\dresser\validate;
use think\Validate;


class ServiceValidate extends Validate{
    
    protected $rule = [
        'cate_id|服务一级分类' =>'require|number',
        'cate_id_2|服务二级分类'  =>  'require|number',
        'service_form|服务形式' =>  'require|max:4',
        'name|服务名称'=> 'require|max:25',
        'duration|耗时' =>'require|between:1,480',
        'market_price|市场价'=>'require|number',
        'price|会员价'=>'require|number',
        'description|图文详情' =>'require',
        'images|服务主图片的路径' =>'require'
    ];
    
    
}