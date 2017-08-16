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
            return json(["error" => "用户不存在"],404);
        }
    }

}