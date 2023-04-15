$(document).ready(function () {
  $("#sec_select, #sem_select").on("change", function () {
    var section = $("#sec_select").val();
    var semester = $("#sem_select").val();
    if (section == "" || semester == "") {
      return;
    }
    $.ajax({
      url: "./php/request.php",
      method: "POST",
      dataType: "html",
      type: "jsonp", // ???
      contentType: "application/x-www-form-urlencoded;charset=UTF-8",
      data: {
        sec_select: section,
        sem_select: semester,
      },
      success: function (response) {
        $("#listSubject").html("");
        $("#listSubject").html(response);
      },
      error: function (response) {
        console.log("Error: " + response);
      },
    });
  });
});

$(document).ready(function () {
  $("#section_id, #semester_id").on("change", function () {
    var section = $("#section_id").val();
    var semester = $("#semester_id").val();
    if (section == "" || semester == "") {
      return;
    }
    $.ajax({
      url: "./php/request.php",
      method: "POST",
      dataType: "html",
      type: "jsonp", // ???
      contentType: "application/x-www-form-urlencoded;charset=UTF-8",
      data: {
        edit_subject_schedule: 1,
        section_id: section,
        semester_id: semester,
      },
      success: function (response) {
        $("#listSubject").html("");
        $("#subject_id").html(response);
      },
    });
  });
  if ($("#section_id").val() && $("#semester_id").val()) {
    $("#section_id, #semester_id").trigger("change");
  }
});
