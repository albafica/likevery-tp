<?php

namespace Backend\Controller;

use Think\Controller;

/**
 * 控制器基类，提供基础方法
 */
class BaseController extends Controller {

    /**
     * 构造函数，验证用户是否登陆
     */
    public function __construct() {
        parent::__construct();
        if (!session('?userid')) {
            $this->redirect('Backend/Login/index');
        }
        $this->cname = cookie('cname');
        $this->username = cookie('username');
    }

}
