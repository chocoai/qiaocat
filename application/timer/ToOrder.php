<?php
namespace app\timer;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

/*
 * 订单自动确认结束服务（15分钟执行一次）
 * 在服务器上本项目根目录 执行 命令  php think ToOrder 即可
 */
class ToOrder extends Command
{
    
    
    protected function configure()
    {
        $this->setName('ToOrder')->setDescription('order confirm');
    }
    
    
    protected function execute(Input $input, Output $output)
    {
        
        //超过24小时自动确认结束服务
        $time = date('Y-m-d H:i:s',time()-86400);
        
        //查出订单状态为301，并且开始服务时间距离现在超过24小时的所有订单
        $res = Db::name('order')->where(['order_status'=>301,'pay_status'=>2])
               ->whereTime('start_service_time', 'between', ['1000-10-01 10:00:00',$time])
               ->field(['id','sn','buyer_id','seller_id'])
               ->select();
        
        //自动确认结束服务
        foreach ($res as $v){
            
            $in_time=date('Y-m-d H:i:s',time());
            $data = ['order_status'=>1000,'updated_at'=>$in_time,'end_service_time'=>$in_time];
            
            try {
                Db::name('order')->where('id',$v['id'])->update($data);
                $arr = ['buyer_id'=>$v['buyer_id'],'seller_id'=>$v['seller_id'],'order_sn'=>$v['sn'],'status'=>1,'type'=>1,'text'=>'执行自动确认结束服务成功','create_time'=>$in_time];
                Db::name('timer_log')->insert($arr);
            } catch (\Throwable $e) {
                $arr = ['buyer_id'=>$v['buyer_id'],'seller_id'=>$v['seller_id'],'order_sn'=>$v['sn'],'status'=>2,'type'=>1,'text'=>$e->getMessage(),'create_time'=>$in_time];
                Db::name('timer_log')->insert($arr);
            }  
           
        }
        
    }
    
     
}