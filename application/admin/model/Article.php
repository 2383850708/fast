<?php

namespace app\admin\model;

use think\Model;
use app\admin\library\Auth;
use think\Db;
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

    public function getCreatetimeAttr($value,$data)
    {
        return date('Y-m-d',$data['createtime']);
    }

    public function getThumbnailImageAttr($value,$data)
    {
       if($data['thumbimage']!='')
       {
            $start = substr($data['thumbimage'],0,strrpos($data['thumbimage'],'/')+1);
            $end = substr($data['thumbimage'],strrpos($data['thumbimage'],'/')+1);
            return $start.'thumb_'.$end;
       }
       else
       {
            return '';
       }
    }
	
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

    public function author()
    {
        return $this->belongsTo('Author', 'author_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function getPrevData($id,$category_id)
    {
        $condition = [];
        $condition['id'] = array('lt',$id);
        $condition['category_id'] = array('eq',$category_id);

        $info = Db::name('article')->where($condition)->order('id asc')->limit(1)->field('id,category_id,title')->find();
        return $info;
    }

    public function getNextData($id,$category_id)
    {
        $condition = [];
        $condition['id'] = array('gt',$id);
        $condition['category_id'] = array('eq',$category_id);

        $info = Db::name('article')->where($condition)->order('id asc')->limit(1)->field('id,category_id,title')->find();
        return $info;
    }
}
