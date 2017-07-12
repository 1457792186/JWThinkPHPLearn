<?php
//定义路由
//在路由定义文件（application/route.php）里面添加一些路由规则
/*
return [
    // 添加路由规则 路由到 index控制器的hello操作方法
    'hello/:name' => 'index/index/hello',
];
*/
//该路由规则表示所有hello开头的并且带参数的访问都会路由到index控制器的hello操作方法。
/*
路由之前的URL访问地址为：
http://tp5.com/index/index/hello/name/thinkphp

定义路由后就只能访问下面的URL地址
http://tp5.com/hello/thinkphp

注意:定义路由规则后，原来的URL地址将会失效，变成非法请求

但是如果只是访问
http://tp5.com/hello
将发生错误
事实上这是由于路由没有正确匹配到，修改路由规则如下
*/
/*
return [
    // 路由参数name为可选
    'hello/[:name]' => 'index/hello',
];

//使用[]把路由规则中的变量包起来，就表示该变量为可选，接下来就可以正常访问了

//当name参数没有传入值的时候，hello方法的name参数有默认值World，所以输出的内容为 Hello,World!
*/



/*
除了路由配置文件中定义之外，还可以采用动态定义路由规则的方式定义，例如在路由配置文件（application/route.php）的开头直接添加下面的方法：
use think\Route;
Route::rule('hello/:name', 'index/hello');

完成的效果和使用配置方式定义是一样的。
无论是配置方式还是通过Route类的方法定义路由，都统一放到路由配置文件application/route.php文件中，具体原因后面会揭晓
*/




/*
完整匹配
前面定义的路由是只要以hello开头就能进行匹配，如果需要完整匹配，可以使用下面的定义：

return [
    // 路由参数name为可选
    'hello/[:name]$' => 'index/hello',
];
当路由规则以$结尾的时候就表示当前路由规则需要完整匹配。
当我们访问下面的URL地址的时候：

http://tp5.com/hello // 正确匹配
http://tp5.com/hello/thinkphp // 正确匹配
http://tp5.com/hello/thinkphp/val/value // 不会匹配
*/





/*
闭包定义
还支持通过定义闭包为某些特殊的场景定义路由规则，例如：

return [
    // 定义闭包
    'hello/[:name]' => function ($name) {
        return 'Hello,' . $name . '!';
    },
];
或者

use think\Route;

Route::rule('hello/:name', function ($name) {
    return 'Hello,' . $name . '!';
});
提示：
闭包函数的参数就是路由规则中定义的变量。
因此，当访问下面的URL地址：

http://tp5.com/hello/thinkphp
会输出

Hello,thinkphp!
*/




