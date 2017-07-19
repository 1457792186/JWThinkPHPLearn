<?php
namespace app\demoObject\model;

use think\Model;

class User extends Model
{
//    protected $table = 'think_user';
//    public $nickname = '';
//    public  $email = '';
//    public  $birthday = '';


    //如果当前模型类需要使用不同的数据库连接,可以定义模型的connection属性,如:
    //设置单独的数据库连接
    /*
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
    */




//*****************************1.读取器和修改器*************************************

//1.读取器:
//  之前读取用户生日的时候,使用了date()方法进行日期的格式处理输出,但是每次都需要这样处理会比较麻烦
//  使用读取器的功能就可以简化类似的数据处理操作,如,给User模型添加读取器的定义方法

//  读取器的命名规范是:
//  get + 属性名的驼峰命名 + Attr
    protected  function  getBirthdayAttr($birthday){
        //读取的是birthday属性
        return date('Y-m-d',$birthday);
    }
    //添加了一个getBirthdayAttr读取器方法用于读取User模型的birthday属性的值,该方法在读取bithday属性值的时候会自动执行
//  定义完修改器后,修改控制器的read操作方法,便可以直接输出birthday信息了

//  读取器还可以定义读取表中不存在的属性,例如把原始生日和转换的格式分开两个属性birthday和user_birthday
//      只需要定义user_birthday属性的读取方法
    protected  function  getUserBirthdayAttr($value,$data){
        //读取的是user_birthday属性    传入了data参数,因为user_birthday数据不存在,所以需要通过data参数读取
        //user_birthday读取器
        //使用例子:控制器中直接调用,无需传参,模型自动获取echo $user->user_birthday.'<br />';
        return date('Y-m-d',$data['birthday']);
    }


//2.修改器
//由于birthday属性是时间戳格式的,因此必须在写入数据前进行时间戳转换,前面使用的方法是每次赋值的时候进行转换处理
//      $user['birthday'] = strtotime('1995-03-05');
//为了避免每次都进行时间格式的转换操作,可以定义修改器方法来自动处理,修改User模型如下

//  修改器的命名规范是:
//  set + 属性名的驼峰命名 + Attr
        protected  function  setBirthdayAttr($value){
            return strtotime($value);
        }





//3.类型转换和自动完成

//3.1类型转换
//对于时间戳,还可以进一步简化,这里需要用到类型强制转换的功能,在User模型类中添加定义
    protected $dateFormat = 'Y/m/d';
    protected $type = [
        //设置birthday为时间戳类型
        'birthday' => 'timestamp',
        //如果不设置模型的dateFormat属性,可以设置日期格式,如
        //      'birthday' => 'timestamp:Y/m/d'
    ];
//不需要任何修改器和读取器就可以完成相同的功能
//对于timestamp和datetime类型,如果不设置模型的dateFormat属性,默认的日期格式是Y-m-d H:i:s,或者也可以显示的设置日期格式如timestamp:Y/m/d

//对于简单的数据格式转换之类的处理,设置类型转换比定义修改器和读取器更加方便
/*ThinkPHP5支持的转换类型
类型              描述
integer         整型
float           浮点型
boolean         布尔型
array           数组
json            JSON类型
object          对象
datetime        日期时间
timestamp       时间戳
serialize       序列化
*/



//3.2自动时间戳
//对于固定的时间戳和时间日期型的字段,比如文章的创建时间、修改时间等字段,还有比设置类型转换更加简单的方法,
//  尤其是所有的数据表统一处理的话,只需要在数据库配置文件(application\database.php)添加设置:
//      'auto_timestamp' => true,                   开启自动写入时间戳字段

//  再次访问时会发现系统已经自动写入了think_user数据表中的create_time、update_time字段,
//      如果自动写入的时间戳字段不是这两个,需要修改模型类的属性定义,如:
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

//如果个别数据表不需要自动写入时间戳字段的话,也可以在模型内直接关闭
    protected $autoWriteTimestamp = false;
//    重新生成的数据已经没有自动写入时间戳了,而是数据库默认值写入

//默认的时间戳字段类型是整型,如果需要使用其他的时间字段类型,可以做如下设置:
//  指定自动写入的时间戳类型为dateTime类型
//    protected $autoWriteTimestamp = 'datetime';

//如果全局的自动时间戳类型是统一的,也可以在数据库配置文件中设置:
//  开启自动写入时间戳字段
//  'auto_timestamp' => 'datetime',
//  设置后,think_user表中的create_time和update_time字段类型就必须更改为datetime类型
//  支持设置时间戳类型包含:datetime、date和timestamp





//3.3自动完成
//系统已经自动写入了think_user数据表中的create_time、update_time字段,如果我们希望自动写入其他字段,则可以使用自动完成功能,
//  例如下面实现新增的时候自动写入status字段
//    protected $insert = ['status'=>1];

/*除了insert属性之外,自动完成共有三个属性定义                 属性
auto                                                    新增及更新的时候自动完成的属性数组
insert                                                  仅新增的时候自动完成的属性数组
update                                                  仅更新的时候自动完成的属性数组
*/
//自动完成属性里面一般来说仅仅需要定义属性的名称,然后配合修改器或者类型转换来一起完成,
//  如果写入的是一个固定的值,就无需使用修改器

//如果status不是固定的,而是需要条件判断,那么可以定义修改器来配合自动完成
    protected $insert = ['status'];//定义自动完成的属性
    protected  function setStatusAttr($value,$data){//status属性修改器
        return '夏夜' == $data['nickname']?2:1;
    }
    protected function getStatusAttr($value){//status属性读取器
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$value];
    }


