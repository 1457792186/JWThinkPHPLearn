<?php
namespace app\demoAPI\controller\v2;

use  app\demoAPI\model\User as UserModel;

class User{
    //    获取用户信息
    public function  read($id = 0){
        $user = UserModel::get($id,'profile');//包含了用户的关联文档信息
        if ($user){
            return json($user);
        }else{
            //接管Http异常处理后(exception下的Http.php文件处理),系统自动处理为json格式输出到客户端
            //抛出Http异常,并发送404状态码
            abort(404,'用户不存在');
        }
    }

}