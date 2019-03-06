<?php

namespace app\admin\controller\shop;

use app\common\controller\Backend;
use app\common\model\Category as CategoryModel;
use fast\Tree;

/**
 * 分类管理
 *
 * @icon fa fa-circle-o
 */
class Category extends Backend
{
    
    /**
     * Cates模型对象
     * @var \app\admin\model\product\Cates
     */
    protected $model = null;
    protected $categorylist = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\product\Cates;

        $tree = Tree::instance();
        $tree->init(collection($this->model->order('weigh desc,id desc')->select())->toArray(), 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'title');
        $categorydata = [0 => ['type' => 'all', 'title' => __('Toplevel'),'id'=>0]];
        foreach ($this->categorylist as $k => $v)
        {
            $categorydata[$v['id']] = $v;
        }

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

        if ($this->request->isAjax())
        {
            $search = $this->request->request("search");
            //构造父类select列表选项数据
            $list = [];

            if ($search) 
            {
                
                foreach ($this->categorylist as $k => $v)
                {
                    if (stripos($v['title'], $search) !== false )
                    {
                        $list[] = $v;
                    }
                }
            } 
            else 
            {
               $list = $this->categorylist;
            }

            $total = count($list);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }


    /**
     * 添加
     * @Author   wyk
     * @DateTime 2019-01-09
     */
    public function add()
    {

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
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

        if(input('param.ids'))
        {
            $this->view->assign("pid", input('param.ids'));
        }
        else
        {
            $this->view->assign("pid", 0);
        }
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {

        if ($ids) {
            $pk = $this->model->getPk();

            $adminIds = $this->getDataLimitAdminIds();

            if (is_array($adminIds)) {
                $count = $this->model->where($this->dataLimitField, 'in', $adminIds);
            }

            $list = $this->model->where($pk, 'in', $ids)->select();
            
            $count = 0;
            $num = '';
            foreach ($list as $k => $v) {

                $is = $this->model->get(['pid' => $v['id']]);

                if($is)
                {
                    $num.=$v['id'].',';
                }
                else
                {
                    $count += $v->delete();
                }
              
            }

            if ($count) {
                $this->success();
            } else {
                $this->error(__('Subclasses cannot be deleted under id').'('.rtrim($num,',').')');
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
}
