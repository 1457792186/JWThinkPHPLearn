<?php
namespace app\demo1\controller;
//导入模板内容
use think\Controller;
//这里使用了use来导入一个命名空间的类库，然后可以在当前文件中直接使用该别名而不需要使用完整的命名空间路径访问类库。
//  也就说，如果没有使用use think\Controller;
//就必须使用class Index extends \think\Controller这种完整命名空间方式
class Index extends Controller
{
    public function index()
    {
        echo "OK";
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

//在浏览器访问http://localhost/tp5/public/index/demo1/index/hello
    public function hello($name = 'thinkphp')
    {
//        直接使用封装好的assign和fetch方法进行模板变量赋值和渲染输出
//        fetch方法中没有指定任何模板，所以按照系统默认的规则（视图目录/控制器/操作方法）输出了view/index/hello.html模板文件
        $this->assign('name', $name);
        return $this->fetch();
    }
}

