<?php
namespace app\demoAPI\model;

use think\Model;

class Profile extends  Model{
    protected $type = [
        'boryhday' => 'timestamp:Y-m-d',
    ];
}