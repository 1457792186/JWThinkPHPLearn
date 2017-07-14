<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*
例子1:
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];

例子2:
return [
    //全局变量规划定义
    '__pattern__' => [
        'id' => '\d+',
    ],
    'demoObject/index'          => 'index/demoObject/index',
    'demoObject/create'         => 'index/demoObject/create',
    'demoObject/add'            => 'index/demoObject/add',
    'demoObject/add_list'       => 'index/demoObject/addList',
    'demoObject/update/:id'     => 'index/demoObject/update',
    'demoObject/delete/:id'     => 'index/demoObject/delete',
    'demoObject/:id'            => 'index/demoObject/read',
]
*/;

return [
    //全局变量规划定义
    '__pattern__' => [
        'name' => '\w+',
        'id' => '\d+',
    ],

    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'demoObject/index'          => 'index/demoObject/model/User/index',
    'demoObject/create'         => 'index/demoObject/model/User/create',
    'demoObject/add'            => 'index/demoObject/model/User/add',
    'demoObject/add_list'       => 'index/demoObject/model/User/addList',
    'demoObject/update/:id'     => 'index/demoObject/model/User/update',
    'demoObject/delete/:id'     => 'index/demoObject/model/User/delete',
    'demoObject/:id'            => 'index/demoObject/model/User/read',

];