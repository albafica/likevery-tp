<?php

/**
 * Description of ManagerController
 * 求职者相关控制器
 * @author albafica.wang
 */

namespace Backend\Controller;

use Backend\Controller\BaseController;

class ManagerController extends BaseController {

    public function __construct() {
        parent::__construct();
        //求职者管理权限和简历管理权限一致
        $this->checkRight(self::HANDLECV);
//        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black', 'My97DatePicker/WdatePicker.js'));
    }

    /**
     * 求职者列表
     */
    public function index() {
        $managerModel = D('Manager');
        //获取所有求职者信息列表
        $map = array(
            'manager.status' => '01',
            'cvupload.status' => '01',
        );
        $field = 'manager.id,manager.jobtype,manager.cname,manager.email,manager.mobilephone,manager.cvid,path,filename';
        $join = 'LEFT JOIN cvupload ON manager.cvid = cvupload.id';
        $condition = array('sort' => 'updatedate', 'order' => 'DESC', 'rows' => 10,);
        $managerList = $managerModel->search($map, $condition, false, $field, $join);
        $this->managerList = $managerList;
        $this->display();
    }

}
