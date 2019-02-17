<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;

/**
 * 俏猫优惠卷类
 */
class Coupon extends Controller{
   
    //对应的优惠券的表
    protected $tb_coupon = 'coupon';
    
    protected $tb_user = 'user';
    
   protected $tb_user_coupon_cash_pid ='';
    
    //对应的用户的优惠券表
	protected $tb_user_coupon_cash = 'user_coupon_cash';
    
	
	/**
	 * @api {post} qiaomao/qm_coupon_center 俏猫-领券中心[qiaomao/qm_coupon_center]
	 * @apiVersion 2.0.0
	 * @apiName qm_coupon_center
	 * @apiGroup qiaomao_Coupon
	 * @apiSampleRequest qiaomao/qm_coupon_center
	 *
	 * @apiParam {Int} type 类型 新人专属:1，化妆：2，美睫：3，纹绣：4，医美：5，培训：6
	 * @apiParam {Int} page 
	 * @apiParam {Int} page_size
	 *
	 */
	public function coupon_center($type=1,$page = 1,$page_size=10)
	{
	   
	    
	    switch ($type)
	    {
	        case 1:
	            $name = "新人";
	            break;
	        case 2:
	            $name = "化妆";
	            break;
	        case 3:
	           $name =  "美睫";
	            break;
            case 4:
                $name = "纹绣";
                break;
            case 5:
                $name =  "医美";
                break;
            case 6:
                $name = "培训";
                break;
            
	        default:
	            $name ="";
	    }
	    $where = [];
	    if($name)
	    {
	        $where['c.description'] = ['like',"%$name%"];
	       
	        
	    }
	    $where['c.end_time'] = ['>',date('Y-m-d H:i:s')];
	    $where['c.allow_user_fetch'] = ['=',1];
	    
	    /* $page = 1;
	    $page_size =10; */
	    $coupon = Db::name($this->tb_coupon)->alias('c')->join('stylist t','c.store_id=t.id','left')->where($where)->field(['t.id as stylist_id','t.real_name','t.level','t.user_img','c.id', 'c.start_time', 'c.end_time', 'c.expired_time', 'c.min_amount', 'c.base_amount', 'c.coupon_type', 'c.coupon_amount', 'c.coupon_value', 'c.description', 'c.allow_give', 'c.allow_user_fetch','c.send_count','c.total_count','c.store_id'])->page($page, $page_size)->order('c.id', 'desc')->select();
	     $data = [];
	     $data['count'] =Db::name($this->tb_coupon)->alias('c')->join('stylist t','c.store_id=t.id','left')->where($where)->count();
	     
	     if(if_cookie() && !empty($coupon))
	     {
	         $user_id =user_info()['id'];
	         foreach ($coupon as &$val)
	         {
	             
	             $val['user_coupon_count'] = $this->has_coupon_fetch($val['id'],'array');
	         }
	         
	     }
	     $data['is_login'] = if_cookie();
	     $data['page'] = $page;
	     $data['page_size'] = $page_size;
	     $data['result'] = $coupon;
	    return json_ok($data);
	    
	}
	/**
	 * 领取优惠券
	 * @param string $coupon_id
	 * @return array
	 */
	/**
	 * @api {post} qiaomao/qm_coupon_fetch 俏猫-领取优惠券[qiaomao/qm_coupon_fetch]
	 * @apiVersion 2.0.0
	 * @apiName qm_coupon_fetch
	 * @apiGroup qiaomao_Coupon
	 * @apiSampleRequest qiaomao/qm_coupon_fetch
	 *
	 * @apiParam {Int} coupon_id 优惠卷id
	 *
	 */
	public function coupon_fetch()
	{
	    $coupon_id = (input("coupon_id")) ?input("coupon_id"):0;
	    //$coupon_sn = (input("coupon_sn")) ?input("coupon_sn"):'';
	   // $mobile = (input("mobile")) ?input("mobile"):'';
	    //$arr = (input("arr")) ?input("arr"):false;
	    //$from = (input("from")) ?input("from"):'';
	  
	   
	        if (!if_cookie()) {
	            return json_nologin();
	        }
	        $user_id = user_info()['id'];
	   
	
	   
	    $coupon = Db::name($this->tb_coupon)->where(['id'=>$coupon_id])->field(['id', 'start_time', 'end_time', 'expired_time', 'min_amount', 'base_amount', 'coupon_type', 'coupon_amount', 'coupon_value', 'description', 'allow_give', 'allow_user_fetch'])->find();
	    if ($coupon && $coupon['allow_user_fetch'] > 0) {
	        return $this->dispatchByOneUser($coupon_id,$user_id);
	    } else {
	        return json_error('优惠券不存在');
	    }
	}
	
	/**
	 * @api {post} qiaomao/qm_has_coupon_fetch 俏猫-查询优惠券领取数量[qiaomao/qm_has_coupon_fetch]
	 * @apiVersion 2.0.0
	 * @apiName qm_has_coupon_fetch
	 * @apiGroup qiaomao_Coupon
	 * @apiSampleRequest qiaomao/qm_has_coupon_fetch
	 *
	 * @apiParam {Int} coupon_id 优惠卷id
	 *
	 */
	
