<?php

namespace Company\Controller;

use Common\Controller\BaseController;

class CompanyBaseController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->showNav = true;
        if (session('companyid') <= 0) {
            //校验是否传入自动登录码
            $companyId = I('companyId', 0);
            $chkloginstr = I('chkloginstr');
            if (generateEncrypt($companyId) == $chkloginstr) {
                session('companyid', $companyId);
            }
        }
        if (session('companyid') <= 0) {
            $this->redirect('/Company/Index/index');
        }
        if (CONTROLLER_NAME != 'Emailvalid') {
            $companyInfo = D('Company')->where(array('id' => session('companyid')))->find();
            if ($companyInfo['emailstatus'] != 1) {
                $this->redirect('/Company/Emailvalid/emailvalidpage');
            }
        }
    }

}
