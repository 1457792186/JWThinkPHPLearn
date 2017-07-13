<?php

//使用Db类操作数据库
namespace app\demoMySQL\controller;

use think\Db;

class Index
{
    //http://localhost/tp5/public/index/demoMySQL/index/index
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    //给应用定义的数据库配置文件(application/database.php),里面设置了应用的全部数据库配置信息
    /*
    return [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'db_study',
    // 用户名
    'username'        => 'root',
    // 密码
    'password'        => '123',
    // 端口
    'hostport'        => '',
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [
        //使用长连接
        \PDO::ATTR_PERSISTENT=>true,
    ],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => 'think_',
    // 数据库调试模式
    'debug'           => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
    ];
    */
    /*模块中数据库配置中使用了长连接
    'params'          => [
        //使用长连接
        \PDO::ATTR_PERSISTENT=>true,
    ]
    */




    //设置好数据库连接后,就可以进行原生的SQL查询操作了,包括query和execute两个方法,分别用于查询和写入
    public function SQL()
    {
        //1.创建-插入记录
        $result = Db::execute('insert into think_data(id,name,status) values (5,"thinkphp",1)');
        dump($result);

        //2.更新-更新记录
        $result = Db::execute('update think_data where id = 5');
        dump($result);

        //3.读取-查询数据
        $result = Db::query('select * from think_data where id = 5');
        dump($result);
        //query方法返回的是一个数据集(数组),若没有查询到数据则返回空数组

        //4.删除-删除数据
        $result = Db::execute('delete from think_data where id = 5');
        dump($result);

        //5.其他操作
        //可以执行一些其他数据库操作,原则上,读操作都使用query方法,写操作使用execute方法
        //如:显示数据库列表
        $result = Db::query('show tables from db_study');
        dump($result);
        //如:清空数据表
        $result = Db::execute('TRUNCATE table think_data');
        dump($result);
        //query方法用于查询,默认情况下返回的是数据集(二维数组),execute方法返回值为受影响的行数

        //6.切换数据库
        //6.1在进行数据库查询的时候,支持切换数据库进行查询
        $result = Db::connect([
            // 数据库类型
            'type'            => 'mysql',
            // 服务器地址
            'hostname'        => '127.0.0.1',
            // 数据库名
            'database'        => 'db_study',
            // 用户名
            'username'        => 'root',
            // 密码
            'password'        => '123',
            // 端口
            'hostport'        => '',
            // 连接dsn
            'dsn'             => '',
            // 数据库连接参数
            'params'          => [],
            // 数据库编码默认采用utf8
            'charset'         => 'utf8',
            // 数据库表前缀
            'prefix'          => 'think_',
        ])->query('select * from think_data');
        dump($result);
        //6.2采用字符串同样
        $result = Db::connect('mysql://root:123@127.0.0.1:3306/db_study#utf8')->query('select * from think_data where id=1');
        dump($result);
        //6.3为简化代码,可以事先在配置文件中定义好多个数据库的连接配置
        $db1 = Db::connect('db1');
        $result = $db1->query('select * from think_data where id=1');
        dump($result);



        //7.参数绑定
        //实际开发中,某些数据使用的是外部传入的变量,所以使用参数绑定机制,所以可以改为
        Db::execute('insert into think_data(id,name,status) values (?,?,?)',[8,'thinkphp',1]);
        $result = Db::query('select * from think_data where id = ?',[8]);
        dump($result);
        //也支持命名占位符绑定,如:
        Db::execute('insert into think_data(id,name,status) values (:id,:name,:status)',['id'=>8,'name'=>'thinkphp','status'=>1]);
        $result = Db::query('select * from think_data where id = :id',['id'=>8]);
        dump($result);




        //8.查询构造器
        //  查询构造器基于PDO实现,对不同的数据库驱动使用统一语法
        //注意:ThinkPHP5查询构造器使用PDO参数绑定,以保护应用程序免于SQL注入,因此传入参数不需要额外转义特殊字符
        //8.1插入记录
        Db::table('think_data')->insert(['id'=>18,'name'=>'thinkphp','status'=>1]);
        //8.2更新记录
        Db::table('think_data')->where('id',18)->update(['name'=>'hello']);
        //8.3查询数据
        Db::table('think_data')->where('id',18)->select();
        //8.4删除数据
        Db::table('think_data')->where('id',18)->delete();

        //因为配置文件设置了表前缀think_,所以table方法可以改成name方法,如
        //8.5插入记录
        Db::name('data')->insert(['id'=>18,'name'=>'thinkphp','status'=>1]);
        //8.6更新记录
        Db::name('data')->where('id',18)->update(['name'=>'hello']);
        //8.7查询数据
        Db::name('data')->where('id',18)->select();
        //8.8删除数据
        Db::name('data')->where('id',18)->delete();

        //若使用系统提供的助手函数db则可进一步简化,但是db助手函数默认会每次重新连接数据库,因此应当尽量避免多次调用
        $db = db('data');//think_data表,配置文件有think_前缀
        //8.9插入记录
        $db->insert(['id'=>18,'name'=>'thinkphp','status'=>1]);
        //8.10更新记录
        $db->where('id',18)->update(['name'=>'hello']);
        //8.11查询数据
        $db->where('id',18)->select();
        //8.12删除数据
        $db->where('id',18)->delete();




    }








































































































































































































































































































































}
