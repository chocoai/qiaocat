<?php
namespace app\mon\controller;
use think\Controller;
use think\Db;

/**
 * 公共类
 */
class Login extends Controller{
    
        
        /**
         * @api {post} mon/mon_set_deviceid 设置用户登录最新设备id[mon/mon_set_deviceid]
         * @apiVersion 2.0.0
         * @apiName mon_set_deviceid
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_set_deviceid
         *
         * @apiParam {int} uid    用户id
         * @apiParam {string} device_id   设备id
         *
         */
        public function set_deviceid(){
          
               $uid = input('uid');
               $device_id = input('device_id');
               if(empty($uid)==true || empty($device_id)==true){
                 return json(['status'=>'error','msg'=>'参数不能为空']);
               }
           
               $res = Db::name('user')->where('id',$uid)->setField('device_id',$device_id);
               if($res){
                 return json(['status'=>'ok','msg'=>'设置成功']);
               }else{
                 return json(['status'=>'error','msg'=>'设置失败']);
               }
            
        }
    
        /**
         * @api {post} mon/mon_quick_login 快捷登录接口[mon/mon_quick_login]
         * @apiVersion 2.0.0
         * @apiName mon_quick_login
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_quick_login
         *
         * @apiParam {int} mobile    手机号
         * @apiParam {string} code   验证码
         * @apiParam {int} from   渠道来源 (来源是推广或分享必须传此项)
         * @apiParam {int} inviter_id   邀请者id (来源是推广或分享必须传此项)
         *
         */
        public function quick_login(){
            $mobile= input('mobile');
            $code  = input('code');
            $from = input('from')?input('from'):0;
            $inviter_id = input('inviter_id')?input('inviter_id'):0;
            $res = $this->val_code($mobile,$code);
            if($res['status']=='error'){
                return json(['status'=>'error','msg'=>$res['msg']]);
            }
            $info=Db::name('user')->where('mobile',$mobile)->find();
            //是用户直接登录，不是就注册
            if($info){
                set_cookie($info['id']);
                return json(['status'=>'ok','msg'=>'登录成功']);
            }else{
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $password= substr(str_shuffle(str_repeat($pool, 5)), 0, 16);
                $province=GetIpLookup()['region_id']?GetIpLookup()['region_id']:0;
                $city = GetIpLookup()['city_id']?GetIpLookup()['city_id']:0;
                $nick = substr_replace($mobile, '*****', 3, 5);
                $time = date('Y-m-d H:i:s',time());
                $data=[ 'email'=>$mobile.'@qiaocat.com','user_name'=>$nick,'nick'=>$nick,'password'=>md5($password),'real_name'=>$mobile,
                        'mobile'=>$mobile,'last_login_time'=>$time,'last_login_ip'=>getIp(),
                        'create_time'=>$time,'province_id'=>$province,'city_id'=>$city,'source'=>reg_source(),
                        'area_id'=>0,'address'=>0,'postcode'=>0,'telphone'=>$mobile,'birthday'=>0,'channel'=>$from,'avatar'=>config('conf.user_avatar'),
                        'tagids'=>0,'idcard'=>0,'ad_source'=>0,'updated_at'=>$time,'jd_token'=>0,'remember_token'=>0,
                        'career'=>0,'invate_id'=>0
                       ];
                
                try {
                    $id = Db::name('user')->insertGetId($data);
                    set_cookie($id);
                }catch (\Throwable $e) {
                    return json(['status'=>'error','msg'=>'注册失败']);
                }
                
                //执行推广记录
                if($from!=0 && $inviter_id!=0){
                    $res = Db::name('user')->where('id',$inviter_id)->find();
                    if($res){
                        $invite_code = strtoupper(dechex($inviter_id));
                        extension($id, $inviter_id,$invite_code,$time);
                    }
                }
                return json(['status'=>'ok','msg'=>'注册成功']);
            }
                
        }
            
        
    
