<?php
//如果控制器是驼峰的，例如定义一个HelloWorld控制器（application/demo1/controller/HelloWorld.php）：
//正确的URL访问地址（该地址可以使用url方法生成）应该是
//http://localhost/tp5/public/index/demo1/new_world
//或http://localhost/tp5/public/index/demo1/newworld
//如果希望严格区分大小写访问（这样就可以支持驼峰法进行控制器访问），可以在应用配置文件中设置'url_convert' => false,

namespace app\demo1\controller;

class NewWorld
{
    public function index($name = 'World')
    {
        return 'Create New,' . $name . '!';
    }
}

?>