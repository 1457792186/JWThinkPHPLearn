<?php
//创建新模块php think build --module demo


//如果直接访问入口文件的话，由于URL中没有模块、控制器和操作，
//      因此系统会访问默认模块（index）下面的默认控制器（Index）的默认操作（index），因此下面的访问是等效的
/*
http://localhost/tp5/public/index.php
http://localhost/tp5/public/index.php/index/index/index
*/

//如果要访问控制器的hello方法，则需要使用完整的URL地址
//http://localhost/tp5/public/index.php/index/index/hello/name/thinkphp
//由于name参数为可选参数，因此也可以使用
//http://localhost/tp5/public/index.php/index/index/hello



namespace app\index\controller;

class Index
{
    public function index()
    {
        echo $this->hello('PPX');
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }
    public function hello($name='Papi')
    {
        return 'Hello,'.$name;
    }
}
