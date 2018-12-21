<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 17:43
 */
namespace app\common\lib;

/**
 * Class IAuth
 * @package app\common\lib
 */
class IAuth{
    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static function setPassword($data){
         return md5($data.config('app.password_pre_halt'));
    }
}