/*
设置URL分隔符
如果需要改变URL地址中的pathinfo参数分隔符，只需要在应用配置文件（application/config.php）中设置：
// 设置pathinfo分隔符
'pathinfo_depr'          => '-',
路由规则定义无需做任何改变，我们就可以访问下面的地址：

http://tp5.com/hello-thinkphp
路由参数
我们还可以约束路由规则的请求类型或者URL后缀之类的条件，例如：

return [
    // 定义路由的请求类型和后缀
    'hello/[:name]' => ['index/hello', ['method' => 'get', 'ext' => 'html']],
];
上面定义的路由规则限制了必须是get请求，而且后缀必须是html的，所以下面的访问地址：
http://tp5.com/hello // 无效
http://tp5.com/hello.html // 有效
http://tp5.com/hello/thinkphp // 无效
http://tp5.com/hello/thinkphp.html // 有效
更多的路由参数请参考完全开发手册的路由参数一节。
变量规则
接下来，我们来尝试一些复杂的路由规则定义满足不同的路由变量。在此之前，首先增加一个控制器类如下：

<?php

namespace app\index\controller;

class Blog
{

    public function get($id)
    {
        return '查看id=' . $id . '的内容';
    }

    public function read($name)
    {
        return '查看name=' . $name . '的内容';
    }

    public function archive($year, $month)
    {
        return '查看' . $year . '/' . $month . '的归档内容';
    }
}
添加如下路由规则：

return [
    'blog/:year/:month' => ['blog/archive', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],
    'blog/:id'          => ['blog/get', ['method' => 'get'], ['id' => '\d+']],
    'blog/:name'        => ['blog/read', ['method' => 'get'], ['name' => '\w+']],
];
在上面的路由规则中，我们对变量进行的规则约束，变量规则使用正则表达式进行定义。

我们看下几种URL访问的情况

// 访问id为5的内容
http://tp5.com/blog/5
// 访问name为thinkphp的内容
http://tp5.com/blog/thinkphp
// 访问2015年5月的归档内容
http://tp5.com/blog/2015/05
路由分组
上面的三个路由规则由于都是blog打头，所以我们可以做如下的简化：
return [
    '[blog]' => [
        ':year/:month' => ['blog/archive', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],
        ':id'          => ['blog/get', ['method' => 'get'], ['id' => '\d+']],
        ':name'        => ['blog/read', ['method' => 'get'], ['name' => '\w+']],
    ],
];
对于这种定义方式，我们称之为路由分组，路由分组一定程度上可以提高路由检测的效率。

复杂路由
有时候，我们还需要对URL做一些特殊的定制，例如如果要同时支持下面的访问地址

http://tp5.com/blog/thinkphp
http://tp5.com/blog-2015-05
我们只要稍微改变路由定义规则即可：

return [
    'blog/:id'            => ['blog/get', ['method' => 'get'], ['id' => '\d+']],
    'blog/:name'          => ['blog/read', ['method' => 'get'], ['name' => '\w+']],
    'blog-<year>-<month>' => ['blog/archive', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],
];
对 blog-<year>-<month> 这样的非正常规范，我们需要使用<变量名>这样的变量定义方式，而不是 :变量名方式。
简单起见，我们还可以把变量规则统一定义，例如：

return [
    // 全局变量规则定义
    '__pattern__'         => [
        'name'  => '\w+',
        'id'    => '\d+',
        'year'  => '\d{4}',
        'month' => '\d{2}',
    ],
    // 路由规则定义
    'blog/:id'            => 'blog/get',
    'blog/:name'          => 'blog/read',
    'blog-<year>-<month>' => 'blog/archive',
];
在__pattern__中定义的变量规则我们称之为全局变量规则，在路由规则里面定义的变量规则我们称之为局部变量规则，如果一个变量同时定义了全局规则和局部规则的话，当前的局部规则会覆盖全局规则的，例如：
return [
    // 全局变量规则
    '__pattern__'         => [
        'name'  => '\w+',
        'id'    => '\d+',
        'year'  => '\d{4}',
        'month' => '\d{2}',
    ],

    'blog/:id'            => 'blog/get',
    // 定义了局部变量规则
    'blog/:name'          => ['blog/read', ['method' => 'get'], ['name' => '\w{5,}']],
    'blog-<year>-<month>' => 'blog/archive',
];
*/





/*
生成URL地址
定义路由规则之后，我们可以通过Url类来方便的生成实际的URL地址（路由地址），针对上面的路由规则，我们可以用下面的方式生成URL地址。

// 输出 blog/thinkphp
Url::build('blog/read', 'name=thinkphp');
Url::build('blog/read', ['name' => 'thinkphp']);
// 输出 blog/5
Url::build('blog/get', 'id=5');
Url::build('blog/get', ['id' => 5]);
// 输出 blog/2015/05
Url::build('blog/archive', 'year=2015&month=05');
Url::build('blog/archive', ['year' => '2015', 'month' => '05']);
提示：
build方法的第一个参数使用路由定义中的完整路由地址。
我们还可以使用系统提供的助手函数url来简化

url('blog/read', 'name=thinkphp');
// 等效于
Url::build('blog/read', 'name=thinkphp');
通常在模板文件中输出的话，可以使用助手函数，例如：

{:url('blog/read', 'name=thinkphp')}
如果我们的路由规则发生调整，生成的URL地址会自动变化。
如果你配置了url_html_suffix参数的话，生成的URL地址会带上后缀，例如：
'url_html_suffix'   => 'html',
那么生成的URL地址 类似

blog/thinkphp.html
blog/2015/05.html
如果你的URL地址全部采用路由方式定义，也可以直接使用路由规则来定义URL生成，例如：

url('/blog/thinkphp');
Url::build('/blog/8');
Url::build('/blog/archive/2015/05');
生成方法的第一个参数一定要和路由定义的路由地址保持一致，如果你的路由地址比较特殊，例如使用闭包定义的话，则需要手动给路由指定标识，例如：

// 添加hello路由标识
Route::rule(['hello','hello/:name'], function($name){
    return 'Hello,'.$name;
});
// 根据路由标识快速生成URL
Url::build('hello', 'name=thinkphp');
// 或者使用
Url::build('hello', ['name' => 'thinkphp']);
*/


namespace app\demoRoute\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }
}
