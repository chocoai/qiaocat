<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use \Yunpian\Sdk\YunpianClient;
use think\Cookie;
use think\Db;

//封装cookie验证公共函数
function if_cookie(){
    
    if(Cookie::has('qm_cookie')==0){
        return false;
    }else{
        return true;
    }
}
//获取cookie
function get_cookie(){
    $cookieValue = Cookie::get('qm_cookie');
    if( !empty($cookieValue) ) {
        $uid = decode($cookieValue, config('conf.cook_key'));
        return $data=['id'=> (int)$uid];
    } else {
        return FALSE;
    }
    
}
//设置cookie
function set_cookie($id){
    $code = encode($id, config('conf.cook_key'));
    Cookie::set('qm_cookie',$code,3600*24*30);
}
//删除cookie
function del_cookie(){
    Cookie::delete('qm_cookie');
}
//加密算法
function encode($string = '', $skey = '') {
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key < $strCount && $strArr[$key].=$value;
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}
//解密算法
function decode($string = '', $skey = '') {
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
}
//返回code参数
function get_msg($code){
    switch ($code){
        case 1:
            $msg = '登陆成功';
            break;
        case -1:
            $msg = '账号未登录';
            break;
        case -2:
            $msg = '此账号未被审核为美业师';
            break;
        case -3:
            $msg = '此账号不是俏猫用户';
            break;
        case -4:
            $msg = '你的店铺还没上线，请联系客服上线';
            break;
        case -5:
            $msg = 'sql语句报错';
            break;
        case -6:
            $msg = '您的店铺未营业,请先营业';
            break;
        case -7:
            $msg = '您还没有上线,请找俏猫后台管理员点击上线';
            break;
        case -8:
            $msg = '您还没有设置服务时段,请点击设置';
            break;
        case -9:
            $msg = '您还没有设置服务商圈,请点击设置';
            break;
        case -100:
            $msg = '传入参数错误';
            break;
        default:
            $msg ='';
    }
    return $msg;
        
}

//判断注册来源
function reg_source(){
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
        $source=1;
    }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
        $source=2;
    }else{
        $source=3;
    }
    return $source;
}
//写入推广记录
function extension($uid,$inviter_id,$invite_code,$time){
    //邀请者用户名
    $inviter_name = Db::name('user')->where('id',$inviter_id)->value('user_name');
    //被邀请用户名和手机
    $invitee = Db::name('user')->where('id',$uid)->field(['user_name','mobile'])->find();
    $data=['inviter_id'=>$inviter_id,'invitee_id'=>$uid,'invite_code'=>$invite_code,
           'status'=>1,'register_time'=>$time,'inviter_name'=>$inviter_name,
           'invitee_name'=>$invitee['user_name'],'invitee_mobile'=>$invitee['mobile'],
           'invitee_email'=>0,'comment'=>'邀请注册','created_at'=>$time,'updated_at'=>$time
          ];
    Db::name('user_invitation')->insert($data);
    
}
//云片手机发送验证码
function send_yun($mobile,$code){
    $apikey = config('conf.yunpian_apikey');
    $text = "【俏猫平台】您的验证码是".$code."，请勿向任何人提供您收到的短信验证码。";
    //初始化client,apikey作为所有请求的默认值
    $clnt = YunpianClient::create($apikey);
    $param = [YunpianClient::MOBILE => $mobile,YunpianClient::TEXT => $text];
    $r = $clnt->sms()->single_send($param);
    return $r;
}

//云片手机发送验证码
function send_yun_text($mobile,$text){
    $apikey = config('conf.yunpian_apikey');
    $text = "【俏猫平台】".$text;
    
    //初始化client,apikey作为所有请求的默认值
    $clnt = YunpianClient::create($apikey);
    $param = [YunpianClient::MOBILE => $mobile,YunpianClient::TEXT => $text];
    $r = $clnt->sms()->single_send($param);
    return $r;
}

