<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 11:57
 */

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    /**
     * page
     * @var string
     */
    public $page = '';
    /**
     * 每页显示多少条
     * @var string
     */
    public $size = '';
    /**
     * 查询条件的起始值
     * @var int
     */
    public $from = 0;

    /**
     * 定义model
     */
    public $model = '';

    /**
     * 初始化方法
     */
    public function _initialize()
    {
        $isLogin = $this->isLogin();
        // 判断是否已经登录
        if (!$isLogin){
           return $this->redirect('login/index');
        }
    }

    /**
     * 判断是否登录
     * @return bool
     */

    public function isLogin()
    {
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
        // 获取session
        if ($user && $user->id){
            return true;
        }
        return false;
    }

    /**
     *  获取分页page size 内容
     */
     public function getPageAndSize($data){
         $this->page = !empty($data['page'])?$data['page']:1;
         $this->size = !empty($data['size'])?$data['size']:config('paginate.list_rows');
         $this->from = ($this->page - 1) * $this->size;
     }

     /**
      * 删除数据
      */
    public function delete($id = 0){
         if (!intval($id)){
             return $this->result('', 0, 'ID不合法');
         }
         // 如果你的表和我们控制器文件名一样，news
         // 但是我们 不一样。
         $model = $this->model ? $this->model : request()->controller();
         try{
             $res = model($model)->save(['status' => -1], ['id' => $id]);
         }
         catch (\Exception $e){
             return $this->result('', 0, $e->getMessage());
         }

         if ($res){
              return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']],1 ,'OK');
         }

          return $this->result('',0 ,'删除失败');

    }

}