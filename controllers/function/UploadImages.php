<?php

class UploadImages
{
    public function createFolder($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }

    public function createImage($file, $path, $newPath)
    {
        if ($file["name"] != "") {
            $this->createFolder($path);
            move_uploaded_file($file["tmp_name"], $newPath);
        }
    }

    public function createImageFb($url, $path, $newPath)
    {
        $this->createFolder($path);
        file_put_contents($newPath, file_get_contents($url));
    }

    public function updateImage($file, $path, $pathOldAvatar, $pathNewAvatar)
    {
        $this->createFolder($path);
        if (file_exists($pathOldAvatar)) {
            unlink($pathOldAvatar);
        }
        move_uploaded_file($file["tmp_name"], $pathNewAvatar);
    }

    public function deleteImage($path)
    {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? deleteImage($file) : unlink($file);
        }
        rmdir($path);
    }
}