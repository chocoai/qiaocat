<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
   
    //公共类接口
    '[mon]'      => [
        
        //设置用户登录最新设备id
        'mon_set_deviceid'=>['mon/Login/set_deviceid', ['method' => 'post|get']],
        //快捷登录接口
        'mon_quick_login'=>['mon/Login/quick_login', ['method' => 'post']],
        //密码登录
        'mon_pass_login'=>['mon/Login/pass_login', ['method' => 'post']],
        //密码注册
        'mon_pass_reg'=>['mon/Login/pass_reg', ['method' => 'post']],      
        //退出登录
        'mon_logout'=>['mon/Login/logout', ['method' => 'post']],
        //发送验证码
        'mon_send' =>['mon/Login/send_code', ['method' => 'post']],
        //忘记密码
        'mon_forget_pass'=>['mon/Login/forget_pass', ['method' => 'post']],
        //验证码验证
        'mon_yan_code' =>['mon/Login/yan_code', ['method' => 'post']],
        //M站上传照片
        'mon_uploads'=>['mon/Upload/uploads', ['method' => 'post']],
        //APP端上传照片
        'mon_app_uploads'=>['mon/Upload/app_uploads', ['method' => 'post']],
        //美业师添加个性化服务的专有主图上传图片
        'mon_service_uploads'=>['mon/Upload/service_uploads', ['method' => 'post']],
        //城市商圈
        'mon_city_street'=>['mon/City/city_street', ['method' => 'post|get']],
        // 获取省市详情
        'mon_get_support_info'=>['mon/City/get_support_info', ['method' => 'post|get']],
        //获取美业师技术类型
        'mon_get_type'      =>['mon/GetInfo/get_type', ['method' => 'post']],
        //获取省份
        'mon_get_province'      =>['mon/GetInfo/get_province', ['method' => 'post']],
        //获取城市
        'mon_get_city'      =>['mon/GetInfo/get_city', ['method' => 'post']],
        //获取区
        'mon_get_area'      =>['mon/GetInfo/get_area', ['method' => 'post']],
        //获取商圈
        'mon_get_street'      =>['mon/GetInfo/get_street', ['method' => 'post']],
        //获取机构店铺
        'mon_get_agency'      =>['mon/GetInfo/get_agency', ['method' => 'post']],
        // 获取市
        'mon_service_cities'=>['mon/City/service_cities', ['method' => 'post|get']],
        
       
        

    ],
    
    //美业师API接口
    '[dresser]'   => [
        
        //美业师统一返回信息
        'dr_data'  =>['dresser/User/dr_data', ['method' => 'post']],
        //单独修改美业师技术类型
        'dr_set_skill_type'  =>['dresser/User/set_skill_type', ['method' => 'post']],
        //美业师重新申请获取之前输入的信息
        'dr_get_apply'  =>['dresser/User/get_apply', ['method' => 'post']],
        //二维码分享获取美业师信息
        'dr_share_info'  =>['dresser/User/share_info', ['method' => 'post|get']],
        //美业师店铺首页
        'dr_store_index'  =>['dresser/User/store_index', ['method' => 'post']],
        //美业师完善资料
        'dr_add_data' =>['dresser/Login/add_data', ['method' => 'post']],
        //美业师申请个人店铺
        'dr_user_store'    =>['dresser/Login/user_store', ['method' => 'post']],
        //美业师申请机构店铺
        'dr_agency_store'    =>['dresser/Login/agency_store', ['method' => 'post']],
        //美业师申请进度
        'dr_schedule'    =>['dresser/User/schedule', ['method' => 'post']],
        //美业师个人中心首页
        'dr_user_index'    =>['dresser/User/user_index', ['method' => 'post']],
        //美业师个人资料
        'dr_user_info'    =>['dresser/User/user_info', ['method' => 'post']],
        //美业师个人资料修改
        'dr_edit_info'    =>['dresser/User/edit_info', ['method' => 'post']],
        //美业师店铺设置页
        'dr_user_index'    =>['dresser/User/user_index', ['method' => 'post']],
        //美业师店铺修改
        'dr_edit_store'    =>['dresser/User/edit_store', ['method' => 'post']],
        //获取自己的商品有哪些类型
        'dr_get_product_type'    =>['dresser/Coupon/get_product_type', ['method' => 'post']],
        //根据类型获取自己的商品
        'dr_get_product_to'    =>['dresser/Coupon/get_product_to', ['method' => 'post']],
        //店铺创建优惠券
        'dr_set_coupon'    =>['dresser/Coupon/set_coupon', ['method' => 'post']],
        //造型师订单列表
        'dr_order_list'    =>['dresser/Order/order_list', ['method' => 'post']],
        //订单详情
        'dr_order_detail' =>['dresser/Order/order_detail', ['method' => 'post']],
        //订单权限
        'dr_order_auth'  =>['dresser/Order/order_auth', ['method' => 'post']],
        //优惠券管理
        'dr_coupon_index'=>['dresser/Coupon/coupon_index', ['method' => 'post']],
        //优惠券开启暂停
        'dr_coupon_onoff'=>['dresser/Coupon/coupon_onoff', ['method' => 'post']],
        //获取忙时时间
        'dr_get_busy'=>['dresser/User/get_busy', ['method' => 'post']],
        //设置忙时时间
        'dr_set_busy'=>['dresser/User/set_busy', ['method' => 'post']],
        //设置店铺营业暂停
        'dr_set_business'=>['dresser/User/set_business', ['method' => 'post']],
        //美业师评价管理
        'dr_ment_index'=>['dresser/Comment/ment_index', ['method' => 'post']],
        //美业师回复评价
        'dr_ment_reply'=>['dresser/Comment/ment_reply', ['method' => 'post']],
 
        //美业师粉丝列表
        'dr_get_fans'=>['dresser/User/get_fans', ['method' => 'post']],
        //我的邀请
        'dr_get_invitation'=>['dresser/User/get_invitation', ['method' => 'post']],
        //我的二维码
        'dr_get_qrcode'=>['dresser/User/get_qrcode', ['method' => 'post|get']],
        //我的订单消息
        'dr_order_news'=>['dresser/News/order_news', ['method' => 'post']],
        //美业师抢单首页
        'dr_rob_order'=>['dresser/Home/rob_order', ['method' => 'post|get']],
        //美业师确认抢单
        'dr_confirm_order'=>['dresser/Home/confirm_order', ['method' => 'post']],

        
        //查询出美业师所拥有的服务的一级分类和二级分类
        'dr_show_ky_service'   =>['dresser/Service/show_ky_service', ['method' => 'post']],
        //查询出所有服务的一级分类和二级分类
        'dr_show_service_class'   =>['dresser/Service/show_service_class', ['method' => 'post']],
        //添加美业师的个性化服务(包含保存和提交)
        'dr_adds_service'    =>['dresser/Service/adds_service', ['method' => 'post']],
        //添加俏猫标准化服务的接口1:查询出所有该分类下的符合要求的商品供美业师选择
        'dr_Standardized_service'    =>['dresser/Service/Standardized_service', ['method' => 'post']],
        //添加俏猫标准化服务的接口2:添加数据到数据库
        'dr_add_Standardized_service'    =>['dresser/Service/add_Standardized_service', ['method' => 'post']],
        //点击服务菜单栏时，判断该美业师是否有添加服务的权限
        'dr_type_auth'    =>['dresser/Service/type_auth', ['method' => 'post']],
        //服务列表的接口
        'dr_service_list'    =>['dresser/Service/service_list', ['method' => 'post']],
        //当点击“修改” ,即查询出该服务的数据
        'dr_ysj_edit'    =>['dresser/Service/ysj_edit', ['method' => 'post']],
        //当点击所有服务列表里面的“提交或保存” 时
        'dr_ysj_tj'    =>['dresser/Service/ysj_tj', ['method' => 'post']],
        //已上架服务，点击“下架”接口 与 待审核点击“取消审核”的接口
        'dr_ysj_shelves'    =>['dresser/Service/ysj_shelves', ['method' => 'post']],
        //点击“删除”接口
        'dr_btg_del'    =>['dresser/Service/btg_del', ['method' => 'post']],
        //点击“提交审核”接口
        'dr_service_shelves'    =>['dresser/Service/service_shelves', ['method' => 'post']],
        //取消审核接口
        'dr_ysj_qxsh'    =>['dresser/Service/ysj_qxsh', ['method' => 'post']],
        //点击上架接口
        'dr_service_shangjia'    =>['dresser/Service/service_shangjia', ['method' => 'post']],

        //造型师全部订单列表
        'dr_order_all'    =>['dresser/Order/order_all', ['method' => 'post']],
        //订单详情
        'dr_order_detail' =>['dresser/Order/order_detail', ['method' => 'post']],
        //订单权限
        'dr_order_auth'  =>['dresser/Order/order_auth', ['method' => 'post']],
        //美业师各个订单状态数据列表
        'dr_order_status'  =>['dresser/Order/order_status', ['method' => 'post']],
        //取消个人的订单
        'dr_cancel_order'  =>['dresser/Order/cancel_order', ['method' => 'post']],
        //美业师确认个人的订单
        'dr_make_sure_order'  =>['dresser/Order/make_sure_order', ['method' => 'post']],
        //添加备注
        'dr_order_notes'  =>['dresser/Order/order_notes', ['method' => 'post']],
        //抢单
        'dr_order_rob'  =>['dresser/Order/order_rob', ['method' => 'post']],
        //联系客户
        'dr_contact_customer'  =>['dresser/Order/contact_customer', ['method' => 'post']],
        //给客户留言
        'dr_add_message'  =>['dresser/Order/add_message', ['method' => 'post']],

    ],
    
    //俏猫API接口
    '[qiaomao]'  =>[
        
        //俏猫服务产品的列表
        'qm_product_list'=>['qiaomao/Product/product_list', ['method' => 'post|get']],
        //俏猫-搜索接口
        'qm_product_fuzzy_search'=>['qiaomao/Product/product_fuzzy_search', ['method' => 'post|get']],
        //俏猫-商品详细页接口
        'qm_product_info'=>['qiaomao/Product/product_info', ['method' => 'post|get']],        
        //俏猫-下单接口
        'qm_order_create'=>['qiaomao/Order/order_create', ['method' => 'post|get']],        
        //俏猫- 获取优惠券详情
        'qm_coupon_info'=>['qiaomao/Coupon/coupon_info', ['method' => 'post|get']],
        
        //俏猫- 获取优惠券详情
        'qm_coupon_info'=>['qiaomao/Coupon/coupon_info', ['method' => 'post|get']],
        
        //俏猫- 获取用户优惠券列表
        'qm_coupon_list'=>['qiaomao/Coupon/coupon_list', ['method' => 'post|get']],
        
        //俏猫- 获取用户资料
        'qm_profile_get'=>['qiaomao/User/profile_get', ['method' => 'post|get']],
        
        //俏猫- 获取用户地址列表
        'qm_user_address_list'=>['qiaomao/Address/user_address_list', ['method' => 'post|get']],
        
        //俏猫-  保存用户地址
        'qm_user_save_address'=>['qiaomao/Address/user_save_address', ['method' => 'post|get']],
        
        //俏猫-删除用户地址
        'qm_user_delete_address'=>['qiaomao/Address/user_delete_address', ['method' => 'post|get']],
        
        //俏猫-订单查询
        'qm_order_find'=>['qiaomao/Order/order_find', ['method' => 'post|get']],
        //俏猫-订单详情
        'qm_order_detail'=>['qiaomao/Order/order_detail', ['method' => 'post|get']],
        
        //俏猫-订单评论
        'qm_order_comment'=>['qiaomao/Order/order_comment', ['method' => 'post|get']],
        
        //俏猫-顾客确认接受服务
        'qm_order_confirm_by_buyer'=>['qiaomao/Order/order_confirm_by_buyer', ['method' => 'post|get']],
        
        //俏猫-顾客确认服务完成
        'qm_order_product_finish_confirm'=>['qiaomao/Order/order_product_finish_confirm', ['method' => 'post|get']],
        
        //俏猫-顾客取消订单
        'qm_order_cancel'=>['qiaomao/Order/order_cancel', ['method' => 'post|get']],
        
        //俏猫-领取优惠券
        'qm_coupon_fetch'=>['qiaomao/Coupon/coupon_fetch', ['method' => 'post|get']],
        
        //俏猫-顾客取消后删除订单
        'qm_order_cancel_delect'=>['qiaomao/Order/order_cancel_delect', ['method' => 'post|get']],
        
        //俏猫-商品评论列表
        'qm_product_get_comments'=>['qiaomao/Product/product_get_comments', ['method' => 'post|get']],
        
        //俏猫-为你推荐
        'qm_product_commend'=>['qiaomao/Product/product_commend', ['method' => 'post|get']],
        
        //俏猫-领券中心
        'qm_coupon_center'=>['qiaomao/Coupon/coupon_center', ['method' => 'post|get']],
        
        // 俏猫-修改用户资料
        'qm_user_modify_base'=>['qiaomao/User/user_modify_base', ['method' => 'post|get']],
        
        // 俏猫-服务产品关注收藏
        'qm_product_collect'=>['qiaomao/Product/product_collect', ['method' => 'post|get']],
        
        //  俏猫-增加美业师/店铺的关注
        'qm_attention_add_attention'=>['qiaomao/Attention/attention_add_attention', ['method' => 'post|get']],
        
        // 俏猫-取消美业师/店铺的关注
        'qm_attention_cancel_attention'=>['qiaomao/Attention/attention_cancel_attention', ['method' => 'post|get']],
        
        // 俏猫-得到用户所关注美业师/店铺的关注
        'qm_attention_get_attent'=>['qiaomao/Attention/attention_get_attent', ['method' => 'post|get']],
        
        // 俏猫-用户意见反馈
        'qm_user_feedback_submit'=>['qiaomao/User/user_feedback_submit', ['method' => 'post|get']],
        
        // 俏猫-用户意见投诉
        'qm_user_complaint_submit'=>['qiaomao/User/user_complaint_submit', ['method' => 'post|get']],
        
        // 俏猫-服务产品关注收藏列表
        'qm_product_collect_list'=>['qiaomao/Product/product_collect_list', ['method' => 'post|get']],
        
        // 俏猫-用户意见投诉美业师列表
        'qm_user_complaint_stylist'=>['qiaomao/User/user_complaint_stylist', ['method' => 'post|get']],
        
        // 俏猫-用户钱包收支列表
        'qm_user_balance_list'=>['qiaomao/User/user_balance_list', ['method' => 'post|get']],
        
        // 俏猫-用户足迹列表
        'qm_user_footprint_list'=>['qiaomao/User/user_footprint_list', ['method' => 'post|get']],
    
        //  俏猫-用户每日签到
        'qm_user_income_check_in'=>['qiaomao/User/user_income_check_in', ['method' => 'post|get']],
        
        //   俏猫-用户猫粮积分列表
        'qm_user_points_list'=>['qiaomao/User/user_points_list', ['method' => 'post|get']],
        
        // 俏猫-服务产品获取树形分类列表
        'qm_category_get_list'=>['qiaomao/Index/category_get_list', ['method' => 'post|get']],
        
        // 俏猫-首页推荐
        'qm_index_recommende_list'=>['qiaomao/Index/index_recommende_list', ['method' => 'post|get']],
        
        //俏猫-领取优惠券
        'qm_has_coupon_fetch'=>['qiaomao/Coupon/has_coupon_fetch', ['method' => 'post|get']],

        //俏猫-店铺基本信息
        'qm_store_detail'=>['qiaomao/Store/store_detail', ['method' => 'post|get']],

        //俏猫-店铺-服务项目
        'qm_service_show'=>['qiaomao/Store/service_show', ['method' => 'post|get']],

        //俏猫-店铺-店铺简介
        'qm_store_Introduction'=>['qiaomao/Store/store_Introduction', ['method' => 'post|get']],
        

        //俏猫-服务产品取消关注收藏
        'qm_product_cancel_collect'=>['qiaomao/Product/product_cancel_collect', ['method' => 'post|get']],
       

        //俏猫-店铺-获取店铺评价
        'qm_store_ment'=>['qiaomao/Store/store_ment', ['method' => 'post|get']],

        
        //俏猫-店铺-获取店铺商圈
        'qm_get_street'=>['qiaomao/Store/get_street', ['method' => 'post|get']],
        
        
        //俏猫-首页发现
        'qm_index_found_list'=>['qiaomao/Index/index_found_list', ['method' => 'post|get']],
        
        //俏猫-购物车验证接口
        'qm_order_calculate'=>['qiaomao/Order/order_calculate', ['method' => 'post|get']],
        
        
        //俏猫-app_ios版本号
        'qm_app_ios'=>['qiaomao/Index/app_ios', ['method' => 'post|get']],
        
        //俏猫-app_android版本号
        'qm_app_android'=>['qiaomao/Index/app_android', ['method' => 'post|get']],
        
        //俏猫美业师-app_ios版本号
        'app_stylist_ios'=>['qiaomao/Index/app_stylist_ios', ['method' => 'post|get']],
        
        //俏猫-造型师列表
        'qm_user_stylist_list'=>['qiaomao/User/user_stylist_list', ['method' => 'post|get']],
        
        //俏猫-造型师列表
        'qm_user_is_login'=>['qiaomao/User/user_is_login', ['method' => 'post|get']],
        
        
        
        
        
        
           
        
        
   
     
        
        
      
        
   
        
     
        
        
     
      
        
       
      
      
        
        
       
    
        
         
        
    
        
       
        
        
        
      
      
        
    ],
];
