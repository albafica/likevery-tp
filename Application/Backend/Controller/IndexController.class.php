<?php

namespace Backend\Controller;

use Backend\Controller\BaseController;

class IndexController extends BaseController {

    /**
     * 后台首页
     */
    public function index() {
        $this->display();
    }

    /**
     * 用户注销
     */
    public function logout() {
        session('userid', null);
        cookie('username', null);
        cookie('cname', null);
        $this->redirect('Backend/Login/index');
    }

}
