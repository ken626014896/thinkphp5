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

    public  function  order($page){
        if (!Session::has('loginname')){

            $this->error('未登录','adminpage/Login/login');

        }
        //通过ajax 更改状态
        if(request()->isAjax()){

            $order_id=input('order_id');
            $user_id=input('user_id');

            $this->change_status($order_id,$user_id);
            return 'true';


        }

        $this->init();
        $page=(int)$page;
        $page=$page-1;
        $json_dats=$this->get_order($page);
        $array_data=json_decode($json_dats,true)['Data'];

        $order_sum= count($array_data);

        $this->assign([
            'username' =>  $this->username,
            'array_data'=>$array_data,
            'order_sum'=>$order_sum

        ]);

        return $this->fetch('adminpage/order_list');

    }

    public function change_status($order_id,$user_id)
    {
        $this->init();
        $url='http://119.23.44.138:10001/order/admin/comfirm';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据


        $post_data = array(
            "order_id" => (int)$order_id,
            "user_id" => (int)$user_id
        );
        $json_data=json_encode($post_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $json_data);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);


        $content = curl_exec($ch);


        curl_close($ch);//关闭会话
    }

    public  function  get_order($page)
    {
        $this->init();
        $url='http://119.23.44.138:10001/order/admin/get?page='.$page;


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