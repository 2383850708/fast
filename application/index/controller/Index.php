<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use think\Db;
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
        if(input('?param.tag'))
        {
          $this->assign('tag',input('param.tag'));  
        }
        else
        {
        $this->assign('tag','');
        }
        
        return $this->view->fetch();
    }

    public function _getchildren($data,$catid)
    {
        static $res=array();
        foreach($data as $k=>$v){
            //判断该条数据的pid 是否等于当前 id
            if($v['pid']==$catid){
            //将该条数据保存在静态变量中
                $res[]=$v['id'];
                //继续将查询出的数据中id代入递归中继续操作
                $this->_getchildren($data,$v['id']);
            }
        }
        return $res;
    }


     private function getMenuPid($mid)
    {
        $condition = [];
        $condition['type'] = 'blog';
        $condition['id'] = $mid;
        $menu = Db::name('category')->where($condition)->field('id,pid')->find();
       
        if($menu['pid'] != 0)
        {
                return $this->getMenuPid($menu['pid']); 
        }
        return $menu['id'];
    }

    public function ajax_load_data()
    {
        $params = input('param.');

        $article = new \app\admin\model\Article;
        $where = [];
        $where['article.status'] = 'normal';
        if($params['tag']!='')
        {
            $where['article.keyword'] = ['like','%'.$params['tag'].'%'];
        }
       
        $dingji = 0;
        if($params['category_id'])
        {
           $category = Db::name('category')->where(['status'=>'normal'])->select();
           $childs = $this->_getchildren($category,$params['category_id']);
           $childs[] = $params['category_id'];
           $where['article.category_id'] = ['in',array_values($childs)];
           
           $dingji = $this->getMenuPid($params['category_id']);
        }
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
            $row->visible(['id','title','author','summary','keyword','content','flag','hits','like','thumbimage','pageviews','comment_count','status','createtime','updatetime']);
            $row->visible(['admin']);
            $row->getRelation('admin')->visible(['username']);
            $row->visible(['category']);
            $row->getRelation('category')->visible(['name','id']);
            $row->visible(['author']);
            $row->getRelation('author')->visible(['name','id']);
        }
        if($list)
        {
            $list = collection($list)->append(['ThumbnailImage'])->toArray();
        }
        else
        {
            $list = collection($list)->toArray();
        }

        $data = [];
        $data['dingji'] = $dingji;
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
