<?php

namespace Company\Controller;

use Common\Controller\BaseController;

class EmailvalidController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
    }
    
    /**
     * 发送认证邮件
     */
    public function validEmail() {
        $companyId = session('companyid');
        $companyInfo = D('Company')->where(array('id' => $companyId))->find();
        if (!$companyInfo) {
            $this->ajaxReturn(array('status' => false, 'errMsg' => '该用户不存在'), 'JSON');
        }
        if ($companyInfo['emailstatus'] == 1) {
            $this->ajaxReturn(array('status' => true, 'errMsg' => '邮箱已认证'), 'JSON');
        }
        $emailChkCode = generatePwd(6, 1);
        $data = array(
            'emailchkcode' => $emailChkCode,
        );
        $result = D('Company')->where(array('id' => $companyId))->save($data);
        $chkEmailUrl = U('/Company/Index/chkemail', array('chkcode' => $emailChkCode, 'companyid' => $companyId));
        if ($result) {
            $mail = new \Lib\Mail();
            $mailResult = $mail->sendMail('重置密码', '点击链接激活您的邮箱：' . DOMAIN . $chkEmailUrl, $companyInfo['email'], '企业用户', C('FROM_EMALI_ADDR'), C('FROM_EMAIL_NAME'));
            if ($mailResult) {
                $this->ajaxReturn(array('status' => true, 'errMsg' => '认证邮件已发送', 'code' => $emailChkCode), 'JSON');
            } else {
                $this->ajaxReturn(array('status' => false, 'errMsg' => '邮件发送失败',), 'JSON');
            }
        } else {
            $this->ajaxReturn(array('status' => false, 'errMsg' => '认证失败,请稍后再试'), 'JSON');
        }
    }


    public function emailvalidpage() {
        $companyId = session('companyid');
        if($companyId <= 0){
            $this->redirect(U('/Company/Index/index'));
        }
        $companyInfo = D('Company')->where(array('id' => $companyId))->find();
        $this->companyInfo = $companyInfo;
        layout(false);
        $this->display();
    }

}
