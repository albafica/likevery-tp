<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index() {
        $this->display();
    }

    public function upload() {
        $upload = new \Think\Upload();
        // 简历附件最大2M
        $upload->maxSize = 2097152;
        $upload->exts = array('doc', 'docx');
        //只允许上传word文档
        $upload->mimes = array(
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword',
        );
        $upload->savePath = './CV/uncheck/'; // 设置附件上传目录
        $info = $upload->uploadOne($_FILES['resumes']);
        if (!$info) {
            // 上传错误提示错误信息        
            $this->error($upload->getError());
        } else {
            // 上传成功 获取上传文件信息        
            echo $info['savepath'] . $info['savename'];
        }
    }

}
