<?php 
namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;

class About extends Frontend
{
	protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
		
    }

    /**
     * 关于我首页
     * @Author   wyk
     * @DateTime 2019-06-24
     */
    public function index()
    {
    	return $this->view->fetch();
    }
}


 ?>