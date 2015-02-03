<?php

namespace Backend\Controller;

use Backend\Controller\BaseController;

/**
 * Description of RoleController
 *  用户管理相关业务逻辑
 * @author albafica.wang
 */
class UserController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->checkRight(self::ADMINRIGHT);
    }

    /**
     * 角色列表页
     */
    public function index() {
        $roleModel = D('User');
        $field = 'user.id,user.cname,user.username,user.email,user.createdate,user.memo,user.issys,role.rolename';
        $where = array(
            'user.status' => '01',
        );
        $join = 'LEFT JOIN role ON user.roleid = role.id';
        $condition = array(
            'sort' => 'user.id',
            'order' => 'DESC',
        );
        $userList = $roleModel->search($where, $condition, false, $field, $join);
        $this->userList = $userList;
        $this->display();
    }

    /**
     * 新增用户
     */
    public function addUser() {
        if (IS_POST) {
            $userModel = D('User');
            if (!$userModel->create()) {
                $this->error($userModel->getError());
            }
            $where = array(
                'id' => $userModel->roleid
            );
            $roleInfo = D('Role')->where($where)->find();
            if (empty($roleInfo) || $roleInfo['status'] != '01') {
                $this->error('该角色不存在');
            }
            $userModel->password = md5(md5($userModel->username) . $userModel->password);
            $result = $userModel->add();
            if ($result == 0) {
                $this->error('用户添加失败:' . $userModel->getError());
            }
            $this->success('用户添加成功', U('Backend/User/index'));
            exit();
        }
        $roleModel = D('Role');
        $roleList = $roleModel->field('id,rolename')->where("status = '01'")->order('id DESC')->select();
        $this->roleList = $roleList;
        $this->display();
    }

    /**
     * 编辑用户
     */
    public function editUser() {
        if (IS_POST) {
            $userModel = D('User');
            $userId = I('post.userid', 0, 'intval');
            $cname = I('post.cname', '', 'trim');
            $email = I('post.email', '', 'trim');
            $memo = I('post.memo', '', 'trim');
            $roleId = I('post.roleid', 0, 'intval');
            $where = array(
                'id' => $roleId,
            );
            $roleInfo = D('Role')->where($where)->find();
            if (empty($roleInfo) || $roleInfo['status'] != '01') {
                $this->error('该角色不存在');
            }
            $userData = array(
                'cname' => $cname,
                'email' => $email,
                'memo' => $memo,
                'roleid' => $roleId,
            );
            $userWhere = array(
                'id' => $userId,
            );
            $result = $userModel->where($userWhere)->save($userData);
            if ($result == 0) {
                $this->error('用户信息修改失败:' . $userModel->getError());
            }
            $this->success('修改成功', U('Backend/User/index'));
            exit();
        }
        $userId = I('userid', 0, 'intval');
        $userModel = D('User');
        $userInfo = $userModel->find($userId);
        if (empty($userInfo)) {
            $this->error('该用户不存在');
        }
        $this->userInfo = $userInfo;
        $roleModel = D('Role');
        $roleList = $roleModel->field('id,rolename')->where("status = '01'")->order('id DESC')->select();
        $this->roleList = $roleList;
        $this->display();
    }

    /**
     * 删除角色
     */
    public function delUser() {
        $userId = I('userid', 0, 'intval');
        $userModel = D('User');
        $delWhere = array(
            'id' => $userId,
            'issys' => 0,
        );
        $result = $userModel->where($delWhere)->delete();
        if ($result == false) {
            $this->error('删除失败，请稍后再试');
        }
        $this->success('删除成功');
    }

}
