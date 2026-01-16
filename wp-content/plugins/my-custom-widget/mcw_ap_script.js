jQuery(document).ready(function () {
  jQuery(".mcw_ap_option").on("change", function () {
    let mcw_option_value = jQuery(this).val();

    if (mcw_option_value === "recent_posts") {
      jQuery(".mcw_display_recent_posts").toggleClass("hide_element");
      jQuery(".mcw_display_static_msg").addClass("hide_element");
    } else if (mcw_option_value === "static_message") {
      jQuery(".mcw_display_recent_posts").addClass("hide_element");
      jQuery(".mcw_display_static_msg").removeClass("hide_element");
    }
  });
});
