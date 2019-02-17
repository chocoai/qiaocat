<?php
namespace app\dresser\validate;
use think\Validate;


class ComValidate extends Validate{
    
    protected $rule = [
        'mobile|手机号'  =>  'require|length:11',
        'code|验证码' =>  'require|length:6',
    ];   
    
}