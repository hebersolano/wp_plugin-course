<?php
/*
* Plugin Name: HS Tests
* Plugin URI: https://example.com/plugins/the-basics/
* Description: Basic tests.
* Version: 0.1
* Requires at least: 5.2
* Requires PHP: 7.2
* Author: Solano
* Author URI: https://author.example.com/
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Update URI: https://example.com/my-plugin/
* Text Domain: my-basics-plugin
*/


// USER CAPABILITIES
/**
 * Generate a Delete link based on the homepage url.
 *
 * @param string $content   Existing content.
 *
 * @return string|null
 */
function wporg_generate_delete_link($content) {
  // Run only for single post page.
  if (is_single() && in_the_loop() && is_main_query()) {
    // Add query arguments: action, post.
    $url = add_query_arg(
      [
        'action' => 'wporg_frontend_delete',
        'post'   => get_the_ID(),
      ],
      home_url()
    );

    return $content . ' <a href="' . esc_url($url) . '">' . esc_html__('Delete Post', 'wporg') . '</a>';
  }

  return null;
}


/**
 * Request handler
 */
function wporg_delete_post() {
  if (isset($_GET['action']) && 'wporg_frontend_delete' === $_GET['action']) {

    // Verify we have a post id.
    $post_id = (isset($_GET['post'])) ? ($_GET['post']) : (null);

    // Verify there is a post with such a number.
    $post = get_post((int) $post_id);
    if (empty($post)) {
      return;
    }

    // Delete the post.
    wp_trash_post($post_id);

    // Redirect to admin page.
    $redirect = admin_url('edit.php');
    wp_safe_redirect($redirect);

    // We are done.
    die;
  }
}


/**
 * Add the delete link to the end of the post content.
 */
add_filter('the_content', 'wporg_generate_delete_link');

/**
 * Register our request handler with the init hook.
 */
add_action('init', 'wporg_delete_post');
