# Host: 120.76.27.217  (Version 5.6.25-log)
# Date: 2018-03-30 09:16:30
# Generator: MySQL-Front 5.4  (Build 4.153) - http://www.mysqlfront.de/

/*!40101 SET NAMES utf8 */;

#
# Structure for table "beauty"
#

CREATE TABLE `beauty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT '描述',
  `type` tinyint(1) NOT NULL,
  `city` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`mobile`),
  UNIQUE KEY `mobile_UNIQUE` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=447155 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for table "m2_17818_ticket_order_child_temp"
#

CREATE TABLE `m2_17818_ticket_order_child_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `identity` tinyint(4) NOT NULL COMMENT '1:身份证2:港澳通行证3:护照',
  `id_code` varchar(30) NOT NULL COMMENT '证件号',
  `skill_type` tinyint(4) NOT NULL COMMENT '1:化妆;2:纹秀',
  `city` varchar(20) NOT NULL COMMENT '城市',
  `mobile` char(11) NOT NULL COMMENT '号码',
  `seat_NO` varchar(10000) NOT NULL DEFAULT '' COMMENT '座位号',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ticket_type` tinyint(6) NOT NULL,
  `team` varchar(30) NOT NULL DEFAULT '' COMMENT '推荐机构',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=890 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_17818_ticket_order_temp"
#

CREATE TABLE `m2_17818_ticket_order_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(20) NOT NULL,
  `ticket_type` tinyint(6) NOT NULL COMMENT '1:普通套票2:黄金套票3:铂金套票4:钻石套票5:大师套票',
  `total_money` decimal(8,2) DEFAULT NULL,
  `ticket_num` tinyint(3) NOT NULL COMMENT '总张数',
  `mobile` char(11) NOT NULL COMMENT '购票人号码',
  `pay_status` tinyint(3) NOT NULL DEFAULT '2',
  `create_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_check` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0未验证1已验证',
  `team` varchar(30) NOT NULL DEFAULT '',
  `trans_id` varchar(30) NOT NULL DEFAULT '' COMMENT '微信单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=683 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_17818_ticket_temp"
#

CREATE TABLE `m2_17818_ticket_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_type` tinyint(6) NOT NULL COMMENT '1:普通套票;2:黄金套票;3:铂金套票;4:钻石套票;5:大师套票',
  `price` decimal(6,2) NOT NULL COMMENT '单价',
  `stock` smallint(5) NOT NULL COMMENT '库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_717order_temp"
#

CREATE TABLE `m2_717order_temp` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `wx_order` varchar(40) NOT NULL,
  `order_sn` varchar(40) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `product_name` varchar(30) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `mobile` char(11) NOT NULL DEFAULT '',
  `create_at` varchar(20) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '0',
  `is_pay` tinyint(3) NOT NULL,
  `school` varchar(50) DEFAULT '',
  `product_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_818pic_tmp"
#

CREATE TABLE `m2_818pic_tmp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `nickname` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户的昵称',
  `openid` varchar(100) NOT NULL COMMENT '用户的标识，对当前公众号唯一',
  `headimgurl` varchar(512) NOT NULL DEFAULT '0' COMMENT '用户头像URL',
  `pic` text COMMENT '上传的图片地址，审核状态和创建时间，json格式 0：未审核；1：审核通过；2：审核不通过',
  `update_at` datetime DEFAULT NULL COMMENT '操作更新时间',
  `checked_pic_num` int(10) NOT NULL DEFAULT '0' COMMENT '有效的图片数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_818pic_tmp_openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=480 DEFAULT CHARSET=utf8 COMMENT='818pic临时表';

#
# Structure for table "m2_ad"
#

CREATE TABLE `m2_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '广告类型',
  `province_id` int(11) DEFAULT '0' COMMENT '省份',
  `city_id` int(11) DEFAULT '0' COMMENT '城市',
  `area_id` int(11) DEFAULT '0' COMMENT '区',
  `start_time` datetime DEFAULT NULL COMMENT '广告开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '广告结束时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用于排序',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '广告标题',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图片链接',
  `description` text COMMENT '广告的描述或者介绍',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '广告图片',
  `is_online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否上线,1为上线，2为下线',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `created_admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建者的id',
  `created_admin_name` varchar(32) NOT NULL DEFAULT '' COMMENT '创建者的名字',
  `market_pay` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '到店付金额',
  `ad_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '广告类型　1服务,商品 id;2店铺，美业师id;3专题链接',
  `first_category_id` varchar(30) NOT NULL DEFAULT ' ' COMMENT '一级分类id',
  `second_category_id` varchar(30) NOT NULL DEFAULT ' ' COMMENT '二级分类id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8 COMMENT='广告表';

#
# Structure for table "m2_ad_category"
#

CREATE TABLE `m2_ad_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL DEFAULT ' ' COMMENT '分类名称',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父级分类id',
  `code` varchar(50) NOT NULL DEFAULT ' ' COMMENT '编码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告的分类表';

#
# Structure for table "m2_admin_acl"
#

CREATE TABLE `m2_admin_acl` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '递增ID',
  `acl` varchar(200) NOT NULL COMMENT 'acl',
  `ctl` varchar(50) NOT NULL COMMENT '控制器名',
  `act` varchar(50) NOT NULL COMMENT '方法名',
  `mark` varchar(50) NOT NULL COMMENT '方法标识',
  `ctl_note` varchar(100) NOT NULL COMMENT '控制器注释',
  `action_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL COMMENT '加入时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `acl` (`acl`)
) ENGINE=InnoDB AUTO_INCREMENT=100416 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限acl列表';

#
# Structure for table "m2_admin_action"
#

CREATE TABLE `m2_admin_action` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `action_name` varchar(20) NOT NULL DEFAULT '' COMMENT '操作名称',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加锁:0未加锁,1:加锁 (加锁需要u盾)',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_admin_action_sign"
#

CREATE TABLE `m2_admin_action_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '申请权限的角色id',
  `admin_id` int(11) NOT NULL COMMENT '申请权限的管理员id',
  `created_at` datetime NOT NULL COMMENT '申请时间',
  `sign_user` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '申请权限的管理员账号',
  `action_list` text COLLATE utf8_bin NOT NULL COMMENT '申请的权限列表',
  `sign_reason` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '申请理由',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1:未通过,0:未处理,1:通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_admin_department"
#

CREATE TABLE `m2_admin_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '部门名称',
  `director_admin_id` int(11) NOT NULL COMMENT '部门负责人',
  `desc` varchar(255) NOT NULL COMMENT '部门简介',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `created_user` varchar(20) NOT NULL COMMENT '创建的管理员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_admin_log"
#

CREATE TABLE `m2_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '递增ID',
  `acl` varchar(200) NOT NULL COMMENT 'acl',
  `uri` varchar(255) NOT NULL COMMENT '访问的UIR',
  `ip` char(20) NOT NULL COMMENT 'ip地址',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `admin_name` varchar(30) DEFAULT NULL COMMENT '操作人名称',
  `vars` longtext NOT NULL COMMENT '变量(序列化后的字符)',
  `comment` varchar(255) DEFAULT NULL COMMENT '详细注释',
  `action_name` varchar(50) NOT NULL COMMENT '操作类型',
  `created_at` datetime NOT NULL COMMENT '加入时间',
  `operation_content` varchar(255) NOT NULL DEFAULT ' ' COMMENT '操作内容',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '日志类型',
  PRIMARY KEY (`id`),
  KEY `acl` (`acl`),
  KEY `index_name` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4051361 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限acl列表';

#
# Structure for table "m2_admin_message"
#

CREATE TABLE `m2_admin_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '给用户发送的系统人员的ID',
  `send_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0是全体，1是部分',
  `uids` text COMMENT '当发送的对象只有部分人的时候所填项,用-ID-ID-ID-这样的形式存储',
  `content` text NOT NULL COMMENT '发送信息的内容',
  `send_time` datetime NOT NULL COMMENT '发送信息的时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间',
  `delete_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100000 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统给用户群发的信息表';

#
# Structure for table "m2_admin_role"
#

CREATE TABLE `m2_admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `name` varchar(30) NOT NULL COMMENT '角色名称',
  `des` varchar(255) NOT NULL COMMENT '描述',
  `action_list` text,
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `created_user` varchar(20) NOT NULL COMMENT '创建人',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100028 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员角色表';

#
# Structure for table "m2_admin_user"
#

CREATE TABLE `m2_admin_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '登陆名',
  `real_name` varchar(11) NOT NULL COMMENT '真实名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `department_id` int(11) NOT NULL DEFAULT '0',
  `role_id` varchar(50) NOT NULL COMMENT '角色ID',
  `email` varchar(50) DEFAULT NULL COMMENT 'EMAIL',
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `job_title` varchar(30) DEFAULT NULL COMMENT '职位',
  `action_list` text COMMENT '权限列表',
  `created_at` datetime NOT NULL COMMENT '添加时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除',
  `last_ip` varchar(30) DEFAULT NULL COMMENT '最后登陆IP',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '管理员状态（0正常1锁定）',
  `province_id` char(6) NOT NULL DEFAULT '' COMMENT '省id',
  `city_id` char(6) NOT NULL DEFAULT '' COMMENT '城市id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100143 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员用户表';

#
# Structure for table "m2_all_pay_log"
#

CREATE TABLE `m2_all_pay_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `sn` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一订单号',
  `post_type` int(8) NOT NULL DEFAULT '1' COMMENT '身份类型，1为用户，2为美业师',
  `order_type` int(8) NOT NULL DEFAULT '100' COMMENT '订单类型，100美业师注册支付验证，200为支付订单，300为美业师缴纳押金',
  `pay_type` int(8) DEFAULT NULL COMMENT '支付类型，100支付宝，200微信',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_account` varchar(255) DEFAULT NULL COMMENT '支付账户',
  `status` int(8) DEFAULT NULL COMMENT '订单状态，100成功，300为失败',
  `data` varchar(9999) DEFAULT '' COMMENT '返回的支付凭证',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `sn` (`sn`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COMMENT='用户支付记录';

#
# Structure for table "m2_api_log"
#

CREATE TABLE `m2_api_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `version` char(20) NOT NULL DEFAULT '',
  `channel` int(11) unsigned NOT NULL DEFAULT '0',
  `method` char(32) NOT NULL DEFAULT '',
  `device_id` varchar(48) NOT NULL DEFAULT '',
  `user_agent` varchar(192) NOT NULL DEFAULT '',
  `referer` varchar(192) NOT NULL DEFAULT '',
  `elapsed` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_created_at_user_id` (`created_at`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20643038 DEFAULT CHARSET=utf8 COMMENT='api log';

#
# Structure for table "m2_association_member"
#

CREATE TABLE `m2_association_member` (
  `id` int(10) unsigned NOT NULL COMMENT '对应俏猫用户',
  `name` varchar(12) NOT NULL COMMENT '注册机构的人名字',
  `mobile` varchar(11) NOT NULL COMMENT '注册机构人手机',
  `agencies` varchar(32) NOT NULL COMMENT '机构的名称',
  `identity` varchar(10) NOT NULL COMMENT '注册机构人的身份',
  `creat_Time` datetime NOT NULL COMMENT '注册的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_ceshi"
#

CREATE TABLE `m2_ceshi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "m2_cms"
#

CREATE TABLE `m2_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(45) NOT NULL COMMENT '发布网站',
  `category_id` int(3) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `position` tinyint(3) NOT NULL DEFAULT '0',
  `image` varchar(100) DEFAULT NULL COMMENT '封面图',
  `description` longtext NOT NULL COMMENT '内容',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `share_count` int(6) NOT NULL DEFAULT '0',
  `like_count` int(6) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `brief` text NOT NULL,
  `show_image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_cms_comments"
#

CREATE TABLE `m2_cms_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(45) NOT NULL COMMENT '用户名　',
  `openid` varchar(45) NOT NULL COMMENT '微信ＯＰＥＮＩＤ',
  `create_time` datetime NOT NULL COMMENT '创建时间　',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `head` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=443 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_cms_config"
#

CREATE TABLE `m2_cms_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(45) DEFAULT NULL COMMENT '关键字',
  `value` varchar(255) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_cms_interaction"
#

CREATE TABLE `m2_cms_interaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL COMMENT '类型',
  `tid` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL COMMENT '时间 ',
  `username` varchar(10) NOT NULL COMMENT '用户',
  `url` varchar(100) NOT NULL COMMENT '地址 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1407 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_comment"
#

CREATE TABLE `m2_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `top_parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '顶级父评论ID,为0时表示该评论为顶级评论而不是追加评论',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '直接父级评论ID,用于追加评论的情况',
  `cont_type` tinyint(3) DEFAULT NULL COMMENT '评论类型 1为顶级评论，2为追加，3为商家回复',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `stylist_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '技师的id',
  `add_time` int(10) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论人ID',
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '客服工号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态, 1: 通过,0:未通过, 2:待审核',
  `score` int(4) NOT NULL DEFAULT '0' COMMENT '综合评分',
  `top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶,0未置顶，1置顶',
  `good` tinyint(1) NOT NULL DEFAULT '0' COMMENT '精华,0非精华，1精华',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `useful` int(4) NOT NULL DEFAULT '0' COMMENT '有用点击数',
  `comment` text NOT NULL COMMENT '评论内容',
  `images` text COMMENT '图片地址',
  `user_name` char(50) NOT NULL DEFAULT '' COMMENT '评论人账号',
  `user_img` varchar(200) DEFAULT NULL COMMENT '评论人头像',
  `user_ip` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '非空时表示软删除',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '１客户评论，２后台添加',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2472 DEFAULT CHARSET=utf8 COMMENT='商品评论表';

#
# Structure for table "m2_comment_meta"
#

CREATE TABLE `m2_comment_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `key` char(64) NOT NULL DEFAULT '',
  `value` varchar(192) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_comment_meta_iid_key_value` (`iid`,`key`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=8623 DEFAULT CHARSET=utf8 COMMENT='评论扩展数据';

#
# Structure for table "m2_company"
#

CREATE TABLE `m2_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL COMMENT '名称',
  `logo` varchar(50) NOT NULL COMMENT 'ＬＯＧＯ',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `city_id` int(5) NOT NULL DEFAULT '0',
  `area_id` int(5) NOT NULL DEFAULT '0',
  `image` text NOT NULL COMMENT '图片',
  `description` longtext NOT NULL COMMENT '介绍',
  `tel` varchar(45) DEFAULT NULL COMMENT '联系电话',
  `contacts` varchar(20) DEFAULT NULL COMMENT '联系人',
  `mobile` varchar(45) DEFAULT NULL,
  `sn` varchar(20) DEFAULT NULL,
  `province_id` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_config"
#

CREATE TABLE `m2_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '名称',
  `value` longtext NOT NULL COMMENT '值',
  `key` varchar(45) NOT NULL COMMENT '属性',
  PRIMARY KEY (`id`,`key`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_coupon"
#

CREATE TABLE `m2_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL COMMENT '优惠券名称',
  `start_time` datetime DEFAULT NULL COMMENT '有效期开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '有效期结束时间',
  `expired_time` int(11) NOT NULL DEFAULT '0' COMMENT '有效期时长，单位为秒',
  `min_amount` double DEFAULT NULL COMMENT '最低消费金额',
  `total_count` int(11) NOT NULL DEFAULT '0' COMMENT '发行张数',
  `send_count` int(11) NOT NULL DEFAULT '0' COMMENT '派发的张数',
  `per_count` int(11) NOT NULL COMMENT '每个ID限制多少张',
  `base_amount` double NOT NULL COMMENT '优惠起点金额',
  `coupon_type` tinyint(2) DEFAULT NULL COMMENT '优惠范围(1直减2满减3直折4满折)',
  `coupon_amount` decimal(10,2) NOT NULL COMMENT '优惠券面额',
  `coupon_value` varchar(2048) DEFAULT NULL COMMENT '优惠范围值，商品ID列表，0代表所有',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `user_level` varchar(100) DEFAULT NULL COMMENT '享受优惠的会员等级限制，多选',
  `allow_give` tinyint(2) NOT NULL COMMENT '允许转赠（0不可以1可以）',
  `allow_user_fetch` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否允许用户领取,0为不允许,1允许',
  `order_count` int(11) NOT NULL DEFAULT '0' COMMENT '使用的订单数',
  `active_count` int(11) NOT NULL DEFAULT '0' COMMENT '激活的数量',
  `order_amount` decimal(10,2) NOT NULL COMMENT '总订单金额',
  `discount_amount` decimal(10,2) NOT NULL COMMENT '折扣的金额',
  `creater` varchar(50) DEFAULT NULL COMMENT '创建人',
  `modifier` varchar(50) DEFAULT NULL COMMENT '最后修改人',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `online` tinyint(1) NOT NULL COMMENT '是否上线　0:没上线;　1:上线;',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000235 DEFAULT CHARSET=utf8 COMMENT='优惠券';

#
# Structure for table "m2_coupon_active"
#

CREATE TABLE `m2_coupon_active` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sn` char(20) NOT NULL COMMENT '激活码',
  `coupon_id` bigint(20) DEFAULT NULL COMMENT '优惠券ID',
  `coupon_sn` char(20) DEFAULT '' COMMENT '激活后所获券码',
  `actived_by` bigint(20) NOT NULL DEFAULT '0' COMMENT '激活人ID',
  `actived_at` datetime DEFAULT NULL COMMENT '激活时间',
  `expired_at` datetime NOT NULL COMMENT '过期时间',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_coupon_active_sn` (`sn`)
) ENGINE=InnoDB AUTO_INCREMENT=1111676 DEFAULT CHARSET=utf8 COMMENT='用户邀请记录';

#
# Structure for table "m2_coupon_meta"
#

