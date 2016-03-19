<?php

namespace Common\Model;

use Common\Model\BaseModel;

/**
 * Description of EmployeeModel
 *  企业订阅表
 * @author albafica.wang
 */
class SubscriptionModel extends BaseModel {

    public function sendSubscriptionMail($managerId) {
        //根据managerid获取精英信息
        $managerModel = D('Manager');
        $managerInfo = $managerModel->where(array('id' => $managerId))->find();
        if (empty($managerInfo)) {
            return $this->returnResult(array('status' => false, 'errMsg' => '精英信息不存在'));
        }
        $jobType = $managerInfo['jobtype'];
        $jobType = in_array($jobType, array(1, 2, 3, 4)) ? $jobType : 4;
        $companyList = $this->where(array('type' => $jobType))->select();
        if (empty($companyList)) {
            return $this->returnResult(array('status' => false, 'errMsg' => '无定位改职位的企业'));
        }
        var_dump($companyList);
    }

}
