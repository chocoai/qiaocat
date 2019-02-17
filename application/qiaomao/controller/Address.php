<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;


/**
 * 俏猫用户地址类
 */
class Address extends Controller{
    
    protected $tb_user_address = 'user_address';
    protected $table = 'user_address';
   
   
    /**
     * @api {post} qiaomao/qm_user_address_list 获取用户地址列表[qiaomao/qm_user_address_list]
     * @apiVersion 2.0.0
     * @apiName qm_user_address_list
     * @apiGroup qiaomao_Address
     * @apiSampleRequest qiaomao/qm_user_address_list
     *
     * @apiParam {int} is_default    选填 1默认0不是
     *
     *
     */
    public function user_address_list()
    {
        
        $is_default =   (input("is_default")) ?input("is_default"):false;
        
        $type =   (input("type")) ?input("type"):false; //android
        
        
            if(!if_cookie())
            {
               return json_nologin();
               
            }
     
            $uid = get_cookie()['id'];
            $conds = ['user_id' => $uid];
            if($is_default){
                $conds['is_default'] = $is_default;
            }
            $list = Db::name($this->tb_user_address)->where($conds)->order(["id" => 'desc'])->select();
            
            if (empty($list)) return json([]);
    
            foreach ($list as &$li)
            {
                $pid = $li['province'];
                $cid = $li['city'];
                $aid = $li['district'];
                $sid = isset($li['street']) ? $li['street'] : 0;
    
                $pName = $this->getProvinceName($pid);
                $cName = $this->getCityName($cid);
                $dName = $this->getAreaName($aid);
                $sName = $this->getStreetName($sid);
    
                $li['province_name'] = $pName;
                $li['city_name'] = $cName == '市辖区' ? $pName : $cName;
                $li['district_name'] = $dName;
                $li['street_name'] = $sName;
    
            }
            if($type =='android')
            {
                return  json_ok($list);
            }else {
                return json($list);
            }
            
        }
        
        
        public function user_address_list_return($is_default = FALSE)
        { 
             
            if(!if_cookie())
            {
                return [];
                 
            }
             
            $uid = get_cookie()['id'];
            $conds = ['user_id' => $uid];
            if($is_default){
                $conds['is_default'] = $is_default;
            }
            $list = Db::name($this->tb_user_address)->where($conds)->order(["id" => 'desc'])->select();
        
            if (empty($list)) return [];
        
            foreach ($list as &$li)
            {
                $pid = $li['province'];
                $cid = $li['city'];
                $aid = $li['district'];
                $sid = isset($li['street']) ? $li['street'] : 0;
        
                $pName = $this->getProvinceName($pid);
                $cName = $this->getCityName($cid);
                $dName = $this->getAreaName($aid);
                $sName = $this->getStreetName($sid);
        
                $li['province_name'] = $pName;
                $li['city_name'] = $cName == '市辖区' ? $pName : $cName;
                $li['district_name'] = $dName;
                $li['street_name'] = $sName;
        
            }
        
            return $list;
        }
        
        
        
        
        
        
        
        /**
         * @api {post} qiaomao/qm_user_save_address 保存用户地址[qiaomao/qm_user_save_address]
         * @apiVersion 2.0.0
         * @apiName qm_user_save_address
         * @apiGroup qiaomao_Address
         * @apiSampleRequest qiaomao/qm_user_save_address
         *
         * @apiParam {String} data    data数据: {"address_id":0,"consignee": "ces", "province": "130000", "city": "130300", "district": "130302", "mobile": "15017580819","address":"详细地址","is_default":0,"street":"BJ-DC-01"}
         *
         *
         */
        public function user_save_address()
        {
            
            $data = (input("data")) ?input("data"):false;
            $data = json_decode($data,true);
            
            if (!if_cookie())
            {
                return json_nologin();
            }
            $user_id = get_cookie()['id'];
            $data = is_array($data) ? $data : unserialize($data);
        
            $data = array_only($data, ['address', 'address_id', 'consignee', 'zipcode', 'mobile', 'best_time', 'province', 'city', 'district','is_default','street']);
        
            $data['user_id'] = $user_id;
            $data['created_at'] = date('Y-m-d H:i:s');
        
            if(array_key_exists('is_default',$data))
            {
                if($data['is_default'] == 1)
                {
                    $uid = $user_id;
                    //先将其它的设置为非默认地址
                    Db::name($this->table)->where('is_default', '=', 1)->where('user_id', '=', $uid)->update(['is_default' => 0]);
                    // 更新用户的地址
                    $update_data = [
                        'id' => $uid,
                        'province_id' => $data['province'],
                        'city_id' => $data['city'],
                        'area_id' => $data['district'],
                        'address' => $data['address'],
                        'street_id' => $data['street'],
                    ];
                    Db::name('user') ->where(['id'=>$uid]) ->update($update_data);
                }
            }
        
            $aid = isset($data['address_id']) ? $data['address_id'] : 0;
            if ($aid < 1)
            {
                unset($data['address_id']);
                try{
                    Db::name($this->table)->insert($data);
                    
                    $data = $this->user_address_list_return();
                    $return =  array(
                        'status' => 'ok',
                        'msg' => '保存成功',
                        'data' => $data,
                    );
                    return json($return);
                }catch (\Exception $e){
                   $return = array(
                        'status' => 'error',
                        'msg' => '保存失败',
                        'data' =>$data
                    );
                    return json($return);
                }
            }
            else
            {
                unset($data['address_id']);
                try{
                    Db::name($this->table)->where('id', '=', $aid)->update($data);
                    $data = $this->user_address_list_return();
                    $return =  array(
                        'status' => 'ok',
                        'msg' => '保存成功',
                        'data' =>$data,
                    );
                    return json($return);
                }catch (\Exception $e){
                    $return = array(
                        'status' => 'error',
                        'msg' => '保存失败',
                        'data' =>$data,
                    );
                    return json($return);
                }
            }
        
        }
        
