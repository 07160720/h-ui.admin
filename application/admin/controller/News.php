<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 11:57
 */

namespace app\admin\controller;

class News extends Base
{
    public function index(){
           $data = input('param.');
           //halt($data);
           $query = http_build_query($data);
           $whereData = [];
           // 转换查询条件
           if (!empty($data['start_time']) && !empty($data['end_time'])
           && $data['end_time'] > $data['start_time']){
               $whereData['create_time'] = [
                   ['gt', strtotime($data['start_time'])],
                   ['lt', strtotime($data['end_time'])],
               ];
           }
           if (!empty($data['catid'])){
               $whereData['catid'] = intval($data['catid']);
           }
           if (!empty($data['title'])){
               $whereData['title'] = ['like', '%'.$data['title'].'%'];
           }

           // 获取数据 然后数据填充到模板
           // 模式一
           //$news = model('News')->getNews();
           // 模式二
           // page size from
           $this->getPageAndSize($data);
//           $whereData['page'] = !empty($data['page']) ? $data['page'] : 1;
//           $whereData['size'] = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');

           // 获取表里边的数据
           $news = model('News')->getNewsByCondition($whereData,$this->from,$this->size);
           // 获取满足条件的数据总数 =》 有多少页
           $total = model('News')->getNewsCountByCondition($whereData);
           // 结合总数+size =》 有多少页
           $pageTotal = ceil($total/$this->size); // 取整 1.1 => 2
           //echo $pageTotal;exit;
           return $this->fetch('',[
               'cats' => config('cat.lists'),
               'news' => $news,
               'pageTotal' => $pageTotal,
               'curr'      => $this->page,
               'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
               'end_time'   => empty($data['end_time']) ? '' : $data['end_time'],
               'catid'     => empty($data['catid']) ? '' : $data['catid'],
               'title'     => empty($data['title']) ? '' : $data['title'],
               'query'    =>  $query,
           ]);

    }



    public function add()
    {
    	if (request()->isPost()) {
    		$data = input('post.');
    		// 数据需要检验
    		// 入库操作
    		try{
    			$id = model('News')->add($data);
    		}
    		catch(\Exception $e){
                return $this->result('', 0, '新增失败');
    		}

    		if ($id) {
    			return $this->result(['jump_url' => url('news/index')], 1, 'OK');
    		}
    		else{
    			return $this->result('', 1, '新增失败');
    		}

    	}

        return $this->fetch('', [
             'cats' =>  config('cat.lists')
        ]);
    }
}