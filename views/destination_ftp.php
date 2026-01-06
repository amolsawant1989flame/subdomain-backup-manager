<?php
if (!defined('ABSPATH')) exit;

function sbm_upload_full_backup($local_base_folder, $subdomain_name, $files)
{
    global $wpdb;

    $destination = $wpdb->get_row(
        "SELECT * FROM {$wpdb->prefix}sbm_destinations LIMIT 1",
        ARRAY_A
    );

    $ftp = ftp_connect($destination['dest_host']);
    ftp_login($ftp, $destination['dest_user'], sbm_decrypt($destination['dest_pass']));
    ftp_pasv($ftp, true);

    $date = date('Y-m-d');

    $remote_root = $destination['dest_path'];

    @ftp_mkdir($ftp, "$remote_root");
    @ftp_mkdir($ftp, "$remote_root/$date");
    @ftp_mkdir($ftp, "$remote_root/$date/$subdomain_name");
    @ftp_mkdir($ftp, "$remote_root/$date/$subdomain_name/extracted_content");
    @ftp_mkdir($ftp, "$remote_root/$date/$subdomain_name/backup_zip");
    @ftp_mkdir($ftp, "$remote_root/$date/$subdomain_name/database");

    foreach($files as $type => $file)
    {
        $target = "$remote_root/$date/$subdomain_name/$type/".basename($file);

        ftp_put($ftp, $target, $file, FTP_BINARY);
    }

    ftp_close($ftp);

    return true;
}
?>
