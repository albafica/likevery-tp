<?php

namespace Company\Controller;

use Company\Controller\CompanyBaseController;

class CompanymanagerController extends CompanyBaseController {

    /**
     * 修改公司信息
     */
    public function index() {
        $companyModel = D('Company');
        if (isPost) {
            
        }
//        $companyInfo = $companyInfo->find();
        $this->display();
    }

}