        /**
         *删除地址
         */
        /**
         * @api {post} qiaomao/qm_user_delete_address 删除用户地址[qiaomao/qm_user_delete_address]
         * @apiVersion 2.0.0
         * @apiName qm_user_delete_address
         * @apiGroup qiaomao_Address
         * @apiSampleRequest qiaomao/qm_user_delete_address
         *
         * @apiParam {Int} addressId   地址id
         *
         *
         */
        public function user_delete_address()
        {
            $addressId = (input("addressId")) ?input("addressId"):'';
            if(!if_cookie())
            {
                return json_nologin();
            }
                $uid = get_cookie()['id'];
                if(!$addressId)
                {
                    return json_error('请选择要删除的地址');
                }
                $return  = Db::name($this->table)->where('id', '=', $addressId)->where('user_id', '=', $uid)->delete();
                
                return json_ok($return,' 删除成功');
        
           
        }
        
        
        
        /**
         *获取省名称
         * @param  int $provinceId
         * @return string
         */
        public function getProvinceName($provinceId)
        {
            $row = Db::name('location_province')->where('province_id', '=', $provinceId)->cache(100)->find();
            return $row ? $row['name'] : '';
        }
        
        /**
         *获取城市名称
         * @param  int $cityId
         * @return string
         */
        public function getCityName($cityId)
        {
            $row = Db::name('location_city')->where('city_id', '=', $cityId)->cache(100)->find();
            return $row ? $row['name'] : '';
        }
        
        /**
         *获取区名称
         * @param  int $areaId
         * @return string
         */
        public function getAreaName($areaId)
        {
            $row = Db::name('location_area')->where('area_id', '=', $areaId)->cache(100)->find();
            return $row ? $row['name'] : '';
        }
        
        /**
         *获取商圈名称
         * @param  int $streetId
         * @return string
         */
        public function getStreetName($streetId)
        {
            $row = Db::name('location_street')->where('street_id', '=', $streetId)->cache(100)->find();
            return $row ? $row['name'] : '';
        }
        
        /**
         *获取商圈名称
         * @param  int $streetId
         * @return string
         */
        static  function getStreetName_($streetId="GZ-TH-01,GZ-TH-02,GZ-TH-03,GZ-TH-04,GZ-LW-02,",$type='array')
        {
          
            
           $field =['s.street_id','s.name as s_name','s.area_id','a.name as a_name'];
           $streetId =  explode(',', $streetId);
           
            $row = Db::name('location_street')->alias('s')->join('location_area a','s.area_id=a.area_id')->where('street_id', 'in', $streetId)->field($field)->order('a_name')->select();
            $return_=[];
            if($row)
            {
                foreach ($row as $key=>$val)
                {
                    $return[$val['a_name']][] = $val;
                }
                
                foreach ($return as $key =>$v)
                {
                    $re['title']= $key;
                    $re['data'] =$v;
                    $return_[] =$re;
                
                
                }  
            }
            
            if($type =='json')
            {
                return json($return_);
            }else {
                return $return_;
            }
            
        }
    
   
    
    
    
    
    
    
    
}