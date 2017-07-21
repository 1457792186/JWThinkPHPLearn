<?php

namespace app\demoAPI\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    //API开发
    //使用ThinkPHP5可以更简单的进行API开发,并最大程度的满足API对性能的需求,下面为API开发中的几个主要问题
    /*
    API版本

    异常处理

    RESTFul

    REST请求测试
        Postman
        REST请求伪装
        API调试
            环境安装
            浏览器设置
            应用配置
            远程调试
        安全建议
    */
    //ThinkPHP5对API开发的支持包括架构、功能和性能方面的良好支持


//1.API版本
//以一个用户信息读取的接口为例,包含两个版本V1和V2,V2版本的接口包括用户的档案信息,统一使用json格式数据输出到客户端:
//在application目录下面创建demoAPI模块目录,并创建controller和model子目录,因为api接口无需视图,所以不需要创建view目录
//api版本号的传入方式有很多,包括设置头信息、请求参数传入以及路由方式,这里采用请求参数传入的方式,设置路由如下:
//  Route::rule(':version/user/id' ,'api/:version.User/read')


//2.异常处理




//3.RESTFul




//4.REST请求测试



//4.1Postman



//4.2REST请求伪装



//4.3API调试



//4.3.1环境安装



//4.3.2浏览器设置



//4.3.3应用配置



//4.3.4远程调试



//4.4安全建议




}
