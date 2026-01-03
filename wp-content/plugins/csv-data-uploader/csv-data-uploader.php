<?php

/**
 * Plugin Name: CSV Data Uploader
 * Description: This plugin will uploads CSV data to DB Table
 * Author: Heber Solano
 * Version: 1.0
 */

// How to create a dynamic table on plugin activation
register_activation_hook(__FILE__, "cdu_create_table");

function cdu_create_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . "students_data";

  $charset_collate = $wpdb->get_charset_collate();

  $sql_command = "CREATE TABLE $table_name (
  id int(9) NOT NULL AUTO_INCREMENT,
  name varchar(50) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  age int(5) DEFAULT NULL,
  phone varchar(30) DEFAULT NULL,
  photo varchar(120) DEFAULT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql_command);
}

//# How to create a form using shortcode

define("CDU_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));  // define path constant 

add_shortcode("csv-data-uploader", "cdu_display_uploader_form");

function cdu_display_uploader_form() {
  // start php buffer
  ob_start();
  // put all content into buffer
  include_once CDU_PLUGIN_DIR_PATH . "/template/cdu_form.php";
  // read buffer
  $template = ob_get_contents();
  // clean buffer
  ob_end_clean();

  return $template;
}

//# How to add / use ajax request in plugin

// add script file
add_action("wp_enqueue_scripts", "cdu_add_script_file");
function cdu_add_script_file() {
  wp_enqueue_script("cdu-script-js", plugin_dir_url(__FILE__) . "assets/script.js", array("jquery"));
}
// /home/solano/development/wordpress/wp_plugin-course/wp-content/plugins/csv-data-uploader/assets/script.js

//# Upload scv, read all data using code and save into DB