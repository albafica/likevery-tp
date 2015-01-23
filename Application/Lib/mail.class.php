<?php

namespace Lib;

/**
 * Description of mail
 *  邮件发送类
 * @author albafica.wang
 */
class mail {

    protected $_mail;               //邮件类示例对象
    protected $errMsg = '';         //错误信息

    public function __construct() {
        import('Lib/PHPMailer/PHPMailerAutoload');
        $this->_mail = new \PHPMailer();
        //设置邮件编码
        $this->_mail->CharSet = 'utf-8';
        //设置语言包
        $this->_mail->setLanguage('zh_cn');
        //判断发送邮件的方式，使用SMTP还是mail
        if (C('MAIL_TYPE') == 'SMTP') {
            $this->_mail->isSMTP();
            $this->_mail->Host = C('SMTP_PARAM.HOST');
            $this->_mail->Port = C('SMTP_PARAM.PORT');
            $this->_mail->SMTPSecure = C('SMTP_PARAM.SMTPSECURE');
            $this->_mail->SMTPAuth = C('SMTP_PARAM.SMTPAUTH');
            $this->_mail->Username = C('SMTP_PARAM.USERNAME');
            $this->_mail->Password = C('SMTP_PARAM.PASSWORD');
        } else {
            $this->_mail->isMail();
        }
    }

    /**
     * 发送邮件
     * @param string $subject           主题
     * @param string $content           邮件正文  
     * @param string $toAddress         收件人地址
     * @param string $toName            收件人姓名
     * @param string $fromAddress       发件人地址
     * @param string $fromName          发件人姓名
     * @param array $attach             邮件附件
     *                  path        附件地址
     *                  name        附件名称
     * @param string $replayAddress     回复地址
     * @param string $replayName        回复名称
     * @param array $cc                 抄送人地址
     * @param array $bcc                密送人地址
     * @return boolean                  是否发送成功
     */
    public function sendMail($subject, $content, $toAddress, $toName, $fromAddress, $fromName, $attach = array(), $replayAddress = '', $replayName = '', $cc = array(), $bcc = array()) {
        if (!\PHPMailer::validateAddress($toAddress)) {
            $this->errMsg = '收件人地址' . $toAddress . '不合法，邮件发送失败';
            return FALSE;
        }
        if (!empty($replayAddress)) {
            $this->_mail->addReplyTo($replayAddress, $replayName);
        }
        $this->_mail->From = $fromAddress;
        $this->_mail->FromName = $fromName;
        $this->_mail->addAddress($toAddress, $toName);
        //添加抄送人
        if (!empty($cc) && is_array($cc)) {
            foreach ($cc as $ccemail) {
                $this->_mail->addCC($ccemail);
            }
        }
        //添加密送地址
        if (!empty($bcc) && is_array($bcc)) {
            foreach ($bcc as $bccemail) {
                $this->_mail->addBCC($bccemail);
            }
        }
        $this->_mail->Subject = $subject;
        $body = <<<EOT
$content
EOT;
        //定义每行字符数
        $this->_mail->WordWrap = 80;
        $this->_mail->msgHTML($body, dirname(__FILE__), true); //Create message bodies and embed images
        //添加附件文件
        if (!empty($attach) && is_array($attach)) {
            foreach ($attach as $attachValue) {
                if (isset($attachValue['path']) && is_file($attachValue['path'])) {
                    $attachName = isset($attachValue['name']) ? $attachValue['name'] : '';
                    $this->_mail->addAttachment($attachValue['path'], $attachName);
                }
            }
        }
        try {
            $sendResult = $this->_mail->send();
            if (!$sendResult) {
                $this->errMsg = $this->_mail->ErrorInfo;
            }
            return $sendResult;
        } catch (\phpmailerException $e) {
            $this->errMsg = $e->getMessage();
            return false;
        }
    }

    /**
     * 返回错误信息
     * @return type
     */
    public function getErrMsg() {
        return $this->errMsg;
    }

}
