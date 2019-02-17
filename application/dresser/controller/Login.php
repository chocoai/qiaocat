<?php
namespace app\dresser\controller;
use think\Controller;
use think\Db;

/**
*美业师注册登录接口
*/

class Login extends Controller{
    
    

    /**
     * @api {post} dresser/dr_add_data 美业师完善资料[dresser/dr_add_data]
     * @apiVersion 2.0.0
     * @apiName dr_add_data
     * @apiGroup dresser_Login
     * @apiSampleRequest dresser/dr_add_data
     *
     * @apiParam {string} user_img    头像
     * @apiParam {string} nick    昵称
     * @apiParam {int} sex   性别
     * @apiParam {string} type    技术类型
     * @apiParam {string} user_good   擅长
     * @apiParam {string} weixin   微信号
     * @apiParam {string} where_add   所在城市
     */
    public function add_data(){
        if(if_cookie()==true){
            if(meiye_status()==true){
                return json(['status'=>'error','msg'=>'你已经完善了资料，请勿重复提交']);
            }
            $user_img = input('user_img');
            $nick= input('nick');
            $sex = input('sex');
            $type = input('type');
            $user_good= input('user_good');
            $weixin = input('weixin');
            $where_add= input('where_add');
            $val=['user_img'=>$user_img,'nick'=>$nick,'sex'=>$sex,'type'=>$type,'wechat_no'=>$weixin,
                  'user_good'=>$user_good, 'weixin'=>$weixin,'where_add'=>$where_add
                 ];
            $validate = validate('AddData');
            if(!$validate->check($val)){
                return json(['status'=>'error','msg'=>$validate->getError()]);
            }
            $id = get_cookie()['id'];
            $mobile= Db::name('user')->where('id',$id)->value('mobile');
            //根据技术类型计算服务保证金
            $bond=controller('common/Bond','method')->set_bond($type);
            
            $data=[ 'id'=>$id,'type'=>$type,'type_tmp'=>$type,'real_name'=>'',
                    'nick'=>$nick,'sex'=>$sex,'email'=>'','mobile'=>$mobile,'user_img'=>$user_img,
                    'work_years'=>'','intro'=>'','address'=>'','idcard'=>'','is_check'=>4,
                    'idcard_img'=>'','stylist_service_bond'=>$bond,'reason'=>'','created_at'=>date('Y-m-d H:i:s',time()),
                    'online_at'=>'','updated_at'=>'','cma_img'=>'',
                    'honor'=>'','trained_experience'=>'','work_experience'=>'','birthday'=>'',
                    'weixin'=>$weixin,'contract_no'=>'','stylist_certificate_sn'=>'',
                    'wechat_no'=>$weixin,'autograph_img'=>'','user_good'=>$user_good,'where_add'=>$where_add
                  ];
            $res = Db::name('stylist')->where('id',$id)->find();
            if($res){
              Db::name('stylist')->where('id',$id)->update($val);
            }else{
              Db::name('stylist')->insert($data);
              Db::name('user')->where('id',$id)->setField('is_dresser',2);
            }
                  
            return json(['status'=>'ok','msg'=>'提交成功']);
            
        }else{
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
         
    }
    
    
    /**
     * @api {post} dresser/dr_user_store 美业师申请个人店铺[dresser/dr_user_store]
     * @apiVersion 2.0.0
     * @apiName dr_user_store
     * @apiGroup dresser_Login
     * @apiSampleRequest dresser/dr_user_store
     *
     * @apiParam {string} store_name    店铺名称
     * @apiParam {string} real_name    真实姓名
     * @apiParam {string} alipay    支付宝账号
     * @apiParam {string} idcard    个人身份证号码
     * @apiParam {string} idcard_hand  手持身份证图片
     * @apiParam {string} idcard_img  身份证图片
     * @apiParam {string} agency   所属美容机构(无机构传0)
     * @apiParam {string} certificate   认证证书
     * @apiParam {string} ccc   发证机构
     * @apiParam {int} province_id     省份
     * @apiParam {int} city_id    城市
     * @apiParam {int} area_id    区，（有就发没有就不发）
     * @apiParam {int} up_store    是否提供顾客到店服务0不提供，1提供
     * @apiParam {string} store_add   实体店地址
     * @apiParam {string} work_years    工作起始年限
     * @apiParam {string} intro   个人介绍
     * @apiParam {string} photo   作品图片
     * @apiParam {string} autograph_img   客户签名
     */
    public function user_store(){
        if(if_cookie()==true){
            if (meiye_status()==true){
                return json(['status'=>'error','msg'=>'你已申请过店铺，请勿重复申请']);
            }
            $store_name = input('store_name');
            $real_name = input('real_name');
            $alipay = input('alipay');
            $idcard = input('idcard');
            $idcard_hand=input('idcard_hand');
            $idcard_img= input('idcard_img');
            $agency = input('agency')?input('agency'):0;
            $certificate= input('certificate')?input('certificate'):'';
            $ccc=input('ccc')?input('ccc'):'';
            $province_id = input('province_id');
            $city_id = input('city_id');
            $area_id = input('area_id')?input('area_id'):0;
            $up_store = input('up_store');
            $store_add = input('store_add')?input('store_add'):'';
            $work_years = input('work_years');
            $intro= input('intro');
            $photo= input('photo');
            $autograph_img =input('autograph_img');
            if($area_id==0 || empty($area_id)){
               $street_id = get_street($city_id);
            }else{
               $street_id = get_street($area_id);
            }
            $time = date('Y-m-d H:i:s',time());
            $data = ['store_name'=>$store_name,'real_name'=>$real_name,'idcard_hand'=>$idcard_hand,'updated_at'=>$time,
                     'idcard_img'=>$idcard_img,'idcard'=>$idcard,'agency'=>$agency,'certificate'=>$certificate,
                     'province_id'=>$province_id,'city_id'=>$city_id,'area_id'=>$area_id,'street_id'=>$street_id,
                     'ccc'=>$ccc,'up_store'=>$up_store,'store_type'=>1,'store_add'=>$store_add,'is_check'=>2,
                     'work_years'=>$work_years,'intro'=>$intro,'photo'=>$photo,'autograph_img'=>$autograph_img,
                    ];
            $validate = validate('UserStore');
            if(!$validate->check($data)){
                return json(['status'=>'error','msg'=>$validate->getError()]);
            }
            
            if(empty($alipay)==true){
                return json(['status'=>'error','msg'=>'支付宝账号不能为空']);
            }
            //把支付宝插入美业师账户表中
            $uid = get_cookie()['id'];
            $res=Db::name('stylist_wallet')->where(['stylist_id'=>$uid,'type'=>2])->find();
            $wallet=['stylist_id'=>$uid,'type'=>2,'account_name'=>$real_name,'bank_name'=>'支付宝',
                     'account_id'=>$alipay,'created_at'=>$time,'updated_at'=>'','deleted_at'=>''
                    ];
            
            Db::startTrans();
            try {
                Db::name('stylist')->where('id',$uid)->update($data);
                $photo_arr = explode('|',$photo);
                foreach ($photo_arr as $v){
                  if(empty($v)==false){
                      $arr=['stylist_id'=>$uid,'pic_url'=>$v,'description'=>'作品图片'];
                      Db::name('stylist_show_product')->insert($arr);
                  }
                }
                if($res){
                   Db::name('stylist_wallet')->where('stylist_id',$uid)->setField('account_id',$alipay);
                }else{
                   Db::name('stylist_wallet')->insert($wallet);
                }
                Db::commit();
                return json(['status'=>'ok','msg'=>'申请成功']);
            } catch (\Throwable $e) {
                Db::rollback();
                return json(['status'=>'error','msg'=>'申请失败,请重试']);
            }  
            
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    /**
     * @api {post} dresser/dr_agency_store 美业师申请机构店铺[dresser/dr_agency_store]
     * @apiVersion 2.0.0
     * @apiName dr_agency_store
     * @apiGroup dresser_Login
     * @apiSampleRequest dresser/dr_agency_store
     * 
     * @apiParam {string} store_name    店铺名称
     * @apiParam {string} license  营业执照
     * @apiParam {string} real_name    真实姓名
     * @apiParam {string} alipay    支付宝账号
     * @apiParam {string} idcard    法人代表身份证号码
     * @apiParam {string} idcard_img  法人代表身份证
     * @apiParam {int} plastic   是否开整形类手术，1开，0不开
     * @apiParam {string} doctor_licence   医疗卫生执业许可证
     * @apiParam {int} province_id     省份
     * @apiParam {int} city_id    城市
     * @apiParam {int} area_id    区，（有就发没有就不发）
     * @apiParam {string} aptitude   机构资质
     * @apiParam {string} store_add   机构地址
     * @apiParam {string} intro   机构介绍
     * @apiParam {string} photo   作品图片
     * @apiParam {string} autograph_img   客户签名
     */ 
    public function agency_store(){
        if(if_cookie()==true){
            if (meiye_status()==true){
                return json(['status'=>'error','msg'=>'你已申请过店铺，请勿重复申请']);
            }
            $store_name = input('store_name');
            $license = input('license');
            $real_name = input('real_name');
            $alipay = input('alipay');
            $idcard = input('idcard');
            $idcard_img= input('idcard_img');
            $plastic= input('plastic');
            $doctor_licence = input('doctor_licence')?input('doctor_licence'):'';
            $province_id = input('province_id');
            $city_id = input('city_id');
            $area_id = input('area_id')?input('area_id'):0;
            $aptitude = input('aptitude');
            $store_add = input('store_add');
            $intro= input('intro');
            $photo= input('photo');
            $autograph_img =input('autograph_img');
            if($area_id==0 || empty($area_id)){
                $street_id = get_street($city_id);
            }else{
                $street_id = get_street($area_id);
            }
            $time = date('Y-m-d H:i:s',time());
            $data = ['store_name'=>$store_name,'license'=>$license,'real_name'=>$real_name,'updated_at'=>$time,
                     'idcard'=>$idcard,'plastic'=>$plastic,'idcard_img'=>$idcard_img,'is_check'=>2,
                     'province_id'=>$province_id,'city_id'=>$city_id,'area_id'=>$area_id,'street_id'=>$street_id,
                     'doctor_licence'=>$doctor_licence,'aptitude'=>$aptitude,'store_add'=>$store_add,
                     'intro'=>$intro,'photo'=>$photo,'autograph_img'=>$autograph_img,'store_type'=>2
                    ];
            $validate = validate('AgencyStore');
            if(!$validate->check($data)){
                return json(['status'=>'error','msg'=>$validate->getError()]);
            }
            
            if(empty($alipay)==true){
                return json(['status'=>'error','msg'=>'支付宝账号不能为空']);
            }
            //把支付宝插入美业师账户表中
            $uid = get_cookie()['id'];
            $res=Db::name('stylist_wallet')->where(['stylist_id'=>$uid,'type'=>2])->find();
            $wallet=['stylist_id'=>$uid,'type'=>2,'account_name'=>$real_name,'bank_name'=>'支付宝',
                     'account_id'=>$alipay,'created_at'=>$time,'updated_at'=>'','deleted_at'=>''
                    ];
             
            Db::startTrans();
            try {
                Db::name('stylist')->where('id',$uid)->update($data);
                $photo_arr = explode('|',$photo);
                foreach ($photo_arr as $v){
                    if(empty($v)==false){
                        $arr=['stylist_id'=>$uid,'pic_url'=>$v,'description'=>'作品图片'];
                        Db::name('stylist_show_product')->insert($arr);
                    }
                }
                if($res){
                    Db::name('stylist_wallet')->where('stylist_id',$uid)->setField('account_id',$alipay);
                }else{
                    Db::name('stylist_wallet')->insert($wallet);
                }
                Db::commit();
                return json(['status'=>'ok','msg'=>'申请成功']);
            } catch (\Throwable $e) {
                Db::rollback();
                return json(['status'=>'error','msg'=>'申请失败,请重试']);
            }  
            
        }else {
            return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
        }
        
    }
    
    
    //验证码验证
    public function val_code($mobile,$code){
        $validate = validate('ComValidate');
        $data=['mobile'=>$mobile,'code'=>$code];
        if(!$validate->check($data)){
            return ['status'=>'error','msg'=>$validate->getError()];
        }
        $res = Db::name('hzsabc_send_code')->where('mobile',$mobile)->where('status',1)->order('create_time','desc')->find();
        if($code!=$res['code']){
            return ['status'=>'error','msg'=>'验证码错误'];
        }
        $time_cha=time()-$res['create_time'];
        if($time_cha>180){
            Db::name('hzsabc_send_code')->where('id',$res['id'])->delete();
            return ['status'=>'error','msg'=>'验证码已过期'];
        }
        //删除已经验证完成的验证码
        Db::name('hzsabc_send_code')->where('id',$res['id'])->delete();
        return ['status'=>'ok'];
    }
    
   
}