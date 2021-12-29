<?php

if (!function_exists('siteURL')) {
    function siteURL()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
            $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        return $protocol . $domainName;
    }
}

if (!function_exists('getImgUrl')) {
    function getImgUrl($assetUrl)
    {
        $url = siteURL();
        return $url . '/' . $assetUrl;
    }
}
//if (!function_exists('getProtocol')) {
//    function getProtocol() {
//        var_dump($_SERVER['HTTPS']);
//        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
//            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
//            $protocol = 'https://';
//        }
//        else {
//            $protocol = 'http://';
//        }
//        var_dump($protocol);die;
//    }
//    https +$_SERVER['SERVER_NAME']
//}