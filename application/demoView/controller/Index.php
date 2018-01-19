<?php
namespace app\demoView\controller;

use  think\Controller;
use  think\View;

//继承文件
class Index extends  Controller
{
//http://localhost/tp5/public/index/demoView/index/index
    public function index()
    {
//        加载视图有四种方法,如下(需要继承Controller):
//        载入完成后,对应
//          1.
        $this->assign('key','value');
//          2.
        $this->view->key2 = 'value2';
//          3.
        View::share('key3','value3');
//          4.
        return $this->fetch('index',[
            'key4'=>'value4'
        ],[
            'STATIC'=>'ttst'
        ]);
        /*
        $this->fetch('指定html文件名称',[
            'key4'=>'value4'
            //传递参数值
        ],[
            'STATIC'=>'STATIC替换为该字符串';
            //html内的所有STATIC字符串替换为  STATIC替换为该字符串
        ]);


        不传值可以直接$this->fetch()显示view/index/index.html
        */


//        可以打印对应文件地址,如
        dump(__DIR__);
        dump(__FILE__);



        /*

        //对应config文件可以配置,以下两个参数为html传值读取为{$key}的原因
        //  会在对应的runtime/temp内生成对应的php语法,将{$key}转为<?php echo $key; ?>

        'template'               => [
        // 模板引擎普通标签开始标记,html读取php传值的开头
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记,html读取php传值的结尾
        'tpl_end'      => '}',
        ],

        // 视图输出字符串内容替换,可在html文件内动态配置CSS文件位置等,可见index.html配置CSS
        'view_replace_str'       => [
            '__CSS__' => '/front/css'
        ]

        /front/css为文件地址,可以配置为__DIR__.'/front/css'等到指定位置,如/tp5/application/config进行配置则
        之后html内使用__CSS__
        如:__CSS__/style.css 为/tp5/application/front/css/style.css
        __CSS__在config的view_replace_str下配置后可以动态修改位置

        */



//        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }



    public  function showView(){
        session('email','2333@qq.com');
        cookie('username','scarlet');
        return $this->fetch('index/showView');
    }
}
