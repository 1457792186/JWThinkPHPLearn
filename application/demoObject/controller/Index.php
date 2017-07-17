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
    'demoObject/index'          => 'index/demoObject/index/index',
    'demoObject/create'         => 'index/demoObject/index/create',
    'demoObject/add'            => 'index/demoObject/index/add',
    'demoObject/add_list'       => 'index/demoObject/index/addList',
    'demoObject/update/:id'     => 'index/demoObject/index/update',
    'demoObject/delete/:id'     => 'index/demoObject/index/delete',
    'demoObject/:id'            => 'index/demoObject/index/read',
]
*/

//4.为think_user表定义一个User模型(位于application/demoObject/model/User.php)     代码在application/demoObject/model/User.php
//大多数情况下,无需为模型定义任何属性和方法即可完成基础的操作


//5.设置数据表
//模型会自动对应一个数据表,规范是:
//      数据库前缀(若有)+当前的模型类名(不含命名空间)
//      因为模型类命名是驼峰法,实际获取的表名为小写+下划线命名的数据表名称
//      如果模型类名命名不符合这一数据表对应规范,可以给当前模型定义单独的数据表,包括两种方式:
/*方法一:5.1设置完整数据表:
namespace app\index\model;
use think\Model

class User extends Model
{
    //设置完整的数据表(包括前缀)
    protected $table = 'think_user';
}
*/
/*方法二:5.2设置不带前缀的数据表名:
namespace app\index\model;
use think\Model

class User extends Model
{
    //设置数据表(不含前缀)
    protected $name = 'member';
}
*/



//6.设置数据库连接
//如果当前模型类需要使用不同的数据库连接,可以定义模型的connection属性,如:
/*6.1模型定义
namespace app\index\model;
use think\Model

class User extends Model
{
    //设置单独的数据库连接
    protected  $connection = [
        //数据库类型
        'type' => 'mysql',
        //服务器地址
        'hostname' => '127.0.0.1',
        //数据库名
        'database' => 'test',
        //数据库用户名
        'username' => 'root',
        //数据库密码
        'password' => '',
        //数据库连接端口
        'hostport' => '',
        //数据库连接参数
        'params' => [],
        //数据库编码默认采用utf8
        'charset' => 'utf8',
        //数据库表前缀
        'prefix' => 'think_',
        //数据库调试模式
        'debug' => true,
    ];
}
*/


namespace app\demoObject\controller;

