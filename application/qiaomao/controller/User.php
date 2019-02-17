<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\db\exception\DataNotFoundException;

/**
 * 俏猫用户类
 */
class User extends Controller{
    
    protected $tb_user = 'user';
    protected $tb_stylist = 'stylist';
 

    /**
     *
     * @api {post} qiaomao/qm_user_is_login 俏猫-判断用户是否登录 [qiaomao/qm_user_is_login]
     * @apiVersion 2.0.0
     * @apiName qm_user_is_login
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_is_login
     *
     *
     */
    public function user_is_login()
    {
        if(!if_cookie())
        {
            return json_nologin();
        }else {
            $user_info = user_info();
            return json_ok($user_info);
        }
    }
    /**
     * 获取造型师列表
     *
     * @param bool|int $type
     * @param int $page
     * @param string $fields
     * @param bool $province_id
     * @param bool $city_id
     * @param bool $area_id
     * @param bool $product_id
     * @param int $page_size
     * @param int $longitude
     * @param int $latitude
     * @param int $lon
     * @param int $lan
     * @param bool $name
     * @param string $sort_by 默认score
     * @param string $sort_rule 默认降序
     * @return mixed
     */
    /**
     *
     * @api {post} qiaomao/qm_user_stylist_list 俏猫-造型师列表 [qiaomao/qm_user_stylist_list]
     * @apiVersion 2.0.0
     * @apiName qm_user_stylist_list
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_stylist_list
     *
     * @apiParam {string}  sort_by  fans 人气  new 最新
     * @apiParam {string}  sort_rule  asc升 desc降 
     * @apiParam {string}  name 美业师名
     * @apiParam {Int}  province_id 省id 
     * @apiParam {Int}  city_id 城市id 
     * @apiParam {Int}  area_id 区id 
     * @apiParam {Int}  page
     * @apiParam {Int}  page_size
     * @apiParam {Int}  recommend_sid 推荐美业师id
     * 
     *
     *
     *
     */
    
    public function user_stylist_list($type = false, $page = 1, $fields = '',
        $province_id = false, $city_id = false, $area_id = false,
        $product_id = false, $page_size = 10,
        $longitude = 0, $latitude = 0,
        $lon = 0, $lan = 0, $name = false,
        $sort_by = 'fans', $sort_rule = 'desc', $cate_id = 0, $circle = false,$recommend_sid=false)
    {
        
        
        $model = Db::name('stylist')->alias('t');
       
      
        $province_id = intval($province_id);
        $city_id = intval($city_id);
        
    
        $fields = array_filter(explode(',', $fields));
        
        $conds = [
            'type' => $type ? ['raw', "FIND_IN_SET(" . $type . ",type)"] : '',
            'is_online' => 2,
            'is_check' => 1
        ];
        $conds = array_filter($conds);
        if ($product_id) {
            $conds ['products'] = [
                'like',
                '%,' . $product_id . ',%'
            ];
        }
        if ($province_id) {
         $conds['province_id'] = $province_id;
         }
         if ($city_id) {
         $conds['city_id'] = $city_id;
         }
         if ($area_id) {
         $conds['area_id'] = $area_id;
         }
        if (!empty($name)) {
           $conds['real_name'] =  ['exp',"like '%$name%' or `store_name` like '%$name%'"];
           // $conds['real_name'] = ['like', "%$name%"];
        }
        $conds['type'] = ['<>', 2048];
        $conds['store_type'] = ['<>', 2];
        
        $model = $model->join('stylist_stats s', 't.id=s.id','left');
        if ($sort_by =='fans') {
           
            $model = $model->order(array(
                's.fans' => $sort_rule?:'desc'
            ));
               
        }elseif($sort_by =='new') 
        {
            $model = $model->order(array(
                't.id' => $sort_rule?:'desc'
            ));
        }else{
            $model = $model->order(array(
                's.fans' => 'desc'
            ));
        }
        
        
    
        $stylists = $model->page($page, $page_size)->where($conds)->field([
            't.id',
            't.real_name',
            't.store_name',           
            't.type',
            't.nick',
            't.age',
            't.sex',
            't.user_img',
            't.history_orders',
            't.intro',
            't.num_orders_extra',
            't.work_years',
            't.longitude',
            't.latitude',
            't.level',
            't.photo',
            't.province_id',
            't.city_id',
            't.area_id',
            't.created_at',
            't.stylist_balance',
            's.average_price',
            's.score',
            's.fans',
        ])
        //->fetchSql(true)
        ->select();
       // return json($stylists);
        
        if($recommend_sid)
        {
           $data_['recommend'] =  Db::name('stylist')->alias('t')->join('stylist_stats s', 't.id=s.id','left')->where(['t.id'=>$recommend_sid])->field([
            't.id',
            't.real_name',
            't.type',
            't.nick',
            't.age',
            't.sex',
            't.user_img',
            't.history_orders',
            't.intro',
            't.num_orders_extra',
            't.work_years',
            't.longitude',
            't.latitude',
            't.level',
            't.photo',
            't.province_id',
            't.city_id',
            't.area_id',
            't.created_at',
            't.stylist_balance',
            's.average_price',
            's.score',
            's.fans',
        ])->find();
            
        }else {
            $data_['recommend'] =null;
            
        }
       
     
     $data_['page'] = $page?intval($page):1;
     $data_['page_size'] = $page_size?intval($page_size):10;
     $data_['count'] = Db::name('stylist')->alias('t')->join('stylist_stats s', 't.id=s.id','left')->page($page, $page_size)->where($conds)->count();
     
    $data_['result'] = $stylists;
    
        return json_ok($data_);
    }
    
    
    /**
     *
     * @api {post} qiaomao/qm_user_points_list 俏猫-用户猫粮积分列表[qiaomao/qm_user_points_list]
     * @apiVersion 2.0.0
     * @apiName qm_user_points_list
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_points_list
     * 
     * @apiParam {Int}  page
     * @apiParam {Int}  page_size
     *
     *
     *
     */
    public function user_points_list($page=1,$page_size=10)
    {
        if(!if_cookie())
        {
            return json_nologin();
        }
        if(!$page) $page = 1;
        if(!$page_size) $page_size = 10;
        
        $user_info = user_info();
        $where['user_id'] = $user_info['id'];
        $data = Db::name('user_points_serial')->where($where)->page($page,$page_size)->order('id','desc')->select();
        
        $data_ =[];
        $data_['page'] = $page;
        $data_['page_size'] = $page_size;
        $data_['count'] = Db::name('user_points_serial')->where($where)->count();
        $data_['sum'] = Db::name('user_points_serial')->where($where)->sum('points');
        
        $data_['result'] = $data;
        
        return  json_ok($data_);
    }
    
