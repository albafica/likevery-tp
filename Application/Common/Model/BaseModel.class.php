<?php

namespace Common\Model;

use Think\Model;

/**
 * Description of BaseModel
 * 基础模型类，提供模型基础方法
 * @author albafica.wang
 */
class BaseModel extends Model {

    /**
     * @param array         map 搜索条件
     * @param array         condition 排序方式等附加条件
     * @param array         relation 是否进行关联查询
     * @param array         fields 要搜索的字段
     * @return array        搜索结果，包括列表数据和分页信息
     */
    public function search($map = '', $condition = array(), $relation = false, $fields = '') {
        $count = $this->where($map)->count();
        //查询前$condition['count']条记录
        if (isset($condition['count']) && !empty($condition['count'])) {
            $count = ($condition['count'] <= $count) ? $condition['count'] : $count;
        }
        if (isset($condition['page']) && !empty($condition['page'])) {
            $_GET[C('VAR_PAGE')] = $condition['page'];
        }
        if (empty($fields)) {
            $fields = $this->fields;
            unset($fields['_autoinc']);
            unset($fields['_pk']);
            unset($fields['_type']);
        }
        if (isset($condition['sort']) && $condition['sort'] != '' && isset($condition['order']) && $condition['order'] != '') {
            $order = $condition['sort'] . " " . $condition['order'];
        } else {
            $order = $this->pk . ' desc';
        }
        $list_row = isset($condition['rows']) && !empty($condition['rows']) ? $condition['rows'] : C('PAGE_LISTROWS');
        $page = new \Think\Page($count, $list_row);
        $page->setConfig('theme', '%HEADER% 当前第%NOW_PAGE%页 %FIRST% %UP_PAGE%  %LINK_PAGE%  %DOWN_PAGE% %END%');
        if ($relation) {
            $list = $this->relation(true)->where($map)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
        } else {
            $list = $this->field($fields)->where($map)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
        }

        $show = $page->show();
        if ($list === null) {
            $list = array();
        }
        return array('total' => $count, 'rows' => $list, 'show' => $show);
    }

}
