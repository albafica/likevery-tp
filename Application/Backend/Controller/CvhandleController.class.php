<?php

namespace Backend\Controller;

use Backend\Controller\BackendBaseController;

/**
 * Description of CvHandleController
 *  简历处理业务逻辑控制器成
 * @author albafica.wang
 */
class CvHandleController extends BackendBaseController {

    public function __construct() {
        parent::__construct();
        $this->checkRight(self::HANDLECV);
        $this->loadBottomJs(array('backend/handlecv.js'));
        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black', 'My97DatePicker/WdatePicker.js'));
    }

    /**
     * 简历处理首页，列出所有未分配的简历
     */
    public function index() {
        $cvUploadModel = D('Cvupload');
        //查询未处理或者通过初审的未分配的简历
        $map = array(
            'isassigned' => '0',
            '_string' => "status = '00' OR status = '01'",
        );
        $field = 'id,filename,createdate,status,jobtype';
        $condition = array('sort' => 'createdate', 'order' => 'ASC', 'rows' => 10,);
        $cvList = $cvUploadModel->search($map, $condition, false, $field);
        $this->cvList = $cvList;
        $this->display();
    }

    /**
     * 获取分配给我的未处理简历列表
     */
    public function mycv() {
        $cvUploadModel = D('Cvupload');
        $map = array(
            'isassigned' => '1',
            'status' => '00',
            'assignerid' => session('userid'),
        );
        $field = 'id,path,filename,createdate,jobtype';
        $condition = array('sort' => 'createdate', 'order' => 'ASC', 'rows' => 10,);
        $cvList = $cvUploadModel->search($map, $condition, false, $field);
        $this->cvList = $cvList;
        $this->display();
    }

    /**
     * 我初审通过的简历列表
     */
    public function simplePassedCv() {
        $cvUploadModel = D('Cvupload');
        $map = array(
            'status' => '01',
            'isassigned' => '1',
            'assignerid' => session('userid'),
        );
        $field = 'id,path,filename,operadate,operatorid,operatorname,cname,email,mobilephone,jobtype';
        $condition = array('sort' => 'operadate', 'order' => 'ASC', 'rows' => 10,);
        $cvList = $cvUploadModel->search($map, $condition, false, $field);
        $this->cvList = $cvList;
        $this->display();
    }

    /**
     * 将简历分配给自己
     */
    public function assigncv() {
        $cvid = I('cvid', 0, 'intval');
        if ($cvid <= 0) {
            $this->error('该简历不存在或者已被分配');
        }
        $cvUploadModel = D('Cvupload');
        $data = array(
            'isassigned' => '1',
            'assignerid' => session('userid'),
            'assignername' => cookie('username'),
            'assigndate' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'isassigned' => '0',
            'id' => $cvid,
        );
        $result = $cvUploadModel->where($where)->save($data);
        if ($result == 0) {
            //未更新到数据
            $this->error('该简历不存在或者已被分配');
        }
        $this->success('简历分配成功');
    }

    /**
     * 放弃分配
     */
    public function cancelassigncv() {
        $cvid = I('cvid', 0, 'intval');
        if ($cvid <= 0) {
            $this->error('该简历不存在或者未被分配');
        }
        $cvUploadModel = D('Cvupload');
        $data = array(
            'isassigned' => '0',
            'assignerid' => null,
            'assignername' => null,
            'assigndate' => null,
        );
        $where = array(
            'isassigned' => '1',
            'assignerid' => session('userid'),
            'id' => $cvid,
        );
        $result = $cvUploadModel->where($where)->save($data);
        if ($result == 0) {
            //未更新到数据
            $this->error('该简历不存在或者未被分配');
        }
        $this->success('简历已取消分配');
    }

    /**
     * 删除简历
     */
    public function delcv() {
        $cvid = I('cvid', 0, 'intval');
        if ($cvid <= 0) {
            $this->error('该简历不存在或者已被删除');
        }
        $cvUploadModel = D('Cvupload');
        $data = array(
            'status' => '06',
            'operatorid' => session('userid'),
            'operatorname' => cookie('cname'),
            'operadate' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'status' => '00',
            'isassigned' => '1',
            'assignerid' => session('userid'),
            'id' => $cvid,
        );
        $cvInfo = $cvUploadModel->field('id,path')->where($where)->find();
        if (empty($cvInfo)) {
            $this->error('该简历不存在或者已被删除');
        }
        $result = $cvUploadModel->where($where)->save($data);
        if ($result == 0) {
            //未更新到数据
            $this->error('该简历不存在或者已被删除');
        }
        //删除简历文件
        $fileHandle = new \Lib\FileHandle();
        $fileHandle->tryDelFile(C('UPLOAD_PATH') . $cvInfo['path']);
        $this->success('简历已删除');
    }

