<?php

namespace Backend\Controller;

use Backend\Controller\BaseController;

/**
 * Description of RoleController
 *  用户管理相关业务逻辑
 * @author albafica.wang
 */
class UserController extends BaseController {

    /**
     * 角色列表页
     */
    public function index() {
        $roleModel = D('User');
        $field = 'user.id,user.cname,user.email,user.createdate,user.memo,role.rolename';
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
     * 新增角色
     */
    public function addUser() {
        if (IS_POST) {
            $userModel = D('User');
            if (!$userModel->create()) {
                $this->error($userModel->getError());
            }
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
     * 删除角色
     */
    public function delUser() {
        $roleId = I('roleid', 0, 'intval');
        $roleModel = D('Role');
        $roleInfo = $roleModel->getById($roleId);
        if (empty($roleInfo)) {
            $this->error('该角色不存在不存在');
        }
        if ($roleInfo['isadmin']) {
            $this->error('系统分组，不可删除');
        }
        $userModel = D('User');
        $where = array(
            'roleid' => $roleId,
        );
        $userCount = $userModel->where($where)->count();
        if ($userCount > 0) {
            $this->error('该角色不为空，不可删除');
        }
        $delWhere = array(
            'id' => $roleId,
            'isadmin' => 0,
        );
        $result = $roleModel->where($delWhere)->delete();
        if ($result === false) {
            $this->error('删除失败，请稍后再试');
        }
        $this->success('删除成功');
    }

}
