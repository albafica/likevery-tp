<?php

namespace Backend\Controller;

use Backend\Controller\BaseController;

/**
 * Description of CvHandleController
 *  简历处理业务逻辑控制器成
 * @author albafica.wang
 */
class CvHandleController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->checkRight(self::HANDLECV);
    }

    /**
     * 简历处理首页，列出所有未分配的简历
     */
    public function index() {
        $cvUploadModel = D('Cvupload');
        $map = array(
            'status' => '00',
        );
        $field = 'id,filename,createdate';
        $condition = array('sort' => 'createdate', 'order' => 'ASC', 'rows' => 10,);
        $cvList = $cvUploadModel->search($map, $condition, false, $field);
        $this->cvList = $cvList;
        $this->display();
    }

    /**
     * 获取分配给我的简历列表
     */
    public function mycv() {
        $cvUploadModel = D('Cvupload');
        $map = array(
            'status' => '01',
            'assignerid' => session('userid'),
        );
        $field = 'id,path,filename,createdate';
        $condition = array('sort' => 'createdate', 'order' => 'ASC', 'rows' => 10,);
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
            'status' => '01',
            'assignerid' => session('userid'),
            'assignername' => cookie('username'),
            'assigndate' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'status' => '00',
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
            'status' => '00',
            'assignerid' => null,
            'assignername' => null,
            'assigndate' => null,
        );
        $where = array(
            'status' => '01',
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
            'operatorname' => cookie('username'),
            'operadate' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'status' => '01',
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
     * 简历审核通过
     */
    public function checkcv() {
        
    }

    /**
     * 简历审核不通过
     */
    public function unchkcv() {
        $cvid = I('cvid', 0, 'intval');
        if ($cvid <= 0) {
            $this->error('该简历不存在或者已被处理');
        }
        $cvUploadModel = D('Cvupload');
        $data = array(
            'status' => '03',
            'operatorid' => session('userid'),
            'operatorname' => cookie('username'),
            'operadate' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'status' => '01',
            'assignerid' => session('userid'),
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

}
