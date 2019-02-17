<?php
namespace app\mon\controller;
use think\Controller;
use think\Db;
use Overtrue\Pinyin\Pinyin;
use think\Cache;

/**
 * 公共类
 */
class City extends Controller{
    
    protected $tb_location_city = 'location_city';
    protected $tb_location_province = 'location_province';
    
        /**
        * @api {post} mon/mon_city_street 城市商圈[mon/mon_city_street]
        * @apiVersion 2.0.0
        * @apiName mon_city_street
        * @apiGroup mon_City
        * @apiSampleRequest mon/mon_city_street
        *
        * @apiParam {int} id    城市id
        * 
        *
        */
    public function city_street()
    {
        $id = (input("id")) ?input("id"):440100;
        //  $id :  城市ＩＤ号
        // 取城市商圈详情
        $city = Db::name("location_city")->where(["city_id" => $id])->find();
        $area = Db::name("location_area")->where(["city_id" => $id])->select();
    
        foreach ($area as $key => $val) {
            $area[$key]['street'] = Db::name("location_street")->where('area_id', "=", $val['area_id'])->order("street_id", 'asc')->select();
        }
    
        return json(['city' => $city, 'area' => $area]);
    }
    
    /**
     * @api {post} mon/mon_get_support_info 获取省市详情[mon/mon_get_support_info]
     * @apiVersion 2.0.0
     * @apiName mon_get_support_info
     * @apiGroup mon_City
     * @apiSampleRequest mon/mon_get_support_info
     *
     * @apiParam {int} province_id    选填 省id
     *
     *
     */
    public function get_support_info()
    {
        $province_id = (input("province_id")) ?input("province_id"):false;
        
        $res = Db::name($this->tb_location_city)->cache(100)->select();
        foreach ($res as $k => $v) {
            $temp[] = $v['province_id'];
        }
        $data = [];
        if ($province_id && in_array($province_id, $temp)) {
            $province = Db::name($this->tb_location_province)->where(['province_id' => $province_id])->cache(100)->find();
            $data[$province_id]['province_name'] = $province['name'];
            $city = $this->getSupportCityByProvince($province['province_id']);
            $data[$province_id]['city'] = $city;
    
           
        } else {
            if (!empty($res)) {
                //取出对应城市
                foreach ($res as $v) {
                    $province = Db::name($this->tb_location_province)->where(['province_id' => $v['province_id']])->cache(100)->find();
    
                    $data[$v['province_id']]['province_name'] = $province['name'];
                    $city = $this->getSupportCityByProvince($province['province_id']);
                    $data[$v['province_id']]['city'] = $city;
    
                    }
    
            }
    
        }
        return json($data);
    }
    
    /**
     * 根据省ID获取支持城市
     * @param $province_id
     * @return mixed
     */
    public function getSupportCityByProvince($province_id)
    {
        $res = Db::name($this->tb_location_city)->where([
            'province_id' => $province_id])->cache(100)->select();
        
        return $res;
    }
    /**
     * @api {post} mon/mon_service_cities 获取市[mon/mon_service_cities]
     * @apiVersion 2.0.0
     * @apiName mon_service_cities
     * @apiGroup mon_City
     * @apiSampleRequest mon/mon_service_cities
     *
     * @apiParam {int} online    开通城市  选填 0不限 1开通
     * @apiParam {String} latitude    经度
     * @apiParam {String} longitude   纬度
     *
     *
     */
    public function service_cities()
    {
      //  $inc_offline = (input("inc_offline")) ?input("inc_offline"):0;
        
        $online =  (input("online")) ?input("online"):true;
        
        $latitude = (input("latitude")) ?input("latitude"):23.16667;
        $longitude = (input("longitude")) ?input("longitude"):113.2333323;
        
      /*   if(Cache::get('service_cities'))
        {
            $result = Cache::get('service_cities');
           return json($result);
        } */
        
        $cities = Db::name($this->tb_location_city)->where([
            /*'longitude' => ['>', 0.01],
             'latitude' => ['>', 0.01],*/
            'is_show' => 1
        ])->cache(100)->select();
        if (!$online) {
            $cities = array_merge(Db::name($this->tb_location_city)->where([
                /*'longitude' => ['<', 0.01],
                 'latitude' => ['<', 0.01],*/
            ])->cache(100)->select());
        }
        //die("1");
        $result = [];
        $hot_cities = [440100, 110100, 440300, 310100, 500100, 330100, 440600];
        $Pinyin =new Pinyin();
        foreach ($cities as $key => $city) {
            if ($city['name'] == '市辖区') {
              $prov = Db::name($this->tb_location_province)->where(['province_id' => $city['province_id']])->cache(100)->find();
                $city['name'] = $prov['name'];
            }
            $city['lat'] = floatval($city['latitude']);
            $city['lon'] = floatval($city['longitude']);
            $city['province_id'] = intval($city['province_id']);
            $city['city_id'] = intval($city['city_id']);
            //$city['spy_name'] = preg_replace('# #','',strtoupper($Pinyin->abbr($city['name'])));
            if(!$city['py_name'])
            {
                $city['py_name'] = preg_replace('# #','',strtoupper($Pinyin->sentence($city['name'])));
                Db::name($this->tb_location_city)->where([
                    
                    'city_id' =>$city['city_id']
                ])->update(['py_name'=>$city['py_name']]);
            }
            //$city['py_name'] = preg_replace('# #','',strtoupper($Pinyin->sentence($city['name'])));
            $city['hit'] = in_array($city['city_id'], $hot_cities);
            $city['distance'] = geo_distance($city['lat'], $city['lon'], floatval($latitude), floatval($longitude));
    
            $result[$city['name']] = array_only($city, ['lat', 'lon', 'province_id', 'city_id', 'py_name','spy_name', 'hit', 'distance']);
        }
        /* $result = array_sort($result, function ($v) {
            return $v['distance'];
        }); */
     
       //Cache::set('service_cities',$result,3600);
        
            return json($result);
    }
    
    
    
    
}