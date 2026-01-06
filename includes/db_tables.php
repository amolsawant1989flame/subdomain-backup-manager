<?php
if (!defined('ABSPATH')) exit;

function sbm_install_tables()
{
    global $wpdb;

    $charset = $wpdb->get_charset_collate();

    $sql1 = "CREATE TABLE {$wpdb->prefix}sbm_subdomains (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subdomain_name VARCHAR(255),
        ftp_host VARCHAR(255),
        ftp_user VARCHAR(255),
        ftp_pass TEXT,
        ftp_path VARCHAR(255),
        backup_frequency ENUM('daily','weekly','monthly')
    ) $charset;";

    $sql2 = "CREATE TABLE {$wpdb->prefix}sbm_databases (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subdomain_id INT,
        db_host VARCHAR(255),
        db_user VARCHAR(255),
        db_pass TEXT,
        db_name VARCHAR(255)
    ) $charset;";

    $sql3 = "CREATE TABLE {$wpdb->prefix}sbm_destinations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dest_host VARCHAR(255),
        dest_user VARCHAR(255),
        dest_pass TEXT,
        dest_path VARCHAR(255),
        retention_days INT DEFAULT 7
    ) $charset;";

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    dbDelta($sql1);
    dbDelta($sql2);
    dbDelta($sql3);
}

register_activation_hook(__DIR__.'/../subdomain-backup-manager.php', 'sbm_install_tables');

?>
