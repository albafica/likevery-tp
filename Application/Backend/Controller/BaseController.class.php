<?php

namespace Backend\Controller;

use Think\Controller;

/**
 * 控制器基类，提供基础方法
 */
class BaseController extends Controller {

    const HANDLECV = 0;
    const ADMINRIGHT = -1;

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

    /**
     * 验证用户操作权限
     * @param type $operation
     */
    public function checkRight($operation) {
        $roleModel = D('Role');
        if (!$roleModel->checkRight($operation)) {
            $this->error('对不起，您没有权限操作', U('Backend/Index/index'));
        }
    }

}
