<?php
namespace app\login\controller;

use think\Controller; //使用控制器
use  think\Session;


class Login  extends  Controller
{
    public function login()
    {
        if (Session::has('islogin')){

            $this->success('成功','homepage/Homepage/homepage');

        }
        if(request()->isAjax()){
        	 $username=input('username');
        	 $password=input('password');
             $data=array($username, $password,'houtai');

             if($username==$password){
                 Session::set('islogin',$username);
                 return json('yes');
             }
          // return json_encode($name);
         // $this->success('成功','homepage/Homepage/homepage');
             return json('no');


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
    public  function  loginsuccess(){

        $this->success('成功','homepage/Homepage/homepage');

    }
    public function  logout(){
        Session::delete('islogin');

        $this->success('退出成功','login/Login/login');

    }


}