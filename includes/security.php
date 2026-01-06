<?php

if (!defined('ABSPATH')) exit;

function sbm_encrypt($text)
{
    return openssl_encrypt($text, 'AES-128-CTR', AUTH_SALT);
}

function sbm_decrypt($text)
{
    return openssl_decrypt($text, 'AES-128-CTR', AUTH_SALT);
}

?>
