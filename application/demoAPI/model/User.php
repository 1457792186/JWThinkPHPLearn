<?php
namespace app\demoAPI\model;


use think\Model;

class User extends Model{

    public function profile(){
        return $this->hasOne('Profile');
    }
}