<?php
global $wpdb;

$table = $wpdb->prefix.'sbm_subdomains';

$id = intval($_GET['id']);

if(isset($_POST['update_subdomain']))
{
    $wpdb->update($table,
    [
      'subdomain_name'=>$_POST['subdomain_name'],
      'ftp_host'=>$_POST['ftp_host'],
      'ftp_user'=>$_POST['ftp_user'],
      'ftp_pass'=>sbm_encrypt($_POST['ftp_pass']),
      'ftp_path'=>$_POST['ftp_path'],
      'backup_frequency'=>$_POST['backup_frequency']
    ],
    ['id'=>$id]
    );

    echo "<div class='updated'>Subdomain Updated</div>";
}

$current = $wpdb->get_row("SELECT * FROM $table WHERE id=$id", ARRAY_A);
?>

<h2>Edit Subdomain</h2>

<form method="post">

Subdomain Name: <input name="subdomain_name" value="<?php echo $current['subdomain_name']; ?>" required><br>
FTP Host: <input name="ftp_host" value="<?php echo $current['ftp_host']; ?>" required><br>
FTP User: <input name="ftp_user" value="<?php echo $current['ftp_user']; ?>" required><br>
FTP Pass: <input name="ftp_pass" value="<?php echo sbm_decrypt($current['ftp_pass']); ?>" required><br>
FTP Path: <input name="ftp_path" value="<?php echo $current['ftp_path']; ?>" required><br>

Frequency:
<select name="backup_frequency">
  <option value="daily" <?php if($current['backup_frequency']=='daily') echo 'selected'; ?>>Daily</option>
  <option value="weekly" <?php if($current['backup_frequency']=='weekly') echo 'selected'; ?>>Weekly</option>
  <option value="monthly" <?php if($current['backup_frequency']=='monthly') echo 'selected'; ?>>Monthly</option>
</select>

<button name="update_subdomain">Update</button>

</form>
