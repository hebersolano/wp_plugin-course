<?php

/**
 * Plugin Name: My Custom Widget
 * Description: This widget will provide options to display a static message as well as recent posts over website.
 * Author: Heber Solano
 * Version: 1.0
 */

if (!defined("ABSPATH")) {
  exit;
}

add_action("widgets_init", "mcw_register_widget");

include_once plugin_dir_path(__FILE__) . "/My_Custom_Widget.php";

function mcw_register_widget() {
  register_widget("My_Custom_Widget");
}

// add admin panel script
add_action("admin_enqueue_scripts", "mcw_add_admin_script");
function mcw_add_admin_script() {
  wp_enqueue_style("admin-style", plugin_dir_url(__FILE__) . "mcw_ap_style.css");
  wp_enqueue_script("admin-script", plugin_dir_url(__FILE__) . "mcw_ap_script.js", array('jquery'));
}
