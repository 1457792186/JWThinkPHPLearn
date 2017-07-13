<?php
namespace app\demoRequest\controller;

//传统方式调用,但实际开发中使用很少
use think\Request;


class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }


    //传统方式调用
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello
    //          或(以name改为shaye添加参数)http://localhost/tp5/public/index/demoRequest/index/requestHello/name/shaye
    //                                  或http://localhost/tp5/public/index/demoRequest/index/requestHello?name=shaye
    public function requestHello($name = '233')
    {
        $reuqest = Request::instance();
        echo 'url:' . $reuqest->url() . '<br />';
        return 'Hello' . $name . '!';
    }


    //自动注入请求对象
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestAutoHello
    public function requestAutoHello(Request $request, $name = '233')
    {//方法的request是系统自动注入的,而不需要通过URL请求传入
        //获取当前URL地址,不含域名
        echo 'url:' . $request->url() . '<br />';
        return 'Hello' . $name . '!';

    }



    //获取请求变量
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello1?test=ddd&name=thinkphp
    //系统推荐使用param方法统一获取当前请求变量,该方法最大的优势是不需要区分当前请求类型而使用不同的全局变量或方法,并且满足大部分需求
    public function requestHello1(Request $request)
    {
        echo '请求参数:';
        dump($request->param());    //输出类型和数值
        echo 'name:'.$request->param('name').'<br />';

    }



    //获取请求变量2
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello2?test=ddd&name=thinkphp
    //系统提供了一个input助手函数来简化Request对象的param方法,用法如下
    public function requestHello2()
    {
        echo '请求参数:';
        dump(input());    //输出类型和数值
        echo 'name:'.input('name').'<br />';

    }



    //param方法获取的参数会自动判断当前请求,以Post请求为例,参数优先级别为:
    //  路由变量>当前请求变量($_POST变量)>$_GET变量
    //这里的路由变量指的是路由规则中定义的变量或者PATH_INFO地址中的变量。路由变量无法使用get方法或者$_GET变量获取
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello3?test=ddd&name=thinkphp
    public function requestHello3(Request $request)
    {
        echo 'name:'.$request->param('name','world','stryolower');
        echo '<br />test:'.$request->param('test','thinkphp','strtoupper');

    }



    //可以设置全局的过滤方法,如下:
    //  设置默认的全局过滤规则 多个数组或逗号分隔
    //  'default_filter'=>'htmlspecialchars ',




    //除了Param外,Request对象也可以用于获取其他的输入参数,例如:
    public function requestHello4(Request $request)
    {
        echo 'GET参数:';
        dump($request->get());
        echo 'GET参数:name';
        dump($request->get('name'));
        echo 'POST参数:name';
        dump($request->post('name'));
        echo 'cookie参数:name';
        dump($request->cookie('name'));
        echo '上传文件信息:image';
        dump($request->file('image'));
        //此外还有put、delete、path、route、session、server、env等
    }
    //使用助手函数的代码为
    public function requestHello5()
    {
        echo 'GET参数:';
        dump(input('get.'));
        echo 'GET参数:name';
        dump(input('get.name'));
        echo 'POST参数:name';
        dump(input('post.name'));
        echo 'cookie参数:name';
        dump(input('cookie.name'));
        echo '上传文件信息:image';
        dump(input('file.image'));
    }





    //获取请求参数
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello6?name=php
    public function requestHello6(Request $request)
    {
        echo '请求方法:'.$request->method().'<br />';
        echo '资源类型:'.$request->type().'<br />';
        echo '访问IP:'.$request->ip().'<br />';
        echo '是否AJax请求:'.var_export($request->isAjax(),true).'<br />';
        echo '请求参数:';
        dump($request->param());
        echo '请求参数:仅包含name';
        dump($request->only(['name']));
        echo '请求参数:不包含name';
        dump($request->except(['name']));
    }






    //获取URL信息
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello7
    public function requestHello7(Request $request,$name='233')
    {
        //获取当前域名
        echo 'domain:'.$request->domain().'<br />';
        //获取当前入口文件
        echo 'file:'.$request->baseFile().'<br />';
        //获取当前URL地址 不含域名
        echo 'url:'.$request->url().'<br />';
        //获取包含域名的完整URL地址
        echo 'url with domain:'.$request->url(true).'<br />';
        //获取当前URL地址 不含QUERY_STRING
        echo 'url without query:'.$request->baseUrl().'<br />';
        //获取URL访问的ROOT地址
        echo 'root:'.$request->root().'<br />';
        //获取URL访问的ROOT地址
        echo 'root:'.$request->root(true).'<br />';
        //获取URL地址中的PATH_INFO信息
        echo 'pathinfo:'.$request->pathinfo().'<br />';
        //获取URL地址中的PATH_INFO信息 不含后缀
        echo 'pathinfo:'.$request->path().'<br />';
        //获取URL地址中的后缀信息
        echo 'ext:'.$request->ext().'<br />';
        //此外还有baseUrl、baseFile、type、scheme、query、host、port、protocol、remotePort
        //url、baseUrl、baseFile、root方法传入true,表示获取包含域名的地址
    }






    //获取当前模块/控制器/操作信息
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello8
    public function requestHello8(Request $request,$name='233')
    {

        echo '模块:'.$request->module().'<br />';
        echo '控制器:'.$request->controller().'<br />';
        echo '操作:'.$request->action().'<br />';
    }
    //collection方法获取的是驼峰命名发实际的控制器名,其他都是小写返回





    //获取路由和调度信息
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/index/requestHello9
    public function requestHello9(Request $request,$name='233')
    {

        echo '路由信息:';
        dump($request->routeInfo());
        echo '调度信息:';
        dump($request->dispatch());
        return 'Hello,'.$name.'!';
    }
    /*
    然后配置文件中添加路由
    return [
        'requestHello9/:name'=>['index/requestHello9',[],['name'=>'\w+']];
    ];
    */



}

?>