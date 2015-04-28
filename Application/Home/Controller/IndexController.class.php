<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index() {
        $this->display();
    }

    /**
     * 简历上传更新操作
     */
    public function upload() {
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
        $info = $upload->uploadOne($_FILES['resumes']);
        if (!$info) {
            // 上传错误提示错误信息        
            $this->error($upload->getError());
        } else {
            try {
                // 上传成功 获取上传文件信息,保存数据库
                $cvUploadModel = D('cvupload');
                $jobType = I('post.job_type', 1, 'intval');
                if (!in_array($jobType, array(1, 2, 3, 4))) {
                    $jobType = 1;
                }
                $cvData = array(
                    'path' => $info['savepath'] . $info['savename'],
                    'filename' => $info['name'],
                    'status' => '00',
                    'createdate' => date('Y-m-d H:i:s'),
                    'jobtype' => $jobType,
                );

                $addResult = $cvUploadModel->add($cvData);
            } catch (\Think\Exception $e) {
                $addResult = false;
            }

            if (!$addResult) {
                //添加记录失败，返回错误信息，同时删除上传的附件
                $fileHandle = new \Lib\FileHandle();
                $fileHandle->tryDelFile(C('UPLOAD_PATH') . $info['savepath'] . $info['savename']);
                $this->error('系统繁忙，简历上传失败，请稍后再试', '', 3);
            }
            $this->success('简历上传成功');
        }
    }

}
