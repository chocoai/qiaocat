<?php
return array(
	'root' => '/opt/lansee/data/attachments/upload/',//上传图片的路径
	'library' => 'gd',
	'upload_dir' => 'uploads',//上传的目录
	'quality' => 85,
	'dimensions' => array(
			'thumb' => array(100, 100, true, 80),
			'medium' => array(600, 400, false, 90),
	),
	'domain' => '',
	'urlinfo' => 'http://crm.qiaocat.com/',
    'crm_urlinfo' => 'http://crm2test.qiaocat.com/',
    
    
	'imagedomain' => 'http://crm.qiaocat.com',
	//资源文件引用 2014-10-13
	'resource_file' => array(
			'values' => '',
			'url_old' => '',
			'url_meigo' => '',
	
	),
	//资源文件引用版本控制
	'edition' => '20141030',
);
