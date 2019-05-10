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
