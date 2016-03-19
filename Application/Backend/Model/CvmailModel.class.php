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
    public function sendSubscriptionMial($managerId, $companyId, $employeeId) {
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
            'emailstatus' => 1,
            'status' => '01',
        );
        $companyList = $companyModel->field('id')->where($companyWhere)->select();
        $sendCompanyId = $companyInfoArr = array();
        for ($i = 0; $i < count($companyList); $i++) {
            $sendCompanyId[] = $companyList[$i]['id'];
            $companyInfoArr[$companyList[$i]['id']] = $companyList[$i];
        }
        if (empty($sendCompanyId)) {
            //没有需要发送的企业
            return true;
        }
        $cvmailModel = D('Cvmail');
        $mail = new \Lib\Mail();
        foreach ($sendCompanyId as $tmpcid) {
            $url = U('Company/Cvmanager/viewmanager', array('employeeid' => $employeeId, 'companyId' => $tmpcid, 'chkloginstr' => generateEncrypt($tmpcid)), true, true);
            $content = '这是求职者;点击进入<a href="' . $url . '">爱才网</a>查看。如果无法打开，请访问以下链接：' . $url;
            $data = array(
                'companyid' => $tmpcid,
                'managerid' => $managerId,
                'content' => $content,
                'status' => '00',
                'createdate' => date('Y-m-d'),
                'updatedate' => date('Y-m-d'),
            );
            $result = $cvmailModel->add($data);
            if ($result) {
                //发送邮件
                $companyEmail = $companyInfoArr[$tmpcid]['email'];
                $companyName = $companyInfoArr[$tmpcid]['companyname'];
                $mail->sendMail('推荐求职者', $content, $companyEmail, $companyName);
            }
        }
    }

}
