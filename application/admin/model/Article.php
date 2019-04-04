<?php

namespace app\admin\model;

use think\Model;
use app\admin\library\Auth;
class Article extends Model
{
    // 表名
    protected $name = 'article';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
	protected $insert = ['create_id'];  
    protected $update = ['update_id'];  
    

	
    // 追加属性
    protected $append = [

    ];
	
	protected function setCreateIdAttr()
	{
		$auth = Auth::instance();
		return $auth->id;
	}
	
	protected function setUpdateIdAttr()
	{
		$auth = Auth::instance();
		return $auth->id;
	}
    
    public function admin()
    {
        return $this->belongsTo('Admin', 'create_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
