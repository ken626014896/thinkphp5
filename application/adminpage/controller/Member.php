<?php
namespace app\adminpage\controller;
use think\Controller; //使用控制器
use think\Db;
use  think\Session;
use think\Url;
class Member extends  Controller
{
    public  $username;
    public  $cookies;
    public function init(){  #初始化方法
        $this->username = Session::get("loginname");
        $this->cookies = Session::get("cookies");
    }

    public   function  member(){

        $this->init();
        $member_json=$this->get_member();
        $member_array=json_decode($member_json,true)['Data'];
        if($member_array!=null)
            $member_sum=array_shift ($member_array);

        $this->assign([
            'username'  =>  $this->username,
            'member_array'=>$member_array
        ]);

        return $this->fetch('adminpage/member_list');

    }

    public function  get_member(){

        $this->init();
        $url='http://119.23.44.138:10001/admin/get_user';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type: application/json; charset=utf-8";


        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);


        $content = curl_exec($ch);

        curl_close($ch);

        return   $content ;

    }
}