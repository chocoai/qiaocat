<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;
use app\qiaomao\controller\User;
use app\qiaomao\controller\Coupon;
use app\qiaomao\controller\Address;
use app\qiaomao\model\Stylist;

/**
 * 俏猫商品类
 */
class Product extends Controller{
    
    //对应的产品数据表
    protected $tb_product_tag = 'product_tag';
    protected $tb_tag = 'tag';
    protected $tb_order = 'order';
    private $t_product_comment = 'comment';
    private $tb_product = 'product';
    private $tb_stylist_service = 'stylist_service';
    protected $tb_stylist = 'stylist';
    private $meta_sets = array();
    protected $tb_stylist_product = 'stylist_product';
    
  
    
    
    
    
    /**
     *获取收藏列表
     *@param int $uid
     *@param int $page
     *@param int $page_size
     *@return array
     */
    
    /**
     * @api {post} qiaomao/qm_product_collect_list 俏猫-服务产品关注收藏列表[qiaomao/qm_product_collect_list]
     * @apiVersion 2.0.0
     * @apiName qm_product_collect_list
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_collect_list
     *
     * 
     * @apiParam {Int} page page
     * @apiParam {Int} page_size page_size
     */
    public function product_collect_list($page=1, $page_size=10)
    {
        if(!$page) $page=1;
        if(!$page_size) $page_size=10;
        $field = ['f.id as f_id','p.shop_price','p.cate_id','p.type_user','f.uid','f.pid','p.id', 'p.name', 'p.price','p.market_price', 'p.duration','p.click_count', 'p.sell_count', 'p.thumb','s.stylist_id','t.real_name','t.level','t.user_img','t.store_type','t.store_name'];
        if (!if_cookie())
        {
           return  json_nologin();
        }
        
        $uid = user_info()['id'];
        
        $db = Db::name('user_favorite')->alias('f')->where('uid', '=', $uid);
        
        $data = $db->join('product p', 'f.pid=p.id','left')->join('stylist_service s', 'f.pid=s.product_id','left')->join('stylist t', 's.stylist_id=t.id','left')->field($field)->page($page, $page_size)->order(['f.id'=>'desc'])->group('p.id')->select();
        foreach ($data as &$prod) {
            
            $prod['product_favorite_count'] = Db::name('user_favorite')->where('pid', '=', $prod['id'])->count();
            
            
                
                    if($prod['type_user'] ==2)
                    {
                        $prod['stylist_id']=null;
                        $prod['real_name']='俏猫';
                        $prod['level']=null;
                        $prod['nick'] = '';
                        $prod['user_img'] = '';
            
                    }
                
           
             
        
        }
        
        $data_['page'] =$page;
        $data_['page_size'] =$page_size;
        $data_['count'] = Db::name('user_favorite')->where('uid', '=', $uid)->count();
        $data_['result'] =$data;
        
            
         
        return json_ok($data_);
    }
    
    
    
    /**
     * @api {post} qiaomao/qm_product_collect 俏猫-服务产品关注收藏[qiaomao/qm_product_collect]
     * @apiVersion 2.0.0
     * @apiName qm_product_collect
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_collect
     *
     * @apiParam {Int} productId 服务产品id
     * 
     */
    public function product_collect($productId)
    {
       
        if (!if_cookie())
        {
            return json_error('尚未登陆无法收藏哦~','', 13000);
        }
        else
        {
            $user = user_info();
            
            $data_info = Db::name('user_favorite')->where(['uid' => $user['id'], 'pid' => $productId])->find();
            if($data_info)
            {
                Db::name('user_favorite')->where(['uid' => $user['id'], 'pid' => $productId])->update(
                    ['uid' => $user['id'], 'pid' => $productId, 'created_at' => date('Y-m-d H:i:s')]);
                return json_ok('','已关注了！');
            }else {
                Db::name('user_favorite')->insert(
                    ['uid' => $user['id'], 'pid' => $productId, 'created_at' => date('Y-m-d H:i:s')]);
                return json_ok('','关注成功！');
            }
            
        }
    }
    
    /**
     * @api {post} qiaomao/qm_product_cancel_collect 俏猫-服务产品取消关注收藏[qiaomao/qm_product_cancel_collect]
     * @apiVersion 2.0.0
     * @apiName qm_product_cancel_collect
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_cancel_collect
     *
     * @apiParam {Int} productId 服务产品id
     *
     */
    public function product_cancel_collect($productId)
    {
        if (!if_cookie())
        {
            return json_error('尚未登陆无法取消收藏哦~','', 13000);
        }
        else
        {
            $user = user_info();
        
            $data_info = Db::name('user_favorite')->where(['uid' => $user['id'], 'pid' => $productId])->find();
            if($data_info)
            {
                Db::name('user_favorite')->where(['uid' => $user['id'], 'pid' => $productId])->delete();
                return json_ok('','已取消关注了！');
            }else {
               
                return json_error('','未关注过商品，无法取消！');
            }
        
        }
    }
    
    
    
