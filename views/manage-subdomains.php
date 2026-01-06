<?php
if (!defined('ABSPATH')) exit;

global $wpdb;

$table = $wpdb->prefix.'sbm_subdomains';

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    $wpdb->delete($table, ['id'=>$id]);

    echo "<div class='updated notice'>Subdomain deleted</div>";
}

$subs = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
?>

<h2>Manage Subdomains</h2>

<table class="widefat">
<tr>
 <th>Name</th>
 <th>FTP Host</th>
 <th>Actions</th>
</tr>

<?php foreach($subs as $s): ?>
<tr>
 <td><?php echo $s['subdomain_name']; ?></td>
 <td><?php echo $s['ftp_host']; ?></td>
 <td>
   <a href="admin.php?page=sbm-edit-subdomain&id=<?php echo $s['id']; ?>">Edit</a> |
   <a href="admin.php?page=sbm-manage-subdomains&delete=<?php echo $s['id']; ?>">Delete</a>
 </td>
</tr>
<?php endforeach; ?>
</table>
