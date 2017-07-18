<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/7/18
 * Time: 下午4:02
 */

namespace app\demoObject\model;

use think\Model;

/*数据库表语句
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

class Book extends Model
{
    protected $type = [
        'publish_time' => 'timestamp:Y-m-d',
    ];

    //开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    //定义自动完成属性
    protected $insert = ['status'=>1];


    //如果需要定义对应的关联,则可以使用belongsTo方法
    public function user(){
        return $this->belongsTo('User');
    }
}