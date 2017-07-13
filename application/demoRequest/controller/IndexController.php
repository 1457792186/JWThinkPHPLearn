<?php
namespace app\demoRequest\controller;

//继承think\Controller
use think\Controller;
class IndexController extends Controller{
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/IndexController/requestHello
    public function requestHello($name = '233'){
        echo 'url:'.$this->request->url().'<br />';
        return'Hello'.$name.'!';
    }
}

?>