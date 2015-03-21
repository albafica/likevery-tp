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
        $this->loadBottomJs(array('backend/handlemanager.js'));
        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black', 'My97DatePicker/WdatePicker.js'));
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
        $field = 'manager.id,manager.jobtype,manager.cname,manager.email,manager.mobilephone,releasestatus,manager.cvid,path,filename';
        $join = 'LEFT JOIN cvupload ON manager.cvid = cvupload.id';
        $condition = array('sort' => 'updatedate', 'order' => 'DESC', 'rows' => 10,);
        $managerList = $managerModel->search($map, $condition, false, $field, $join);
        $this->managerList = $managerList;
        $this->display();
    }

    /**
     * 编辑求职者简历
     */
    public function editManager() {
        $managerModel = D('Manager');
        if (IS_POST) {
            $result = $managerModel->editManager();
            if (!$result[0]) {
                $this->error($result[1]);
            } else {
                $this->success('保存成功', U('Backend/Manager/index'));
            }
            exit();
        }
        $managerId = I('managerid', 0, 'intval');
        $managerInfo = $managerModel->find($managerId);
        if (empty($managerInfo)) {
            $this->error('求职者信息查询出错，请稍后再试', U('Backend/Manager/index'));
            exit();
        }
        $this->managerInfo = $managerInfo;
        $this->display();
    }

    /**
     * 覆盖旧简历
     */
    public function coverCV() {
        //检验旧简历信息
        $managerId = I('post.managerid', 0, 'intval');
        $cvId = I('post.cvid', 0, 'intval');
        $managerModel = D('Manager');
        $where = array(
            'id' => $managerId,
            'cvid' => $cvId,
            'status' => '01',
        );
        $managerInfo = $managerModel->field('id')->where($where)->find();
        if (empty($managerInfo)) {
            $this->error('上传失败，请稍后重试', U('Backend/Manager/index'));
            exit();
        }
        $upload = new \Think\Upload();
        // 简历附件最大2M
        $upload->maxSize = 2097152;
        $upload->exts = array('doc', 'docx');
        //只允许上传word文档
        $upload->mimes = array(
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword',
        );
        $upload->savePath = 'CV/uncheck/'; // 设置附件上传目录
        $upload->rootPath = C('UPLOAD_PATH');
        $info = $upload->uploadOne($_FILES['uploadNewCv']);
        if (!$info) {
            // 上传错误提示错误信息        
            $this->error($upload->getError(), U('Backend/Manager/index'));
        } else {
            try {
                // 上传成功 获取上传文件信息,保存数据库
                $cvUploadModel = D('cvupload');
                $cvData = array(
                    'id' => $cvId,
                    'path' => $info['savepath'] . $info['savename'],
                    'filename' => $info['name'],
                    'operatorid' => session('userid'),
                    'operatorname' => cookie('cname'),
                    'operadate' => date('Y-m-d H:i:s'),
                );
                $addResult = $cvUploadModel->save($cvData);
            } catch (\Think\Exception $e) {
                $addResult = false;
            }

            if (!$addResult) {
                //添加记录失败，返回错误信息，同时删除上传的附件
                $fileHandle = new \Lib\FileHandle();
                $fileHandle->tryDelFile(C('UPLOAD_PATH') . $info['savepath'] . $info['savename']);
                $this->error('系统繁忙，简历上传失败，请稍后再试', U('Backend/Manager/index'), 3);
            }
            $this->success('简历上传成功');
        }
    }

    /**
     * 发布此求职者信息
     */
    public function releaseManager() {
        $managerId = I('managerid', 0, 'intval');
        $managerModel = D('Manager');
        $employeeModel = D('Employee');
        $employeeModel->startTrans();
        $employeedata = array(
            'managerid' => $managerId,
            'status' => '01',
            'startdate' => date('Y-m-d'),
            'enddate' => date('Y-m-d', strtotime('+16 days')), //有效期半个月
        );
        $result = $employeeModel->add($employeedata);
        //2、更新简历信息
        $where = array(
            'id' => $managerId,
            'releasestatus' => '00',
            'status' => '01',
        );
        $updData = array(
            'releasestatus' => '01',
        );
        $result2 = $managerModel->where($where)->save($updData);
        if ($result && $result2) {
            $employeeModel->commit();
            $this->success('发布成功', U('Backend/Manager/index'));
        } else {
            $employeeModel->rollback();
            $this->error('发布失败，请稍后再试', U('Backend/Manager/index'));
        }
    }

}