    /**
     *
     * @api {post} qiaomao/qm_user_income_check_in 俏猫-用户每日签到[qiaomao/qm_user_income_check_in]
     * @apiVersion 2.0.0
     * @apiName qm_user_income_check_in
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_income_check_in
     *
     *
     *
     */
    public function user_income_check_in()
    {
        if(!if_cookie())
        {
            return json_nologin();
        }
        $user_info = user_info();
        
        $info = [
            'message' => '签到',
            'points' => 2,
            'in_out' => 'INCOME',
            'status' => 'EFFECTIVE',
        ];
        
        $where['points_en_code']=$info['points_en_code'] = 'INCOME_CHECK_IN';
        $where['additional_number']=$info['additional_number'] = date('Ymd');
        $where['user_id']=$info['user_id'] = $user_info['id'];
        
        //判断是否已签到
        
        $count  = DB::name('user_points_serial')->where(['points_en_code' =>'INCOME_CHECK_IN','user_id' =>$user_info['id']])->count();
        $if_check = Db::name('user_points_serial')->where($where)->find();
        
        $data=[];
        $data['count'] = $count;
        $data['ponits'] = $count*2;
        
        if($if_check)
        {
            return  json_ok($data,'今日已签到',1);
        }
        
               
        $now = time();
        $info = array_replace([
            'created_at' => date('Y-m-d H:i:s', $now),
            'effected_at' => date('Y-m-d H:i:s', $now),
            'deadline_at' => date('Y-m-d H:i:s', $now + 3 * 356 * 86400)           
        ], $info);
        $return =  Db::name('user_points_serial')->insert($info);
        $data['count'] += 1;
        $data['ponits'] += 2;
        return json_ok($data,'签到成功');
    }
    
   
    /**
     *
     * @api {post} qiaomao/qm_user_footprint_list 俏猫-用户足迹列表[qiaomao/qm_user_footprint_list]
     * @apiVersion 2.0.0
     * @apiName qm_user_footprint_list
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_footprint_list
     *
     *
     * @apiParam {Int}  uid  用户id
     * @apiParam {Int}  page
     * @apiParam {Int}  page_size
     *
     *
     *
     */
    
    
    public function user_footprint_list($uid='', $page = 1, $page_size = 10)
    {
        if(!if_cookie()) 
        {
            return json_nologin();
        }
        if(!$uid) $uid = user_info()['id'];
        //return json_ok($uid);
        if(!$page) $page = 1;
        if(!$page_size) $page_size = 10;
        
        $field = ['p.shop_price','p.cate_id','t.store_type','t.store_name','p.id', 'p.name', 'p.price','p.market_price','p.thumb','p.click_count','p.sell_count','s.stylist_id','t.real_name','t.level','t.user_img','p.type_user'];
         
        //$data = Db::name("data_analysis")->alias('a')->join('product p', 'a.data_ext=p.id','left')->join('stylist_service s','a.data_ext=s.product_id','left')->join('stylist t','s.stylist_id=t.id','left')->field($field)->where(["a.user_id" => $uid,'a.type' => 5])->page($page,$page_size)->group('a.note')->select();
        $data_ = Db::name("data_analysis")->where(["user_id" => $uid,'type' => 5])->field(['data_ext pid'])->page($page,$page_size)->group('note')->order('date_added','desc')->select();
        $pid_in =[];
        foreach($data_ as $k=>$v) {
            $pid_in[] = intval($v['pid']); 
        }
       
        
        $data = Db::name("product")->alias('p')->join('stylist_service s','p.id=s.product_id','left')->join('stylist t','s.stylist_id=t.id','left')->field($field)->where(['p.id'=>['in',$pid_in]])->group('p.id')->select();
        
       
        
        $data = $this->sortByKey($data,$pid_in);
        
       
        
        
        if($data)
        {
            foreach ($data as &$val){
                $val['product_favorite_count'] = Db::name('user_favorite')->where('pid', '=', $val['id'])->cache(100)->count();
                if($val['type_user'] ==2)
                {
                    $val['user_img'] = "";
                    $val['stylist_id'] = 10000;
                    $val['real_name']= '俏猫';
                    $val['level']= 1;
                
                }
                
            }  
        }
        
        $data_=[];
        
        $data_['page'] = $page;
        $data_['page_size'] = $page_size;
        $data_['count'] = Db::name("data_analysis")->where(["user_id" => $uid,'type' => 5])->group('note')->count();
        $data_['result'] = $data;
        
        return json_ok($data_);
    }
    /**
     *获取用户收支列表
     * @param int $uid
     * @param int $page 分页
     * @param int $page_size 分页长度
     * @param array
     */
    /**
     *
     * @api {post} qiaomao/qm_user_balance_list 俏猫-用户钱包收支列表[qiaomao/qm_user_balance_list]
     * @apiVersion 2.0.0
     * @apiName qm_user_balance_list
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_balance_list
     *
     * 
     * @apiParam {Int}  uid  测试 324248231
     * @apiParam {Int}  page 
     * @apiParam {Int}  page_size 
     * 
     *
     *
     */
    public function user_balance_list($uid='', $page = 1, $page_size = 10)
    {
        if(!if_cookie())
        {
            return json_nologin();
        }
        if(!$uid) $uid = user_info()['id'];
        if(!$page) $page = 1;    
        if(!$page_size)  $page_size = 10;
       
        
              
       
        $list = Db::name('user_balance')->where('user_id', '=', $uid)->order('id', 'DESC')
        ->page($page,$page_size)->select();
        $list_['page'] =$page;
        $list_['page_size'] =$page_size;
        $list_['count'] =  Db::name('user_balance')->where('user_id', '=', $uid)->order('id', 'DESC')
        ->count();
        $list_['result'] =$list;
       
        
       
        return json_ok($list_);
    }
    
