<?php
if (!defined('ABSPATH')) exit;

global $wpdb;

$table = $wpdb->prefix.'sbm_destinations';

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    $wpdb->delete($table, ['id'=>$id]);

    echo "<div class='updated notice'>Destination FTP deleted</div>";
}

$dest = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
?>

<h2>Manage Destination FTP</h2>

<table class="widefat">
<tr>
 <th>Host</th>
 <th>User</th>
 <th>Path</th>
 <th>Actions</th>
</tr>

<?php foreach($dest as $d): ?>
<tr>
 <td><?php echo $d['dest_host']; ?></td>
 <td><?php echo $d['dest_user']; ?></td>
 <td><?php echo $d['dest_path']; ?></td>
 <td>
   <a href="<?php echo admin_url('admin.php?page=sbm-edit-destination&id='.$d['id']); ?>">Edit</a>
 </td>
</tr>
<?php endforeach; ?>
</table>

