<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/7/18
 * Time: 下午6:06
 */

namespace app\demoObject\model;

use think\Model;

/*think_role表
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

class Role extends Model
{

    //如果需要定义对应的关联,则可以使用belongsToMany方法
    //  belongsToMany(关联模型名,中间表名,关联外键,关联模型主键,别名定义)
    public function user(){
        return $this->belongsToMany('User','think_access');
    }

}