<?php
namespace app\dresser\validate;
use think\Validate;

class EditInfo extends Validate{
    
    protected $rule = [
        'user_img|头像' =>  'require|max:200',
        'sex|性别' =>  'require|number|length:1',
        'user_good|擅长' =>'require|max:200',
        'wechat_no|微信号'=>'require|max:30',
        'nick|昵称'   => 'require|max:50'
    ];
    
}