    /**
     * @api {post} qiaomao/qm_product_fuzzy_search 俏猫-搜索接口[qiaomao/qm_product_fuzzy_search]
     * @apiVersion 2.0.0
     * @apiName qm_product_fuzzy_search
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_fuzzy_search
     *
     * @apiParam {String} Keyword 搜索关键字  
     * @apiParam {string} fileds 要查询的字段，多个字段用逗号隔开   
     * @apiParam {String} order_by 排序字段选填默认id |好评：score|价格：price|最新:created_at|人气/销量:sell_count|
     * @apiParam {Int} order_rule 升降序 |降序:desc|升序:asc|
     * @apiParam {Int} price_start  价格start 
     * @apiParam {Int} price_end  价格end   如单一方向大于 只传price_start;如price>=200【price_start】;price_end=false/或空值或不传
     * @apiParam {Int} sex  美业师性别 |男:1|女:2|不限:0|
     * @apiParam {Int} level  美业师等级 |不限:0|一星：1|二星：2|三星：3|四星：4|五星：5|
     * @apiParam {String} server_street   服务商圈
     * @apiParam {Int} service_form  服务形式  |不限：0|美业师上门：1| 顾客到店：2|
     * 
     * @apiParam {int} page default is 1
     * @apiParam {int} page_size default is 10
     * 
     *    
     */
    public function product_fuzzy_search()
    {
        $Keyword = (input("Keyword")) ?input("Keyword"):false;
        $fileds = (input("fileds")) ?input("fileds"):false;
        $order_by = (input("order_by")) ?input("order_by"):'id';
        $order_rule = (input("order_rule")) ?input("order_rule"):'desc';        
        $price_start = (input("price_start")) ?input("price_start"):'' ;
        $price_end = (input("price_end")) ?input("price_end"):'' ; 
        $order_by = "p.$order_by";
        
        $sex = (input("sex")) ?input("sex"):0 ;
        $level = (input("level")) ?input("level"):'all';
        $server_street = (input("server_street")) ?input("server_street"):''; //BJ-DX-01
        $service_form = (input("service_form")) ?input("service_form"):0; 
        
        $page = (input("page")) ?input("page"):1;
        $page_size =(input("page_size")) ?input("page_size"):10;
        $fileds_ =[];
        
        if($fileds)
        {
           $fileds = explode(',', $fileds);
           
           foreach ($fileds as $val)
           {
               $fileds_[] = "p.$val";
           }
        }
      
        if ($Keyword ||  $price_start  ||  $price_end || $sex || $level || $server_street) {
            
            $join = [
                ["$this->tb_stylist_service s",'p.id = s.product_id','LEFT'],
                ["$this->tb_stylist t",'s.stylist_id= t.id','LEFT'],
               
            ];
            $tb_stylist_service  = Db::name($this->tb_product)->alias('p')->join($join);
             if ($Keyword) {
                $conds = [
                    'p.name' => ['like', "%$Keyword%"],
                ];
            }
            if ($service_form>0) {
                $conds["p.service_form"] = ['like', "%$service_form%"];
                   
            }
            
            if ($price_start  && $price_end  ) {
                $conds["p.price"]= ['between' ,[$price_start , $price_end]] ;
            }elseif  ($price_start) {
                $conds["p.price"]=[">=" ,$price_start ] ;
            } elseif  ($price_end) {
                $conds["p.price"]=["<=" ,$price_end ] ;
            }
            /*
             * 临时本地注释测试start_0711
             */
            $conds["p.online"]= ["=" , 1];
            //$conds["s.online"]= ["=" , 1];
            //$conds["t.is_online"]= ["=" , 2];
            $conds['p.label'] = ['<>', 6];
            $conds['p.deleted_at'] = ['exp','is null']; 
            
            /*
             * 临时本地注释测试end_0711
             */
            
            if($sex)
            {
                $conds['t.sex'] = ["=",$sex];
            }
            if($level == 'zero')
            {
                $conds['t.level'] = ["=",0];
            }
            elseif($level != 'all')
            {
                $conds['t.level'] = ["=",$level];
            }
            
            if($server_street)
            {
                $conds['t.street_id'] = ["like","%$server_street%"];
            }
            
            $conds = array_filter($conds); 
            
           // return json($fileds_);
            $fileds = array_merge($fileds_, ['p.type_user','p.cate_id','p.shop_price','p.id', 'p.name', 'p.price','p.market_price', 'p.images', 'p.duration', 'p.summary', 'p.sell_count', 'p.thumb','s.product_id','s.stylist_id','t.nick','t.real_name','t.level','t.sex','t.store_type','t.store_name']);
            $fileds = array_unique($fileds);
            
             $tb_stylist_service_c =$tb_stylist_service;
             
          
          $res['page'] = intval($page);
          $res['page_size'] = intval($page_size);; 
          $res['count'] =  Db::name($this->tb_product)->alias('p')->join($join)->where($conds)->order($order_by, $order_rule)->field($fileds)->group('p.id')
            ->select();
          
            $res['count']=count($res['count']);
            
          
            
            $res['result'] =  $tb_stylist_service
            ->where($conds)
            ->order($order_by, $order_rule)
            //->fetchSql(true)
            ->field($fileds)
            ->page($page,$page_size)
            ->group('p.id')
            ->select();
            
            //return json($res['result']);
            
            if($res['result']){
                foreach ($res['result'] as &$val)
                {
                    if($val['type_user'] ==2)
                    {
                        $val['stylist_id']=null;
                        $val['real_name']='俏猫';
                        $val['level']=null;
                        $val['nick'] = '';
                      
                    }
                }  
            }
          
            
 
            if ( !empty($res['result']) &&  is_array($res['result']) ) {
                foreach ($res['result']       as  $res_key =>$res_val     ) {
                    $res['result']["$res_key"]['product_favorite_count'] = Db::name('user_favorite')->where('pid', '=', $res_val['id'])->cache(100)->count();
                     
                    @$thumb=explode("," , $res_val["thumb"] ) ;
                    @$image=explode("," , $res_val["images"] ) ;
                    $thumb= isset( $thumb[0] )  && trim($thumb[0]) ? $thumb[0]:(  isset($image[0])  && trim($image[0]) ?$image[0]:'') ;
                    if (  strpos(  $thumb , "http" ) > -1  ) {
                        $res['result']["$res_key"]["thumb"]= $thumb;
                    }else{
                        
                        $res['result']["$res_key"]["thumb"]= config("image.urlinfo") . "/upload/" . $thumb;
                    }
                }
            }
    
        } else {
            $res['result'] = [];
        }
    
        
        $hot_search_res = Db::name('config')->where(['key' => 'hotkeyword'])->field(['value'])->find();
        $hot_search = unserialize($hot_search_res['value'])['data'];
        //匹配URL
        
        $rule = '/^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/';
       
        if (  isset($hot_search["title"])  && !empty($hot_search["title"]) ) {
            foreach ($hot_search['link'] as $key => $v) {
                if (preg_match($rule, $v)) {
                    $hot_search['type'][$key] = 2;
                } else {
                    $hot_search['type'][$key] = 1;
                }
            }
    
            for ($i = 1; $i <= count($hot_search['title']); $i++) {
                $input_data[$i - 1] = [
                    'name' => $hot_search['title'][$i],
                    'value' => $hot_search['link'][$i],
                    'type' => $hot_search['type'][$i]
                ];
            }
           
        } else {
           
            $input_data = [];
        }
        
        $res['hot_search'] = $input_data;
        
        if($res)
        {
            $return = [
                'status' => 'ok',
                'msg' => 'success',
                'data' => $res,
            ];
        }else {
            $return = [
                'status' => 'error',
                'msg' => '暂无相关的产品,俏小猫会努力添加的!',
                'data' => $res,
            ];
        }
        
        
        return json($return);
    
        
    }
    
    
    /**
     * 
     * @api {post} qiaomao/qm_product_list 显示服务产品的列表[qiaomao/qm_product_list]
     * @apiVersion 2.0.0
     * @apiName qm_product_list
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_list
     * 
     * @apiParam {string}  fileds 要查询的字段，多个字段用逗号隔开
     * @apiParam {bool} status 作品审核状态,1为未审核的作品
     * @apiParam {bool} stylist_id 查询指定造型师提供服务的产品
     * @apiParam {bool} id 服务产品的ID
     * @apiParam {int} cate_id 分类ID
     * @apiParam {string} name 服务产品的名字
     * @apiParam {string} city 服务产品所服务的城市
     * @apiParam {int} page default is 1
     * @apiParam {int} page_size default is 10
     * @apiParam {string} sort_by 根据字段排序
     * @apiParam {string} sort_rule desc|asc
     * @apiParam {bool} type 按产品类型
     * @apiParam {bool} tag_id 1为精品，2为新品，3为促销，4为热销
     * @apiParam {bool} offline
     * @apiParam {string} tag 表示标签
     * @apiParam {int} service_form 1为美业师上门  2为顾客到店
     * @apiParam {int} service_object 1为用户1对1服务 2为团体服务 3为个体拼单服务
     * @apiParam {int} label 1-新品  2-热销  3-促销  4-打包套装 5-赠品 6-活动  7-秒杀
     * @apiParam {int} cate_id_2  一级分类下的二级分类数字,一般为 6 7 8 9 10 11 12 13 。。。
     * @apiParam {int} price_start $price_end 价格区间【0,999999】默认
     * @apiParam {int} index 该字段用于首页的取产品为双数
     * @apiParam {int} type_user 	区别服务是谁添加 2俏猫平台添加 1美业师自己添加 
     * 
     *     
     */
     
