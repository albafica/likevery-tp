<?php

namespace Backend\Model;

use Common\Model\BaseModel;

/**
 * Description of UserModel
 *  后台用户相关操作逻辑
 * @author albafica.wang
 */
class UserModel extends BaseModel {

    protected $_auto = array(
//        array(完成字段1,完成规则,[完成条件,附加规则]),   
        array('password', 'generatePwd', 1, 'callback'),
        array('createdate', 'getSysDate', 1, 'callback'),
    );
    protected $_validate = array(
//         array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('username', 'require', '登录名必填且不可重复', 0, 'unique', 1),
        array('password', 'require', '密码必填'),
        array('cname', 'require', '中文名必填'),
        array('roleid', 'require', '角色必填'),
        array('email', 'require', '邮箱必填'),
        array('username', 'require', '登录名必填且不可重复', 0, 'unique', 1),
        array('repassword', 'password', '两次密码不一致', 0, 'confirm', 1),
        array('email', 'email', '邮箱格式不正确', 2),
    );

    /**
     * 生成加密密码
     * @return type
     */
    public function generatePwd() {
        return md5(md5($this->username) . $this->password);
    }

    /**
     * 获取当前系统时间
     * @return type
     */
    public function getSysDate() {
        return date('Y-m-d H:i:s');
    }

    /**
     * 用户登陆
     */
    public function login($username, $password) {
        $field = '*';
        $condition = array(
            'username' => $username,
        );
        $userInfo = $this->field($field)->where($condition)->find();
        if (empty($userInfo) || $userInfo['status'] != '01') {
            return array('status' => false, 'message' => '该用户不存在或者账号被禁用');
        }
        if (md5(md5($username) . $password) != $userInfo['password']) {
            return array('status' => false, 'message' => '用户名或者密码错误');
        }
        return array('status' => true, 'message' => '登陆成功', 'userinfo' => $userInfo);
    }

}