    /**
     * 初审简历
     */
    public function simpleHandle() {
        $cvid = I('cvid', 0, 'intval');
        if (!IS_AJAX) {
            $this->error('错误的访问方式', U('Backend/Index/index'));
        }
        if ($cvid <= 0) {
            $this->ajaxReturn(array('status' => 0, 'message' => '请求错误'));
        }
        $cname = I('post.cname', '', 'trim');
        $mobilephone = I('post.mobilephone', '', 'trim');
        $email = I('post.email', '', 'trim');
        $jobtype = I('post.jobtype', 5);
        $jobtype = in_array($jobtype, array(1, 2, 3, 4, 5)) ? $jobtype : 5;
        if (empty($cname) || (empty($mobilephone) && empty($email))) {
            $this->error('姓名必填，手机和邮箱必填一个');
        }
        $cvModel = D('Cvupload');
        $data = array(
            'cname' => $cname,
            'mobilephone' => $mobilephone,
            'email' => $email,
            'jobtype' => $jobtype,
            'status' => '01',
            'operatorid' => session('userid'),
            'operatorname' => cookie('cname'),
            'operadate' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'id' => $cvid,
            'status' => '00',
        );
        $result = $cvModel->where($where)->save($data);
        $returnData = array(
            'status' => $result ? 1 : 0,
            'message' => $result ? '初审成功' : '简历不存在或者已被初审通过，审核失败',
        );
        $this->ajaxReturn($returnData);
    }

    /**
     * 正式审核简历
     */
    public function auditcv() {
        $cvid = I('cvid', 0, 'intval');
        if (IS_POST) {
            $managerModel = D('Manager');
            $result = $managerModel->addManager();
            if (!$result[0]) {
                $this->error($result[1]);
            } else {
                $this->success('审核成功', U('Backend/Cvhandle/simplePassedCv'));
            }
            exit();
        }
        $cvModel = D('Cvupload');
        //根据id获取简历基本信息
        $where = array(
            'id' => $cvid,
            'status' => '01',
            'isassigned' => 1,
            'assignerid' => session('userid'),
        );
        $field = 'id,path,filename,cname,email,mobilephone,jobtype';
        $cvInfo = $cvModel->field($field)->where($where)->find();
        if (empty($cvInfo)) {
            $this->error('简历不存在或者尚未通过初审，不可审核');
        }
        $this->cvInfo = $cvInfo;
        $this->display();
    }

    /**
     * 简历审核不通过
     */
    public function unAuditcv() {
        $cvid = I('get.cvid', 0, 'intval');
        $cvModel = D('Cvupload');
        //根据id获取简历基本信息
        $where = array(
            'id' => $cvid,
            'status' => '01',
            'isassigned' => 1,
            'assignerid' => session('userid'),
        );
        $data = array(
            'status' => '03',
            'operatorid' => session('userid'),
            'operatorname' => cookie('cname'),
            'operadate' => date('Y-m-d H:i:s'),
        );
        $result = $cvModel->where($where)->save($data);
        if (!$result) {
            $this->error('操作失败。' . $cvModel->getDbError());
        } else {
            $this->success('操作成功', U('Backend/Cvhandle/simplePassedCv'));
        }
    }

    /**
     * 下载简历
     */
    public function downloadcv() {
        $fileDownload = new \Lib\FileDownload();
        $realFilePath = C('UPLOAD_PATH') . str_replace(array('../', './'), array('', ''), I('filePath', '', 'base64_decode'));
        $fileName = I('filename', '', 'base64_decode');
        if (empty($fileName)) {
            $this->error('未找到文件');
        }
        $result = $fileDownload->downloadFile($realFilePath, $fileName);
        if (!$result) {
            $this->error($fileDownload->getErrMsg());
        }
    }

    /**
     * 覆盖旧简历
     */
    public function coverCV() {
        //检验旧简历信息
        $cvId = I('post.cvid', 0, 'intval');
        $cvModel = D('Cvupload');
        $where = array(
            'id' => $cvId,
            'status' => '01',
            'isassigned' => 1,
            'assignerid' => session('userid'),
        );
        $cvInfo = $cvModel->field('id')->where($where)->find();
        if (empty($cvInfo)) {
            $this->error('上传失败，请稍后重试', U('Backend/Cvhandle/simplePassedCv'));
            exit();
        }
        $upload = new \Think\Upload();
        // 简历附件最大2M
        $upload->maxSize = 2097152;
        $upload->exts = array('doc', 'docx');
        //只允许上传word文档
        $upload->mimes = array(
//            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
//            'application/msword',
        );
        $upload->savePath = 'CV/uncheck/'; // 设置附件上传目录
        $upload->rootPath = C('UPLOAD_PATH');
        $info = $upload->uploadOne($_FILES['uploadNewCv']);
        if (!$info) {
            // 上传错误提示错误信息        
            $this->error($upload->getError(), U('Backend/Cvhandle/simplePassedCv'));
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
                $this->error('系统繁忙，简历上传失败，请稍后再试', U('Backend/Cvhandle/simplePassedCv'), 3);
            }
            $this->success('简历上传成功');
        }
    }

}
