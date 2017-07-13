<?php

namespace app\demoResponse\controller;
//响应对象
use  think\Response;

//页面跳转
//use  traits\controller\Jump;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    //响应对象
    //大多数情况下,系统会根据default_return_type和default_ajax_return配置决定响应输出的类型
    //  默认的自动响应输出会自动判断是否AJAX请求,如果是的话会自动输出default_ajax_return配置的输出类型
    //访问下面地址:http://localhost/tp5/public/index/demoResponse/index/requestHello
    public function requestHello()
    {
        $data = ['name'=>'thinkphp','status'=>'1'];
        return $data;
    }
    //由于默认是输出Html输出,所以访问页面输出结果错误,不支持的数据类型输出:array
    /*
    修改配置文件:
    添加:
    'default_return_type' => 'json',
    //输出结果{"name":"thinkphp","status":"1"}


    若输出类型修改为xml,则输出样式变化:
    'default_return_type' => 'xml',
    */




    //手动输出
    //在必要时,可以手动输出类型和参数
    public function requestHello1(){
        //无论参数如何控制,输出结果为{"name":"thinkphp","status":"1"}
        $data = ['name'=>'thinkphp','status'=>'1'];
        return json($data);

        //默认状态下发送的http状态码是200,如果需要返回其他的状态码,可以使用以下代码:
//        return json($data,201);
        //或者发送更多的信息
//        return json($data,201,['Cache-control'=>'no-cache,must-revalidate']);
        //也支持下面的格式:
//        return json($data)->code(201)->header['Cache-control' =>'no-cache,must-revalidate'];
        //默认支持的输出类型包括:JSON输出json、JSONP输出jsonp、XML输出xml、渲染模板输出view、页面重定向redirect
    }





//***************************进行页面的跳转****************************************
    use  \traits\controller\Jump;
    //引入traits\controller\Jump
    //若控制器继承的是think\Controller,则系统已经自动引入了traits\controller\Jump,无需再次引入
    //进行页面的跳转
    //当页面传入的name为thinkphp时,跳转到欢迎页面,其他情况跳转到一个guest页面
    //正确跳转:http://localhost/tp5/public/index/demoResponse/index/requestHello2?name=thinkphp
    //  错误跳转(name有默认值故可不写入):http://localhost/tp5/public/index/demoResponse/index/requestHello2
    public function requestHello2($name=''){
        if ('thinkphp'==$name){
            $this->success('欢迎使用ThinkPHP5','hello');
        }else{
            $this->error('错误的name','guest');
        }
    }
    public function hello(){
        return 'Hellow,TP';
    }
    public function guest(){
        return 'Hellow,Guest';
    }




    //页面重定向
    //如果要进行页面重定向跳转,可以使用:redirect
    //name正确:http://localhost/tp5/public/index/demoResponse/index/requestHello3?name=thinkphp
    //  name错误:http://localhost/tp5/public/index/demoResponse/index/requestHello3
    public function requestHello3($name=''){
        if ('thinkphp'==$name){
            $this->redirect('http://www.baidu.com');
        }else{
            $this->success('欢迎使用ThinkPHP5','hello');
        }
    }
    //redirect方法默认使用了302跳转,若不需要介样使用第二个参数进行301跳转
    //  如:$this->redirect('http://www.baidu.com',301);


    //在任何时候(即使没有引入Jump trait)可以使用助手函数的redirect函数进行重定向
    //name正确:http://localhost/tp5/public/index/demoResponse/index/requestHello4?name=thinkphp
    //  name错误:http://localhost/tp5/public/index/demoResponse/index/requestHello4
    public function requestHello4($name=''){
        if ('thinkphp'==$name){
            return redirect('http://www.baidu.com');
        }else{
            return '欢迎使用ThinkPHP5';
        }
    }

}
