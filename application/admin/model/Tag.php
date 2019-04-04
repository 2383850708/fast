<?php

namespace app\admin\model;

use think\Model;
use think\Db;
class Tag extends Model
{
    // 表名
    protected $name = 'tag';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    

    public function add_tags($datas='',$tags_old='')
	{
		if(!empty($tags_old))
		{	
			$tags_old = explode(',',$tags_old);
			
			
				foreach($tags_old as $key=>$value)
				{
					
					$condition = [];
					$condition['name'] = $value;
					$tag = Tag::where($condition)->find();
					
					if($tag)
					{					
						$data_update = [];
						$data_update['num'] = $tag['num']-1;
						
						if($data_update['num']<1)
						{
							Db::name('tag')->delete($tag['id']);	
						}
						else
						{
							Db::name('tag')->where('id', $tag['id'])->update($data_update);
						}	
					}
					
				}

		}
		if(!empty($datas))
		{
			$datas = explode(',',$datas);
			
			foreach($datas as $k=>$v)
			{
				
				$data = [];
				$data['name'] = $v;
				$tag = Tag::where($data)->find();
				
				if($tag)
				{
					Db::name('tag')->where('id', $tag['id'])->setInc('num', 1);
					continue;
				}
				$data['num'] = 1;
				
				Db::name('tag')->insert($data);
			}	
		}	
	}







}
