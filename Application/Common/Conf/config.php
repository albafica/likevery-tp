<?php

//加载本地配置项
$localConf = include 'config-local.php';
$conf = array(
    //'配置项'=>'配置值'
    'SESSION_PREFIX' => 'superjy',
    'ASSETVESION' => time(),
    'FROM_EMALI_ADDR' => 'admin@superjy.cn',
    'FROM_EMAIL_NAME' => '系统管理员',
    'URL_MODEL' => 1, //PATHINFO模式
    'URL_CASE_INSENSITIVE' => true,
    'TMPL_ACTION_SUCCESS' => APP_PATH . 'CommonTpl/dispatch_jump.tpl',
    'TMPL_ACTION_ERROR' => APP_PATH . 'CommonTpl/dispatch_jump.tpl',
);

return array_merge($localConf, $conf);
