<?php
namespace app\homepage\controller;
use think\Controller; //使用控制器

use think\Db;
use  think\Session;
class Homepage  extends Controller
{
    public function homepage()
    {   
        $res=Db::query('select * from php_commodity where name=?',['苹果']);

        //两种查询方式
        $res2=Db::table('item')->where('itemid','Apple627657501')->select();
        $item=Db::query('select * from item where itemid=?',['Apple627657501']);
        dump($res2);


        foreach ($res as $value)
		{
		     foreach ($value as $key => $val)
			{
		      dump($key);
		      dump($val);
		     
			}

		}

        dump($this->send_post());

       $name=Session::get('islogin');
       $this->assign([
            'name'  =>  $name,
            'email' => 'thinkphp@qq.com'
        ]);
        // 模板输出
        return $this->fetch('homepage/homepage');
    }
    public function  send_post() {
        $url='http://119.23.44.138:10001/admin/login';
        $post_data = array(

            'username' => 'admin',

            'password' => 'admin'

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

    return $result;
}

}