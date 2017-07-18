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



        //9.链式操作
        //查询十个满足条件的数据,并按照id倒序排列
        $list = Db::name('data')
            ->where('status',1)
            ->field('id,name')
            ->order('id','desc')        //asc为从小到大
            ->limit(10)
            ->select();
        dump($list);
        //操作查询方法
        /*
        支持链式操作的查询方法包括
        方法名                 描述
        select              查询数据集
        find                查询单个记录
        insert              插入记录
        udate               更新记录
        delete              删除记录
        value               查询值
        column              查询列
        chunk               分块查询
        count等              聚合查询
        */






        //10.事务支持
        //因为需要使用事务功能,所以表的类型应该为InnoDB,而不是MyISAM
        //对于事务支持,最简单的方法就是transaction方法,只需要把需要执行的事务操作封装到闭包里面即可自动完成事务,如:
        Db::transaction(function (){
           Db::table('think_user')->delete(1);
           Db::table('think_data')->insert(['id'=>28,'name'=>'thinkphp','status'=>1]);
        });
        //一旦think_data表写入失败的话,系统会自动回滚写入成功的话系统会自动提交当前事务
        //  也可以手动控制事务的提交,上面的实现代码可以已改成:
        Db::startTrans();
        try{
            Db::table('think_user')->delete(1);
            Db::table('think_data')->insert(['id'=>28,'name'=>'thinkphp','status'=>1]);
            Db::commit();//提交事务
        }catch (\Exception $e){
            Db::rollback();//回滚事务
        }
        //注意:事务操作只对支持事务的数据库,并且设置了数据表为事务类型才有效,在MySQL数据库中设置表类型为InnoDB。
        //  并且事务操作必须使用同一个数据库连接






        //*****************************************查询语言********************************************
        //11.查询语言
        //查询表达式:如查询think_data数据表中id等于1的数据
        $result = Db::name('data')  //因为配置了前缀,所以表think_data可以写成data
            ->where('id',1)
            ->find();
        dump($result);
        //如果没有使用use引入Db类的话,需要使用
        $result = \think\Db::name('data')  //因为配置了前缀,所以表think_data可以写成data
        ->where('id',1)
            ->find();
        dump($result);
        //find方法用于查找满足条件的第一个记录(及时查询条件有多个符合的数据),
        //  如果查询成功,返回的是一个一维数组,没有满足条件的话则默认返回null(也支持设置是否抛出异常)
        //上述查询实际等于SELECT * FROM 'think_data' WHERE 'id' = 1

        /*
        使用表达式查询时,where的参数依次为:
        where(字段名,条件表达式,查询值)

        可以支持的查询表达式包括如下:
        表达式             含义
        EQ、=            等于(=)
        NEQ、            不等于()
        GT、>            大于(>)
        EGT、>=          大于等于(>=)
        LT、<            小于(<)
        ELT、<=          小于等于(<=)
        LIKE             模糊查询
        [NOT]BETWEEM     (不在)区间查询
        [NOT]IN          (不在)IN查询
        [NOT]NULL        查询字段是否(不)是NULL
        [NOT]EXISTS      EXISTS查询
        EXP              表达式查询,支持SQL语法

        其中表达式不区分大小写
        */

        //11.2查询id大于等于1的数据
        $result = Db::name('data')  //因为配置了前缀,所以表think_data可以写成data
            ->where('id','>=',1)
            ->limit(10)
            ->select();
        dump($result);
        //因为要返回多条记录,所以使用select方法,并且使用limit方法限制返回的最多记录数
        //  上述查询实际等于SELECT * FROM 'think_data' WHERE 'id' >= 1 LIMIT 10
        //如果使用EXP条件表达式的话,表示是原生的SQL语句表达式,如:
        $result = Db::name('data')
        ->where('id','exp','>=1')
            ->limit(10)
            ->select();
        dump($result);



        //11.3查询id的范围
        $result = Db::name('data')  //因为配置了前缀,所以表think_data可以写成data
            ->where('id','in',[1,2,3])
            ->select();
        dump($result);
        //  上述查询实际等于SELECT * FROM 'think_data' WHERE 'id' IN(1,2,3)
        //如果使用EXP条件表达式的话,表示是原生的SQL语句表达式,如:
        $result = Db::name('data')
            ->where('id','between',[1,3])
            ->select();
        dump($result);



        //11.4多字段查询
        $result = Db::name('data')
            ->where('id','between',[1,3])
            ->where('name','like','%think%')    //模糊查询,查找字段内包含think的结果
            ->select();
        dump($result);
        //  上述查询实际等于SELECT * FROM 'think_data' WHERE 'id' BETWEEN 1 AND 3 'name' LIKE '%think%'



        //11.5查询是否为NULL
        $result = Db::name('data')
            ->where('name','null')
            ->select();
        dump($result);
        //  上述查询实际等于SELECT * FROM 'think_data' WHERE 'name' IS NULL




        //11.6批量查询
        $result = Db::name('data')
            ->where([
                'id'=>['between','1,3'],
                'name'=>['like','%think%'],   //模糊查询,查找字段内包含think的结果
            ])->select();
        dump($result);
        //  上述查询实际等于SELECT * FROM 'think_data' WHERE 'id' BETWEEN 1 AND 3 'name' LIKE '%think%'

        //实例2:使用OR和AND混合条件查询
        $result = Db::name('data')
            ->where('name','like','%think%')
            ->where('id',['in',[1,2,3]],['between','5,8'],'or')
            ->limit(10)
            ->select();
        dump($result);
        //或者使用批量方式
        $result = Db::name('data')
            ->where([
                'id'=>[['in',[1,2,3]],['between','5,8'],'or'],
                'name'=>['like','%think%'],   //模糊查询,查找字段内包含think的结果
            ])->select();
        dump($result);
        //  上述查询实际等于
        //  SELECT * FROM 'think_data' WHERE ('id' IN (1,2,3) or 'id'BETWEEN '5' AND '8') AND 'name' LIKE '%think%' LIMIT 10





        //11.7快捷查询
        //如果有多个字段需要使用相同的查询条件,可以使用快捷查询,如,查询id和status都大于0的数据
        $result = Db::name('data')
            ->where('id&status','>',0)
            ->limit(10)
            ->select();
        dump($result);
        //生成的SQL为SELECT * FROM 'think_data' WHERE ('id' > 0 AND 'status' > 0) LIMIT 10
        //也可以使用or方式查询
        $result = Db::name('data')
            ->where('id|status','>',0)
            ->limit(10)
            ->select();
        dump($result);
        //生成的SQL为SELECT * FROM 'think_data' WHERE ('id' > 0 OR 'status' > 0) LIMIT 10





        //11.8视图查询
        //如果需要快捷查询多个表的数据,可以使用试图查询,相当于在数据库创建了一个视图,但仅仅支持查询操作,如
        $result = Db::view('user','id,name,status')
            ->view('profile',['name'=>'truename','phone','email'],'profile.user_id=user.id')
            ->where('status',1)
            ->order('id desc')
            ->limit(10)
            ->select();
        dump($result);
        //生成的SQL语句为
        /*
        SELECT user.id,user.name,user.profile.name AS truename,profile.phone,profile.email
            FROM think_user user INNER JOIN think_profile profile ON profile.user_id=user.id
            WHERE user.status = 1 order by user.id desc
        */






        //11.9闭包查询
        //find和select方法可以直接使用闭包查询
        $result = Db::name('data')
            ->select(function ($query){
                $query->where('name','like','%think%')
                    ->where('id','in','1,2,3')
                    ->limit(10);
            });
        dump($result);
        //生成的SQL语句为SELECT * FROM 'think_data' WHERE 'name' LIKE '%think%' AND 'id' IN ('1','2','3') LIMIT 10




        //11.10使用Query对象
        //可以事先封装Query对象,并传入select方法,例如:
        $query = new \think\db\Query;
        $query->name('data')->where('name','like','%think%')
            ->where('id','in','1,2,3')
            ->limit(10);
        $result = Db::select($query);
        dump($result);




        //11.11获取数值
        //如果仅仅是需要获取某行表的某个值,可以使用value方法:
        //如:获取id为8的data数据的name字段值
        $name = Db::name('data')
                    ->where('id',8)
                    ->value('name');
        dump($name);





        //11.12获取列数据
        //也支持获取某个列的数据,使用column方法,如
        $list = Db::name('data')
            ->where('status',1)
            ->column('name');
        dump($list);
        //获取以id为索引的name列数据,可以修改为
        $list = Db::name('data')
            ->where('status',1)
            ->column('name','id');
        dump($list);
        //获取以主键为索引的数据集,可以修改为
        $list = Db::name('data')
            ->where('status',1)
            ->column('*','id');
        dump($list);





        //11.13聚合查询
        //thinkphp为聚合查询提供了便捷的方法
        $count = Db::name('data')       //统计data表的数据
            ->where('status',1)
            ->count();
        dump($count);
        $max = Db::name('user')       //统计user表的最高分
            ->where('status',1)
            ->max('score');
        dump($max);
        /*
        支持的聚合查询方法      方法               说明
        count               统计数量            统计的字段名(必须)
        max                 获取的最大值         统计的字段名(必须)
        min                 获取的最小值         统计的字段名(必须)
        avg                 获取的平均值         统计的字段名(必须)
        sum                 获取总分            统计的字段名(必须)
        */





        //11.14字符串查询
        //在必要的时候,可以使用原生的字符串查询,但建议是配合参数绑定一起使用,可以避免注入问题,如:
        $result = Db::name('data')
            ->where('id > :id AND name IS NOT NULL',['id' => 10])
            ->select();
        dump($result);
        //可以直接在where方法中使用字符串查询条件,并支持第二个参数传入参数绑定,上面这个查询生成的SQL语句为:
        //  SELECT * FROM 'think_data' WHERE (id > '10' AND name IS NOT NULL)





        //11.15时间(日期)查询
        //首先需要在think_data数据表新增create_time字段,用于日期查询的字段类型推荐使用datetime类型
        //ThinkPHP5查询语言强化了对时间日期查询的支持,如:
        //(1)查询创建时间大于2016-1-1的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','2016-1-1')
            ->select();
        dump($result);
        //(2)查询本周添加的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','this week')
            ->select();
        dump($result);
        //(3)查询最近两天添加的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','-2 days')
            ->select();
        dump($result);
        //(4)查询创建时间在2016-1-1~2016-7-1的数据
        $result = Db::name('data')
            ->whereTime('create_time','between',['2016-1-1','2016-7-1'])
            ->select();
        dump($result);
        //日期查询对create_time字段类型没有要求,可以是int/string/timestamp/datetime/date中的任何一种,系统会自动识别进行处理

        //还可以使用下面的人性化日期查询方式,如:
        //(1)获取今天的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','today')
            ->select();
        dump($result);
        //(2)获取昨天的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','yesterday')
            ->select();
        dump($result);
        //(3)获取本周的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','week')
            ->select();
        dump($result);
        //(4)获取上周的数据
        $result = Db::name('data')
            ->whereTime('create_time','>','last week')
            ->select();
        dump($result);






        //11.16分块查询
        //分块查询是为查询大量数据的需要而设计的,例如think_data表已经有超过1万条记录,但是一次取那么大的数据会导致内存消耗特别大,
        //      但是有这个需要(如查询所有数据并导出到execel),采用分块查询可以缓解这个问题
        //使用分块查询,可以把1万条记录分成100次处理,每次处理100条数据,代码如下:
        Db::name('data')
            ->where('status','>',0)
            ->chunk(100,function ($list){
               //处理100条记录
                foreach ($list as $data){

                }
            });
        //第二个参数可以是有效的callback类型,包括使用闭包函数
        //系统会按照主键顺序查询,每次查询100条,如果不希望使用主键进行查询或者没有主键,则需要指定查询的排序字段(但必须是唯一的),例如:
        Db::name('user')
            ->where('status','>',0)
            ->chunk(100,function ($list){
                //处理100条记录
                foreach ($list as $data){

                }
            },'uid');
        //然后交给callback进行数据处理,处理完毕后进行下一个100条记录,如果需要在中途中断后续查询,只需要在callback方法中返回false即可
        Db::name('data')
            ->where('status','>',0)
            ->chunk(100,function ($list){
                //处理100条记录
                foreach ($list as $data){
                    // 返回false则中断后续查询
                    return false;
                }
            });































    }








































































































































































































































































































































}
