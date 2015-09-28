<?php

/**
 * Description of PositionmanagerController
 * 职位管理界面
 * @author hh
 */

namespace Company\Controller;

use Company\Controller\CompanyBaseController;

class PositionmanagerController extends CompanyBaseController {

    /**
     * 职位管理首页
     */
    public function index() {
        $this->display();
    }

}
