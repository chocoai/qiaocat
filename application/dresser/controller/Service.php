<?php
namespace app\dresser\controller;

use think\Controller;
use think\Db;
use think\View;
use OSS\OssClient;
use OSS\Core\OssException;

/**
 *服务的接口
 */

class Service extends Controller{

    //查询出所有服务的一级分类和二级分类
    /**
     * @api {post} dresser/dr_show_service_class 查询服务一二级分类[dresser/dr_show_service_class
     * @apiVersion 2.0.0
     * @apiName dr_show_service_class
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_show_service_class
     *
     */
    public function show_service_class(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }
        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        try {
            //该美业师所能够提供的一二级分类
            $arr = explode(',',$res['type']);
            $parent = [];
            foreach ($arr as $k => $v) {
                $map['is_show'] = 1;
                $map['id'] = $v;
                $parent[] = Db::name('product_category')->where($map)->field('id,name')->find();
            }
            foreach ($parent as $k => $v) {
                $map1['parent_id'] = $v['id'];
                $map1['is_show'] = 1;
                $parent[$k]['son'] = Db::name('product_category')->where($map1)->field('id,name')->select();
            }
            return json(['status' => 'ok','data' => $parent]);
        } catch (\Throwable $e) {
            return json(['status' => 'error','code' => -5,'msg'=>get_msg(-5)]);
        }

