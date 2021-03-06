<?php 

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use think\Db;
use think\Request;

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
        /*$request = Request::instance();
        echo $request->ip();exit;*/

    	$params = input('param.');
        $where = [];
        $where['article.id'] = $params['id'];
        Db::name('article')->where('id', $params['id'])->setInc('pageviews');
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

    public function like()
    {
        $root = [];
        $params = input('param.');
        $condition = [];
        $condition['article_id'] = $params['id'];
        $condition['ip'] = request()->ip();
        $res = Db::name('ip_record')->where($condition)->find();
        if($res)
        {
            $root['status'] = 0;
            $root['msg'] = '您已提交过';
            return json($root);
        }

        Db::name('article')->where('id', $params['id'])->setInc('like');
        $data = [];
        $data['ip'] = request()->ip();
        $data['article_id'] = $params['id'];
        $data['createtime'] = time();
        Db::name('ip_record')->insert($data);
        $root['status'] = 1;
        $root['msg'] = '感谢您的支持，我会继续努力的';
        return json($root);
    }
}



 ?>