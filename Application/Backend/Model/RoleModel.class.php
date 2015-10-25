<?php

namespace Backend\Model;

use Common\Model\BaseModel;

/**
 * Description of RoleModel
 *  角色数据逻辑
 * @author albafica.wang
 */
class RoleModel extends BaseModel {

    /**
     * 判断用户是否有操作的权限
     * @param string $operation
     * @return type
     */
    public function checkRight($operation) {
        $roleId = session('roleid');
        $roleInfo = $this->where(array('id' => $roleId))->find();
        if (empty($roleInfo)) {
            return false;
        }
        if ($roleInfo['isadmin']) {
            return TRUE;
        }
        $rightsArr = str_split($roleInfo['rights']);
        return isset($rightsArr[$operation]) && $rightsArr[$operation] ? true : false;
    }

}
