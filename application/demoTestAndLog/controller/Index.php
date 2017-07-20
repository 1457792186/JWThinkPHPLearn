<?php

//调试和日志
//用于调试和跟踪问题,ThinkPHP5提供了方便的调试工具和手段,便于定位和发现问题
namespace app\demoTestAndLog\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

//TP5调试分为五类,分别为
//页面Trace
//异常页面
//断点调试
//日志分析
//远程调试




//1.页面Trace
// 应用Trace
//  页面Trace的主要作用包括:
//    (1)查看运行数据;
//    (2)查看文件加载情况;
//    (3)查看运行流程;
//    (4)查看当前执行SQL;
//    (5)跟踪调试数据;
//    (6)查看页面错误信息;

//1.1开启Trance
//系统默认不打开Trance,开启Trance是在应用配置文件中设置下面的参数
/*
    // 开启应用Trace调试
    'app_trace'              => true,
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
        ],
*/
//开启后,打开任意调试界面下方出现绿色Trance信息显示,包含了基本、文件、流程、错误、SQL和调试信息
//1.2.1基本信息
//显示了当前请求的运行信息,包括运行时间、吞吐率、内存开销和文件加载等基本信息,通过这个页面可以对当前的请求有一个直观的了解,
//  例如当前请求的内存开销是否过大,查询次数是否在合理的范围之内等等

//1.2.2文件信息
//按加载顺序显示了当前请求加载的文件列表

//1.2.3流程信息
//会显示当前请求做了哪些操作

//1.2.4错误
//会显示页面执行过程中的相关错误,包括警告错误

//1.2.5SQL信息
//如果当前请求使用了数据库操作和查询的话,并且开启了数据库调试模式(数据库调试模式可以单独开启,在数据库配置文件中开启debug参数)
//  会在SQL一栏显示相关的SQL连接和查询信息

//对于一些性能不高的查询尤其要引起注意,及早优化,如果要查看每个SQL查询的EXPLAIN信息,可以在数据库配置文件中设置sql_explain参数如下:
/*
//是否需要进行SQL性能分析
    'sql_explain' => true,
*/
//开启后,SQL语句的下面增加了EXPLAIN分析信息

//1.2.6调试信息
//最后一栏用于开发过程中的调试输出,使用trace方法调试输出的信息不会再页面直接显示,而是在页面Trance的调试一栏显示输出
//在控制器的方法中添加
//  trace()
//刷新页面则会在Trance信息中的调试信息内显示
    //如:
    //http://localhost/tp5/public/index/demoTestAndLog/index/test
    public function test(){
        trace('测试信息');
        trace([1,2,3]);
    }
//如果不希望影响页面的输出效果,可以启用浏览器Trace调试信息,设置如下:
/*
//开启应用Trace调试
'app_trace' => true,
//设置Trace显示方式
'trace' => [
    //使用浏览器console显示页面trace信息
    'trace' => 'console',
],
*/
//设置后,使用Chrome浏览器打开控制台切换到console可以看到Console显示
//控制台依然支持可以查看基本、文件、流程、错误、SQL和调试栏的相关信息,并且支持颜色显示
//Ajax方式请求的信息不会在页面Trace中显示,还包括部分页面Trace之后执行的日志信息也无法在Trace中查看到




//2.异常页面
    //http://localhost/tp5/public/index/demoTestAndLog/index/test2
    public function test2(){
        //使用了一个未定义的索引
        return 'hello,'.$_GET['name'];
    }
    //异常页面会显示错误信息,还有额外的信息可以快速定位和发现问题所在
    //错误行会使用红色标识,若需要详细信息,则需要查看下面的Call Stack信息,这显示了当前异常的详细Trace信息,
    //  带下划线样式的地方,鼠标一上去,停留一伙儿会显示该文件的详细信息
    //  仔细查看完整的异常界面,包含了当前请求的全局变量和常量
    //一般情况下,80%的问题都能在异常页面找出



//3.断点调试
//系统为断点调试提供了几个方法,可以通过调试信息不断缩小问题的范围以及诊断变量的变化

//3.1dump变量调试输出
//在需要的断点位置,调用dunp方法,可以输出浏览器友好的变量信息,支持任何变量类型,如:
//dump('测试');
//dump(['a','b','c']);
//dump(User::get());

//3.2halt变量调试并终端输出
//halt方法与dump一样,不过在输出变量后会诊断当前程序的执行,如:
//halt('测试');       此行代码后程序不会执行

//3.3trace控制台输出
//如果不希望在页面输出调试信息,可以使用trace方法,该方法输出的信息会在Trace或者浏览器Console中显示,使用方法与dump一致,如:
//trace('测试');




//4.日志分析
//追溯日志信息,协同分析错误原因
//系统记录的日志信息在很多时候需要使用,默认情况下,系统使用文件方式记录日志,并且按照日期自动分开子目录保存,文件位于runtime文件夹(可能需要授权777)

//日志文件的内容与Trace类似,但区别在于所有请求都会记录,因此日志信息包含了大量的信息
//ThinkPHP对系统的日志按照级别来分类,并且这个日志级别完全可以自定义,系统内部使用的级别包括:
/*
log:常规日志,用于记录日志
error:错误,一般会导致程序的终止
notice:警告,出现可以运行但是还不够完美的错误
info:信息,程序输出信息
debug:调试,用于调试信息
sql:SQL语句,用于SQL记录,指在数据库的调试模式开启时有效
*/

//系统提供了不同日志级别的快速记录方法,如:
//Log::error('错误信息');
//Log::info('日志信息');

//或者使用trace方法记录日志:
//trace('错误信息','error');
//trace('日志信息','info');

//为了便于分析,还支持设置某些级别的日志信息单独文件记录,如:
/*
'log' => [
    'type' => 'file',
    //error和sql日志单独记录
    'apart_level' => ['error','sql'],
],
*/
//设置后,就会单独生成error和sql两个类型的日志文件,主日志文件中将不再包含这两个级别的日志信息

//定期查看系统的日志文件便于及时发现一些可能存在的隐患,以及给已有的问题提供更多的参考
//日志文件可以使用Socket方式记录到远程服务器,这便是远程调试功能



//5.远程调试
//在demoAPI中进行练习和讲述
















}
