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
        $this->loadBottomJs(array('backend/handlecv.js'));
        $this->loadPlugin(array('artDialog4.1.7/artDialog.js?skin=black'));
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
        $field = 'id,filename,createdate,status';
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
        $field = 'id,path,filename,createdate';
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
        $field = 'id,path,filename,operadate,operatorid,operatorname,cname,email,mobilephone';
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
        if (IS_POST) {
            $cname = I('post.cname', '', 'trim');
            $mobilephone = I('post.mobilephone', '', 'trim');
            $email = I('post.email', '', 'trim');
            if (empty($cname) || (empty($mobilephone) && empty($email))) {
                $this->error('姓名必填，手机和邮箱必填一个');
            }
            $cvModel = D('Cvupload');
            $data = array(
                'cname' => $cname,
                'mobilephone' => $mobilephone,
                'email' => $email,
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
            if ($result == 0) {
                //未更新到数据
                $this->error('该简历不存在,初审失败');
            }
            $this->success('简历初审成功', U('Backend/CvHandle/mycv'));
            exit();
        }
        $this->cvid = $cvid;
        $this->display();
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
