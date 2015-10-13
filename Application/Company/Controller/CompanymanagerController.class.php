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
            $data['updatedate'] = date('Y-m-d');
            $data['id'] = session('companyid');
            $result = $companyModel->save($data);
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
            
        }
        $subscriptionList = $subscriptionModel->where(array('companyid' => session('companyid')))->find();
        $subscriptionArr = array();
        if(isset($subscriptionInfo['type']) && !empty($subscriptionInfo['type'])){
            $subscriptionArr = explode(',', $subscriptionInfo['type']);
        }
        $this->subscriptionArr = $subscriptionArr;
        $this->display();
    }

}