        /**
         * @api {post} mon/mon_pass_reg 密码注册[mon/mon_pass_reg]
         * @apiVersion 2.0.0
         * @apiName mon_pass_reg
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_pass_reg
         *
         * @apiParam {int} mobile    手机号
         * @apiParam {string} code   验证码
         * @apiParam {string} password   密码
         * @apiParam {int} from   渠道来源  (来源是推广或分享必须传此项)
         * @apiParam {int} inviter_id   邀请者id (来源是推广或分享必须传此项)
         *
         */
        public function pass_reg(){
            $mobile= input('mobile');
            $code  = input('code');
            $password = input('password');
            $from = input('from')?input('from'):0;
            $inviter_id = input('inviter_id')?input('inviter_id'):0;
            $res = $this->val_code($mobile,$code);
            if($res['status']=='error'){
                return json(['status'=>'error','msg'=>$res['msg']]);
            }
            $info=Db::name('user')->where('mobile',$mobile)->find();
            if($info){
                return json(['status'=>'error','msg'=>'此账号已经被注册']);
            }else {
                if(strlen($password)<6||strlen($password)>20){
                    return json(['status'=>'error','msg'=>'密码长度在6到20之间']);
                }
                $province=GetIpLookup()['region_id']?GetIpLookup()['region_id']:0;
                $city = GetIpLookup()['city_id']?GetIpLookup()['city_id']:0;
                $nick = substr_replace($mobile, '*****', 3, 5);
                $time = date('Y-m-d H:i:s',time());
                $pass = md5($password);
                $data=[ 'email'=>$mobile.'@qiaocat.com','user_name'=>$nick,'nick'=>$nick,'password'=>$pass,'real_name'=>$mobile,
                        'mobile'=>$mobile,'last_login_time'=>$time,'last_login_ip'=>getIp(),'source'=>reg_source(),
                        'create_time'=>$time,'province_id'=>$province,'city_id'=>$city,
                        'area_id'=>0,'address'=>0,'postcode'=>0,'telphone'=>$mobile,'birthday'=>0,'channel'=>$from,'avatar'=>config('conf.user_avatar'),
                        'tagids'=>0,'idcard'=>0,'ad_source'=>0,'updated_at'=>$time,'jd_token'=>0,'remember_token'=>0,
                        'career'=>0,'invate_id'=>0
                       ];
                
               try {
                     $id = Db::name('user')->insertGetId($data);
                     set_cookie($id);
                }catch (\Throwable $e) { 
                   return json(['status'=>'error','msg'=>'注册失败']);
                }  
                
                //执行推广记录
                if($from!=0 && $inviter_id!=0){
                  $res = Db::name('user')->where('id',$inviter_id)->find();
                  if($res){
                      $invite_code = strtoupper(dechex($inviter_id));
                      extension($id, $inviter_id,$invite_code,$time);
                    }
                }
               return json(['status'=>'ok','msg'=>'注册成功']);
            }
            
        }
    
        /**
         * @api {post} mon/mon_pass_login 密码登录[mon/mon_pass_login]
         * @apiVersion 2.0.0
         * @apiName mon_pass_login
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_pass_login
         *
         * @apiParam {int} mobile    手机号
         * @apiParam {string} password   密码
         */
        public function pass_login(){
            $mobile= input('mobile');
            $password= input('password');
            if(empty($mobile)||empty($password)){
                return json(['status'=>'error','msg'=>'手机号码或密码不能为空']);
            }
            $pass = md5($password);
            $res = Db::name('user')->where('mobile',$mobile)->where('password',$pass)->find();
            if($res){
                set_cookie($res['id']);
                return json(['status'=>'ok','msg'=>'登录成功']);
            }else{
                return json(['status'=>'error','msg'=>'账号或密码错误']);
            }
         }
        /**
        * @api {post} mon/mon_send 公共发验证码[mon/mon_send]
        * @apiVersion 2.0.0
        * @apiName mon_send
        * @apiGroup mon_Login
        * @apiSampleRequest mon/mon_send
        *
        * @apiParam {int} mobile    手机号
        * @apiParam {string} type   不需要验证此手机号码是否为俏猫用户请传1，其他不传
        *
        */
        public function send_code(){
            $mobile= input('mobile');
            $type = input('type');
            if (strlen ( $mobile) != 11) {
                return json(['status'=>'error','msg'=>'手机号码不合法']);
            }
            if($type!=1){
                $res = Db::name('user')->where('mobile',$mobile)->find();
                if($res==null){
                   return json(['status'=>'error','code'=>-3,'msg'=>get_msg(-3)]);
                }
            }
            $code = substr(str_shuffle('123456789'), 0, 6);
            //使用公共方法发送验证码
            $res = send_yun($mobile,$code);
            if($res->code()==0){
                $data=['mobile'=>$mobile,'code'=>$code,'create_time'=>time(),'status'=>1];
                Db::name('hzsabc_send_code')->insert($data);
                return json(['status'=>'ok','msg'=>$res->msg()]);
            }else{
                return json(['status'=>'error','msg'=>$res->msg()]);
            }
        }
    
