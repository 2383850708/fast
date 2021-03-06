<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*return [
    //别名配置,别名只能是映射到控制器且访问时必须加上请求的方法
    '__alias__'   => [
    ],
    //变量规则
    '__pattern__' => [
    ],
//        域名绑定到模块
//        '__domain__'  => [
//            'admin' => 'admin',
//            'api'   => 'api',
//        ],
];*/
use think\Route;
// 注册路由到index模块的News控制器的read操作
Route::get(':id','index/Article/info',['ext'=>'html'],['id'=>'\d+']);
Route::get('index/:id','index/Index/index',['ext'=>'html'],['id'=>'\d+']);
Route::get('category:id','index/Category/index',['ext'=>'html'],['id'=>'\d+']);


