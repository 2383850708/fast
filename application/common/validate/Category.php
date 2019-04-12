<?php

namespace app\common\validate;

use think\Validate;
use think\Db;
class Category extends Validate
{

    /**
     * 验证规则
     */
    protected $rule = [
        'name' => 'require|max:50|checkName',
        'nickname' => 'require',
       
    ];

    /**
     * 提示消息
     */
    protected $message = [
        'name.require' => '名称不能为空',
        'name.max' => '名称长度不得超过50字符',
        'name.checkName' => '名称已存在'
    ];

    protected function checkName($value,$rule,$data)
    {
        $condition = [];
        $condition['type'] = $data['type'];
        $condition['name'] = $data['name'];
        $condition['pid'] = $data['pid'];
		if(isset($data['id']))
		{
			$condition['id'] = array('neq',$data['id']);
		}
        $id =  Db::name('category')->where($condition)->value('id');
        if($id)
        {
            return false;
        }
        else
        {
            return true;
        }

    }

    /**
     * 字段描述
     */
    protected $field = [
    ];

    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => ['name', 'nickname'],
        'edit' => ['name', 'nickname'],
    ];

  

}
