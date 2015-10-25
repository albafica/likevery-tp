<?php

namespace Common\Controller;

use Think\Controller;

/**
 * 控制器基类，提供基础方法
 */
class BaseController extends Controller {

    const HANDLECV = 0;
    const ADMINRIGHT = -1;

    /**
     * 构造函数，验证用户是否登陆
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 加载头部js
     * @param array $jsPath         js路径数组
     */
    protected function loadTopJs($jsPath) {
        $this->_topJs = $jsPath;
    }

    /**
     * 加载底部js文件
     * @param array $jsPath         js路径数组
     */
    protected function loadBottomJs($jsPath) {
        $this->_btmJs = $jsPath;
    }

    /**
     * 加载头部css样式文件
     * @param array $cssPath        css路径数组
     */
    protected function loadTopCss($cssPath) {
        $this->_topCss = $cssPath;
    }

    /**
     * 加载底部css样式文件
     * @param array $cssPath        css路径数组
     */
    protected function loadBottomCss($cssPath) {
        $this->_btmCss = $cssPath;
    }

    /**
     * 加载第三方插件
     * @param array $pluginJsPath           第三方插件js路径
     * @param array $pluginCssPath          第三方插件css路径
     */
    public function loadPlugin($pluginJsPath = array(), $pluginCssPath = array()) {
        $this->_pluginJs = $pluginJsPath;
        $this->_pluginCss = $pluginCssPath;
    }

}