//获取ip地址
function getIp($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if(isset($_SERVER['HTTP_X_REAL_IP'])){//nginx 代理模式下，获取客户端真实IP
        $ip=$_SERVER['HTTP_X_REAL_IP'];
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

//根据ip地址获取城市地址
function GetIpLookup($ip = ''){
    if(empty($ip)){
        $ip = GetIp();
    }
    $res = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='. $ip);
    if(empty($res)){ return false; }
    $arr = json_decode($res,true);
    return $arr['data'];
}  
//返回美业师等级
if (!function_exists('stylist_level')){
    function stylist_level($exp){
      if($exp>=50 && $exp<=59){
            $level = '见习美业师';
      }elseif ($exp>=60 && $exp<=99){
            $level = '初级美业师';
      }elseif ($exp>=100 && $exp<=499){
            $level = '中级美业师';
      }elseif ($exp>=500 && $exp<=999){
            $level = '高级美业师';
      }elseif ($exp>=1000){
            $level = '专业美业师';
      }else {
            $level = '新晋美业师';
      }
       return $level;
    }
}
 //美业师是否营业
function if_business(){
    $res = Db::name('stylist')->where('id',get_cookie()['id'])->value('is_business');
    if($res==2){
        return true;
    }else{
        return false;
    }
}
 //美业师是否在线
function if_online(){
    $res = Db::name('stylist')->where('id',get_cookie()['id'])->value('is_online');
    if($res==2){
        return true;
    }else{
        return false;
    }
}


 //是否为美业师
function if_meiye(){
    $res = Db::name('stylist')->where('id',get_cookie()['id'])->value('is_check');
    if($res==1){
        return true;
    }else{
        return false;
    }
}

//申请美业师状态
function meiye_status(){
    $res = Db::name('stylist')->where('id',get_cookie()['id'])->value('is_check');
    if($res==1 || $res==2){
        return true;
    }else{
        return false;
    }
}

//获取商圈
function get_street($add_id){
    if(!empty($add_id)){
        $sql = Db::name('location_street')->where('area_id',$add_id)->field('street_id')->select();
        $data='';
        if(count($sql)>0){
            foreach ($sql as $v){
                $data = $data.','.$v['street_id'];
            }
        }
        $info = trim($data,',');
        return $info;
    }
}


if (!function_exists('starts_with'))
{
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string $haystack
     * @param  string|array $needles
     * @return bool
     */
    function starts_with($haystack, $needles)
    {
        foreach ((array)$needles as $needle)
        {
            if ($needle != '' && strpos($haystack, $needle) === 0) return true;
        }

        return false;
    }
}

if (!function_exists('array_only'))
{
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array $array
     * @param  array $keys
     * @return array
     */
    function array_only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }
}

if (!function_exists('array_get'))
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        if (is_null($key)) return $array;

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment)
        {
            if (!is_array($array) || !array_key_exists($segment, $array))
            {
                return value($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if (!function_exists('json_error'))
{
/**
 * 返回错误信息
 * @param $msg
 * @param $res
 * @return array|json
 */
function json_error($msg='',$res=[],$code='')
{
    $return = [
        'status' => 'error',
        'msg' => $msg,
        'data' => $res,
        'code' =>$code,
    ];
    return json($return);
}
}

if (!function_exists('json_nologin'))
{
    /**
     * 返回未登录信息
     * @param $msg
     * @param $res
     * @return array|json
     */
    function json_nologin($data=[])
    {
        $return = [
            'status' => 'error',
            'msg' => '账号未登录',
            'data' => $data,
            'code' =>13000,
        ];
        return json($return);
    }
}

if (!function_exists('json_ok'))
{
    /**
     * 返回信息
     * @param $msg
     * @param $res
     * @return array|json
     */
    function json_ok($data=[],$msg='',$code='')
    {
        $return = [
            'status' => 'ok',
            'msg' => $msg,
            'data' => $data,
            'code' =>$code,
        ];
        return json($return);
    }
}

if (!function_exists('value'))
{
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('user_info'))
{
    /**
     * 获取 用户资料
     * @param unknown $value
     * @return Closure
     */
    function user_info()
    {
        $field = ['id','user_name','real_name', 'nick', 'mobile','avatar','last_login_ip'];
        $res = Db::name('user')->where('id',get_cookie()['id'])->field($field)->find();
        if($res){
            return $res;
        }else{
            return false;
        }
        
    }
}
if (!function_exists('metadata'))
{
function metadata($table,$iid, $data = false,$meta_sets =[])
{
    $meta_op = Db::name($table . '_meta');
    /* if (!empty($data))
    {

        $data = empty($meta_sets) ? $data : array_only($data, $meta_sets);
        foreach ($data as $k => $v)
        {
            $this->meta($iid, $k, $v);
        }
    } */
    $data = $meta_op->where(['iid' => $iid])->select();
    $meta = [];
    foreach ($data as $kv)
    {
        $kv['value'] = json_decode($kv['value'], true);
        if (isset($meta[$kv['key']]))
        {
            $meta[$kv['key']] = (array)$meta[$meta[$kv['key']]];
            array_push($meta[$kv['key']], $kv['value']);
        }
        else
        {
            $meta[$kv['key']] = $kv['value'];
        }
    }
    return $meta;
}
}

if (!function_exists('array_except'))
{
    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param  array $array
     * @param  array $keys
     * @return array
     */
    function array_except($array, $keys)
    {
        return array_diff_key($array, array_flip((array)$keys));
    }
}

if (!function_exists('geo_rad')) {
    function geo_rad($d)
    {
        return $d * 3.1415926535898 / 180.0;
    }
}

if (!function_exists('geo_distance')) {
    function geo_distance($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378.137;
        $radLat1 = geo_rad($lat1);
        //echo $radLat1;
        $radLat2 = geo_rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = geo_rad($lng1) - geo_rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) +
            cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }
}

if (!function_exists('head'))
{
    /**
     * Get the first element of an array. Useful for method chaining.
     *
     * @param  array $array
     * @return mixed
     */
    function head($array)
    {
        return reset($array);
    }
}

if (!function_exists('array_add'))
{
    /**
     * Add an element to an array if it doesn't exist.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $value
     * @return array
     */
    function array_add($array, $key, $value)
    {
        if (!isset($array[$key])) $array[$key] = $value;

        return $array;
    }
}

   /*
    * @param  int $stylist_id
    */
    //获取美业师的成功接单数
    function Successful_order($stylist_id){
           $count = DB::name('order')->where(['seller_id' => $stylist_id])->where('order_status','in',[1000,1200])->count();
           //几个美业师因为在老数据库残留的订单没有导入到新数据库，所以需要额外补上订单数量
           switch ($stylist_id) {
               case 324287452:
                   $count = $count+1;
                   break;
               case 324282795:
                   $count = $count+1;
                   break;
               case 324300519:
                   $count = $count+12;
                   break;
               case 324265222:
                   $count = $count+1;
                   break;
               }
           
           return $count;
    }

    
    /*
    * @param  int $stylist_id
    */
    //获取美业师的接单率
    function rate($stylist_id){
        //总的订单数
         $count_sum = DB::name('order')->where(['seller_id' => $stylist_id])->count();
         //接单的成功数
         $count = DB::name('order')->where(['seller_id' => $stylist_id])->where('order_status','in',[1000,1200])->count();
         switch ($stylist_id) {
             case 324287452:
                 $count_sum = $count_sum+1;
                 $count = $count+1;
                 break;
             case 324282795:
                 $count_sum = $count_sum+1;
                 $count = $count+1;
                 break;
             case 324300519:
                 $count_sum = $count_sum+12;
                 $count = $count+12;
                 break;
             case 324265222:
                 $count_sum = $count_sum+1;
                 $count = $count+1;
                 break;
         }
         if($count_sum == '' || $count == ''){
            return "0%";
         }
         if($count_sum == $count){
            return "100%";
         }
         $fal = (($count * 100)/$count_sum);
         $str = substr($fal,0,5);
         if(strlen($fal) >= 5){
            return ($str.'%');
         }else{
            return ($str.'%');
         }
    }


    /*
    * @param  int $stylist_id
    */
    //获取机构的好评率
    function Agency_rate($stylist_id){
        //总的评论数
         $count_sum = Db::name('comment')->where(['stylist_id' => $stylist_id])->where(['cont_type' => 1])->count();
         //好评的数量
         $count = Db::name('comment')->where(['stylist_id' => $stylist_id])->where(['score' => 5])->where(['cont_type' => 1])->count();
         if($count_sum == '' || $count == ''){
            return "0%";
         }
         if($count_sum == $count){
            return "100%";
         }
         $fal = (($count * 100)/$count_sum);
         $str = substr($fal,0,5);
         if(strlen($fal) >= 5){
            return ($str.'%');
         }else{
            return ($str.'%');
         }
    }
    
    if (!function_exists('sortByKey'))
    {
        /*
         * 智能排序
         */
        function sortByKey($arr, $order,$field='id')
        {
            $newArr = array();
            foreach ($order as $item) {
                foreach ($arr as $val) {
                    if ($val[$field] == $item) {
                        $newArr[] = $val;
                    }
                }
            }
        
            return $newArr;
        }  
    }
   

