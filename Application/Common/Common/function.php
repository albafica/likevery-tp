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

/**
 * 判断输入字符串的格式
 * @param string $text: 传入字符串
 * @param string $type：传判断类型:
 *     数字型：I0:数字类型   I1:正整数  I2:邮编  I3:电话号码 I4:手机号码 I5:电话+手机号码 I6:身份证号码
 *   字符串型：S0:Email   S1:URL  S2:IP  S3:数字+26个字母组成的  S4:是否utf8  S5:全中文  S6:包含中文
 * 日期时间型：D0:日期+时间  D1：日期   D2：时间    D3:年月
 * @return false：否 true:是  $type . "类型未实现！"
 * */
function isFormat($text, $type) {
    $regexResult = false;
    $regexStr = '';
    switch ($type) {
        case "I0":      // 数字类型
            $regexStr = '/^[-]?\d+[.]?\d*$/';
            break;
        case "I1":      // 正整数
            $regexStr = '/^[0-9]*[1-9][0-9]*$/';
            break;
        case "I2":      // 邮编
            $regexStr = '/\d{6,6}/';
            break;
        case "I3":      // 座机电话
            $regexStr = '(([+]{0,1}\d{2,4}|\d{2,4})-?)?'; //国号 +086 
            $regexStr .= '((\d{3,4})-?)?';                //区号
            $regexStr .= '(\d{6,8})';                     //电话号
            $regexStr .= '(-?(\d{1,6}))?';                //分机号
            $regexStr = '/(^' . $regexStr . '$)/';
            break;
        case "I4":      // 手机
            $regexStr = '(([+]{0,1}\d{2,4}|\d{2,4})-?)?'; //国号 +086 
            $regexStr .= '1[34578]\d{9}';                 //手机号 1[34578]\d{9}
            $regexStr = '/(^' . $regexStr . '$)/';
            break;
        case "I5":      // 手机或座机电话
            $regexStr = '(([+]{0,1}\d{2,4}|\d{2,4})-?)?'; //国号 +086 
            //电话
            $regexStr1 = '((\d{3,4})-?)?';                //区号
            $regexStr1 .= '(\d{6,8})';                    //电话号
            $regexStr1 .= '(-?(\d{1,6}))?';               //分机号
            //手机
            $regexStr2 = '1[34578]\d{9}';                 //手机号 1[34578]\d{9}
            //合并
            $regexStr .= '(' . $regexStr1 . ')|(' . $regexStr2 . ')';
            $regexStr = '/(^(' . $regexStr . ')$)/';
            break;
        case "I6":      // 身份证
            $regexStr = '/^\d{15}$|^\d{17}[\dXx]$/';
            break;
        case "I7":      // 生日
            $regexStr = '/^\d{4}-\d{2}-\d{2}$/';
            break;
        case "S0":      // Email
            $regexStr = "/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";
            break;
        case "S1":      // URL http://www.baidu.com
            $regexStr = "/^[a-zA-z]+://(\w+(-\w+)*)(\.(\w+(-\w+)*))*(\?\S*)?$/";
            break;
        case "S2":      // IP
            $regexStr = "/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/";
            break;
        case "S3":      // 由数字和26个英文字母组成的字符串 
            $regexStr = "/^[0-9a-zA-Z]+$/";
            break;
        case "S4":      // 判断是否是utf8 
            $regexStr = '/^('
                    . '[\x09\x0A\x0D\x20-\x7E]|'            # ASCII
                    . '[\xC2-\xDF][\x80-\xBF]|'             # non-overlong 2-byte
                    . '\xE0[\xA0-\xBF][\x80-\xBF]|'         # excluding overlongs
                    . '[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|'  # straight 3-byte
                    . '\xED[\x80-\x9F][\x80-\xBF]|'         # excluding surrogates
                    . '\xF0[\x90-\xBF][\x80-\xBF]{2}|'      # planes 1-3
                    . '[\xF1-\xF3][\x80-\xBF]{3}|'          # planes 4-15
                    . '\xF4[\x80-\x8F][\x80-\xBF]{2}'       # plane 16
                    . ')*\z/x';
            break;
        case "S5":      // 全中文
            $regexStr = "/^[\x7f-\xff]+$/";
            break;
        case "S6":      // 包含中文
            $regexStr = "/[\x7f-\xff]/";
            break;
        case "D0":      // 日期+时间
            $regexStr = "(((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|";
            $regexStr .= "(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|";
            $regexStr .= "(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|";
            $regexStr .= "(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|";
            $regexStr .= "((16|[2468][048]|[3579][26])00))-0?2-29)";
            $regexStr = "(" . $regexStr . ") (20|21|22|23|[0-1]?\d):[0-5]?\d:[0-5]?\d";  //加时间
            $regexStr = "/^(" . $regexStr . ")$/";
            break;
        case "D1":      // 日期  1999-9-12   2000-9-12
            $regexStr = "(((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|";
            $regexStr .= "(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|";
            $regexStr .= "(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|";
            $regexStr .= "(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|";
            $regexStr .= "((16|[2468][048]|[3579][26])00))-0?2-29)";
            $regexStr = "/^(" . $regexStr . ")$/";
            break;
        case "D2":      // 时间
            $regexStr = "/^((20|21|22|23|[0-1]?\d):[0-5]?\d:[0-5]?\d)$/";
            break;
        case "D3":      //年月    1990-11
            $regexStr = "/^(1[6-9]|[2-9]\d)\d{2}-(0?[1-9]|1[0-2])$/";
    }

    if ($regexStr != '') {
        $regexResult = @preg_match($regexStr, $text);
    }
    return $regexResult;
}