    public function product_list()
    {
        $fields = (input("fields")) ?input("fields"):'';
        $status = (input("status")) ?input("status"):false; 
        $stylist_id = (input("stylist_id")) ?input("stylist_id"):false; 
        $id = (input("id")) ?input("id"):false; 
        $cate_id = (input("cate_id")) ?input("cate_id"):0; 
        $name = (input("name")) ?input("name"):''; 
        $city = (input("city")) ?input("city"):''; 
        $page = (input("page")) ?input("page"):1; 
        $page_size = (input("page_size")) ?input("page_size"):10; 
        $sort_by = (input("sort_by")) ?input("sort_by"):''; 
        $sort_rule = (input("sort_rule")) ?input("sort_rule"):'desc';
        $type = (input("type")) ?input("type"):false; 
        $tag_id = (input("tag_id")) ?input("tag_id"):false; 
        $offline = (input("offline")) ?input("offline"):false; 
        $label = (input("label")) ?input("label"):false; 
        $tag = (input("tag")) ?input("tag"):false; 
        $service_form = (input("service_form")) ?input("service_form"):false; 
        $service_object = (input("service_object")) ?input("service_object"):false; 
        $cate_id_2 = (input("cate_id_2")) ?input("cate_id_2"):0; 
        $duration_start = (input("duration_start")) ?input("duration_start"):1;
        $duration_end = (input("duration_end")) ?input("duration_end"):9999; 
        $price_start = (input("price_start")) ?input("price_start"):false; 
        $price_end = (input("price_end")) ?input("price_end"):false; 
        $index = (input("index")) ?input("index"):false;
        $type_user = (input("type_user")) ?input("type_user"):false;
        

        if( isset($sort_by) &&  !$sort_by  &&  strtolower($sort_rule) =='asc') {
            $sort_rule=" desc  ";
        }
        $sort_by= $sort_by?$sort_by:"add_time" ;
    
        $fields = empty($fields) ? [] : explode(',', $fields);
        $type = $cate_id ?: $type;
        //兼容ios
       
        if ($cate_id < 0) {
            $t_id = abs($cate_id);
            return $this->getProductByTag($t_id, $page, $page_size, $sort_by, $sort_rule, $type, $offline);
        }
    
        if ($tag_id > 1000) {
            return $this->getProductByTag($tag_id, $page, $page_size, $sort_by, $sort_rule, $type, $offline);
        }
        $conds = [
            'cate_id' => $cate_id,
            'name' => $name,
            //'type' => ['not in', [16, 32, 1024]]
        ];
       
        if($type_user)
        {
            $conds['type_user'] = $type_user;
        }
        
        
        
        if ($type) {
            //			$conds['type'] = $type;
            $conds['cate_id'] = $type;
        }
    
        if ($label) {
            $conds['label'] = $label;
        } else {
            $conds['label'] = ['<>', 6];
        }
    
        //todo $fields = array_only($fields, []); // for secure
        $db = Db::name($this->tb_product);
        $conds = array_filter($conds);
        $conds['online'] = (!$offline + 0);
        
        if ($id) {
            $conds['id'] = $id;
          
        } else {
           
            if ($stylist_id = intval($stylist_id)) {
                $stylist_product = Db::name($this->tb_stylist_product)->where(['stylist_id' => $stylist_id, 'status' => 1, 'action' => 1])->select();
                
                if ($status) {
                    $stylist_product = Db::name($this->tb_stylist_product)->where(['stylist_id' => $stylist_id, 'status' => ['in', [0, 1]], 'action' => 1])->select();
                    //如果造型师没有审核中和已经审核的产品，则会返回所有产品信息
                    if (empty($stylist_product)) {
                        $conds['id'] = ['>', 0];
                    } else {
                        $service_pids = [];
                        foreach ($stylist_product as $v) {
                            $service_pids[] = $v['product_id'];
                        }
                        $conds['id'] = ['not in', $service_pids];
                    }
                } else {
                    if (empty($stylist_product)) {
                        $array = array(
                            //'1' => ['1000171', '1000165', '1000146', '1000068'],
                            '1' => ['1000290', '1000025', '1000167', '1000068','1000054','1000344'],
                            '2' => ['1000205', '1000142', '1000141', '1000118'],
                            '3' => ['1000194', '1000193'],
                        );
                       
                        $stylis_type = Db::name('stylist')->where(['id' => $stylist_id])->field(['type'])->find();
                        
                        $stylis_type = explode(',', $stylis_type['type']);
                        $proids = array();
                        foreach ($stylis_type as $v) {
                            foreach ($array[$v] as $v2) {
                                array_push($proids, $v2);
                            }
                        }
                        $conds['id'] = ['in', $proids];
                    } else {
                        $service_pids = [];
                        foreach ($stylist_product as $v) {
                            $service_pids[] = $v['product_id'];
                        }
    
                        $conds['id'] = ['in', $service_pids];
                    }
                }
            }
        }
        if ($tag_id) {
            $conds['label'] = ['like', "%$tag_id%"];
        }
        if ($tag) {
            $conds['tag'] = ['like', "%$tag%"];//标签
        }
        if ($service_form) {
            $conds['service_form'] = $service_form;//服务形式
        }
        if ($service_object) {
            $conds['service_object'] = $service_object - 1;//服务对象
        }
        if ($cate_id_2) {
            $cate_id_2_arr = explode(",", $cate_id_2);
            if (is_array($cate_id_2_arr) && isset($cate_id_2_arr[1])) {
                $conds['cate_id_2'] = ["in"];
                foreach ($cate_id_2_arr as $k => &$v) {
                    $conds['cate_id_2'][1][$k] = $v;//二级分类
                }
            } else {
                $conds['cate_id_2'] = $cate_id_2;//二级分类
            }
        }
        if ($price_start || $price_end) {
            $price_end = $price_end < 0 ? abs($price_end) : $price_end;
            $price_start = $price_start < 0 ? abs($price_start) : $price_start;
    
            $price_start = sprintf("%.2f", $price_start);
            $price_end = sprintf("%.2f", $price_end);
            empty($price_start) && !isset($price_start) ? "0.01" : $price_start;
            empty($price_end) && !isset($price_start) ? "99999.00" : $price_end;
            if ($price_start > $price_end) {
                list($price_start, $price_end) = array($price_end, $price_start);
            }
            $conds['price'] = ['between', [$price_start, $price_end]];
    
        }
      
        if (!empty($city)) {
            $conds['city'] = ['like', "%$city%"];
        }
    
        if (!(empty($fields) || in_array('id', $fields))) {
            $fields[] = 'id';
        }
        if (isset($duration_start) || isset($duration_end)) { //时间条件筛选搜索
            $duration_start = intval($duration_start);
            $duration_end = intval($duration_end);
            !empty($duration_start) ? $duration_start : 1;
            !empty($duration_end) ? $duration_end : 9999;
            if ($duration_start > $duration_end) {
                list($duration_start, $duration_end) = array($duration_end, $duration_start);
            }
            $conds['duration'] = ['between', [$duration_start, $duration_end]];
        }
    
        
        $conds['deleted_at'] = ['null', true];
        
    
        $prods = $db->page($page, $page_size < 100 ? $page_size : 10)
        ->order([$sort_by => ($sort_rule == 'desc' ? 'desc' : 'asc')])
        ->where($conds)
        ->where('id','<>',1000478)
        ->field(array_diff($fields, ['stylist']))
        ->select();
        
        $prods_count =Db::name($this->tb_product)->order([$sort_by => ($sort_rule == 'desc' ? 'desc' : 'asc')])
        ->where($conds)
        ->where('id','<>',1000478)
        ->field(array_diff($fields, ['stylist']))
        ->count();
        
       
        $view_produdts = '' ; /// 浏览的商品
        foreach ($prods as &$prod) {
            if (!empty($prod['images'])) {
                $prod['images'] = $this->url($prod['images']);
            }
            if (isset($prod['thumb']) && !empty($prod['thumb'])) {
                $prod['thumb'] = $this->url($prod['thumb']);
            }
            //if (empty($fields) || in_array('stylist', $fields)) {
                
            if ($prod['type_user'] ==1) {
                $prod['stylist'] = Db::name($this->tb_stylist_service)->alias('s')->join("$this->tb_stylist t", 't.id=s.stylist_id')
                ->where([
                    's.product_id' => $prod['id'],
                    //'t.is_online' => 2
                ])->field(['real_name','level','aptitude','ccc','nick','type','user_img','street_id','stylist_id','store_name','store_type',' busy_time','business_week','business_start','business_end','up_store','store_add','is_business'])->find();
                 
                //$prod['stylist'] = $stylist_id ? [$stylist_id] : array_column(Db::name('stylist_ser')->where('product_id', 'like', '%,' . $prod['id'] . ',%')->select(), 'stylist_id');
            }else {
                $prod['stylist'] =[];
            }
            if (!empty($prod['cate_name'])) {
                $prod['cate_name'] = array_column(Db::name('product_category')->where('id', $prod['cate_id'])->select(), 'name');
            }
            $view_produdts.=  "|" .$prod['name'] ;
            
            $prod['product_favorite_count'] = Db::name('user_favorite')->where('pid', '=', $prod['id'])->count();
        }
        
        if(if_cookie())
        {
            $user_info = user_info();
           // $this->postDataAnalysis( 2 , '浏览商品 '.$view_produdts ,  $_SERVER['REQUEST_URI'] , $user_info["id"]  , $user_info["mobile"],  0 , date("Y-m-d H:i:s") ,'' ,  $user_info['last_login_ip']); ////提交数据分析数据
            
            // $this->postDataAnalysis( 2 , '浏览商品 '.$view_produdts ,  $_SERVER['REQUEST_URI'] ,get_cookie()["id"]  , '',  0 , date("Y-m-d H:i:s") ,'' ,  '' ); ////提交数据分析数据
            
        }
        
       
      
        if (count($prods) % 2 == 1 && $index) {
            array_pop($prods);
        }
        //dump($prods);
        $return = [
            'status' => 'ok',
            'msg' => 'success',
            'count' => $prods_count,
            'data' => $prods,
        ];
       
        return json($return);
    }
    
