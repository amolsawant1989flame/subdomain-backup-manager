<?php

global $wpdb;

$sub_table = $wpdb->prefix.'sbm_subdomains';
$db_table  = $wpdb->prefix.'sbm_databases';

if(isset($_POST['save_subdomain']))
{
    $wpdb->insert($sub_table, [
        'subdomain_name'=>$_POST['subdomain_name'],
        'ftp_host'=>$_POST['ftp_host'],
        'ftp_user'=>$_POST['ftp_user'],
        'ftp_pass'=>sbm_encrypt($_POST['ftp_pass']),
        'ftp_path'=>$_POST['ftp_path'],
        'backup_frequency'=>$_POST['backup_frequency']
    ]);

    $sub_id = $wpdb->insert_id;

    $wpdb->insert($db_table, [
        'subdomain_id'=>$sub_id,
        'db_host'=>$_POST['db_host'],
        'db_user'=>$_POST['db_user'],
        'db_pass'=>sbm_encrypt($_POST['db_pass']),
        'db_name'=>$_POST['db_name']
    ]);

    echo "<div class='updated'>Subdomain and database saved successfully</div>";
}

?>

<h2>Add Remote Subdomain</h2>

<form method="post">

<h3>Source FTP Details</h3>

Subdomain Name: <input name="subdomain_name" required><br>
FTP Host: <input name="ftp_host" required><br>
FTP User: <input name="ftp_user" required><br>
FTP Pass: <input name="ftp_pass" required><br>
FTP Path: <input name="ftp_path" value="/" required><br>

Frequency:
<select name="backup_frequency">
  <option value="daily">Daily</option>
  <option value="weekly">Weekly</option>
  <option value="monthly">Monthly</option>
</select>

<hr>

<h3>Source Database Details</h3>

DB Host: <input name="db_host" required><br>
DB User: <input name="db_user" required><br>
DB Pass: <input name="db_pass" required><br>
DB Name: <input name="db_name" required><br>

<button name="save_subdomain">Save Subdomain</button>

</form>
