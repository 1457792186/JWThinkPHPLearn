<?php
//调用IndexAutoBind

namespace app\demoRequest\controller\IndexAutoBindUse;
use app\demoRequest\controller\IndexAutoBind;
use think\Request;

class IndexAutoBindUse extends IndexAutoBind{
    //访问下面地址:http://localhost/tp5/public/index/demoRequest/IndexController/requestHello
    public function index(Request $request){
        echo $request->user->id;
        echo $request->user->name;
    }
}

?>