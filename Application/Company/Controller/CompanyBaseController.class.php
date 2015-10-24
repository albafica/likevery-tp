<?php

namespace Company\Controller;

use Common\Controller\BaseController;

class CompanyBaseController extends BaseController {

    public function __construct() {
        parent::__construct();
        if(session('companyid') <= 0){
            $this->redirect('/Company/Index/index');
        }
    }

}
