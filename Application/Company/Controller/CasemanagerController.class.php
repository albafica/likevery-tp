<?php

namespace Company\Controller;

use Company\Controller\CompanyBaseController;

class CasemanagerController extends CompanyBaseController {

    /**
     * 修改公司信息
     */
    public function index() {
        $caseModel = D('comcase');
        $where = array();
        $where['companyid'] = session('companyid');
        $result = 0;
        if (IS_POST) {
            $data = array();
            if (I('post.isshow') == "1") {
                if (I('post.id') != "") {
                    $where['id'] = I('post.id');
                    $result = $caseModel->where($where)->find();
                }
                if (!is_array($result)) {
                    $this->ajaxReturn(array("status" => 0, "message" => '获取失败'), 'JSON');
                } else {
                    $this->ajaxReturn(array("status" => 1, "message" => '获取成功', 'caseinfo' => $result), 'JSON');
                }
                exit();
            }
            if (I('post.isdelete') == "1") {
                if (I('post.id') != "") {
                    $where['id'] = I('post.id');
                    $result = $caseModel->where($where)->delete($data);
                }
                if ($result < 1) {
                    $this->ajaxReturn(array("status" => 0, "message" => '删除失败'), 'JSON');
                } else {
                    $this->ajaxReturn(array("status" => 1, "message" => '删除成功'), 'JSON');
                }
                exit();
            }

            $data['name'] = I('post.name');
            $data['salary'] = I('post.salary');
            $data['content'] = I('post.content');
            $data['tags'] = I('post.tags');
            $data['updatedate'] = date('Y-m-d H:i:s');
            $data['companyid'] = $where['companyid'];
            if (trim($data['name']) == "" || trim($data['salary']) == "" || trim($data['content']) == "") {
                $this->ajaxReturn(array("status" => 0, "message" => '参数异常'), 'JSON');
            }
            if (I('post.id') != "") {
                $data['id'] = I('post.id');
                $where['id'] = $data['id'];
                $result = $caseModel->where($where)->save($data);
            } else {
                $data['createdate'] = date('Y-m-d H:i:s');
                $result = $caseModel->add($data);
            }
            if ($result < 1) {
                $this->ajaxReturn(array("status" => 0, "message" => '保存失败'), 'JSON');
            } else {
                $this->ajaxReturn(array("status" => 1, "message" => '保存成功', 'caseid' => $result), 'JSON');
            }
            exit();
        }
        $caseInfo = $caseModel->field('id,name,content,salary,tags,createdate,updatedate')->where($where)->order('updatedate DESC')->select();
        $this->caseInfo = $caseInfo;
        $_btmJs[] = "company/casemanager.js";
        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black', 'My97DatePicker/WdatePicker.js'));
        $this->loadBottomJs($_btmJs);

        $this->display();
    }

    /**
     * 查看简历
     */
    public function viewCase() {
        $caseModel = D('comcase');
        $where = array();
        $where['companyid'] = session('companyid');
        if (IS_POST) {
            $data = array();
            if (I('post.isshow') == "1") {
                if (I('post.id') != "") {
                    $where['id'] = I('post.id');
                    $result = $caseModel->where($where)->find();
                }
                if (!is_array($result)) {
                    $this->ajaxReturn(array("status" => 0, "message" => '获取失败'), 'JSON');
                } else {
                    $this->ajaxReturn(array("status" => 1, "message" => '获取成功', 'caseinfo' => $result), 'JSON');
                } $this->ajaxReturn(array("status" => 1, "message" => '删除成功', 'caseinfo' => $result), 'JSON');
                exit();
            }
            $data['name'] = I('post.name');
            $data['salary'] = I('post.salary');
            $data['content'] = I('post.content');
            $data['tags'] = I('post.tags');
            $data['updatedate'] = date('Y-m-d H:i:s');
            $data['companyid'] = $where['companyid'];
            if (trim($data['name']) == "" || trim($data['salary']) == "" || trim($data['content']) == "") {
                $this->ajaxReturn(array("status" => 0, "message" => '参数异常'), 'JSON');
            }
            if (I('post.id') != "") {
                $data['id'] = I('post.id');
                $where['id'] = $data['id'];
                $result = $caseModel->where($where)->save($data);
            } else {
                $result = $caseModel->add($data);
            }
            if ($result < 1) {
                $this->ajaxReturn(array("status" => 0, "message" => '保存失败'), 'JSON');
            } else {
                $this->ajaxReturn(array("status" => 1, "message" => '保存成功'), 'JSON');
            }
            exit();
        }
        $where['id'] = I('id', 0, 'intval');
        $result = $caseModel->where($where)->find();
        $this->caseInfo = $result;
        $_btmJs[] = "company/casemanager.js";
        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black', 'My97DatePicker/WdatePicker.js'));
        $this->loadBottomJs($_btmJs);
        $this->display();
    }

}
