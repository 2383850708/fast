<?php

namespace app\admin\validate\product;

use think\Validate;
use think\Db;
class Cates extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'title'  => 'require|max:50|IsHave',
    ];
    /**
     * 提示消息
     */
    protected $message = [
     'title.require' => '分类名称不能为空',
     'title.max' => '分类名称长度不超过50'
    ];

    protected function IsHave($value,$rule,$data,$field)
    {
        $map = array();
        $map['pid'] = $data['pid'];
        $map['title'] = $data['title'];

        $info = Db::name('product_cates')->where($map)->find();

        if($info)
        {
            return '类名重复';
        }
        else
        {
             return true;
        }
    }
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => [],
        'edit' => [],
    ];
    
}
