<?php

/**
 * Description of CvmanagerController
 * 简历管理界面
 * @author hh
 */

namespace Company\Controller;

use Company\Controller\CompanyBaseController;

class CvmanagerController extends CompanyBaseController {

    /**
     * 简历列表
     */
    public function index() {
        //查询所有发布中的求职者简历列表
        $employeeModel = D('Employee');
        $map = array(
            'startdate' => array('elt', date('Y-m-d')),
            'enddate' => array('egt', date('Y-m-d')),
            'employee.status' => '01',
        );
        $field = 'employee.id,employee.managerid,employee.status,employee.startdate,employee.enddate,manager.jobtype,manager.area,manager.selfintroduce,manager.tag';
        $join = 'LEFT JOIN manager ON employee.managerid = manager.id';
        $condition = array('sort' => 'enddate, id', 'order' => 'DESC', 'rows' => 4,);
        $employeeList = $employeeModel->search($map, $condition, false, $field, $join);
        $this->employeeList = $employeeList;
        $this->display();
    }

    /**
     * 查看精英简历
     */
    public function viewmanager() {
        $employeeId = I('employeeid', 0, 'intval');
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
        $btmJs = array('company/viewmanager.js');
        $this->loadPlugin(array('jcountdown/jcountdown/jquery.jcountdown.min.js', 'artDialog4.1.7/artDialog.js?skin=black'), array('jcountdown/jcountdown/jcountdown.css'));
        $this->loadBottomJs($btmJs);

        $this->display();
    }

    /**
     * 获取企业职位列表
     */
    public function getCaseList() {
        $caseModel = D('Comcase');
        $companyId = session('companyid');
        $caseList = $caseModel->field('id,name')->where(array('companyid' => $companyId))->order('id DESC')->select();
        $this->ajaxReturn(array('status' => true, 'caselist' => $caseList), 'JSON');
    }

    /**
     * 简历竞拍
     */
    public function auctioncv() {
        $companyId = session('companyid');
        $companyModel = D('Company');
        $companyInfo = $companyModel->where(array('id' => $companyId))->find();
        if (!$companyInfo) {
            //企业信息不存在，返回错误
            $this->ajaxReturn(array('status' => false, 'errCode' => -1, 'errMsg' => '系统繁忙，请稍后再试'), 'JSON');
        }
        //验证公司信息是否完善
        if ($companyInfo['emailstatus'] != 1 || empty($companyInfo['companyname'])) {
            $this->ajaxReturn(array('status' => false, 'errCode' => -10, 'errMsg' => '请完善公司信息后再竞拍此简历', 'directURL' => U('/Company/Companymanager/index')), 'JSON');
        }
        $employeeId = I('get.employeeid', 0, 'intval');
        $employeeModel = D('Employee');
        $where = array(
            'id' => $employeeId,
            'status' => '01',
        );
        $employeeInfo = $employeeModel->where($where)->find();
        if (empty($employeeInfo)) {
            $this->ajaxReturn(array('status' => false, 'errCode' => -1, 'errMsg' => '竞拍失败，此简历不存在'), 'JSON');
        }
        if ($employeeInfo['auctionstatus']) {
            $this->ajaxReturn(array('status' => false, 'errCode' => -2, 'errMsg' => '您慢了一步，此简历已被竞拍'), 'JSON');
        }
        if ($employeeInfo['enddate'] < date('Y-m-d') || $employeeInfo['startdate'] > date('Y-m-d')) {
            $this->ajaxReturn(array('status' => false, 'errCode' => -3, 'errMsg' => '此求职者已经下线，不可竞拍'), 'JSON');
        }
        $updData = array(
            'auctionstatus' => 1,
            'auctioncompanyid' => session('companyid'),
            'auctiondate' => date('Y-m-d'),
        );
        $result = $employeeModel->where(array('id' => $employeeId))->save($updData);
        if ($result) {
            $this->ajaxReturn(array('status' => true), 'JSON');
        }
        $this->ajaxReturn(array('status' => false, 'errCode' => -4, 'errMsg' => '竞拍失败，请稍后再试'), 'JSON');
    }

    public function auctionlist() {
        $employeeModel = D('Employee');
        $map = array(
            'employee.status' => array('IN', array('01', '04')),
            'auctionstatus' => 1,
            'auctioncompanyid' => session('companyid'),
        );
        $condition = array(
            'sort' => 'auctiondate',
            'order' => 'DESC',
            'rows' => 10,
        );
        $field = 'employee.id,employee.managerid,employee.status,employee.startdate,employee.enddate,manager.jobtype,manager.area,manager.selfintroduce,manager.tag';
        $join = 'LEFT JOIN manager ON employee.managerid = manager.id';
        $employeeList = $employeeModel->search($map, $condition, false, $field, $join);
        $this->employeeList = $employeeList;
        $this->display();
    }

}
