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
        if (!Session::has('loginname')){

            $this->error('未登录','adminpage/Login/login');

        }
          $this->init();
        $this->assign([
            'username'  =>  $this->username,

        ]);

         return $this->fetch('adminpage/index');


    }
    //得到所有商品
    public  function  post($page){
        if (!Session::has('loginname')){

            $this->error('未登录','adminpage/Login/login');

        }

        //通过ajax 更改状态
        if(request()->isAjax()){

            $move=input('option');
            if($move=='change'){

                $com_id=input('com_id');
                $status=input('status');

                $this->change_status($com_id,$status);
                return $status;
            }

        }


        $page=(int)$page;
        $page=$page-1;

        $this->init();
        $url='http://119.23.44.138:10001/commodity/admin/get_detail?page='.$page;
        $result=$this->get_commodity($url);
        if ($result==0)
            $commodity_list=null;


        $commodity_sum=0;//商品总数

        $commodity_list=json_decode($result ,true)["Data"];
        if($commodity_list!=null)
            $commodity_sum=array_shift ($commodity_list);


        $this->assign([
            'username'  =>  $this->username,
             'commodity_list' =>$commodity_list,
            'com_sum'=>$commodity_sum['total_count']
        ]);


        return $this->fetch('adminpage/commodity_list');

    }

    public  function  change_status($com_id,$stat){

        $this->init();
        $url='http://119.23.44.138:10001/commodity/update_status';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据

        if($stat=='true')
            $status=true;
        else
            $status=false;
        $post_data = array(
            "commodity_id" => (int)$com_id,
            "status" => $status
        );
        $json_data=json_encode($post_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $json_data);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);


        $content = curl_exec($ch);


        curl_close($ch);//关闭会话

    }
    public function  get_commodity($url) {
        $this->init();

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


    public  function  comment($page){
        if (!Session::has('loginname')){

            $this->error('未登录','adminpage/Login/login');

        }
        //使用ajax请求删除评论
        if(request()->isAjax()){

            $del_id=input('del_id');
            $user_id=input('user_id');
            $this->del_comment($del_id,$user_id);

            $str='要删除的评论id'.$del_id.' 用户id'.$user_id;


                return $str;

        }

        //得到评论
        $page=(int)$page;
        $page=$page-1;
        $comment_list=json_decode($this->get_comment($page),true)['Data'];

        $comment_sum=0 ; //初始化评论数
        if($comment_list!=null)
         $comment_sum=array_shift ($comment_list);

        $this->assign([
            'username'  =>  $this->username,
            'comment_list' =>$comment_list,
            'comment_sum'=>$comment_sum['total_count']
        ]);


        return $this->fetch('adminpage/comment_list');

    }
    public  function  del_comment($del_id,$user_id){
        $this->init();
        $url='http://119.23.44.138:10001/comment/user/delete';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据
        $post_data = array(
            "comment_id" => (int)$del_id,
            "user_id" => (int)$user_id
        );
        $json_data=json_encode($post_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $json_data);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);


        $content = curl_exec($ch);


        curl_close($ch);//关闭会话




    }

    public  function  get_comment($page){
        $this->init();
        $url='http://119.23.44.138:10001/comment/admin/get?page='.$page;


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

    public  function  add_commodity(){
        if (!Session::has('loginname')){

            $this->error('未登录','adminpage/Login/login');

        }
        //使用ajax添加商品
        if(request()->isAjax()){

            $post_data=input('aaa');

            $arr_data=json_decode($post_data,true);
            $this->add_commodity_post($arr_data);

            $msg='添加成功';
            return $msg;

        }
        $this->init();
        $this->assign([
            'username'  =>  $this->username,

        ]);

        return $this->fetch('adminpage/add_commodity');



    }
    public function add_commodity_post($arr_data){
        $this->init();
        $url='http://119.23.44.138:10001/commodity/add';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type:application/json";
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据


        $json_data=json_encode($arr_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);

        $content = curl_exec($ch);


        curl_close($ch);//关闭会话


    }
    public  function upload(){


        $file = $_FILES["img_obj"];
        move_uploaded_file($file['tmp_name'], $file["name"]);


        $this->init();
        $url='http://119.23.44.138:10001/image/add';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type:multipart/form-data";
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据

        $post= array("upload_file"=>"");
//        $sabsolute_path=getcwd();
//        $sabsolute_path=strtr($sabsolute_path, '\\', '/');
//        $path=$sabsolute_path.'/'.$file['name'];


        $post['upload_file']  = curl_file_create(realpath($file['name']),$file['type'],$file['name']);

//        $json_data=json_encode($post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);

        //打印请求头


        $content = curl_exec($ch);


        curl_close($ch);//关闭会话
        return $content;
    }
     public function change_msg(){
         $post_data=input('bbb');

         $arr_data=json_decode($post_data,true);
         $this->change_msg_post($arr_data);

         $msg='修改成功';
         return $msg;



     }
    public function change_msg_post($arr_data){
        $this->init();
        $url='http://119.23.44.138:10001/commodity/update';


        $cookies='beegosessionID='.$this->cookies.'; Path=/; HttpOnly';


        $ch =curl_init();

        $header[] = "Content-type:application/json";
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据


        $json_data=json_encode($arr_data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch,CURLOPT_COOKIE,$cookies);

        $content = curl_exec($ch);


        curl_close($ch);//关闭会话


    }
}
