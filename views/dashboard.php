<?php
if (!defined('ABSPATH')) exit;

global $wpdb;

$subs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sbm_subdomains", ARRAY_A);
?>

<h2>Manual Backup Testing</h2>

<p>Click on 'Backup Now' to test backup for individual subdomains.</p>

<table class="widefat">
<tr>
 <th>Subdomain Name</th>
 <th>FTP Host</th>
 <th>Backup Frequency</th>
 <th>Actions</th>
</tr>

<?php foreach($subs as $s): ?>
<tr>
 <td><?php echo $s['subdomain_name']; ?></td>
 <td><?php echo $s['ftp_host']; ?></td>
 <td><?php echo $s['backup_frequency']; ?></td>
 <td>
   <a href="<?php echo admin_url('admin.php?page=sbm-run-manual-backup&id='.$s['id']); ?>">
      Backup Now
   </a> |
   <a href="<?php echo admin_url('admin.php?page=sbm-edit-subdomain&id='.$s['id']); ?>">
      Edit Subdomain
   </a>
 </td>
</tr>
<?php endforeach; ?>

</table>

