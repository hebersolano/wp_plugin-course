<?php
$value = get_post_meta($post->ID, '_meta_title', true);
?>

<p>
  <label for="mm_meta_title">Meta Title</label>
  <input type="text" name="mm_meta_title" placeholder="Meta Title..." id="mm_meta_title" value="<?= esc_attr($value) ?>">
</p>

<p>
  <label for="mm_meta_description">Meta Description</label>
  <input type="text" name="mm_meta_description" id="mm_meta_description" placeholder="Meta Description...">
</p>