    /**
     *
     * @api {post} qiaomao/qm_user_complaint_stylist 俏猫-用户意见投诉美业师列表[qiaomao/qm_user_complaint_stylist]
     * @apiVersion 2.0.0
     * @apiName qm_user_complaint_stylist
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_complaint_stylist
     *
     * 
     *
     *
     */
     public function user_complaint_stylist()
     {
         if(!if_cookie())
         {
            return  json_nologin();
         }
         $uid = user_info()['id'];
         //查询用户下单美业师列表
         
        
         
         $field = ['s.id', 's.real_name','s.level'];
         $list = Db::name('stylist')->alias('s')->join('order o','s.id=o.seller_id','left')->where(['o.buyer_id'=>$uid])->order('o.id', 'DESC')->group('s.id')->field($field)
         ->page(1,10)->select();
         return json_ok($list);
     }
    
    /**
     * @param $data ['title', 'user_name', 'description', 'contact']
     * @return array
     */
    
    /**
     *
     * @api {post} qiaomao/qm_user_complaint_submit 俏猫-用户意见投诉[qiaomao/qm_user_complaint_submit]
     * @apiVersion 2.0.0
     * @apiName qm_user_complaint_submit
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_complaint_submit
     *
     * @apiParam {Array}  data ['user_name', 'description', 'contact','stylist_id']
     *
     *
     */
    public function user_complaint_submit()
    {
        $data = input();
        $data = isset($data['data'])?$data['data']:$data;
        if(if_cookie())
        {
            $user_info = user_info();
            $data['user_name'] = array_get($user_info, 'user_name');
            $data['contact'] = array_get($user_info, 'mobile');
        }
       
        
        $data['title'] = '用户意见投诉';
        $data['description'] .="|美业师id:".$data['stylist_id'];
        $result = $this->feedback_submit($data);
        return $result;
    }
    
