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
    'demoObject/index'          => 'index/demoObject/index/index',
    'demoObject/create'         => 'index/demoObject/index/create',
    'demoObject/add'            => 'index/demoObject/index/add',
    'demoObject/add_list'       => 'index/demoObject/index/addList',
    'demoObject/update/:id'     => 'index/demoObject/index/update',
    'demoObject/delete/:id'     => 'index/demoObject/index/delete',
    'demoObject/:id'            => 'index/demoObject/index/read',
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

//    'demoObject/index'          => 'index/demoObject/index/index',
    'demoObject/create'         => 'index/demoObject/index/create',
    'demoObject/add'            => 'index/demoObject/index/add',
    'demoObject/add_list'       => 'index/demoObject/index/addList',
    'demoObject/update/:id'     => 'index/demoObject/index/update',
    'demoObject/delete/:id'     => 'index/demoObject/index/delete',
    'demoObject/:id'            => 'index/demoObject/index/read',

];