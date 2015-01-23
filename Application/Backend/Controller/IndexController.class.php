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

    public function testMail() {
        $mail = new \Lib\mail();
        $mailResult = $mail->sendMail('测试邮件', '你好，这是一封测试邮件', 'albafica.wang@51job.com', '测试发送人', '', '');
        var_dump($mailResult);
        var_dump($mail->getErrMsg());
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
