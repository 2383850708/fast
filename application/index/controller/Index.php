<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
		
    }

    public function index()
    {
		$banner = new \app\admin\model\Banner();
        $condition = [];
        $condition['status'] = 'normal';
        $banner_list = $banner->where($condition)->field('id,title,image,contents,url')->select();//

        if($banner_list)
        {
            $banner_list = collection($banner_list)->append(['ImageThumb'])->toArray();
        }
        
        $this->assign('banner_list',$banner_list);

        return $this->view->fetch();
    }

    public function news()
    {
        $newslist = [];
        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.fastadmin.net?ref=news']);
    }

}
