<?php
namespace app\mon\controller;
use think\Controller;
use OSS\OssClient;
use OSS\Core\OssException;
/**
 * 上传文件类
 */

class Upload extends Controller{
    
      
      /**
       * @api {post} mon/mon_uploads M站上传图片[mon/mon_uploads]
       * @apiVersion 2.0.0
       * @apiName mon_uploads
       * @apiGroup mon_Upload
       * @apiSampleRequest mon/mon_uploads
       *
       * @apiParam {base64} image    图片
       */
      public function uploads(){
           if(if_cookie()==true){
               $base64_image_content = isset($_POST['image'])?$_POST['image']:'';
               //匹配出图片的格式
               if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
                   $type = $result[2];
                   $date = date('Ymd',time());
                   $path = config('conf.img_path').$date;
                   if(!file_exists($path))
                   {
                       //检查是否有该文件夹，如果没有就创建，并给予最高权限
                       mkdir($path, 0700);
                   }
                   $time = date('YmdHis',time());
                   $rand = mt_rand(1000000,999999999);
                   $img_name = $time.'_'.$rand.".{$type}";
                   $file_name = $path.'/'.$img_name;
                   if (file_put_contents($file_name, base64_decode(str_replace($result[1],'', $base64_image_content)))){
                       $accessKeyId = config('aliyuncs.accessKeyId');
                       $accessKeySecret = config('aliyuncs.accessKeySecret');
                       $endpoint = config('aliyuncs.endpoint');
                       $bucket = config('aliyuncs.Bucket');
                       $object = $img_name;
                       $filePath = $file_name;
                       try {
                           $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                           $ossClient->uploadFile($bucket, $object, $filePath);
                           $url = config('aliyuncs.url').$object;
                           return json(['status'=>'ok','data'=>$url,'msg'=>'上传成功']);
                       } catch (OssException $e) {
                           return json(['status'=>'error','msg'=>$e->getMessage()]);
                       }
                   }else{
                       return json(['status'=>'error','msg'=>'上传失败']);
                   }
               }
           }else{
               return json(['status'=>'error','msg'=>'账号未登录']);
           }
          
      }

      /**
       * @api {post} mon/mon_app_uploads APP端上传图片[mon/mon_app_uploads]
       * @apiVersion 2.0.0
       * @apiName mon_app_uploads
       * @apiGroup mon_Upload
       * @apiSampleRequest mon/mon_app_uploads
       *
       * @apiParam {int} image    图片
       */
      public function app_uploads(){
          if(if_cookie()==true){
              $file= request()->file('image');
              $path = config('conf.img_path');
              $info = $file->validate(['size'=>9437184,'ext'=>'jpg,png,gif,jpeg'])->move($path);
              if($info){
                  $accessKeyId = config('aliyuncs.accessKeyId');
                  $accessKeySecret = config('aliyuncs.accessKeySecret');
                  $endpoint = config('aliyuncs.endpoint');
                  $bucket = config('aliyuncs.Bucket');
                  $object = $info->getFilename();
                  $filePath = $path.'/'.$info->getSaveName();
                  try {
                      $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                      $ossClient->uploadFile($bucket, $object, $filePath);
                      $url = config('aliyuncs.url').$object;
                      return json(['status'=>'ok','data'=>$url,'msg'=>'上传成功']);
                  } catch (OssException $e) {
                      return json(['status'=>'error','msg'=>$e->getMessage()]);
                  }
              }else{
                  // 上传失败获取错误信息
                  return json(['status'=>'error','msg'=>$file->getError()]);
              }
              
          }else{
             return json(['status'=>'error','code'=>-1,'msg'=>get_msg(-1)]);
          }
      }




      /**
       * 添加服务需要将服务的主图进行缩放
       * @api {post} mon/mon_service_uploads 添加服务专有上传接口[mon/mon_service_uploads]
       * @apiVersion 2.0.0
       * @apiName mon_service_uploads
       * @apiGroup service_uploads
       * @apiSampleRequest mon/mon_service_uploads
       *
       * @apiParam {base64} image    图片
       */
      public function service_uploads(){
           if(if_cookie()==true){
               $base64_image_content = isset($_POST['image'])?$_POST['image']:'';
               //匹配出图片的格式
               if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
                   $type = $result[2];
                   $date = date('Ymd',time());
                   $path = config('conf.img_path').$date;
                   if(!file_exists($path))
                   {
                       //检查是否有该文件夹，如果没有就创建，并给予最高权限
                       mkdir($path, 0700);
                   }
                   $time = date('YmdHis',time());
                   $rand = mt_rand(1000000,999999999);
                   $img_name = $time.'_'.$rand.".{$type}";
                   $file_name = $path.'/'.$img_name;
                   //$file_name = ROOT_PATH.'public/'.$img_name;
                   if (file_put_contents($file_name, base64_decode(str_replace($result[1],'', $base64_image_content)))){
                    
                        //对服务的主图进行缩放
                        $image = \think\Image::open($file_name);
                        //var_dump($image);
                        $timestamp = mt_rand(1000000,999999999).time();
                        $sf_img_name = $timestamp.'.'.$type;
                        $jcpath = $path.'/'.$sf_img_name;
                        $image->thumb(150, 150)->save($jcpath);
                       
                       $accessKeyId = config('aliyuncs.accessKeyId');
                       $accessKeySecret = config('aliyuncs.accessKeySecret');
                       $endpoint = config('aliyuncs.endpoint');
                       $bucket = config('aliyuncs.Bucket');
                       $object = $img_name;
                       $filePath = $file_name;
                       try {
                           $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                           //对主图进行上传
                           $ossClient->uploadFile($bucket, $object, $filePath);
                           $url = config('aliyuncs.url').$object;
                           //对缩放的图片进行上传
                           $ossClient->uploadFile($bucket, $sf_img_name, $jcpath);
                           $sf_url = config('aliyuncs.url').$sf_img_name;
                           return json(['status'=>'ok','data'=>$url,'sf_data' => $sf_url,'msg'=>'上传成功']);
                           //return json(['status'=>'ok','data'=>$url,'msg'=>'上传成功']);
                       } catch (OssException $e) {
                           return json(['status'=>'error','msg'=>$e->getMessage()]);
                       }
                   }else{
                       return json(['status'=>'error','msg'=>'上传失败']);
                   }
               }
           }else{
               return json(['status'=>'error','msg'=>'账号未登录']);
           }
          
      }
      
      
      
      
      
      
      
      
      
}