<?php

//加载本地配置项
$localConf = include 'config-local.php';
$conf = array(
    //'配置项'=>'配置值'
    'SESSION_PREFIX' => 'likevery',
    'ASSETVESION' => '20150814',
);

return array_merge($localConf, $conf);