/**
 * 翻译求职者工作意向
 * @param int $jobType
 */
function transJobType($jobType) {
    switch ($jobType) {
        case 1:
            return '技术';
        case 2:
            return '设计师';
        case 3:
            return '产品经理';
        case 4:
            return '产品运营';
        default:
            return '其他';
    }
}

/**
 * utf8字符串无乱码截取
 * @param string $str       待截取的字符串
 * @param int $len       截取中文字符个数
 * @param string $suffix    字符串被截取后后缀
 * @return string           截取后的字符串
 */
function cutStr($str, $len, $suffix = '...') {
    if ($len <= 0) {
        return '';
    }
    $length = strlen($str);
    if ($length <= $len) {
        return $str;
    }
    $offset = 0;
    $chars = 0;
    $res = '';
    while ($chars < $len && $offset < $length) {
        $heigh = decbin(ord(substr($str, $offset, 1)));
        if (strlen($heigh) < 8) {
            $count = 1;
        } else if (substr($heigh, 0, 3) == '110') {
            $count = 2;
        } else if (substr($heigh, 0, 4) == '1110') {
            $count = 3;
        } else if (substr($heigh, 0, 5) == '11110') {
            $count = 4;
        } else if (substr($heigh, 0, 6) == '111110') {
            $count = 5;
        } else if (substr($heigh, 0, 7) == '1111110') {
            $count = 6;
        }
        $res .= substr($str, $offset, $count);
        $chars += 1;
        $offset += $count;
    }
    return $res . $suffix;
}

/**
 * 翻译教育水平
 * @param type $eduLevel
 */
function getEduByLevel($eduLevel) {
    switch ($eduLevel) {
        case 1:
            return '小学';
        case 2:
            return '初中';
        case 3:
            return '高中';
        case 4:
            return '专科';
        case 5:
            return '本科';
        case 6:
            return '研究生';
        case 7:
            return '博士';
        case 8:
        default :
            return '其他';
    }
}

/**
 * 翻译工作年限
 * @param type $code
 */
function getWordYearByCode($code) {
    switch ($code) {
        case 1:
            return '一年以内';
        case 2:
            return '一到两年';
        case 3:
            return '两到三年';
        case 4:
            return '三到五年';
        case 5:
            return '五到七年';
        case 6:
            return '七到十年';
        case 7:
            return '十到十五年';
        case 8:
            return '十五年以上';
        default :
            return '其他';
    }
}
