<?php

namespace Backend\Controller;

use Think\Controller;

/**
 * 用户登陆控制逻辑
 */
class LoginController extends Controller {

    /**
     * 后台登陆页
     */
    public function index() {
        if (IS_POST) {
            $userModel = D('User');
            $userName = I('username');
            $password = I('password');
            $loginResult = $userModel->login($userName, $password);
            if ($loginResult['status']) {
                //登陆成功，设置相应session值
                session('userid', $loginResult['userinfo']['id']);
                cookie('username', $loginResult['userinfo']['username']);
                cookie('cname', $loginResult['userinfo']['cname']);
                $this->redirect('Backend/Index/index');
            }
        }
        layout(false);
        $this->display();
    }

}
