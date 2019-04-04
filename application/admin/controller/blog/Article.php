<?php

namespace app\admin\controller\blog;

use app\common\controller\Backend;
use fast\Tree;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Article extends Backend
{
    
    /**
     * Article模型对象
     * @var \app\admin\model\Article
     */
    protected $model = null;
    protected $categorylist = [];
	protected $modelValidate = true;
	protected $get_category = [];
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Article;
		
		
        $category = model('app\common\model\Category');
		$condition = [];
		$condition['type'] = 'blog';
		
        $tree = Tree::instance();
        $tree->init(collection($category->where($condition)->order('weigh desc,id desc')->field('id,name,pid,type,flag')->select())->toArray(), 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'name');
        $categorydata = [0 => ['id'=>'','type' => 'all', 'name' => __('None')]];
        foreach ($this->categorylist as $k => $v)
        {
            $categorydata[$v['id']] = $v;
        }
		$this->get_category =$categorydata; 
	
		$this->view->assign("parentList", $categorydata);
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['admin','category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['admin','category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['id','title','author','keyword','flag','hits','thumbimage','pageviews','comment_count','status','createtime','updatetime']);
                $row->visible(['admin']);
				$row->getRelation('admin')->visible(['username']);
				$row->visible(['category']);
				$row->getRelation('category')->visible(['name','id']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
	
	/**
     * 文章添加
     */
	 
	 public function add()
	 {
		if ($this->request->isPost()) 
		{
            $params = $this->request->post("row/a");
			
            if ($params) 
			{

				if($params['flag'])
				{
					$params['flag'] = implode(',',$params['flag']);
				}
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
						$tag = new \app\admin\model\Tag();
						$tag->add_tags($params['keyword']);
                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
		else
		{
		 return $this->view->fetch();
		}
	 }
	 
	 /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
		
		
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
			
			if($params['flag'])
			{
				$params['flag'] = implode(',',$params['flag']);
			}
		
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false) {
					
						$tag = new \app\admin\model\Tag();
						$tag->add_tags($params['keyword'],input('param.old_keyword'));
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
	
	/**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
			$tag = new \app\admin\model\Tag();
            $pk = $this->model->getPk();
		
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();
			
            $count = 0;
            foreach ($list as $k => $v) {
				
                $count += $v->delete();
				$tag->add_tags('',$v['keyword']);
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
	
	public function get_category()
	{
		return json($this->get_category);
	}

}
