<?php

namespace Company\Controller;

use Common\Controller\BaseController;

class IndexController extends BaseController {

    public function index() {
        layout('Layout/companylayout');
        $_btmJs[] = "company/login.js";
        $this->loadBottomJs($_btmJs);
        $this->display();
    }

    public function login() {
        if (session('companyid') > 0) {
            $this->redirect('Company/Cvmanager/index');
        }
        if (IS_AJAX) {
            $isLogin = I('post.isLogin', '', 'trim');
            $choseType = I('post.choseType', '', 'trim');
            $loginName = I('post.loginName', '', 'trim');
            $loginPass = I('post.loginPass', '', 'trim');
            if ($loginName == "") {
                $this->error('公司邮箱不可为空');
            }

            if ($loginPass == "") {
                $this->error('登陆密码不可为空');
            }
            if ($isLogin != 0) {
                //登陆逻辑
                $where = array(
                    'email' => $loginName
                );
                $companyDll = D('Company');
                $companyInfo = $companyDll->where($where)->find();
                if (count($companyInfo) < 1 || $companyInfo['status'] != '01' || $companyInfo['password'] != md5(md5($loginName) . $loginPass)) {
                    $this->ajaxReturn(array("status" => 0, "info" => '公司邮箱或密码不正确！'), 'JSON');
                }
                $companyId = $companyInfo['id'];
            } else {
                //注册逻辑
                $where = array(
                    'email' => $loginName
                );
                $companyDll = D('Company');
                $companyInfo = $companyDll->where($where)->find();
                if (count($companyInfo) > 0 && $companyInfo['status'] == '01') {
                    $this->ajaxReturn(array("status" => 0, "info" => '该邮箱已被注册！'), 'JSON');
                }
                $companyDll->password = md5(md5($loginName) . $loginPass);
                $companyDll->email = $loginName;
                $companyDll->status = '01';
                $companyDll->createdate = date('Y-m-d H:i:s');
                $companyDll->updatedate = date('Y-m-d H:i:s');
                $companyId = $companyDll->add();
                if ($companyId < 1) {
                    $this->ajaxReturn(array("status" => 0, "info" => '注册失败！' . $userModel->getError()), 'JSON');
                }
                //发送注册邮件
                $companyDll->sendValidEmil($companyId);
                if ($choseType != "") {
                    $arrType = explode(",", $choseType);
                    if (count($arrType) > 0) {
                        foreach ($arrType as $value) {
                            if (in_array($value, array(1, 2, 3, 4, 5))) {
                                $subscriptionDll = D('Subscription');
                                $subscriptionDll->type = $value;
                                $subscriptionDll->companyid = $companyId;
                                $result = $subscriptionDll->add();
                                if ($result < 1) {
//                                    $this->ajaxReturn(array("status" => 0, "info" => '注册失败！' . $userModel->getError()), 'JSON');
                                }
                            }
                        }
                    }
                }
            }
            session('companyid', $companyId);
            $direct = 0;
//            if ($companyInfo['emailstatus'] == 1 && !empty($companyInfo['cname'])) {
//                $direct = 1;
//            }
            $this->ajaxReturn(array("status" => 1, "info" => '成功', 'direct' => $direct), 'JSON');
            exit();
        }
        layout('Layout/companylayout');
        $_btmJs[] = "company/login.js";
        $this->loadBottomJs($_btmJs);
        $this->display();
    }

    public function register() {
        if (IS_AJAX) {
            $this->login();
        }
        layout('Layout/companylayout');
        $_btmJs[] = "company/login.js";
        $this->loadBottomJs($_btmJs);
        $this->display();
    }

    public function logout() {
        session('companyid', null);
        $this->redirect('/Company/Index/index');
    }

    public function chkemail() {
        $companyId = I('companyid');
        $chkcode = I('chkcode');
        $companyModel = D('Company');
        $where = array('id' => $companyId, 'chkcode' => $chkcode);
        $companyInfo = $companyModel->where($where)->find();
        if (!$companyInfo) {
            $this->error('参数错误,验证失败', U('/Company/Index/index'));
            exit();
        }
        if ($companyInfo['emailstatus'] == 1) {
            $this->success('验证通过', U('/Company/Cvmanager/index'));
            exit();
        }
        $data = array(
            'emailstatus' => 1,
            'updatedate' => date('Y-m-d H:i:s'),
        );
        $result = $companyModel->where(array('id' => $companyId,))->save($data);
        if ($result) {
            $this->success('验证通过', U('/Company/Cvmanager/index'));
            exit();
        }
        $this->error('参数错误,验证失败', U('/Company/Index/index'));
        exit();
    }
   
}
