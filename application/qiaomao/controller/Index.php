<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;
use app\qiaomao\model\Tree;


/**
 * 俏猫首页类
 */
class Index extends Controller{
    
   
    private $category_table = 'product_category';

    
    /**
     *
     * @api {post} qiaomao/qm_index_recommende_list 俏猫-首页推荐[qiaomao/qm_index_recommende_list]
     * @apiVersion 2.0.0
     * @apiName qm_index_recommende_list
     * @apiGroup qiaomao_Index
     * @apiSampleRequest qiaomao/qm_index_recommende_list
     *
     */
    public function index_recommende_list()
    {   
        $user_info = user_info();
        $where['code'] = 'recommende';
        $data = Db::name('ad_category')->where($where)->cache(100)->find();
        $where_['c.pid'] = $data['id'];
        $where_['a.is_online'] = 1;
        
        $data_ = Db::name('ad_category')->alias('c')->join('ad a','c.id=a.second_category_id')->where($where_)->cache(100)->order('c.id,a.sort')->select();
        
        $return=[];
        $return_=[];
       
        foreach ($data_ as $key=>$val)
        {
                $val['image'] = $this->url($val['image']);
                if($val['ad_type'] ==2)
                {
                  $val['stylist']  =  Db::name('stylist')->field(['id','real_name', 'level','store_type','store_name'])->where(['id'=>$val['link']])->cache(100)->find();
                  /* if($val['stylist'])
                  {
                      $val['stylist']['user_img'] = $this->url($val['stylist']['user_img']);
                  } */
                }
                
                if($val['ad_type'] ==3)
                {
                    $field = ['p.id', 'p.name', 'p.price','p.market_price', 'p.duration','p.click_count', 'p.sell_count', 'p.thumb','p.type_user'];
                    
                    
                     
                    
                    $db = Db::name('product')->alias('p')->where('p.id', '=', $val['link'])->field($field)->cache(100)->find();
                    if($db)
                    {
                        $db['thumb'] =$this->url_p($db['thumb']);
                        $db['product_favorite_count'] = Db::name('user_favorite')->where('pid', '=', $db['id'])->count();
                         
                        
                    }
                    if($db && $db['type_user']==1) 
                    {
                         $field_ = ['s.stylist_id','t.real_name','t.level','t.user_img','t.store_type','t.store_name'];
                         $db['stylist'] = Db::name('stylist_service')->alias('s')->where(['s.product_id'=>$db['id']])->join('stylist t', 's.stylist_id=t.id','left')->field($field_)->find();
                    }else {
                         $db['stylist'] = [];
                    }
                    
                    
                    $val['product'] = $db;
                    
                    
                     
                }
                
               
                $return[$val['category_name']][] = $val;
                 
        }
        
        foreach ($return as $key =>$v)
        {
            $re['title']= $key;
            $re['data'] =$v;
            $return_[] =$re;
            
            
        }
        if(empty($return_))
        {
            $return_[0]['title'] ='';
            $return_[0]['data'] =[];
            
        }
 
        return  json($return_);
    }
    
    
    /**
     *
     * @api {post} qiaomao/qm_index_found_list 俏猫-首页发现[qiaomao/qm_index_found_list]
     * @apiVersion 2.0.0
     * @apiName qm_index_found_list
     * @apiGroup qiaomao_Index
     * @apiSampleRequest qiaomao/qm_index_found_list
     *
     *
     *
     */
    public function index_found_list()
    {
        $user_info = user_info();
        $where['code'] = 'found';
        $data = Db::name('ad_category')->where($where)->cache(100)->find();
        $where_['c.pid'] = $data['id'];
        $where_['a.is_online'] = 1;
    
        $data_ = Db::name('ad_category')->alias('c')->join('ad a','c.id=a.second_category_id')->where($where_)->cache(100)->order('c.id,a.sort')->select();
        
        foreach ($data_ as &$val)
        {
            $val['image'] = $this->url($val['image']);
        }
       return  json($data_);
    }
    
    /**
     * 获取树形分类列表
     *
     */
    /**
     * @api {post} qiaomao/qm_category_get_list 俏猫-服务产品获取树形分类列表[qiaomao/qm_category_get_list]
     * @apiVersion 2.0.0
     * @apiName qm_category_get_list
     * @apiGroup qiaomao_Index
     * @apiSampleRequest qiaomao/qm_category_get_list
     *
     *
     * @apiParam {Int} type  分类id选填 如化妆 1
     *
     */
    
