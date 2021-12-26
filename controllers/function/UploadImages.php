<?php

class UploadImages
{
    public static function  createFolder($path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }
    public static function createImage($file, $path, $newPath)
    {
        if ($file["name"] != "") {
            self::createFolder($path);
            move_uploaded_file($file["tmp_name"], $newPath);
        }
    }

    public static function updateImage($file, $path, $pathOldAvatar, $pathNewAvatar)
    {
        self::createFolder($path);
        if (file_exists($pathOldAvatar)) {
            unlink($pathOldAvatar);
        }
        move_uploaded_file($file["tmp_name"], $pathNewAvatar);
    }
    public static function deleteImage($path) {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? deleteImage($file) : unlink($file);
        }
        rmdir($path);
    }
}