        //var_dump($parent);

    }

    //查询出该美业师所能服务的一二级分类
    /**
     * @api {post} dresser/dr_show_ky_service 查询服务一二级分类[dresser/dr_show_ky_service
     * @apiVersion 2.0.0
     * @apiName dr_show_ky_service
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_show_ky_service
     *
     */
    public function show_ky_service(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }
        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //查询出所有服务的一级分类和二级分类
        $arr = explode(',',$res['type']);
        $parent = [];
        foreach ($arr as $k => $v) {
           $map['parent_id'] = 0;
           $map['is_show'] = 1;
           $map['id'] = $v;
           $parent[] = Db::name('product_category')->where($map)->field('id,name')->find();
        }
       
        try {
            //var_dump($parent);
            foreach ($parent as $k => $v) {
                $map1['parent_id'] = $v['id'];
                $map1['is_show'] = 1;
                $parent[$k]['son'] = Db::name('product_category')->where($map1)->field('id,name')->select();
            }
            return json(['status' => 'ok','data' => $parent]);
        } catch (\Throwable $e) {
            return json(['status' => 'error','code' => -5,'msg'=>get_msg(-5)]);
        }

        //var_dump($parent);

    }

    //添加美业师的个性化服务(包含保存和提交两个接口，只需要加上service_type这个字段判断)
    /**
     * @api {post} dresser/dr_adds_service 添加个性化服务[dresser/dr_adds_service]
     * @apiVersion 2.0.0
     * @apiName dr_adds_service
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_adds_service
     *
     * @apiParam {int} service_type       该字段判断是保存服务，还是添加服务;保存就传11过来，添加不用传该值
     * @apiParam {int} cate_id            一级分类id
     * @apiParam {int} cate_id_2          二级分类id
     * @apiParam {string} pic_path        服务主图片的路径
     * @apiParam {string} thumb           缩略图地址
     * @apiParam {string} service_form    服务形式
     * @apiParam {string} name            服务名称
     * @apiParam {float} duration         耗时
     * @apiParam {float} market_price     市场价
     * @apiParam {float} price            当美业师添加个性化服务时，不选择预定金服务，该字段就是会员价格，当选择预定金服务时，就是预定金价格
     * @apiParam {int} circumstances_service   是否拥有预定金服务 1否 2是
     * @apiParam {float} shop_price   到店付价格  选择预定金服务才存在
     * @apiParam {string} description     图文详情
     *
     *
     */
    public function adds_service(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //获取传过来的所有主图片的路径
        $images = input('pic_path');
        $datass['images'] = $images;
        $slu = input('thumb');
        $ss = explode(',',$slu);
        $datass['thumb'] = $ss[0];

        //组装添加的数据
        $datass['cate_id'] = input('cate_id');
        $datass['cate_id_2'] = input('cate_id_2');
        $datass['service_form'] = input('service_form');
        $datass['name'] = input('name');
        $datass['duration'] = input('duration');
        $datass['market_price'] = input('market_price');
        $datass['price'] = input('price');
        //$datass['description'] = input('description');
        $datass['new_pic_path'] = input('new_pic_path');
        $datass['new_details'] = input('new_details');
        $datass['description'] = input('description');
        //美业师id
        $datass['stylist_id'] = $id;
        //预定金服务
        $circumstances_service = input('circumstances_service');
        if($circumstances_service == 2){
            $datass['circumstances_service'] = 2;
            //到店付价格
            $datass['shop_price'] = input('shop_price');
        }

        $datass['label'] = 2;
        //服务的状态
        if(input('service_type') == 11){
            $datass['online'] = 4; //该服务为保存的状态
        }else{
            $datass['online'] = 2;   //该服务为待审核的状态
        }
        $datass['type_user'] = 1;
        $datass['add_time'] = date('Y-m-d H:i:s');

        $validate = validate('ServiceValidate');
        if(!$validate->check($datass)){
            return json(['status'=>'error','msg'=>$validate->getError()]);
        }
        try {
            //得到添加服务的id
            $product_id = Db::name('product')->insertGetId($datass);
            if(input('service_type') == 11){
                if($product_id == '') return json(['status'=>'error','msg'=>'保存服务失败']);
            }else{
                if($product_id == '') return json(['status'=>'error','msg'=>'添加服务失败']);
            }
            
            //获取美业师的id
            $stylist_id = get_cookie()['id'];
            //$stylist_id = 324299922;
            $adddata['stylist_id'] = $stylist_id;
            $adddata['product_id'] = $product_id;
            $adddata['type_user'] = 1;
            $adddata['cate_id'] = input('cate_id');
            $adddata['cate_id_2'] = input('cate_id_2');
            $adddata['create_at'] = date('Y-m-d H:i:s');
            //服务的状态
            if(input('service_type') == 11){
                $adddata['online'] = 4; //该服务为保存的状态
            }else{
                $adddata['online'] = 2;   //该服务为待审核的状态
            }

            Db::name('stylist_service')->insert($adddata);

            if(input('service_type') == 11){
                return json(['status'=>'ok','msg'=>'保存成功']);
            }else{
                return json(['status'=>'ok','msg'=>'添加成功']);
            }

        }catch (\Throwable $e) {
            if(input('service_type') == 11){
                return json(['status'=>'error','msg'=>'保存失败']);
            }else{
                return json(['status'=>'error','msg'=>'添加失败']);
            }
        }


    }




    //添加俏猫标准化服务的接口1:查询出所有该分类下的符合要求的商品供美业师选择
    /**
     * @api {post} dresser/dr_Standardized_service 查询俏猫标准化服务[dresser/dr_Standardized_service]
     * @apiVersion 2.0.0
     * @apiName dr_Standardized_service
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_Standardized_service
     *
     * @apiParam {int} parent_id            一级分类id
     * @apiParam {int} son_id               二级分类id
     *
     *
     */
    public function Standardized_service(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //默认美业师id
        //$id = 324251115;
        //接收参数，添加数据
        $parent_id = input('parent_id'); //一级id
        //$parent_id = 1;
        $son_id = input('son_id');   //二级id
        //$son_id = 8;
        //查询出该美业师拥有的服务
        $map11['stylist_id'] = $id;
        $map11['is_del'] = 0;
        $res = Db::name('stylist_service')->where($map11)->field('product_id')->select();
        $user_Service = "";
        foreach ($res as $k => $v) {
            $user_Service .= $v['product_id'].',';
        }
        $user_Service = rtrim($user_Service,',');
        //组装条件
        $map['cate_id'] = $parent_id;
        $map['cate_id_2'] = $son_id;
        $map['online'] = 1;
        $map['id'] = ['not in',$user_Service];
        $map['type_user'] = 2;
        try {
            $data = Db::name('product')->where($map)->field('id,name,price,market_price,thumb,duration')->select();
            return json(['status' => 'ok','data' => $data]);
        } catch (\Throwable $e) {
            return json(['status' => 'errot','data' => '']);
        }

    }



    //添加俏猫标准化服务的接口2:添加数据到数据库
    /**
     * @api {post} dresser/dr_add_Standardized_service 添加俏猫标准化服务[dresser/dr_add_Standardized_service]
     * @apiVersion 2.0.0
     * @apiName dr_add_Standardized_service
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_add_Standardized_service
     *
     * @apiParam {string} service_arr            美业师选择的服务的id
     *
     *
     */
    public function add_Standardized_service(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //默认美业师id
        //$id = 324251115;
        //接收参数，添加数据
        $product_arr = input('service_arr');
        
        if($product_arr != ''){
            $product_arr = explode(',',$product_arr);
            try {
                foreach ($product_arr as $k => $v) {
                    //根据服务id查询出该商品的一 二级分类
                    $ress = Db::name('product')->where('id',$v)->field('cate_id,cate_id_2')->find();
                    //循环添加俏猫平台的服务
                    $data['stylist_id'] = $id;
                    $data['product_id'] = $v;
                    $data['online'] = 1;
                    $data['type_user'] = 2;
                    $data['cate_id'] = $ress['cate_id'];
                    $data['cate_id_2'] = $ress['cate_id_2'];
                    $data['create_at'] = date('Y-m-d H:i:s');
                    $res = Db::name('stylist_service')->insert($data);
           
                }
                return json(['status'=>'ok','msg'=>'添加成功','res' => $res]);
            } catch (\Throwable $e) {
                return json(['status'=>'error','msg'=>'添加失败']);
            }
        }else{
             return json(['status'=>'error','msg'=>'数据不能为空']);
        }
            
        
        

    }


    //点击服务菜单栏时，判断该美业师是否有添加服务的权限
    /**
     * @api {post} dresser/dr_type_auth 服务权限接口[dresser/dr_type_auth]
     * @apiVersion 2.0.0
     * @apiName dr_type_auth
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_type_auth
     *
     *
     */
    public function type_auth(){
        //判断是否是正常的用户登录
       if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //$id = 324251115;
        $res = Db::name('stylist')->where('id',$id)->find();
        //var_dump($res);
        if($res['street_id'] == "") return json(['status'=>'error','code' => -9,'msg'=>get_msg(-9)]);
        if($res['is_online'] == 1) return json(['status'=>'error','code' => -4,'msg'=>get_msg(-4)]);

        return json(['status'=>'ok','store_address'=>$res['store_add'],'msg'=>'有添加服务的权限']);

    }




    //服务列表的接口
    /**
     * @api {post} dresser/dr_service_list 服务列表的接口[dresser/dr_service_list]
     * @apiVersion 2.0.0
     * @apiName dr_service_list
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_service_list
     * 
     *@apiParam {int} service_type      服务列表数据  all代表所有数据 1已上架 2待审核 3不通过 4以保存 0已下架         
     *
     */
    public function service_list(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //默认$id
        //$id = 324251115;
        //根据美业师的id查询出美业师所拥有的服务
        $map['stylist_id'] = $id;
        $map['is_del'] = 0;
        $service_type = input('service_type');
        try {
            if($service_type == 'all'){
                $arr = DB::name('stylist_service')->where($map)->field('product_id,online')->order('create_at desc')->select();
                $data = [];
                $data[1]['name'] = "已上架";
                $data[2]['name'] = "待审核";
                $data[3]['name'] = "不通过";
                $data[4]['name'] = "以保存";
                $data[0]['name'] = "已下架";
                $shangjia_service = 0;
                $qiaocat_service = 0;
                foreach ($arr as $k => $v) {
                    //循环查询出每一个服务
                    $res = Db::name('product')->where('id',$v['product_id'])->field('name,type_user,price,market_price,shop_price,circumstances_service,duration,thumb,sell_count,id,online')->find();
                    //var_dump($res);
                    if($res['type_user'] == 2){ //俏猫平台
                       //判断平台该服务主表的状态
                       if($res['online'] == 1){  //平台该服务主表状态上架
                            if($v['online'] == 1){
                                $shangjia_service += 1;
                                $qiaocat_service += 1;
                                $data[1]['service'][] = $res;
                            }
                       }else{  //平台该服务主表状态下架
                            if($v['online'] == 1){
                                $data[0]['service'][] = $res;
                            }
                       }
                        
                    }else{  //个性化
                        if($v['online'] == 1){
                            $shangjia_service += 1;
                            $data[1]['service'][] = $res;
                        }
                    }
                        
                        if($v['online'] == 2){
                            $data[2]['service'][] = $res;
                        }
                        if($v['online'] == 3){
                            $data[3]['service'][] = $res;
                        }
                        if($v['online'] == 4){
                            $data[4]['service'][] = $res;
                        }
                        if($v['online'] == 0){
                            $data[0]['service'][] = $res;
                        }
                }
                $data[1]['shangjia_service'] = $shangjia_service;
                $data[1]['qiaocat_service'] = $qiaocat_service;
            }elseif($service_type == 0){
                 $map['online'] = 0;
                 $arr = DB::name('stylist_service')->where($map)->field('product_id,online')->order('create_at desc')->select();
                 $data = [];
                 $data[0]['name'] = "已下架";
                 foreach ($arr as $k => $v) {
                    //循环查询出每一个服务
                    $res = Db::name('product')->where('id',$v['product_id'])->field('name,type_user,price,market_price,duration,thumb,sell_count,id')->find();
                        $data[0]['service'][] = $res;
                 }
            }elseif($service_type == 1){
                $map['online'] = 1;
                $arr = DB::name('stylist_service')->where($map)->field('product_id,online')->order('create_at desc')->select();
                $data = [];
                $data[1]['name'] = "已上架";
                $shangjia_service = 0;
                $qiaocat_service = 0;
                foreach ($arr as $k => $v) {
                    //循环查询出每一个服务
                    $res = Db::name('product')->where('id',$v['product_id'])->field('name,type_user,price,market_price,duration,thumb,sell_count,id,online')->find();
                    //判断该服务是俏猫平台还是美业师个人的
                    if($res['type_user'] == 2){  //俏猫平台
                          if($res['online'] == 1){
                                $shangjia_service += 1;
                                $qiaocat_service += 1;
                                $data[1]['service'][] = $res;
                             }
                    }else{  //美业师个人的
                        $shangjia_service += 1;
                        $data[1]['service'][] = $res;
                    }
                                
                }
                $data[1]['shangjia_service'] = $shangjia_service;
                $data[1]['qiaocat_service'] = $qiaocat_service;
            }elseif($service_type == 2){
                 $map['online'] = 2;
                 $arr = DB::name('stylist_service')->where($map)->field('product_id,online')->order('create_at desc')->select();
                 $data = [];
                 $data[2]['name'] = "待审核";
                 foreach ($arr as $k => $v) {
                    //循环查询出每一个服务
                    $res = Db::name('product')->where('id',$v['product_id'])->field('name,type_user,price,market_price,duration,thumb,sell_count,id')->find();
                    $data[2]['service'][] = $res;
                 }
            }elseif($service_type == 3){
                 $map['online'] = 3;
                 $arr = DB::name('stylist_service')->where($map)->field('product_id,online')->order('create_at desc')->select();
                 $data = [];
                 $data[3]['name'] = "不通过";
                 foreach ($arr as $k => $v) {
                    //循环查询出每一个服务
                    $res = Db::name('product')->where('id',$v['product_id'])->field('name,type_user,price,market_price,duration,thumb,sell_count,id')->find();
                    $data[3]['service'][] = $res;
                 }
            }elseif($service_type == 4){
                 $map['online'] = 4;
                 $arr = DB::name('stylist_service')->where($map)->field('product_id,online')->order('create_at desc')->select();
                 $data = [];
                 $data[4]['name'] = "已保存";
                 foreach ($arr as $k => $v) {
                    //循环查询出每一个服务
                    $res = Db::name('product')->where('id',$v['product_id'])->field('name,type_user,price,market_price,duration,thumb,sell_count,id')->find();
                    $data[4]['service'][] = $res;
                 }
            }

            return json(['status' => 'ok','data' => $data]);

        } catch (\Throwable $e) {
            return json(['status'=>'error','code' => -5,'msg'=>get_msg(-5)]);
        }
            



    }


    //当点击“修改” ,即查询出该服务的数据
    /**
     * @api {post} dresser/dr_ysj_edit 点击'修改'与'详情'的数据[dresser/dr_ysj_edit]
     * @apiVersion 2.0.0
     * @apiName dr_ysj_edit
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_ysj_edit
     *
     *
     *@apiParam {int} service_id         修改，详情的服务id
     */
    public function ysj_edit(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        $service_id = input('service_id');
        //$service_id = 1000027;
        try {
            $res = Db::name('product')->where('id',$service_id)->field('cate_id,cate_id_2,thumb,description,sell_count,add_time,service_form,name,images,new_details,new_pic_path,price,market_price,shop_price,circumstances_service,duration,id,type_user')->find();

            $res['images'] = explode(',',$res['images']);
            $res['new_pic_path'] = explode(',',$res['new_pic_path']);
            $res['cate_id_name'] = Db::name('product_category')->where('id',$res['cate_id'])->value('name');
            $res['cate_id_2_name'] = Db::name('product_category')->where('id',$res['cate_id_2'])->value('name');
            $res['online'] = Db::name('stylist_service')->where('product_id',$service_id)->value('online');
            //var_dump($res);
            return json(['status' => 'ok','data' => $res]);
        } catch (\Throwable $e) {
            return json(['status'=>'error','code' => -5,'msg'=>get_msg(-5)]);
        }


    }


    //当点击“提交或保存” 时(包含保存和提交两个接口，只需要加上service_type这个字段判断)
    /**
     * @api {post} dresser/dr_ysj_tj 服务列表提交,保存接口[dresser/dr_ysj_tj]
     * @apiVersion 2.0.0
     * @apiName dr_ysj_tj
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_ysj_tj
     *
     * @apiParam {int} service_type       该字段判断是保存服务，还是添加服务;保存就传11过来，添加不用传该值
     * @apiParam {int} id         修改的服务id
     * @apiParam {int} cate_id            一级分类id
     * @apiParam {int} cate_id_2          二级分类id
     * @apiParam {string} pic_path         服务主图片的路径
     * @apiParam {string} new_pic_path     服务详情图片的路径
     * @apiParam {string} service_form    服务形式
     * @apiParam {string} name            服务名称
     * @apiParam {float} duration         耗时
     * @apiParam {float} market_price     市场价
     * @apiParam {float} price            当美业师添加个性化服务时，不选择预定金服务，该字段就是会员价格，当选择预定金服务时，就是预定金价格
     * @apiParam {int} circumstances_service   是否选择预定金服务 1否 2是
     * @apiParam {float} shop_price   到店付价格  选择预定金服务才存在
     * @apiParam {string} description     图文详情
     *
     *
     */
    public function ysj_tj(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }
