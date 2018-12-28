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
// 注册路由到index模块的News控制器的read操作
Route::rule('','homepage/Homepage/homepage');
Route::rule('test/:id','homepage/Test/getnum');

Route::rule('loginsuccess','login/Login/loginsuccess');
Route::rule('login','login/Login/login');
Route::rule('logout','login/Login/logout');
Route::rule('testfetch','login/Login/sendtofetch');


Route::rule('adminlogin','adminpage/Login/login');
Route::rule('index','adminpage/Index/index');
Route::rule('commodity_list','adminpage/Index/post');
Route::rule('comment_list/','adminpage/Index/comment');
Route::rule('add_commodity/','adminpage/Index/add_commodity');
Route::rule('upload_img/','adminpage/Index/upload');
Route::rule('change_msg/','adminpage/Index/change_msg');
Route::rule('change_msg/','adminpage/Index/change_msg');


Route::rule('member_list/','adminpage/Member/member');


Route::rule('order_list/','adminpage/Order/order');