    /**
     *
     * @api {post} qiaomao/qm_user_feedback_submit 俏猫-用户意见反馈[qiaomao/qm_user_feedback_submit]
     * @apiVersion 2.0.0
     * @apiName qm_user_feedback_submit
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_feedback_submit
     *
     * @apiParam {Array}  data ['user_name', 'description', 'contact']
     *
     *
     */
    public function user_feedback_submit()
    {
        $data = input();
        $data = isset($data['data'])?$data['data']:$data;
        $data['title'] = '用户意见反馈';
        $result = $this->feedback_submit($data);
        return $result;
    }
    protected function feedback_submit($data)
    {
        $data = array_only($data, ['title', 'user_name', 'description', 'contact']);
        
    
        if(empty($data['title']) && empty($data['description']))
        {
            return json_error('缺少反馈信息');
        }
    
        if(if_cookie())
        {
            $user_info = user_info();
            $data['user_name'] = array_get($user_info, 'user_name');
            $data['user_id'] = $user_info['id'];
            $data['meta'] = json_encode([
                'user_agent' => array_only($_SERVER, ['REMOTE_ADDR', 'REMOTE_PORT', 'HTTP_USER_AGENT'])
            ]);
            
        }else{
            if(empty($data['user_name'])||empty($data['contact']))
            {
                return json_error('缺少用户信息');
            }
        }
    
    
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = $data['created_at'];
        $data['type'] = 0;
    
        $data['checksum'] = md5(json_encode(array_only($data, ['user_name', 'user_id', 'title', 'description', 'type', 'contact'])));
    
        $ret =  Db::name('feedback')->insertGetId($data);
        /* $tag_params = ['feedback' => $ret];
        tag('feedback.submit.after', $tag_params); */
        $data['id'] =$ret;
        return json_ok($data);
    
    }
    /**
     * 修改base资料
     * @param array $data
     * @return array|bool
     */
    /**
     *
     * @api {post} qiaomao/qm_user_modify_base 俏猫-修改用户资料[qiaomao/qm_user_modify_base]
     * @apiVersion 2.0.0
     * @apiName qm_user_modify_base
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_user_modify_base
     *
     * @apiParam {Array}  data ['nick', 'real_name', 'city_id', 'area_id', 'address', 'birthday', 'sex', 'career','avatar']
     * 
     *
     */
    public function user_modify_base()
    {
        $data = input();
        $data = isset($data['data'])?$data['data']:$data;
        
      
        if (!if_cookie()) {
            return json_nologin();
        }
        $old = user_info();
        
        $info = array_only($data, ['nick', 'real_name', 'city_id', 'area_id', 'address', 'birthday', 'sex', 'career','avatar']);
        $meta = array_only($data, ['iphone_id', 'jpush_id']);
      
        if (!empty($meta)) {
            $meta = metadata($this->tb_user,$old['id'], $meta);
        }
        if (empty($info)) {
            $info['id'] = $old['id'];
            return json_ok(array_replace($info, $meta));
        } else {
            $info['id'] = $old['id'];
            
           /*  $msg["title"] = "用户$info[id]修改了个人资料";
            $msg["content"] = "用户$info[id]修改了个人资料";
            $msg["created_at"] = date("Y-m-d H:i:s");
            $msg['status'] = 1;
            $msg["href"] = "/admin/member/user/info?id=$info[id]";
            D("service_message")->insert($msg); */
            $return =  Db::name($this->tb_user)->where(['id'=>$info['id']])->update($info);
            $return = Db::name($this->tb_user)->where(['id'=>$info['id']])->find();
            
            $return = array_replace($info, $meta);
            
            return json_ok($return);
        }
    
    }
    /**
     * api验证用户成功,返回的用户资料
     *
     * @param int $uid
     * @param string $exts 'account,balance,buy_info'
     * @return array
     */
    
