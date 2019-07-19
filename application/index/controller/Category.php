<?php 
namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use think\Db;
use think\Request;

class Category extends Frontend
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
    	
    	if(input('?param.tag'))
    	{
    		$this->assign('tag',input('param.tag'));
    	}
    	else
    	{
    		$this->assign('tag','');
    	}
    	$this->assign('category_id',input('param.id'));
    	return $this->view->fetch();
    }
}
?>