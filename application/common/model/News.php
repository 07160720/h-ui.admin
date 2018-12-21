<?php  

namespace app\common\model;
use think\Model;
use app\common\model\Base;
/**
* 
*/
class News extends Base
{
    /** 后台自动化分页
     * @param array $data
     */
	 public function getNews($data = []){
	     $data['status'] = [
	         'neq', config('code.status_delete')
         ];
	     $order = ['id' => 'desc'];
	     //查询
         $result = $this->where($data)
                        ->order($order)
                        ->paginate();
         // 调试
         //echo $this->getLastSql();
	     return $result;
     }

     /**
      * 根据来获取列表的数据
      */
      public function getNewsByCondition($condition = [], $from=0, $size=5){
          $condition['status'] = [
              'neq', config('code.status_delete')
          ];

          $order = ['id' => 'desc'];

          $result = $this->where($condition)
              ->limit($from, $size)
              ->order($order)
              ->select();

          //echo $this->getLastSql();
          return $result;

      }

    /**
     * 根据条件来获取列表的数据的总数
     * @param array $param
     */
      public function getNewsCountByCondition($condition = []){
          $condition['status'] = [
              'neq', config('code.status_delete')
          ];

          return $this->where($condition)
              ->count();
      }

}
?>