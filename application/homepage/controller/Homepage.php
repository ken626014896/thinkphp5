<?php
namespace app\homepage\controller;
use think\Controller; //使用控制器

use think\Db;

class Homepage  extends Controller
{
    public function homepage()
    {   
        $res=Db::query('select * from php_commodity where name=?',['苹果']);
            
        dump($res);
         
        foreach ($res as $value)
		{
		     foreach ($value as $key => $val)
			{
		      dump($key);
		      dump($val);
		     
			}

		}
    	
       $this->assign([
            'name'  =>  'ddd',
            'email' => 'thinkphp@qq.com'
        ]);
        // 模板输出
        return $this->fetch('homepage/homepage');
    }
}