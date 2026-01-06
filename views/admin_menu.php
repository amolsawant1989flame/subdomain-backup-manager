<?php
if (!defined('ABSPATH')) exit;

/*
 Proper Admin Menu Registration including Edit screens
*/

function sbm_register_admin_menus()
{
    add_menu_page(
        'Subdomain Backup Manager',
        'Subdomain Backups',
        'manage_options',
        'sbm-dashboard',
        'sbm_dashboard_view',
        'dashicons-database'
    );

    add_submenu_page(
        'sbm-dashboard',
        'Manage Subdomains',
        'Manage Subdomains',
        'manage_options',
        'sbm-manage-subdomains',
        'sbm_manage_subdomains_view'
    );

    add_submenu_page(
        'sbm-dashboard',
        'Manage Destinations',
        'Manage Destinations',
        'manage_options',
        'sbm-manage-destinations',
        'sbm_manage_destinations_view'
    );

    add_submenu_page(
        'sbm-dashboard',
        'Add Subdomain',
        'Add Subdomain',
        'manage_options',
        'sbm-add-subdomain',
        'sbm_add_subdomain_view'
    );

    add_submenu_page(
        'sbm-dashboard',
        'Edit Destination FTP',
        'Edit Destination FTP',
        'manage_options',
        'sbm-edit-destination',
        'sbm_edit_destination_view'
    );

    add_submenu_page(
        'sbm-dashboard',
        'Edit Subdomain',
        'Edit Subdomain',
        'manage_options',
        'sbm-edit-subdomain',
        'sbm_edit_subdomain_view'
    );

    add_submenu_page(
        'sbm-dashboard',
        'Logs',
        'manage_options',
        'sbm-logs',
        'sbm_logs_view'
    );
}

add_action('admin_menu', 'sbm_register_admin_menus');


function sbm_dashboard_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/dashboard.php');
}

function sbm_manage_subdomains_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/manage-subdomains.php');
}

function sbm_manage_destinations_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/manage-destinations.php');
}

function sbm_add_subdomain_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/add-subdomain.php');
}


/*
  Edit Destination FTP screen loader
*/

function sbm_edit_destination_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/edit-destination.php');
}


/*
  Edit Subdomain screen loader
*/

function sbm_edit_subdomain_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/edit-subdomain.php');
}


/*
  Edit Subdomain Database credentials screen
*/

function sbm_edit_database_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/edit-database.php');
}


function sbm_logs_view()
{
    include_once(plugin_dir_path(__FILE__) . '../views/logs.php');
}

?>
