<?php


class My_Custom_Widget extends WP_Widget {
  public function __construct() {
    return parent::__construct("my_custom_widget", "My Custom Widget", array(
      "description" => "Display recent posts and static message"
    ));
  }

  // display widget to admin panel
  public function form($instance) {

    // id & name tag generation
    $title = ["name" => $this->get_field_name("mcw_title"), "id" => $this->get_field_id("mcw_title")];
    $display_opt = [$this->get_field_name("display_opt"), $this->get_field_id("display-opt")];
    $number_posts = [$this->get_field_name("number_posts"), $this->get_field_id("number_posts")];
    $static_msg = [$this->get_field_name("static_msg"), $this->get_field_id("static_msg")];

    // field values
    $title_v = !empty($instance["mcw_title"]) ? $instance["mcw_title"] : "";
    $display_opt_v = !empty($instance["display_opt"]) ? $instance["display_opt"] : "recent_posts";
    $number_posts_v = !empty($instance["number_posts"]) ? $instance["number_posts"] : "";
    $static_msg_v = !empty($instance["static_msg"]) ? $instance["static_msg"] : "";
?>
    <p>
      <label for="<?= $title["name"]; ?>">Title</label>
      <input type="text" class="widefat" name="<?= $title["name"] ?>" id="<?= $title["id"]; ?>" value="<?= $title_v ?>">
    </p>

    <p>
      <label for="<?= $display_opt[0]; ?>">Display Type</label>
      <select class="widefat mcw_ap_option" name="<?= $display_opt[0];  ?>" id="<?= $display_opt[1]; ?>">
        <option value="recent_posts" <?= $display_opt_v === "recent_posts" ? "selected" : ""; ?>>Recent Posts</option>
        <option value="static_message" <?= $display_opt_v === "static_message" ? "selected" : ""; ?>>Static Message</option>
      </select>
    </p>

    <p id="" class="mcw_display_recent_posts <?= $display_opt_v === "static_message" ? "hide_element" : ""; ?>">
      <label for="<?= $number_posts[0]; ?>">Number of posts</label>
      <input type="number" class="widefat" name="<?= $number_posts[0]; ?>" id="<?= $number_posts[1]; ?>" value="<?= $number_posts_v ?>">
    </p>

    <p id="" class="mcw_display_static_msg <?= $display_opt_v === "recent_posts" ? "hide_element" : ""; ?>">
      <label for="<?= $static_msg[0]; ?>">Your Message</label>
      <input type="text" class="widefat" name="<?= $static_msg[0]; ?>" id="<?= $static_msg[1]; ?>" value="<?= $static_msg_v ?>">
    </p>

<?php
  }

  // save widget settings to Wordpress
  public function update($new_instance, $old_instance) {
    $instance = []; // mcw_title, display_opt, static_msg, number_posts

    $instance["mcw_title"] = !empty($new_instance["mcw_title"]) ? strip_tags(($new_instance["mcw_title"])) : "";

    $instance["display_opt"] = !empty($new_instance["display_opt"]) ? sanitize_text_field(($new_instance["display_opt"])) : "";

    $instance["number_posts"] = !empty($new_instance["number_posts"]) ? sanitize_text_field(($new_instance["number_posts"])) : "";

    $instance["static_msg"] = !empty($new_instance["static_msg"]) ? sanitize_text_field(($new_instance["static_msg"])) : "";

    print_r($instance);
    return $instance;
  }

  // display widget to frontend
  public function widget($args, $instance) {
    $title = $instance["mcw_title"];

    echo $args["before_title"];
    echo $title;
    echo $args["after_title"];
    // check display type
    if ($instance["display_opt"] === "static_message") {

      echo $instance["static_message"];
    } elseif ($instance["display_opt"] === "recent_posts") {

      $query = new WP_Query([
        "posts_per_page" => $instance["number_posts"],
        "post_status" => "publish"
      ]);

      if ($query->have_posts()) {
        echo "<ul>";

        while ($query->have_posts()) {

          $query->the_post();
          echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . "</a></li>";
        }

        echo "</ul>";

        wp_reset_postdata();
      } else {
        echo "No Posts Found";
      }
    }
    echo $args["after_widget"];
  }
}
