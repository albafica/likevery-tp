<?php

namespace Common\Model;

use Common\Model\BaseModel;

/**
 * Description of CompanyModel
 *  求职者模型
 * @author albafica.wang
 */
class CompanyModel extends BaseModel {

    public function sendValidEmil($companyId) {
        $companyInfo = $this->where(array('id' => $companyId))->find();
        if (!$companyInfo) {
            return $this->returnResult(array('status' => false, 'errMsg' => '该用户不存在'), 'JSON');
        }
        if ($companyInfo['emailstatus'] == 1) {
            return $this->returnResult(array('status' => true, 'errMsg' => '邮箱已认证'), 'JSON');
        }
        $emailChkCode = generatePwd(6, 1);
        $data = array(
            'emailchkcode' => $emailChkCode,
        );
        $result = $this->where(array('id' => $companyId))->save($data);
        $chkEmailUrl = U('/Company/Index/chkemail', array('chkcode' => $emailChkCode, 'companyid' => $companyId));
        if ($result) {
            $mail = new \Lib\Mail();
            $mailResult = $mail->sendMail('重置密码', '点击链接激活您的邮箱：' . DOMAIN . $chkEmailUrl, $companyInfo['email'], '企业用户', C('FROM_EMALI_ADDR'), C('FROM_EMAIL_NAME'));
            if ($mailResult) {
                return $this->returnResult(array('status' => true, 'errMsg' => '认证邮件已发送', 'code' => $emailChkCode), 'JSON');
            } else {
                return $this->returnResult(array('status' => false, 'errMsg' => '邮件发送失败',), 'JSON');
            }
        } else {
            return $this->returnResult(array('status' => false, 'errMsg' => '认证失败,请稍后再试'), 'JSON');
        }
    }

}