	public function has_coupon_fetch($coupon_id='',$type='json')
	{
	    
	 
	   if(!$coupon_id)
	   {
	       return json_error('参数不能为空');
	   }

	    if (!if_cookie()) {
	        return json_nologin();
	    }
	    $user_id = user_info()['id'];
	
	    //验证该用户领过的优惠券是否达到上限
	    $count = Db::name($this->tb_user_coupon_cash)->where(['coupon_id' => $coupon_id, 'user_id' => $user_id])->count();
	    $data['count'] =$count;
	    
	    if($type =='array')
	    {
	        return $count;
	    }else {
	        return json_ok($data);
	    }
	    
	}
	
	
	
	/**
	 *
	 * @param $coupon_id
	 * @param $user_id
	 * @param string $suffix
	 * @return array|bool
	 */
	protected function dispatchByOneUser($coupon_id, $user_id)
	{
	   
	    $suffix = 'U';
	
	    //验证该优惠券是否存在
	    $coupon = Db::name($this->tb_coupon)->where(['id'=>$coupon_id])->find();
	    if (empty($coupon)) return json_error('该优惠券不存在');
	
	
	    //验证该优惠券的派发张数是不是已经上限，
	    $userCouponCount = Db::name($this->tb_user_coupon_cash)->where(['coupon_id' => $coupon_id])->count();
	    
	    if ($userCouponCount > $coupon['total_count']) {
	        $num = $coupon['total_count'] - $userCouponCount;
	        if($num < 0)
	        {
	            $num = 0;
	        }
	        return json_error('派发该优惠券的数量已经上限，最多还能派' . $num . '张','',1);
	    }
	
	    //验证该用户领过的优惠券是否达到上限
	    $myCouponLimit = Db::name($this->tb_user_coupon_cash)->where(['coupon_id' => $coupon_id, 'user_id' => $user_id])->count();
	
	   
	
	    if ($myCouponLimit >= $coupon['per_count']) {
	        return json_error('该用户[' . $user_id . ']所领取的优惠券已经上限了','',1);
	    }
	
	
	    //调整start_time end_time
	    if (strtotime($coupon['start_time']) < 1) {
	        $coupon['start_time'] = date("Y-m-d H:i:s", time());
	        if (strtotime($coupon['end_time']) < 1) {
	            $end_time = time() + ($coupon['expired_time'] * 86400);
	            $coupon['end_time'] = date("Y-m-d H:i:s", $end_time);
	        }
	
	    }
	
	    $data = [
	        'user_id' => $user_id,
	        'sn' => $suffix . date('ymdHis') . rand(1000, 9999),
	        'coupon_id' => $coupon['id'],
	        'type' => $coupon['coupon_type'],
	        'amount' => $coupon['coupon_amount'],
	        'note' => $coupon['name'],
	        'start_time' => $coupon['start_time'],
	        'end_time' => $coupon['end_time'],
	        'active_time' => date("Y-m-d H:i:s"),
	        'des' => $coupon['description'] ? $coupon['description'] : $coupon['name'],
	        'created_at' => date("Y-m-d H:i:s"),
	        'operator' => '10000'
	    ];
	
	    $coupon_serial_id = Db::name($this->tb_user_coupon_cash)->insertGetId($data);
	    
	    
	    $coupon_serial = Db::name($this->tb_user_coupon_cash)->where(['id'=>$coupon_serial_id])->find();
	    
	    
	    if (array_get($coupon_serial, 'id', false)) {
	
	        Db::name($this->tb_coupon)->where(['id'=>$coupon_id])->update(['id' => $coupon_id, 'send_count' => $userCouponCount + 1]);
	        if ($coupon_id==1000002 ) {
	            Db::name($this->tb_coupon)->where(['id'=>$coupon_id])->update(['id' => $coupon_id, 'send_count' => $userCouponCount + 1]);
	        }
	
	        return json_ok($coupon_serial);
	    } else {
	        return json_error('派发失败[系统维护中]');
	    }
	}
	