//http://qiaocat.oss-cn-shenzhen.aliyuncs.com/20170804181638_268120196.jpeg,http://qiaocat.oss-cn-shenzhen.aliyuncs.com/20170804181642_553964901.jpeg
        //获取传过来的所有主图片的路径
        $images = input('pic_path');
        $datass['images'] = $images;
        $slu = input('thumb');
        $ss = explode(',',$slu);
        $datass['thumb'] = $ss[0];

        //组装添加的数据
        $datass['cate_id'] = input('cate_id');
        $datass['cate_id_2'] = input('cate_id_2');
        $datass['service_form'] = input('service_form');
        $datass['name'] = input('name');
        $datass['duration'] = input('duration');
        $datass['market_price'] = input('market_price');
        $datass['price'] = input('price');
        $datass['new_pic_path'] = input('new_pic_path');
        //$datass['new_details'] = input('new_details');
        $datass['description'] = input('description');
        //预定金服务
        $circumstances_service = input('circumstances_service');
        if($circumstances_service == 2){
            $datass['circumstances_service'] = 2;
            //到店付价格
            $datass['shop_price'] = input('shop_price');
        }

        //服务的状态
        if(input('service_type') == 11){
            $datass['online'] = 4; //该服务为保存的状态
        }else{
            $datass['online'] = 2;   //该服务为待审核的状态
        }

        //修改的服务的id
        $service_id = input('id');
        
        //字段验证
        $validate = validate('ServiceValidate');
        if(!$validate->check($datass)){
            return json(['status'=>'error','msg'=>$validate->getError()]);
        }

        try {
            //将该服务的信息修改
            Db::name('product')->where('id',$service_id)->update($datass);
            //将美业师对应的该服务状态进行修改
            $map['stylist_id'] = $id;
            $map['product_id'] = $service_id;
            if(input('service_type') == 11){
                Db::name('stylist_service')->where($map)->update(['online' => 4,'cate_id' => $datass['cate_id'],'cate_id_2' => $datass['cate_id_2']]);
                return json(['status'=>'ok','msg'=>'保存成功']);
            }else{
                Db::name('stylist_service')->where($map)->update(['online' => 2]);
                return json(['status'=>'ok','msg'=>'修改成功']);
            }
        }catch (\Throwable $e) {
            if(input('service_type') == 11){
                return json(['status'=>'error','msg'=>'保存失败']);
            }else{
                return json(['status'=>'error','msg'=>'修改失败']);
            }
        }


    }


    //已上架服务，点击“下架”接口 
    /**
     * @api {post} dresser/dr_ysj_shelves 下架接口[dresser/dr_ysj_shelves]
     * @apiVersion 2.0.0
     * @apiName dr_ysj_shelves
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_ysj_shelves
     *
     *@apiParam {int} service_id         修改的服务id
     */
    public function ysj_shelves(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        $service_id = input('service_id');
        //查询出该服务是属于个人还是平台的，个人的需要同步
        $type_user = Db::name('product')->where(['id' => $service_id])->value('type_user');
        $map['stylist_id'] = $id;
        $map['product_id'] = $service_id;
        try {
            if($type_user == 1){ //个人的服务需要同步
                Db::name('product')->where(['id' => $service_id])->update(['online' => 0]);
            }
                Db::name('stylist_service')->where($map)->update(['online' => 0]);
                return json(['status'=>'ok','msg'=>'下架成功']);
        } catch (\Throwable $e) {
                return json(['status'=>'error','msg'=>'下架失败']);
        }


    }



    //已上架服务，“取消审核”的接口  取消审核到以保存
    /**
     * @api {post} dresser/dr_ysj_qxsh 取消审核接口[dresser/dr_ysj_qxsh]
     * @apiVersion 2.0.0
     * @apiName dr_ysj_qxsh
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_ysj_qxsh
     *
     *@apiParam {int} service_id         修改的服务id
     */
    public function ysj_qxsh(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }


        $service_id = input('service_id');
        //$id = 324251115;
        //$service_id = 1000057;
        //查询出该服务是属于个人还是平台的，个人的需要同步
        $type_user = Db::name('product')->where(['id' => $service_id])->value('type_user');
        $map['stylist_id'] = $id;
        $map['product_id'] = $service_id;
        //$type = 1;
        try {
            if($type_user == 1){ //个人的服务需要同步
                Db::name('product')->where(['id' => $service_id])->update(['online' => 4]);
            }
                Db::name('stylist_service')->where($map)->update(['online' => 4]);
                return json(['status'=>'ok','msg'=>'取消审核成功']);
        } catch (\Throwable $e) {
                return json(['status'=>'error','msg'=>'取消审核失败']);
        }


    }



    //点击“删除”接口
    /**
     * @api {post} dresser/dr_btg_del 删除服务接口[dresser/dr_btg_del]
     * @apiVersion 2.0.0
     * @apiName dr_btg_del
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_btg_del
     *
     *@apiParam {int} service_id         删除的服务id
     */
    public function btg_del(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //$id = 324251115;
        //$service_id = 1000057;
        $service_id = input('service_id');
        //查询出该服务是属于个人还是平台的，个人的需要同步
        $type_user = Db::name('product')->where(['id' => $service_id])->value('type_user');
        $map['stylist_id'] = $id;
        $map['product_id'] = $service_id;
        $date_time = date('Y-m-d H:i:s');
        try {
            if($type_user == 1){ //个人的服务需要同步
                Db::name('product')->where(['id' => $service_id])->update(['deleted_at' => $date_time]);
            }
            Db::name('stylist_service')->where($map)->update(['is_del' => 1]);
            return json(['status'=>'ok','msg'=>'删除成功']);
        } catch (\Throwable $e) {
            return json(['status'=>'error','msg'=>'删除失败']);
        }


    }


    //点击“提交审核”接口
    /**
     * @api {post} dresser/dr_service_shelves 提交审核服务接口[dresser/dr_service_shelves]
     * @apiVersion 2.0.0
     * @apiName dr_service_shelves
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_service_shelves
     *
     *@apiParam {int} service_id         上架的服务id
     */
    public function service_shelves(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //$id = 324251115;
        //$service_id = 1000062;
        $service_id = input('service_id');
        //查询出该服务是属于个人还是平台的，个人的需要同步
        $type_user = Db::name('product')->where(['id' => $service_id])->value('type_user');
        $map['stylist_id'] = $id;
        $map['product_id'] = $service_id;
        try {
            if($type_user == 1){ //个人的服务需要同步
                Db::name('product')->where(['id' => $service_id])->update(['online' => 2]);
            }
            Db::name('stylist_service')->where($map)->update(['online' => 2]);
            return json(['status'=>'ok','msg'=>'上架成功']);
        } catch (\Throwable $e) {
            return json(['status'=>'error','msg'=>'上架失败']);
        }


    }


    //点击“上架”接口
    /**
     * @api {post} dresser/dr_service_shangjia 上架服务接口[dresser/dr_service_shangjia]
     * @apiVersion 2.0.0
     * @apiName dr_service_shangjia
     * @apiGroup dresser_Service
     * @apiSampleRequest dresser/dr_service_shangjia
     *
     *@apiParam {int} service_id         上架的服务id
     */
    public function service_shangjia(){
        //判断是否是正常的用户登录
        if(if_cookie()==false){
            return json(['status'=>'error','code' => -1,'msg'=>get_msg(-1)]);
        }else{
            $id = get_cookie()['id'];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res==null){
                return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
            }
        }

        if(if_meiye() == false){
            return json(['status'=>'error','code' => -2,'msg'=>get_msg(-2)]);
        }

        //$id = 324251115;
        //$service_id = 1000062;
        $service_id = input('service_id');
        //查询出该服务是属于个人还是平台的，个人的需要同步
        $type_user = Db::name('product')->where(['id' => $service_id])->value('type_user');
        $map['stylist_id'] = $id;
        $map['product_id'] = $service_id;
        try {
            if($type_user == 1){ //个人的服务需要同步
                Db::name('product')->where(['id' => $service_id])->update(['online' => 1]);
            }
            Db::name('stylist_service')->where($map)->update(['online' => 1]);
            return json(['status'=>'ok','msg'=>'上架成功']);
        } catch (\Throwable $e) {
            return json(['status'=>'error','msg'=>'上架失败']);
        }


    }











}