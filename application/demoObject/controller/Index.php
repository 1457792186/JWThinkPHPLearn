<?php
//ThinkPHP5的模型是ORM:对象-关系映射  的封装
//  并提供了简洁的ActiveRecord实现。一般来说,每个数据表都会和一个"模型"对应


/*1.定义表
CREATE TABLE `think_user` (
  `id` int(8) NOT NULL,
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `birthday` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '生日',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_date` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=gb2312;
*/

//2.数据库配置文件定义——与demo2SQL配置相同

//3.添加路由定义(application/route.php)
/*
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
*/

//4.为think_user表定义一个User模型(位于application/demoObject/model/User.php)     代码在application/demoObject/model/User.php
//大多数情况下,无需为模型定义任何属性和方法即可完成基础的操作


namespace app\demoObject\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }





























































































}
