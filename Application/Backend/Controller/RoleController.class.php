<?php

namespace Backend\Controller;

use Backend\Controller\BackendBaseController;

/**
 * Description of RoleController
 *  角色管理相关业务逻辑
 * @author albafica.wang
 */
class RoleController extends BackendBaseController {

    public function __construct() {
        parent::__construct();
        $this->checkRight(self::ADMINRIGHT);
    }

    /**
     * 角色列表页
     */
    public function index() {
        $roleModel = D('Role');
        $field = 'id,rolename,isadmin,memo';
        $where = array(
            'status' => '01',
        );
        $roleList = $roleModel->search($where, array(), false, $field);
        $this->roleList = $roleList;
        $this->display();
    }

    /**
     * 新增、编辑角色
     */
    public function addRole() {
        if (IS_POST) {
            $roleId = I('post.roleid', 0, 'intval');
            $roleName = I('post.rolename', '', 'trim');
            $memo = I('post.memo', '', 'trim');
            $cvManage = I('post.cvmanage', 0, 'intval');
            $rights = '';
            //判断有无简历管理权限
            $rights .= $cvManage ? '1' : '0';
            $data = array(
                'rolename' => $roleName,
                'memo' => $memo,
                'isadmin' => '0',
                'status' => '01',
                'rights' => $rights,
            );
            $roleModel = D('Role');
            if ($roleId > 0) {
                $data['id'] = $roleId;
                $result = $roleModel->save($data);
            } else {
                $result = $roleModel->add($data);
            }
            if ($result === false) {
                $this->error('保存失败，请稍后再试', U('Backend/Role/index'));
            }
            $this->success('保存成功', U('Backend/Role/index'));
            exit;
        }
        $roleId = I('roleid', 0, 'intval');
        if ($roleId <= 0) {
            //新增角色
            $handle = 'add';
            $roleInfo = array();
            $rightArr = array();
        } else {
            //编辑角色，获取角色信息
            $handle = 'edit';
            $roleModel = D('Role');
            $roleInfo = $roleModel->find($roleId);
            $rightArr = str_split($roleInfo['rights']);
        }
        $this->rightArr = $rightArr;
        $this->handle = $handle;
        $this->roleInfo = $roleInfo;
        $this->display();
    }

    /**
     * 删除角色
     */
    public function delRole() {
        $roleId = I('roleid', 0, 'intval');
        $roleModel = D('Role');
        $roleInfo = $roleModel->where(array('id' => $roleId))->find();
        if (empty($roleInfo)) {
            $this->error('该角色下还有未删除的用户，不可删除');
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
