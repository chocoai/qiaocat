define({ "api": [
  {
    "type": "post",
    "url": "dresser/dr_get_balance",
    "title": "店铺账户流水[dresser/dr_get_balance]",
    "version": "2.0.0",
    "name": "dr_get_balance",
    "group": "dresser_Account",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_get_balance"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "datetime",
            "optional": false,
            "field": "s_time",
            "description": "<p>开始时间</p>"
          },
          {
            "group": "Parameter",
            "type": "datetime",
            "optional": false,
            "field": "e_time",
            "description": "<p>结束时间</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Account.php",
    "groupTitle": "dresser_Account"
  },
  {
    "type": "post",
    "url": "dresser/dr_ment_index",
    "title": "美业师评价管理[dresser/dr_ment_index]",
    "version": "2.0.0",
    "name": "dr_ment_index",
    "group": "dresser_Comment",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_ment_index"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>0全部，1好评，2中评，3差评，4有图</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Comment.php",
    "groupTitle": "dresser_Comment"
  },
  {
    "type": "post",
    "url": "dresser/dr_ment_reply",
    "title": "美业师回复评价[dresser/dr_ment_reply]",
    "version": "2.0.0",
    "name": "dr_ment_reply",
    "group": "dresser_Comment",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_ment_reply"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "parent_id",
            "description": "<p>顶级评论的id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "comment",
            "description": "<p>回复内容</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Comment.php",
    "groupTitle": "dresser_Comment"
  },
  {
    "type": "post",
    "url": "dresser/dr_coupon_index",
    "title": "优惠券管理[dresser/dr_coupon_index]",
    "version": "2.0.0",
    "name": "dr_coupon_index",
    "group": "dresser_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_coupon_index"
      }
    ],
    "filename": "application/dresser/controller/Coupon.php",
    "groupTitle": "dresser_Coupon"
  },
  {
    "type": "post",
    "url": "dresser/dr_coupon_onoff",
    "title": "优惠券开启暂停[dresser/dr_coupon_onoff]",
    "version": "2.0.0",
    "name": "dr_coupon_onoff",
    "group": "dresser_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_coupon_onoff"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>优惠券id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>开启传1 暂停传0</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Coupon.php",
    "groupTitle": "dresser_Coupon"
  },
  {
    "type": "post",
    "url": "dresser/dr_set_coupon",
    "title": "美业师创建优惠券[dresser/dr_set_coupon]",
    "version": "2.0.0",
    "name": "dr_set_coupon",
    "group": "dresser_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_set_coupon"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "coupon_value",
            "description": "<p>服务项目id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "coupon_type",
            "description": "<p>优惠券类型(1直减，2满减)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "base_amount",
            "description": "<p>最低满多少元</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "coupon_amount",
            "description": "<p>优惠券面额</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "start_time",
            "description": "<p>有效开始时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "end_time",
            "description": "<p>有效结束时间</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "total_count",
            "description": "<p>发行张数</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Coupon.php",
    "groupTitle": "dresser_Coupon"
  },
  {
    "type": "post",
    "url": "dresser/dr_confirm_order",
    "title": "美业师确认抢单[dresser/dr_confirm_order]",
    "version": "2.0.0",
    "name": "dr_confirm_order",
    "group": "dresser_Home",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_confirm_order"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>订单主键id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Home.php",
    "groupTitle": "dresser_Home"
  },
  {
    "type": "post",
    "url": "dresser/dr_rob_order",
    "title": "美业师抢单首页[dresser/dr_rob_order]",
    "version": "2.0.0",
    "name": "dr_rob_order",
    "group": "dresser_Home",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_rob_order"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Home.php",
    "groupTitle": "dresser_Home"
  },
  {
    "type": "post",
    "url": "dresser/dr_add_data",
    "title": "美业师完善资料[dresser/dr_add_data]",
    "version": "2.0.0",
    "name": "dr_add_data",
    "group": "dresser_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_add_data"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user_img",
            "description": "<p>头像</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nick",
            "description": "<p>昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>性别</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "skill_type",
            "description": "<p>技术类型</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user_good",
            "description": "<p>擅长</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "WeChat_id",
            "description": "<p>微信号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "where_add",
            "description": "<p>所在城市</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Login.php",
    "groupTitle": "dresser_Login"
  },
  {
    "type": "post",
    "url": "dresser/dr_agency_store",
    "title": "美业师申请机构店铺[dresser/dr_agency_store]",
    "version": "2.0.0",
    "name": "dr_agency_store",
    "group": "dresser_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_agency_store"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_name",
            "description": "<p>店铺名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "license",
            "description": "<p>营业执照</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "real_name",
            "description": "<p>真实姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "alipay",
            "description": "<p>支付宝账号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idcard",
            "description": "<p>法人代表身份证号码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idcard_img",
            "description": "<p>法人代表身份证</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "plastic",
            "description": "<p>是否开整形类手术，1开，0不开</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "doctor_licence",
            "description": "<p>医疗卫生执业许可证</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "province_id",
            "description": "<p>省份</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "area_id",
            "description": "<p>区，（有就发没有就不发）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "aptitude",
            "description": "<p>机构资质</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_add",
            "description": "<p>机构地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "intro",
            "description": "<p>机构介绍</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "photo",
            "description": "<p>作品图片</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "autograph_img",
            "description": "<p>客户签名</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Login.php",
    "groupTitle": "dresser_Login"
  },
  {
    "type": "post",
    "url": "dresser/dr_user_store",
    "title": "美业师申请个人店铺[dresser/dr_user_store]",
    "version": "2.0.0",
    "name": "dr_user_store",
    "group": "dresser_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_user_store"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_name",
            "description": "<p>店铺名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "real_name",
            "description": "<p>真实姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "alipay",
            "description": "<p>支付宝账号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idcard",
            "description": "<p>个人身份证号码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idcard_hand",
            "description": "<p>手持身份证图片</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idcard_img",
            "description": "<p>身份证图片</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "agency",
            "description": "<p>所属美容机构(无机构传0)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "certificate",
            "description": "<p>认证证书</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "ccc",
            "description": "<p>发证机构</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "province_id",
            "description": "<p>省份</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "area_id",
            "description": "<p>区，（有就发没有就不发）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "up_store",
            "description": "<p>是否提供顾客到店服务0不提供，1提供</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_add",
            "description": "<p>实体店地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "work_years",
            "description": "<p>工作起始年限</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "intro",
            "description": "<p>个人介绍</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "photo",
            "description": "<p>作品图片</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "autograph_img",
            "description": "<p>客户签名</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Login.php",
    "groupTitle": "dresser_Login"
  },
  {
    "type": "post",
    "url": "dresser/dr_order_news",
    "title": "订单消息[dresser/dr_order_news]",
    "version": "2.0.0",
    "name": "dr_order_news",
    "group": "dresser_News",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_order_news"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/News.php",
    "groupTitle": "dresser_News"
  },
  {
    "type": "post",
    "url": "dresser/dr_cancel_order",
    "title": "美业师拒绝订单[dresser/dr_cancel_order",
    "version": "2.0.0",
    "name": "dr_cancel_order",
    "group": "dresser_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_cancel_order"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Order.php",
    "groupTitle": "dresser_Order"
  },
  {
    "type": "post",
    "url": "dresser/dr_make_sure_order",
    "title": "美业师接单[dresser/dr_make_sure_order",
    "version": "2.0.0",
    "name": "dr_make_sure_order",
    "group": "dresser_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_make_sure_order"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Order.php",
    "groupTitle": "dresser_Order"
  },
  {
    "type": "post",
    "url": "dresser/dr_order_detail",
    "title": "订单详情[dresser/dr_order_detail",
    "version": "2.0.0",
    "name": "dr_order_detail",
    "group": "dresser_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_order_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Order.php",
    "groupTitle": "dresser_Order"
  },
  {
    "type": "post",
    "url": "dresser/dr_order_status",
    "title": "查询各种订单状态列表[dresser/dr_order_status",
    "version": "2.0.0",
    "name": "dr_order_status",
    "group": "dresser_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_order_status"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_type",
            "description": "<p>订单的状态类型  2待确定 3待服务 4进行中  all所有的</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Order.php",
    "groupTitle": "dresser_Order"
  },
  {
    "type": "post",
    "url": "dresser/dr_Standardized_service",
    "title": "查询俏猫标准化服务[dresser/dr_Standardized_service]",
    "version": "2.0.0",
    "name": "dr_Standardized_service",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_Standardized_service"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "parent_id",
            "description": "<p>一级分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "son_id",
            "description": "<p>二级分类id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_add_Standardized_service",
    "title": "添加俏猫标准化服务[dresser/dr_add_Standardized_service]",
    "version": "2.0.0",
    "name": "dr_add_Standardized_service",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_add_Standardized_service"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "service_arr",
            "description": "<p>美业师选择的服务的id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_adds_service",
    "title": "添加个性化服务[dresser/dr_adds_service]",
    "version": "2.0.0",
    "name": "dr_adds_service",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_adds_service"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_type",
            "description": "<p>该字段判断是保存服务，还是添加服务;保存就传11过来，添加不用传该值</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cate_id",
            "description": "<p>一级分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cate_id_2",
            "description": "<p>二级分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "pic_path",
            "description": "<p>服务主图片的路径</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "thumb",
            "description": "<p>缩略图地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "service_form",
            "description": "<p>服务形式</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>服务名称</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "duration",
            "description": "<p>耗时</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "market_price",
            "description": "<p>市场价</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "price",
            "description": "<p>当美业师添加个性化服务时，不选择预定金服务，该字段就是会员价格，当选择预定金服务时，就是预定金价格</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "circumstances_service",
            "description": "<p>是否拥有预定金服务 1否 2是</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "shop_price",
            "description": "<p>到店付价格  选择预定金服务才存在</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>图文详情</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_btg_del",
    "title": "删除服务接口[dresser/dr_btg_del]",
    "version": "2.0.0",
    "name": "dr_btg_del",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_btg_del"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_id",
            "description": "<p>删除的服务id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_service_list",
    "title": "服务列表的接口[dresser/dr_service_list]",
    "version": "2.0.0",
    "name": "dr_service_list",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_service_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_type",
            "description": "<p>服务列表数据  all代表所有数据 1已上架 2待审核 3不通过 4以保存 0已下架</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_service_shangjia",
    "title": "上架服务接口[dresser/dr_service_shangjia]",
    "version": "2.0.0",
    "name": "dr_service_shangjia",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_service_shangjia"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_id",
            "description": "<p>上架的服务id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_service_shelves",
    "title": "提交审核服务接口[dresser/dr_service_shelves]",
    "version": "2.0.0",
    "name": "dr_service_shelves",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_service_shelves"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_id",
            "description": "<p>上架的服务id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_show_ky_service",
    "title": "查询服务一二级分类[dresser/dr_show_ky_service",
    "version": "2.0.0",
    "name": "dr_show_ky_service",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_show_ky_service"
      }
    ],
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_show_service_class",
    "title": "查询服务一二级分类[dresser/dr_show_service_class",
    "version": "2.0.0",
    "name": "dr_show_service_class",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_show_service_class"
      }
    ],
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_type_auth",
    "title": "服务权限接口[dresser/dr_type_auth]",
    "version": "2.0.0",
    "name": "dr_type_auth",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_type_auth"
      }
    ],
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_ysj_edit",
    "title": "点击'修改'与'详情'的数据[dresser/dr_ysj_edit]",
    "version": "2.0.0",
    "name": "dr_ysj_edit",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_ysj_edit"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_id",
            "description": "<p>修改，详情的服务id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_ysj_qxsh",
    "title": "取消审核接口[dresser/dr_ysj_qxsh]",
    "version": "2.0.0",
    "name": "dr_ysj_qxsh",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_ysj_qxsh"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_id",
            "description": "<p>修改的服务id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_ysj_shelves",
    "title": "下架接口[dresser/dr_ysj_shelves]",
    "version": "2.0.0",
    "name": "dr_ysj_shelves",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_ysj_shelves"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_id",
            "description": "<p>修改的服务id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_ysj_tj",
    "title": "服务列表提交,保存接口[dresser/dr_ysj_tj]",
    "version": "2.0.0",
    "name": "dr_ysj_tj",
    "group": "dresser_Service",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_ysj_tj"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_type",
            "description": "<p>该字段判断是保存服务，还是添加服务;保存就传11过来，添加不用传该值</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>修改的服务id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cate_id",
            "description": "<p>一级分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cate_id_2",
            "description": "<p>二级分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "pic_path",
            "description": "<p>服务主图片的路径</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "new_pic_path",
            "description": "<p>服务详情图片的路径</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "service_form",
            "description": "<p>服务形式</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>服务名称</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "duration",
            "description": "<p>耗时</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "market_price",
            "description": "<p>市场价</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "price",
            "description": "<p>当美业师添加个性化服务时，不选择预定金服务，该字段就是会员价格，当选择预定金服务时，就是预定金价格</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "circumstances_service",
            "description": "<p>是否选择预定金服务 1否 2是</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "shop_price",
            "description": "<p>到店付价格  选择预定金服务才存在</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>图文详情</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/Service.php",
    "groupTitle": "dresser_Service"
  },
  {
    "type": "post",
    "url": "dresser/dr_data",
    "title": "全局统一返回美业师信息[dresser/dr_data]",
    "version": "2.0.0",
    "name": "dr_data",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_data"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "is_check",
            "description": "<p>返回状态  1代表已审核，跳到店铺首页或其他首页，2代表待审核，跳到查看进度， 3为审核不通过，跳到查看进度，给重新完善资料入口，4已完善资料未申请店铺 5新用户未完善资料</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>美业师id</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>技术类型</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "real_name",
            "description": "<p>美业师真实姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>美业师性别   1男2女</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "store_type",
            "description": "<p>1为个人店铺，2为机构店铺</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "is_business",
            "description": "<p>1不营业，2营业</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "is_online",
            "description": "<p>1不在线，2在线</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "up_store",
            "description": "<p>0不提供，1提供</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_edit_info",
    "title": "美业师个人资料修改[dresser/dr_edit_info]",
    "version": "2.0.0",
    "name": "dr_edit_info",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_edit_info"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user_img",
            "description": "<p>头像</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nick",
            "description": "<p>昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>性别</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user_good",
            "description": "<p>擅长</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "wechat_no",
            "description": "<p>微信号</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_edit_store",
    "title": "美业师店铺设置[dresser/dr_edit_store]",
    "version": "2.0.0",
    "name": "dr_edit_store",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_edit_store"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_name",
            "description": "<p>店铺名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "intro",
            "description": "<p>店铺介绍</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "advance",
            "description": "<p>提前预约(暂时不传)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "business_start",
            "description": "<p>营业开始时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "business_end",
            "description": "<p>营业结束时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "business_week",
            "description": "<p>营业工作日  1,2,3  这种形式传入</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "province_id",
            "description": "<p>省份</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "area_id",
            "description": "<p>区，（有就发没有就不发）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "street_id",
            "description": "<p>服务范围商圈id 用,号分开</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "agency",
            "description": "<p>所属美容机构的id(个人店铺可以选，本身为机构店铺不显示这项也不传)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "up_store",
            "description": "<p>是否提供到店服务 0否 1是</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_add",
            "description": "<p>实体店地址</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_get_apply",
    "title": "美业师重新申请获取之前输入的信息[dresser/dr_get_apply]",
    "version": "2.0.0",
    "name": "dr_get_apply",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_get_apply"
      }
    ],
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_get_busy",
    "title": "获取忙时时间[dresser/dr_get_busy]",
    "version": "2.0.0",
    "name": "dr_get_busy",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_get_busy"
      }
    ],
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_get_fans",
    "title": "美业师获取粉丝列表[dresser/dr_get_fans]",
    "version": "2.0.0",
    "name": "dr_get_fans",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_get_fans"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_get_invitation",
    "title": "我邀请的[dresser/dr_get_invitation]",
    "version": "2.0.0",
    "name": "dr_get_invitation",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_get_invitation"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>查全部不传，查签约用户传2，查注册用户传1</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_get_qrcode",
    "title": "我的二维码[dresser/dr_get_qrcode]",
    "version": "2.0.0",
    "name": "dr_get_qrcode",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_get_qrcode"
      }
    ],
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_schedule",
    "title": "美业师申请进度[dresser/dr_schedule]",
    "version": "2.0.0",
    "name": "dr_schedule",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_schedule"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user_time",
            "description": "<p>注册时间</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "created_at",
            "description": "<p>完善资料时间</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "updated_at",
            "description": "<p>申请店铺时间</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "is_check",
            "description": "<p>申请状态</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "reason",
            "description": "<p>审核返回的信息</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_set_business",
    "title": "设置店铺营业暂停[dresser/dr_set_business]",
    "version": "2.0.0",
    "name": "dr_set_business",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_set_business"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "is_business",
            "description": "<p>传 1暂停   2营业</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_set_busy",
    "title": "美业师忙时设置[dresser/dr_set_busy]",
    "version": "2.0.0",
    "name": "dr_set_busy",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_set_busy"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "busy",
            "description": "<p>忙时时间</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_set_skill_type",
    "title": "修改美业师技术类型[dresser/dr_set_skill_type]",
    "version": "2.0.0",
    "name": "dr_set_skill_type",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_set_skill_type"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>技术类型，多个用','分开</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_share_info",
    "title": "二维码分享获取美业师信息[dresser/dr_share_info]",
    "version": "2.0.0",
    "name": "dr_share_info",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_share_info"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>美业师id</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_store_index",
    "title": "店铺首页[dresser/dr_store_index]",
    "version": "2.0.0",
    "name": "dr_store_index",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_store_index"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "is_business",
            "description": "<p>返回状态  1暂停，2营业</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>返回状态  美业师id</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "real_name",
            "description": "<p>美业师真实姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>美业师性别 1为男 2为女</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user_img",
            "description": "<p>美业师头像</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "work_years",
            "description": "<p>美业师工作开始年限</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "level",
            "description": "<p>返回状态 美业师等级</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "store_type",
            "description": "<p>返回状态  1个人店铺，2机构店铺</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "order_sum",
            "description": "<p>接单数</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "order_rate",
            "description": "<p>接单率</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "fans",
            "description": "<p>美业师关注数</p>"
          }
        ]
      }
    },
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_user_index",
    "title": "美业师店铺设置页[dresser/dr_user_index]",
    "version": "2.0.0",
    "name": "dr_user_index",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_user_index"
      }
    ],
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "dresser/dr_user_info",
    "title": "美业师个人资料[dresser/dr_user_info]",
    "version": "2.0.0",
    "name": "dr_user_info",
    "group": "dresser_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/dresser/dr_user_info"
      }
    ],
    "filename": "application/dresser/controller/User.php",
    "groupTitle": "dresser_User"
  },
  {
    "type": "post",
    "url": "mon/mon_city_street",
    "title": "城市商圈[mon/mon_city_street]",
    "version": "2.0.0",
    "name": "mon_city_street",
    "group": "mon_City",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_city_street"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>城市id</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/City.php",
    "groupTitle": "mon_City"
  },
  {
    "type": "post",
    "url": "mon/mon_get_support_info",
    "title": "获取省市详情[mon/mon_get_support_info]",
    "version": "2.0.0",
    "name": "mon_get_support_info",
    "group": "mon_City",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_support_info"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "province_id",
            "description": "<p>选填 省id</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/City.php",
    "groupTitle": "mon_City"
  },
  {
    "type": "post",
    "url": "mon/mon_service_cities",
    "title": "获取市[mon/mon_service_cities]",
    "version": "2.0.0",
    "name": "mon_service_cities",
    "group": "mon_City",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_service_cities"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "online",
            "description": "<p>开通城市  选填 0不限 1开通</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>经度</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>纬度</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/City.php",
    "groupTitle": "mon_City"
  },
  {
    "type": "post",
    "url": "mon/mon_get_agency",
    "title": "获取机构店铺[mon/mon_get_agency]",
    "version": "2.0.0",
    "name": "mon_get_agency",
    "group": "mon_GetInfo",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_agency"
      }
    ],
    "filename": "application/mon/controller/GetInfo.php",
    "groupTitle": "mon_GetInfo"
  },
  {
    "type": "post",
    "url": "mon/mon_get_area",
    "title": "获取区[mon/mon_get_area]",
    "version": "2.0.0",
    "name": "mon_get_area",
    "group": "mon_GetInfo",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_area"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市id</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/GetInfo.php",
    "groupTitle": "mon_GetInfo"
  },
  {
    "type": "post",
    "url": "mon/mon_get_city",
    "title": "获取城市[mon/mon_get_city]",
    "version": "2.0.0",
    "name": "mon_get_city",
    "group": "mon_GetInfo",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_city"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "province_id",
            "description": "<p>省份id</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/GetInfo.php",
    "groupTitle": "mon_GetInfo"
  },
  {
    "type": "post",
    "url": "mon/mon_get_province",
    "title": "获取省份[mon/mon_get_province]",
    "version": "2.0.0",
    "name": "mon_get_province",
    "group": "mon_GetInfo",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_province"
      }
    ],
    "filename": "application/mon/controller/GetInfo.php",
    "groupTitle": "mon_GetInfo"
  },
  {
    "type": "post",
    "url": "mon/mon_get_street",
    "title": "获取商圈[mon/mon_get_street]",
    "version": "2.0.0",
    "name": "mon_get_street",
    "group": "mon_GetInfo",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_street"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "add_id",
            "description": "<p>城市id或区id</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/GetInfo.php",
    "groupTitle": "mon_GetInfo"
  },
  {
    "type": "post",
    "url": "mon/mon_get_type",
    "title": "获取美业师类型[mon/mon_get_type]",
    "version": "2.0.0",
    "name": "mon_get_type",
    "group": "mon_GetInfo",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_get_type"
      }
    ],
    "filename": "application/mon/controller/GetInfo.php",
    "groupTitle": "mon_GetInfo"
  },
  {
    "type": "post",
    "url": "mon/mon_forget_pass",
    "title": "忘记密码(或修改密码)[mon/mon_forget_pass]",
    "version": "2.0.0",
    "name": "mon_forget_pass",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_forget_pass"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "pass_1",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "pass_2",
            "description": "<p>确认密码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_logout",
    "title": "公共退出登录[mon/mon_logout]",
    "version": "2.0.0",
    "name": "mon_logout",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_logout"
      }
    ],
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_pass_login",
    "title": "密码登录[mon/mon_pass_login]",
    "version": "2.0.0",
    "name": "mon_pass_login",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_pass_login"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_pass_reg",
    "title": "密码注册[mon/mon_pass_reg]",
    "version": "2.0.0",
    "name": "mon_pass_reg",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_pass_reg"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "from",
            "description": "<p>渠道来源  (来源是推广或分享必须传此项)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "inviter_id",
            "description": "<p>邀请者id (来源是推广或分享必须传此项)</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_quick_login",
    "title": "快捷登录接口[mon/mon_quick_login]",
    "version": "2.0.0",
    "name": "mon_quick_login",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_quick_login"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "from",
            "description": "<p>渠道来源 (来源是推广或分享必须传此项)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "inviter_id",
            "description": "<p>邀请者id (来源是推广或分享必须传此项)</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_send",
    "title": "公共发验证码[mon/mon_send]",
    "version": "2.0.0",
    "name": "mon_send",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_send"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>不需要验证此手机号码是否为俏猫用户请传1，其他不传</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_set_deviceid",
    "title": "设置用户登录最新设备id[mon/mon_set_deviceid]",
    "version": "2.0.0",
    "name": "mon_set_deviceid",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_set_deviceid"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "uid",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "device_id",
            "description": "<p>设备id</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_yan_code",
    "title": "公共验证码验证[mon/mon_yan_code]",
    "version": "2.0.0",
    "name": "mon_yan_code",
    "group": "mon_Login",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_yan_code"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>不需要验证此手机号码是否为俏猫用户请传1，其他不传</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Login.php",
    "groupTitle": "mon_Login"
  },
  {
    "type": "post",
    "url": "mon/mon_app_uploads",
    "title": "APP端上传图片[mon/mon_app_uploads]",
    "version": "2.0.0",
    "name": "mon_app_uploads",
    "group": "mon_Upload",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_app_uploads"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "image",
            "description": "<p>图片</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Upload.php",
    "groupTitle": "mon_Upload"
  },
  {
    "type": "post",
    "url": "mon/mon_uploads",
    "title": "M站上传图片[mon/mon_uploads]",
    "version": "2.0.0",
    "name": "mon_uploads",
    "group": "mon_Upload",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_uploads"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "base64",
            "optional": false,
            "field": "image",
            "description": "<p>图片</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Upload.php",
    "groupTitle": "mon_Upload"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_address_list",
    "title": "获取用户地址列表[qiaomao/qm_user_address_list]",
    "version": "2.0.0",
    "name": "qm_user_address_list",
    "group": "qiaomao_Address",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_address_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "is_default",
            "description": "<p>选填 1默认0不是</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Address.php",
    "groupTitle": "qiaomao_Address"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_delete_address",
    "title": "删除用户地址[qiaomao/qm_user_delete_address]",
    "version": "2.0.0",
    "name": "qm_user_delete_address",
    "group": "qiaomao_Address",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_delete_address"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "addressId",
            "description": "<p>地址id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Address.php",
    "groupTitle": "qiaomao_Address"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_save_address",
    "title": "保存用户地址[qiaomao/qm_user_save_address]",
    "version": "2.0.0",
    "name": "qm_user_save_address",
    "group": "qiaomao_Address",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_save_address"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "data",
            "description": "<p>data数据: {&quot;address_id&quot;:0,&quot;consignee&quot;: &quot;ces&quot;, &quot;province&quot;: &quot;130000&quot;, &quot;city&quot;: &quot;130300&quot;, &quot;district&quot;: &quot;130302&quot;, &quot;mobile&quot;: &quot;15017580819&quot;,&quot;address&quot;:&quot;详细地址&quot;,&quot;is_default&quot;:0,&quot;street&quot;:&quot;BJ-DC-01&quot;}</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Address.php",
    "groupTitle": "qiaomao_Address"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_attention_add_attention",
    "title": "俏猫-增加美业师/店铺的关注[qiaomao/qm_attention_add_attention]",
    "version": "2.0.0",
    "name": "qm_attention_add_attention",
    "group": "qiaomao_Attention",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_attention_add_attention"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "stylistId",
            "description": "<p>美业师id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Attention.php",
    "groupTitle": "qiaomao_Attention"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_attention_cancel_attention",
    "title": "俏猫-取消美业师/店铺的关注[qiaomao/qm_attention_cancel_attention]",
    "version": "2.0.0",
    "name": "qm_attention_cancel_attention",
    "group": "qiaomao_Attention",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_attention_cancel_attention"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "stylistId",
            "description": "<p>美业师id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Attention.php",
    "groupTitle": "qiaomao_Attention"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_attention_get_attent",
    "title": "俏猫-得到用户所关注美业师/店铺的关注[qiaomao/qm_attention_get_attent]",
    "version": "2.0.0",
    "name": "qm_attention_get_attent",
    "group": "qiaomao_Attention",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_attention_get_attent"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Attention.php",
    "groupTitle": "qiaomao_Attention"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_coupon_center",
    "title": "俏猫-领券中心[qiaomao/qm_coupon_center]",
    "version": "2.0.0",
    "name": "qm_coupon_center",
    "group": "qiaomao_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_coupon_center"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "type",
            "description": "<p>类型 新人专属:1，化妆：2，美睫：3，纹绣：4，医美：5，培训：6</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Coupon.php",
    "groupTitle": "qiaomao_Coupon"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_coupon_fetch",
    "title": "俏猫-领取优惠券[qiaomao/qm_coupon_fetch]",
    "version": "2.0.0",
    "name": "qm_coupon_fetch",
    "group": "qiaomao_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_coupon_fetch"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "coupon_id",
            "description": "<p>优惠卷id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Coupon.php",
    "groupTitle": "qiaomao_Coupon"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_coupon_info",
    "title": "获取优惠券详情[qiaomao/qm_coupon_info]",
    "version": "2.0.0",
    "name": "qm_coupon_info",
    "group": "qiaomao_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_coupon_info"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "coupon_id",
            "description": "<p>优惠卷id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Coupon.php",
    "groupTitle": "qiaomao_Coupon"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_coupon_list",
    "title": "获取用户优惠券列表[qiaomao/qm_coupon_list]",
    "version": "2.0.0",
    "name": "qm_coupon_list",
    "group": "qiaomao_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_coupon_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "coupon_id",
            "description": "<p>优惠卷id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "status",
            "description": "<p>0未使用1已经使用2已过期3冻结中</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Coupon.php",
    "groupTitle": "qiaomao_Coupon"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_has_coupon_fetch",
    "title": "俏猫-查询优惠券领取数量[qiaomao/qm_has_coupon_fetch]",
    "version": "2.0.0",
    "name": "qm_has_coupon_fetch",
    "group": "qiaomao_Coupon",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_has_coupon_fetch"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "coupon_id",
            "description": "<p>优惠卷id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Coupon.php",
    "groupTitle": "qiaomao_Coupon"
  },
  {
    "type": "post",
    "url": "qiaomao/app_stylist_ios",
    "title": "俏猫美业师-app_ios版本号【废除】[qiaomao/app_stylist_ios]",
    "version": "2.0.0",
    "name": "app_stylist_ios",
    "group": "qiaomao_Index",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/app_stylist_ios"
      }
    ],
    "filename": "application/qiaomao/controller/Index.php",
    "groupTitle": "qiaomao_Index"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_app_android",
    "title": "俏猫-app_android版本号【废除】[qiaomao/qm_app_android]",
    "version": "2.0.0",
    "name": "qm_app_android",
    "group": "qiaomao_Index",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_app_android"
      }
    ],
    "filename": "application/qiaomao/controller/Index.php",
    "groupTitle": "qiaomao_Index"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_app_ios",
    "title": "俏猫-app_ios版本号【废除】[qiaomao/qm_app_ios]",
    "version": "2.0.0",
    "name": "qm_app_ios",
    "group": "qiaomao_Index",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_app_ios"
      }
    ],
    "filename": "application/qiaomao/controller/Index.php",
    "groupTitle": "qiaomao_Index"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_category_get_list",
    "title": "俏猫-服务产品获取树形分类列表[qiaomao/qm_category_get_list]",
    "version": "2.0.0",
    "name": "qm_category_get_list",
    "group": "qiaomao_Index",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_category_get_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "type",
            "description": "<p>分类id选填 如化妆 1</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Index.php",
    "groupTitle": "qiaomao_Index"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_index_found_list",
    "title": "俏猫-首页发现[qiaomao/qm_index_found_list]",
    "version": "2.0.0",
    "name": "qm_index_found_list",
    "group": "qiaomao_Index",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_index_found_list"
      }
    ],
    "filename": "application/qiaomao/controller/Index.php",
    "groupTitle": "qiaomao_Index"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_index_recommende_list",
    "title": "俏猫-首页推荐[qiaomao/qm_index_recommende_list]",
    "version": "2.0.0",
    "name": "qm_index_recommende_list",
    "group": "qiaomao_Index",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_index_recommende_list"
      }
    ],
    "filename": "application/qiaomao/controller/Index.php",
    "groupTitle": "qiaomao_Index"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_calculate",
    "title": "俏猫-购物车验证接口[qiaomao/qm_order_calculate]",
    "version": "2.0.0",
    "name": "qm_order_calculate",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_calculate"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>data数据: {&quot;items&quot;:[{&quot;id&quot;:&quot;1000370&quot;,&quot;number&quot;:&quot;1&quot;}],&quot;service_form&quot;:1,&quot;use_balance&quot;:false,&quot;contact&quot;:{&quot;consignee&quot;:&quot;测试&quot;,&quot;address&quot;:&quot;广州市 海珠区 测试&quot;,&quot;mobile&quot;:&quot;15017580819&quot;,&quot;send_time&quot;:&quot;2017-07-13 22:35:00&quot;,&quot;province_id&quot;:&quot;440000&quot;,&quot;city_id&quot;:&quot;440100&quot;,&quot;district_id&quot;:&quot;440105&quot;,&quot;postscript&quot;:&quot;测试&quot;},&quot;coupon_sn&quot;:&quot;&quot;,&quot;stylist_id&quot;:null,&quot;from_ad&quot;:&quot;m站&quot;}</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_cancel",
    "title": "俏猫-顾客取消订单[qiaomao/qm_order_cancel",
    "version": "2.0.0",
    "name": "qm_order_cancel",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_cancel"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单sn</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>取消类型如user</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reason",
            "description": "<p>取消原因</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_cancel_delect",
    "title": "俏猫-顾客取消后删除订单[qiaomao/qm_order_cancel_delect",
    "version": "2.0.0",
    "name": "qm_order_cancel_delect",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_cancel_delect"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单sn</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_comment",
    "title": "俏猫-订单评论[qiaomao/qm_order_comment",
    "version": "2.0.0",
    "name": "qm_order_comment",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_comment"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>评论内容</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "score",
            "description": "<p>评分</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "images",
            "description": "<p>images 多张图’,‘隔开</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "parent_id",
            "description": "<p>parent_id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "top_parent_id",
            "description": "<p>top_parent_id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_confirm_by_buyer",
    "title": "俏猫-顾客确认接受服务[qiaomao/qm_order_confirm_by_buyer",
    "version": "2.0.0",
    "name": "qm_order_confirm_by_buyer",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_confirm_by_buyer"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单sn</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_create",
    "title": "俏猫-下单接口[qiaomao/qm_order_create]",
    "version": "2.0.0",
    "name": "qm_order_create",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_create"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "data",
            "description": "<p>data数据: {&quot;items&quot;:[{&quot;id&quot;:&quot;1000370&quot;,&quot;number&quot;:&quot;1&quot;}],&quot;service_form&quot;:1,&quot;use_balance&quot;:false,&quot;contact&quot;:{&quot;consignee&quot;:&quot;测试&quot;,&quot;address&quot;:&quot;广州市 海珠区 测试&quot;,&quot;mobile&quot;:&quot;15017580819&quot;,&quot;send_time&quot;:&quot;2017-07-13 22:35:00&quot;,&quot;province_id&quot;:&quot;440000&quot;,&quot;city_id&quot;:&quot;440100&quot;,&quot;district_id&quot;:&quot;440105&quot;,&quot;postscript&quot;:&quot;测试&quot;},&quot;coupon_sn&quot;:&quot;&quot;,&quot;stylist_id&quot;:null,&quot;from_ad&quot;:&quot;m站&quot;}</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_detail",
    "title": "俏猫-订单详情[qiaomao/qm_order_detail",
    "version": "2.0.0",
    "name": "qm_order_detail",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单sn</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_find",
    "title": "俏猫-订单查询[qiaomao/qm_order_find]",
    "version": "2.0.0",
    "name": "qm_order_find",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_find"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": "<p>page</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": "<p>page_size</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "status",
            "description": "<p>订单状态 多个‘,’隔开</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "comment_status",
            "description": "<p>评论状态</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_order_product_finish_confirm",
    "title": "俏猫-顾客确认服务完成[qiaomao/qm_order_product_finish_confirm",
    "version": "2.0.0",
    "name": "qm_order_product_finish_confirm",
    "group": "qiaomao_Order",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_order_product_finish_confirm"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_sn",
            "description": "<p>订单sn</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Order.php",
    "groupTitle": "qiaomao_Order"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_cancel_collect",
    "title": "俏猫-服务产品取消关注收藏[qiaomao/qm_product_cancel_collect]",
    "version": "2.0.0",
    "name": "qm_product_cancel_collect",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_cancel_collect"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "productId",
            "description": "<p>服务产品id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_collect",
    "title": "俏猫-服务产品关注收藏[qiaomao/qm_product_collect]",
    "version": "2.0.0",
    "name": "qm_product_collect",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_collect"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "productId",
            "description": "<p>服务产品id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_collect_list",
    "title": "俏猫-服务产品关注收藏列表[qiaomao/qm_product_collect_list]",
    "version": "2.0.0",
    "name": "qm_product_collect_list",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_collect_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": "<p>page</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": "<p>page_size</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_commend",
    "title": "俏猫-为你推荐[qiaomao/qm_product_commend]",
    "version": "2.0.0",
    "name": "qm_product_commend",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_commend"
      }
    ],
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_fuzzy_search",
    "title": "俏猫-搜索接口[qiaomao/qm_product_fuzzy_search]",
    "version": "2.0.0",
    "name": "qm_product_fuzzy_search",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_fuzzy_search"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Keyword",
            "description": "<p>搜索关键字</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fileds",
            "description": "<p>要查询的字段，多个字段用逗号隔开</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_by",
            "description": "<p>排序字段选填默认id |好评：score|价格：price|最新:created_at|人气/销量:sell_count|</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "order_rule",
            "description": "<p>升降序 |降序:desc|升序:asc|</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "price_start",
            "description": "<p>价格start</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "price_end",
            "description": "<p>价格end   如单一方向大于 只传price_start;如price&gt;=200【price_start】;price_end=false/或空值或不传</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "sex",
            "description": "<p>美业师性别 |男:1|女:2|不限:0|</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "level",
            "description": "<p>美业师等级 |不限:0|一星：1|二星：2|三星：3|四星：4|五星：5|</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "server_street",
            "description": "<p>服务商圈</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "service_form",
            "description": "<p>服务形式  |不限：0|美业师上门：1| 顾客到店：2|</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>default is 1</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_size",
            "description": "<p>default is 10</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_get_comments",
    "title": "俏猫-商品评论列表[qiaomao/qm_product_get_comments]",
    "version": "2.0.0",
    "name": "qm_product_get_comments",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_get_comments"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "product_id",
            "description": "<p>产品id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>评论类型|全部：all|好评：good|中评：normal|差评：bad|有图：picture|</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_info",
    "title": "俏猫-商品详情页接口[qiaomao/qm_product_info]",
    "version": "2.0.0",
    "name": "qm_product_info",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_info"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "product_id",
            "description": "<p>产品id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ext",
            "description": "<p>查询字段stylists</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "stylist_id",
            "description": "<p>美业师id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "online",
            "description": "<p>是否上线产品默认1</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ly",
            "description": "<p>默认qt</p>"
          },
          {
            "group": "Parameter",
            "type": "Bool",
            "optional": false,
            "field": "is_order",
            "description": "<p>选填 下单页获取商品详情填写true</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_product_list",
    "title": "显示服务产品的列表[qiaomao/qm_product_list]",
    "version": "2.0.0",
    "name": "qm_product_list",
    "group": "qiaomao_Product",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_product_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fileds",
            "description": "<p>要查询的字段，多个字段用逗号隔开</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "status",
            "description": "<p>作品审核状态,1为未审核的作品</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "stylist_id",
            "description": "<p>查询指定造型师提供服务的产品</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "id",
            "description": "<p>服务产品的ID</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cate_id",
            "description": "<p>分类ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>服务产品的名字</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "city",
            "description": "<p>服务产品所服务的城市</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>default is 1</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_size",
            "description": "<p>default is 10</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_by",
            "description": "<p>根据字段排序</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_rule",
            "description": "<p>desc|asc</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "type",
            "description": "<p>按产品类型</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "tag_id",
            "description": "<p>1为精品，2为新品，3为促销，4为热销</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "offline",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tag",
            "description": "<p>表示标签</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_form",
            "description": "<p>1为美业师上门  2为顾客到店</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "service_object",
            "description": "<p>1为用户1对1服务 2为团体服务 3为个体拼单服务</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "label",
            "description": "<p>1-新品  2-热销  3-促销  4-打包套装 5-赠品 6-活动  7-秒杀</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cate_id_2",
            "description": "<p>一级分类下的二级分类数字,一般为 6 7 8 9 10 11 12 13 。。。</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "price_start",
            "description": "<p>$price_end 价格区间【0,999999】默认</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "index",
            "description": "<p>该字段用于首页的取产品为双数</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type_user",
            "description": "<p>区别服务是谁添加 2俏猫平台添加 1美业师自己添加</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Product.php",
    "groupTitle": "qiaomao_Product"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_get_street",
    "title": "查看美业师商圈[qiaomao/qm_get_street]",
    "version": "2.0.0",
    "name": "qm_get_street",
    "group": "qiaomao_Store",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_get_street"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "stylist_id",
            "description": "<p>美业师id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Store.php",
    "groupTitle": "qiaomao_Store"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_service_show",
    "title": "俏猫-店铺-服务项目[qiaomao/qm_service_show]",
    "version": "2.0.0",
    "name": "qm_service_show",
    "group": "qiaomao_Store",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_service_show"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "storeId",
            "description": "<p>店铺/机构 id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Store.php",
    "groupTitle": "qiaomao_Store"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_store_Introduction",
    "title": "俏猫-店铺简介[qiaomao/qm_store_Introduction]",
    "version": "2.0.0",
    "name": "qm_store_Introduction",
    "group": "qiaomao_Store",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_store_Introduction"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "storeId",
            "description": "<p>店铺/机构 id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Store.php",
    "groupTitle": "qiaomao_Store"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_store_detail",
    "title": "俏猫-店铺详情[qiaomao/qm_store_detail]",
    "version": "2.0.0",
    "name": "qm_store_detail",
    "group": "qiaomao_Store",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_store_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "storeId",
            "description": "<p>店铺/机构 id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Store.php",
    "groupTitle": "qiaomao_Store"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_store_ment",
    "title": "查看店铺评价[qiaomao/qm_store_ment]",
    "version": "2.0.0",
    "name": "qm_store_ment",
    "group": "qiaomao_Store",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_store_ment"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "stylist_id",
            "description": "<p>美业师id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page_no",
            "description": "<p>第几页</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "per_page",
            "description": "<p>一页几条</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>0全部，1好评，2中评，3差评，4有图</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/Store.php",
    "groupTitle": "qiaomao_Store"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_profile_get",
    "title": "api验证用户成功,返回的用户资料[qiaomao/qm_profile_get]",
    "version": "2.0.0",
    "name": "qm_profile_get",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_profile_get"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "uid",
            "description": "<p>选填</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "exts",
            "description": "<p>选填</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_balance_list",
    "title": "俏猫-用户钱包收支列表[qiaomao/qm_user_balance_list]",
    "version": "2.0.0",
    "name": "qm_user_balance_list",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_balance_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "uid",
            "description": "<p>测试 324248231</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_complaint_stylist",
    "title": "俏猫-用户意见投诉美业师列表[qiaomao/qm_user_complaint_stylist]",
    "version": "2.0.0",
    "name": "qm_user_complaint_stylist",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_complaint_stylist"
      }
    ],
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_complaint_submit",
    "title": "俏猫-用户意见投诉[qiaomao/qm_user_complaint_submit]",
    "version": "2.0.0",
    "name": "qm_user_complaint_submit",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_complaint_submit"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>['user_name', 'description', 'contact','stylist_id']</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_feedback_submit",
    "title": "俏猫-用户意见反馈[qiaomao/qm_user_feedback_submit]",
    "version": "2.0.0",
    "name": "qm_user_feedback_submit",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_feedback_submit"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>['user_name', 'description', 'contact']</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_footprint_list",
    "title": "俏猫-用户足迹列表[qiaomao/qm_user_footprint_list]",
    "version": "2.0.0",
    "name": "qm_user_footprint_list",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_footprint_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "uid",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_income_check_in",
    "title": "俏猫-用户每日签到[qiaomao/qm_user_income_check_in]",
    "version": "2.0.0",
    "name": "qm_user_income_check_in",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_income_check_in"
      }
    ],
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_modify_base",
    "title": "俏猫-修改用户资料[qiaomao/qm_user_modify_base]",
    "version": "2.0.0",
    "name": "qm_user_modify_base",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_modify_base"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "data",
            "description": "<p>['nick', 'real_name', 'city_id', 'area_id', 'address', 'birthday', 'sex', 'career','avatar']</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_points_list",
    "title": "俏猫-用户猫粮积分列表[qiaomao/qm_user_points_list]",
    "version": "2.0.0",
    "name": "qm_user_points_list",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_points_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "qiaomao/qm_user_stylist_list",
    "title": "俏猫-造型师列表 [qiaomao/qm_user_stylist_list]",
    "version": "2.0.0",
    "name": "qm_user_stylist_list",
    "group": "qiaomao_User",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/qiaomao/qm_user_stylist_list"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_by",
            "description": "<p>fans 人气  new 最新</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_rule",
            "description": "<p>asc升 desc降</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>美业师名</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "province_id",
            "description": "<p>省id</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市id</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "area_id",
            "description": "<p>区id</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "page_size",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "recommend_sid",
            "description": "<p>推荐美业师id</p>"
          }
        ]
      }
    },
    "filename": "application/qiaomao/controller/User.php",
    "groupTitle": "qiaomao_User"
  },
  {
    "type": "post",
    "url": "mon/mon_service_uploads",
    "title": "添加服务专有上传接口[mon/mon_service_uploads]",
    "version": "2.0.0",
    "name": "mon_service_uploads",
    "group": "service_uploads",
    "sampleRequest": [
      {
        "url": "http://www.qiaom.com/mon/mon_service_uploads"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "base64",
            "optional": false,
            "field": "image",
            "description": "<p>图片</p>"
          }
        ]
      }
    },
    "filename": "application/mon/controller/Upload.php",
    "groupTitle": "service_uploads"
  }
] });
