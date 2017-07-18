<?php
namespace app\demoObject\validate;

//  添加一个User验证器
use think\Validate;

class User extends Validate{
    //验证规则
    /*
    protected $rule = [
        'nickname' => 'require|min:5',
        'email' => 'require|email',
        'birthday' => 'dateFormat:Y-m-d',
    ];
    */
    //添加了三个属性的验证规则,对属性可以使用多个验证规则,除非使用了require开头的规则,否则所有验证都是可选的(有值才验证),
    //  多个验证之间使用|分割,并且按照先后顺序依次进行验证,一旦某个规则验证失败,后续的规则就不会再进行验证(除非设置批量验证方式则统一返回所有的错误信息)

    //也可以使用数组方式进行验证规则的定义
    /*
    protected $rule = [
        'nickname' => ['require','min'=>5],
        'email' => ['require','email'],
        'birthday' => ['dateFormat'=>'Y-m-d'],
    ];
    */

    //使用验证器则在save方法前添加一个validate参数即可





    //错误提示
    //1.如果只是希望修改属性名称,则可以使用验证规则定义的方式
    /*
    protected $rule = [
        'nickname|昵称' => ['require','min'=>5],
        'email|邮箱' => ['require','email'],
        'birthday|生日' => ['dateFormat'=>'Y-m-d'],
    ];
    */

    //2.如果希望定义完整的错误提示信息,可以使用:
    /*

    */
    protected $rule = [
        ['nickname','require|min:5','昵称必须|昵称不能短于5字符'],
        ['email','require|email','邮箱必须|邮箱格式错误'],
        ['birthday','dateFormat:Y-m-d','生日格式必须为年-月-日'],
    ];





    //自定义规则验证:
    //系统的验证规则可以满足大部分场景,但是有时也需要特殊的验证规则,如,需要验证邮箱必须为thinkphp.cn域名的话,可以添加验证规则如下:
    protected function checkMail($value,$rule){//验证邮箱格式,是否符合指定的域名
        $result = preg_match('/^\w+([-+.]\w+)*@'.$rule.'$/',$value);

        //邮箱也可以自定义错误信息
        if ($result){
            return true;
        }else{
            return '邮箱只能是'.$rule.'域名';
        }
    }
    //对应的验证规则需要修改为:
    /*例子:验证邮箱必须为thinkphp.cn域名
    protected $rule = [
        ['nickname','require|min:5','昵称必须|昵称不能短于5字符'],
        ['email','require|checkMail:thinkphp.cn','邮箱必须|邮箱格式错误'],
        ['birthday','dateFormat:Y-m-d','生日格式必须为年-月-日'],
    ];
    */


}