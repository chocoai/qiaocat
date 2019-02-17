<?php
namespace app\dresser\validate;
use think\Validate;

class UserStore extends Validate{
    
    protected $rule = [
        'store_name|店铺名称'=>'require|max:200',
        'real_name|真实姓名' =>  'require|chs|max:30',
        'idcard|身份证号码' =>  'require',
        'idcard_img|身份证文件' =>  'require|max:200',
        'idcard_hand|手持身份证照片' =>  'require|max:200',
        'province_id|服务省份'=>'require',
        'city_id|服务城市'    =>'require',
        'up_store|是否提供顾客到店服务'=>'require|in:0,1',
        'work_years|工作起始年限'=>'require|max:200',
        'intro|个人介绍'      =>'require|max:300',
        'photo|作品' =>'require',
        'autograph_img|签名'=>'require|max:200'
    ];
    
}