    /**
     * @api {post} qiaomao/qm_product_info 俏猫-商品详情页接口[qiaomao/qm_product_info]
     * @apiVersion 2.0.0
     * @apiName qm_product_info
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_info
     *
     * @apiParam {Int} product_id 产品id
     * @apiParam {String} ext 查询字段stylists
     * @apiParam {String} stylist_id  美业师id
     * @apiParam {String} online 是否上线产品默认1
     * @apiParam {String} ly 默认qt  
     * @apiParam {Bool}  is_order 选填 下单页获取商品详情填写true
     *
     */
    public function product_info()
    {
        
        $product_id = (input("product_id")) ?input("product_id"):'';
        $ext = (input("ext")) ?input("ext"):'stylists';
        $online = (input("online")) ?input("online"):1; 
        $ly = (input("ly")) ?input("ly"):'ht';
        $stylist_id = (input("stylist_id")) ?input("stylist_id"):false;
        
        $is_order = (input("is_order")) ?input("is_order"):false; //判断是否下订单页面获取商品详情，返回用户资料和余额
        
        ///print_r ( $this->user()["id"] )  ;
        ///die();
        $ext = explode(',', $ext);
    
        $data = [
            'id' => intval($product_id),
        ];
    
        if ($online != 'all') {
            $data['online'] = intval($online);
        }
    
        ////die("1");
        if ($prod = Db::name($this->tb_product)->where($data)->find()) {
    
            if (isset($product_id) && $product_id) {
                $prod = Db::name($this->tb_product)->where($data)->find();
                //此处加入点击量的统计
                $click_count = $prod['click_count'];
                //			print_r($click_count);exit;
                $info = [
                    'id' => $product_id,
                    'click_count' => $click_count + 1
                ];
                Db::name($this->tb_product)->update($info);
            }
            $rid  =  [ 1000360 , 1000361] ;  ///
            if ($ly != 'ht') {
    
                if ($prod['label'] == 6   &&  !in_array($product_id ,  $rid  ) ) {
                    return json_error('所请求产品[' . $product_id . ']并不存在或为活动产品');
                }
            }
    
    
            $prod_images = explode(',', $prod['images']);
            foreach ($prod_images as &$prod_img) {
                if ($prod_img != '') {
                    $prod_img = $this->url($prod_img);
                }
            }
            $prod['images'] = implode(',', $prod_images);
    
            if (isset($prod['thumb']) && !empty($prod['thumb'])) {
                $prod['thumb'] = $this->url($prod['thumb']);
            }
    
            $prduct_extra_text = Db::name('config')->where(['key' => 'prduct_extra_text'])->field(['value'])->find();
            $prod['prduct_extra_text'] = $prduct_extra_text['value'];
            $prod['stylists'] = [];
            $prod['product_favorite_count'] = Db::name('user_favorite')->where('pid', '=', $prod['id'])->count();
            if ($prod['type_user'] ==1) {
                $prod['stylists'] = Db::name($this->tb_stylist_service)->alias('s')->join("$this->tb_stylist t", 't.id=s.stylist_id')
                ->where([
                    's.product_id' => $prod['id'],
                    //'t.is_online' => 2
                ])->field(['level','aptitude','ccc','nick','type','user_img','street_id','stylist_id','store_name','store_type',' busy_time','business_week','business_start','business_end','up_store','store_add','is_business'])->select();
               
                if(!empty(($prod['stylists'])))
                {
                    
                    $prod['stylists'][0]['server_street_name'] = Address::getStreetName_($prod['stylists'][0]['street_id']);
                }
               
                $prod['store_coupon'] = Db::name('coupon')
                ->where([
                    'store_id' => isset($prod['stylists'][0]['stylist_id'])?$prod['stylists'][0]['stylist_id']:0,
                    'online' => 1
                ])->order(['id'=>'desc'])->page(1,5)->select();
                
                if($prod['store_coupon'] && if_cookie())
                {
                    $user_id = user_info()['id'];
                    foreach ($prod['store_coupon'] as &$val)
                    {
                                          
                       $have_count = Db::name('user_coupon_cash')->where(['coupon_id' => $val['id'], 'user_id' => $user_id])->count();
                       $val['user_have_count'] = $have_count;
                    }
                }
                
                
                foreach ($prod['stylists'] as &$stylist) {
                    $stylist['user_img'] = $this->url($stylist['user_img']);
                    $stylist['busy_time'] =json_decode($stylist['busy_time'],true);
                   
                } 
                
                if(count($prod['stylists']) >1) $prod['stylists'] =[];//美业师多个为空
            }elseif($prod['type_user'] ==2 && $stylist_id && $stylist_id >0){
                $prod['stylists'] = Db::name($this->tb_stylist)->alias('t')
                ->where([                
                    't.id' => $stylist_id,
                    't.is_business' => 2
                ])->field(['level','aptitude','ccc','nick','type','user_img','street_id','id as stylist_id','store_name','store_type',' busy_time','business_week','business_start','business_end','up_store','store_add','is_business'])->select();
                 
                if(!empty(($prod['stylists'])))
                {
                
                    $prod['stylists'][0]['server_street_name'] = Address::getStreetName_($prod['stylists'][0]['street_id']);
                }
                 
                $prod['store_coupon'] = Db::name('coupon')
                ->where([
                    'store_id' => isset($prod['stylists'][0]['stylist_id'])?$prod['stylists'][0]['stylist_id']:0,
                    'online' => 1
                ])->order(['id'=>'desc'])->page(1,5)->select();
                
                if($prod['store_coupon'] && if_cookie())
                {
                    $user_id = user_info()['id'];
                    foreach ($prod['store_coupon'] as &$val)
                    {
                
                        $have_count = Db::name('user_coupon_cash')->where(['coupon_id' => $val['id'], 'user_id' => $user_id])->count();
                        $val['user_have_count'] = $have_count;
                    }
                }
                
                
                foreach ($prod['stylists'] as &$stylist) {
                    $stylist['user_img'] = $this->url($stylist['user_img']);
                    $stylist['busy_time'] =json_decode($stylist['busy_time'],true);
                     
                }
                
                if(count($prod['stylists']) >1) $prod['stylists'] =[];//美业师多个为空
                
            }
    
            if ( !get_magic_quotes_gpc()  &&  isset($_GET["addslashes"]) ) {
                @$prod['description'] = trim(strip_tags($prod['description'])) ?  addslashes($prod['description']):'';
            }
            $meta = $this->metadata($this->tb_product,$prod['id']);
            $prod['user_favorite'] =0;
            if($is_order){
                
               
                //订单页详情 产品所属美业师空闲时间+用户所属产品优惠卷+用户基本资料（包含地址，余额等）
                //首先用户登录状态下
                if(!if_cookie())
                {
                    return json_nologin();
                }
                //用户基本资料
                $user_info_return = new User();
                $prod['user_info'] = $user_info_return ->profile_get_return();
                
                $user_id = user_info()['id'];
                
                $prod['user_old_shipping'] = Db::name('order_shipping')->where(['buyer_id' => $user_id])->field(['consignee','mobile'])->order(['id' => 'desc'])->find();
                
               // return json_ok($prod['user_info']);
                //获取用户所属产品的优惠卷列表
                $user_coupon = new Coupon();
                if(!empty($prod['stylists']))
                {
                    $store_id = $prod['stylists'][0]['stylist_id'];
                }else {
                    $store_id=0;
                }
                $prod['user_coupon'] = $user_coupon->coupon_list_return($store_id,false,'c.store_id,c.base_amount,c.coupon_value,p.*',$prod['id']);
                //获取用户地址
                $user_address = new Address();
               
                $prod['user_address'] = $user_address->user_address_list_return();
                
                if(!empty($prod['stylists']))
                {
                    $seller_id = $prod['stylists'][0]['stylist_id'];
                   
                    $contact['send_time'] = date('Y-m-d 00:00:00'); //测试
                    
                    $order_send_time_start = $contact['send_time'];
                    $order_send_time_end = date('Y-m-d H:i:s', strtotime($contact['send_time']) + 3600 * 23);
                    $prod['stylist_busy_time']  = (new Stylist())->getTimeNew($seller_id, $order_send_time_start, $order_send_time_end, 2);
                    
                }
                
                $prod['user_favorite'] = Db::name('user_favorite')->where(['uid' => $user_id, 'pid' => $prod["id"]])->count();
                if($prod['user_favorite'] >1) $prod['user_favorite']=1;
               
                
            }else {
                //普通商品详情页详情 商品评论+推荐产品
                if(if_cookie())
                {
                    $user_info = user_info();
                    // return json($user_info) ;
                    $this->postDataAnalysis( 3 , '浏览商品|'.$prod["name"].'|'.$prod["id"] , $_SERVER['REQUEST_URI']  , $user_info["id"]  , $user_info["mobile"],  0 , date("Y-m-d H:i:s") ,'' ,  $user_info['last_login_ip'],$prod["id"]); ////提交数据分析数据
                
                    $this->postDataAnalysis(5, '浏览商品足迹|'.$prod["name"].'|'.$prod["id"] , $_SERVER['REQUEST_URI']  , $user_info["id"]  , $user_info["mobile"],  0 , date("Y-m-d H:i:s") ,'' ,  $user_info['last_login_ip'],$prod["id"]); ////提交数据分析数据
                    
                    $prod['user_favorite'] = Db::name('user_favorite')->where(['uid' => $user_info["id"], 'pid' => $prod["id"]])->count();
                    if($prod['user_favorite'] >1) $prod['user_favorite']=1;
                }
               
                 
                
                $prod['comments_count'] =count($this->getComments($product_id));
                $prod['comments'] = $this->getComments($product_id,5);
                
                if($prod['comments'])
                {
                    foreach ($prod['comments'] as &$v)
                    {
                        $huifu = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',3)->field(['comment','created_at'])->cache(100)->find();
                        if($huifu){
                            $v['huifu'] = $huifu;
                        }else{
                            $v['huifu'] = [];
                        }
                        $zhuijia = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',2)->field(['comment','images','created_at'])->cache(100)->find();
                         if($zhuijia){
                             $v['zhuijia'] = $zhuijia;
                         }else{
                             $v['zhuijia'] = [];
                         }
                    }
                }
                
                
                
            
                 
                 
                $prod['commend'] = $this->getProductByTag(7);
            }
           
          
             $return = array_replace($prod, $meta);
            
            $return = [
                'status' => 'ok',
                'msg' => 'success',
               
                'data' => $return,
            ];
            return json($return);
        } else {
           
            $return = [
                'status' => 'error',
                'msg' => '所请求产品[' . $product_id . ']并不存在',
                'data' => '',
            ];
            return json($return);
        }
    }
    
