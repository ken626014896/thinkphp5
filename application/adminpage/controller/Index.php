<?php
namespace app\adminpage\controller;
use think\Controller; //使用控制器

use think\Db;
use  think\Session;
class Index extends  Controller
{
    /**
     *
     */
            public  $username;
            public  $cookies;
    public function init(){  #初始化方法
        $this->username = Session::get("loginname");
        $this->cookies = Session::get("loginname");
    }
    public function index()
    {
//        $this->username=Session::get("loginname");
//
//        $this->cookies=Session::get('cookies');
          $this->init();
        $this->assign([
            'username'  =>  $this->username,
            'email' => 'thinkphp@qq.com'
        ]);

         return $this->fetch('adminpage/index');


    }
    public  function  post(){
        $this->init();
        $this->assign([
            'username'  =>  $this->username,
            'email' => 'thinkphp@qq.com'
        ]);


        return $this->fetch('adminpage/commodity_list');

    }


    public function  send_post($username,$password) {
        $url='http://119.23.44.138:10001/admin/login';
        $post_data = array(

            'username' => $username,

            'password' => $password

        );
        $json_data=json_encode($post_data);
        $post_data = http_build_query($post_data);

        $options = array(
            'http' =>array(
                'method' => 'POST',
                'header' =>'Content-type:application/x-www-form-urlencoded',
                'content' =>$json_data,
                'timeout' =>15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);


        return  $result;
    }
}
