console.log("Hi, from CSV Data Uploader");

(function ($) {
  $(document).ready(function () {
    $("#frm-csv-upload").on("submit", function (event) {
      event.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        type: "POST",
        url: cdu_object.ajax_url, // variable from wp_localize_script
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: onSuccess,
      });
    });
  });
})(jQuery);

function onSuccess(res) {
  if (res.status) {
    $("#show_upload_msg").text(res.message).css({
      color: "green",
    });
  }

  $("#frm-csv-upload")[0].reset(); // reset form
}
