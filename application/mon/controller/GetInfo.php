<?php
namespace app\mon\controller;
use think\Controller;
use think\Db;

/**
 * 获取信息类
 */
class GetInfo extends Controller{
    
    
    /**
     * @api {post} mon/mon_get_type 获取美业师类型[mon/mon_get_type]
     * @apiVersion 2.0.0
     * @apiName mon_get_type
     * @apiGroup mon_GetInfo
     * @apiSampleRequest mon/mon_get_type
     *
     */
    public function get_type(){
        if(if_cookie()==true){
            $data = Db::name('product_category')->where(['parent_id'=>0,'is_show'=>1])->field(['id','name','sort'])->order('sort')->select();
            return json(['status'=>'ok','data'=>$data]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} mon/mon_get_province 获取省份[mon/mon_get_province]
     * @apiVersion 2.0.0
     * @apiName mon_get_province
     * @apiGroup mon_GetInfo
     * @apiSampleRequest mon/mon_get_province
     *
     */
       
    public function get_province(){
        if(if_cookie()==true){
            $data = Db::name('location_province')->select();
            return json(['status'=>'ok','data'=>$data]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} mon/mon_get_city 获取城市[mon/mon_get_city]
     * @apiVersion 2.0.0
     * @apiName mon_get_city
     * @apiGroup mon_GetInfo
     * @apiSampleRequest mon/mon_get_city
     *
     * @apiParam {int} province_id    省份id
     */
    
    public function get_city(){
        if(if_cookie()==true){
          $province_id = input('province_id');
            if(!empty($province_id)){
                $data = Db::name('location_city')
                ->where(['province_id'=>$province_id,'is_show'=>1])
                ->select();
                return json(['status'=>'ok','data'=>$data]);
            }else{
              return json(['status'=>'error','code'=>-100,'msg'=>'请填写省份id']);
            }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} mon/mon_get_area 获取区[mon/mon_get_area]
     * @apiVersion 2.0.0
     * @apiName mon_get_area
     * @apiGroup mon_GetInfo
     * @apiSampleRequest mon/mon_get_area
     *
     * @apiParam {int} city_id    城市id
     */
    public function get_area(){
        if(if_cookie()==true){
            $city_id= input('city_id');
            if(!empty($city_id)){
                $data = Db::name('location_area')
                ->where('city_id',$city_id)
                ->select();
                return json(['status'=>'ok','data'=>$data]);
            }else{
                return json(['status'=>'error','code'=>-100,'msg'=>'请填写城市id']);
            }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} mon/mon_get_street 获取商圈[mon/mon_get_street]
     * @apiVersion 2.0.0
     * @apiName mon_get_street
     * @apiGroup mon_GetInfo
     * @apiSampleRequest mon/mon_get_street
     *
     * @apiParam {int} add_id    城市id或区id
     */
    public function get_street(){
        if(if_cookie()==true){
            $add_id = input('add_id');
            if(!empty($add_id)){
                $data = Db::name('location_street')
                ->where('area_id',$add_id)
                ->select();
                return json(['status'=>'ok','data'=>$data]);
            }else{
                return json(['status'=>'error','code'=>-100,'msg'=>'请填写城市id或区id']);
            }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }

    }
    
    /**
     * @api {post} mon/mon_get_agency 获取机构店铺[mon/mon_get_agency]
     * @apiVersion 2.0.0
     * @apiName mon_get_agency
     * @apiGroup mon_GetInfo
     * @apiSampleRequest mon/mon_get_agency
     *
     */
    public function get_agency(){
        if(if_cookie()==true){
                $data = Db::name('stylist')
                ->where(['is_check'=>1,'store_type'=>2])
                ->field(['id','store_name'])
                ->select();
                return json(['status'=>'ok','data'=>$data]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
}