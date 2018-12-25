<?php
namespace app\adminpage\controller;
use think\Controller; //使用控制器

use think\Db;
use  think\Session;
use think\Url;

class Index extends  Controller
{
    /**
     *
     */
            public  $username;
            public  $cookies;
    public function init(){  #初始化方法
        $this->username = Session::get("loginname");
        $this->cookies = Session::get("cookies");
    }
    public function index()
    {

          $this->init();
        $this->assign([
            'username'  =>  $this->username,
            'email' => 'thinkphp@qq.com'
        ]);

         return $this->fetch('adminpage/index');


    }
    public  function  post(){
        $this->init();
        $url='http://119.23.44.138:10001/commodity/get_detail?page=1';
        $result=$this->get_commodity($url);
        $commodity_list=json_decode($result ,true)["Data"];

        $this->assign([
            'username'  =>  $this->username,
             'commodity_list' =>$commodity_list,
        ]);


        return $this->fetch('adminpage/commodity_list');

    }


    public function  get_commodity($url) {

        $result = file_get_contents($url);


        return  $result;
    }
    public  function  comment(){
        $comment_list=json_decode($this->get_comment(),true)['Data'];
        $comment_sum=array_shift ($comment_list);

        $this->assign([
            'username'  =>  $this->username,
            'comment_list' =>$comment_list,
        ]);


        return $this->fetch('adminpage/comment_list');

    }

    public  function  get_comment(){
        $this->init();
        $url='http://119.23.44.138:10001/comment/admin/get';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type: application/json; charset=utf-8";


        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);


        $content = curl_exec($ch);

        curl_close($ch);//关闭会话

        return   $content ;


    }


}
