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

use app\demoObject\model\Book;
use app\demoObject\model\Profile;
use app\demoObject\model\Role;
use  app\demoObject\model\User as UserModel;//导入模型类。as UserModel为起别名,防止命名冲突,可无

use think\Validate;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }


//************************************1.基础操作********************************
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
        echo $user->birthday.'<br />'; //直接输出,需要在User类定义读取器
        //若没有定义读取器,使用 echo date('Y/m/d',$user->birthday) . '<br />';
    }
    //模型的get方法和Db的find方法返回结果的区别在于,Db默认返回的是数组,而模型发get方法返回的一定是当前的模型对象实例
    //  系统为模型实现了ArrayAccess接口,因此可以通过数组的方式访问对象实例,吧控制器的read方法修改如下:
    public function read2($id='')
    {//http://localhost/tp5/public/index/demoObject/index/read2/id/1
        $user = UserModel::get($id);
        echo $user['nickname'] . '<br />';
        echo $user['email'] . '<br />';
        echo $user->birthday.'<br />';//直接输出,需要在User类定义读取器
        //若没有定义读取器,使用 echo date('Y/m/d',$user['birthday']) . '<br />';
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
            echo $user->birthday.'<br />'; //直接输出,需要在User类定义读取器
            //若没有定义读取器,使用 echo date('Y/m/d',$user->birthday) . '<br />';
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
            echo $user->birthday.'<br />'; //直接输出,需要在User类定义读取器
            //若没有定义读取器,使用 echo date('Y/m/d',$user->birthday) . '<br />';
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
            echo $user->birthday.'<br />'; //直接输出,需要在User类定义读取器
            //若没有定义读取器,使用 echo date('Y/m/d',$user->birthday) . '<br />';
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





//************************************2.User模型修改后自动方法&查询********************************************************
    //http://localhost/tp5/public/index/demoObject/index/autoTest
    public function autoTest()
    {

        $list = UserModel::scope('email,status')->select();//编写了查询范围,所以查询的是邮箱为thinkphp@qq.com并且status为1的数据
        /*或者:追加新的查询及链式操作
            $list = UserModel::scope('email,status',function ($query){
                $query->order('id','asc');
            })->select();
        */

        foreach ($list as $user){
            echo $user->nickname . '<br />';
            echo $user->email . '<br />';
            echo $user->birthday . '<br />';    //编写了读取器和修改器,所以不需要转换时间戳格式
            echo $user->status . '<br />';      //编写了自动完成,所以建立时插入数据
        }
    }


    //若查询范围方法支持额外的参数,例如scopeEmail添加email参数
    //http://localhost/tp5/public/index/demoObject/index/autoTestEmail
    public function autoTestEmail()
    {
        $list = UserModel::scope('email','xiaye@qq.com')->select();

        foreach ($list as $user){
            echo $user->nickname . '<br />';
            echo $user->email . '<br />';
            echo $user->birthday . '<br />';    //编写了读取器和修改器,所以不需要转换时间戳格式
            echo $user->status . '<br />';      //编写了自动完成,所以建立时插入数据
        }
    }




//****************************************3.输入与验证********************************************
//使用表单提交数据完成模型的对象操作
//  主要包括:1.表单提交2.表单验证3.错误提示4.自定义验证规则5.控制器验证

//1.表单提交
//首先创建一个时涂抹办文件application/demoObject/view/index/create.html
//      demoObject(目录名)/view(文件夹名)/index(对应类名,同时文件夹名一致)/create.html(方法名与html文件名一致)
//代码见application/demoObject/view/index/create.html文件

//添加对应create方法
    public function create(){//http://localhost/tp5/public/index/demoObject/index/create
        return view();
        /*
         view方法是系统封装的助手函数用于快速渲染模板文件,此处没有传入模板文件,则按照系统默认的解析规则会自动渲染当前操作方法对应的模板文件,
            所以和下面的方式是一致的
        return view('index/create');
        */
    }



//2.表单验证&3.错误提示&4.自定义验证规则
//给表单提交添加数据验证
//  添加一个User验证器(application/demoObject/validate/User.php)
//  对验证器进行定义
//使用验证器则在save方法前添加一个validate参数即可

//新增add3方法
    public function add3()
    {
        $user = new UserModel();
        if ($user->allowField(true)->validate(true)->save(input('post.'))){
            //$user->allowField(true)->save(input('post.'))     原始样式插入
            //$user->allowField(true)->validate(true)->save(input('post.')) 此为有验证的调用


            return  '用户['.$user->nickname.':'.$user->id.']新增成功';
        }else{
            return $user->getError();
        }
    }


//5.控制器验证
//新增add4方法,需要测试时修改为add3方法
    public function add4()
    {
        $data = input('post.');
        //数据验证
        $result = $this->validate($data,'User');
        if (true !== $result){
            return $result;
        }

        //如果一些个别的验证没有在验证器里定义,也可以使用静态方法单独处理,
        //  例如下面对birthday字段单独处理是否是一个有效的日期格式
        $check = Validate::is($data['birthday'],'date');
        if (false === $check){
            return '生日日期格式不合法';
        }

        $user = new UserModel();
        //数据保存
        if ($user->allowField(true)->save(input('post.'))){
            return  '用户['.$user->nickname.':'.$user->id.']新增成功';
        }else{
            return $user->getError();
        }
    }





//****************************************4.关联********************************************
//User模型内进行修改
//新建Profile关联模型类



//————————————————————————一对一关联————————————————————————
//1.User模型添加关联后,控制器关联写入方法
    public function add5(){//http://localhost/tp5/public/index/demoObject/index/add5
        $user = new UserModel();
        $user->nickname = '流年';
        $user->email = 'thinkphp@qq.com';
        $user->birthday = strtotime('1997-03-05');
        if ($user->save()){
            //写入关联数据
            $profile = new Profile();
            $profile->truename = '刘念';
            $profile->birthday = $user->birthday;
            $profile->address = '中国上海';
            $profile->email = $user->email;
            $user->profile()->save($profile);
            return  '用户['.$user->nickname.':'.$user->id.']新增成功';
        }else{
            return $user->getError();
        }
    }
    //关联模型的写入调用了profile()方法,该方法返回的是一个Relation对象,执行save方法会自动传入当前模型User的主键作为关联键值,
    //  所以不需要手动传入Prodile模型的user_id属性


    //save方法也可以使用数组而不是Profile对象,如
    public function add6(){//http://localhost/tp5/public/index/demoObject/index/add6
        $user = new UserModel();
        $user->nickname = '流年';
        $user->email = 'thinkphp@qq.com';
        $user->birthday = strtotime('1997-03-05');
        if ($user->save()){
            //写入关联数据
            $profile['truename'] = '刘念';
            $profile['birthday'] = $user->birthday;
            $profile['address'] = '中国上海';
            $profile['email'] = $user->email;
            $user->profile()->save($profile);
            return  '用户['.$user->nickname.':'.$user->id.']新增成功';
        }else{
            return $user->getError();
        }
    }



//2.关联查询:
//一对一的关联查询,直接把关联对象当成属性来用即可:如
    public function read3($id){//http://localhost/tp5/public/index/demoObject/index/read3/id/21
        $user = UserModel::get($id);
        echo $user->nickname . '<br />';
        echo $user->email . '<br />';
        echo $user->profile->truename . '<br />';
        echo $user->profile->address . '<br />';
    }
//  以上关联查询的时候,只有在获取关联对象($user->profile)的时候才会进行实际的关联查询,缺点是会可能进行多次查询,
//      但可以使用预载入查询来提高查询性能,对于一对一关联来说,只需要进行一次查询即可获取关联对象数据,如
    public function read4($id){//http://localhost/tp5/public/index/demoObject/index/read4/id/21
        $user = UserModel::get($id,'profile');
        echo $user->nickname . '<br />';
        echo $user->email . '<br />';
        echo $user->profile->truename . '<br />';
        echo $user->profile->address . '<br />';
    }


//3.关联更新
//一对一的关联更新如下:
    public function update3($id){//http://localhost/tp5/public/index/demoObject/index/update3/id/21
        $user = UserModel::get($id);
        $user->nickname = '夏夜';
        if ($user->save()){
            //更新关联数据
            $user->profile->email = 'shaye@qq.com';
            $user->profile->save();
            return '用户['.$user->nickname.':'.$user->id.']更新成功';
        }else{
            return $user->getError();
        }
    }



//4.关联删除
    public function delete3($id){//http://localhost/tp5/public/index/demoObject/index/delete3/id/21
        $user = UserModel::get($id);
        if ($user->delete()){
            //删除关联数据
            $user->profile->delete();
            return '用户['.$user->nickname.':'.$user->id.']删除成功';
        }else{
            return $user->getError();
        }
    }





//————————————————————————一对多关联————————————————————————
//1.User模型添加关联后,控制器关联新增方法
    public function add7(){//http://localhost/tp5/public/index/demoObject/index/add7
        $user = UserModel::get(21);
        if ($user){
            $book = new Book();
            $book->title = 'ThinkPHP快速入门';
            $book->publish_time = '2016-08-06';
            $user->bookList()->save($book);
            return  '添加Book成功';
        }else{
            return '用户不存在';
        }
    }

    //对于一对多关联,也可以批量增加数据,如
    public function add8(){//http://localhost/tp5/public/index/demoObject/index/add8
        $user = UserModel::get(21);
        if ($user){
            $books = [
                ['title' => 'ThinkPHP快速入门','publish_time'=>'2016-08-06'],
                ['title' => 'ThinkPHP开发手册','publish_time'=>'2016-05-06'],
            ];
            $user->bookList()->saveAll($books);
            return  '添加Book成功';
        }else{
            return '用户不存在';
        }
    }



//2.关联查询:
//可以直接调用模型的属性获取全部关联数据:如
    public function read5($id){//http://localhost/tp5/public/index/demoObject/index/read5/id/21
        $user = UserModel::get($id);
        $books = $user->bookList();
        dump($books);
    }
//      一对多同样可以使用预载入查询
    public function read6($id){//http://localhost/tp5/public/index/demoObject/index/read6/id/21
        $user = UserModel::get($id,'bookList');
        $books = $user->bookList();
        dump($books);
    }
//    一对多预载入查询会在原先延迟查询的基础上增加一次查询,可以解决N+1次查询问题
//        如果要过滤查询,可以调用关联方法:
    public function read7(){//http://localhost/tp5/public/index/demoObject/index/read7
        $user = UserModel::get(21);
        //获取status为1的关联数据
        $books = $user->bookList()->where('status',1)->select();
        dump($books);

        echo '-----------------------------'.'<br />';
        //获取作者写的某本书
        $book = $user->bookList()->getByTitle('ThinkPHP开发手册');
        dump($book);
    }
//还可以根据关联函数来查询当前模型数据,如:
    public function read8(){//http://localhost/tp5/public/index/demoObject/index/read8
        //查询写过书的作者
        $user = UserModel::has('bookList')->select();
        dump($user);

        echo '-----------------------------'.'<br />';
        //查询写过三本以上书的作者
        $user = UserModel::has('bookList','>=',3)->select();
        dump($user);

        echo '-----------------------------'.'<br />';
        //查询写过ThinkPHP开发手册的作者
        $user = UserModel::has('bookList',['title'=>'ThinkPHP开发手册'])->select();
        dump($user);
    }



//3.关联更新
//一对多的关联更新如下:
    public function update4($id){//http://localhost/tp5/public/index/demoObject/index/update4/id/21
        $user = UserModel::get($id);
        $book = $user->bookList()->getByTitle('ThinkPHP开发手册');
        $book->title = '幻想乡缘起';
        if ($book->save()){
            return '更新成功';
        }else{
            return '更新失败';
        }
    }

    //使用查询构建器的update方法进行更新(但可能无法触发关联模型的事件)
    public function update5($id){//http://localhost/tp5/public/index/demoObject/index/update5/id/21
        $user = UserModel::get($id);
        $book = $user->bookList()->where('title','ThinkPHP5开发手册')->update(['title'=>'ThinkPHP快速入门']);
        if ($book){
            return '更新成功';
        }else{
            return '更新失败';
        }
    }


//4.关联删除
    //删除部分关联数据
    public function delete4($id){//http://localhost/tp5/public/index/demoObject/index/delete4/id/21
        $user = UserModel::get($id);
        $book = $user->bookList()->getByTitle('ThinkPHP开发手册');
        $book->delete();
    }
    //删除所有的关联数据
    public function delete5($id){//http://localhost/tp5/public/index/demoObject/index/delete5/id/21
        $user = UserModel::get($id);
        if ($user->delete()){
            $user->bookList()->delete();
        }
    }





//————————————————————————多对多关联————————————————————————
//1.User模型添加关联后,控制器关联新增方法
    public function add9(){//http://localhost/tp5/public/index/demoObject/index/add9
        //给某个用户增加编辑角色,并且由于这个角色还没创建过,所以可以使用如下方式:
        $user = UserModel::getByNickname('流年');

        //新增用户角色,,并自动写入枢纽表
        if ($user->roles()->save(['name'=>'editor','title'=>'编辑'])){
            return '用户角色新增成功';
        }else{
            return '用户角色新增失败';
        }
    }

    //也可以批量新增用户的角色
    public function add10(){//http://localhost/tp5/public/index/demoObject/index/add10
        //给某个用户增加编辑角色,并且由于这个角色还没创建过,所以可以使用如下方式:
        $user = UserModel::getByNickname('流年');
        //新增用户角色,,并自动写入枢纽表
        if ($user->roles()->saveAll([
            ['name'=>'leader','title'=>'领导'],
            ['name'=>'admin','title'=>'管理员'],
        ])){
            return '用户角色新增成功';
        }else{
            return '用户角色新增失败';
        }
    }

    //如果给另外一个用户增加编辑角色,由于该角色已经存在了,所以只需要使用attach方法增加枢纽表的关联数据
    //关联新增数据
    public function add11(){//http://localhost/tp5/public/index/demoObject/index/add11
        $user = UserModel::getByNickname('夏夜');
        $role = Role::getByName('editor');
        //添加枢纽表数据
        if ($user->roles()->attach($role)){
            return '用户角色新增成功';
        }else{
            return '用户角色新增失败';
        }
    }

    //或者直接使用角色id添加关联数据
    //关联新增数据
    public function add12(){//http://localhost/tp5/public/index/demoObject/index/add12
        //给某个用户增加编辑角色,并且由于这个角色还没创建过,所以可以使用如下方式:
        $user = UserModel::getByNickname('夏夜');
        //添加枢纽表数据
        if ($user->roles()->attach(1)){
            return '用户角色新增成功';
        }else{
            return '用户角色新增失败';
        }
    }



//2.关联查询:
//获取用户流年的所有角色的话,直接使用
    public function read9($id){//http://localhost/tp5/public/index/demoObject/index/read9/id/19
        $user = UserModel::getByNickname('流年');
        dump($user->roles());
    }

    //同样支持多对多关联使用预载入查询
    public function read10($id){//http://localhost/tp5/public/index/demoObject/index/read10/id/19
        $user = UserModel::get(19,'roles');
        dump($user->roles());
    }


//3.关联删除
    //如果需要解除用户的管理角色,可以使用detach方法删除关联的枢纽表数据,但不会删除关联模型数据,如
    //关联删除数据
    public function delete6($id){//http://localhost/tp5/public/index/demoObject/index/delete6/id/19
        $user = UserModel::get($id);
        $role = Role::getByName('admin');
        //删除关联数据 但不删除关联模型数据
        $user->roles()->detach($role);
        return '用户角色删除成功';
    }

    //如果有必要,也可以删除枢纽表的同时删除关联模型,下面的例子在解除用户的编辑角色同时删除编辑这个角色身份
    public function delete7($id){//http://localhost/tp5/public/index/demoObject/index/delete7/id/19
        $user = UserModel::get($id);
        $role = Role::getByName('editor');
        //删除关联数据 同时删除关联模型数据
        $user->roles()->detach($role,true);
        return '用户&角色删除成功';
    }




//****************************************5.模型输出********************************************
    /*
    模型输出可以输出模型的实例对象为数组或者JSON
    输出数组
    隐藏属性
    指定属性
    追加属性
    输出JSON
    */



//1.输出数组
    public function readUser($id){//http://localhost/tp5/public/index/demoObject/index/readUser/id/21
        $user = UserModel::get($id);
        dump($user);
    }

//2.隐藏属性
    //如果输出的时候需要隐藏某些属性,可以使用:
    public function readUser1($id){//http://localhost/tp5/public/index/demoObject/index/readUser1/id/21
        $user = UserModel::get($id);
        dump($user->hidden(['create_time','update_time'])->toArray());
    }

//3.指定属性
    //指定一些属性的输出
    public function readUser2($id){//http://localhost/tp5/public/index/demoObject/index/readUser2/id/21
        $user = UserModel::get($id);
        dump($user->visible(['id','nickname','email'])->toArray());
    }


//4.追加属性
    //如果定义了一些非数据库字段的读取,如:
    //  User模型中对status添加修改器,如果我们需要输出user_status属性数据的话,可以使用append方法,如:
    public function readUser3($id){//http://localhost/tp5/public/index/demoObject/index/readUser3/id/21
        $user = UserModel::get($id);
        dump($user->append(['user_status'])->toArray());
        /*User模型需要添加以下修改器,设置参数读取
        protected function getUserStatusAttr($value,$data){//status属性读取器    $data为自动导入的User模型数据
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$data['status']];//使用例子:控制器中直接调用,无需传参,模型自动获取echo $user->user_status.'<br />';
        }
        */
    }


//5.输出JSON
//对API开发而言,经常需要返回JSON格式的数据,修改read操作方法改成JSON输出

//读取用户数据输出JSON
    public function readUser4($id){//http://localhost/tp5/public/index/demoObject/index/readUser4/id/21
        $user = UserModel::get($id);
        echo $user->toJson();
    }

//或者采用更简单的方法输出JSON,下面方式等效:
    public function readUser5($id){//http://localhost/tp5/public/index/demoObject/index/readUser5/id/21
        echo UserModel::get($id);
    }




//****************************************6.视图和模板********************************************
/*
前面只是在控制器方法里面直接输出而没有使用视图模板功能,从现在开始来了解如何把变量赋值到模板,并渲染输出,主要内容包括:
模板输出
分页输出
公共模板
模板定位
模板布局
标签定制
输出替换
渲染内容
助手函数
*/

//注意:需要导入think\Controller和继承Controller,并且创建对应的模板(方法名+.html文件)

//1.模板输出
    //获取用户列表并输出,此处需要在view/index创建show.html文件,具体代码在文件中
    public function show(){//http://localhost/tp5/public/index/demoObject/index/show
        $list = UserModel::all();
        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch();
        /*
        这里的控制器继承了\think\Controller类,该类对视图类的方法进行了封装,所以可以再无需实例化视图的情况下,直接调用视图类的相关方法,如

        方法              描述
        assign          模板变量复制
        fetch           渲染模板文件
        display         渲染内容
        engine          初始化模板引擎
        */
        /*
        其中assign和fetch是最常用的两个方法:
            assign方法可以把任何类型的变量赋值给模板,关键在于模板中如何输出,不同的变量类型需要采用不同的标签输出
            fetch方法默认渲染输出的模板文件应该是当前控制器和操作对应的模板,在上例中也就是application/demoObject/view/index/show.html
        */

        //具体调用和实现需结合show.html文件查看
    }

//2.分页输出
    //获取用户列表并分页输出,此处需要在view/index创建showPage.html文件,具体代码在文件中
    public function showPage(){//http://localhost/tp5/public/index/demoObject/index/showPage
        //分页显示输出,每页显示3条数据
        $list = UserModel::paginate(3);
        $this->assign('list',$list);
        return $this->fetch();

        //具体调用和实现需结合showPage.html文件查看
    }

//3.公共模板
//为了避免重复定义模板,可以把模板的公共的头部和尾部分离出来,便于维护
/*
把模板文件拆成三部分
application/demoObject/view/index/header.html
application/demoObject/view/index/indexBody.html
application/demoObject/view/index/footer.html

具体代码看文件
*/
    //使用公共头部尾部模板文件,其他和show.html一致
    public function indexBody(){//http://localhost/tp5/public/index/demoObject/index/indexBody
        $list = UserModel::all();
        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch();
    }

//4.模板定位
//fetch方法的第一个参数表示渲染的模板文件或者模板表达式
//  通常使用模板表达式,而不需要使用完整的文件名

//  模板文件名可以随意命名,如果把show.html文件改成:
//      application/demoObject/view/index/list.html
//      show操作方法中的fetch方法需要改成:
//      return $this->fetch('list');

//如果show操作方法中的fetch方法改成:
//      return $this->fetch('user/list');
//      那么实际的渲染模板文件则是:
//      application/demoObject/view/user/list.html

//当然,可以设置更多级别的目录

//一些和模板定位相关的设置参数能够调整模板文件的位置和名称
//  通常来说,模板相关的参数可以直接在配置文件中设置template参数,默认配置如下:
/*

    'template' => [
        //模板引擎文件类型  支持  php think 支持扩展
        'type' => 'Think',
        //模板路径
        'view_path' => '',
        //模板后缀
        'view_suffix' => '.html',
        //模板文件名分隔符
        'view_depr' => DS,
        //模板引擎普通标签开始标记
        'tpl_begin' => '{',
        //模板引擎普通标签结束标记
        'tpl_end' => '}',
        //标签库标签开始标记
        'taglib_begin' => '{',
        //标签库标签结束标记
        'taglib_end' => '}',
    ],

*/
//view_path 参数决定了模板文件的根目录,如果没有设置的话系统会默认使用当前模块的视图目录view
//  如果希望自定义模板文件的位置、命名和后缀,可以对模板文件参数稍加修改,如
/*通过配置把当前渲染的模板文件移动到了    ROOT_PATH/template/index/user_index.tpl

    'template' => [
      //模板引擎文件类型  支持  php think 支持扩展
      'type' => 'Think',
      //模板路径
      'view_path' => '../template/index/',
      //模板后缀
      'view_suffix' => '.tpl',
      //模板文件名分隔符
      'view_depr' => '_',
     ],
*/


//5.模板布局
//使用模板布局进一步简化模板定义

//首先定义一个布局模板文件,放到application/demoObject/view/index/layout.html  内容如下:
/*
{include file="index/header"/}
    {__CONTENT__}
{include file="index/footer" /}
*/
    //之后定义模板文件layoutShow.html   位于application/demoObject/view/index/layoutShow.html
    //具体内容见layoutShow.html,若要见全局配置内容也在layoutShow.html
    public function layoutShow(){//http://localhost/tp5/public/index/demoObject/index/layoutShow
        $list = UserModel::all();
        $this->assign('list',$list);
        $this->assign('count',count($list));

        //如果想动态使用布局
//        $this->view->engine->layout('index/layout','[__CONTENT__]');
        //注意,这里调用的是$this->view->engine对象的layout方法,并不是所有的模板引擎都支持布局功能,如果使用的是其它的模板引擎,可能不提供layout方法
        //如果配置方式开启了布局模板,也可以使用该方法临时关闭布局
//        $this->view->engine->layout(false);   或者在模板文件(layoutSHow.html)开头加上{__NOLAYOUT__}标签

        return $this->fetch();
    }


//6.标签定制
//可以设置模板标签的定界符
/*
    'template' => [
        //模板引擎文件类型  支持  php think 支持扩展
        'type' => 'Think',
        //模板路径
        'view_path' => '../template/index/',
        //模板后缀
        'view_suffix' => '.html',
        //模板文件名分隔符
        'view_depr' => '_',
        //模板引擎普通标签开始标记
        'tpl_begin' => '{',
        //模板引擎普通标签结束标记
        'tpl_end' => '}',
        //标签库标签开始标记
        'taglib_begin' => '<',
        //标签库标签结束标记
        'taglib_end' => '>',
    ],
*/
//并且修改layoutShow.html标签如下:
/*
<h2>用户列表({$count})</h2>
<div class="info">
{volist name="list" id="user"}
    ID:{$user.id}<br />
    昵称:{$user.nickname}<br />
    邮箱:{$user.email}<br />
    生日:{$user.birthday}<br />
{/volist}
</div>
*/



//7.输出替换
//为了更加清晰,需要把资源文件独立出来,并在模板文件中引入,如,增加public/static/common.css 文件
/*
body{
            color: #333333;
            font:16px Verdana,"Helvetica Neue",helvetica,Arial,'Microsoft YaHei',sans-serif;
            margin: 0px;
            padding: 20px;
        }
        a{
            color: #868686;
            cursor: pointer;
        }
        a:hover{
            text-decoration: underline;
        }
        h2{
            color: #4288ce;
            font-weight: 400;
            padding: 6px 0;
            margin: 6px 0 0;
            font-size: 28px;
            border-bottom: 1px solid #EEEEEE;
        }
        div{
            margin: 8px;
        }
        .info{
            padding: 12px 0;
            border-bottom: 1px solid #EEEEEE;
        }
        .copyright{
            margin-top: 24px;
            padding: 12px 0;
            border-top: 1px solid #EEEEEE;
        }
*/

//在headerStyle.html文件引入资源文件
/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>[title]</title>

    <link charset="utf-8" rel="stylesheet" href="/static/common.css">
</head>
<body>
*/
//在headerStyle.html引入资源文件,达到效果与header.html一致
/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>[title]</title>

    <link charset="utf-8" rel="stylesheet" href="/static/common.css">
</head>
<body>
*/

    public function styleShow(){//http://localhost/tp5/public/index/demoObject/index/styleShow
        $list = UserModel::all();
        $this->assign('list',$list);
        $this->assign('count',count($list));

        //但是,如果部署的目录变化的话,资源文件的路径也会变化,所以采用替换输出,使得资源文件的引入动态化
        //  可以在输出之前对解析后的内容进行替换,最终输出的时候,会自动进行__PUBLIC__替换
        $this->view->replace([
            '__PUBLIC__' => '/static',
        ]);
        return $this->fetch();
    }




//8.渲染内容
//有时候,并不需要模板文件,而是直接渲染内容或者读取数据库中存储的内容,控制器修改如下
    public function displayShow(){//http://localhost/tp5/public/index/demoObject/index/displayShow
        $list = UserModel::all();
        $this->assign('list',$list);
        $this->assign('count',count($list));


        //$content与模板文件部分内容相似,需要将特殊字符转义和位置替换等
        $content = <<<EOT
              
        <style>
        body{
            color: #333333;
            font:16px Verdana,"Helvetica Neue",helvetica,Arial,'Microsoft YaHei',sans-serif;
            margin: 0px;
            padding: 20px;
        }
        a{
            color: #868686;
            cursor: pointer;
        }
        a:hover{
            text-decoration: underline;
        }
        h2{
            color: #4288ce;
            font-weight: 400;
            padding: 6px 0;
            margin: 6px 0 0;
            font-size: 28px;
            border-bottom: 1px solid #EEEEEE;
        }
        div{
            margin: 8px;
        }
        .info{
            padding: 12px 0;
            border-bottom: 1px solid #EEEEEE;
        }
        .copyright{
            margin-top: 24px;
            padding: 12px 0;
            border-top: 1px solid #EEEEEE;
        }

    </style>
    <h2>用户列表({\$count})</h2>
    <div class="info">
    {volist name="list" id="user"}
        ID:{\$user.id}<br />
        昵称:{\$user.nickname}<br />
        邮箱:{\$user.email}<br />
        生日:{\$user.birthday}<br />
    {/volist}
    </div>
    
    <div class="copyright">
        <a title="官网" href="http://www.baidu.com"></a>
        <span>V5</span>
        <span>{测试超链接}</span>
    </div>

EOT;

        return $this->display($content);
        //display方法用于渲染内容而不是模板文件输出,和直接使用echo输出的区别是display方法输出的内容支持模板标签的解析
    }



//9.助手函数
//可以使用系统提供的助手函数view简化模板渲染输出(注意不适用于内容渲染输出)
//前面的模板渲染代码可以改为
    public function helpShow($id=''){
        //http://localhost/tp5/public/index/demoObject/index/helpShow/id/21
        //未测试
        $user = UserModel::get($id);

        return view('',['user'=>$user],['__PUBLIC__' => '/static']);
        //使用view助手函数,不需要继承think\Controller类。该方法的第一个参数就是渲染的模板表达式
    }




}