    /**
     * @api {post} qiaomao/qm_product_get_comments 俏猫-商品评论列表[qiaomao/qm_product_get_comments]
     * @apiVersion 2.0.0
     * @apiName qm_product_get_comments
     * @apiGroup qiaomao_Product
     * @apiSampleRequest qiaomao/qm_product_get_comments
     *
     * @apiParam {Int} product_id 产品id
     * @apiParam {String} type 评论类型|全部：all|好评：good|中评：normal|差评：bad|有图：picture|
     * @apiParam {Int} page 
     * @apiParam {Int} page_size 
     *
     */
    public function product_get_comments()
    {
       // all、good、normal、bad、picture
       
        $product_id = (input("product_id")) ?input("product_id"):'';
        $page = (input("page")) ?input("page"):1;
        $page_size = (input("page_size")) ?input("page_size"):10;
        $type = (input("type")) ?input("type"):'all';
        
       
        $return = $this->getComments($product_id,$page_size,$page,$type);
        
        if($return)
        {
            foreach ($return as &$v)
            {
                $huifu = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',3)->field(['comment','created_at'])->cache(100)->find();
                if($huifu){
                    $v['huifu'] = $huifu;
                }else{
                    $v['huifu'] = null;
                }
                $zhuijia = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',2)->field(['comment','images','created_at'])->cache(100)->find();
                if($zhuijia){
                    $v['zhuijia'] = $zhuijia;
                }else{
                    $v['zhuijia'] = null;
                }
            }
        }
        
        $data['all_comments_count'] = count($this->getComments($product_id,100000,1,'all'));
        $data['good_comments_count'] = count($this->getComments($product_id,100000,1,'good'));
        $data['normal_comments_count'] = count($this->getComments($product_id,100000,1,'normal'));
        $data['bad_comments_count'] = count($this->getComments($product_id,100000,1,'bad'));
        $data['picture_comments_count'] = count($this->getComments($product_id,100000,1,'picture'));
        
        
        $data['count'] = count($this->getComments($product_id,100000,1,$type));
        $data['page'] = $page;
        $data['page_size'] = $page_size;        
        $data['result'] = $return;
       
        
        
        return json_ok($data);
        
        
    }
    
