<?php
//动态绑定属性
//可以给Request请求对象绑定属性,方便全局调用
namespace app\demoRequest\controller;
use app\demoRequest\model\User;
use think\Controller;
use think\Request;
use think\Session;


class IndexAutoBind extends Controller{
    //访问下面地址:
    public function _initialize(){
        $user = User::get(Session::get('user_id'));
        Request::instance()->bind('user',$user);
    }
}

//IndexAutoBindUse.php中调用
?>