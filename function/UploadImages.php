<?php

if (!function_exists('createFolder')) {
    function createFolder($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }
}

if (!function_exists('createImage')) {
    function createImage($file, $path, $newPath)
    {
        if ($file["name"] != "") {
            createFolder($path);
            move_uploaded_file($file["tmp_name"], $newPath);
        }
    }
}

if (!function_exists('createImageFb')) {
    function createImageFb($url, $path, $newPath)
    {
        createFolder($path);
        file_put_contents($newPath, file_get_contents($url));
    }
}

if (!function_exists('updateImage')) {
    function updateImage($file, $path, $pathOldAvatar, $pathNewAvatar)
    {
        createFolder($path);
        if (file_exists($pathOldAvatar)) {
            unlink($pathOldAvatar);
        }
        move_uploaded_file($file["tmp_name"], $pathNewAvatar);
    }
}
if (!function_exists('deleteImage')) {
    function deleteImage($path)
    {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? deleteImage($file) : unlink($file);
        }
        rmdir($path);
    }
}