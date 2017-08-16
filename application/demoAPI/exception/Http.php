<?php
namespace app\demoAPI\exception;

//如果希望由API后台处理异常,并且直接接管系统的所有异常信息输出json错误信息,可以自定义一个异常处理

use think\exception\Handle;
use think\exception\HttpException;

class Http extends Handle{
    public function render(\Exception $e)
    {
        if ($e instanceof HttpException){
            $statusCode = $e->getStatusCode();
        }

        if (!isset($statusCode)){
            $statusCode = 500;
        }

        $result = [
            'code' => $statusCode,
            'msg' => $e->getMessage(),
            'time' => $_SERVER['REQUEST_TIME'],
        ];

        return json($result,$statusCode);
    }
//    之后再配置文件中修改异常处理handle参数为自定义的异常类
//      'exception_handle' => '\app\demoAPI\exception\Http',


}
