<?php

namespace app\admin\validate;

use think\Validate;

class Author extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'name'=>'require|unique:Author'
    ];
    /**
     * 提示消息
     */
    protected $message = [
        'name.require' =>'作者不能为空',
        'name.unique' =>'作者已存在',
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => [],
        'edit' => [],
    ];
    
}
