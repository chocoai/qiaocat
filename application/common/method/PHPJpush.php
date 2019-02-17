<?php
namespace app\common\method;
use think\Controller;
require EXTEND_PATH.'jpush-php/autoload.php';
use JPush;
use think\Db;
/**
 *极光推送类(内部公共调用)
 */
class PHPJpush extends Controller{
    
    
    private $client = null; //jpush对象
    
    
    
    //构造函数自动连接极光
    public function __construct() {
        $this->client = new \JPush\Client(config('jpush.stylist_AppKey'), config('jpush.stylist_Secret'));
    }
    
    
    /**
     * 向所有设备推送消息
     * @param string $message 需要推送的消息
     * @return 消息推送结果
     */
    public function sendNotifyAll($message){
        $pusher = $this->client->push();
        $pusher->setPlatform('all');
        $pusher->addAllAudience();
        $pusher->setNotificationAlert($message);
        try {
            $result = $pusher->send();
        } catch (\JPush\Exceptions\JPushException $e) {
            return $e;
        }catch (\JPush\Exceptions\APIRequestException $e) {
            return $e;
        }
    }
    
    /**
     * 向特定设备推送消息
     * @param array $userid 用户id
     * @param string $message 需要推送的消息
     * @return null
     */
    public function sendNotifySpecial($userid,$message){
        if(empty($userid)==true ||empty($message)==true){
            return ['status'=>'error','msg'=>'请传入用户id和要发送的信息'];
        }
        //查出用户对应的最新设备id
        $device_id = Db::name('user')->where('id',$userid)->value('device_id');
        if($device_id==null || $device_id==0){
            return ['status'=>'error','msg'=>'用户不存在或该用户没有设备id'];
        }
        $pusher = $this->client->push();
        $pusher->setPlatform('all');
        $pusher->addRegistrationId($device_id);
        $pusher->setNotificationAlert($message);
        try {
            $result = $pusher->send();
        } catch (\JPush\Exceptions\JPushException $e) {
            return $e;
        }catch (\JPush\Exceptions\APIRequestException $e) {
            return $e;
        }
    }
    
    
    
    
    
    
    
}