<?php
namespace app\login\controller;

use think\Controller; //使用控制器


class Login  extends  Controller
{
    public function login()
    {
        if(request()->isAjax()){
        	 $username=input('username');
        	 $password=input('password');
             $data=array($username, $password,'houtai');

          // return json_encode($name);
          return json($data);


        }
       
       $this->assign([
            'login'  => '登录页面',
            'email' => 'thinkphp@qq.com'
        ]);
        // 模板输出
        return $this->fetch('login/login');
    }

    public function sendtofetch(){

            $data=array('houtai');
              return json($data);;

    }
   

}