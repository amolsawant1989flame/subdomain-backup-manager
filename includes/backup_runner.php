<?php
if (!defined('ABSPATH')) exit;

include_once(plugin_dir_path(__FILE__) . 'constants.php');
include_once(plugin_dir_path(__FILE__) . 'security.php');
include_once(plugin_dir_path(__FILE__) . 'destination_ftp.php');


function sbm_manual_backup($subdomain_id)
{
    global $wpdb;

    $sub = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}sbm_subdomains WHERE id=%d", $subdomain_id),
        ARRAY_A
    );

    if (!$sub) {
        error_log("SBM: Subdomain not found for ID: $subdomain_id");
        return false;
    }

    $db = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}sbm_databases WHERE subdomain_id=%d LIMIT 1", $subdomain_id),
        ARRAY_A
    );

    if (!$db) {
        error_log("SBM: Database not configured for Subdomain ID: $subdomain_id");
        return false;
    }

    $date = date('Y-m-d');

    $base = SBM_BACKUP_ROOT . $date . '/' . $sub['subdomain_name'];

    if (!file_exists($base))
        mkdir($base, 0755, true);

    $folders = [
        'extracted_content',
        'backup_zip',
        'database'
    ];

    foreach($folders as $f)
    {
        if (!file_exists("$base/$f"))
            mkdir("$base/$f",0755,true);
    }

    $ftp = @ftp_connect($sub['ftp_host']);

    if ($ftp === false) {
        error_log("SBM FTP CONNECT FAILED to host: ".$sub['ftp_host']);
        return false;
    }

    $login = @ftp_login(
        $ftp,
        $sub['ftp_user'],
        sbm_decrypt($sub['ftp_pass'])
    );

    if (!$login) {
        error_log("SBM: FTP LOGIN FAILED for host: ".$sub['ftp_host']);
        ftp_close($ftp);
        return false;
    }

    sbm_recursive_download(
        $ftp,
        $sub['ftp_path'],
        "$base/extracted_content"
    );

    $zip = "$base/backup_zip/".$sub['subdomain_name']."-$date.zip";

    sbm_zip_directory("$base/extracted_content", $zip);

    $db_dump = sbm_backup_database_php($db, $base);

    ftp_close($ftp);

    sbm_upload_full_backup($base, $sub['subdomain_name'], [
        'extracted_content'=>$zip,
        'backup_zip'=>$zip,
        'database'=>$db_dump
    ]);

    return true;
}


function sbm_recursive_download($ftp, $remote, $local)
{
    if (!file_exists($local))
        mkdir($local,0755,true);

    $list = ftp_nlist($ftp,$remote);

    if (!$list) return;

    foreach($list as $file)
    {
        $remote_file = $remote.'/'.$file;
        $local_file  = $local.'/'.basename($file);

        if (@ftp_chdir($ftp, $remote_file))
        {
            sbm_recursive_download($ftp, $remote_file, $local_file);
            ftp_chdir($ftp,"..");
        }
        else
        {
            ftp_get($ftp, $local_file, $remote_file, FTP_BINARY);
        }
    }
}


function sbm_zip_directory($source, $destination)
{
    $zip = new ZipArchive();
    $zip->open($destination, ZipArchive::CREATE);

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source)
    );

    foreach ($files as $name => $file)
    {
        if (!$file->isDir())
        {
            $filePath = $file->getRealPath();
            $relative = substr($filePath, strlen($source) + 1);
            $zip->addFile($filePath, $relative);
        }
    }

    $zip->close();

    return $destination;
}

?>