        /**
         * @api {post} mon/mon_forget_pass 忘记密码(或修改密码)[mon/mon_forget_pass]
         * @apiVersion 2.0.0
         * @apiName mon_forget_pass
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_forget_pass
         *
         * @apiParam {string} pass_1     密码
         * @apiParam {string} pass_2     确认密码
         * @apiParam {int} mobile     手机号码
         */
        public function forget_pass(){
            $pass_1 = input('pass_1');
            $pass_2 = input('pass_2');
            $mobile = input('mobile');
            if($pass_1!==$pass_2){
                return json(['status'=>'error','msg'=>'两次密码输入不一致']);
            }
            if(strlen($pass_1)<6||strlen($pass_1)>20){
                return json(['status'=>'error','msg'=>'密码长度在6到20之间']);
            }
            try {
                Db::name('user')->where('mobile',$mobile)->setField('password',md5($pass_1));
                return json(['status'=>'ok','msg'=>'修改密码成功']);
            }catch (\Throwable $e) {
                return json(['status'=>'error','msg'=>'修改密码失败']);
            }
        }
        
        /**
         * @api {post} mon/mon_yan_code 公共验证码验证[mon/mon_yan_code]
         * @apiVersion 2.0.0
         * @apiName mon_yan_code
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_yan_code
         *
         * @apiParam {int} mobile    手机号
         * @apiParam {int} code      验证码
         * @apiParam {int} type      不需要验证此手机号码是否为俏猫用户请传1，其他不传
         *
         */
        public function yan_code(){
            $mobile = input('mobile');
            $code = input('code');
            $type = input('type');
            if($type!=1){
                $res = Db::name('user')->where('mobile',$mobile)->find();
                if($res==null){
                  return json(['status'=>'error','code'=>-3,'msg'=>get_msg(-3)]);
                }
            }
            $validate = validate('ComValidate');
            $data=['mobile'=>$mobile,'code'=>$code];
            if(!$validate->check($data)){
                return json(['status'=>'error','msg'=>$validate->getError()]);
            }
            $res = Db::name('hzsabc_send_code')->where('mobile',$mobile)->where('status',1)->order('create_time','desc')->find();
            if($code!=$res['code']){
                return json(['status'=>'error','msg'=>'验证码错误']);
            }
            $time_cha=time()-$res['create_time'];
            if($time_cha>180){
                Db::name('hzsabc_send_code')->where('id',$res['id'])->delete();
                return json(['status'=>'error','msg'=>'验证码已过期']);
            }
            //删除已经验证完成的验证码
            Db::name('hzsabc_send_code')->where('id',$res['id'])->delete();
            return json(['status'=>'ok','msg'=>'验证通过']);
        }
    
        /**
         * @api {post} mon/mon_logout 公共退出登录[mon/mon_logout]
         * @apiVersion 2.0.0
         * @apiName mon_logout
         * @apiGroup mon_Login
         * @apiSampleRequest mon/mon_logout
         */
        public function logout(){
            if(if_cookie()==true){
                del_cookie();
                return json(['status'=>'ok','msg'=>'退出成功']);
            }else {
                return json(['status'=>'error','msg'=>'账号未登录']);
            }
        }
    
        //验证码验证(内部调用)
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