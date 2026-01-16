<?php

/**
 * Plugin Name: My Meta-boxes
 * Description: This will be the metabox for WP Pages.
 * Author: Heber Solano
 * Version: 1.0
 */

if (!defined("ABSPATH")) {
  exit;
}

// register pages metabox
add_action("add_meta_boxes", "mm_register_page_metabox");

function mm_register_page_metabox() {
  add_meta_box("mm_metabox_id", "My Custom Metabox - SEO", "mm_create_page_metabox");
}

// create layout for page metabox
function mm_create_page_metabox($post) {
  // include template file
  include_once plugin_dir_path(__FILE__) . "page_metabox.php";
  $template = ob_get_contents();
  ob_end_clean();
  echo $template;
}


// save data of custom meta-box
add_action("save_post", "mm_save_page_metabox_data");

function mm_save_page_metabox_data($post_id) {
  if (isset($_POST["mm_meta_title"]))
    update_post_meta($post_id, "_meta_title", $_POST["mm_meta_title"]);

  if (isset($_POST["mm_meta_description"]))
    update_post_meta($post_id, "_meta_description", $_POST["mm_meta_description"]);
}