    /**
     * @api {post} qiaomao/qm_coupon_info 获取优惠券详情[qiaomao/qm_coupon_info]
     * @apiVersion 2.0.0
     * @apiName qm_coupon_info
     * @apiGroup qiaomao_Coupon
     * @apiSampleRequest qiaomao/qm_coupon_info
     *
     * @apiParam {Int} coupon_id 优惠卷id
     *
     */
    public function coupon_info()
    {
        $coupon_id = (input("coupon_id")) ?input("coupon_id"):false;
        
        if(!$coupon_id)
        {
            return json_error('缺少优惠卷coupon_id');
        }
        
        $coupon = Db::name($this->tb_coupon)->where(['id'=>$coupon_id])->field(['id', 'start_time', 'end_time', 'expired_time', 'min_amount', 'base_amount', 'coupon_type', 'coupon_amount', 'coupon_value', 'description', 'allow_give'])->find();
        if ($coupon) {
            return json_ok($coupon);
        } else {
            return json_error('优惠券不存在');
        }
    }   
    
   
    /**
     * @api {post} qiaomao/qm_coupon_list 获取用户优惠券列表[qiaomao/qm_coupon_list]
     * @apiVersion 2.0.0
     * @apiName qm_coupon_list
     * @apiGroup qiaomao_Coupon
     * @apiSampleRequest qiaomao/qm_coupon_list
     *
     * @apiParam {Int} coupon_id 优惠卷id
     * @apiParam {string} field
     * @apiParam {Int} 	status 0未使用1已经使用2已过期3冻结中 
     * @apiParam {int} page
     * @apiParam {int} page_size
     *
     */
    public function coupon_list()
    {
        if(!if_cookie())
        {
            return json_nologin();
        }
        $field = (input("field")) ?input("field"):'c.store_id,c.base_amount,c.coupon_value,p.*'; 
        $coupon_id = (input("coupon_id")) ?input("coupon_id"):''; 
        $status = (input("status") || input("status") ==='0' || input("status") ===0) ?input("status"):false; 
        $page = (input("page")) ?input("page"):1;
        $page_size = (input("page_size")) ?input("page_size"):100;
        
        $store_id = (input("store_id")) ?input("store_id"):false; //店铺id0
        
        
        
        $fields = empty($field) ? ['c.store_id,c.base_amount,p.*'] : explode(',', $field);
        $conds = [
            'p.user_id' => get_cookie()['id'],
           // 'p.end_time' => ['>', date('Y-m-d H:i:s')]
        ];
        $coupon_ids = array_filter(explode(',', $coupon_id));
        if ($coupon_id && !empty($coupon_ids)) {
            $conds['p.coupon_id'] = ['in', $coupon_ids];
        }
        if (!$status === false) {
            $conds['p.status'] = $status;
        }
        if($status ===0 || $status === '0')
        {
            $conds['p.status'] = 0;
        }
        if($status ===2 || $status === '2')
        {
            $conds['p.status'] = ['in',[2,3]];
        }
       
        
    
        if($store_id)
        {
            $conds['p.store_id'] = ['in', [$store_id,0]];
        }
        
    
        $data = Db::name($this->tb_user_coupon_cash)->alias('p')->join("$this->tb_coupon c",'p.coupon_id = c.id','LEFT')->where($conds)->field($fields)->order('p.id', 'desc')->page($page, $page_size)->select();
        $data_return = [];
        $data_return['count'] =Db::name($this->tb_user_coupon_cash)->alias('p')->join("$this->tb_coupon c",'p.coupon_id = c.id','LEFT')->where($conds)->count();;
        $data_return['all'] =$data;
        $data_return['unused'] =[];
        $data_return['used'] =[];
        $data_return['over'] =[];
        if($data)
        {
            
            
         
            foreach ($data as $val)
            {
                if($val['status'] ==0 && ($val['end_time'] < date('Y-m-d H:i:s')))
                {
                    //未使用但过期的
                    $data_return['over'][] = $val;
                    
                }elseif($val['status'] ==0){
                    //未使用
                    $data_return['unused'][] = $val;
                }elseif ($val['status'] ==1){
                    //已使用
                    $data_return['used'][] = $val;
                }else{
                    //其他统一过期处理
                    $data_return['over'][] = $val;
                }
                
            }
        }
        
        
        return json_ok($data_return);
    }
    
    public function coupon_list_return($store_id = FALSE,$status=false,$field='c.store_id,c.base_amount,c.coupon_value,p.*',$pid=FALSE)
    {
        if(!if_cookie())
        {
            return [];
        }
        
       
        
      
        $fields = empty($field) ? ['c.store_id,c.base_amount,c.coupon_value,p.*'] : explode(',', $field);
        $conds = [
            'p.user_id' => get_cookie()['id'],
            'p.end_time' => ['>', date('Y-m-d H:i:s')],
            'c.store_id' => ['in', "$store_id,0"],
        ];
        //var_dump($conds);exit();
      
        if ($status == false) {
            $conds['p.status'] = 0;
        }
        if($pid && $pid>0)
        {
            $this->tb_user_coupon_cash_pid = $pid;
           $data = Db::name($this->tb_user_coupon_cash)->alias('p')->join("$this->tb_coupon c",'p.coupon_id = c.id','LEFT')->where($conds)
            
            ->where(function ($query) {
                $query->where('c.coupon_value','like',"%$this->tb_user_coupon_cash_pid%")->whereor('c.coupon_value', '0');
            })->field($fields)->order('p.id', 'desc')->select(); //->fetchSql(true)
            //var_dump($store_id);exit();
        }else {
            $conds['p.status'] = $status;
            
            $data = Db::name($this->tb_user_coupon_cash)->alias('p')->join("$this->tb_coupon c",'p.coupon_id = c.id','LEFT')->where($conds)->field($fields)->order('p.id', 'desc')->select();
            
        }
    
        
        
       /*  $data_ = [];
      if($data)
      {
          foreach ($data as $val)
          {
              ($val['store_id'] > 0) ? ($data_['dp'][]=$val) : ($data_['ty'][]=$val);
          }
      } */
       
        
        return $data;
    }
    
    
       
   
     
    
   
   
}