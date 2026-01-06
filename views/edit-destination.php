<?php
if (!defined('ABSPATH')) exit;

global $wpdb;

$table = $wpdb->prefix.'sbm_destinations';

if(isset($_POST['update']))
{
    $wpdb->update($table,
    [
      'dest_host'=>$_POST['dest_host'],
      'dest_user'=>$_POST['dest_user'],
      'dest_pass'=>sbm_encrypt($_POST['dest_pass']),
      'dest_path'=>$_POST['dest_path']
    ],
    ['id'=>intval($_POST['id'])]
    );

    echo "<div class='updated notice'>Destination FTP Updated</div>";
}

$id = intval($_GET['id']);

$current = $wpdb->get_row("SELECT * FROM $table WHERE id=$id", ARRAY_A);
?>

<h2>Edit Destination FTP</h2>

<form method="post">

<input type="hidden" name="id" value="<?php echo $current['id']; ?>">

Host: <input name="dest_host" value="<?php echo $current['dest_host']; ?>"><br>
User: <input name="dest_user" value="<?php echo $current['dest_user']; ?>"><br>
Pass: <input name="dest_pass" value="<?php echo sbm_decrypt($current['dest_pass']); ?>"><br>
Path: <input name="dest_path" value="<?php echo $current['dest_path']; ?>"><br>

<button name="update">Update</button>

</form>