//    或者可以设置user_status属性来另外添加输出,成为模型的追加属性,如在controller/index.php中5.模型输出-追加属性调用user_status
    protected function getUserStatusAttr($value,$data){//status属性读取器    $data为自动导入的User模型数据
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$data['status']];//使用例子:控制器中直接调用,无需传参,模型自动获取echo $user->user_status.'<br />';
    }



//*****************************2.查询范围*********************************

//对于一些常用的查询条件,我们可以封装成查询范围来进行方便的调用
//如:邮箱地址为thinkphp@qq.com和status为1这两个常用查询条件,可以定义模型类的两个查询范围方法:
//查询方法的定义规范为:
//  scope + 查询范围名称

/*与上面重复的方法

//定义类型转换
protected $type = [
        //设置birthday为时间戳类型
        'birthday' => 'timestamp:Y/m/d'
    ];

//定义自动完成的属性
protected $insert = ['status'];

//status属性修改器
protected  function setStatusAttr($value,$data){
        return '夏夜' == $data['nickname']?1:2;
    }

//status属性读取器
protected function getStatusAttr($value){
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$value];
    }
*/
//email查询,支持额外参数
    protected function scopeEmail($query,$email='thinkphp@qq.com'){
        $query->where('email',$email);
    }
//status查询
    protected function scopeStatus($query){
        $query->where('status','1');
    }
//测试地址:http://localhost/tp5/public/index/demoObject/index/autoTest

//全局查询范围
//可以给模型定义全局的查询范围,在模型类添加一个静态的base方法即可,如,给模型类增加一个全局查询范围,用于查询状态为1的数据
    protected static function base($query){
        //查询状态为1的数据
        $query->where('status',1);
    }
    //当模型进行查询的时候,会自动带上全局查询范围的条件







//********************************3.关联**************************************
//关联的定义及基础用法:
/*
基本定义
一对一关联
    关联定义
    关联写入
    关联查询
    关联更新
    关联删除
    一对一多关联
        关联定义
        关联新增
        关联查询
        关联更新
        关联删除
    多对多关联
        关联定义
        关联新增
        关联删除
        关联查询
*/


//1.基本定义
//ThinkPHP5的关联采用了对象化的操作模式,无需继承不同的模型类,只要把关联定义成一个方法,
//  并且直接通过当前模型对象的属性名获取定义的关联数据

//例:如果有一个关联的模型对象Book,每个用户多本书,则需要定义关联方法,如
    //定义关联方法
    public function books(){//books方法是一个关联方法,方法名可随意命名,但要注意避免和User模型对象的字段属性冲突
        return $this->hasMany('Book');
        /*
        一般来说,关联关系包括:
        一对一关联:HAS_ONE以及相对的BELONGS_TO
        一对多关联:HAS_MANY以及相对的BELONGS_TO
        多对多关联: BELONGS_TO_MANY
        */
    }
    //实际获取关联数据的时候
    /*
    $user = User::get(5);   获取id=5的用户
    dump($user->books);     获取User对象的Book关联对象
    $user->books()->where('name','thinkphp')->find();   执行关联的Book对象的查询
    */



