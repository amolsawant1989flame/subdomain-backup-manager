<?php

if (!defined('ABSPATH')) exit;

function sbm_upload_to_destination($file, $destination)
{
    $ftp = ftp_connect($destination['dest_host']);
    ftp_login($ftp, $destination['dest_user'], $destination['dest_pass']);

    ftp_pasv($ftp, true);

    $date = date('Y-m-d');
    $sub  = $destination['subdomain_name'];

    $remote_base = $destination['dest_path']."/$date/$sub";

    @ftp_mkdir($ftp, "$remote_base");
    @ftp_mkdir($ftp, "$remote_base/extracted_content");
    @ftp_mkdir($ftp, "$remote_base/backup_zip");
    @ftp_mkdir($ftp, "$remote_base/database");

    ftp_put(
        $ftp,
        "$remote_base/backup_zip/".basename($file),
        $file,
        FTP_BINARY
    );

    ftp_close($ftp);

    return true;
}

?>
