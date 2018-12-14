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
            
        $item=Db::query('select * from item where itemid=?',['Apple627657501']);
        dump($item);


        foreach ($res as $value)
		{
		     foreach ($value as $key => $val)
			{
		      dump($key);
		      dump($val);
		     
			}

		}
        $name=Session::get('islogin');
       $this->assign([
            'name'  =>  $name,
            'email' => 'thinkphp@qq.com'
        ]);
        // 模板输出
        return $this->fetch('homepage/homepage');
    }
}