<?php
namespace app\adminpage\controller;
use think\Controller; //使用控制器
use think\Db;
use  think\Session;
use think\Url;
class Order   extends  Controller
{
    public  $username;
    public  $cookies;
    public function init(){  #初始化方法
        $this->username = Session::get("loginname");
        $this->cookies = Session::get("cookies");
    }

    public  function  order(){

        $this->init();
        $this->assign([
            'username'  =>  $this->username,

        ]);

        return $this->fetch('adminpage/order_list');

    }
}