console.log("Hi, from CSV Data Uploader");

(function ($) {
  $(document).ready(function () {
    console.log("jquery init");

    $("#frm-csv-upload").on("submit", function (event) {
      event.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        type: "POST",
        url: cdu_object.ajax_url,
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.status) {
            $("#show_upload_msg").text(res.message).css({
              color: "green",
            });
          }
        },
      });
    });
  });
})(jQuery);
