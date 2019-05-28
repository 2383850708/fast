<?php 

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;

class Article extends Frontend
{
	protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
		
    }

    /**
     * 文章首页
     * @Author   wyk
     * @DateTime 2019-05-28
     */
    public function index()
    {
    	return $this->view->fetch();
    }

    /**
     * 文章详情
     * @param    description
     * @param    description
     * @return   json
     * @Author   wyk
     * @DateTime 2019-05-28
     */
    public function info()
    {
    	$params = input('param.');
    
    	return $this->view->fetch();
    }
}



 ?>