<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use Elasticsearch\ClientBuilder;
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
        $this->assign('url',url('index/test'));
       
        return $this->view->fetch();
    }

    public function ajax_load_data()
    {
        $params = input('param.');
        $article = new \app\admin\model\Article;
        $where = [];
        $where['article.status'] = 'normal';
        $start = ($params['Page']-1)*$params['Limit'];
        $total = $article
                ->with(['admin','category','author'])
                ->where($where)
                //->fetchSql(true)
                ->count();
        $list = $article
                ->with(['admin','category','author'])
                ->where($where)
                ->order('article.id', 'desc')
                ->limit($start, $params['Limit'])
                
                ->select();
        foreach ($list as $row) 
        {
            $row->visible(['id','title','author','summary','keyword','content','flag','hits','thumbimage','pageviews','comment_count','status','createtime','updatetime']);
            $row->visible(['admin']);
            $row->getRelation('admin')->visible(['username']);
            $row->visible(['category']);
            $row->getRelation('category')->visible(['name','id']);
            $row->visible(['author']);
            $row->getRelation('author')->visible(['name','id']);
        }
        $list = collection($list)->toArray();
        $data = [];
        if ($list) 
        {
            $data['status'] = 1;
            $data['count'] = $total;
            $data['data'] = $list;
        }
        else
        {
            $data['status'] = 0;
        }
        
        return json($data);

    }

    public function news()
    {
        $newslist = [];
        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.fastadmin.net?ref=news']);
    }

    public function test()
    {
        $config = [];
        $config['host']='http://192.168.8.245:9200';
        $client = ClientBuilder::create()->setHosts($config)->build();
        $params = [
            'index' => 'mybold',
            'type' => 'user',
            'id' => '1'
        ];


        $response = $client->get($params);
        print_r($response);exit;

    }

}
