<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 15:26
 */
namespace app\common\model;
use think\Model;

class Base extends Model{
	
    protected $autoWriteTimestamp = true;

    public function add($data){
        if (!is_array($data)){
            exception('传递数据不合法');
        }
        // allowField() 过滤掉表中没有的字段
        $this->allowField(true)->save($data);
        return $this->id;
    }
}