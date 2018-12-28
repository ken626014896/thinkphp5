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
        $json_dats=$this->get_order();
        $array_data=json_decode($json_dats,true)['Data'];

        $order_sum= count($array_data);

        $this->assign([
            'username' =>  $this->username,
            'array_data'=>$array_data,
            'order_sum'=>$order_sum

        ]);

        return $this->fetch('adminpage/order_list');

    }

    public  function  get_order()
    {
        $this->init();
        $url='http://119.23.44.138:10001/order/admin/get';


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