<?php
namespace app\adminpage\controller;
use think\Controller; //使用控制器

use think\Db;
use  think\Session;
class Login extends  Controller
{
      public function login(){
          if (Session::has('loginname')){

              $this->success('已登陆','adminpage/Index/index');

          }

          if(request()->isAjax()){

              $username=input('username');
              $password=input('password');
              $res=$this->send_post($username,$password);

              if($res['Code']==0) {
                  Session::set('loginname', $username);
                  Session::set('cookies', $res['cookies']);
                  return 1;
              }
              else
                  return 0;
          }

          return $this->fetch('adminpage/login');

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
        $res=json_decode($result,true);
//        成功登录获取cookies
        $res_data=array("Code"=>218);
        if($res['Code']==0)
        {
            $res_data['Code']=0;
            $responseInfo = $http_response_header;
            $res=substr($responseInfo[4],strpos($responseInfo[4],'=')+1);
            $res=substr($res,0,strpos($res, '; '));
            $res_data['cookies']=$res;

        }



        return  $res_data;
    }
    public function loginout(){

            Session::delete(' cookies');
            Session::delete('loginname');
            $this->success('退出成功','adminpage/Login/login');


    }
}