<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 15:16
 */
namespace app\common\validate;
use think\Validate;
class AdminUser extends Validate {
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',

    ];
}
