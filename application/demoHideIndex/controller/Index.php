<?php
namespace app\demoHideIndex\controller;

/*

编辑apache 的配置文件 /etc/apache2/httpd.conf
> sudo vim /etc/apache2/httpd.conf
Apache的httpd.conf文件中

1.开启重写
#LoadModule rewrite_module libexec/apache2/mod_rewrite.so

去除"#",开启配置
LoadModule rewrite_module libexec/apache2/mod_rewrite.so

2.配置重写
// /Library/WebServer/Documents为对应文件路径
DocumentRoot "/Library/WebServer/Documents"
<Directory "/Library/WebServer/Documents">
    AllowOverride None
    Options None
    Require all granted
</Directory>

//其中AllowOverride None改为AllowOverride All使其可以重写
DocumentRoot "/Library/WebServer/Documents"
<Directory "/Library/WebServer/Documents">
    AllowOverride All
    Options None
    Require all granted
</Directory>

——————————————————————————————————————————————

隐藏index.php

可以去掉URL地址里面的入口文件index.php，但是需要额外配置WEB服务器的重写规则。

以Apache为例，需要在入口文件的同级添加.htaccess文件（官方默认自带了该文件,tp5/public/.htaccess），内容如下：
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
//此行表名隐藏index.php,自动改写index.php
</IfModule>

如果用的phpstudy，规则如下：
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1]
</IfModule>

接下来就可以使用下面的URL地址访问了
http://tp5.com/index/index/index
http://tp5.com/index/index/hello

如果使用的apache版本使用上面的方式无法正常隐藏index.php，可以尝试使用下面的方式配置.htaccess文件：
<IfModule mod_rewrite.c>
Options +FollowSymlinks -Multiviews
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
//此行表名隐藏index.php,自动改写index.php

</IfModule>

如果是Nginx环境的话，可以在Nginx.conf中添加：
location / { // …..省略部分代码
    if (!-e $request_filename) {
        rewrite  ^(.*)$  /index.php?s=/$1  last;
        break;
    }
}

——————————————————————————————————————————————
BIND_MODULE

设置绑定Admin模块
define('BIND_MODULE','Admin');
使得http://localhost/admin.php/Public/product
改为http://localhost/product

注1:常用于Api等限制,只可绑定一个(BIND_MODULE不常用,除非为单模块项目)
注2:可于入口绑定文件内设置,如tp5/public/index.php内
注3:若开启了config.php内的auto_bind_module(入口自动绑定模块)为true,则自动绑定模块,一般不设置,默认为false

*/

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }
}
