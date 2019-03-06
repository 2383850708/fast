<?php

namespace app\admin\validate;

use think\Validate;

class Banner extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'title'  => 'require|max:50|unique:banner',
    ];
    /**
     * 提示消息
     */
    protected $message = [
        'title.require' => '标题不能为空',
        'title.max' => '标题长度不超过50',
        'title.unique' => '标题已存在'
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => [],
        'edit' => [],
    ];
    
}
