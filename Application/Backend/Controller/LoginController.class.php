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
                session('roleid', $loginResult['userinfo']['roleid']);
                session('userid', $loginResult['userinfo']['id']);
                cookie('username', $loginResult['userinfo']['username']);
                cookie('cname', $loginResult['userinfo']['cname']);
                if (!chkPwd($password)) {
                    //密码规则太过简单，提示用户
                    cookie(('simplepwd'), 1);
                }
                $this->redirect('Backend/Index/index');
            }
        }
        layout(false);
        $this->display();
    }

    /**
     * 找回密码页面
     */
    public function findPwd() {
        if (IS_POST) {
            $userName = I('post.username', '', 'trim');
            $email = I('post.email', '', 'trim');
            $userModel = D('User');
            $where = array(
                'username' => $userName,
                'email' => $email,
            );
            $userInfo = $userModel->where($where)->find();
            if (empty($userInfo)) {
                $this->error('该用户不存在');
            }
            $newPwd = $userModel->createPassword();
            $data = array(
                'password' => md5(md5($userInfo['username']) . $newPwd),
            );
            $result = $userModel->where(array('id' => $userInfo['id']))->save($data);
            if ($result === FALSE) {
                $this->error('密码重置失败：' . $userModel->getError());
            }
            //将新密码发送到邮箱中去
            $mail = new \Lib\Mail();
            $mailResult = $mail->sendMail('重置密码', '您的新密码为：' . $newPwd, $userInfo['email'], $userInfo['cname']);
            if ($mailResult) {
                $this->success('新密码已发送到您的邮箱中，请登陆邮箱查收', U('Backend/Index/index'));
                exit;
            }
            $this->error('密码已重置，邮件发送失败，请联系系统管理员', U('Backend/Index/index'));
        }
        layout(false);
        $this->display();
    }

}
