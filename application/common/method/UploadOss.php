<?php
namespace app\common\method;
use think\Controller;
use OSS\OssClient;
use OSS\Core\OssException;
class UploadOss extends Controller{
    
    
    //上传图片到阿里云OSS，内部调用
    function upload_oss($object,$filePath){
        $accessKeyId = config('aliyuncs.accessKeyId');
        $accessKeySecret = config('aliyuncs.accessKeySecret');
        $endpoint = config('aliyuncs.endpoint');
        $bucket = config('aliyuncs.Bucket');
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->uploadFile($bucket, $object, $filePath);
            $url = config('aliyuncs.url').$object;
            return ['status'=>'ok','data'=>$url];
        } catch (OssException $e) {
            return ['status'=>'error','msg'=>$e->getMessage()];
        }
        
    }

    
    
}