CREATE TABLE `m2_coupon_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `key` char(64) NOT NULL DEFAULT '',
  `value` varchar(192) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_coupon_meta_iid_key_value` (`iid`,`key`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=1139 DEFAULT CHARSET=utf8 COMMENT='优惠券扩展数据';

#
# Structure for table "m2_crm"
#

CREATE TABLE `m2_crm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(55) NOT NULL DEFAULT '' COMMENT '名字',
  `approve` varchar(55) NOT NULL DEFAULT '' COMMENT '职业认证',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `sex` tinyint(4) NOT NULL DEFAULT '0',
  `score` float(9,3) NOT NULL DEFAULT '0.000' COMMENT '星级',
  `mobile` varchar(88) NOT NULL DEFAULT '' COMMENT '联系电话,多个电话用,号隔开',
  `workyear` char(4) NOT NULL DEFAULT '' COMMENT '工作起始年限',
  `province_id` varchar(20) DEFAULT NULL COMMENT '省份',
  `city_id` varchar(20) DEFAULT NULL COMMENT '城市',
  `area_id` varchar(20) DEFAULT NULL COMMENT '区',
  `address` varchar(255) DEFAULT NULL COMMENT '街道',
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '有值代表已经成为技师',
  `follow_user` varchar(20) NOT NULL DEFAULT '' COMMENT '跟进人，有值代表已经有人跟进该商家',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `created_user` varchar(20) NOT NULL DEFAULT '' COMMENT '创建人',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100377 DEFAULT CHARSET=utf8 COMMENT='CRM表';

#
# Structure for table "m2_crm_visit"
#

CREATE TABLE `m2_crm_visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `crm_id` int(11) NOT NULL DEFAULT '0',
  `visit_type` tinyint(4) NOT NULL DEFAULT '0',
  `visit_date` datetime DEFAULT NULL COMMENT '拜访时间',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '此次拜访联系的手机号，如若电话联系方式必须填写',
  `valid_visit` tinyint(4) NOT NULL DEFAULT '0',
  `content` text COMMENT '拜访情况',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `created_user` varchar(20) NOT NULL DEFAULT '' COMMENT '拜访人',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地推拜访';

#
# Structure for table "m2_data_analysis"
#

CREATE TABLE `m2_data_analysis` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ＩＤ　－　用户行为分析表',
  `type` tinyint(3) NOT NULL COMMENT '类型',
  `action` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '动作',
  `user_id` int(11) NOT NULL COMMENT '用户ＩＤ',
  `mobile` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `residence_time` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '停留时间',
  `date_added` datetime NOT NULL COMMENT '添加时间',
  `note` text COLLATE utf8_bin NOT NULL COMMENT '备注',
  `data_ext` text COLLATE utf8_bin NOT NULL COMMENT '扩展',
  `ad_source` varchar(50) COLLATE utf8_bin NOT NULL,
  `last_login_ip` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155042 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_doctors"
#

CREATE TABLE `m2_doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '医师的用户ID',
  `sn` varchar(255) DEFAULT NULL COMMENT '医师编号',
  `outfit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构ID',
  `org_name` varchar(255) DEFAULT NULL COMMENT '机构名称',
  `real_name` varchar(15) DEFAULT '' COMMENT '医师姓名',
  `is_work` tinyint(4) NOT NULL DEFAULT '1' COMMENT '工作状态，1工作中，2休息，3离职',
  `idcard_zy` char(15) NOT NULL DEFAULT '' COMMENT '医师执业证号',
  `idcard_zg` char(26) NOT NULL DEFAULT '' COMMENT '医师资格证号',
  `honor` varchar(1000) NOT NULL COMMENT '医师头衔',
  `skilful` varchar(255) DEFAULT NULL COMMENT '医师擅长',
  `work_years` varchar(5) NOT NULL DEFAULT '' COMMENT '医师从业起始年限',
  `work_gy` varchar(255) NOT NULL DEFAULT '' COMMENT '医师从医格言',
  `user_img` varchar(255) NOT NULL DEFAULT '' COMMENT '医师的头像',
  `idcard_zz_img` varchar(1000) NOT NULL DEFAULT '' COMMENT '资质证书',
  `trained_ry_img` varchar(1000) NOT NULL COMMENT '荣誉奖杯',
  `intro` varchar(1000) NOT NULL DEFAULT '' COMMENT '医师简介',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT 'deleted_at通过检测其为NOT NULL的时候，即为软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='医师的信息表';

#
# Structure for table "m2_feedback"
#

CREATE TABLE `m2_feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '反馈的类型，0 普通',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '反馈用户ID',
  `user_name` varchar(50) DEFAULT '' COMMENT '用户名',
  `contact` varchar(144) DEFAULT '' COMMENT '联系方式',
  `title` varchar(144) NOT NULL DEFAULT '' COMMENT '标题',
  `description` text COMMENT '反馈详情',
  `is_handle` smallint(1) NOT NULL DEFAULT '0' COMMENT '是否处理',
  `handle_info` varchar(255) DEFAULT NULL COMMENT '处理信息',
  `meta` text COMMENT '元数据',
  `checksum` varchar(127) DEFAULT '' COMMENT '内容唯一校验',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT 'deleted_at通过检测其为NOT NULL的时候，即为软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1014039 DEFAULT CHARSET=utf8 COMMENT='反馈主表';

#
# Structure for table "m2_fx_comment"
#

CREATE TABLE `m2_fx_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `moment_id` int(11) NOT NULL DEFAULT '0' COMMENT 'moment id',
  `comment` varchar(280) NOT NULL DEFAULT '' COMMENT '评论内容',
  `reply_name` varchar(50) NOT NULL DEFAULT '' COMMENT '评论人姓名',
  `reply_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论人id',
  `replyed_name` varchar(50) NOT NULL DEFAULT '' COMMENT '被评论人姓名',
  `replyed_id` int(11) NOT NULL DEFAULT '0' COMMENT '被评论人id',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '类型，1为点赞，2为评论',
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `news` tinyint(2) NOT NULL DEFAULT '1' COMMENT '未读状态，0为已读，1为未读',
  `time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COMMENT='发现点赞评论记录';

#
# Structure for table "m2_hzsabc_curriculum"
#

CREATE TABLE `m2_hzsabc_curriculum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(50) NOT NULL COMMENT '发布目标',
  `title` varchar(50) NOT NULL COMMENT '课程标题',
  `teacher` varchar(25) NOT NULL COMMENT '课程老师id',
  `introduce` text NOT NULL COMMENT '课程介绍',
  `brief` varchar(80) NOT NULL COMMENT '简短介绍',
  `label` varchar(255) NOT NULL COMMENT '标签',
  `cover_image` varchar(255) NOT NULL COMMENT '封面图',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '封面图',
  `show_image` text NOT NULL COMMENT '展示图',
  `video` varchar(255) NOT NULL DEFAULT '' COMMENT '视频链接',
  `video_play_num` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL COMMENT '开始时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_hzsabc_enroll"
#

CREATE TABLE `m2_hzsabc_enroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` bigint(20) DEFAULT NULL COMMENT '手机号',
  `real_name` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '真实姓名',
  `sex` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '性别',
  `idcard` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT '身份证号码',
  `province_id` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '省',
  `city_id` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '市',
  `area_id` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '区',
  `address` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '城市地址',
  `deputy` tinyint(3) DEFAULT NULL COMMENT '代表参赛 1为个人2为机构',
  `mechanism` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '机构名称',
  `group` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '参赛组别',
  `review` tinyint(3) DEFAULT NULL COMMENT '评审状态0为未评审1为未通过2为通过',
  `intro` varchar(600) COLLATE utf8_bin DEFAULT NULL COMMENT '个人简介',
  `product_img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '个人原创作品',
  `user_img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '个人形象照',
  `create_time` bigint(20) DEFAULT NULL COMMENT '报名时间',
  `allot` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='星选报名表';

#
# Structure for table "m2_hzsabc_img"
#

CREATE TABLE `m2_hzsabc_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT '手机号',
  `product_img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '个人作品图片',
  `create_time` bigint(20) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_hzsabc_order"
#

CREATE TABLE `m2_hzsabc_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_status` int(11) NOT NULL,
  `type` int(3) NOT NULL COMMENT '商品的类型',
  `wx_order_num` varchar(64) NOT NULL COMMENT '自定义的订单号',
  `amount` decimal(10,2) NOT NULL COMMENT '支付的金额',
  `mobile` varchar(32) NOT NULL COMMENT '购买的商品名称',
  `openid` varchar(64) NOT NULL COMMENT 'openid',
  `user_id` varchar(32) NOT NULL COMMENT '第三方支付的单号',
  `create_time` datetime NOT NULL COMMENT '支付的时间',
  `pay_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_hzsabc_order_old"
#

CREATE TABLE `m2_hzsabc_order_old` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_status` int(11) NOT NULL,
  `type` int(3) NOT NULL COMMENT '商品的类型',
  `wx_order_num` varchar(64) NOT NULL COMMENT '自定义的订单号',
  `amount` decimal(10,2) NOT NULL COMMENT '支付的金额',
  `mobile` varchar(32) NOT NULL COMMENT '购买的商品名称',
  `openid` varchar(64) NOT NULL COMMENT 'openid',
  `user_id` varchar(32) NOT NULL COMMENT '第三方支付的单号',
  `create_time` datetime NOT NULL COMMENT '支付的时间',
  `pay_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_hzsabc_send_code"
#

CREATE TABLE `m2_hzsabc_send_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `code` int(11) DEFAULT NULL COMMENT '6位验证码',
  `create_time` bigint(20) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态0为已验证1为未验证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14880 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='星选发送验证码';

#
# Structure for table "m2_hzsabc_teacher"
#

CREATE TABLE `m2_hzsabc_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '教师名字',
  `title` varchar(50) NOT NULL COMMENT '头衔',
  `grade` varchar(50) NOT NULL COMMENT '教师等级',
  `brief` varchar(100) NOT NULL COMMENT '教师简介',
  `introduction` varchar(255) NOT NULL COMMENT '教师介绍',
  `image` varchar(255) NOT NULL COMMENT '教师头像',
  `subscribe` int(11) NOT NULL DEFAULT '0' COMMENT '订阅数',
  `create_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_image"
#

CREATE TABLE `m2_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `object_type` varchar(15) DEFAULT NULL,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '图片路径',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '图片排序',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '上传者的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1025580 DEFAULT CHARSET=utf8 COMMENT='产品图片和文章图片表';

#
# Structure for table "m2_jpush_log"
#

CREATE TABLE `m2_jpush_log` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '推送人id',
  `rec_id` varchar(9999) DEFAULT '' COMMENT '接收人id',
  `message` varchar(255) DEFAULT '' COMMENT '推送的消息',
  `type` int(11) DEFAULT NULL COMMENT '推送的类型',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态，1为成功，2为失败',
  `info` varchar(255) DEFAULT '' COMMENT '返回的状态信息',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COMMENT='极光推送记录';

#
# Structure for table "m2_location_area"
#

CREATE TABLE `m2_location_area` (
  `area_id` varchar(50) NOT NULL COMMENT '区编号',
  `name` varchar(60) NOT NULL,
  `city_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(15) NOT NULL COMMENT '编号',
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='区表';

#
# Structure for table "m2_location_city"
#

CREATE TABLE `m2_location_city` (
  `city_id` varchar(50) NOT NULL COMMENT '城市编号',
  `name` varchar(60) NOT NULL,
  `province_id` varchar(33) NOT NULL COMMENT '属于这个省',
  `longitude` decimal(16,8) NOT NULL DEFAULT '0.00000000' COMMENT '经度',
  `latitude` decimal(16,8) NOT NULL DEFAULT '0.00000000' COMMENT '纬度',
  `is_show` int(1) NOT NULL DEFAULT '0' COMMENT '1显示0不显示',
  `py_name` varchar(50) DEFAULT NULL COMMENT '城市拼音',
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='城市表';

#
# Structure for table "m2_location_province"
#

CREATE TABLE `m2_location_province` (
  `province_id` varchar(50) NOT NULL COMMENT '省份编号',
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='省份表';

#
# Structure for table "m2_location_street"
#

CREATE TABLE `m2_location_street` (
  `street_id` varchar(50) NOT NULL COMMENT '街道编号',
  `name` varchar(60) NOT NULL,
  `area_id` varchar(50) NOT NULL COMMENT '区编号',
  `longitude` decimal(16,8) NOT NULL DEFAULT '0.00000000' COMMENT '经度',
  `latitude` decimal(16,8) NOT NULL DEFAULT '0.00000000' COMMENT '纬度',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`street_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='街道表';

#
# Structure for table "m2_location_street_copy_5_17"
#

CREATE TABLE `m2_location_street_copy_5_17` (
  `street_id` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '街道编号',
  `name` varchar(60) CHARACTER SET utf8 NOT NULL,
  `area_id` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '区编号',
  `longitude` decimal(16,8) NOT NULL DEFAULT '0.00000000' COMMENT '经度',
  `latitude` decimal(16,8) NOT NULL DEFAULT '0.00000000' COMMENT '纬度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_log"
#

CREATE TABLE `m2_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(8) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1614 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_message_template"
#

CREATE TABLE `m2_message_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_id_create` int(64) NOT NULL DEFAULT '0',
  `role_id_update` int(64) NOT NULL DEFAULT '0',
  `content` text NOT NULL COMMENT '短信的主体内容',
  `sort_title` varchar(128) DEFAULT NULL COMMENT '短信模板的简短说明',
  `create_time` datetime NOT NULL COMMENT '短信模板创建的时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '短信模板修改的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_minip_complaint"
#

CREATE TABLE `m2_minip_complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in_user` bigint(20) NOT NULL DEFAULT '0' COMMENT '投诉人',
  `be_user` bigint(20) NOT NULL DEFAULT '0' COMMENT '被投诉人',
  `order_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单id',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1为投诉接单人，2为投诉派单人',
  `info` varchar(255) NOT NULL DEFAULT '' COMMENT '投诉理由',
  `is_del` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1显示，2删除',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `system_reply` varchar(255) DEFAULT '' COMMENT '系统回复',
  `reply_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '回复时间',
  `is_reply` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1未回复，2已回复',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='小程序投诉反馈表';

#
# Structure for table "m2_minip_formid"
#

CREATE TABLE `m2_minip_formid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `form_id` varchar(255) NOT NULL DEFAULT '' COMMENT '表单id',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='小程序用户formid';

#
# Structure for table "m2_minip_order"
#

CREATE TABLE `m2_minip_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `wechat_avatar` varchar(255) DEFAULT '' COMMENT '微信头像',
  `wechat_name` varchar(100) DEFAULT '' COMMENT '微信昵称',
  `take_id` bigint(20) DEFAULT '0' COMMENT '接单人id',
  `order_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一订单号',
  `order_status` int(11) NOT NULL DEFAULT '1' COMMENT '1等待接单，300派单成功等待服务，1000服务完成，1200订单完成，3000派单人取消订单，4000订单过期',
  `demand` varchar(20) NOT NULL DEFAULT '' COMMENT '需求美业师类型',
  `number` tinyint(3) NOT NULL DEFAULT '1' COMMENT '人数',
  `service_day` date DEFAULT '0000-00-00' COMMENT '服务日期',
  `service_time` varchar(30) NOT NULL DEFAULT '' COMMENT '时间段',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `city_id` varchar(30) NOT NULL DEFAULT '' COMMENT '城市id',
  `longitude` varchar(50) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(50) NOT NULL DEFAULT '' COMMENT '纬度',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '费用',
  `is_face` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否面议，1不面议，2面议',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '联系手机',
  `info` varchar(255) DEFAULT '' COMMENT '说明',
  `cancel_info` varchar(255) DEFAULT '' COMMENT '取消原因',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COMMENT='小程序派单表';

#
# Structure for table "m2_minip_order_log"
#

CREATE TABLE `m2_minip_order_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '300派单成功，1000完成服务，1200订单完成，3000取消订单，4000订单过期',
  `info` varchar(255) DEFAULT '' COMMENT '备注信息',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COMMENT='小程序订单完成记录';

#
# Structure for table "m2_minip_proposal"
#

CREATE TABLE `m2_minip_proposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `text` varchar(255) NOT NULL DEFAULT '' COMMENT '反馈内容',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机号码',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='小程序意见反馈表';

#
# Structure for table "m2_minip_skill_type"
#

CREATE TABLE `m2_minip_skill_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型唯一id',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '0为顶级类型',
  `type_name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称',
  `id_del` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1显示，2删除',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`,`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='小程序技术类型表';

#
# Structure for table "m2_minip_take_order"
#

CREATE TABLE `m2_minip_take_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '订单sn',
  `take_status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态，1为参与订单，2为被派单人选为接单人，0自己取消参与',
  `cancel_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '取消报名次数',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COMMENT='小程序参与订单人员表';

#
# Structure for table "m2_minip_user"
#

CREATE TABLE `m2_minip_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `real_name` varchar(50) DEFAULT '' COMMENT '真实姓名',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机号码',
  `skill_type` varchar(200) DEFAULT '' COMMENT '技能',
  `openid` varchar(255) DEFAULT '' COMMENT '唯一识别号',
  `unionid` varchar(255) DEFAULT '' COMMENT '微信号id',
  `wechat_avatar` varchar(255) DEFAULT '' COMMENT '微信头像',
  `wechat_name` varchar(255) DEFAULT '' COMMENT '微信昵称',
  `sex` tinyint(3) NOT NULL DEFAULT '2' COMMENT '1男，2女',
  `year` varchar(50) DEFAULT '' COMMENT '工作几年',
  `source` varchar(255) DEFAULT '' COMMENT '注册来源',
  `register_ip` varchar(50) DEFAULT '' COMMENT '注册ip',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登陆ip',
  `country` varchar(50) DEFAULT '' COMMENT '国家',
  `province` varchar(50) DEFAULT '' COMMENT '省份',
  `city` varchar(50) DEFAULT '' COMMENT '城市',
  `info` varchar(255) DEFAULT '' COMMENT '简介',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态，1注册用户，2已完善资料',
  `qm_auth` bigint(20) NOT NULL DEFAULT '0' COMMENT '俏猫认证uid',
  `ad_user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '推广人uid，0代表自主注册',
  `is_ban` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否封禁，1正常登陆，2已封禁',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100000028 DEFAULT CHARSET=utf8mb4 COMMENT='小程序用户表';

#
# Structure for table "m2_minip_user_invitation"
#

CREATE TABLE `m2_minip_user_invitation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `inviter_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '邀请者用户ID',
  `invitee_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '被邀请者用户ID',
  `invite_code` char(128) NOT NULL COMMENT '邀请码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1邀请中；2邀请成功',
  `comment` varchar(144) DEFAULT '' COMMENT '备注',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_invitation_inviter_invitee_invite_code` (`inviter_id`,`invitee_id`,`invite_code`),
  KEY `index_invitation_invite_code` (`invite_code`),
  KEY `index_invitation_invitee_id` (`invitee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='小程序用户邀请记录';

#
# Structure for table "m2_minip_user_works"
#

CREATE TABLE `m2_minip_user_works` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `works_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作品地址',
  `is_del` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1显示，2软删除',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COMMENT='小程序用户的作品图片';

#
# Structure for table "m2_ms_category"
#

CREATE TABLE `m2_ms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品类ID',
  `parent_id` int(4) NOT NULL DEFAULT '0' COMMENT '分类父ID，默认为顶级分类',
  `product_total` int(4) NOT NULL DEFAULT '0' COMMENT '产品总数',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示,1为显示2为不显示',
  `is_nav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否导航栏显示，1为显示2为不显示',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类的名字',
  `tag` varchar(1000) NOT NULL COMMENT ' 标签',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='美塑分类表';

#
# Structure for table "m2_ms_product"
#

CREATE TABLE `m2_ms_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `outfit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构ID',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '项目分类',
  `sn` varchar(50) NOT NULL DEFAULT '' COMMENT '项目的编号',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '项目的名称',
  `service_form` tinyint(4) NOT NULL DEFAULT '1' COMMENT '服务形式，1顾客到店',
  `buy_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '服务形式，1普通购买',
  `evech_product` varchar(100) NOT NULL DEFAULT '' COMMENT '伊肤泉产品',
  `indication` varchar(255) NOT NULL DEFAULT '' COMMENT '适应症',
  `effect_time` tinyint(4) NOT NULL DEFAULT '0' COMMENT '效果持续时间',
  `time_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '效果持续时间类型，1天，2月，3年',
  `course_day_second` tinyint(4) NOT NULL DEFAULT '1' COMMENT '天/次',
  `course_second_lc` tinyint(4) NOT NULL DEFAULT '1' COMMENT '次/1疗程',
  `course_one_time` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1次治疗时间单位：分钟',
  `is_hospitalization` tinyint(4) NOT NULL DEFAULT '0' COMMENT '住院天数，0不用住院',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '标准价格',
  `down_payment` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '预定金',
  `pay_back` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '到医院再付',
  `advance_time` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提前预约时间',
  `send_score` int(11) NOT NULL DEFAULT '0' COMMENT '赠送俏猫积分',
  `doctors_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '负责医师id多个用逗号分隔',
  `successful_case_img` varchar(1000) NOT NULL DEFAULT '' COMMENT '成功案例，多个img用逗号分开',
  `item_img` varchar(1000) NOT NULL DEFAULT '' COMMENT '项目图片，多个img用逗号分开',
  `item_description` text NOT NULL COMMENT '项目描述',
  `display_chart` text NOT NULL COMMENT '效果展示图',
  `treatment` text NOT NULL COMMENT '治疗过程',
  `common_problem` text NOT NULL COMMENT '常见问题',
  `consumer_information` text NOT NULL COMMENT '消费须知',
  `add_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '添加商品的时间',
  `cate_id` int(10) NOT NULL DEFAULT '0',
  `online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否上架，1为上架，0为下架',
  `is_check` tinyint(4) NOT NULL DEFAULT '2' COMMENT '审核状态，1已审核，2未审核',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数，浏览量',
  `sell_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `comment_count` int(4) NOT NULL DEFAULT '0' COMMENT '评论数',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属原商品ID',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `label` varchar(10) NOT NULL DEFAULT '' COMMENT '商品的标签，1为精品，2为新品，3为促销，4为热销',
  `seo_title` varchar(100) DEFAULT NULL,
  `seo_keyword` varchar(100) DEFAULT NULL,
  `seo_description` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT 'deleted_at通过检测其为NOT NULL的时候，即为软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COMMENT='美塑项目主表';

#
# Structure for table "m2_option"
#

CREATE TABLE `m2_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type` char(16) NOT NULL DEFAULT 'BASE' COMMENT '类型',
  `key` varchar(192) NOT NULL DEFAULT '' COMMENT '数据项列名',
  `name` varchar(192) NOT NULL DEFAULT '' COMMENT '数据项名称',
  `value` text NOT NULL COMMENT '值(JSON 格式)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='参数设置';

#
# Structure for table "m2_order"
#

CREATE TABLE `m2_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单递增ID',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父订单号,用于订单合并',
  `sn` char(64) NOT NULL DEFAULT '0' COMMENT ' 订单号,唯一,用于业务显示',
  `buyer_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '买家id',
  `seller_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '卖家id',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '订单的状态 0待付款 1待审核 200货到付款审核 201,202待确认 300已确认 301 开始服务 302 美业师拒绝订单 1000交易成功待结算 1200订单交易完成 10000已取消待退款 11000已取消',
  `shipping_status` int(11) NOT NULL DEFAULT '0' COMMENT '0未发货--》1配货中--》2已发货--》3已签收',
  `pay_status` int(11) NOT NULL DEFAULT '0' COMMENT '支付状态;0:未付款；1:付款中；2:已经付款；',
  `pay_type` enum('ALIPAY','COD','UNIONPAY','WECHAT','CM','CMB','JD') DEFAULT NULL,
  `order_type` int(11) NOT NULL DEFAULT '0' COMMENT '订单对应商品类型作为订单类型',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单生成时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `confirm_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '订单确认时间',
  `pay_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '支付时间',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额=商品总金额+运费=已支付金额+还需支付金额',
  `product_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品的总金额',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `need_to_pay` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '还需支付的金额',
  `already_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已付款金额=已支付余额+已支付优惠券额+已支付积分金额+已支付第三方金额',
  `balance_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已支付余额',
  `coupon_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已支付优惠券额',
  `points_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已支付第三方金额[支付宝、微信支付、银联支付等]',
  `three_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已支付第三方金额[支付宝、微信支付、银联支付等]',
  `points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用的积分的数量[积分换购商品时]',
  `from_ad` char(100) DEFAULT '0' COMMENT '推广带来的标识',
  `referer` varchar(255) NOT NULL DEFAULT '' COMMENT '订单的来源页面',
  `pt_is_main` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开团人0不是，1是',
  `pt_sn` varchar(64) NOT NULL DEFAULT '' COMMENT '拼团编号',
  `pt_is` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否拼团订单0不是，1是',
  `inv_payee` varchar(120) NOT NULL DEFAULT '' COMMENT '发票抬头,用户页面填写',
  `inv_type` varchar(60) NOT NULL COMMENT '发票类型',
  `inv_content` varchar(120) NOT NULL DEFAULT '' COMMENT '发票内容',
  `invoice_no` varchar(255) NOT NULL DEFAULT '' COMMENT '发票编号',
  `inv_tax` decimal(10,2) NOT NULL COMMENT '发票税额',
  `to_buyer` varchar(255) NOT NULL DEFAULT '' COMMENT '商家给客户的留言',
  `is_locked` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT '订单是否被锁定',
  `locked_by_real_name` varchar(20) DEFAULT NULL COMMENT '锁定订单人的真实姓名，跟单人名称',
  `locked_by_admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '锁定订单，当前只有这个管理员ID可以操作订单,跟单',
  `is_cs_audit` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT '是否通过了客服审核',
  `is_fa_audit` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT '是否通过了财务审核',
  `is_irregular` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT '是否为异常订单',
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建该订单的工号ID,引导客服',
  `staff_real_name` varchar(20) DEFAULT NULL COMMENT '引导客服真实姓名',
  `subsidy_created_at` datetime DEFAULT NULL COMMENT '补贴申请时间',
  `subsidy_status` int(2) NOT NULL DEFAULT '0' COMMENT '补贴状态:0|正常订单:1|申请中:2|申请成功:3|申请失败',
  `subsidy_note` varchar(100) DEFAULT NULL COMMENT '补贴备注',
  `withdrawal_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '入账申请状态：0未申请；1申请中；2申请通过',
  `share_user_id` int(11) NOT NULL COMMENT '分享时用户ＩＤ',
  `start_service_time` datetime DEFAULT NULL COMMENT '开始服务时间',
  `end_service_time` datetime DEFAULT NULL COMMENT '结束服务时间',
  `cancem_time` datetime DEFAULT NULL COMMENT '取消时间',
  `deleted_time` datetime DEFAULT NULL COMMENT '删除时间',
  `order_time` datetime DEFAULT NULL COMMENT '接单时间',
  `note` varchar(200) DEFAULT '' COMMENT '美业师给这笔订单的备注',
  `service_form` tinyint(3) DEFAULT '1' COMMENT '1美业师上门 2顾客到店',
  `remark` varchar(300) NOT NULL DEFAULT '' COMMENT '订单备注',
  `is_import` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否导入订单，１否，２是',
  `send_kefu` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否发送过给客服 1未发送，2已发送',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unqiue_sn` (`sn`),
  KEY `index_order_buyer_id` (`buyer_id`),
  KEY `index_order_status` (`order_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5512368 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

#
# Structure for table "m2_order_7421_temp"
#

CREATE TABLE `m2_order_7421_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buy_id` int(24) DEFAULT NULL COMMENT '用户ID',
  `stylist_id` int(24) DEFAULT NULL COMMENT '美业师id',
  `type` int(3) DEFAULT NULL COMMENT '商品的类型',
  `wx_order_num` varchar(64) DEFAULT NULL COMMENT '自定义的订单号',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '支付的金额',
  `product_name` varchar(32) DEFAULT NULL COMMENT '购买的商品名称',
  `openid` varchar(64) DEFAULT NULL COMMENT 'openid',
  `three_order` varchar(128) DEFAULT NULL COMMENT '第三方支付的单号',
  `create_time` datetime NOT NULL COMMENT '支付的时间',
  `msg` text COMMENT '需要存储的长文本信息',
  `y_number` int(12) DEFAULT NULL,
  `is_pay` tinyint(3) NOT NULL,
  `tel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_order_cancel"
#

CREATE TABLE `m2_order_cancel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单表ID',
  `flag` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '取消原因标志',
  `reason` varchar(50) NOT NULL DEFAULT '' COMMENT '取消原因',
  `cancel_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8 COMMENT='订单取消原因';

#
# Structure for table "m2_order_groups"
#

CREATE TABLE `m2_order_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `sn` char(64) NOT NULL COMMENT '拼团编号',
  `pid` int(11) NOT NULL COMMENT '商品id',
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '美业师ID',
  `stylist_name` varchar(50) NOT NULL DEFAULT '' COMMENT '美业师店铺名',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '开团人uid',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '开团人',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拼团状态1开团中，2开团成功,3开团失败',
  `number` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拼单数',
  `has_number` tinyint(4) NOT NULL DEFAULT '0' COMMENT '已拼单数',
  `main_order_sn` varchar(128) NOT NULL DEFAULT '' COMMENT '主订单号',
  `second_order_sn` varchar(1024) NOT NULL DEFAULT '' COMMENT '从订单号集',
  `orther_value` varchar(1024) NOT NULL DEFAULT '' COMMENT '附加值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8 COMMENT='拼团管理';

#
# Structure for table "m2_order_halloween_temp"
#

CREATE TABLE `m2_order_halloween_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(24) NOT NULL COMMENT '用户ID',
  `tel` varchar(11) DEFAULT NULL COMMENT '手机号',
  `type` int(3) DEFAULT NULL COMMENT '商品的类型',
  `wx_order_num` varchar(64) NOT NULL COMMENT '自定义的订单号',
  `amount` decimal(10,2) NOT NULL COMMENT '支付的金额',
  `q_number` varchar(64) NOT NULL COMMENT '排队号',
  `product_name` varchar(32) DEFAULT NULL COMMENT '购买的商品名称',
  `product_id` varchar(32) DEFAULT NULL COMMENT '购买的商品id',
  `openid` varchar(64) DEFAULT NULL COMMENT 'openid',
  `three_order` varchar(128) DEFAULT NULL COMMENT '第三方支付的单号',
  `is_pay` int(2) DEFAULT '0' COMMENT '默认为0|1表示已支付',
  `create_time` datetime NOT NULL COMMENT '支付的时间',
  `bd_number` varchar(64) NOT NULL DEFAULT '' COMMENT '年会排队号',
  `msg` text NOT NULL COMMENT '需要存储的长文本信息',
  `tel_arr` text NOT NULL COMMENT '报名的手机号合集',
  `company_name` varchar(64) NOT NULL COMMENT '年会公司名',
  `director_name` varchar(32) NOT NULL COMMENT '公司负责人',
  `y_number` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=852 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_order_jdo2o"
#

CREATE TABLE `m2_order_jdo2o` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderCode` varchar(64) NOT NULL COMMENT '订单编号: 到家订单编号',
  `clientName` varchar(32) NOT NULL COMMENT '到家用户名',
  `mobilePhone` varchar(20) NOT NULL COMMENT '用户手机号(11位手机号)',
  `artistCode` varchar(20) DEFAULT NULL COMMENT '第三方手艺人编码',
  `outletCode` varchar(20) DEFAULT NULL COMMENT '第三方服务网点编码',
  `orderPrice` decimal(10,2) NOT NULL COMMENT '订单金额',
  `itemCode` varchar(20) NOT NULL COMMENT '服务项目编码: 采用到家统一编码，SKUID',
  `cityCode` varchar(10) NOT NULL COMMENT '城市编码: 采用到家统一编码',
  `productCode` varchar(10) DEFAULT NULL COMMENT '服务项目产品编码',
  `packageCode` varchar(10) DEFAULT NULL COMMENT '服务项目产品套餐编码',
  `longitude` varchar(20) NOT NULL COMMENT '服务地点经度',
  `latitude` varchar(20) NOT NULL COMMENT '服务地点纬度',
  `serviceAddress` varchar(225) NOT NULL COMMENT '服务地点',
  `community` varchar(30) DEFAULT NULL COMMENT '服务地点所在小区',
  `startTimestamp` datetime DEFAULT NULL COMMENT '时间戳(unix time,精确到秒),如:1422868783,服务开始时间',
  `quantity` smallint(6) NOT NULL DEFAULT '0',
  `orderBuyerRemark` varchar(225) DEFAULT NULL COMMENT '订单买家备注',
  `isGroupOn` smallint(6) DEFAULT '0' COMMENT '是否拼团订单:0-默认-非拼团订单;1-拼团订单-服务开始时间为空',
  `lockTime` datetime NOT NULL COMMENT '锁定库存时间',
  `isLock` smallint(6) NOT NULL DEFAULT '0' COMMENT '锁定订单，0:默认锁定;1:解锁',
  `orderCreateTime` datetime NOT NULL COMMENT '订单生成时间',
  `orderPayTime` datetime NOT NULL COMMENT '支付时间',
  `sn` varchar(225) NOT NULL COMMENT '俏猫商品流水号',
  `isPay` int(5) NOT NULL DEFAULT '0' COMMENT '是否支付，0:未支付;1:支付成功',
  `order_type` int(11) NOT NULL DEFAULT '0' COMMENT '订单服务状态',
  `macthArtist` varchar(12) NOT NULL COMMENT '匹配的美业师ID',
  `isRead` int(1) NOT NULL DEFAULT '0' COMMENT '消息是否已读',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_order_jdo2o_servicetime"
#

CREATE TABLE `m2_order_jdo2o_servicetime` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timeIndex` int(1) NOT NULL DEFAULT '0',
  `updateTime` datetime NOT NULL COMMENT '最后修改的日期',
  `serviceTimeList` text NOT NULL COMMENT '服务时间小时,jsonArray',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_order_log"
#

CREATE TABLE `m2_order_log` (
  `action_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '递增ID',
  `order_sn` varchar(20) NOT NULL COMMENT '订单业务编号',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单表ID',
  `user_type` enum('USER_ID','SYSTEM_ID','STAFF_ID') NOT NULL DEFAULT 'STAFF_ID' COMMENT 'USER_ID：用户进行操作，SYSTEM_ID：系统自动操作，STAFF_ID：客服操作',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '本次操作的用户ID',
  `order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `shipping_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未发货--》1配货中--》2已发货--》3已签收',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态;0:未付款；1:付款中；2:已经付款；',
  `is_cs_audit` enum('NO','YES') NOT NULL DEFAULT 'NO' COMMENT '是否通过了客审',
  `is_fa_audit` enum('NO','YES') NOT NULL DEFAULT 'NO' COMMENT '是否通过了财务审核',
  `is_irregular` enum('NO','YES') NOT NULL DEFAULT 'NO' COMMENT '是否为异常订单',
  `is_locked` enum('NO','YES') NOT NULL DEFAULT 'NO' COMMENT '订单是否被锁定',
  `action_note` varchar(255) DEFAULT '' COMMENT '操作备注',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  `fa_user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '本次财审操作的用户ID',
  `fa_action_note` varchar(255) DEFAULT '' COMMENT '财审操作备注',
  PRIMARY KEY (`action_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=427 DEFAULT CHARSET=utf8 COMMENT='订单日志';

#
# Structure for table "m2_order_message"
#

CREATE TABLE `m2_order_message` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id  关联订单表',
  `content` varchar(100) DEFAULT NULL COMMENT '留言内容',
  `xtype` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0代表客户给美业师留言 1美业师给客户留言',
  `time` char(10) NOT NULL DEFAULT '0' COMMENT '留言时间，存时间错',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='订单评论表';

#
# Structure for table "m2_order_meta"
#

CREATE TABLE `m2_order_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `key` char(64) NOT NULL DEFAULT '',
  `value` varchar(192) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_order_meta_iid_key_value` (`iid`,`key`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=6402 DEFAULT CHARSET=utf8 COMMENT='订单元数据';

#
# Structure for table "m2_order_operate_log"
#

CREATE TABLE `m2_order_operate_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '递增ID',
  `sn` varchar(20) NOT NULL COMMENT '订单号',
  `order_status` int(11) NOT NULL COMMENT '订单状态,参考order_status表',
  `admin_id` int(11) NOT NULL COMMENT '操作者id',
  `admin_name` varchar(30) NOT NULL COMMENT '操作人名称',
  `action_name` varchar(50) NOT NULL COMMENT '操作类型名',
  `created_at` datetime NOT NULL COMMENT '加入时间',
  `operation_content` varchar(600) NOT NULL COMMENT '操作内容',
  `type` enum('前台操作','2后台操作') NOT NULL COMMENT '1:前台操作,2后台操作',
  `ip` char(20) NOT NULL COMMENT 'ip地址',
  `acl` varchar(200) NOT NULL DEFAULT '' COMMENT '当前操作方法路径,例如:AdminControllerCommonCommonController@getServiceMessage',
  `uri` varchar(255) NOT NULL DEFAULT '' COMMENT '访问的路由,例如:/admin/common/common/service-message',
  PRIMARY KEY (`id`),
  KEY `sn` (`sn`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='订单轨迹表';

#
# Structure for table "m2_order_pay_history"
#

CREATE TABLE `m2_order_pay_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `order_sn` varchar(20) NOT NULL COMMENT '订单业务编号',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单表ID',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '支付用户名称',
  `three_order_id` varchar(255) DEFAULT NULL COMMENT '第三方支付流水号/或优惠券号',
  `pay_type_name` varchar(50) DEFAULT NULL COMMENT '支付来源[如：支付宝即时到账支付]',
  `pay_type` enum('ALIPAY','UNIONPAY','COD','COUPON','BALANCE','Baifu','POINTS','WECHAT','BANK','PSBC','CLIENT','TENPAY','ICBC','CMBC','COMM','GIFT','CM','CMB','JD') DEFAULT NULL,
  `pay_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '支付时间',
  `money_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '付款金额',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态;0:支付失败；1:支付成功；',
  `return_msg` varchar(2048) DEFAULT '' COMMENT '第三方支付接口返回的提示信息',
  `CmbDiscountAmt` decimal(10,2) DEFAULT '0.00' COMMENT '招行支付优惠金额 招行支付优惠金额XXX. XX',
  `CmbDiscountFlag` varchar(2) DEFAULT 'N' COMMENT '招行支付优惠标识 招行支付优惠标识Y/N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_pay_history_unique_order_id_pay_type_three_id` (`order_id`,`pay_type`,`three_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1507310519 DEFAULT CHARSET=utf8 COMMENT='订单支付流水表';

#
# Structure for table "m2_order_product"
#

CREATE TABLE `m2_order_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '递增ID',
  `type` int(11) NOT NULL DEFAULT '0',
  `buyer_id` bigint(20) NOT NULL DEFAULT '0',
  `seller_id` bigint(20) NOT NULL DEFAULT '0',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单表ID',
  `order_sn` char(64) NOT NULL DEFAULT '0',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `product_name` varchar(120) NOT NULL DEFAULT '' COMMENT '商品名',
  `product_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '商品编码',
  `product_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `product_summary` varchar(200) NOT NULL DEFAULT '' COMMENT '简介',
  `relation` varchar(100) NOT NULL DEFAULT '',
  `discount` int(11) NOT NULL DEFAULT '100' COMMENT '购买时的折扣，80为8折,100不打折',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `product_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际成交价格',
  `b2c_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'b2c商城价格',
  `product_attr` text NOT NULL COMMENT '购买该商品时所选择的属性',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父商品id，取值于cart的parent_id；如果有该值则是值多代表的物品的配件',
  `comment_id` int(10) NOT NULL DEFAULT '0' COMMENT 'comment_id为0时表示无评论，非0时表示评论的ID',
  `ms_id` int(10) NOT NULL,
  `cate_id_2` smallint(5) NOT NULL DEFAULT '0' COMMENT '商品二级分类',
  `cate_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '商品主分类',
  PRIMARY KEY (`id`),
  KEY `index_order_product_order_id` (`order_id`),
  KEY `index_order_product_buyer_id` (`buyer_id`,`order_id`) USING BTREE,
  KEY `index_order_product_seller_id` (`seller_id`,`order_id`) USING BTREE,
  KEY `index_order_product_order_sn` (`order_sn`),
  KEY `index_order_product_product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13113 DEFAULT CHARSET=utf8 COMMENT='订单商品表';

#
# Structure for table "m2_order_refund_history"
#

CREATE TABLE `m2_order_refund_history` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `sn` varchar(128) NOT NULL COMMENT '订单号',
  `role_id` int(32) NOT NULL DEFAULT '0',
  `user_id` int(32) NOT NULL DEFAULT '0',
  `refund_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三方返回退款的金额',
  `request_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '发起请求退款的金额',
  `three_order_id` varchar(128) NOT NULL COMMENT '第三方交易号',
  `type` varchar(12) NOT NULL COMMENT '退款方式字母,ALIPAY-支付宝|JD-京东支付|WECHAT-微信|CMB-招行一网通',
  `refund_create_order` varchar(128) NOT NULL COMMENT '退款单号',
  `status` tinyint(4) NOT NULL DEFAULT '-2' COMMENT '状态:-2:申请,1:成功,-1:失败',
  `msg` varchar(255) NOT NULL DEFAULT '' COMMENT '成功或失败的原因',
  `alipay_batch_no` varchar(64) DEFAULT NULL COMMENT '支付宝退款的标识',
  `refund_three_msg` text CHARACTER SET ascii COMMENT '第三方返回的全部结果:json格式',
  `create_time` datetime NOT NULL COMMENT '发起第三方退款时间',
  `refund_time` datetime NOT NULL COMMENT '第三方返回的处理时间',
  `refund_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际可退金额',
  `note` varchar(300) NOT NULL DEFAULT ' ' COMMENT '退款备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_order_senioryear_temp"
#

CREATE TABLE `m2_order_senioryear_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(24) NOT NULL COMMENT '用户ID',
  `tel` varchar(11) DEFAULT NULL COMMENT '手机号',
  `type` int(3) DEFAULT NULL COMMENT '商品的类型',
  `wx_order_num` varchar(64) NOT NULL COMMENT '自定义的订单号',
  `amount` decimal(10,2) NOT NULL COMMENT '支付的金额',
  `q_number` varchar(64) NOT NULL COMMENT '排队号',
  `product_name` varchar(32) DEFAULT NULL COMMENT '购买的商品名称',
  `product_id` varchar(32) DEFAULT NULL COMMENT '购买的商品id',
  `openid` varchar(64) DEFAULT NULL COMMENT 'openid',
  `three_order` varchar(128) DEFAULT NULL COMMENT '第三方支付的单号',
  `is_pay` int(2) DEFAULT '0' COMMENT '默认为0|1表示已支付',
  `create_time` datetime NOT NULL COMMENT '支付的时间',
  `bd_number` varchar(64) NOT NULL DEFAULT '' COMMENT '年会排队号',
  `msg` text NOT NULL COMMENT '需要存储的长文本信息',
  `tel_arr` text NOT NULL COMMENT '报名的手机号合集',
  `company_name` varchar(64) NOT NULL COMMENT '年会公司名',
  `director_name` varchar(32) NOT NULL COMMENT '公司负责人',
  `y_number` int(12) DEFAULT NULL,
  `coupon_id` int(12) DEFAULT NULL COMMENT '优惠券id',
  `ad_source` varchar(100) NOT NULL COMMENT '推广来源',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_order_shipping"
#

CREATE TABLE `m2_order_shipping` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '递增ID',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单表ID',
  `order_sn` char(64) NOT NULL DEFAULT '0',
  `buyer_id` bigint(20) NOT NULL DEFAULT '0',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人的姓名,用户页面填写,默认取值表user_address',
  `province` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货人的省份ID',
  `city` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市ID',
  `district` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市区ID',
  `street` varchar(30) NOT NULL COMMENT '商圈id',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道地址',
  `zipcode` varchar(60) NOT NULL DEFAULT '' COMMENT '邮编',
  `tel` varchar(60) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(60) NOT NULL DEFAULT '' COMMENT '移动电话',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT 'EMAIL',
  `send_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '发货时间',
  `shipping_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '指定配送时间',
  `not_holiday` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT '节假日不送',
  `sign_building` varchar(120) NOT NULL DEFAULT '' COMMENT '送货人的地址的标志性建筑',
  `postscript` varchar(255) NOT NULL DEFAULT '' COMMENT '订单附言,由用户提交订单前填写',
  `wlgsmc` varchar(100) DEFAULT NULL COMMENT '物流公司名称',
  `shipping_sn` varchar(50) DEFAULT '0' COMMENT '对应配送方式的运单号',
  `shipping_name` varchar(120) NOT NULL DEFAULT '' COMMENT '配送方式',
  `street_id` varchar(45) DEFAULT NULL,
  `area_id` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_order_shipping_order_id` (`order_id`),
  KEY `index_order_shipping_buyer_id` (`buyer_id`),
  KEY `index_order_shipping_order_sn` (`order_sn`)
) ENGINE=InnoDB AUTO_INCREMENT=12183 DEFAULT CHARSET=utf8 COMMENT='订单物流配送时间信息表';

#
# Structure for table "m2_order_status"
#

CREATE TABLE `m2_order_status` (
  `id` int(11) NOT NULL COMMENT '状态ID',
  `to_admin_name` varchar(250) NOT NULL COMMENT '后台看到的状态提示',
  `to_user_name` varchar(250) NOT NULL COMMENT '前台用户看到的状态提示',
  `to_action_name` varchar(250) NOT NULL COMMENT '操作中文名',
  `to_short_name` varchar(250) NOT NULL COMMENT '列表简短中文名',
  `to_search_name` varchar(250) DEFAULT NULL COMMENT '搜索简短中文名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单状态键值表';

#
# Structure for table "m2_order_yanyi_temp"
#

CREATE TABLE `m2_order_yanyi_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(24) DEFAULT NULL COMMENT '用户ID',
  `tel` varchar(11) DEFAULT NULL COMMENT '手机号',
  `type` int(3) DEFAULT NULL COMMENT '商品的类型',
  `wx_order_num` varchar(64) DEFAULT NULL COMMENT '自定义的订单号',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '支付的金额',
  `q_number` varchar(64) DEFAULT NULL COMMENT '排队号',
  `product_name` varchar(32) DEFAULT NULL COMMENT '购买的商品名称',
  `product_id` varchar(32) DEFAULT NULL COMMENT '购买的商品id',
  `openid` varchar(64) DEFAULT NULL COMMENT 'openid',
  `three_order` varchar(128) DEFAULT NULL COMMENT '第三方支付的单号',
  `is_pay` int(2) DEFAULT '0' COMMENT '默认为0|1表示已支付',
  `create_time` datetime NOT NULL COMMENT '支付的时间',
  `msg` text COMMENT '需要存储的长文本信息',
  `tel_arr` text COMMENT '报名的手机号合集',
  `company_name` varchar(64) DEFAULT NULL COMMENT '公司名',
  `director_name` varchar(32) DEFAULT NULL COMMENT '负责人',
  `y_number` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_pay818_tmp"
#

CREATE TABLE `m2_pay818_tmp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单ID',
  `mobile` varchar(13) NOT NULL COMMENT '报名人手机',
  `name` varchar(32) NOT NULL DEFAULT '0' COMMENT '报名人姓名',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '券ID',
  `pname` varchar(64) DEFAULT '' COMMENT '券名称',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '券金额',
  `channel` varchar(10) DEFAULT '' COMMENT '来源',
  `use_time` varchar(10) DEFAULT '' COMMENT '参会时间',
  `openid` varchar(512) DEFAULT NULL COMMENT 'openid',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  `ticket_num` varchar(40) DEFAULT NULL COMMENT '签到显示票数量',
  `unit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '购买人种类：1个人，2机构',
  `signin_at_818` datetime DEFAULT NULL COMMENT '818签到时间',
  `signin_at_819` datetime DEFAULT NULL COMMENT '819签到时间',
  `sign_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '签到状态：0未签到；1签到818；2签到819；3签到两天',
  `dinner` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有餐：0没餐；1晚宴；2自助餐',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_pay818_tmp_sn` (`sn`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8 COMMENT='818pay临时表';

#
# Structure for table "m2_product"
#

CREATE TABLE `m2_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `sn` varchar(50) NOT NULL DEFAULT '' COMMENT '商品的编号',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '商品的名字',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加商品的时间',
  `cate_id` int(11) NOT NULL DEFAULT '0',
  `price` float(8,2) DEFAULT NULL COMMENT '会员价格',
  `market_price` int(11) NOT NULL DEFAULT '0' COMMENT '促销价格',
  `promotion_price` int(11) NOT NULL DEFAULT '0' COMMENT '促销价格',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '商品所需积分',
  `online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否上架，1为上架，0为下架',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '会这项服务的技师的人数',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `duration` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数，浏览量',
  `sell_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `follow_count` int(11) DEFAULT '0' COMMENT '关注数',
  `comment_count` int(4) NOT NULL DEFAULT '0' COMMENT '评论数',
  `relation` varchar(100) NOT NULL DEFAULT '' COMMENT '同个产品的id集合，比如 同个产品仅不同颜色的多个商品id',
  `label` varchar(10) NOT NULL DEFAULT '' COMMENT '商品的标签，1为精品，2为新品，3为促销，4为热销',
  `summary` longtext,
  `description` longtext,
  `images` text COMMENT '主图片，直接保存图片路径，而不是ID',
  `seo_title` varchar(100) DEFAULT NULL,
  `seo_keyword` varchar(100) DEFAULT NULL,
  `seo_description` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT 'deleted_at通过检测其为NOT NULL的时候，即为软删除',
  `thumb` text COMMENT '产品缩略图',
  `extra_text` varchar(45) NOT NULL COMMENT '附加内容,如配送方式等.m2_config 表 key=prduct_extra_text',
  `cate_id_2` int(11) NOT NULL DEFAULT '0',
  `service_form` varchar(10) NOT NULL COMMENT '服务形式',
  `service_object` tinyint(4) NOT NULL DEFAULT '0',
  `tag` varchar(255) NOT NULL COMMENT '标签',
  `point` int(11) NOT NULL DEFAULT '0',
  `coupons` int(11) NOT NULL DEFAULT '0',
  `province_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(11) NOT NULL DEFAULT '0',
  `area_id` int(11) NOT NULL DEFAULT '0',
  `people_number` varchar(255) NOT NULL COMMENT '拼单人数',
  `buy_way_id` tinyint(4) NOT NULL DEFAULT '0',
  `buy_way` varchar(255) NOT NULL,
  `app_time` int(11) NOT NULL DEFAULT '0',
  `real_name` varchar(30) NOT NULL COMMENT '审核者',
  `reason` varchar(100) NOT NULL DEFAULT ' ' COMMENT '审核原因',
  `check_time` char(20) NOT NULL DEFAULT '0000-00-00 00-00-00' COMMENT '审核时间',
  `shop_price` float(8,2) unsigned DEFAULT NULL COMMENT '到店付价格',
  `circumstances_service` tinyint(3) unsigned DEFAULT '1' COMMENT '是否拥有预定金服务 1否 2是',
  `type_user` tinyint(1) DEFAULT '2' COMMENT '区别服务是谁添加',
  `new_pic_path` text COMMENT '服务详情里面的图片的地址，替换掉description(字段)里面的图片',
  `new_details` text COMMENT '服务详情里面的文字介绍，替换掉description(字段)里面的文字',
  `stylist_id` int(11) DEFAULT '0' COMMENT '平台服务为0  个性化服务添加美业师id',
  `pro_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序，越大越靠前',
  `set_follow_count` int(10) NOT NULL DEFAULT '0' COMMENT '后台设置收藏数',
  PRIMARY KEY (`id`),
  KEY `pro_index` (`pro_order`)
) ENGINE=InnoDB AUTO_INCREMENT=1000661 DEFAULT CHARSET=utf8 COMMENT='商品主表';

#
# Structure for table "m2_product_category"
#

CREATE TABLE `m2_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品类ID',
  `parent_id` int(4) NOT NULL DEFAULT '0' COMMENT '分类父ID，默认为顶级分类',
  `product_total` int(4) NOT NULL DEFAULT '0' COMMENT '产品总数',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示,1为显示2为不显示',
  `is_nav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否导航栏显示，1为显示2为不显示',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类的名字',
  `tag` text NOT NULL COMMENT '标签',
  `icon` varchar(100) NOT NULL COMMENT '图标 ',
  `link` varchar(100) NOT NULL COMMENT '链接地址',
  `show_image` varchar(100) NOT NULL COMMENT '首页展示图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2071 DEFAULT CHARSET=utf8 COMMENT='产品分类表';

#
# Structure for table "m2_product_label"
#

CREATE TABLE `m2_product_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL COMMENT '名称',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_product_meta"
#

CREATE TABLE `m2_product_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) NOT NULL DEFAULT '0',
  `key` char(8) NOT NULL DEFAULT '',
  `value` varchar(192) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_object_id_key` (`iid`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='产品元数据';

#
# Structure for table "m2_product_tag"
#

CREATE TABLE `m2_product_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `product_id` bigint(20) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0',
  `tag_name` char(20) NOT NULL COMMENT '标签名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=317 DEFAULT CHARSET=utf8 COMMENT='产品标签表';

#
# Structure for table "m2_product_tmp"
#

CREATE TABLE `m2_product_tmp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '商品的类型，1|化妆,2|造型,4|美甲,8|赠品,16|优惠券,32|普通商品,64|美睫,128|纹绣,256|活动,512|教学,1024|秒杀',
  `sn` varchar(50) NOT NULL DEFAULT '' COMMENT '商品的编号',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '商品的名字',
  `add_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '添加商品的时间',
  `cate_id` int(10) unsigned NOT NULL COMMENT '对应的商品的分类的id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价格',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员价格',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '商品所需积分',
  `online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否上架，1为上架，0为下架',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '会这项服务的技师的人数',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `duration` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数，浏览量',
  `sell_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `comment_count` int(4) NOT NULL DEFAULT '0' COMMENT '评论数',
  `relation` varchar(100) NOT NULL DEFAULT '' COMMENT '同个产品的id集合，比如 同个产品仅不同颜色的多个商品id',
  `label` varchar(10) NOT NULL DEFAULT '' COMMENT '商品的标签，1为精品，2为新品，3为促销，4为热销',
  `summary` varchar(1000) NOT NULL DEFAULT '' COMMENT '简介',
  `description` text COMMENT '商品详情',
  `images` text COMMENT '主图片，直接保存图片路径，而不是ID',
  `seo_title` varchar(100) DEFAULT NULL,
  `seo_keyword` varchar(100) DEFAULT NULL,
  `seo_description` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT 'deleted_at通过检测其为NOT NULL的时候，即为软删除',
  `thumb` text COMMENT '产品缩略图',
  `cate_id_2` int(11) NOT NULL COMMENT '分类二ID',
  `service_form` varchar(10) NOT NULL COMMENT '服务形式',
  `service_object` tinyint(4) NOT NULL COMMENT '服务对象',
  `tag` varchar(255) NOT NULL COMMENT '标签',
  `point` int(5) NOT NULL COMMENT '赠送积分',
  `coupons` int(11) NOT NULL COMMENT '优惠券',
  `province_id` int(11) NOT NULL COMMENT '省ID',
  `city_id` int(11) NOT NULL COMMENT '城市ID',
  `area_id` int(11) NOT NULL COMMENT '县/区ID',
  `people_number` varchar(255) NOT NULL COMMENT '拼单人数',
  `buy_way_id` tinyint(4) NOT NULL COMMENT '购买方式',
  `buy_way` varchar(255) NOT NULL,
  `app_time` int(3) NOT NULL COMMENT '提前预约时间',
  `extra_text` varchar(45) DEFAULT NULL COMMENT '附加内容,如配送方式等.m2_config 表  key=prduct_extra_text',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000327 DEFAULT CHARSET=utf8 COMMENT='商品主表';

#
# Structure for table "m2_promotion_link"
#

CREATE TABLE `m2_promotion_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `link` varchar(100) COLLATE utf8_bin NOT NULL,
  `tag` varchar(45) COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_recharge"
#

CREATE TABLE `m2_recharge` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主健id',
  `batch_no` char(48) NOT NULL DEFAULT '' COMMENT '生成批次',
  `sn` char(11) NOT NULL DEFAULT '' COMMENT '序列号',
  `password` char(16) NOT NULL DEFAULT '' COMMENT '充值卡密码',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '充值用户的id，如果有值，代表已经被充值',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '充值的手机号',
  `recharge_amount` varchar(5) NOT NULL DEFAULT '0' COMMENT '充值卡面额',
  `note` varchar(144) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `recharge_at` datetime DEFAULT NULL COMMENT '充值时间',
  `expired_at` datetime DEFAULT NULL COMMENT '过期时间',
  `updated_by` int(11) NOT NULL DEFAULT '0' COMMENT '更新人',
  `created_admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建该充值卡的管理员id',
  `created_admin_name` varchar(30) NOT NULL DEFAULT '0' COMMENT '创建该充值卡的管理员名字',
  PRIMARY KEY (`id`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=17811 DEFAULT CHARSET=utf8 COMMENT='充值记录表';

#
# Structure for table "m2_recharge_card"
#

CREATE TABLE `m2_recharge_card` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主健id',
  `code` char(11) NOT NULL DEFAULT '' COMMENT '积分码卡号',
  `password` char(16) NOT NULL DEFAULT '' COMMENT '积分码密码',
  `amount` int(4) NOT NULL DEFAULT '0' COMMENT '会员卡面额',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '领取用户的id，如果有值，代表已经被领取',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '领取的手机号',
  `order_sn` varchar(64) NOT NULL DEFAULT '' COMMENT '领取订单号',
  `note` varchar(144) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `recharge_at` datetime DEFAULT NULL COMMENT '领取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1601 DEFAULT CHARSET=utf8 COMMENT='优惠积分活动记录表';

#
# Structure for table "m2_recharge_log"
#

CREATE TABLE `m2_recharge_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '充值的用户的id',
  `recharge_amount` varchar(5) NOT NULL DEFAULT '0' COMMENT '充值卡面额',
  `password` char(16) NOT NULL DEFAULT '' COMMENT '充值的密码',
  `recharge_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '充值的id,也可以是客服充值',
  `recharge_time` datetime DEFAULT NULL COMMENT '充值的时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '充值状态：1为正在充值，2为充值成功，3为充值失败',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=639 DEFAULT CHARSET=utf8 COMMENT='充值日志';

#
# Structure for table "m2_recruit_week"
#

CREATE TABLE `m2_recruit_week` (
  `re_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `re_inviter_id` int(10) NOT NULL DEFAULT '0' COMMENT 'é‚€è¯·è€…id',
  `re_week` varchar(10) NOT NULL DEFAULT '' COMMENT 'å‘¨åº',
  `re_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1æ‰“æ¬¾ï¼Œ2æœªæ‰“æ¬¾',
  `re_amount` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT 'æ‰“æ¬¾é‡‘é¢',
  `re_created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'åˆ›å»ºæ—¶é—´',
  `re_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'è®°å½•ç±»åž‹(1:ä¸“å‘˜2:åŸŽå¸‚ç»ç†)',
  PRIMARY KEY (`re_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='æ‹›å‹Ÿç»Ÿè®¡æ‰“æ¬¾è®°å½•è¡¨';

#
# Structure for table "m2_return_visit"
#

CREATE TABLE `m2_return_visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户/美业师ID',
  `admin_id` int(11) NOT NULL COMMENT '回访人',
  `return_visit` varchar(1000) NOT NULL DEFAULT '' COMMENT '回访内容',
  `user_reply` varchar(1000) NOT NULL DEFAULT '' COMMENT '用户回访',
  `style` enum('电话','微信','QQ','信件','其他') NOT NULL COMMENT '回访方式:1电话,2微信,3QQ,4信件,5其他',
  `status_` enum('成功','失败') NOT NULL COMMENT '回访结果:1成功,2失败',
  `type_` tinyint(3) NOT NULL COMMENT '1用户,2美业师',
  `create_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='美业/用户回访表';

#
# Structure for table "m2_send_code"
#

CREATE TABLE `m2_send_code` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `send_type` enum('mobile','email') NOT NULL DEFAULT 'mobile' COMMENT '发送类型：mobile：短信发送；email：邮箱发送',
  `use_to` enum('forget_password','add_bank','take_out_commission','modify_mobile','login_first','common','apply_ugirl','bonding_mobile','register_success','ext_1','ext_2','ext_3') NOT NULL DEFAULT 'common' COMMENT '使用场合',
  `code` char(6) NOT NULL DEFAULT '0' COMMENT '六位验证码',
  `email_mobile` varchar(100) DEFAULT NULL COMMENT '接收邮箱、接收手机号',
  `send_at` int(11) NOT NULL DEFAULT '0',
  `send_by` char(6) NOT NULL DEFAULT '' COMMENT '发送服务商',
  `counter` tinyint(1) NOT NULL DEFAULT '0' COMMENT '验证了的次数，错误次数',
  PRIMARY KEY (`id`),
  KEY `send_at` (`send_at`)
) ENGINE=InnoDB AUTO_INCREMENT=311823 DEFAULT CHARSET=utf8 COMMENT='手机或者邮件发送的校验码';

#
# Structure for table "m2_service_message"
#

CREATE TABLE `m2_service_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `content` text NOT NULL COMMENT '通知客服内容',
  `read_admin_id` text NOT NULL COMMENT '已读客服ＩＤ,如1，55，88，66',
  `title` varchar(100) NOT NULL COMMENT '通知客服标题',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `href` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `reason` varchar(300) NOT NULL DEFAULT '' COMMENT '取消原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9197 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_statistic_custom"
#

CREATE TABLE `m2_statistic_custom` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `viewer_ids` varchar(1024) DEFAULT '0' COMMENT '浏览者id,用逗号分隔',
  `title` varchar(100) DEFAULT '0' COMMENT '标题',
  `summary` varchar(1024) DEFAULT '0' COMMENT '摘要',
  `content` text COMMENT '数据内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COMMENT='自定义报表';

#
# Structure for table "m2_strange1010_temp"
#

CREATE TABLE `m2_strange1010_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL COMMENT '报名的用户名字',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `sex` int(5) NOT NULL DEFAULT '0',
  `wechat` varchar(32) NOT NULL COMMENT '微信号',
  `education` varchar(32) NOT NULL COMMENT '教育程度',
  `industry` varchar(32) NOT NULL COMMENT '行业',
  `city` varchar(64) NOT NULL COMMENT '地区',
  `photo` varchar(100) NOT NULL COMMENT '照片',
  `wishing` text NOT NULL COMMENT '介绍',
  `SApplication` datetime DEFAULT NULL COMMENT '时间戳',
  `nickname` varchar(100) DEFAULT NULL COMMENT '微信名称',
  `openid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `headimgurl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_stylist"
#

CREATE TABLE `m2_stylist` (
  `id` bigint(10) unsigned NOT NULL COMMENT '造型师的用户ID',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '关联m2_stylist_type表id',
  `type_tmp` varchar(64) NOT NULL DEFAULT '' COMMENT 'm2_stylist_type表id以逗号连接',
  `real_name` varchar(15) NOT NULL DEFAULT '' COMMENT '造型师的名字',
  `nick` varchar(18) NOT NULL DEFAULT '' COMMENT '造型师的昵称',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1为男，2为女',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '造型师的邮箱',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '造型师的联系的手机号',
  `user_img` varchar(200) NOT NULL DEFAULT '' COMMENT '造型师的头像',
  `work_years` varchar(5) NOT NULL DEFAULT '' COMMENT '造型师的工作起始年限',
  `history_orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师历史订单量',
  `num_orders_extra` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师临时添加的订单量',
  `is_setSchedule` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置行程，用于提示美业师第一次修改行程',
  `is_setStreet` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置商圈，用于提示美业师第一次修改商圈',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '造型师的介绍',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证文件',
  `idcard_img` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证图片',
  `longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `level` tinyint(3) NOT NULL DEFAULT '1' COMMENT '造型师的等级',
  `exp_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师经验值',
  `cat_food` int(11) NOT NULL DEFAULT '0' COMMENT '猫粮',
  `photo` text COMMENT '造型师的作品，多个作品用|隔开',
  `stylist_product_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师产品保证金',
  `stylist_service_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师服务保证金',
  `stylist_deduct_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已扣除的保证金',
  `stylist_not_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '不可提现的押金，数额超过需要缴纳的总押金，则视为缴纳完成',
  `stylist_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '造型师 余额',
  `tx_password` varchar(32) DEFAULT '' COMMENT '提现密码',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '当前是否预约，1未预约，2已预约',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的结束时间',
  `is_online` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否在线，1不在线，2在线',
  `is_check` tinyint(3) NOT NULL DEFAULT '4' COMMENT '是否审核,1为已审核，2为审核中，3审核不通过，4已完善资料，未申请店铺，5新用户未完善资料',
  `last_examine_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '考核状态：1为通过，0为不通过',
  `reason` varchar(500) NOT NULL DEFAULT ' ' COMMENT '审核原因',
  `created_at` datetime NOT NULL COMMENT '技师的注册时间',
  `online_at` datetime NOT NULL COMMENT '美业师第一次上线时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `cma_img` varchar(200) NOT NULL COMMENT 'CMA证书头像',
  `is_union_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为联合会会员1｜是，0｜否',
  `honor` varchar(1000) NOT NULL COMMENT '获得的荣誉',
  `trained_experience` varchar(1000) CHARACTER SET dec8 COLLATE dec8_bin NOT NULL COMMENT '培训经历',
  `work_experience` varchar(1000) NOT NULL COMMENT '工作经历',
  `birthday` varchar(45) NOT NULL COMMENT '生日',
  `weixin` varchar(45) NOT NULL COMMENT '微信号',
  `recommend_id` int(11) NOT NULL DEFAULT '0',
  `contract_no` varchar(50) NOT NULL COMMENT '合同编号',
  `stylist_certificate_sn` varchar(32) NOT NULL COMMENT '化妆师联合会证书编号',
  `hasStore` tinyint(4) NOT NULL DEFAULT '0',
  `street_id` varchar(1000) DEFAULT '' COMMENT '商圈ID',
  `wechat_no` varchar(255) NOT NULL COMMENT '微信号',
  `autograph_img` varchar(255) NOT NULL COMMENT '签名图片路径',
  `is_professional` int(2) DEFAULT NULL COMMENT '是否专业会员(1:是  2：否)',
  `fail` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否审核,0为未操作，1为一次被拒，2为二次被拒，3为一次通过，4为二次通过',
  `store_name` varchar(100) DEFAULT '' COMMENT '店铺名称',
  `idcard_hand` varchar(255) DEFAULT '' COMMENT '手持身份证图片',
  `agency` int(11) NOT NULL DEFAULT '0' COMMENT '所属美容机构id',
  `up_store` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否提供顾客到店服务0不提供，1提供',
  `plastic` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否开整形类手术，0不开，1开',
  `store_add` varchar(255) DEFAULT '' COMMENT '实体店地址',
  `license` varchar(255) DEFAULT '' COMMENT '营业执照',
  `doctor_licence` varchar(255) DEFAULT '' COMMENT '医疗卫生执业许可证',
  `store_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1为个人店铺，2为机构店铺',
  `aptitude` varchar(50) DEFAULT '' COMMENT '机构资质',
  `is_business` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否营业 1未营业 2营业',
  `user_good` varchar(100) DEFAULT '' COMMENT '美业师擅长',
  `certificate` varchar(255) DEFAULT '' COMMENT '认证证书',
  `ccc` varchar(100) DEFAULT '' COMMENT '发证机构',
  `advance` varchar(10) NOT NULL DEFAULT '3' COMMENT '提前预约',
  `business_start` varchar(20) DEFAULT '09:00' COMMENT '营业开始时间',
  `business_end` varchar(20) DEFAULT '22:00' COMMENT '营业结束时间',
  `business_week` varchar(20) DEFAULT '1,2,3,4,5,6,0' COMMENT '营业工作日',
  `busy_time` varchar(1000) DEFAULT '' COMMENT '忙时时间',
  `where_add` varchar(100) DEFAULT '' COMMENT '所在城市',
  `check_user` varchar(30) DEFAULT '' COMMENT '审核人',
  `check_time` char(20) NOT NULL DEFAULT '0000-00-00 00-00-00' COMMENT '审核时间',
  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '跟踪客服id',
  `service_name` varchar(30) NOT NULL DEFAULT '' COMMENT '跟踪客服姓名',
  `check_alipay` varchar(255) NOT NULL COMMENT '支付宝账号验证',
  `remark` text NOT NULL COMMENT '美业师审核备注',
  `stylist_partner_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '城市合伙人押金',
  `stylist_partner_bond_code` varchar(30) NOT NULL DEFAULT '0' COMMENT '城市合伙人押金收据编号',
  `stylist_not_bond_code` varchar(30) NOT NULL DEFAULT '' COMMENT '上线包缴纳押金收据编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='造型师的信息表';

#
# Structure for table "m2_stylist_balance_config"
#

CREATE TABLE `m2_stylist_balance_config` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `stylist_name` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'huazhuang' COMMENT '名称类型',
  `stylist_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '美业师类型:1-化妆师,2-美睫师,3-纹绣师',
  `stylist_deposit_ratio` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金累积不足1000元，应扣除比例',
  `stylist_profit_radio` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '收益比例',
  `stylist_second_transpay` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '纹绣师二次打款比例',
  `stylist_deposit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金金额额度',
  `stylist_online_time` tinyint(1) NOT NULL DEFAULT '1' COMMENT '2016年10月前后区别(1-之前,2-之后)',
  `stylist_service_deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '2016年10之后的美业师服务保证金',
  `stylist_product_deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '2016年10之后的美业师产品保证金',
  `stylist_note` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '备注' COMMENT '字段说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_stylist_balance_log"
#

CREATE TABLE `m2_stylist_balance_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL COMMENT '美业师id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `type` int(6) NOT NULL DEFAULT '1' COMMENT '类型，1为订单，2为提现',
  `in_out` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1为收入，2为支出',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `sn_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `service_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台抽取的服务费',
  `bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '押金',
  `revenue` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '税收',
  `latest_balance` decimal(10,2) DEFAULT NULL COMMENT '最新余额',
  `sn` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `note` varchar(255) NOT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `remark` varchar(3000) NOT NULL DEFAULT '' COMMENT '余额明细备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COMMENT='美业师余额变动表';

#
# Structure for table "m2_stylist_balance_return_log"
#

CREATE TABLE `m2_stylist_balance_return_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL COMMENT '美业师id',
  `in_out` tinyint(3) NOT NULL DEFAULT '2' COMMENT '1为收入，2为支出',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `sn_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '押金',
  `sn` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `note` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `remark` varchar(3000) NOT NULL DEFAULT '' COMMENT '余额明细备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8 COMMENT='美业师余额变动线下回退记录表';

#
# Structure for table "m2_stylist_bank"
#

CREATE TABLE `m2_stylist_bank` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '类型',
  `account_name` varchar(60) NOT NULL COMMENT '持卡人',
  `bank_name` varchar(255) NOT NULL COMMENT '开户行',
  `account_id` varchar(48) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `deleted_at` datetime NOT NULL COMMENT '删除时间',
  `is_del` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否删除，1未删除，2已删除',
  `is_default` tinyint(3) NOT NULL DEFAULT '0' COMMENT '此卡是否为默认银行卡,0不是，1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='美业师提现银行卡';

#
# Structure for table "m2_stylist_bond_log"
#

CREATE TABLE `m2_stylist_bond_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `sn` varchar(255) DEFAULT NULL COMMENT '订单号',
  `type` int(8) DEFAULT NULL COMMENT '1为美业师线上缴纳，2为购买线上包，3为城市合伙人，4为订单，100为美业师申请退押金',
  `in_out` tinyint(3) DEFAULT NULL COMMENT '1为收入，2为支出',
  `bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '押金金额',
  `note` varchar(255) DEFAULT NULL COMMENT '备注',
  `admin_name` varchar(50) NOT NULL DEFAULT '系统' COMMENT '操作员',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `stylist_id` (`stylist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COMMENT='美业师押金记录表';

#
# Structure for table "m2_stylist_bond_logs"
#

CREATE TABLE `m2_stylist_bond_logs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `stylist_id` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '美业师ＩＤ',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `type` varchar(1) COLLATE utf8_bin NOT NULL COMMENT '类型:+增加　-减少',
  `title` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '标题(理由)',
  `admin_id` int(11) NOT NULL COMMENT '操作员',
  `total` decimal(10,2) NOT NULL COMMENT '小计金额',
  `date_added` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=407 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_stylist_cat_log"
#

CREATE TABLE `m2_stylist_cat_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `food` int(11) NOT NULL DEFAULT '0' COMMENT '猫粮',
  `in_out` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1获取，2支出',
  `type` tinyint(3) DEFAULT NULL COMMENT '获取类型，1为登陆获取',
  `info` varchar(255) DEFAULT '' COMMENT '变动来源',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1203 DEFAULT CHARSET=utf8 COMMENT='美业师猫粮记录';

#
# Structure for table "m2_stylist_certifi_manag"
#

CREATE TABLE `m2_stylist_certifi_manag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_name` varchar(15) NOT NULL COMMENT '证书名',
  `c_sn_rule` varchar(20) NOT NULL COMMENT '证书的编号例如以CMA开头',
  `c_skill_type` int(5) NOT NULL DEFAULT '0',
  `c_skill_name` varchar(25) NOT NULL COMMENT '认证类型名字(冗余)',
  `c_summary` varchar(256) NOT NULL COMMENT '证书的说明',
  `c_image` varchar(256) NOT NULL COMMENT '证书的样式-图片URl',
  `creat_date` datetime NOT NULL COMMENT '创建证书的时间',
  `update_date` datetime NOT NULL COMMENT '更新证书的时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `c_name` (`c_name`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_stylist_certificate"
#

CREATE TABLE `m2_stylist_certificate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `sn` varchar(32) NOT NULL DEFAULT '' COMMENT '证书编号',
  `stylist_id` int(10) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '认证项目1|化妆,64|美睫,128|纹绣',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '验证状态0:未验证;1:验证中;2:已验证;3已发证',
  `create_at` datetime NOT NULL COMMENT '发证时间',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证文件',
  `real_name` varchar(15) NOT NULL DEFAULT '' COMMENT '造型师的名字',
  `certificate_id` int(11) NOT NULL DEFAULT '0',
  `mobile` char(11) DEFAULT NULL,
  `cer_type` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_stylist_certificate_sn` (`sn`)
) ENGINE=InnoDB AUTO_INCREMENT=2690 DEFAULT CHARSET=utf8 COMMENT='美业师证书验证表';

#
# Structure for table "m2_stylist_examine_log"
#

CREATE TABLE `m2_stylist_examine_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '考核方式，1为现场考核，2为免试通过',
  `stylist_id` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户的id',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '上一次考核状态：1为通过，0为不通过',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `img_url` varchar(255) NOT NULL COMMENT '证明文件（图片）',
  `examine_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '考核类型，0为技师考核，1为化妆，2为纹绣，3为美睫',
  `examine_con` varchar(255) NOT NULL COMMENT '考核内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7254 DEFAULT CHARSET=utf8 COMMENT='考核日志';

#
# Structure for table "m2_stylist_meta"
#

CREATE TABLE `m2_stylist_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `key` char(8) NOT NULL DEFAULT '',
  `value` varchar(192) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_stylist_meta_iid_key_value` (`iid`,`key`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=2584 DEFAULT CHARSET=utf8 COMMENT='造型师元数据';

#
# Structure for table "m2_stylist_points_serial"
#

CREATE TABLE `m2_stylist_points_serial` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `stylist_id` int(11) NOT NULL DEFAULT '0',
  `in_out` enum('INCOME','OUTPUT') NOT NULL DEFAULT 'INCOME' COMMENT '收入-支出',
  `points_en_code` varchar(30) NOT NULL COMMENT '积分执行类型编码',
  `additional_number` varchar(255) NOT NULL COMMENT '1.积分换购礼品时的订单号；2.积分换购邮费时的邮费单号；3.积分换购优惠券时的券号',
  `message` varchar(50) NOT NULL COMMENT '积分加减说明',
  `points` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL COMMENT '积分创建时间',
  `effected_at` datetime NOT NULL COMMENT '积分生效时间',
  `deadline_at` datetime NOT NULL COMMENT '积分过期时间',
  `status` enum('FROZEN','EFFECTIVE','INVALID') NOT NULL DEFAULT 'FROZEN' COMMENT 'FROZEN：冻结中；EFFECTIVE：生效；INVALID：失效(交易被取消，非积分过期，该状态的记录不被作为计算总积分的凭据)；',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unqiue_id_additional_number_points_en_code` (`id`,`additional_number`,`points_en_code`)
) ENGINE=InnoDB AUTO_INCREMENT=10002432 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_stylist_product"
#

CREATE TABLE `m2_stylist_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `stylist_id` int(10) unsigned NOT NULL COMMENT '技师的id',
  `product_id` int(10) unsigned NOT NULL COMMENT '服务产品的id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态，0：等待审核，1，审核通过，2审核不通过',
  `action` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '动作，1:添加作品，2移除作品',
  `reason` varchar(255) NOT NULL DEFAULT '' COMMENT '审核的理由',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `created_user` varchar(20) NOT NULL DEFAULT '' COMMENT '审核人',
  `deleted_at` datetime NOT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=163924 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='技师服务产品审核表';

#
# Structure for table "m2_stylist_return_bond"
#

CREATE TABLE `m2_stylist_return_bond` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '要退回的押金',
  `account_name` varchar(60) NOT NULL DEFAULT '' COMMENT '开户人',
  `bank_name` varchar(255) NOT NULL DEFAULT '' COMMENT '开户行',
  `account_id` varchar(50) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `status` int(6) NOT NULL DEFAULT '100' COMMENT '状态，100退回中，200已拒绝，300退回失败，1000退回完成',
  `info` varchar(255) DEFAULT '' COMMENT '返回信息',
  `remark` varchar(3000) NOT NULL DEFAULT '' COMMENT '备注信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='美业师退押金申请表';

#
# Structure for table "m2_stylist_schedule"
#

CREATE TABLE `m2_stylist_schedule` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `stylist_id` bigint(10) unsigned NOT NULL COMMENT '造型师的用户ID',
  `type` int(11) NOT NULL COMMENT '类型：0: 无效时间段 1: 空闲时间段, 2: 忙碌时间段',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的结束时间',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `index_stylist_type` (`stylist_id`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=36711 DEFAULT CHARSET=utf8 COMMENT='造型师的日程时间表';

#
# Structure for table "m2_stylist_ser"
#

CREATE TABLE `m2_stylist_ser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `stylist_id` int(10) unsigned NOT NULL COMMENT '对应造型师ID',
  `product_id` text COMMENT '所对应的产品表的ID',
  `free_time` text COMMENT '空闲时间段',
  `server_street` text COMMENT '美业师服务商圈',
  `weekday_free_time` text COMMENT '工作日空闲时间段',
  `server_city` int(10) NOT NULL COMMENT '市id',
  `weekend_free_time` text COMMENT '非工作日空闲时间段',
  PRIMARY KEY (`id`),
  UNIQUE KEY `stylist_id` (`stylist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1888 DEFAULT CHARSET=utf8 COMMENT='造型师的服务产品表';

#
# Structure for table "m2_stylist_service"
#

CREATE TABLE `m2_stylist_service` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `stylist_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应美业师表id',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应服务表的id',
  `online` tinyint(3) DEFAULT '2' COMMENT '商品状态 1为上架，0为下架 2为待审核 3审核不通过 4以保存',
  `type_user` tinyint(3) unsigned DEFAULT '2' COMMENT '区别服务是谁添加 2俏猫平台添加 1美业师自己添加',
  `cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '服务的一级分类id',
  `cate_id_2` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `create_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `is_del` tinyint(3) DEFAULT '0' COMMENT '是否删除 1是删除 0未删除',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=64603 DEFAULT CHARSET=utf8 COMMENT='美业师所拥有的服务表';

#
# Structure for table "m2_stylist_show_product"
#

CREATE TABLE `m2_stylist_show_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的造型师的id',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `pic_url` varchar(100) NOT NULL DEFAULT '' COMMENT '化妆师的展示作品',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '展示的对应的作品的描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104948 DEFAULT CHARSET=utf8 COMMENT='广告表';

#
# Structure for table "m2_stylist_stats"
#

CREATE TABLE `m2_stylist_stats` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'stylist.id',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评分',
  `average_price` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '均价',
  `history_orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单数',
  `fans` bigint(20) NOT NULL DEFAULT '0' COMMENT '美业师的粉丝统计',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='统计表';

#
# Structure for table "m2_stylist_studio"
#

CREATE TABLE `m2_stylist_studio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `studio_name` varchar(32) NOT NULL DEFAULT '' COMMENT '工作室名称',
  `type` varchar(64) NOT NULL DEFAULT '' COMMENT '工作室服务内容',
  `phone` varchar(20) DEFAULT NULL COMMENT '工作室联系方式',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '工作室的介绍',
  `front_photo` varchar(255) NOT NULL COMMENT '工作室前台图片',
  `photo` text COMMENT '工作室图片，多个图片用|隔开',
  `leader_name` varchar(20) NOT NULL DEFAULT '' COMMENT '负责人姓名',
  `leader_mobile` char(11) NOT NULL DEFAULT '' COMMENT '负责人的手机号',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `create_at` datetime NOT NULL COMMENT '添加时间',
  `stylist_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `unique_stylist_studio_leader_mobile` (`leader_mobile`) USING BTREE,
  KEY `stylist_id` (`stylist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4084 DEFAULT CHARSET=utf8 COMMENT='俏猫招募工作室表';

#
# Structure for table "m2_stylist_temp"
#

CREATE TABLE `m2_stylist_temp` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分销用户ID',
  `stylist_id` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '造型师的用户ID',
  `real_name` varchar(15) DEFAULT '' COMMENT '名字',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '联系的手机号',
  `is_check` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否审核,1为已审核，2为审核中，3为审核不通过',
  `stylist_type` int(11) NOT NULL DEFAULT '0' COMMENT '造型师类型，1|化妆,2|造型,4|美甲,32|普通商品,64|美睫,128|纹绣',
  `created_at` datetime DEFAULT NULL COMMENT '导入时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `registration_nature` tinyint(4) NOT NULL DEFAULT '1' COMMENT '注册性质，1为手工导入美业师数据，2为手工导入用户数据',
  `connection_status` varchar(255) NOT NULL DEFAULT '' COMMENT '联系状态，T: 考虑，*：感兴趣， N：无兴趣，M：发短信，E：发邮箱，W：加微信， Q：加QQ，---- : 未接，O：关机， X：停机或号码错误',
  `reason` varchar(255) NOT NULL DEFAULT '' COMMENT '备注信息',
  `password` varchar(255) NOT NULL DEFAULT 'abc123456' COMMENT '初始密码',
  `distribution` varchar(255) NOT NULL DEFAULT '' COMMENT '分配',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `sub_title` varchar(100) NOT NULL COMMENT '副标题',
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `province_id` int(5) NOT NULL DEFAULT '0',
  `city_id` int(5) NOT NULL DEFAULT '0',
  `area_id` int(5) NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6111 DEFAULT CHARSET=utf8 COMMENT='美业师分销导入表';

#
# Structure for table "m2_stylist_transpay_log"
#

CREATE TABLE `m2_stylist_transpay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flow_id` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '关联入账的id',
  `stylist_name` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '申请的美业师名称',
  `stylist_id` int(11) NOT NULL COMMENT '美业师id',
  `money` decimal(10,2) NOT NULL COMMENT '申请金额',
  `alipay_no` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '支付宝打款流水号',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-申请中，2-打款成功',
  `admin_name` varchar(24) COLLATE utf8_bin NOT NULL COMMENT '操作的管理员名称',
  `admin_id` int(10) NOT NULL COMMENT '管理员id',
  `msg` text COLLATE utf8_bin NOT NULL COMMENT '异步通知的全部信息',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '完成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_stylist_tx"
#

CREATE TABLE `m2_stylist_tx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '要提现的金额',
  `here_bal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现之前的总余额',
  `now_bal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现之后的总余额',
  `account_name` varchar(60) NOT NULL DEFAULT '' COMMENT '开户人',
  `bank_name` varchar(255) NOT NULL DEFAULT '' COMMENT '开户行',
  `account_id` varchar(50) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `status` int(6) NOT NULL DEFAULT '100' COMMENT '状态，100提现中，200已拒绝，300提现失败，1000提现完成',
  `info` varchar(255) DEFAULT '' COMMENT '返回信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='美业师余额提现申请表';

#
# Structure for table "m2_stylist_type"
#

CREATE TABLE `m2_stylist_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '类型名',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0|使用中;1|暂停使用',
  `value` int(11) NOT NULL DEFAULT '0' COMMENT '临时值',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '名称标识',
  `is_used` int(1) NOT NULL DEFAULT '0' COMMENT '是否使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='美业师类型表';

#
# Structure for table "m2_stylist_wallet"
#

CREATE TABLE `m2_stylist_wallet` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `account_name` varchar(60) NOT NULL COMMENT '持卡人',
  `bank_name` varchar(255) NOT NULL COMMENT '开户行',
  `account_id` varchar(48) NOT NULL COMMENT '银行卡号|支付宝帐号ID',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `deleted_at` datetime NOT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14867 DEFAULT CHARSET=utf8 COMMENT='造型师账户信息表';

#
# Structure for table "m2_stylist_warning"
#

CREATE TABLE `m2_stylist_warning` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `stylist_id` int(11) NOT NULL DEFAULT '0' COMMENT '美业师ID',
  `stylist_name` varchar(50) NOT NULL DEFAULT '' COMMENT '美业师姓名',
  `stylist_mobile` char(11) NOT NULL DEFAULT '' COMMENT '美业师手机号',
  `order_number` tinyint(4) NOT NULL DEFAULT '0' COMMENT '当天订单数',
  `ab_cause` varchar(500) NOT NULL DEFAULT '' COMMENT '异常原因',
  `time` datetime NOT NULL COMMENT '预警时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='异常店铺预警管理';

#
# Structure for table "m2_stylist_withdrawal_flow"
#

CREATE TABLE `m2_stylist_withdrawal_flow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `flow_id` varchar(32) NOT NULL COMMENT '流水号',
  `flow_from` varchar(32) NOT NULL DEFAULT '' COMMENT '流水产生来源，订单sn等',
  `applicant_id` int(11) NOT NULL DEFAULT '0',
  `applicant_name` varchar(32) NOT NULL DEFAULT '' COMMENT '申请人姓名',
  `applicant_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '申请来源：0美业师；1用户；',
  `applicant_mobile` char(11) NOT NULL DEFAULT '' COMMENT '申请人手机号',
  `pay_account` varchar(64) NOT NULL DEFAULT '' COMMENT '申请人支付账号',
  `in_out` tinyint(1) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL COMMENT '进出金额数（正负数）实际支付金额',
  `three_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '第三方支付金额',
  `jifen_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分抵现金额',
  `balance_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额支付',
  `pre_tax_income` decimal(10,2) NOT NULL COMMENT '美业师税前收入',
  `after_tax_income` decimal(10,2) NOT NULL COMMENT '税后美业师可以提现的金额',
  `tax` decimal(10,2) NOT NULL COMMENT '个税的金额根据公式计算得出',
  `first_transpay` decimal(10,2) NOT NULL COMMENT '初次打款的金额',
  `second_transpay` decimal(10,2) NOT NULL COMMENT '二次打款，主要针对纹绣的商品',
  `coupon_paid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠券支付金额',
  `margin` decimal(10,2) NOT NULL COMMENT '进出保证金（正负数）',
  `latest_balance` decimal(10,2) NOT NULL COMMENT '最新余额',
  `latest_margin` decimal(10,2) NOT NULL COMMENT '最新保证金金额',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '流水状态：0 未审核 | 1 已审核 | 2 已入账或已打款| 3 纹绣第一次打款',
  `order_product_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '入账的订单类型，1-化妆类，2-美睫类，3-纹绣类,99-其它',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '审核备注说明',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `payment_second_time` datetime NOT NULL COMMENT '二次打款的时间',
  `payment_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '打款日期',
  `first_success_details` text NOT NULL COMMENT '第一次打款第三方返回的notify通知数据success_details',
  `second_success_details` text NOT NULL COMMENT '第二次打款第三方返回的notify通知数据success_details',
  `audit_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '审核时间',
  `this_deposit_radio` float(5,2) NOT NULL COMMENT '当前入账美业师保证金比',
  `this_deposit_money` float(5,2) NOT NULL COMMENT '当前扣除的保证金',
  `this_second_transradio` float(5,2) NOT NULL DEFAULT '0.10' COMMENT '针对二次打款的占比',
  `this_profit_radio` float(5,2) NOT NULL COMMENT '当前入账美业师收益比',
  `three_msg` text NOT NULL COMMENT '第三方返回的信息notify信息若有两次以''|''作为分隔',
  `is_deductCoupon` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否扣除优惠劵标识 1，扣除2不扣除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_stylist_withdrawal_flow_id` (`flow_id`),
  UNIQUE KEY `unique_stylist_withdrawal_flow_from` (`flow_from`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=utf8 COMMENT='用户/美业师提现流水表';

#
# Structure for table "m2_tag"
#

CREATE TABLE `m2_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` int(4) NOT NULL DEFAULT '0' COMMENT '分类父ID，0为顶级分类',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '标签的名字',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示,1为显示0为不显示',
  `pic_url` varchar(100) NOT NULL DEFAULT '' COMMENT '标签图片',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `updated_by` bigint(20) NOT NULL DEFAULT '0' COMMENT '更新人ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100024 DEFAULT CHARSET=utf8 COMMENT='标签表';

#
# Structure for table "m2_temp_deposit_topic11"
#

CREATE TABLE `m2_temp_deposit_topic11` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `deposit_money` decimal(10,2) NOT NULL COMMENT '预付金额',
  `use_money` decimal(10,2) NOT NULL COMMENT '抵扣金额',
  `deposit_product_id` int(11) NOT NULL DEFAULT '0',
  `use_product_id` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `pay_time` datetime NOT NULL COMMENT '支付时间',
  `use_time` datetime NOT NULL COMMENT '使用时间',
  `user_pay_time` datetime NOT NULL COMMENT '使用的支付时间',
  `deposit_order_id` char(64) NOT NULL COMMENT '预付的订单id',
  `use_order_id` char(64) NOT NULL COMMENT '使用的订单id',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_timer_log"
#

CREATE TABLE `m2_timer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_id` int(11) DEFAULT NULL COMMENT '买家id',
  `seller_id` int(11) DEFAULT NULL COMMENT '卖家id',
  `order_sn` varchar(255) DEFAULT NULL COMMENT '订单号',
  `status` tinyint(3) DEFAULT NULL COMMENT '1为执行正常，2为执行异常',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '任务类型->1为订单自动确认结束服务',
  `text` varchar(5000) DEFAULT NULL COMMENT '执行记录说明',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='定时器执行日志记录';

#
# Structure for table "m2_topic"
#

CREATE TABLE `m2_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '专题英文名称',
  `name_cn` varchar(32) NOT NULL DEFAULT '' COMMENT '专题中文名称',
  `create_by` varchar(32) DEFAULT NULL COMMENT '创建人ID',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_topic_admin_sn` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='专题管理';

#
# Structure for table "m2_topic_activity_gift"
#

CREATE TABLE `m2_topic_activity_gift` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(20) NOT NULL COMMENT '用户ID',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `get_time` datetime NOT NULL COMMENT '获取时间',
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠送的产品ID',
  `p_name` varchar(255) NOT NULL DEFAULT '' COMMENT '赠送的产品名称',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未领取；1已经领取；2已经过期',
  `used_by_order_sn` varchar(20) DEFAULT NULL COMMENT '领取该礼品的业务显示订单号',
  `used_time` datetime DEFAULT NULL COMMENT '领取时间',
  `send_by_key` varchar(255) DEFAULT NULL COMMENT '关联的标识',
  `send_by_id` varchar(255) DEFAULT NULL COMMENT '关联的ID',
  `comments` varchar(255) DEFAULT NULL COMMENT '附加说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='专题活动礼品表';

#
# Structure for table "m2_topic_gas_station"
#

CREATE TABLE `m2_topic_gas_station` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `head_img` varchar(300) NOT NULL DEFAULT '' COMMENT '头像',
  `stylist_name` varchar(20) NOT NULL DEFAULT '美业师姓名',
  `stylist_id` int(10) NOT NULL DEFAULT '0' COMMENT '美业师id',
  `contribution_value` int(10) NOT NULL DEFAULT '0' COMMENT '贡献值',
  `update_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `create_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='美业师加油站';

#
# Structure for table "m2_topic_mystp"
#

CREATE TABLE `m2_topic_mystp` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `number` varchar(10) NOT NULL DEFAULT '' COMMENT '编号',
  `uid` bigint(20) NOT NULL COMMENT '用户uid',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `headimgurl` varchar(512) NOT NULL DEFAULT '' COMMENT '用户头像URL',
  `certificate` varchar(512) NOT NULL DEFAULT '' COMMENT '证书',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户最后交互时间',
  `voting_number` int(11) DEFAULT '0' COMMENT '投票数',
  `content` text NOT NULL COMMENT '其他内容',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='美业师投票专题';

#
# Structure for table "m2_topic_mystp_log"
#

CREATE TABLE `m2_topic_mystp_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(20) NOT NULL COMMENT '点击投票者用户uid',
  `voting_uid` bigint(20) NOT NULL COMMENT '被投票者用户uid',
  `voting_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '投票时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='美业师投票专题日志';

#
# Structure for table "m2_topic_phonedata"
#

CREATE TABLE `m2_topic_phonedata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `operator` tinyint(3) NOT NULL DEFAULT '0' COMMENT '运营商 1为移动，2为联通，3为电信',
  `prize_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '奖品类型 1为移动30M，2为20M联通，3为电信30M，8为888元美妆券',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 1为等待发奖，2为已发奖',
  `admin_id` varchar(255) DEFAULT NULL COMMENT '操作人',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COMMENT='俏猫转盘抽奖送流量活动';

#
# Structure for table "m2_topic_plate"
#

CREATE TABLE `m2_topic_plate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `code` tinyint(3) DEFAULT NULL COMMENT '奖品代号',
  `prize` varchar(255) DEFAULT '' COMMENT '奖品名称',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COMMENT='幸运大转盘活动';

#
# Structure for table "m2_topic_qcat3"
#

CREATE TABLE `m2_topic_qcat3` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `prize_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id',
  `prize_name` varchar(200) NOT NULL DEFAULT '' COMMENT '奖品名称',
  `real_name` varchar(100) DEFAULT '' COMMENT '收货人',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机号码',
  `address` varchar(255) DEFAULT '' COMMENT '收货地址',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='俏猫3周年抽奖信息表';

#
# Structure for table "m2_topic_qcat3_num"
#

CREATE TABLE `m2_topic_qcat3_num` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `in_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '已获得的总次数',
  `be_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '剩余抽奖次数',
  `type` varchar(255) DEFAULT NULL COMMENT '次数分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='用户抽奖次数表';

#
# Structure for table "m2_topic_qcat3_prize"
#

CREATE TABLE `m2_topic_qcat3_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prize_name` varchar(200) NOT NULL DEFAULT '' COMMENT '奖品名称',
  `in_num` int(11) NOT NULL DEFAULT '0' COMMENT '历史总数量',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '剩余数量',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1为俏猫3周年，后续添加',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='俏猫3周年奖品列表';

#
# Structure for table "m2_topic_replacestylist"
#

CREATE TABLE `m2_topic_replacestylist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `mobile` char(11) NOT NULL COMMENT '手机号码',
  `reason` varchar(50) NOT NULL COMMENT '投诉理由',
  `order_id` char(64) NOT NULL COMMENT '订单号',
  `image` varchar(255) NOT NULL COMMENT '投诉凭证图片',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未处理,1:已处理',
  `create_time` datetime NOT NULL COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_topic_three_jb"
#

CREATE TABLE `m2_topic_three_jb` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `wechat_id` varchar(255) NOT NULL COMMENT '微信id',
  `value` varchar(255) NOT NULL DEFAULT '' COMMENT '数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='俏猫三周年领取金币';

#
# Structure for table "m2_topic_three_question"
#

CREATE TABLE `m2_topic_three_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content` varchar(255) NOT NULL COMMENT '用户答题内容',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '回答次数',
  `q_key` varchar(100) NOT NULL DEFAULT '1A' COMMENT '用户答题标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='俏猫三周年问卷调查表';

#
# Structure for table "m2_topic_tpl"
#

CREATE TABLE `m2_topic_tpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tpl_name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '专题名称',
  `tpl_key` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '模板ＩＤ',
  `tpl_image_path` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '图片路径',
  `tpl_image_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '图片名称',
  `date_added` datetime NOT NULL COMMENT '添加时间',
  `admin_id` int(6) NOT NULL COMMENT '创建者ＩＤ',
  `key` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '键值',
  `sn` varchar(45) COLLATE utf8_bin NOT NULL COMMENT '编号',
  `ext_data` longtext COLLATE utf8_bin NOT NULL COMMENT '扩展信息',
  `description` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Structure for table "m2_topic_ysl"
#

CREATE TABLE `m2_topic_ysl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `force_value` int(11) NOT NULL DEFAULT '0' COMMENT '武力值',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '１真实用户，２马甲',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='圣罗兰召唤符选手表';

#
# Structure for table "m2_topic_ysl_log"
#

CREATE TABLE `m2_topic_ysl_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supporter` int(11) NOT NULL DEFAULT '0' COMMENT '支持者id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '被支持者id',
  `force_value` int(11) NOT NULL DEFAULT '0' COMMENT '支持武力值',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='圣罗兰支持记录表';

#
# Structure for table "m2_user"
#

CREATE TABLE `m2_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(125) NOT NULL,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `source` int(11) NOT NULL DEFAULT '0' COMMENT '注册来源',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '等级',
  `points` bigint(20) NOT NULL DEFAULT '0' COMMENT '购物积分',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户余额',
  `real_name` varchar(50) NOT NULL COMMENT '真实姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '上次登录ip',
  `create_time` datetime NOT NULL COMMENT '注册时间',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `province_id` varchar(255) NOT NULL COMMENT '省份',
  `city_id` varchar(255) NOT NULL COMMENT '城市',
  `area_id` varchar(255) NOT NULL COMMENT '区',
  `street_id` int(11) NOT NULL DEFAULT '0',
  `addr_type` smallint(1) NOT NULL DEFAULT '0' COMMENT '地址类型，0家庭 1公司 3其他',
  `address` varchar(255) NOT NULL COMMENT '街道',
  `postcode` varchar(255) NOT NULL COMMENT '邮政编码',
  `telphone` varchar(255) NOT NULL COMMENT '电话',
  `birthday` varchar(255) NOT NULL COMMENT '生日',
  `channel` varchar(255) NOT NULL COMMENT '渠道来源？',
  `login_status` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '用户头像',
  `tagids` varchar(50) NOT NULL COMMENT '标签ID组 1,2,3,',
  `diggnum` int(11) NOT NULL DEFAULT '0' COMMENT '获赞数',
  `wealth` int(11) NOT NULL DEFAULT '0' COMMENT '财富',
  `commission` int(11) NOT NULL DEFAULT '0' COMMENT '总的佣金',
  `idcard` char(37) NOT NULL COMMENT '身份证文件',
  `locked` int(1) NOT NULL DEFAULT '0' COMMENT '是否被锁1为被锁状态',
  `ad_source` varchar(100) NOT NULL COMMENT '推广来源',
  `service_customer` smallint(6) NOT NULL DEFAULT '0' COMMENT '客服专员',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员分组ID',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `jd_token` varchar(255) NOT NULL,
  `remember_token` varchar(100) NOT NULL COMMENT '检验码',
  `career` varchar(225) NOT NULL COMMENT '用户的职业',
  `order_nums` int(11) NOT NULL DEFAULT '0' COMMENT '下单数',
  `invate_id` int(10) DEFAULT '0',
  `is_dresser` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否为美业师，1不是2是',
  `device_id` varchar(255) NOT NULL DEFAULT '0' COMMENT '用户登录最新的设备id',
  `u_pl_sysid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推广链接表ID',
  `wechat_id` varchar(255) DEFAULT NULL COMMENT '微信号',
  `wechat_avatar` varchar(255) DEFAULT NULL COMMENT '微信头像',
  `wechat_nickname` varchar(255) DEFAULT NULL COMMENT '微信昵称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mobile` (`mobile`),
  KEY `u_pl_sysid` (`u_pl_sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=500006634 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_account"
#

CREATE TABLE `m2_user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `weibo_id` varchar(100) DEFAULT NULL COMMENT '微博账号',
  `tencent_id` varchar(100) DEFAULT NULL COMMENT '腾讯微博账号',
  `qq_id` varchar(100) DEFAULT NULL COMMENT 'QQ账号',
  `alipay_id` varchar(100) DEFAULT NULL COMMENT '支付宝ID',
  `wechat_id` varchar(100) DEFAULT NULL COMMENT '微信ID',
  `wechat_xcx_id` varchar(100) DEFAULT '' COMMENT '微信小程序id',
  `douban_id` varchar(100) DEFAULT NULL COMMENT '豆瓣ID',
  `renren_id` varchar(100) DEFAULT NULL COMMENT '人人网ID',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8 COMMENT='用户社区账号表';

#
# Structure for table "m2_user_address"
#

CREATE TABLE `m2_user_address` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `address_name` varchar(50) NOT NULL DEFAULT '' COMMENT '地址别名',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收件人',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `province` int(11) NOT NULL DEFAULT '0' COMMENT '省份ID',
  `city` int(11) NOT NULL DEFAULT '0' COMMENT '市级ID',
  `district` int(11) NOT NULL DEFAULT '0' COMMENT '区ID',
  `street` varchar(50) NOT NULL COMMENT '商圈id',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '街道地址',
  `zipcode` varchar(60) NOT NULL DEFAULT '' COMMENT '邮编',
  `tel` varchar(60) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(60) NOT NULL DEFAULT '' COMMENT '移动电话',
  `sign_building` varchar(120) NOT NULL DEFAULT '' COMMENT '标识性建筑',
  `best_time` varchar(120) NOT NULL DEFAULT '' COMMENT '最佳送货时间(none,holiday,workday,other)',
  `is_default` int(1) NOT NULL DEFAULT '0' COMMENT '1默认0不是',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10006328 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_attention_stylist"
#

CREATE TABLE `m2_user_attention_stylist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `stylist_id` bigint(20) NOT NULL DEFAULT '0',
  `is_attent` int(1) NOT NULL DEFAULT '0' COMMENT '用户的id',
  `created_at` datetime DEFAULT NULL COMMENT '关注的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1204 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Structure for table "m2_user_balance"
#

CREATE TABLE `m2_user_balance` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `in_out` tinyint(4) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL COMMENT '进出金额数（正负数）',
  `latest_balance` decimal(10,2) NOT NULL COMMENT '最新余额',
  `sn` varchar(30) NOT NULL COMMENT '订单/充值当序列号',
  `note` varchar(255) NOT NULL COMMENT '备注说明',
  `created_at` datetime NOT NULL COMMENT '时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_balance_in_out_sn` (`sn`,`in_out`),
  KEY `index_user_balance_uid` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1203 DEFAULT CHARSET=utf8 COMMENT='用户余额流水表';

#
# Structure for table "m2_user_channel"
#

CREATE TABLE `m2_user_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) DEFAULT NULL,
  `c_name` varchar(50) NOT NULL DEFAULT '' COMMENT '渠道名字',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否使用，1使用，0不使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户渠道来源表';

#
# Structure for table "m2_user_cmbcart"
#

CREATE TABLE `m2_user_cmbcart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `cust_argno` varchar(35) NOT NULL COMMENT ' 互联网商户签约协议号',
  `respcod` varchar(10) NOT NULL COMMENT ' 签约请求时的附加参数 ',
  `respmsg` varchar(88) NOT NULL COMMENT ' 返回签约信息 ',
  `noticepara` varchar(130) NOT NULL COMMENT ' 签约请求时的附加参数 ',
  `cust_no` varchar(33) NOT NULL COMMENT ' 互联网商户客户 ID ',
  `cust_pidty` varchar(3) NOT NULL COMMENT ' 证件类型: 目前只有 1 ,表示身份证 ',
  `cust_open_d_pay` varchar(2) NOT NULL COMMENT ' 事例值:N ',
  `cust_pid_v` varchar(33) NOT NULL COMMENT ' 招行后台生成hash值 ',
  `cart_num` varchar(33) NOT NULL DEFAULT '0' COMMENT ' 签约的卡号,显示后4位 ',
  `cart_txt` text COMMENT ' 签约回调返回的信息 ',
  `cart_name` varchar(33) NOT NULL,
  `signDate` datetime DEFAULT '2016-08-29 15:00:00' COMMENT '签约日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_code"
#

CREATE TABLE `m2_user_code` (
  `uc_u_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `uc_code` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `uc_dateline` int(11) unsigned DEFAULT '0' COMMENT '失效时间，生成60秒后失效',
  UNIQUE KEY `uc_u_id` (`uc_u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户临时密码表-用于后台登陆';

#
# Structure for table "m2_user_coupon_cash"
#

CREATE TABLE `m2_user_coupon_cash` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `sn` varchar(20) NOT NULL COMMENT '优惠券编号',
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `amount` double NOT NULL COMMENT '账面额',
  `note` varchar(255) DEFAULT NULL COMMENT '券说明',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '过期时间',
  `active_time` datetime DEFAULT NULL COMMENT '激活的时间',
  `used_time` datetime DEFAULT NULL COMMENT '使用时间',
  `des` varchar(200) NOT NULL COMMENT '使用条件',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0未使用1已经使用2已过期3冻结中',
  `order_sn` varchar(30) DEFAULT NULL COMMENT '使用订单号',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '抵扣金额',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除',
  `send_by_order_sn` bigint(20) DEFAULT '0' COMMENT '该优惠券来源于哪个订单业务编号,下单后赠送的这张券处于冻结中，30后不退单才能用',
  `operator` int(11) DEFAULT '0' COMMENT '操作者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108379 DEFAULT CHARSET=utf8 COMMENT='会员的现金优惠券表';

#
# Structure for table "m2_user_favorite"
#

CREATE TABLE `m2_user_favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `pid` int(11) NOT NULL COMMENT '产品ID',
  `created_at` datetime DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=293 DEFAULT CHARSET=utf16 COMMENT='用户产品服务收藏';

#
# Structure for table "m2_user_geo"
#

CREATE TABLE `m2_user_geo` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `latitude` decimal(10,2) DEFAULT '0.00' COMMENT '经度',
  `longitude` decimal(10,2) DEFAULT '0.00' COMMENT '纬度',
  `province_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_gift"
#

CREATE TABLE `m2_user_gift` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `get_time` datetime DEFAULT NULL COMMENT '产生时间',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠送的产品ID',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未领取；1已经领取；2已经过期',
  `used_by_order_sn` varchar(20) DEFAULT NULL COMMENT '领取该赠品的业务显示订单号',
  `used_time` datetime DEFAULT NULL COMMENT '领取时间',
  `send_by_ask_id` varchar(255) DEFAULT NULL COMMENT '关联的问题ID（回答这些问题而产生此礼品）',
  `comments` varchar(255) DEFAULT NULL COMMENT '附加说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='赠品表';

#
# Structure for table "m2_user_hzsabc"
#

CREATE TABLE `m2_user_hzsabc` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(125) NOT NULL,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '上次登录ip',
  `create_time` datetime NOT NULL COMMENT '注册时间',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `order_nums` int(11) NOT NULL DEFAULT '0' COMMENT '下单数',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '关联m2_stylist_type表id',
  `real_name` varchar(15) NOT NULL DEFAULT '' COMMENT '造型师的名字',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1为男，2为女',
  `user_img` varchar(55) NOT NULL DEFAULT '' COMMENT '造型师的头像',
  `work_years` varchar(5) NOT NULL DEFAULT '' COMMENT '造型师的工作起始年限',
  `history_orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师历史订单量',
  `num_orders_extra` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师临时添加的订单量',
  `is_setSchedule` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置行程，用于提示美业师第一次修改行程',
  `is_setStreet` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置商圈，用于提示美业师第一次修改商圈',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '造型师的介绍',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city` varchar(11) NOT NULL DEFAULT '' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证文件',
  `idcard_img` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证图片',
  `longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '造型师的等级',
  `photo` text COMMENT '造型师的作品，多个作品用|隔开',
  `stylist_product_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师产品保证金',
  `stylist_service_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师服务保证金',
  `stylist_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '造型师 余额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '当前是否预约，1未预约，2已预约',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的结束时间',
  `is_online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否在线，1不在线，2在线',
  `is_check` tinyint(4) NOT NULL DEFAULT '4' COMMENT '是否审核,1为已审核，2为审核中，3审核不通过，4新用户未审核',
  `last_examine_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '考核状态：1为通过，0为不通过',
  `reason` varchar(255) NOT NULL COMMENT '审核理由',
  `created_at` datetime NOT NULL COMMENT '技师的注册时间',
  `online_at` datetime NOT NULL COMMENT '美业师第一次上线时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `cma_img` varchar(200) NOT NULL COMMENT 'CMA证书头像',
  `is_union_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为联合会会员1｜是，0｜否',
  `honor` varchar(1000) NOT NULL COMMENT '获得的荣誉',
  `trained_experience` varchar(1000) CHARACTER SET dec8 COLLATE dec8_bin NOT NULL COMMENT '培训经历',
  `work_experience` varchar(1000) NOT NULL COMMENT '工作经历',
  `birthday` varchar(45) NOT NULL COMMENT '生日',
  `weixin` varchar(45) NOT NULL COMMENT '微信号',
  `recommend_id` int(11) NOT NULL DEFAULT '0',
  `contract_no` varchar(50) NOT NULL COMMENT '合同编号',
  `stylist_certificate_sn` varchar(32) NOT NULL COMMENT '化妆师联合会证书编号',
  `hasStore` tinyint(4) NOT NULL DEFAULT '0',
  `street_id` varchar(45) DEFAULT NULL COMMENT '商圈ID',
  `wechat_no` varchar(255) NOT NULL COMMENT '微信号',
  `autograph_img` varchar(255) NOT NULL COMMENT '签名图片路径',
  `fail` tinyint(4) NOT NULL DEFAULT '0',
  `is_professional` int(2) DEFAULT NULL COMMENT '是否专业会员(1:是  2：否)',
  `out_trade_no` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mobile` (`mobile`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=650000830 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_hzsabc_old"
#

CREATE TABLE `m2_user_hzsabc_old` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(125) NOT NULL,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '上次登录ip',
  `create_time` datetime NOT NULL COMMENT '注册时间',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `order_nums` int(11) NOT NULL DEFAULT '0' COMMENT '下单数',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '关联m2_stylist_type表id',
  `real_name` varchar(15) NOT NULL DEFAULT '' COMMENT '造型师的名字',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1为男，2为女',
  `user_img` varchar(55) NOT NULL DEFAULT '' COMMENT '造型师的头像',
  `work_years` varchar(5) NOT NULL DEFAULT '' COMMENT '造型师的工作起始年限',
  `history_orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师历史订单量',
  `num_orders_extra` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师临时添加的订单量',
  `is_setSchedule` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置行程，用于提示美业师第一次修改行程',
  `is_setStreet` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置商圈，用于提示美业师第一次修改商圈',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '造型师的介绍',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证文件',
  `idcard_img` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证图片',
  `longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '造型师的等级',
  `photo` text COMMENT '造型师的作品，多个作品用|隔开',
  `stylist_product_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师产品保证金',
  `stylist_service_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师服务保证金',
  `stylist_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '造型师 余额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '当前是否预约，1未预约，2已预约',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的结束时间',
  `is_online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否在线，1不在线，2在线',
  `is_check` tinyint(4) NOT NULL DEFAULT '4' COMMENT '是否审核,1为已审核，2为审核中，3审核不通过，4新用户未审核',
  `last_examine_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '考核状态：1为通过，0为不通过',
  `reason` varchar(255) NOT NULL COMMENT '审核理由',
  `created_at` datetime NOT NULL COMMENT '技师的注册时间',
  `online_at` datetime NOT NULL COMMENT '美业师第一次上线时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `cma_img` varchar(200) NOT NULL COMMENT 'CMA证书头像',
  `is_union_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为联合会会员1｜是，0｜否',
  `honor` varchar(1000) NOT NULL COMMENT '获得的荣誉',
  `trained_experience` varchar(1000) CHARACTER SET dec8 COLLATE dec8_bin NOT NULL COMMENT '培训经历',
  `work_experience` varchar(1000) NOT NULL COMMENT '工作经历',
  `birthday` varchar(45) NOT NULL COMMENT '生日',
  `weixin` varchar(45) NOT NULL COMMENT '微信号',
  `recommend_id` int(11) NOT NULL DEFAULT '0',
  `contract_no` varchar(50) NOT NULL COMMENT '合同编号',
  `stylist_certificate_sn` varchar(32) NOT NULL COMMENT '化妆师联合会证书编号',
  `hasStore` tinyint(4) NOT NULL DEFAULT '0',
  `street_id` varchar(45) DEFAULT NULL COMMENT '商圈ID',
  `wechat_no` varchar(255) NOT NULL COMMENT '微信号',
  `autograph_img` varchar(255) NOT NULL COMMENT '签名图片路径',
  `fail` tinyint(4) NOT NULL DEFAULT '0',
  `is_professional` int(2) DEFAULT NULL COMMENT '是否专业会员(1:是  2：否)',
  `out_trade_no` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mobile` (`mobile`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_hzsabc2"
#

CREATE TABLE `m2_user_hzsabc2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(125) NOT NULL,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '上次登录ip',
  `create_time` datetime NOT NULL COMMENT '注册时间',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `order_nums` int(11) NOT NULL DEFAULT '0' COMMENT '下单数',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '关联m2_stylist_type表id',
  `real_name` varchar(15) NOT NULL DEFAULT '' COMMENT '造型师的名字',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1为男，2为女',
  `user_img` varchar(55) NOT NULL DEFAULT '' COMMENT '造型师的头像',
  `work_years` varchar(5) NOT NULL DEFAULT '' COMMENT '造型师的工作起始年限',
  `history_orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师历史订单量',
  `num_orders_extra` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师临时添加的订单量',
  `is_setSchedule` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置行程，用于提示美业师第一次修改行程',
  `is_setStreet` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置商圈，用于提示美业师第一次修改商圈',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '造型师的介绍',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city` varchar(11) NOT NULL DEFAULT '' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证文件',
  `idcard_img` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证图片',
  `longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '造型师的等级',
  `photo` text COMMENT '造型师的作品，多个作品用|隔开',
  `stylist_product_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师产品保证金',
  `stylist_service_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师服务保证金',
  `stylist_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '造型师 余额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '当前是否预约，1未预约，2已预约',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的结束时间',
  `is_online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否在线，1不在线，2在线',
  `is_check` tinyint(4) NOT NULL DEFAULT '4' COMMENT '是否审核,1为已审核，2为审核中，3审核不通过，4新用户未审核',
  `last_examine_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '考核状态：1为通过，0为不通过',
  `reason` varchar(255) NOT NULL COMMENT '审核理由',
  `created_at` datetime NOT NULL COMMENT '技师的注册时间',
  `online_at` datetime NOT NULL COMMENT '美业师第一次上线时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `cma_img` varchar(200) NOT NULL COMMENT 'CMA证书头像',
  `is_union_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为联合会会员1｜是，0｜否',
  `honor` varchar(1000) NOT NULL COMMENT '获得的荣誉',
  `trained_experience` varchar(1000) CHARACTER SET dec8 COLLATE dec8_bin NOT NULL COMMENT '培训经历',
  `work_experience` varchar(1000) NOT NULL COMMENT '工作经历',
  `birthday` varchar(45) NOT NULL COMMENT '生日',
  `weixin` varchar(45) NOT NULL COMMENT '微信号',
  `recommend_id` int(11) NOT NULL DEFAULT '0',
  `contract_no` varchar(50) NOT NULL COMMENT '合同编号',
  `stylist_certificate_sn` varchar(32) NOT NULL COMMENT '化妆师联合会证书编号',
  `hasStore` tinyint(4) NOT NULL DEFAULT '0',
  `street_id` varchar(45) DEFAULT NULL COMMENT '商圈ID',
  `wechat_no` varchar(255) NOT NULL COMMENT '微信号',
  `autograph_img` varchar(255) NOT NULL COMMENT '签名图片路径',
  `fail` tinyint(4) NOT NULL DEFAULT '0',
  `is_professional` int(2) DEFAULT NULL COMMENT '是否专业会员(1:是  2：否)',
  `out_trade_no` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mobile` (`mobile`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=650000025 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_hzsabc3"
#

CREATE TABLE `m2_user_hzsabc3` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(125) NOT NULL,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `last_login_time` datetime NOT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '上次登录ip',
  `create_time` datetime NOT NULL COMMENT '注册时间',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `order_nums` int(11) NOT NULL DEFAULT '0' COMMENT '下单数',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '关联m2_stylist_type表id',
  `real_name` varchar(15) NOT NULL DEFAULT '' COMMENT '造型师的名字',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1为男，2为女',
  `user_img` varchar(55) NOT NULL DEFAULT '' COMMENT '造型师的头像',
  `work_years` varchar(5) NOT NULL DEFAULT '' COMMENT '造型师的工作起始年限',
  `history_orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师历史订单量',
  `num_orders_extra` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '造型师临时添加的订单量',
  `is_setSchedule` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置行程，用于提示美业师第一次修改行程',
  `is_setStreet` varchar(3) NOT NULL DEFAULT '1' COMMENT '1-未设置，2-已设置,是否第一次设置商圈，用于提示美业师第一次修改商圈',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '造型师的介绍',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city` varchar(11) NOT NULL DEFAULT '' COMMENT '城市',
  `area_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证文件',
  `idcard_img` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证图片',
  `longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '造型师的等级',
  `photo` text COMMENT '造型师的作品，多个作品用|隔开',
  `stylist_product_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师产品保证金',
  `stylist_service_bond` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '美业师服务保证金',
  `stylist_balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '造型师 余额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '当前是否预约，1未预约，2已预约',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '空闲的结束时间',
  `is_online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否在线，1不在线，2在线',
  `is_check` tinyint(4) NOT NULL DEFAULT '4' COMMENT '是否审核,1为已审核，2为审核中，3审核不通过，4新用户未审核',
  `last_examine_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '考核状态：1为通过，0为不通过',
  `reason` varchar(255) NOT NULL COMMENT '审核理由',
  `created_at` datetime NOT NULL COMMENT '技师的注册时间',
  `online_at` datetime NOT NULL COMMENT '美业师第一次上线时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `cma_img` varchar(200) NOT NULL COMMENT 'CMA证书头像',
  `is_union_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为联合会会员1｜是，0｜否',
  `honor` varchar(1000) NOT NULL COMMENT '获得的荣誉',
  `trained_experience` varchar(1000) CHARACTER SET dec8 COLLATE dec8_bin NOT NULL COMMENT '培训经历',
  `work_experience` varchar(1000) NOT NULL COMMENT '工作经历',
  `birthday` varchar(45) NOT NULL COMMENT '生日',
  `weixin` varchar(45) NOT NULL COMMENT '微信号',
  `recommend_id` int(11) NOT NULL DEFAULT '0',
  `contract_no` varchar(50) NOT NULL COMMENT '合同编号',
  `stylist_certificate_sn` varchar(32) NOT NULL COMMENT '化妆师联合会证书编号',
  `hasStore` tinyint(4) NOT NULL DEFAULT '0',
  `street_id` varchar(45) DEFAULT NULL COMMENT '商圈ID',
  `wechat_no` varchar(255) NOT NULL COMMENT '微信号',
  `autograph_img` varchar(255) NOT NULL COMMENT '签名图片路径',
  `fail` tinyint(4) NOT NULL DEFAULT '0',
  `is_professional` int(2) DEFAULT NULL COMMENT '是否专业会员(1:是  2：否)',
  `out_trade_no` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mobile` (`mobile`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;

#
# Structure for table "m2_user_invitation"
#

CREATE TABLE `m2_user_invitation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `inviter_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '邀请者用户用户ID',
  `invitee_id` bigint(20) NOT NULL DEFAULT '0',
  `invite_code` char(128) NOT NULL COMMENT '邀请码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0邀请中；1邀请成功',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `inviter_name` varchar(50) NOT NULL DEFAULT '' COMMENT '邀请者用户名',
  `invitee_name` varchar(50) NOT NULL DEFAULT '' COMMENT '被邀请者用户名',
  `invitee_mobile` varchar(13) NOT NULL DEFAULT '' COMMENT '被邀者设备ID：手机号',
  `invitee_email` varchar(129) DEFAULT NULL,
  `comment` varchar(144) DEFAULT '' COMMENT '备注',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `updated_by` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_invitation_inviter_invitee_invite_code` (`inviter_id`,`invitee_id`,`invite_code`),
  KEY `index_invitation_invite_code` (`invite_code`),
  KEY `index_invitation_invitee_id` (`invitee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=106424 DEFAULT CHARSET=utf8 COMMENT='用户邀请记录';

#
# Structure for table "m2_user_message"
#

CREATE TABLE `m2_user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL DEFAULT '0',
  `receive_uid` int(11) NOT NULL DEFAULT '0',
  `related_id` bigint(10) unsigned DEFAULT '0',
  `order_sn` varchar(100) DEFAULT NULL COMMENT '订单号',
  `content` text NOT NULL COMMENT '发送信息的内容',
  `message_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '信息类型，1为用户,2为系统,4为订单相关消息,8为评论相关消息',
  `is_send_delete` tinyint(4) NOT NULL DEFAULT '1' COMMENT '删除状态，1表示没删除发送者的，2表示已删除发送者',
  `is_receive_delete` tinyint(4) NOT NULL DEFAULT '1' COMMENT '删除状态，1表示没删除接收者的，2表示已删除接收者',
  `is_reade` tinyint(4) NOT NULL DEFAULT '1' COMMENT '信息读取状态，1未读，2已读',
  `send_time` datetime NOT NULL COMMENT '发送信息的时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间',
  `delete_at` datetime DEFAULT NULL COMMENT '删除时间',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `message_ext` text COMMENT '扩展信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16024 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户站内发送信息表';

#
# Structure for table "m2_user_meta"
#

CREATE TABLE `m2_user_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) NOT NULL DEFAULT '0',
  `key` char(64) NOT NULL DEFAULT '',
  `value` varchar(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `index_order_meta_iid_key_value` (`iid`,`key`,`value`(255))
) ENGINE=InnoDB AUTO_INCREMENT=53146 DEFAULT CHARSET=utf8 COMMENT='用户元数据';

#
# Structure for table "m2_user_news_system"
#

CREATE TABLE `m2_user_news_system` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '发送者',
  `receive_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '接收者id',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `photo` varchar(255) DEFAULT '' COMMENT '图片地址，多个用，号分开',
  `href_url` varchar(255) DEFAULT '' COMMENT '跳转链接地址',
  `be_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联id',
  `is_read` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0未读，1已读',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='用户系统消息表';

#
# Structure for table "m2_user_news_topic"
#

CREATE TABLE `m2_user_news_topic` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(30) NOT NULL DEFAULT '' COMMENT '发送者',
  `receive_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '接收类型，1为用户，2为美业师，3为全部',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `photo` varchar(255) DEFAULT '' COMMENT '图片地址，多个用，号分开',
  `href_url` varchar(255) DEFAULT '' COMMENT '跳转链接地址',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动关联id',
  `is_del` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否显示，1显示，2不显示',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `deadline` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COMMENT='用户活动消息表';

#
# Structure for table "m2_user_news_topic_read"
#

CREATE TABLE `m2_user_news_topic_read` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1为用户，2为美业师',
  `topic_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '消息id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COMMENT='活动消息已读表';

#
# Structure for table "m2_user_notes"
#

CREATE TABLE `m2_user_notes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL COMMENT '用户ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常，2停机，3免打扰，4手机无效',
  `staff_name` varchar(255) NOT NULL DEFAULT '0' COMMENT '执行添加备注者的姓名',
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '执行添加备注者的工号',
  `content` text NOT NULL COMMENT '备注内容',
  `note` text NOT NULL COMMENT '备注',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户备注';

#
# Structure for table "m2_user_points_serial"
#

CREATE TABLE `m2_user_points_serial` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `in_out` enum('INCOME','OUTPUT') NOT NULL DEFAULT 'INCOME' COMMENT '收入-支出',
  `points_en_code` varchar(30) NOT NULL COMMENT '积分执行类型编码',
  `additional_number` varchar(255) DEFAULT NULL COMMENT '1.积分换购礼品时的订单号；2.积分换购优惠券时的券号',
  `message` varchar(50) NOT NULL COMMENT '积分加减说明',
  `points` int(11) NOT NULL COMMENT '加减的积分，含正负号',
  `created_at` datetime NOT NULL COMMENT '积分创建时间',
  `effected_at` datetime DEFAULT NULL COMMENT '积分生效时间',
  `deadline_at` datetime DEFAULT NULL COMMENT '积分过期时间',
  `status` enum('FROZEN','EFFECTIVE','INVALID') NOT NULL DEFAULT 'FROZEN' COMMENT 'FROZEN：冻结中；EFFECTIVE：生效；INVALID：失效(交易被取消，非积分过期，该状态的记录不被作为计算总积分的凭据)；',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unqiue_user_id_additional_number_points_en_code` (`user_id`,`additional_number`,`points_en_code`)
) ENGINE=InnoDB AUTO_INCREMENT=348 DEFAULT CHARSET=utf8 COMMENT='用户猫粮积分';

#
# Structure for table "m2_wechat_activity"
#

CREATE TABLE `m2_wechat_activity` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '活动标题',
  `description` text COMMENT '活动描述',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '活动类型',
  `link` varchar(100) NOT NULL DEFAULT '' COMMENT '对应的链接地址',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '对应的活动作品集',
  `cteated_at` datetime DEFAULT NULL COMMENT '创建时间',
  `created_admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建管理员',
  `created_name` varchar(15) NOT NULL DEFAULT '' COMMENT '创建管理员的名字',
  PRIMARY KEY (`id`),
  KEY `title_type` (`title`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信推广活动表';

#
# Structure for table "m2_wechat_check"
#

CREATE TABLE `m2_wechat_check` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL COMMENT '用户的标识，对当前公众号唯一',
  `check_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '签到时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信签到功能管理';

#
# Structure for table "m2_wechat_check_log"
#

CREATE TABLE `m2_wechat_check_log` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL COMMENT '用户的标识，对当前公众号唯一',
  `check_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '签到时间',
  `check_count` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户签到天数',
  `check_coupon` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户领取优惠劵标识10,20,30,50',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '派发优惠券ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信签到功能管理日志';

#
# Structure for table "m2_wechat_check_statistics"
#

CREATE TABLE `m2_wechat_check_statistics` (
  `id` int(11) NOT NULL DEFAULT '0',
  `check_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '签到时间',
  `user_count` int(11) NOT NULL DEFAULT '0' COMMENT '当天签到人数',
  `coupon_count` int(11) NOT NULL DEFAULT '0' COMMENT '当天领卷人数',
  `coupon_yi` int(11) NOT NULL DEFAULT '0' COMMENT '当天领10元现金卷人数',
  `coupon_er` int(11) NOT NULL DEFAULT '0' COMMENT '当天领20元现金卷人数',
  `coupon_san` int(11) NOT NULL DEFAULT '0' COMMENT '当天领30元现金卷人数',
  `coupon_wu` int(11) NOT NULL DEFAULT '0' COMMENT '当天领50元现金卷人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信签到功能每日统计';

#
# Structure for table "m2_wechat_code"
#

CREATE TABLE `m2_wechat_code` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL COMMENT '渠道名称',
  `keyword` varchar(200) NOT NULL COMMENT '关键词触发',
  `use_count` int(11) NOT NULL DEFAULT '0' COMMENT '渠道使用量',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否使用',
  `code_url` varchar(512) NOT NULL DEFAULT '0' COMMENT '二维码地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信渠道二维码管理';

#
# Structure for table "m2_wechat_coupon_bulk"
#

CREATE TABLE `m2_wechat_coupon_bulk` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '微信对应的openid',
  `ticket` varchar(100) NOT NULL DEFAULT '' COMMENT '带参数的二维码的Ticket',
  `coupon` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送优惠券，0未发送，1为已发送',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购优惠券微信记录';

#
# Structure for table "m2_wechat_coupon_bulk_activity"
#

CREATE TABLE `m2_wechat_coupon_bulk_activity` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '微信对应的openid',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '派送类型',
  `coupon` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送优惠券，0未发送，1为已发送',
  `created_at` datetime DEFAULT NULL COMMENT '扫描时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='柚子舍优惠券微信记录';

#
# Structure for table "m2_wechat_coupon_bulk_qrcode"
#

CREATE TABLE `m2_wechat_coupon_bulk_qrcode` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '微信对应的openid',
  `ticket` varchar(100) NOT NULL DEFAULT '' COMMENT '带参数的二维码的Ticket',
  `coupon` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送优惠券，0未发送，1为已发送',
  `created_at` datetime DEFAULT NULL COMMENT '扫描时间',
  `type` varchar(21) NOT NULL DEFAULT '' COMMENT '二维码类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='柚子舍优惠券微信记录';

#
# Structure for table "m2_wechat_data_statistics"
#

CREATE TABLE `m2_wechat_data_statistics` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `page_number` smallint(5) unsigned DEFAULT NULL COMMENT '记录活动首页的访问数',
  `participants
_num` smallint(5) unsigned DEFAULT NULL COMMENT '活动参与者数量',
  `draw_button_num` smallint(5) unsigned DEFAULT NULL COMMENT '统计抽奖按钮次数',
  `help_button_num` smallint(5) unsigned DEFAULT NULL COMMENT '统计求助好友按钮次数',
  `show_datail_num` smallint(5) unsigned DEFAULT NULL COMMENT '统计查看详情按钮点击数',
  `yuyue_button_num` smallint(5) unsigned DEFAULT NULL COMMENT '统计立即预约按钮点击数',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='睫毛弯弯活动数据统计表';

#
# Structure for table "m2_wechat_follower"
#

CREATE TABLE `m2_wechat_follower` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(50) DEFAULT NULL COMMENT 'OPENID',
  `uid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_openId` (`openid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='关注微信用户';

#
# Structure for table "m2_wechat_friend_card"
#

CREATE TABLE `m2_wechat_friend_card` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fxopenid` varchar(35) NOT NULL DEFAULT '0' COMMENT '分享者的openid',
  `hyopenid` varchar(35) NOT NULL DEFAULT '0' COMMENT '好友的openid',
  `friend_nickname` varchar(25) DEFAULT NULL COMMENT '好友的昵称',
  `friend_headimgurl` varchar(250) DEFAULT NULL COMMENT '好友的图像',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='好友帮助分享者抽取卡片的记录信息表';

#
# Structure for table "m2_wechat_keymenu"
#

CREATE TABLE `m2_wechat_keymenu` (
  `id` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(100) NOT NULL COMMENT '触发事件标识',
  `describe` varchar(100) NOT NULL COMMENT '事件描述',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型1,文本2,图文3,链接',
  `content` text COMMENT '文本回复内容',
  `title` varchar(100) DEFAULT '0' COMMENT '图文标题',
  `summary` varchar(1024) DEFAULT '0' COMMENT '图文摘要',
  `url` varchar(200) DEFAULT '0' COMMENT '图文连接',
  `img_url` varchar(1024) DEFAULT '0' COMMENT '图片链接',
  `sort` int(4) DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(4) DEFAULT '1' COMMENT '是否隐藏此banner',
  `img_id` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信菜单事件触发管理';

#
# Structure for table "m2_wechat_keyword"
#

CREATE TABLE `m2_wechat_keyword` (
  `id` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(100) NOT NULL COMMENT '关键字触发',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型1,文本2,图文',
  `content` text COMMENT '文本回复内容',
  `title` varchar(100) DEFAULT '0' COMMENT '图文标题',
  `summary` varchar(1024) DEFAULT '0' COMMENT '图文摘要',
  `url` varchar(200) DEFAULT '0' COMMENT '图文连接',
  `img_url` varchar(1024) DEFAULT '0' COMMENT '图片链接',
  `sort` int(4) DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(4) DEFAULT '1' COMMENT '是否隐藏此banner',
  `img_id` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信关键字触发管理';

#
# Structure for table "m2_wechat_lucky_draw_card"
#

CREATE TABLE `m2_wechat_lucky_draw_card` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(35) DEFAULT NULL COMMENT '微信openid',
  `card_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '卡片类型 1 2 3 4 5 6代表6种类型的卡片',
  `num` tinyint(3) unsigned DEFAULT NULL COMMENT '该用户拥有该类型卡片的数量',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='睫毛弯弯用户拥有卡片表';

#
# Structure for table "m2_wechat_mei"
#

CREATE TABLE `m2_wechat_mei` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL COMMENT '用户的标识，对当前公众号唯一',
  `type` varchar(100) NOT NULL DEFAULT '0数据类型',
  `skintype` varchar(100) NOT NULL DEFAULT '0皮肤类型',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='美丽真相数据管理';

#
# Structure for table "m2_wechat_menu"
#

CREATE TABLE `m2_wechat_menu` (
  `id` tinyint(4) NOT NULL DEFAULT '0',
  `content` text NOT NULL COMMENT '菜单数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信自定义菜单';

#
# Structure for table "m2_wechat_parameter"
#

CREATE TABLE `m2_wechat_parameter` (
  `id` int(11) NOT NULL DEFAULT '0',
  `app_id` varchar(255) DEFAULT '0' COMMENT 'AppId',
  `app_secret` varchar(255) DEFAULT '0' COMMENT 'AppSecret',
  `encoding_aeskey` varchar(255) DEFAULT '0' COMMENT 'EncodingAESKey',
  `token` varchar(255) DEFAULT '0' COMMENT 'Token',
  `api_url` varchar(255) DEFAULT NULL COMMENT 'API接口url',
  `api_token` varchar(255) DEFAULT NULL COMMENT 'API验证TOKEN',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `creater` varchar(50) DEFAULT NULL COMMENT '创建人',
  `modifier` varchar(50) DEFAULT NULL COMMENT '修改人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信参数设置';

#
# Structure for table "m2_wechat_qrcode"
#

CREATE TABLE `m2_wechat_qrcode` (
  `id` int(11) NOT NULL DEFAULT '0',
  `ticket` varchar(100) NOT NULL DEFAULT '' COMMENT '带参数的二维码的值',
  `scanning` int(11) NOT NULL DEFAULT '0' COMMENT '扫描次数',
  `scanning_time` datetime DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(21) NOT NULL DEFAULT '' COMMENT '二维码类型',
  `is_online` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否上线,1上线2下线',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '涉及的优惠券id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket` (`ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='带二维码参数的记录表';

#
# Structure for table "m2_wechat_user"
#

CREATE TABLE `m2_wechat_user` (
  `id` int(11) NOT NULL DEFAULT '0',
  `subscribe` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号标识，0未关注，1关注',
  `openid` varchar(100) NOT NULL COMMENT '用户的标识，对当前公众号唯一',
  `source` int(11) NOT NULL DEFAULT '0' COMMENT '来源',
  `nickname` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户的昵称',
  `remark` varchar(30) DEFAULT '' COMMENT '微信用户备注名',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户的性别，1男性，2女性，0未知',
  `city` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户所在城市',
  `country` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户所在国家',
  `province` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户所在省份',
  `languages` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户的语言，简体中文为zh_CN',
  `headimgurl` varchar(512) NOT NULL DEFAULT '0' COMMENT '用户头像URL',
  `subscribe_time` int(11) NOT NULL DEFAULT '0' COMMENT '用户关注时间',
  `end_time` varchar(15) NOT NULL DEFAULT '0' COMMENT '用户最后交互时间',
  `mall_uid` int(11) NOT NULL DEFAULT '0' COMMENT '商城用户ID,0非商城用户',
  `mall_vip` tinyint(4) NOT NULL DEFAULT '0' COMMENT '记录是否为商城用户，用户商城会员等级，0非商城会员',
  `subscribe_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户首次关注时间记录',
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户最后触发事件时间记录',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户管理';

#
# Structure for table "m2_wechat_user_info"
#

CREATE TABLE `m2_wechat_user_info` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `unionid` varchar(255) DEFAULT NULL COMMENT '微信号',
  `openid` varchar(35) NOT NULL DEFAULT '0' COMMENT '微信openid',
  `nickname` varchar(20) DEFAULT NULL COMMENT '微信昵称',
  `headimgurl` varchar(150) DEFAULT NULL COMMENT '用户图像',
  `lottery_number` tinyint(3) unsigned DEFAULT NULL COMMENT '用户剩余抽奖次数',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `is_date` date DEFAULT NULL COMMENT '记录每天首次访问页面的年月日',
  `type` tinyint(3) unsigned DEFAULT NULL COMMENT '1为有美字  2为有睫字',
  `uid` int(11) unsigned DEFAULT NULL COMMENT '关联用户表id',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='睫毛弯弯用户信息表';

#
# Structure for table "m2_wehcat_recharge"
#

CREATE TABLE `m2_wehcat_recharge` (
  `id` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '微信对应的openid',
  `is_recharge` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否充值,1没充值2以充值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信充值余额活动表';

#
# Structure for table "m2_ws_examinee_temp"
#

CREATE TABLE `m2_ws_examinee_temp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) DEFAULT '' COMMENT '名字',
  `jid` int(10) unsigned DEFAULT '0' COMMENT '评委ID/小组ID',
  `img_url` varchar(100) DEFAULT '' COMMENT '用户头像',
  `tool_score` int(3) DEFAULT '0' COMMENT '工具成绩',
  `health_score` int(3) DEFAULT '0' COMMENT '卫生成绩',
  `process_score` int(3) DEFAULT '0' COMMENT '流程规范成绩',
  `skill_score` int(3) DEFAULT '0' COMMENT '专业技术成绩',
  `is_exam` int(2) DEFAULT '0' COMMENT '考试状态：0->没考试;1->已考试',
  `start_at` datetime DEFAULT NULL COMMENT '考试开始时间',
  `finish_at` datetime DEFAULT NULL COMMENT '考试结束时间',
  `create_at` datetime DEFAULT NULL COMMENT '登记时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='考生表';

#
# Structure for table "m2_ws_judges_temp"
#

CREATE TABLE `m2_ws_judges_temp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) DEFAULT '' COMMENT '名字',
  `sum` int(10) DEFAULT '0' COMMENT '考生总数',
  `finish_num` int(10) DEFAULT '0' COMMENT '考试结束人数',
  `start_at` datetime DEFAULT NULL COMMENT '考试开始时间',
  `exam_status` int(2) DEFAULT '0' COMMENT '考试状态：0->没考试;1->考试中;2->考试结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评委表';

#
# View "m2_stylist_view"
#

CREATE
  ALGORITHM = UNDEFINED
  VIEW `m2_stylist_view`
  AS
SELECT
  t.`id`,
  s.`server_city`,
  s.`server_street`,
  t.`street_id`,
  t.`num_orders_extra`,
  t.`type`,
  t.`real_name`,
  t.`nick`,
  t.`age`,
  t.`sex`,
  t.`email`,
  t.`mobile`,
  t.`user_img`,
  t.`work_years`,
  t.`history_orders`,
  t.`intro`,
  t.`province_id`,
  t.`city_id`,
  t.`area_id`,
  t.`address`,
  t.`idcard`,
  t.`longitude`,
  t.`latitude`,
  t.`level`,
  t.`photo`,
  t.`stylist_balance`,
  t.`status`,
  t.`start_time`,
  t.`end_time`,
  t.`is_online`,
  t.`is_check`,
  t.`created_at`,
  s.`product_id` AS 'products'
FROM
  (`m2_stylist` t
    LEFT JOIN `m2_stylist_ser` s ON ((t.`id` = s.`stylist_id`)));
