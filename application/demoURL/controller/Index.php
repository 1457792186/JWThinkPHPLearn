<?php
//如果服务器环境不支持pathinfo方式的URL访问，可以使用兼容方式，例如：
//http://localhost/tp5/public/index.php?s=/demo2SQL/index/dbShow
//其中变量s的名称的可以配置的

//5.0不再支持普通的URL访问方式，所以下面的访问是无效的，会发现无论输入什么，访问的都是默认的控制器和操作
//      http://tp5.com/index.php?m=index&c=Index&a=hello


//参数传入
//通过操作方法的参数绑定功能，可以实现自动获取URL的参数，仍然以上面的控制器为例，控制器代码如下


namespace app\demoURL\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    public function hello($name = 'World')
    {
        //就是访问app\index\controller\Index控制器类的hello方法，
        //因为没有传入任何参数，name参数就使用默认值World。如果传入name参数(例子中为thinkphp)，则使用
        //http://localhost/tp5/public/index.php/demoURL/index/hello/name/thinkphp
        return 'Hello,' . $name . '!';
    }

//现在给hello方法增加第二个参数：
    public function hello1($name = 'World', $city = '')
    {
        //   http://localhost/tp5/public/index.php/demoURL/index/hello1/name/thinkphp/city/shanghai
        //或者http://localhost/tp5/public/index.php/demoURL/index/hello1/city/shanghai/name/thinkphp
        //  参数顺序任意
        //或者使用http://localhost/tp5/public/index.php/demoURL/index/hello1?city=shanghai&name=thinkphp
        return 'Hello,' . $name . '! You come from ' . $city . '.';
    }

//还可以进一步对URL地址做简化，前提就是必须明确参数的顺序代表的变量
//  按照参数顺序获取:更改下URL参数的获取方式，把应用配置文件中的url_param_type参数的值修改如下
//  'url_param_type' => 1
//  URL的参数传值方式就变成了严格按照操作方法的变量定义顺序来传值了
//  URL参数顺序固定
//注意:按顺序绑定参数的话，操作方法的参数只能使用URL pathinfo变量，而不能使用get或者post变量




}
