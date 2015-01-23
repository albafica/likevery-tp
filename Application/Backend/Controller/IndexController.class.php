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

    public function changePwd() {
        $this->display();
    }

    public function chgPwd() {
        if (!IS_AJAX) {
            $this->error('错误的访问方式', U('Backend/Index/index'));
        }
        $userId = I('post.userid', 0, 'intval');
        $oldPwd = I('post.oldName', '', 'trim');
        $newPwd = I('post.newName', '', 'trim');
        $renewPwd = I('post.renewoldName', '', 'trim');
        if ($userId <= 0) {
            
        }
        if (empty($oldPwd) || empty($newPwd) || empty($renewPwd)) {
            $this->ajaxReturn(array('status' => false, 'message' => '密码必须输入'));
        }
        if ($newPwd != $renewPwd) {
            $this->ajaxReturn(array('status' => false, 'message' => '两次输入的密码不一致'));
        }
        if (!chkPwd($newPwd)) {
            $this->ajaxReturn(array('status' => false, 'message' => '密码长度6-15位，同时包含数字、大写字母，小写字母'));
        }
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
