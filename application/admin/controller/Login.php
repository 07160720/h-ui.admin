<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 11:56
 */

namespace app\admin\controller;

use app\common\validate\AdminUser;
use think\Controller;
use app\common\lib\IAuth;

class Login extends Base
{
    public function _initialize(){}
    public function index()
    {
        $isLogin = $this->isLogin();
        if ($isLogin){
            // 如果后台用户已经登录了，那么我们需要跳转到后台页面
            return $this->redirect('index/index');
        }
        return $this->fetch();
    }

    public function check()
    {
        if (request()->isPost()) {
            $data = input("post.");
            if (!captcha_check($data['code'])) {
                $this->error('验证码不正确');
            }

            try {
                $user = model('AdminUser')->get(['username' => $data['username']]);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            // username+password
            if (!$user || $user['status'] != config('code.status_normal')) {
                $this->error('用户名不存在');
            }
            // 再对密码进行校验
            if (IAuth::setPassword($data['password']) != $user['password']) {
                $this->error('密码不正确');
            }
            // 1 更新数据库 登录时间 登录ip
            $updata = [
                'last_login_time' => time(),
                'last_login_ip' => request()->ip(),
            ];
            try {
                model("AdminUser")->save($updata, ['id' => $user->id]);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            // 2 session
            session(config('admin.session_user'), $user, config('admin.session_user_scope'));
            $this->success('登录成功', 'index/index');
        } else {
            $this->error('请求不合法');
        }
    }

    public function logout(){
        session(null, config('admin.session_user_scope'));
        $this->redirect('login/index');
    }
}