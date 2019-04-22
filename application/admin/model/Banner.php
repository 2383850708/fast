<?php

namespace app\admin\model;

use think\Model;

class Banner extends Model
{
    // 表名
    protected $name = 'banner';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'status_text'
    ];
    

    
    public function getStatusList()
    {
        return ['hidden' => __('Hidden'),'normal' => __('Normal')];
    }     


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getImageThumbAttr($value, $data)
    {      

        if($data['image'])
        {
            $begin = substr($data['image'],0,strrpos($data['image'],'/')+1);
            $end = substr($data['image'],strrpos($data['image'],'/')+1);
            $thumb_image = $begin.'thumb_'.$end;
        }
        else
        {
            $thumb_image = '';
        }
       
        return $thumb_image;
    }




}