    /**
     *
     * @api {post} qiaomao/qm_profile_get api验证用户成功,返回的用户资料[qiaomao/qm_profile_get]
     * @apiVersion 2.0.0
     * @apiName qm_profile_get
     * @apiGroup qiaomao_User
     * @apiSampleRequest qiaomao/qm_profile_get
     *
     * @apiParam {Int}  uid 选填
     * @apiParam {String} exts 选填  
     * 
     */
    public function profile_get()
    {
        
        $uid = (input("uid")) ?input("uid"):0;
        $exts = (input("exts")) ?input("exts"):'';
        
       if(!if_cookie())
       {
           return json_nologin();
       }
        
        $exts = explode(',', $exts);
        $user_id = get_cookie()['id'];
        $exts = array_intersect($exts, ['account', 'balance', 'buy_info']);
        if (if_cookie() && $user = Db::name($this->tb_user)->where(['id'=>$user_id])->field(['id',
            'user_name', 'nick', 'level', 'points', 'balance', 'mobile', 'sex', 'real_name',
            'create_time', 'city_id', 'area_id', 'address', 'birthday', 'avatar', 'locked', 'province_id'
        ])->find()
            ) {
                //$user = array_replace($this->user(), $user);
                $user['user_id'] = $user['id'];
                $user = array_replace($user, metadata($this->tb_user,$user['id']));
                foreach ($exts as $tbl) {
                    $one = Db::name("user_$tbl")->where(['uid' => $user_id])->find() ?: [];
                    $user = array_replace(array_except($one, ['created_at', 'deleted_at', 'updated_at']), $user);
                }
                $stylist = Db::name($this->tb_stylist)->where(['id'=>$user_id])->find();
                
                $user['product_count'] = Db::name('user_favorite')->where('uid', '=', $user_id)->count();
                //$user['stylist_count']  = Db::name('user_attention_stylist')->where('user_id', '=', $user_id)->where('is_attent', '=', 1)->count();
                $user['stylist_count'] = Db::name('user_attention_stylist')->alias('gz')->join("stylist st", 'gz.stylist_id=st.id','LEFT')->join("stylist_stats ss", 'gz.stylist_id=ss.id','LEFT')->where('st.real_name','<>','' )->where('gz.user_id', '=', $user_id)->where('gz.is_attent', '=', 1)->count();;
                
                $user['coupon_count']  = Db::name('user_coupon_cash')->where('user_id', '=', $user_id)->count();    
                $user['footprint_count'] = Db::name("data_analysis")->where(["user_id" => $user_id,'type' => 5])->group('note')->count();
                
                $user['points'] = Db::name('user_points_serial')->where('user_id', '=', $user_id)->sum('points');
                $user['is_stylist'] = $stylist ? 1 : 0;
                $user["alias"] = isset($user['user_id']) && $user['user_id']? md5($user['user_id']):'' ;
    
                $user['invite_code'] = strtoupper(dechex($user['id']));
    
                $return =  array_except($user, ['password']);
                return json_ok($return);
            } else {
                return json_nologin();
            }
    
    }
    
    public function profile_get_return($exts='')
    {
              
        
        $exts = explode(',', $exts);
        $user_id = get_cookie()['id'];
       
        $exts = array_intersect($exts, ['account', 'balance', 'buy_info']);
        if (if_cookie() && $user = Db::name($this->tb_user)->where(['id'=>$user_id])->field(['id',
            'user_name', 'nick', 'level', 'points', 'balance', 'mobile', 'sex', 'real_name',
            'create_time', 'city_id', 'area_id', 'address', 'birthday', 'avatar', 'locked', 'province_id'
        ])->find()
            ) {
               // return ($user);
                //$user = array_replace($this->user(), $user);
                $user['user_id'] = $user['id'];
                $user = array_replace($user, metadata($this->tb_user,$user['id']));
                foreach ($exts as $tbl) {
                    $one = Db::name("user_$tbl")->where(['uid' => $user_id])->find() ?: [];
                    $user = array_replace(array_except($one, ['created_at', 'deleted_at', 'updated_at']), $user);
                }
                $stylist = Db::name($this->tb_stylist)->where(['id'=>$user_id])->find();
    
                $user['is_stylist'] = $stylist ? 1 : 0;
                $user["alias"] = isset($user['user_id']) && $user['user_id']? md5($user['user_id']):'' ;
    
                $user['invite_code'] = strtoupper(dechex($user['id']));
    
                $return =  array_except($user, ['password']);
                return ($return);
            } else {
                return  [];
            }
    
    }
    
    public function sortByKey($arr, $order,$field='id')
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