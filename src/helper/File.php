<?php
// +----------------------------------------------------------------------
// | Alpicool [ WE MAKE YOU FEEL COOL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://alpicool.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Allyfireshen <allyfireshen@alpicool.com>
// +----------------------------------------------------------------------

namespace allyfireshen\helper;


class File
{
    /**
     * @param string $url 文件夹路径
     * @return bool
     */
    public static function createDir($url): bool
    {
        $url = str_replace('', '/', $url);
        $dir = '';
        $urlArr = explode('/', $url);
        $result = true;
        foreach ($urlArr as $value) {
            $dir .= $value . '/';
            if (!file_exists($dir)) {
                $result = mkdir($dir);
            }
        }

        return $result;
    }

    /**
     * 移动目录
     * @param string $oldDir 移动文件夹
     * @param string $aimDir 目标文件夹
     * @param bool $overwrite 是否覆盖
     * @return bool
     */
    public static function moveDir($oldDir, $aimDir, $overwrite = false): bool
    {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        $oldDir = str_replace('', '/', $oldDir);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
        if (!is_dir($oldDir)) {
            return false;
        }

        if (!file_exists($aimDir)) {
            self::createDir($aimDir);
        }

        @$handle = opendir($oldDir);
        if (!$handle) {
            return false;
        }

        while (false !== ($file = readdir($handle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            if (!is_dir($oldDir . $file)) {
                self::moveFile($oldDir . $file, $aimDir . $file, $overwrite);
            } else {
                self::moveDir($oldDir . $file, $aimDir . $file, $overwrite);
            }
        }

        closedir($handle);
        return rmdir($oldDir);
    }

    /**
     * 新建文件
     * @param string $url 文件路径
     * @param bool $overwrite 是否覆盖
     * @return bool
     */
    public static function createFile($url, $overwrite = false): bool
    {
        if (file_exists($url)) {
            if ($overwrite) {
                self::unlinkFile($url);
            } else {
                return false;
            }
        }

        $dir = dirname($url);
        self::createDir($dir);
        touch($url);
        return true;
    }

    /**
     * 移动文件
     * @param string $fileUrl 原文件路径
     * @param string $aimUrl 目标文件路径
     * @param bool $overwrite 是否覆盖
     * @return bool
     */
    public static function moveFile($fileUrl, $aimUrl, $overwrite = false): bool
    {
        if (!file_exists($fileUrl)) {
            return false;
        }

        if (file_exists($aimUrl)) {
            if ($overwrite) {
                self::unlinkFile($aimUrl);
            } else {
                return false;
            }
        }

        $aimDir = dirname($aimUrl);
        self::createDir($aimDir);
        rename($fileUrl, $aimUrl);
        return true;
    }

    /**
     * 删除文件夹
     * @param string $dir
     * @return bool
     */
    public static function unlinkDir($dir): bool
    {
        $dir = str_replace('', '/', $dir);
        $dir = substr($dir, -1) == '/' ? $dir : $dir . '/';
        if (!is_dir($dir)) {
            return false;
        }

        $handle = opendir($dir);
        while (false !== ($file = readdir($handle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            if (!is_dir($dir . $file)) {
                self::unlinkFile($dir . $file);
            } else {
                self::unlinkDir($dir . $file);
            }
        }

        closedir($handle);
        return rmdir($dir);
    }

    /**
     * 删除文件
     * @param string $url 文件路径
     * @return bool
     */
    public static function unlinkFile($url): bool
    {
        if (file_exists($url)) {
            unlink($url);
            return true;
        }

        return false;
    }

    /**
     * 复制文件夹
     * @param string $oldDir 源文件夹
     * @param string $aimDir 目标文件夹
     * @param bool $overwrite 是否覆盖
     * @return bool
     */
    public static function copyDir($oldDir, $aimDir, $overwrite = false): bool
    {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        $oldDir = str_replace('', '/', $oldDir);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
        if (!is_dir($oldDir)) {
            return false;
        }

        if (!file_exists($aimDir)) {
            self::createDir($aimDir);
        }

        $handle = opendir($oldDir);
        while (false !== ($file = readdir($handle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            if (!is_dir($oldDir . $file)) {
                self::copyFile($oldDir . $file, $aimDir . $file, $overwrite);
            } else {
                self::copyDir($oldDir . $file, $aimDir . $file, $overwrite);
            }
        }

        closedir($handle);
        return true;
    }

    /**
     * 复制文件
     * @param string $fileUrl 源文件路径
     * @param string $aimUrl 目标文件路径
     * @param bool $overwrite 是否覆盖
     * @return bool
     */
    public static function copyFile($fileUrl, $aimUrl, $overwrite = false): bool
    {
        if (!file_exists($fileUrl)) {
            return false;
        }

        if (file_exists($aimUrl)) {
            if ($overwrite) {
                self::unlinkFile($aimUrl);
            } else {
                return false;
            }
        }

        $aimDir = dirname($aimUrl);
        self::createDir($aimDir);
        copy($fileUrl, $aimUrl);
        return true;
    }

    /**
     * 判断文件夹是否为空
     * @param string $dir 文件夹
     * @return bool
     */
    public static function isEmptyDir($dir): bool
    {
        if (!is_dir($dir)) {
            return true;
        }

        $res = array_diff(scandir($dir), ['..', '.']);
        return empty($res);
    }
}