<?php
//创建该目录:进入到tp5后继续终端执行
//php think build --module demo

namespace app\demo\controller;

//进入demo文件夹http://localhost/tp5/public/index/demo
//调用Index类http://localhost/tp5/public/index/demo/index
//Index类调用hello方法http://localhost/tp5/public/index/demo/index/hello

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }
//浏览器进输出http://localhost/tp5/public/index/demo/index/hello
    public function hello()
    {
        return 'hello,thinkphp!';
    }

    public function test()
    {
        return '这是一个测试方法!';
    }

// protected方法不会被调用显示
    protected function hello2()
    {
        return '只是protected方法!';
    }

    private function hello3()
    {
        return '这是private方法!';
    }
}
