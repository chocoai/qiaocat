<?php
namespace app\dresser\validate;
use think\Validate;


class AddData extends Validate{
    
    protected $rule = [
        'user_img|头像' =>'require|max:100',
        'nick|昵称'  =>  'require|max:50',
        'sex|性别' =>  'require|number',
        'type|技术类型'=> 'require',
        'user_good|擅长' =>'require|length:2,200',
        'weixin|微信号' =>'require|max:50',
        'where_add|所在城市'  =>'require|max:100'
    ];
    
}