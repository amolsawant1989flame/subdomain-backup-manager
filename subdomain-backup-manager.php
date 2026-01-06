<?php
/*
Plugin Name: Subdomain Backup Manager
Description: Centralized backups from multiple hosts using FTP and database credentials
Version: 1.0
Author: Amol
*/

if (!defined('ABSPATH')) exit;

define('SBM_PATH', plugin_dir_path(__FILE__));

include_once(SBM_PATH.'includes/constants.php');
include_once(SBM_PATH.'includes/security.php');
include_once(SBM_PATH.'includes/db_tables.php');
include_once(SBM_PATH.'includes/admin_menu.php');
include_once(SBM_PATH.'includes/backup_runner.php');

?>
