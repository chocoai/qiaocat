<?php
namespace app\dresser\controller;
use think\Controller;
use think\Db;

/**
 * 评价类
 */
class Comment extends Controller{
    
    /**
     * @api {post} dresser/dr_ment_index 美业师评价管理[dresser/dr_ment_index]
     * @apiVersion 2.0.0
     * @apiName dr_ment_index
     * @apiGroup dresser_Comment
     * @apiSampleRequest dresser/dr_ment_index
     * 
     * @apiParam {int} page_no    第几页
     * @apiParam {int} per_page    一页几条
     * @apiParam {int} type    0全部，1好评，2中评，3差评，4有图
     */
    public function ment_index(){
        if(if_cookie()==true){
            if(if_meiye()==true){
            $page_no  = input('page_no')?input('page_no'):1;
            $per_page = input('per_page')?input('per_page'):10;
            $type = input('type')?input('type'):0;
            $id = get_cookie()['id'];
            $sum = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->count();
            $hao = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('score',5)->count();
            $zhong = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('score','between',[3,4])->count();
            $cha = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('score','between',[1,2])->count();
            $has_img = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('images','not null')->count();
            $info=['sum'=>$sum,'hao'=>$hao,'zhong'=>$zhong,'cha'=>$cha,'has_img'=>$has_img];
            if($type==0){
                $map['cont_type']=['=',1];
            }elseif ($type==1){
                $map['cont_type']=['=',1];
                $map['score']=['=',5];
            }elseif ($type==2){
                $map['cont_type']=['=',1];
                $map['score']=['between',[3,4]];
            }elseif ($type==3){
                $map['cont_type']=['=',1];
                $map['score']=['between',[1,2]];
            }elseif ($type==4){
                $map['cont_type']=['=',1];
                $map['images']=['<>','null'];
            }else{
                $map['cont_type']=['=',1];
            }

            $res = Db::name('comment')->where(['stylist_id'=>$id,'status'=>1])->where($map)->order('created_at','desc')->field(['id','order_id'])->page($page_no,$per_page)->select();
            $data=[];
            if(count($res)>0){
                foreach ($res as $v){
                    $user_info=Db::name('comment')->where('id',$v['id'])->field(['id','product_id','order_id','user_img','user_name','score','comment','images','created_at'])->find();
                    if($user_info)
                    {
                        $user_info['images'] =explode(',',  $user_info['images']);
                    }
                    $zhuijia = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',2)->field(['comment','images','created_at'])->find();
                    if($zhuijia)
                    {
                        $zhuijia['images'] =explode(',',  $zhuijia['images']);
                    }
                    $huifu = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',3)->field(['comment','created_at'])->find();
                    $goods = Db::name('product')->where('id',$user_info['product_id'])->field(['name','thumb'])->find();
                    $arr = ['user_info'=>$user_info,'zhuijia'=>$zhuijia,'huifu'=>$huifu,'goods'=>$goods];
                    array_push($data, $arr);
                }
              return json(['status'=>'ok','info'=>$info,'data'=>$data]);
            }else{
              return json(['status'=>'ok','data'=>[]]);
            }
         }else{
            return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
         }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} dresser/dr_ment_reply 美业师回复评价[dresser/dr_ment_reply]
     * @apiVersion 2.0.0
     * @apiName dr_ment_reply
     * @apiGroup dresser_Comment
     * @apiSampleRequest dresser/dr_ment_reply
     *
     * @apiParam {int} parent_id    顶级评论的id
     * @apiParam {int} order_id    订单id
     * @apiParam {int} product_id    商品id
     * @apiParam {string} comment    回复内容
     */
    public function ment_reply(){
        if(if_cookie()==true){
            if(if_meiye()==true){
                $parent_id= input('parent_id');
                $order_id= input('order_id');
                $product_id = input('product_id');
                $comment = input('comment');
                $id = get_cookie()['id'];
                $time = date('Y-m-d H:i:s',time());
                $res = Db::name('comment')->where(['parent_id'=>$parent_id,'cont_type'=>3])->find();
                if($res){
                   return json(['status'=>'error','msg'=>'你已经回复过，请勿重复回复']);
                }
                $data = ['parent_id'=>$parent_id,'cont_type'=>3,'order_id'=>$order_id,
                         'product_id'=>$product_id,'stylist_id'=>$id,'add_time'=>time(),
                         'user_id'=>$id,'status'=>2,'comment'=>$comment,'user_name'=>0,
                         'created_at'=>$time,'updated_at'=>$time
                        ];
                $validate = validate('MentReply');
                if(!$validate->check($data)){
                    return json(['status'=>'error','msg'=>$validate->getError()]);
                }
                
                Db::name('comment')->insert($data);
                return json(['status'=>'ok','msg'=>'回复成功']);
            }else{
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}