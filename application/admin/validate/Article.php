<?php

namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
		'category_id'=>'require',
		'title' => 'require|unique:Article',
		'author' => 'require',
		'hits' => 'number',
		'pageviews' => 'number',
		'weigh' => 'number',
		
    ];
    /**
     * 提示消息
     */
    protected $message = [
		'category_id.require' => '请选择分类',
		'title.require' => '标题不能为空',
		'title.unique' => '标题名已存在',
		'author.require' => '作者不能为空',
		'hits.number' => '点击量必须为数字',
		'pageviews.number' => '浏览量必须为数字',
		'weigh.number' => '权重必须为数字'
		
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => [],
        'edit' => [],
    ];
    
}