    public function category_get_list($type = false)
    {
        if (isset($type) && $type) {
            //通过第一分类获取二级分类
            $data = Db::name($this->category_table)->where('parent_id', $type)->select();
            $dataParent = Db::name($this->category_table)->where('id', $type)->select();
            $list = array_merge($dataParent, $data);
            $Tree = new Tree();
            $cateTree = $Tree->makeTreeArr($list, 0, ['id' => 'id']);
            return json($cateTree);
        }
        $data = Db::name($this->category_table)->select();
        $Tree = new Tree();
        $cateTree = $Tree->makeTreeArr($data, 0, ['id' => 'id']);
        return json($cateTree);
    }
    
    public function Sql($sql)
    {
       
        $data = Db::query("select $sql limit 100");
        
        return  json_ok($data);
    }
    
    protected function url($url)
    {
    
        return starts_with($url, 'http://') ? $url : config('image.crm_urlinfo') . '/upload' . $url;
    }
    
    protected function url_p($url)
    {
    
        return starts_with($url, 'http://') ? $url : config('image.urlinfo') . '/upload' . $url;
    }
    
    /**
     * @api {post} qiaomao/qm_app_ios 俏猫-app_ios版本号【废除】[qiaomao/qm_app_ios]
     * @apiVersion 2.0.0
     * @apiName qm_app_ios
     * @apiGroup qiaomao_Index
     * @apiSampleRequest qiaomao/qm_app_ios
     *
     *
     *
     *
     */
   /*  public function app_ios()
    {
        $v = "3.2.0";
        $description = "做重大更新";
        $forced_update = 0;
        
        $return = array("v" => $v, 'description' => $description, 'forced_update' => $forced_update);
        
        //json_encode();
        
        //$return = '{"v":"","description":"做重大更新","forced_update":1}';
        
        return json($return);
    } */
    
    /**
     * @api {post} qiaomao/app_stylist_ios 俏猫美业师-app_ios版本号【废除】[qiaomao/app_stylist_ios]
     * @apiVersion 2.0.0
     * @apiName app_stylist_ios
     * @apiGroup qiaomao_Index
     * @apiSampleRequest qiaomao/app_stylist_ios
     *
     *
     *
     *
     */
  /*   public function app_stylist_ios()
    {
        $v = "3.2.0";
        $description = "做重大更新";
        $forced_update = 0;
    
        $return = array("v" => $v, 'description' => $description, 'forced_update' => $forced_update);
    
        //json_encode();
    
        //$return = '{"v":"","description":"做重大更新","forced_update":1}';
    
        return json($return);
    } */
    
    /**
     * @api {post} qiaomao/qm_app_android 俏猫-app_android版本号【废除】[qiaomao/qm_app_android]
     * @apiVersion 2.0.0
     * @apiName qm_app_android
     * @apiGroup qiaomao_Index
     * @apiSampleRequest qiaomao/qm_app_android
     *
     *
     *
     *
     */
   /*  public function app_android()
    {
        $arr = [];
        $arr["v"] = "10520";
        
        $arr["list"][0]["title"] = "官方";
        $arr["list"][0]["url"] = "http://120.24.214.28/app/client/channel/QiaocatClient_1001.apk";
        $arr["list"][0]["code"] = "1001";
        $arr["list"][0]["description"] = "最新又上了好多美丽妆容哦，赶紧来更新体验吧！";
               
        //$return = '{"v":"10520","list":[{"title":"官方","url":"http://120.24.214.28/app/client/channel/QiaocatClient_1001.apk","code":"1001","description":"最新又上了好多美丽妆容哦，赶紧来更新体验吧！"}]}';
          
        return json($arr);
    } */
    
    public function ceshi()
    {
        if(!if_cookie())
        {
           return json_nologin(); 
        }
        $user_info = user_info();
        $msg = "再次感谢小主选择俏猫医美，在您项目体验完成后请到俏猫APP平台确认服务完成，也欢迎您对本次体验服务进行评价。俏猫医美还会不断提供更多的超值体验项目，期待小主的下次宠幸。俏猫医美客服（微信同号）：18922408091。";
        $mobile = $user_info['mobile'];
        $dd = send_yun_text($mobile,$msg);
        $data['send_yun_text'] = $dd;
        $data['msg'] = $msg;
        $data['mobile'] = $mobile;
        $data['user_info'] = $user_info;
        
        
        
        return json($data);
       
    }
   
    
   
    
    
   
 
    
}