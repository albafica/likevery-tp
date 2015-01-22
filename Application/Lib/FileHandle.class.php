<?php

namespace Lib;

/**
 * Description of FileDownload
 *  PHP文件操纵类
 * @author albafica.wang
 * @createdate 2014/12/29
 */
class FileHandle {

    /**
     * 尝试建立目录
     * @param $url	文件路径
     * @param $mode	目录权限
     * @param $maxloop	最大尝试次数
     * @return true or false
     */
    public function tryMakedir($url, $mode = 0777, $maxloop = 5) {
        $urlarr = explode('/', $url);
        $urlstr = '';
        foreach ($urlarr as $key => $value) {
            $urlstr .= $value . '/';
            if (!is_dir($urlstr)) {
                $loop = 0;
                $makeok = false;
                while ($loop < $maxloop) {
                    if (@mkdir($urlstr, $mode)) {
                        chown($urlstr, 'nobody');
                        chgrp($urlstr, 'nobody');
                        chmod($urlstr, $mode);
                        $makeok = true;
                        break;
                    } else {
                        $loop++;
                    }
                }
                if (!$makeok) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 尝试打开某个文件
     * @param $url	文件路径
     * @param $mode	目录权限
     * @param $maxloop	最大尝试次数
     * @return true or false
     */
    public function tryOpen($url, $mode, $maxloop = 5) {
        for ($i = 0; $i < $maxloop; $i++) {
            $fhandle = @fopen($url, $mode);
            if (is_resource($fhandle)) {
                return $fhandle;
            }
        }
        return false;
    }

    /**
     * 尝试写入文件
     * @param $fhandle	文件句柄
     * @param $content	文件内容
     * @param $maxloop	最大尝试次数
     * @return true or false
     */
    public function tryWrite($fhandle, $content, $maxloop = 5) {
        for ($i = 0; $i < $maxloop; $i++) {
            if (@fwrite($fhandle, $content)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 尝试关闭文件句柄
     * @param $fhandle	文件句柄
     * @param $maxloop	最大尝试次数
     * @return true or false
     */
    public function tryClosefile($fhandle, $maxloop = 5) {
        for ($i = 0; $i < $maxloop; $i++) {
            if (@fclose($fhandle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 尝试重命名一个文件
     * @param $oldName	源文件名
     * @param $newName	新文件名
     * @param $maxloop	最大尝试次数
     * @return true or false
     */
    public function tryRename($oldName, $newName, $maxloop = 5) {
        for ($i = 0; $i < $maxloop; $i++) {
            if (@rename($oldName, $newName)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 尝试删除一个文件
     * @param string $filePath      文件路径
     * @param int $maxloop          最大尝试次数
     */
    public function tryDelFile($filePath, $maxloop = 5) {
        for ($i = 0; $i < $maxloop; $i++) {
            if (is_file($filePath) && @unlink($filePath)) {
                return true;
            }
        }
        return false;
    }

}
