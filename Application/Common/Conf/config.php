<?php

//加载本地配置项
$localConf = include 'config-local.php';
$conf = array(
    //'配置项'=>'配置值'
    'SESSION_PREFIX' => 'likevery',
    'ASSETVESION' => time(),
);

return array_merge($localConf, $conf);
