<?php

namespace Company\Controller;

use Company\Controller\CompanyBaseController;

class ViewmanagerController extends CompanyBaseController {

    /**
     * 简历库列表
     */
    public function index() {
        $this->display();
    }

    /**
     * 查看精英简历
     */
    public function viewmanager() {
        $employeeId = I('employeeid', 11, 'intval');
        $employeeModel = D('Employee');
        $where = array(
            'id' => $employeeId,
            'status' => '01',
        );
        $employeeInfo = $employeeModel->where($where)->find();
        if (empty($employeeInfo)) {
            $this->error('该求职者简历不存在或者已经下线');
            exit();
        }
        $managerModel = D('Manager');
        $map = array(
            'id' => $employeeInfo['managerid'],
            'status' => '01',
            'releasestatus' => '01',
        );
        $managerInfo = $managerModel->where($map)->find();
        if (empty($managerInfo)) {
            $this->error('该求职者简历不存在或者已经下线');
            exit();
        }
        $this->employeeInfo = $employeeInfo;
        $this->managerInfo = $managerInfo;
        $tagArr = array();
        if (!empty($managerInfo['tag'])) {
            $tagArr = explode(' ', $managerInfo['tag']);
        }
        $this->tagArr = $tagArr;
        echo '<script>var timeText = "' . date('Y/m/d H:i:s', strtotime($employeeInfo['enddate'] . ' 00:00:00')) . '";</script>';
        $this->loadPlugin(array('jcountdown/jcountdown/jquery.jcountdown.min.js'), array('jcountdown/jcountdown/jcountdown.css'));
        $btmJs = array('company/viewmanager.js');
        $this->loadBottomJs($btmJs);

        $this->display();
    }

}
