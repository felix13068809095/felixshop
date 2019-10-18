<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//默認網頁首頁

    Route::get('/','home/index/index');
    Route::get('admin/index/index','admin/index/index');

//前台路由分組

    Route::group('home',function(){
        // 基本數據展示路由
        Route::get('goods/detail','home/goods/detail');
        // 前台分類首頁
        Route::get('/category/index','home/category/index');
        // 前台首頁路由
        Route::get('/index/index','home/index/index');
        // 註冊路由
        Route::any('/public/register','home/public/register');
        // 登錄路由
        Route::any('/public/login','home/public/login');
        // 登出路由
        Route::get('/public/logout','home/public/logout');
        // 發送短信路由
        Route::any('/public/sendSms','home/public/sendSms');
    });

// 後台路由分組

    Route::group('admin',function(){

        //後台相關頁面路由
        Route::get('/index/top','admin/index/top');
        Route::get('/index/main','admin/index/main');
        Route::get('/index/left','admin/index/left');

        //後台用戶增加路由
        Route::any('/user/add','admin/user/add');
        //後台用戶首頁路由
        Route::get('user/index','admin/user/index');
        //後台用戶修改路由
        Route::any('/user/upd','admin/user/upd');
        //後台用戶刪除路由
        Route::get('/user/del','admin/user/del');
	    //后台的退出和登录
    	Route::any('/public/login','admin/public/login');
        Route::get('/public/logout','admin/public/logout');
        
        //後台用戶權限增加路由
        Route::any('/auth/add','admin/auth/add');
        //後台用戶權限首頁路由
        Route::get('/auth/index','admin/auth/index');        
        //後台用戶權限更新路由
        Route::any('/auth/upd','admin/auth/upd');        
        //後台用戶權限刪除路由
        Route::get('/auth/ajaxDelAuth','admin/auth/ajaxDelAuth');

        //後台角色首頁
        Route::get('/role/index','admin/role/index');
        //後台角色添加路由
        Route::any('/role/add','admin/role/add');
        //後台角色刪除路由
        Route::get('/role/del','admin/role/del');
        //後台角色更新路由
        Route::any('/role/upd','admin/role/upd');

         //後台商品類型首頁
         Route::get('/type/index','admin/type/index');
         //後台商品類型添加路由
         Route::any('/type/add','admin/type/add');
         //後台商品類型刪除路由
         Route::get('/type/del','admin/type/del');
         //後台商品類型更新路由
         Route::any('/type/upd','admin/type/upd');       

         //後台商品屬性首頁
         Route::get('/attribute/index','admin/attribute/index');
         //後台商品屬性添加路由
         Route::any('/attribute/add','admin/attribute/add');
         //後台商品屬性刪除路由
         Route::get('/attribute/del','admin/attribute/del');
         //後台商品屬性更新路由
         Route::any('/attribute/upd','admin/attribute/upd');    
         
        //後台商品分類屬性首頁
         Route::get('/category/index','admin/category/index');
         //後台商品屬性添加路由
         Route::any('/category/add','admin/category/add');
         //後台商品屬性刪除路由
         Route::get('/category/del','admin/category/del');
         //後台商品屬性更新路由
         Route::any('/category/upd','admin/category/upd');

        //後台商品首頁
        Route::get('/goods/index','admin/goods/index');
        //後台商品屬性添加路由
        Route::any('/goods/add','admin/goods/add');
        //後台商品屬性刪除路由
        Route::get('/goods/del','admin/goods/del');
        //後台商品屬性更新路由
        Route::any('/goods/upd','admin/goods/upd');   
        
        //ajax 獲取商品類型指定的屬性
        Route::get('/goods/getAttr','admin/goods/getAttr');
     
    });
