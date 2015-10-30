<?php

namespace Company\Controller;

use Company\Controller\CompanyBaseController;

class CompanymanagerController extends CompanyBaseController {

    /**
     * 修改公司信息
     */
    public function index() {
        $companyModel = D('Company');
        if (IS_POST) {
            $data = array();
            $data['companyname'] = I('post.companyname');
            $data['address'] = I('post.address');
            $data['contact'] = I('post.contact');
            $data['mobilephone'] = I('post.mobilephone');
            $data['url'] = I('post.url');
            $data['updatedate'] = date('Y-m-d H:i:s');
            $data['degree'] = array('exp', "IF(degree = 'A', 'B', degree)");
            $result = $companyModel->where(array('id' => session('companyid')))->save($data);
            if ($result) {
                $this->success('更新成功', U('/Company/Companymanager/index'));
            } else {
                $this->error('更新失败', U('/Company/Companymanager/index'));
            }
            exit();
        }
        $companyInfo = $companyModel->field('companyname,address,contact,mobilephone,url')->where(array('id' => session('companyid')))->find();
        $this->companyInfo = $companyInfo;
        $this->display();
    }

    public function cvroleset() {
        $subscriptionModel = D('Subscription');
        if (IS_POST) {
            if (I('post.type') > 0 && I('post.type') < 5) {
                $where = array(
                    'type' => I('post.type'),
                    'companyid' => session('companyid')
                );
                $result = $subscriptionModel->where($where)->delete();
                if (I('post.isadd') == "0") {
                    if ($result == false) {
                        $this->ajaxReturn(array("status" => 0, "info" => '保存失败'), 'JSON');
                    } else {

                        $this->ajaxReturn(array("status" => 1, "info" => '保存成功'), 'JSON');
                    }
                }
                if (I('post.isadd') == "1") {
                    $subscriptionModel->type = I('post.type');
                    $subscriptionModel->companyid = session('companyid');
                    $result = $subscriptionModel->add($where);
                    if ($result < 1) {
                        $this->ajaxReturn(array("status" => 0, "info" => '保存失败'), 'JSON');
                    } else {
                        $this->ajaxReturn(array("status" => 1, "info" => '保存成功'), 'JSON');
                    }
                }
            }
            exit();
        }
        $subscriptionList = $subscriptionModel->where(array('companyid' => session('companyid')))->select();
        $subscriptionArr = array();
        if (count($subscriptionList) > 0) {
            foreach ($subscriptionList as $value) {
                $subscriptionArr[$value["type"]] = $value["type"];
            }
        }
        $_btmJs[] = "company/cvroleset.js";
        $this->loadBottomJs($_btmJs);

        $this->subscriptionArr = $subscriptionArr;
        $this->display();
    }

}
