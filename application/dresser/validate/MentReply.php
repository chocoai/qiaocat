<?php
namespace app\dresser\validate;
use think\Validate;

class MentReply extends Validate{
    
    protected $rule = [
        'parent_id|顶级评论id' =>  'require|number',
        'order_id|订单id'  =>  'require|number',
        'comment|回复内容'  =>  'require|max:300'
    ];
    
}