document.addEventListener("DOMContentLoaded", function () {
  const secSelect = document.querySelector("#sec_select");
  const semSelect = document.querySelector("#sem_select");

  function onSelectionChange() {
    const section = secSelect.value;
    const semester = semSelect.value;
    if (section == "" || semester == "") {
      return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/request.php", true);
    xhr.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded;charset=UTF-8"
    );
    xhr.onload = function () {
      if (xhr.status === 200) {
        document.querySelector("#listSubject").innerHTML = xhr.responseText;
      } else {
        console.log("Error: " + xhr.statusText);
      }
    };
    xhr.onerror = function () {
      console.log("Error: " + xhr.statusText);
    };
    xhr.send(`sec_select=${section}&sem_select=${semester}`);
  }

  secSelect.addEventListener("change", onSelectionChange);
  semSelect.addEventListener("change", onSelectionChange);
});

document.addEventListener("DOMContentLoaded", function () {
  var section = document.querySelector("#section_id");
  var semester = document.querySelector("#semester_id");

  section.addEventListener("change", function () {
    var sectionValue = section.value;
    var semesterValue = semester.value;

    if (sectionValue === "" || semesterValue === "") {
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/request.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        document.querySelector("#listSubject").innerHTML = "";
        document.querySelector("#subject_id").innerHTML = xhr.responseText;
      }
    };
    xhr.send(
      "edit_subject_schedule=1&section_id=" +
        sectionValue +
        "&semester_id=" +
        semesterValue
    );
  });

  semester.addEventListener("change", function () {
    var sectionValue = section.value;
    var semesterValue = semester.value;

    if (sectionValue === "" || semesterValue === "") {
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/request.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        document.querySelector("#listSubject").innerHTML = "";
        document.querySelector("#subject_id").innerHTML = xhr.responseText;
      }
    };
    xhr.send(
      "edit_subject_schedule=1&section_id=" +
        sectionValue +
        "&semester_id=" +
        semesterValue
    );
  });

  if (section.value && semester.value) {
    section.dispatchEvent(new Event("change"));
  }
});