//2.一对一关联
//一对一关联是一种最简单的关联,比如每个用户都有一个身份证,每个班级都有一个班主任一样:
//首先,创建数据表think_user和think_profile
/*
think_profile表:
CREATE TABLE `db_study`.`think_profile` (
    `id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    `truename` VARCHAR(25) NOT NULL ,
    `birthday` INT(11) NOT NULL ,
    `address` VARCHAR(255) NULL DEFAULT NULL ,
    `email` VARCHAR(255) NULL DEFAULT NULL ,
    `user_id` INT(6) UNSIGNED NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/


//2.1关联定义
//以用户和档案的一对一关联为例,在User模型类中添加关联定义方法,然后在方法中调用hasOne方法即可:
    public function profile(){
        //return $this->hasOne('Profile');

        //hasOne有五个参数,分别是'
        //hasOne(关联模型名,关联外键,主键,别名定义,join类型)

        //默认的外键是当前模型名_id,主键则是自动获取,如果表设计符合这一规范,只需要设置关联的模型名即可

        //通常关联模型和当前模型都是相同的命名空间,如果关联模型在不同的控件,需要制定完整的类名,如
        //return $this->hasOne('\app\demoObject\Profile');

        //在关联查询的时候,默认使用当前模型的名称(小写)作为数据表别名,可以指定查询使用的数据表别名
        return $this->hasOne('Profile','user_id','id',['user'=>'member','profile'=>'info']);

        //要进行模型的关联操作,必须同时定义好关联模型Profile
    }



//2.2关联写入
//    控制器的add5操作


//2.3关联查询
//    控制器的read3操作


//2.4关联更新
//  控制器的update3操作


//2.5关联删除
//  控制器的delete3操作




//3.一对一多关联
//每个作者写有多本书就是一个典型的一对多关联,首先创建如下数据表:
/*
CREATE TABLE `db_study`.`think_book` (
    `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `title` VARCHAR(255) NOT NULL ,
    `publish_time` INT(11) UNSIGNED NULL DEFAULT NULL ,
    `create_time` INT(11) UNSIGNED NOT NULL ,
    `update_time` INT(11) UNSIGNED NOT NULL ,
    `status` TINYINT(1) NOT NULL ,
    `user_id` INT(6) NOT NULL , PRIMARY KEY (`id`)
) ENGINE = InnoDB;
*/


//3.1关联定义
    public function bookList(){
//        return $this->hasMany('Book');

        //hasMany有四个参数,分别是'
        //hasMany(关联模型名,关联外键,关联模型主键,别名定义)

        //默认的外键是当前模型名_id,主键则是自动获取,如果表设计符合这一规范,只需要设置关联的模型名即可

        //通常关联模型和当前模型都是相同的命名空间,如果关联模型在不同的控件,需要制定完整的类名,如
        //return $this->hasMany('\app\demoObject\Book');

        //在关联查询的时候,默认使用当前模型的名称(小写)作为数据表别名,可以指定查询使用的数据表别名
        return $this->hasMany('Book','user_id','id');

        //要进行模型的关联操作,必须同时定义好关联模型Book
    }

//3.2关联新增
//    控制器的add7操作


//3.3关联查询
//    控制器的read5操作


//3.4关联更新
//  控制器的update4操作


//3.5关联删除
//  控制器的delete4操作




//4.多对多关联
//一个用户会有多个角色,同时一个角色也会包含多个用户,这是一个多对多的关联,先创建一个think_role结构如下:
/*
CREATE TABLE `db_study`.`think_role` (
    `id` INT(5) NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(25) NOT NULL ,
    `title` VARCHAR(50) NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/
//多对多关联通常会有一个中间表,也成为枢纽表,所以需要创建一个用户角色的中间表,此处创建了一个think_access表,结构如下:
/*
CREATE TABLE `db_study`.`think_access` (
    `user_id` INT(6) UNSIGNED NOT NULL ,
    `role_id` INT(5) UNSIGNED NOT NULL
) ENGINE = InnoDB;
*/


//4.1关联定义
    //定义多对多关联
    public function roles(){
        //  belongsToMany(关联模型名,中间表名,关联外键,关联模型主键,别名定义)
        return $this->belongsToMany('Role','access');
        //要进行模型的关联操作,必须同时定义好关联模型Role    access为think_access表,因为已经定义了数据表前缀所以可写为access
    }

//    对于枢纽表并不需要创建模型类,在多对多关联关系中,并不需要直接操作枢纽表


//4.2关联新增
//    控制器的add9操作


//4.3关联查询
//    控制器的read9操作


//4.4关联删除
//  控制器的delete6操作





//********************************4.模型输出**************************************
//见controller/Index.php模型输出




















}