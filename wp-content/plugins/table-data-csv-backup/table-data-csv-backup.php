<?php

/**
 * Plugin Name: CSV Data Backup
 * Description: Export table data into .csv file
 * Author: Heber Solano
 * Version: 1.0
 */

// Plugin Menu in Admin
add_action("admin_menu", "tdcb_create_admin_menu");
function tdcb_create_admin_menu() {
  add_menu_page("CSV Data Backup", "CSV Data Backup", "manage_options", "csv-dta-backup", "tdcb_export_form", "dashicons-database-export", 8);
}

// Create a page - button export
function tdcb_export_form() {
  ob_start();
  include_once plugin_dir_path(__FILE__) . "/template/table-data-backup-form.php";
  $layout = ob_get_contents();
  ob_end_clean();
  echo $layout;
}

// Export all table data into .csv file
add_action("admin_init", "tdcb_handle_form_export");
function tdcb_handle_form_export() {
  if (isset($_POST["tdcb_export_button"])) {
    global $wpdb;
    $table_name = $wpdb->prefix . "students_data";

    $students = $wpdb->get_results(
      "SELECT * FROM {$table_name}",
      ARRAY_A
    );

    if (empty($students)) {
    }

    $filename = "students_data_" . time() . ".csv";

    header("Content-Type: text/csv; charset=utf-8;");
    header("Content-Disposition: attachment; filename={$filename};");

    $output = fopen("php://output", 'w');

    fputcsv($output, array_keys($students[0])); //headers
    foreach ($students as $student) {
      fputcsv($output, $student); // rows
    }

    exit;
  }
}
