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
        $where = [];
        $where['article.id'] = $params['id'];
        $article = new \app\admin\model\Article;
        $list = $article
                ->with(['admin','category','author'])
                ->where($where)
                ->find();
        $list->visible(['id','title','category_id','author','like','summary','keyword','content','flag','hits','thumbimage','pageviews','comment_count']);
        $list->visible(['admin']);
        $list->getRelation('admin')->visible(['username']);
        $list->visible(['category']);
        $list->getRelation('category')->visible(['name','id']);
        $list->visible(['author']);
        $list->getRelation('author')->visible(['name','id']);
        if($list['keyword']!='')
        {
            $list['keyword'] = explode(',', $list['keyword']);
        }

        $prev = $article->getPrevData($list['id'],$list['category_id']);
        $next = $article->getNextData($list['id'],$list['category_id']);

        $this->assign('list',$list);
        $this->assign('prev',$prev);
        $this->assign('next',$next);
        
    	return $this->view->fetch();
    }
}



 ?>