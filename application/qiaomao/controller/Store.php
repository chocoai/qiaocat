<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;


/**
 *用户关注的美业师/店铺
 */
class Store extends Controller
{


	
	/**
	 * @api {post} qiaomao/qm_store_detail 俏猫-店铺详情[qiaomao/qm_store_detail]
	 * @apiVersion 2.0.0
	 * @apiName qm_store_detail
	 * @apiGroup qiaomao_Store
	 * @apiSampleRequest qiaomao/qm_store_detail
	 *
	 * @apiParam {Int} storeId 店铺/机构 id
	 *
	 */
	public function store_detail()
	{   
	    $storeId = (input("storeId")) ?input("storeId"):0;
	    //$storeId = 324304977;
	    $data = Db::name('stylist')->alias('ms')->
	    field('ms.user_img,ms.store_name,ms.store_type,ms.level,ms.business_start,ms.business_end,mss.fans')->join('m2_stylist_stats mss','ms.id = mss.id','LEFT')->where(['ms.id' => $storeId])->find();
	    //接单率
	    if($data != ''){
	    	    $data['Order_rate'] = rate($storeId);
			    //好评率
			    $data['Agency_rate'] = Agency_rate($storeId);
			    //对可预约的时间进行计算
			    $aa = strtotime(date('Y-m-d').$data['business_end']);
			    if((time() + 10800) > $aa){
				   $data['appointment'] = 0;
				}else{
				  $hehe = date('H:i',(time()+10800));
				  $arr = explode(':',$hehe);
				  if($arr[1] < 30){
				    $data['appointment'] = $arr[0].':30';
				  }elseif($arr[1] > 30){
				    $data['appointment'] = ($arr[0] + 1).':00';
				  }else{
				    $data['appointment'] = $arr[0].':'.$arr[1];
				  }
				}
			 return json(['status' => 'ok','data' => $data]);
	    }else{
             return json(['status' => 'error','data' => '']);
	    }
	    

        //var_dump($data);
	   
	}


	/**
	 * @api {post} qiaomao/qm_service_show 俏猫-店铺-服务项目[qiaomao/qm_service_show]
	 * @apiVersion 2.0.0
	 * @apiName qm_service_show
	 * @apiGroup qiaomao_Store
	 * @apiSampleRequest qiaomao/qm_service_show
	 *
	 * @apiParam {Int} storeId 店铺/机构 id
	 *
	 */
	public function service_show()
	{   
	    $storeId = (input("storeId")) ?input("storeId"):0;
	    //$storeId = 324250325;
	    $map['ss.stylist_id'] = $storeId;
	    $map['mp.online'] = 1;
	    $map['ss.type_user'] = 1;
	    $map['ss.online'] = 1;
	    
	    //$product_in['ss.stylist_id'] = $storeId;
	    
	    
	    $product_in['mp.online'] = 1;
	    $product_in['mp.id'] = ['in',[1000045,
                                    1000299,
                                    1000343,
                                    1000354,
                                    1000370,
                                    1000352,
                                    1000025,
                                    1000353,
                                    1000050,
                                    1000068,
                                    1000367,
                                    1000167,
                                    1000344,
                                    1000290,
                                    1000032,
                                    1000030,
                                    1000359,
                                    1000054,
                                    1000358,
                                    1000027,
                                    1000300,
                                    1000301,
                                    1000161,
                                    1000164,
                                    1000033,
                                    1000060,
                                    1000356,
                                    1000379
	        ]];
	    $data = Db::name('stylist_service')->alias('ss')->field('mp.id,mp.thumb,mp.name,mp.price,mp.market_price,mp.cate_id')->join('product mp','ss.product_id = mp.id','LEFT')->where($map)->select();
	    
	    //$data_ =Db::name('stylist_service')->alias('ss')->field('mp.id,mp.thumb,mp.name,mp.price,mp.market_price')->join('product mp','ss.product_id = mp.id','LEFT')->where($product_in)->select();
	   $flag = true;
	   if($data_s = Db::name('stylist')->where(['id'=>$storeId])->find())
	   {
	       if($data_s['store_type']==2)
	       {
	           $flag = false;
	       }
	   }
	   if($flag)
	   {
	       $data_ =Db::name('product')->alias('mp')->field('mp.id,mp.thumb,mp.name,mp.price,mp.market_price,mp.cate_id')->where($product_in)->select();
	        
	       $data = array_merge($data,$data_);
	   }

	    foreach ($data as $k => $v) {
	    	$data[$k]['images'] = $v['thumb'];
	    	unset($data[$k]['thumb']);
	    }


	    
	    //查询出所有的一级分类
	    $product_category = Db::name('product_category')->field('id,name')->where(['parent_id' => 0])->select();
	    $store_product = [];
        foreach ($product_category as $k1 => $v1) {
        	foreach ($data as $k2 => $v2) {
        		if($v2['cate_id'] == $v1['id']){
        			$store_product[$k1]['id'] = $v2['cate_id'];
        			$store_product[$k1]['name'] = $v1['name'];
        		}
        	}
        }

        $stores_service['service_classification'] = $store_product;
        $stores_service['store_service'] = $data;


	    return json($stores_service);
	}


