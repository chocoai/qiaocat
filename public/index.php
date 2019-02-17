<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
 $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
 
 
 if(strstr($origin,"192.168"))
 {
     header("Access-Control-Allow-Origin:$origin");
     
 }else{
     $allow_origin = array(
          //线上正式环境
         'http://mys.qiaocat.com',
         'http://mm.qiaocat.com',
          //线上测试环境
         'http://mystest.qiaocat.com',
         'http://mmtest.qiaocat.com',
          //58内网测试环境
         'http://mys.test58.qiaocat.com',
         'http://mm.test58.qiaocat.com',
         
         'http://mobile.vueqcat.com',
         'http://192.168.50.21',
         'http://192.168.50.6',
         'http://192.168.2.110',
         'http://192.168.50.23:8080',
         'http://192.168.50.4:8080',
         'http://192.168.50.18:8888',  //猫头鹰PC
         'http://192.168.50.18:8080',
         'http://192.168.50.5:8080',
         'http://192.168.50.15:8888',
         'http://192.168.50.23:8080',
         //'http://192.168.8.123:8888', //猫头鹰笔记本
         'http://192.168.50.4:8080', //海胆
         'http://192.168.50.5:8005' //秋如
          
     );
     if(in_array($origin, $allow_origin))
     {
         header("Access-Control-Allow-Origin:$origin");
          
     }
 }
 
 
 
 
 
 
header("Access-Control-Allow-Methods:HEAD,POST,GET,PUT,DELETE,OPTIONS"); 
header('Access-Control-Allow-Credentials: true');


// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
