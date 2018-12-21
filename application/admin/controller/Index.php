<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 11:57
 */

namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {
        //halt(session(config('admin.session_user'), '', config('admin.session_user_scope')));
        return $this->fetch();
    }

    public function welcome()
    {
        return "hello api";
    }

}