<?php
namespace app\dresser\validate;
use think\Validate;


class AgencyStore extends Validate{
    
    protected $rule = [
        'store_name|店铺名称'=>'require|max:200',
        'license|营业执照' =>  'require|max:200',
        'real_name|真实姓名' =>  'require|chs|max:30',
        'idcard|身份证号码' =>  'require',
        'idcard_img|身份证文件' =>  'require|max:200',
        'plastic|是否开整形类手术'=>'require|in:0,1',
        'province_id|服务省份'=>'require',
        'city_id|服务城市'    =>'require',
        'aptitude|机构资质'=>'require|max:200',
        'store_add|机构地址' =>'require|max:200',
        'intro|店铺介绍'      =>'require|max:300',
        'photo|作品' =>'require',
        'autograph_img|签名'=>'require|max:200'
    ];
    
}