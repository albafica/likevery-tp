<?php

//加载本地配置项
$localConf = include 'config-local.php';
$conf = array(
        //'配置项'=>'配置值'
);

return array_merge($localConf, $conf);