	/**
	 * @api {post} qiaomao/qm_store_Introduction 俏猫-店铺简介[qiaomao/qm_store_Introduction]
	 * @apiVersion 2.0.0
	 * @apiName qm_store_Introduction
	 * @apiGroup qiaomao_Store
	 * @apiSampleRequest qiaomao/qm_store_Introduction
	 *
	 * @apiParam {Int} storeId 店铺/机构 id
	 *
	 */
	public function store_Introduction()
	{   
	    $storeId = (input("storeId")) ?input("storeId"):0;
	    //$storeId = 324304976;
	    $data = Db::name('stylist')->field('created_at,user_good,intro,photo')->where(['id' => $storeId])->find();
	    $year = date('Y',strtotime($data['created_at']));
	    $years = date('Y',time());
	    if($years == $year){
	    	$data['year'] = 1;
	    }else{
	    	$data['year'] = ($years - $year);
	    }
	    $arr = explode('|', $data['photo']);
	    $data['photo'] = $arr;
	    unset($data['created_at']);
        //var_dump($data);
	    return json($data);
	}
	
	/**
	 * @api {post} qiaomao/qm_store_ment 查看店铺评价[qiaomao/qm_store_ment]
	 * @apiVersion 2.0.0
	 * @apiName qm_store_ment
	 * @apiGroup qiaomao_Store
	 * @apiSampleRequest qiaomao/qm_store_ment
	 * 
	 * @apiParam {int} stylist_id    美业师id
	 * @apiParam {int} page_no    第几页
	 * @apiParam {int} per_page    一页几条
	 * @apiParam {int} type    0全部，1好评，2中评，3差评，4有图
	 */
	public function store_ment(){
	    $id=input('stylist_id')?input('stylist_id'):0;
        $page_no  = input('page_no')?input('page_no'):1;
        $per_page = input('per_page')?input('per_page'):10;
        $type = input('type')?input('type'):0;
        $sum = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->count();
        $hao = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('score',5)->count();
        $zhong = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('score','between',[3,4])->count();
        $cha = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('score','between',[1,2])->count();
        $has_img = Db::name('comment')->where('stylist_id',$id)->where('status',1)->where('cont_type',1)->where('images','not null')->count();
        $info=['sum'=>$sum,'hao'=>$hao,'zhong'=>$zhong,'cha'=>$cha,'has_img'=>$has_img];
        if($type==0){
            $map['cont_type']=['=',1];
        }elseif ($type==1){
            $map['cont_type']=['=',1];
            $map['score']=['=',5];
        }elseif ($type==2){
            $map['cont_type']=['=',1];
            $map['score']=['between',[3,4]];
        }elseif ($type==3){
            $map['cont_type']=['=',1];
            $map['score']=['between',[1,2]];
        }elseif ($type==4){
            $map['cont_type']=['=',1];
            $map['images']=['<>','null'];
        }else{
            $map['cont_type']=['=',1];
        }
        
        $res = Db::name('comment')->where(['stylist_id'=>$id,'status'=>1])->where($map)->order('created_at','desc')->field(['id','order_id'])->page($page_no,$per_page)->select();
        $data=[];
        if(count($res)>0){
            foreach ($res as $v){
                $user_info=Db::name('comment')->where('id',$v['id'])->field(['id','product_id','order_id','user_img','user_name','score','comment','images','created_at'])->find();
                if($user_info)
                {
                    $user_info['images'] =explode(',',  $user_info['images']);
                }
                $zhuijia = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',2)->field(['comment','images','created_at'])->find();
                if($zhuijia)
                {
                    $zhuijia['images'] =explode(',',  $zhuijia['images']);
                }
                $huifu = Db::name('comment')->where('order_id',$v['order_id'])->where('cont_type',3)->field(['comment','created_at'])->find();
                $goods = Db::name('product')->where('id',$user_info['product_id'])->field(['name','thumb'])->find();
                $arr = ['user_info'=>$user_info,'zhuijia'=>$zhuijia,'huifu'=>$huifu,'goods'=>$goods];
                array_push($data, $arr);
            }
            return json(['status'=>'ok','info'=>$info,'data'=>$data]);
        }else{
            return json(['status'=>'ok','data'=>[]]);
        }
    
     }
	
     /**
      * @api {post} qiaomao/qm_get_street 查看美业师商圈[qiaomao/qm_get_street]
      * @apiVersion 2.0.0
      * @apiName qm_get_street
      * @apiGroup qiaomao_Store
      * @apiSampleRequest qiaomao/qm_get_street
      *
      * @apiParam {int} stylist_id    美业师id
      * 
      */
     public function get_street(){
         $id=input('stylist_id')?input('stylist_id'):0;
         $field=['province_id','city_id','street_id'];
         $res = Db::name('stylist')->where('id',$id)->field($field)->find();
         if($res==null){
           return json(['status'=>'ok','data'=>[]]);
         }
         $res['street_id']=explode(',',$res['street_id']);
         $data['province']=Db::name('location_province')->where('province_id',$res['province_id'])->value('name');
         $data['city'] = Db::name('location_city')->where('city_id',$res['city_id'])->value('name');
         $data['street']=[];
         foreach ($res['street_id'] as $v){
             $arr = Db::name('location_street')->where('street_id',$v)->value('name');
             array_push($data['street'], $arr);
         }
         return json(['status'=>'ok','data'=>$data]);
     }
     

}
