<?php

namespace Backend\Controller;

use Backend\Controller\BaseController;

class IndexController extends BaseController {

    /**
     * 后台首页
     */
    public function index() {
        $simplePwd = cookie(('simplepwd')) ? true : false;
        $this->simplePwd = $simplePwd;
        $this->display();
    }

    /**
     * 修改个人基本信息
     */
    public function editProfile() {
        if (IS_POST) {
            $userModel = D('User');
            $userId = I('post.userid', 0, 'intval');
            $cname = I('post.cname', '', 'trim');
            $email = I('post.email', '', 'trim');
            $userData = array(
                'cname' => $cname,
                'email' => $email,
            );
            $userWhere = array(
                'id' => $userId,
            );
            $result = $userModel->where($userWhere)->save($userData);
            if ($result == 0) {
                $this->error('用户信息修改失败:' . $userModel->getError());
            }
            cookie('cname', $cname);
            $this->success('修改成功', U('Backend/Index/index'));
            exit();
        }
        $userModel = D('User');
        $userInfo = $userModel->field('id,username,cname,email,memo')->where(array('id' => session('userid')))->find();
        $this->userInfo = $userInfo;
        $this->display();
    }

    /**
     * 修改密码页面
     */
    public function changePwd() {
        if (IS_POST) {
            $oldPwd = I('post.oldPwd', '', 'trim');
            $newPwd = I('post.newPwd', '', 'trim');
            $renewPwd = I('post.renewPwd', '', 'trim');
            if (empty($oldPwd) || empty($newPwd) || empty($renewPwd)) {
                $this->error('必须输入原密码和新密码');
            }
            if ($newPwd != $renewPwd) {
                $this->error('两次输入的密码不一致');
            }
            if (!chkPwd($newPwd)) {
                $this->error('密码长度6-15位，同时包含数字、大写字母，小写字母');
            }
            $userModel = D('User');
            $where = array(
                'id' => session('userid'),
                'status' => '01',
            );
            $userInfo = $userModel->field('username,password')->where($where)->find();
            if (empty($userInfo)) {
                $this->error('账号出现异常，请重新登陆', U('Backend/Index/logout'));
            }
            if (md5(md5($userInfo['username']) . $oldPwd) != $userInfo['password']) {
                $this->error('原密码不正确');
            }
            $data = array(
                'password' => md5(md5($userInfo['username']) . $newPwd),
            );
            $result = $userModel->where($where)->save($data);
            if (!$result) {
                $this->error('密码修改失败');
            }
            cookie(('simplepwd'), NULL);
            $this->success('密码修改成功', U('Backend/Index/index'));
            exit();
        }
        $this->display();
    }

    /**
     * 用户注销
     */
    public function logout() {
        session('userid', null);
        session('roleid', null);
        cookie('username', null);
        cookie('cname', null);
        $this->redirect('Backend/Login/index');
    }

}
