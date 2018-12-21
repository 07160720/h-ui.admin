<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 11:56
 */

namespace app\admin\controller;
use think\Controller;
class Admin extends Controller
{
    public function add(){
        // 判断是否是post提交
        if (request()->isPost()){
           $data = input("post.");
           $valicate = validate('AdminUser');
           if (!$valicate -> check($data)){
               $this->error($valicate->getError());
           }

           $data['password'] = md5($data['password'].'_#sing_ty');
           $data['status'] = 1;
           try {
               $id = model('AdminUser')->add($data);
           }
           // 1 exception
           // 2 add id
           catch (\Exception $e){
               $this->error($e->getMessage());
           }
           if ($id) {

           }
           else{

           }

        }
        else{

        }
        return $this->fetch();
    }
}