<?php

/**
 * 公用函数库
 * @author albafica.wang 
 * @createdate 2015-01-23
 */

/**
 * 检验密码复杂度
 * @param string $pwd   明文密码
 * @return int 密码复杂度 0-不符合规范 1,2,3 表示不同强度   
 */
function chkPwd($pwd) {
    //密码长度6-15位，包含数字、大写字母，小写字母
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/', $pwd)) {
        return 0;
    }
    $pwdLength = strlen($pwd);
    if ($pwdLength <= 8) {
        return 1;
    }
    if ($pwdLength <= 12) {
        return 2;
    }
    return 3;
}
