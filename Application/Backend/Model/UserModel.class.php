<?php

namespace Backend\Model;

use Think\Model;

/**
 * Description of UserModel
 *  后台用户相关操作逻辑
 * @author albafica.wang
 */
class UserModel extends Model {

    /**
     * 用户登陆
     */
    public function login($username, $password) {
        $field = '*';
        $condition = array(
            'username' => $username,
        );
        $userInfo = $this->field()->where($condition)->find();
        if (empty($userInfo) || $userInfo['status'] != '01') {
            return array('status' => false, 'message' => '该用户不存在或者账号被禁用');
        }
        if (md5(md5($username) . $password) != $userInfo['password']) {
            return array('status' => false, 'message' => '用户名或者密码错误');
        }
        return array('status' => true, 'message' => '登陆成功', 'userinfo' => $userInfo);
    }

}