    public function getComments($product_id = 0, $page_size = 100000, $page = 1,$type_=FALSE,$order_id = 0,$stylist_id = false,$type = false, $parent_id = false, $online = 0)
	{
	    $type= $type_;
	    
		$order_id = intval($order_id);
		$product_id = intval($product_id);
		if ($order_id || $product_id || $stylist_id) {
			$page = intval($page);
			$page_size = intval($page_size);
			//$page_size = $page_size > 30 ? 10 : $page_size;
			$conds = ['c.order_id' => $order_id, 'c.product_id' => $product_id, 'c.parent_id' => $parent_id];
			$conds['c.deleted_at'] = ['exp','is null'];
			$conds['c.cont_type'] = ['=','1'];
			$conds['c.status'] = ['=','1'];
			$conds['c.is_show'] = ['=','1'];
			
			
			$conds = array_filter($conds);
			
			$fileds = ['c.*', 'u.avatar'];
			//$fileds = array_unique($fileds);
			
			if($type)
			{
			    switch ($type)
			    {
			     //   好 对应 5星、中 对应 3 4星 、差 1 2星
			        case "good":
			            $conds['c.score'] = 5;
			            break;
		            case "normal":
		                $conds['c.score'] = ['in',[3,4]];
		                break;
                    case "bad":
                        $conds['c.score'] = ['in',[1,2]];
                        break;
                    case "picture":
                        //$conds['c.images'] = ['exp','is not null'];
                        $conds['c.images'] = ['<>',''];
                        
                        break;
			       default:
			           
			            
			            
			            
			    }
			    
			}
			
			//return $conds;
			
			$model = Db::name($this->t_product_comment)->alias('c')->join("user u", 'c.user_id=u.id');
			
			$res = $model->where($conds)->order(['c.id' => 'desc'])->field($fileds)->page($page, $page_size)->select();
			
			
			return $res;
			
			
		} else {
			return [];
		}
	}
	
