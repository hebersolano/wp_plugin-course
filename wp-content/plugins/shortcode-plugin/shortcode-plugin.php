<?php

/**
 * Plugin Name: ShortCode Plugin
 * Description: This is second plugin of this course which gives idea about shortcode basic
 * Version: 1.0
 * Author: Solano
 * Author URL: https://github.com/hebersolano
 * Plugin URL: https://example.com/hello-world
 */
// basic shortcode
add_shortcode('message', 'sp_show_static_msg');
function sp_show_static_msg() {
  return '<p style="color:red;font-size:36; font-weight:bold">Hello, I am a shortcode message</p>';
  // return "Hello, I am a shortcode message";
}


// Parameterize shortcode []
add_shortcode('student', 'sp_handle_student_data');
function sp_handle_student_data($atts) {
  $atts = shortcode_atts(array(
    'name' => 'Default student',
    'email' => 'Default email',
  ), $atts, 'student');

  return "<h3>Student data: Name - {$atts['name']}, Email: - {$atts['email']}</h3>";
}

// shortcode with DB operation
// add_shortcode('list-posts', 'sp_handle_list_posts');
add_shortcode('list-posts', 'sp_handle_list_posts_wp_query_class');

function sp_handle_list_posts() {
  global $wpdb;

  $table_prefix = $wpdb->prefix; // wp_
  $table_name = $table_prefix . 'posts'; // wp_posts

  // get post whose post_type = post and status = publish 
  $posts = $wpdb->get_results(
    "SELECT post_title FROM {$table_name} WHERE post_type = 'post' AND post_status = 'publish'"
  );


  if (count($posts) > 0) {
    $output = "<ul>";
    foreach ($posts as $post) {
      $output .= "<li>" . $post->post_title . "</li>";
    }
    $output .= "</ul>";

    return $output;
  }

  return "Data no found";
}


function sp_handle_list_posts_wp_query_class($atts) {
  $atts = shortcode_atts(array(
    'number' => 5
  ), $atts, "list-posts");

  $query = new WP_Query(array(
    "posts_per_page" => $atts["number"],
    "post_status" => "publish"
  ));

  if ($query->have_posts()) {

    $output = "<ul>";
    while ($query->have_posts()) {
      $query->the_post();
      $output .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . "</a></li>";
    }
    $output .= "</ul>";
    
    return $output;
  }

  return "No Post Found";
}
