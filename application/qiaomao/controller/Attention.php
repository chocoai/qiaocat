<?php
namespace app\qiaomao\controller;
use think\Controller;
use think\Db;


/**
 *用户关注的美业师/店铺
 */
class Attention extends Controller
{
	/**
	 * 数据表
	 * @var string
	 */
	protected static $table = 'user_attention_stylist';

	
	/**
	 * @api {post} qiaomao/qm_attention_add_attention 俏猫-增加美业师/店铺的关注[qiaomao/qm_attention_add_attention]
	 * @apiVersion 2.0.0
	 * @apiName qm_attention_add_attention
	 * @apiGroup qiaomao_Attention
	 * @apiSampleRequest qiaomao/qm_attention_add_attention
	 *
	 * @apiParam {Int} stylistId 美业师id
	 *
	 */
	public function attention_add_attention()
	{
	    $stylistId = (input("stylistId")) ?input("stylistId"):0;
	    $return =  $this->addAttention($stylistId);
	    return json($return);
	}
	
	/**增加美业师的关注
	 * @param $attents
	 * 关注的美业师保存的格式
	 * id         | int(11)
	 * user_id    | 用户的id
	 * stylist_id | 关注的美业师id
	 * is_attent  |  0/1关注 没关注
	 * created_at | 关注的日期
	 */
	protected function addAttention($stylistId)
	{
		
		if (if_cookie()) {
			$uid = user_info()['id'];
			//$uid = 324280822;
			//判断美业师是否存在
			$is_stylist = Db::name("stylist")->where('id', '=', $stylistId)->find();
			if (!$is_stylist) {
				return ["status" =>"error", "msg" => "关注的不是美业师!"];
			}
			$is_attent = Db::name(self::$table)->where(['stylist_id' => $stylistId, "user_id" => $uid])->find();
			if ($is_attent) {
			    if(!(Db::name('stylist_stats')->where(['id'=>$stylistId])->find()))
			    {
			        Db::name('stylist_stats')->insert(['id' => $stylistId, 'fans' =>1]);
			    }
			    
				return ["status" => "ok", "msg" => "你已关注了!"];
			}
			$cons = [
				"user_id" => $uid,
				"stylist_id" => $stylistId,
				"is_attent" => 1,
				"created_at" => date("Y-m-d H:i:s")
			];
			$res = Db::name(self::$table)->insert($cons);
			if ($res) {
				//美业师的粉丝数+1
				$prod = Db::name('stylist_stats')->field('fans')->where(['id' => intval($stylistId)])->find();
				$fans = $prod['fans'] > 0 ? $prod['fans'] : 0;
				$info = ['id' => $stylistId, 'fans' => $fans + 1];
				if(Db::name('stylist_stats')->where(['id'=>$stylistId])->find())
				{
				    Db::name('stylist_stats')->where(['id'=>$stylistId])->update($info);
				}else {
				    Db::name('stylist_stats')->insert($info);
				}
				
				return ["status" => "ok", "msg" => "关注成功"];
			}
			return ["status" =>"error", "msg" => '关注失败'];

		} else {
			return ["status" =>"error", "msg" => '账号未登录',"code"=>13000];
		}

	}

	/**
	 * @api {post} qiaomao/qm_attention_cancel_attention 俏猫-取消美业师/店铺的关注[qiaomao/qm_attention_cancel_attention]
	 * @apiVersion 2.0.0
	 * @apiName qm_attention_cancel_attention
	 * @apiGroup qiaomao_Attention
	 * @apiSampleRequest qiaomao/qm_attention_cancel_attention
	 *
	 * @apiParam {Int} stylistId 美业师id
	 *
	 */
	public function attention_cancel_attention()
	{
	    $stylistId = (input("stylistId")) ?input("stylistId"):0;
	    $return =  $this->cancelAttention($stylistId);
	    return json($return);
	}
	/**
	 * 取消美业师的关注
	 */
	protected function cancelAttention($stylistId)
	{
		
		if (!if_cookie()) {
			return ["status" => "error", "msg" => "账号未登录","code"=>13000];
		}
		$uid = user_info()['id'];	
		$res = Db::name(self::$table)->where("stylist_id", "=", $stylistId)->where("user_id", "=", $uid)->delete();
		//美业师的粉丝数-1
		$prod = Db::name('stylist_stats')->field('fans')->where(['id' => intval($stylistId)])->find();
		$fans = $prod['fans'] > 0 ? $prod['fans'] : 1;
		$info = ['id' => $stylistId, 'fans' => $fans - 1];
		Db::name('stylist_stats')->where(['id'=>$stylistId])->update($info);		
		return ["status" => "ok", "msg" => "取消关注成功"];
		

	}
	
	/**
	 * @api {post} qiaomao/qm_attention_get_attent 俏猫-得到用户所关注美业师/店铺的关注[qiaomao/qm_attention_get_attent]
	 * @apiVersion 2.0.0
	 * @apiName qm_attention_get_attent
	 * @apiGroup qiaomao_Attention
	 * @apiSampleRequest qiaomao/qm_attention_get_attent
	 *
	 * @apiParam {Int} page 
	 * @apiParam {Int} page_size 
	 */
	
	public function attention_get_attent($page=1,$page_size=10)
	{
		if (!if_cookie()) {
		    return json_nologin();
			
		}
		$uid = user_info()['id'];
		
		$fields = ['st.store_name','st.store_type','st.id', 'st.real_name', 'st.user_img', 'st.history_orders', 'st.type', 'st.level', 'ss.average_price','ss.fans',
		    'ss.score','st.is_online'];
		$attentags = Db::name(self::$table)->alias('gz')->join("stylist st", 'gz.stylist_id=st.id','LEFT')->join("stylist_stats ss", 'gz.stylist_id=ss.id','LEFT')->where('st.real_name','<>','' )->where('gz.user_id', '=', $uid)->where('gz.is_attent', '=', 1)->field($fields)->page($page,$page_size)->select();
		
		if($attentags)
		{
		    foreach ($attentags as &$val)
		    {
		         
		        $val['Agency_rate']=Agency_rate($val['id']);
		    
		    } 
		}
		
		$data['page'] = $page;		
		$data['page_size'] = $page_size;
		$data['count'] = Db::name(self::$table)->alias('gz')->join("stylist st", 'gz.stylist_id=st.id','LEFT')->join("stylist_stats ss", 'gz.stylist_id=ss.id','LEFT')->where('st.real_name','<>','' )->where('gz.user_id', '=', $uid)->where('gz.is_attent', '=', 1)->field($fields)->count();;
		$data['result'] = $attentags;
		
		return json_ok($data);
		
	}
	
	protected function url($url)
	{
	
	    return starts_with($url, 'http://') ? $url : config('image.urlinfo') . '/upload' . $url;
	}

}
