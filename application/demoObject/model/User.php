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




//*****************************读取器和修改器*************************************

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
        return '夏夜' == $data['nickname']?1:2;
    }
    protected function getStatusAttr($value){//status属性读取器
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$value];
    }




//*****************************查询范围*********************************

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







//********************************关联**************************************
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




















































}