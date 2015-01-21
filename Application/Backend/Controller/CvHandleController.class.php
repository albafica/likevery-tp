<?php

namespace Backend\Controller;

use Backend\Controller\BaseController;

/**
 * Description of CvHandleController
 *  简历处理业务逻辑控制器成
 * @author albafica.wang
 */
class CvHandleController extends BaseController {

    /**
     * 简历处理首页，列出所有未分配的简历
     */
    public function index() {
        $cvUploadModel = D('Cvupload');
        $cvList = $cvUploadModel->search();
        var_dump($cvUploadModel->getLastSql());
        var_dump($cvList);
        echo $cvList['show'];
        exit();
    }

}
