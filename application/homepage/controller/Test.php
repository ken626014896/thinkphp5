<?php
namespace app\homepage\controller;

use think\Controller; //使用控制器

class Test extends Controller
{    
	public function jump()
    {     
        //  $this->assign([
        //     'name'  => 'ThinkPHP',
        //     'email' => 'thinkphp@qq.com'
        // ]);
        // 模板输出
        return view('login/login');
    }
     

    public function getnum($id)
    {     
         $this->assign([
            'num'  => $id
          
        ]);
        // 模板输出
        return $this->fetch('homepage/test');
    }

}