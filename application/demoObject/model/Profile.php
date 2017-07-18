<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/7/18
 * Time: 下午2:09
 */

namespace app\demoObject\model;

use think\Model;

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

class Profile extends Model
{
    protected $type = [
        'birthday' => 'timestamp:Y-m-d',
    ];

    //如果关联操作都是基于User模型的话,Profile模型中并不需要定义关联方法

    //如果需要基于Profile模型来进行关联操作,则需要在Profile模型中定义对应的BELONGS_TO关联,如下:
    public function user(){
        //档案 BELONGS TO 关联用户
        return $this->belongsTo('User');
        //belongsTo方法和hasOne一样,有5个参数
        //  belongsTo(关联模型名,关联外键,主键,别名定义,join类型)
    }
}