<?php
global $wpdb;

$table = $wpdb->prefix.'sbm_destinations';

if(isset($_POST['update_destination']))
{
    $wpdb->update($table,
    [
      'dest_host'=>$_POST['dest_host'],
      'dest_user'=>$_POST['dest_user'],
      'dest_pass'=>sbm_encrypt($_POST['dest_pass']),
      'dest_path'=>$_POST['dest_path'],
      'retention_days'=>intval($_POST['retention_days'])
    ],
    ['id'=>intval($_POST['id'])]
    );

    echo "<div class='updated notice'>Destination updated</div>";
}

$destinations = $wpdb->get_results("SELECT * FROM $table");
?>

<h2>Destination FTP Servers</h2>

<table class="widefat">
<tr>
 <th>Host</th>
 <th>User</th>
 <th>Path</th>
 <th>Retention</th>
 <th>Action</th>
</tr>

<?php foreach($destinations as $d): ?>
<tr>
 <td><?php echo $d->dest_host; ?></td>
 <td><?php echo $d->dest_user; ?></td>
 <td><?php echo $d->dest_path; ?></td>
 <td><?php echo $d->retention_days; ?></td>

 <td>
   <a href="admin.php?page=sbm-edit-destination&id=<?php echo $d->id; ?>">Edit</a>
 </td>

</tr>
<?php endforeach; ?>
</table>