	/**
	 * @api {post} qiaomao/qm_product_commend 俏猫-为你推荐[qiaomao/qm_product_commend]
	 * @apiVersion 2.0.0
	 * @apiName qm_product_commend
	 * @apiGroup qiaomao_Product
	 * @apiSampleRequest qiaomao/qm_product_commend
	 *
	 *
	 */
	
	public function product_commend()
	{
	    
	    $data = $this->getProductByTag(7,1,10,'p.id');
	    
	    foreach ($data as &$v)
	    {
	        $v['product_favorite_count'] =Db::name('user_favorite')->where('pid', '=', $v['id'])->count();;
	    }
	    return json_ok($data);
	    
	}
	
	
	public function getProductByTag($tag_id = '', $page = 1, $page_size = 10, $sort_by = 'sort', $sort_rule = 'desc', $type = false, $offline = false)
	{
	    //是否是父分类
	    $parent = Db::name($this->tb_tag)->where(['parent_id' => $tag_id])->select();
	    $tag_ids = [];
	
	    if ($parent) {
	        foreach ($parent as $p) {
	            $tag_ids[] = $p['id'];
	        }
	    }
	
	    $tag_ids[] = $tag_id;
	
	    $conds = [];
	
	    if (empty($tag_ids) && $type) {
	        //			$conds['type'] = $type;
	        $conds['p.cate_id'] = $type;
	    }
	
	    if ($tag_ids) {
	        $conds['g.tag_id'] = ['in', $tag_ids];
	    }
	
	    $field = ['p.id', 'p.name', 'p.market_price','p.price','p.promotion_price', 'p.images', 'p.duration', 'p.sell_count'];
	    $conds = array_filter($conds);
	    $conds['online'] = (!$offline + 0);
	    
	    
	    $res = Db::name($this->tb_product)
	    ->alias('p')->join("$this->tb_product_tag g",'p.id = g.product_id','left')
	    //->join('product_tag tg', 'p.id=tg.product_id', 'left')
	    ->where(['p.online'=>1,'p.deleted_at'=>['exp','is null']])
	    //->where($conds)
	    ->page($page, $page_size)
	    ->order($sort_by, $sort_rule)
	    ->field($field)
	    ->group('p.id')
	    ->select();
	
	    foreach ($res as &$v) {
	        if (!empty($v['images'])) {
	            $l = stripos($v['images'], ',');
	            $l = $l ?: strlen($v['images']);
	            $v['images'] = $this->url(substr($v['images'], 0, $l));
	        }
	    }
	
	    return $res;
	}
    
