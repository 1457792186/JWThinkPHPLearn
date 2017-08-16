<?php
namespace app\demoAPI\controller\v1;

use  app\demoAPI\model\User as UserModel;

class User{
    //    获取用户信息
    public function  read($id = 0){
        $user = UserModel::get($id);
        if ($user){
            return json($user);
        }else{
            return json(["error" => "用户不存在"],404);
        }
    }

}