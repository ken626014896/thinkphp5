<?php
namespace app\index\controller;

class Index  extends \think\Controller
{
    public function index()
    {
       $this->assign([
            'name'  => 'ThinkPHP',
            'email' => 'thinkphp@qq.com'
        ]);
        // 模板输出
        return $this->fetch('index');
    }
    public function index2($id)
    {
        $this->assign([
            'name'  => $id,
            'email' => 'thinkphp@qq.com'
        ]);
        // 模板输出
        return $this->fetch('index');
    }
}