    /**
     * Get/update all the meta data of the object
     * @param int|string $iid object id
     * @param bool|array $data
     * @return array
     */
    protected function metadata($table,$iid, $data = false)
    {
        $meta_op = Db::name($table . '_meta');
        if (!empty($data))
        {
            
            $data = empty($this->meta_sets) ? $data : array_only($data, $this->meta_sets);
            foreach ($data as $k => $v)
            {
                $this->meta($iid, $k, $v);
            }
        }
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
    
      protected function url($url)
    {
    
        return starts_with($url, 'http://') ? $url : config('image.urlinfo') . '/upload' . $url;
    }
    
    protected function postDataAnalysis($type = '1', $note = 'test', $action = 'test', $user_id = '', $mobile = '', $residence_time = '', $date_added = '', $ad_source = '', $last_login_ip = '', $data_ext = '')
    {
        
        ///  保存数据分析基础数据
        $dev = 0;  //  是否调试模式
        if ($user_id && $dev == 0) {
            $row = Db::name("data_analysis")->order(["id" => 'desc'])->where("type", ">", 1) ->where(["user_id" => $user_id])
            ->field(["id", 'date_added'])->find();
            ///print_r($row);
            if (isset($row["id"]) && isset($row['date_added']) && $row['date_added']) {
                $residence_time = time() - strtotime($row['date_added']);
                Db::query(" update m2_data_analysis    set   residence_time= '$residence_time'  where id ='$row[id]'  ");
            }
            return Db::query("  insert into  m2_data_analysis set   `type`='$type' ,  note='$note' ,  action='$action' ,    user_id ='$user_id' , mobile='$mobile' , residence_time='$residence_time' ,   date_added=now() ,  ad_source='$ad_source', last_login_ip='$last_login_ip', data_ext='$data_ext'    ");
        }
    }
    
    
}