<?php

namespace Backend\Model;

use Common\Model\BaseModel;

/**
 * Description of UserModel
 *  后台用户相关操作逻辑
 * @author albafica.wang
 */
class CvmailModel extends BaseModel {

    /**
     * 发送订阅邮件
     * @param int $managerId        求职者id
     * @param int $companyId        企业id
     */
    public function sendSubscriptionMial($managerId, $companyId) {
        if (empty($companyId)) {
            //企业id为空，直接返回错误，不可继续发送
            return false;
        }
        $managerModel = D('Manager');
        $managerInfo = $managerModel->field('*')->where(array('id' => $managerId))->find();
        if (empty($managerInfo)) {
            return false;
        }
        $companyModel = D('Company');
        $companyWhere = array(
            'id' => array('IN', $companyId),
            'status' => '01',
        );
        $companyList = $companyModel->field('id')->where($companyWhere)->select();
        $sendCompanyId = array();
        for ($i = 0; $i < count($companyList); $i++) {
            $sendCompanyId[] = $companyList[$i]['id'];
        }
        if (empty($sendCompanyId)) {
            //没有需要发送的企业
            return true;
        }
        $cvmailModel = D('Cvmail');
        $content = '这是求职者';
        foreach ($sendCompanyId as $tmpcid) {
            $data[] = array(
                'companyid' => $tmpcid,
                'managerid' => $managerId,
                'content' => $content,
                'status' => '00',
            );
        }
        $result = $cvmailModel->addAll($data);
        if ($result) {
            return true;
        }
        return false;
    }

}
