<?php

//加载本地配置项
$localConf = include 'config-local.php';
$conf = array(
    //'配置项'=>'配置值'
    'SESSION_PREFIX' => 'likevery',
    'ASSETVESION' => time(),
    'FROM_EMALI_ADDR' => 'admin@likevery.com',
    'FROM_EMAIL_NAME' => '系统管理员',
);

return array_merge($localConf, $conf);
