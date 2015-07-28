<?php

/**
 * Description of CvmailController
 * 订阅邮件控制器
 * @author albafica.wang
 */

namespace Backend\Controller;

use Backend\Controller\BaseController;

class CvmailController extends BaseController {

    public function __construct() {
        parent::__construct();
        //求职者管理权限和简历管理权限一致
        $this->checkRight(self::HANDLECV);
    }

    public function index() {
        $objModel = D('Cvmail');
        $status = I('post.status');
        $this->status = $status;
        if ($status == 1) {
            $status = '01';
        } elseif ($status == 2) {
            $status = '00';
        } else {
            $status = '';
        }
        $map = array();
        if (!empty($status)) {
            $map['cvmail.status'] = array('eq', $status);
        } else {
            $map['cvmail.status'] = array('neq', '06');
        }

        $field = 'cvmail.id,cvmail.createdate,cvmail.content,cvmail.updatedate,cvmail.companyid,cvmail.managerid,cvmail.status,manager.cname,company.companyname';
        $join = 'LEFT JOIN manager ON manager.id = cvmail.managerid LEFT JOIN company ON company.id=cvmail.companyid';
        $condition = array('sort' => 'cvmail.id', 'order' => 'DESC', 'rows' => 10,);
        $result = $objModel->search($map, $condition, false, $field, $join);
        $this->List = $result;
        $this->display();
    }

    /**
     * 发送邮件
     */
    public function sendmail() {
        set_time_limit(0);
        $objModel = D('Cvmail');
        $map = array(
            'cvmail.status' => array('eq', '00'),
            'company.status' => array('eq', '01'),
            'company.email' => array('neq', ''),
        );
        $field = 'cvmail.id,cvmail.content,company.email,company.contact';
        $join = 'LEFT JOIN company on cvmail.companyid = company.id';
        $mailList = $objModel->field($field)->where($map)->join($join)->limit('0,10')->select();
        if (empty($mailList)) {
            $this->success('发送成功', U('Backend/Cvmail/sendmail'));
            exit();
        }
        $mail = new \Lib\Mail();
        $errNum = $succNum = 0;
        foreach ($mailList as $mail) {
            $mailResult = $mail->sendMail('订阅邮件', $mail['content'], $mail['email'], $mail['contact']);
            if (!$mailResult) {
                $errNum++;
                continue;
            }
            $data = array('status' => '01', 'id' => $mail['id']);
            $objModel->save($data);
            $succNum++;
        }
        $this->success('发送成功,其中成功' . $succNum . '封，失败' . $errNum . '封', U('Backend/Cvmail/sendmail'));
    }

}