use  app\demoObject\model\User as UserModel;    //导入模型类。as UserModel为起别名,防止命名冲突,可无

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }



    //6.2基础操作:
    //对象化操作主要内容包含:
    //1.新增数据
    //2.批量新增
    //3.查询数据
    //4.数据列表
    //5.更新数据
    //6.删除数据


    //1.新增数据
    //http://localhost/tp5/public/index/demoObject/index/add
    //            测试时需要把application/route.php文件中'demoObject/index'          => 'index/demoObject/index/index'屏蔽
    //因为application/route.php文件进行了配置,所以http://localhost/tp5/public/index/demoObject/add同样有效
    public function add()
    {
        $user = new UserModel();
        $user->nickname = '流年';
        $user->email = 'thinkphp@qq.com';
        $user->birthday = strtotime('1997-03-05');
        if ($user->save()){
            return  '用户['.$user->nickname.':'.$user->id.']新增成功';
        }else{
            return $user->getError();
        }
    }
    //有一种方式可以省去别名定义,系统支持统一对控制器类添加Controller后缀,修改配置参数(application/config.php):
    //  是否启用控制器类后缀:'controller_suffix'=>true,
    //  之后,控制器类文件改为UserController.php,并修改控制器类的定义,类名修改为UserController

    //默认情况下,实例化模型类后执行save操作都是执行的数据库insert操作,
    //  如果需要实例化执行save执行数据库的update操作,要确保在save方法之前调用isUpdate方法:
    //  $user->isUpdate()->save()
    //如果感觉给User对象一个个赋值太麻烦,可以改为下面的方式
    public function add2()
    {
        //http://localhost/tp5/public/index/demoObject/index/add2
        $user['nickname'] = '流火';
        $user['email'] = 'liuhuohp@qq.com';
        $user['birthday'] = strtotime('1995-03-05');
        if ($result = UserModel::create($user)){
            //create方法可以传入数组或者标准对象,可以在外部统一赋值后传入,当然也可以直接传入表单数据
            return  '用户['.$result->nickname.':'.$result->id.']新增成功';
        }else{
            return '新增出错';
        }
    }




    //2.批量新增
    //可以直接进行数据的批量新增,给控制器添加如下addList方法
    //http://localhost/tp5/public/index/demoObject/index/addList
    //因为application/route.php文件进行了配置,所以http://localhost/tp5/public/index/demoObject/add_list同样有效
    public function addList()
    {
        $user = new UserModel();
        $list = [
            ['nickname'=>'张三','email'=>'234567@qq.com','birthday'=>strtotime('1997-09-09')],
            ['nickname'=>'李四','email'=>'1234567@qq.com','birthday'=>strtotime('1987-09-09')],
        ];
        if ($user->saveAll($list)){
            var_dump($list);
            return  '用户批量新增成功';
        }else{
            return $user->getError();
        }
    }




    //3.查询数据
    //接下来添加User模型的查询功能,给控制器添加read操作方法
    //http://localhost/tp5/public/index/demoObject/index/read/id/1
    //因为application/route.php文件进行了配置,所以http://localhost/tp5/public/index/demoObject/1同样有效
    public function read($id='')
    {//模型的get方法用于获取数据表的数据并返回当前的模型对象实例,通常只需要传入主键作为参数,若没有传传入值,则表示获取第一条数据
        $user = UserModel::get($id);
        echo $user->nickname . '<br />';
        echo $user->email . '<br />';
        echo date('Y/m/d',$user->birthday) . '<br />';
    }
    //模型的get方法和Db的find方法返回结果的区别在于,Db默认返回的是数组,而模型发get方法返回的一定是当前的模型对象实例
    //  系统为模型实现了ArrayAccess接口,因此可以通过数组的方式访问对象实例,吧控制器的read方法修改如下:
    public function read2($id='')
    {//http://localhost/tp5/public/index/demoObject/index/read2/id/1
        $user = UserModel::get($id);
        echo $user['nickname'] . '<br />';
        echo $user['email'] . '<br />';
        echo date('Y/m/d',$user['birthday']) . '<br />';
    }




    //4.数据列表
    //如果要查询多个数据,可以使用模型的all方法,我们在控制器中添加index操作方法用于获取用户列表:
    //http://localhost/tp5/public/index/demoObject/index/readAll
    public function readAll()
    {
        $list = UserModel::all();
        foreach ($list as $user){
            echo $user->nickname . '<br />';
            echo $user->email . '<br />';
            echo date('Y/m/d',$user->birthday) . '<br />';//echo $user->birthday.'<br />'; 直接输出,需要在User类定义读取器
            echo '---------------------' . '<br />';
        }
    }
    //如果不是主键查询,而是条件查询
    public function readAll2()
    {//http://localhost/tp5/public/index/demoObject/index/readAll2
        $list = UserModel::all(function($query){
            $query->where('id','<',3);  //->limit(3)->order('id', 'asc');
        });//all内查询条件需要使用闭包
        foreach ($list as $user){
            echo $user->nickname . '<br />';
            echo $user->email . '<br />';
            echo date('Y/m/d',$user->birthday) . '<br />';
            echo '---------------------' . '<br />';
        }
    }
    //或者
    public function readAll3()
    {//http://localhost/tp5/public/index/demoObject/index/readAll3
        $list = UserModel::all(['status'=>1]);//all内查询条件需要使用闭包
        foreach ($list as $user){
            echo $user->nickname . '<br />';
            echo $user->email . '<br />';
            echo date('Y/m/d',$user->birthday) . '<br />';
            echo '---------------------' . '<br />';
        }
    }




    //5.更新数据
    //可以对查询出来的数据进行更新操作
    //http://localhost/tp5/public/index/demoObject/index/update/id/1
    //因为application/route.php文件进行了配置,所以http://localhost/tp5/public/index/demoObject/update/1同样有效
    public function update($id='')
    {//模型的get方法用于获取数据表的数据并返回当前的模型对象实例,通常只需要传入主键作为参数,若没有传传入值,则表示获取第一条数据
        $user = UserModel::get($id);
        $user->nickname = '夏夜';
        $user->email = 'xiaye@qq.com';

        if (false !== $user->save()){
            return '更新用户成功';
        }else{
            return $user->getError();
        }
    }
    //默认情况下,查询模型数据后返回的模型示例执行save操作都是执行的数据库update操作,
    //  如果需要实例化执行save执行数据库的insert操作,需要确保save方法之前调用isUpdate方法
    //  $user->isUpdate(false)->save()

    //ActiveRecord模式的更新数据需要首先读取对应的数据,若需要更加高效的办法,可以修改为
    //http://localhost/tp5/public/index/demoObject/index/update2/id/1
    public function update2($id='')
    {
        $user['id'] = (int)$id;
        $user['nickname'] = '夏夜';
        $user['email'] = 'xiaye@qq.com';
        $result = UserModel::update($user);
        if ($result){
            return '更新用户成功';
        }else{
            return '更新数据失败';
        }
    }





    //6.删除数据
    //给User控制器添加delete方法来删除用户
    //http://localhost/tp5/public/index/demoObject/index/delete/id/1
    //因为application/route.php文件进行了配置,所以http://localhost/tp5/public/index/demoObject/delete/1同样有效
    public function delete($id='')
    {//模型的get方法用于获取数据表的数据并返回当前的模型对象实例,通常只需要传入主键作为参数,若没有传传入值,则表示获取第一条数据
        $user = UserModel::get($id);

        if ($user){
            $user->nickname = '夏夜';
            $user->email = 'xiaye@qq.com';
            $user->delete();
            return '删除用户成功';
        }else{
            return '删除用户不存在';
        }
    }
    //也可以直接使用destroy方法删除模型数据,如:
    public function delete2($id='')
    {//http://localhost/tp5/public/index/demoObject/index/delete2/id/1
        $result = UserModel::destroy($id);

        if ($result){
            return '删除用户成功';
        }else{
            return '删除用户不存在';
        }
    }





















































































}
