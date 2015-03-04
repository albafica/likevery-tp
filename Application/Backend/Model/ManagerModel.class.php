<?php

namespace Backend\Model;

use Common\Model\BaseModel;

/**
 * Description of ManagerModel
 *  求职者模型
 * @author albafica.wang
 */
class ManagerModel extends BaseModel {

    /**
     * 添加求职者信息
     */
    public function addManager() {
        $cvid = I('post.cvid', 0, 'intval');
        $cname = I('post.cname', '', 'trim');
        $ename = I('post.ename', '', 'trim');
        $email = I('post.email', '', 'trim');
        $mobilephone = I('post.mobilephone', '', 'trim');
        $tel = I('post.tel', '', 'trim');
        $gender = I('post.gender', 0, 'intval');
        $brithday = I('post.brithday', '', 'trim');
        $homepage = I('post.homepage', '', 'trim');
        $targetposition = I('post.targetposition', '', 'trim');
        $getjobtime = I('post.getjobtime', '', 'trim');
        $area = I('post.area', '', 'trim');
        $targetarea = I('post.targetarea', '', 'trim');
        $edulevel = I('post.edulevel', 0, 'intval');
        $workyear = I('post.workyear', 0, 'intval');
        $salary = I('post.salary', '', 'trim');
        $targetsalary = I('post.targetsalary', '', 'trim');
        $tag = I('post.tag', '', 'trim');
        $selfintroduce = I('post.selfintroduce', '', 'trim');
        $memo = I('post.memo', '', 'trim');
        if (empty($cvid) || empty($cname) || (empty($mobilephone) && empty($email)) || empty($targetposition) || empty($tag)) {
            return array(FALSE, '姓名、联系方式，期望职位，标签等必填字段不可为空');
        }
        if (!empty($mobilephone) && !isFormat($mobilephone, 'I4')) {
            return array(FALSE, '手机格式不正确');
        }
        if (!empty($email) && !isFormat($email, 'S0')) {
            return array(FALSE, '邮件格式不正确');
        }
        $data = array(
            'cname' => $cname,
            'ename' => $ename,
            'email' => $email,
            'mobilephone' => $mobilephone,
            'tel' => $tel,
            'gender' => $gender,
            'brithday' => $brithday,
            'homepage' => $homepage,
            'targetposition' => $targetposition,
            'getjobtime' => $getjobtime,
            'area' => $area,
            'targetarea' => $targetarea,
            'edulevel' => $edulevel,
            'workyear' => $workyear,
            'salary' => $salary,
            'targetsalary' => $targetsalary,
            'tag' => $tag,
            'selfintroduce' => $selfintroduce,
            'memo' => $memo,
            'cvid' => $cvid,
            'createdate' => date('Y-m-d'),
            'status' => '01',
        );
        //1、插入精英信息
        $this->startTrans();
        $result = $this->add($data);
        //2、更新简历信息
        $where = array(
            'id' => $cvid,
            'status' => '01',
            'isassigned' => 1,
            'assignerid' => session('userid'),
        );
        $updData = array(
            'status' => '02',
            'operatorid' => session('userid'),
            'operatorname' => cookie('cname'),
            'operadate' => date('Y-m-d H:i:s'),
        );
        $result2 = D('Cvupload')->where($where)->save($updData);
        if ($result && $result2) {
            $this->commit();
            return array(true);
        } else {
            $this->rollback();
            return array(false, $this->getDbError());
        }
    }

}
