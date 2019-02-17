<?php
namespace app\dresser\controller;
use think\Controller;
use think\Db;

/**
 * @美业师个人中心类
 */
class User extends Controller{
    
    
    /**
     * @api {post} dresser/dr_data 全局统一返回美业师信息[dresser/dr_data]
     * @apiVersion 2.0.0
     * @apiName dr_data
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_data
     *
     * @apiSuccess {int} is_check 返回状态  1代表已审核，跳到店铺首页或其他首页，2代表待审核，跳到查看进度，
     *                            3为审核不通过，跳到查看进度，给重新完善资料入口，4已完善资料未申请店铺
     *                            5新用户未完善资料
     * @apiSuccess {int} id    美业师id
     * @apiSuccess {string} type    技术类型
     * @apiSuccess {string} real_name    美业师真实姓名
     * @apiSuccess {int} sex    美业师性别   1男2女                      
     * @apiSuccess {int} store_type    1为个人店铺，2为机构店铺
     * @apiSuccess {int} is_business    1不营业，2营业
     * @apiSuccess {int} is_online      1不在线，2在线
     * @apiSuccess {int} up_store       0不提供，1提供                   
     *                                                                            
     */
    public function dr_data(){
        if(if_cookie()==true){
            $field = ['id','type','real_name','sex','is_check','store_type','is_business','is_online','up_store'];
            $data = Db::name('stylist')->where('id',get_cookie()['id'])->field($field)->find();
            if($data){
              return json(['status'=>'ok','data'=>$data]);
            }else{
                $data['id']=get_cookie()['id'];
                $data['is_check']=5;
              return json(['status'=>'ok','data'=>$data]);
            }
        }else{
           return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_set_skill_type 修改美业师技术类型[dresser/dr_set_skill_type]
     * @apiVersion 2.0.0
     * @apiName dr_set_skill_type
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_set_skill_type
     *
     * @apiParam {string} type    技术类型，多个用','分开
     */
    public function set_skill_type(){
        if(if_cookie()==true){
           $type = input('type');
           if(empty($type)==true){return json(['status'=>'error','msg'=>'请选择技术类型']);}
           Db::name('stylist')->where('id',get_cookie()['id'])->setField('type',$type);
           return json(['status'=>'ok','msg'=>'修改成功']);
        }else{
           return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_get_apply 美业师重新申请获取之前输入的信息[dresser/dr_get_apply]
     * @apiVersion 2.0.0
     * @apiName dr_get_apply
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_get_apply
     *
     */
    public function get_apply(){
        if(if_cookie()==true){
           $data=Db::name('stylist')->where('id',get_cookie()['id'])->find(); 
           if($data){
             $data['alipay']=Db::name('stylist_wallet')->where(['stylist_id'=>get_cookie()['id'],'type'=>2])->value('account_id');
             return json(['status'=>'ok','data'=>$data]);
           }else{
             return json(['status'=>'ok','data'=>[]]);
           }
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_share_info 二维码分享获取美业师信息[dresser/dr_share_info]
     * @apiVersion 2.0.0
     * @apiName dr_share_info
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_share_info
     *
     * @apiParam {int} id 美业师id
     */
    public function share_info(){
        $id = input('id');
        $data = Db::name('stylist')->where('id',$id)->field(['real_name','user_img'])->find();
        if($data){
            return json(['status'=>'ok','data'=>$data]);
        }else {
            return json(['status'=>'ok','data'=>[]]);
        }
    }
    
    /**
     * @api {post} dresser/dr_store_index 店铺首页[dresser/dr_store_index]
     * @apiVersion 2.0.0
     * @apiName dr_store_index
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_store_index
     *
     * @apiSuccess {int} is_business 返回状态  1暂停，2营业
     * @apiSuccess {int} id 返回状态  美业师id
     * @apiSuccess {string} real_name 美业师真实姓名
     * @apiSuccess {int} sex 美业师性别 1为男 2为女
     * @apiSuccess {string} user_img 美业师头像
     * @apiSuccess {int} work_years  美业师工作开始年限
     * @apiSuccess {int} level 返回状态 美业师等级
     * @apiSuccess {int} store_type 返回状态  1个人店铺，2机构店铺
     * @apiSuccess {int} order_sum 接单数
     * @apiSuccess {int} order_rate 接单率
     * @apiSuccess {int} fans  美业师关注数
     *                            
     */
    public function store_index(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
         $id = get_cookie()['id'];
         $field=['id','is_business','real_name','sex','user_img','work_years','exp_value','store_type'];
         $data=Db::name('stylist')->where('id',$id)->field($field)->find();
         $data['order_sum'] = Successful_order($id);
         $data['order_rate'] = rate($id);
         $data['fans'] = Db::name('user_attention_stylist')->where('stylist_id',$id)->count();
         $data['level'] = stylist_level($data['exp_value']);
         
         return json(['status'=>'ok','data'=>$data]);
         
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    
    
    /**
     * @api {post} dresser/dr_set_business 设置店铺营业暂停[dresser/dr_set_business]
     * @apiVersion 2.0.0
     * @apiName dr_set_business
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_set_business
     * 
     * @apiParam {int} is_business    传 1暂停   2营业
     */
    public function set_business(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $business= input('is_business');
            if($business==1 || $business==2){
                Db::name('stylist')->where('id',get_cookie()['id'])->setField('is_business',$business);
                return json(['status'=>'ok','msg'=>'设置成功']);
            }else{
                return json(['status'=>'error','msg'=>'传参错误']);
            }
        }else{
           return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} dresser/dr_schedule 美业师申请进度[dresser/dr_schedule]
     * @apiVersion 2.0.0
     * @apiName dr_schedule
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_schedule
     * 
     * @apiSuccess {string} user_time  注册时间
     * @apiSuccess {string} created_at 完善资料时间
     * @apiSuccess {string} updated_at 申请店铺时间
     * @apiSuccess {string} is_check   申请状态
     * @apiSuccess {string} reason  审核返回的信息
     */
    public function schedule(){
        if(if_cookie()==true){
            $id = get_cookie()['id'];
            $time = Db::name('user')->where('id',$id)->value('create_time');
            $info = Db::name('stylist')->where('id',$id)->field(['created_at','updated_at','is_check','reason'])->find();
            $info['user_time']=$time;
            return json(['status'=>'ok','data'=>$info]);
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} dresser/dr_user_info 美业师个人资料[dresser/dr_user_info]
     * @apiVersion 2.0.0
     * @apiName dr_user_info
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_user_info
     */
    public function user_info(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $field=['user_img','real_name','nick','sex','type','user_good','wechat_no','address'];
            $data=Db::name('stylist')->where('id',get_cookie()['id'])->field($field)->find();
            return json(['status'=>'ok','data'=>$data]);
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    /**
     * @api {post} dresser/dr_edit_info 美业师个人资料修改[dresser/dr_edit_info]
     * @apiVersion 2.0.0
     * @apiName dr_edit_info
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_edit_info
     * 
     * @apiParam {string} user_img    头像
     * @apiParam {string} nick    昵称
     * @apiParam {int} sex    性别
     * @apiParam {string} user_good    擅长
     * @apiParam {string} wechat_no    微信号
     */
    public function edit_info(){
       if(if_cookie()==true){
           if(if_meiye()==false){
               return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $id = get_cookie()['id'];
            $user_img=input('user_img');
            $nick = input('nick');
            $sex=input('sex');
            $user_good=input('user_good');
            $wechat_no=input('wechat_no');
            $data=['user_img'=>$user_img,'sex'=>$sex,'user_good'=>$user_good,
                   'wechat_no'=>$wechat_no,'nick'=>$nick
                  ];
            $validate = validate('EditInfo');
            if(!$validate->check($data)){
                return json(['status'=>'error','msg'=>$validate->getError()]);
            }
            
            try {
                Db::name('stylist')->where('id',$id)->update($data);
                return json(['status'=>'ok','msg'=>'修改成功']);
            } catch (\Throwable $e) {
                return json(['status'=>'error','msg'=>'修改失败,请重试']);
            }  
            
       }else{
           return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
       }
    }
    
    /**
     * @api {post} dresser/dr_user_index 美业师店铺设置页[dresser/dr_user_index]
     * @apiVersion 2.0.0
     * @apiName dr_user_index
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_user_index
     */
    public function user_index(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $id = get_cookie()['id'];
            $field=['store_name','intro','advance','business_start','business_end',
                    'business_week','province_id','city_id','area_id',
                    'street_id','agency','up_store','store_add','store_type'
                   ];
            $data=Db::name('stylist')->where('id',$id)->field($field)->find();
            $street = Db::name('stylist')->where('id',$id)->value('street_id');
            $arr = explode(',',$street);
            $array='';
            foreach ($arr as $v){
                $name= Db::name('location_street')->where('street_id',$v)->value('name');
                $array= $array.','.$name;
            }
            $str = trim($array,',');
            $agency_name = Db::name('stylist')->where('id',$data['agency'])->value('store_name');
            $city_name = Db::name('location_city')->where('city_id',$data['city_id'])->value('name');
            return json(['status'=>'ok','data'=>$data,'info'=>['street_name'=>$str,'agency_name'=>$agency_name,'city_name'=>$city_name]]);
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    /**
     * @api {post} dresser/dr_edit_store 美业师店铺设置[dresser/dr_edit_store]
     * @apiVersion 2.0.0
     * @apiName dr_edit_store
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_edit_store
     *
     * @apiParam {string} store_name    店铺名称
     * @apiParam {string} intro    店铺介绍
     * @apiParam {string} advance    提前预约(暂时不传)
     * @apiParam {string} business_start  营业开始时间
     * @apiParam {string} business_end    营业结束时间
     * @apiParam {string} business_week    营业工作日  1,2,3  这种形式传入
     * @apiParam {int} province_id     省份
     * @apiParam {int} city_id    城市
     * @apiParam {int} area_id    区，（有就发没有就不发）
     * @apiParam {string} street_id    服务范围商圈id 用,号分开
     * @apiParam {string} agency    所属美容机构的id(个人店铺可以选，本身为机构店铺不显示这项也不传)
     * @apiParam {int} up_store    是否提供到店服务 0否 1是
     * @apiParam {string} store_add   实体店地址
     */
     public function edit_store(){
      if(if_cookie()==true){
          if(if_meiye()==false){
              return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
          }
          $store_name= input('store_name');
          $intro = input('intro');
          $advance = 3;
          $business_start= input('business_start');
          $business_end= input('business_end');
          $business_week= input('business_week');
          $province_id = input('province_id');
          $city_id = input('city_id');
          $area_id = input('area_id')?input('area_id'):0;
          $street_id = input('street_id');
          $agency = input('agency')?input('agency'):0;
          $up_store = input('up_store');
          $store_add= input('store_add')?input('store_add'):'';
          $data=['store_name'=>$store_name,'intro'=>$intro,'advance'=>$advance,'business_start'=>$business_start,
                 'business_end'=>$business_end,'business_week'=>$business_week,
                 'province_id'=>$province_id,'city_id'=>$city_id,'area_id'=>$area_id,
                 'street_id'=>$street_id,'agency'=>$agency,'up_store'=>$up_store,'store_add'=>$store_add
                ];
          $validate = validate('EditStore');
          if(!$validate->check($data)){
              return json(['status'=>'error','msg'=>$validate->getError()]);
          }
          
          try {
            Db::name('stylist')->where('id',get_cookie()['id'])->update($data);
            return json(['status'=>'ok','msg'=>'修改成功']);
          } catch (\Throwable $e) { 
            return json(['status'=>'error','msg'=>'修改失败,请重试']);
          }  
         
      }else{
          return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
      }
        
     }
    
    /**
     * @api {post} dresser/dr_get_busy  获取忙时时间[dresser/dr_get_busy]
     * @apiVersion 2.0.0
     * @apiName dr_get_busy
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_get_busy
     *
     */
     public function get_busy(){
         if(if_cookie()==true){
             $busy = Db::name('stylist')->where('id',get_cookie()['id'])->value('busy_time');
             return json(['status'=>'ok','data'=>$busy]);
         }else{
           return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
         }
        
     }
     
    /**
     * @api {post} dresser/dr_set_busy  美业师忙时设置[dresser/dr_set_busy]
     * @apiVersion 2.0.0
     * @apiName dr_set_busy
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_set_busy
     *
     * @apiParam {string} busy    忙时时间
     * 
     */
     public function set_busy(){
        if(if_cookie()==true){
            $busy = input('busy');
            Db::name('stylist')->where('id',get_cookie()['id'])->setField('busy_time',$busy);
            return json(['status'=>'ok','msg'=>'设置成功']);
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
     }

     /**
      * @api {post} dresser/dr_get_fans  美业师获取粉丝列表[dresser/dr_get_fans]
      * @apiVersion 2.0.0
      * @apiName dr_get_fans
      * @apiGroup dresser_User
      * @apiSampleRequest dresser/dr_get_fans
      *
      * @apiParam {int} page_no    第几页
      * @apiParam {int} per_page    一页几条
      */
    public function get_fans(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $page_no  = input('page_no')?input('page_no'):1;
            $per_page = input('per_page')?input('per_page'):20;
            $data = Db::name('user_attention_stylist')->alias('a')->where(['a.stylist_id'=>get_cookie()['id'],'a.is_attent'=>1])
                    ->field(['b.nick','b.avatar','a.created_at'])
                    ->join('user b','a.user_id = b.id','INNER')
                    ->page($page_no,$per_page)
                    ->order('a.created_at','desc')
                    ->select();
            return json(['status'=>'ok','data'=>$data]);
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_get_invitation  我邀请的[dresser/dr_get_invitation]
     * @apiVersion 2.0.0
     * @apiName dr_get_invitation
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_get_invitation
     *
     * @apiParam {int} page_no    第几页
     * @apiParam {int} per_page    一页几条
     * @apiParam {int} type     查全部不传，查签约用户传2，查注册用户传1
     */
    public function get_invitation(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $id = get_cookie()['id'];
            $page_no  = input('page_no')?input('page_no'):1;
            $per_page = input('per_page')?input('per_page'):20;
            $type = input('type');
            if($type==2 || $type==1)
            {
                $map['b.is_dresser']=$type;
            }else {
                $map=[];
            }
          
            //总人数
            $sum = Db::name('user_invitation')->where('inviter_id',$id)->count();
             
            //已签约人数(美业师)
            $qy = Db::name('user_invitation')->alias('a')->where(['a.inviter_id'=>$id])
                  ->join('stylist b','a.invitee_id = b.id','INNER')
                  ->count();
            //仅注册用户人数
            $user = $sum - $qy;
            $data = Db::name('user_invitation')->alias('a')->where('a.inviter_id',$id)->where($map)
                    ->join('user b','a.invitee_id = b.id','INNER')
                    ->join('stylist c','a.invitee_id = c.id','LEFT')
                    ->field(['b.mobile','c.real_name','b.avatar','c.is_check'])
                    ->page($page_no,$per_page)
                    ->order('a.created_at','desc')
                    ->select();
            return json(['status'=>'ok','sum'=>$sum,'qy'=>$qy,'user'=>$user,'data'=>$data]);
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
    }
    
    /**
     * @api {post} dresser/dr_get_qrcode  我的二维码[dresser/dr_get_qrcode]
     * @apiVersion 2.0.0
     * @apiName dr_get_qrcode
     * @apiGroup dresser_User
     * @apiSampleRequest dresser/dr_get_qrcode
     *
     */
    public function get_qrcode(){
        if(if_cookie()==true){
            if(if_meiye()==false){
                return json(['status'=>'error','code'=>-2,'msg'=>get_msg(-2)]);
            }
            $data = Db::name('stylist')->where('id',get_cookie()['id'])
                    ->field(['id','real_name','user_img','level'])
                    ->find();
            //图片保存路径
            $save_path = config('conf.qrcode').'/'.$data['id'].'/';
            //二维码要跳转的网址路径带参数
            $qr_data = config('conf.qrcode_url').'?id='.$data['id'].'&from=5';
            $code =controller('common/PHPqrcode','method')->createQRcode($save_path,$qr_data);
            //下载的用户头像保存名字
            $file_path = $save_path.$data['id'].'_toubu.png';
            $user_avatar=$data['user_img'];
            //如果美业师没有头像，那就用默认头像
            if(empty($user_avatar) || $user_avatar==''){
               $user_avatar=config('conf.user_avatar');
            }
            //如果老数据头像地址是相对路径，就拼接域名
            if(stristr($user_avatar,'http')===false){
                $user_avatar=config('conf.domain_name').$user_avatar;
            }
            
            try {
              $content = file_get_contents($user_avatar);
            }catch (\Throwable $e) { 
              $content = file_get_contents(config('conf.user_avatar'));
            }  
           
            file_put_contents($file_path, $content);
            $image = \think\Image::open($file_path);
            //把头像按比例缩放并覆盖原来的图片
            $image->thumb(180, 180)->save($file_path);
            //打开底部图片
            $img = \think\Image::open(config('conf.dibu'));
            //定义最终生成的二维码合成图片的名字
            $user_img = $save_path.$data['id'].'_qrcode.png';
            //进行图片合成
            $img->water($file_path,[132,330])
                ->water($save_path.$code,[363,554])
                ->text($data['real_name'],ROOT_PATH.'/public/static/font/simhei.ttf',30,'#000000',[443,426])
                ->save($user_img);
            //将最终合成的图片上传到阿里云OSS服务器上
            $url = controller('common/UploadOss','method')->upload_oss($data['id'].'_qrcode.png',$user_img);
            if($url['status']=='ok'){
                return json(['status'=>'ok','data'=>$data,'url'=>$url['data']]);
            }else{
                return json(['status'=>'error','msg'=>$url['msg']]);
            }
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    
    
    
    
    
    
    
}