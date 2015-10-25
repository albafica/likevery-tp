<?php

/**
 * Description of CompanyController
 * 求职者相关控制器
 * @author albafica.wang
 */

namespace Backend\Controller;

use Backend\Controller\BackendBaseController;

class CompanyController extends BackendBaseController {

    public function __construct() {
        parent::__construct();
        //求职者管理权限和简历管理权限一致
        $this->checkRight(self::HANDLECV);
        $this->loadBottomJs(array('backend/handlemanager.js'));
        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black', 'My97DatePicker/WdatePicker.js'));
    }

    public function index() {
        $objModel = D('Company');
        //获取所有求职者信息列表
        $map = array();
        $map['status'] = array('NEQ', '06');
        $field = 'id,loginname,companyname,contact,mobilephone,email,createdate,updatedate,address,url,degree,auctioncvcount,getcvcount,status';
        $condition = array('sort' => 'updatedate', 'order' => 'DESC', 'rows' => 10,);
        $result = $objModel->search($map, $condition, false, $field);
        $this->List = $result;
        $this->display();
    }

    /**
     * 查看
     */
    public function viewCompany() {
        $Id = I('id', 0, 'intval');
        if ($Id < 1) {
            $this->error('参数错误', U('Backend/Company/index'));
            exit();
        }

        $objModel = D('Company');
        $objInfo = $objModel->find($Id);
        if (empty($objInfo)) {
            $this->error('该企业不存在');
            exit();
        }
        $this->objInfo = $objInfo;
        $this->display();
    }

    /**
     * 编辑用户
     */
    public function editCompany() {
        $Id = I('id', 0, 'intval');
        if ($Id < 1) {
            $this->error('参数错误', U('Backend/Company/index'));
            exit();
        }

        $objModel = D('Company');
        $objInfo = $objModel->find($Id);
        if (empty($objInfo)) {
            $this->error('该企业不存在');
            exit();
        }
        if (IS_POST) {
            $objWhere = array(
                'id' => $Id,
            );
            //loginname,companyname,contact,mobilephone,email,address,url,degree
            $companyname = I('post.companyname', '', 'trim');
            $contact = I('post.contact', '', 'trim');
            $mobilephone = I('post.mobilephone', '', 'trim');
            $email = I('post.email', '', 'trim');
            $address = I('post.address', '', 'trim');
            $url = I('post.url', '', 'trim');
            $objData = array(
                'loginname' => $loginname,
                'companyname' => $companyname,
                'contact' => $contact,
                'mobilephone' => $mobilephone,
                'email' => $email,
                'address' => $address,
                'url' => $url,
            );
            $result = $objModel->where($objWhere)->save($objData);
            if ($result == 0) {
                $this->error('企业信息修改失败:' . $userModel->getError());
            } else {
                $this->error('保存成功', U('Backend/Company/index'));
            }
            exit();
        }

        $this->objInfo = $objInfo;
        $this->display();
    }

    public function delete() {
        $Id = I('id', 0, 'intval');
        if ($Id < 1) {
            $this->error('参数错误', U('Backend/Company/index'));
            exit();
        }
        $updWhere = array(
            'id' => $Id,
        );

        $updData = array();
        $updData['status'] = '06';
        $updData['updatedate'] = date('Y-m-d');

        $objModel = D('Company');
        $result = $objModel->where($updWhere)->save($updData);
        if ($result) {
            $this->success('操作成功');
        } else {
            $this->success('操作失败');
        }
    }

}
