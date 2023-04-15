function filterTable(filterSelectors, tableSelector) {
  var filterValues = {};

  filterSelectors.forEach(function (selector, index) {
    var inputEl = document.querySelector(selector);
    filterValues[index] = inputEl.value;

    if (inputEl.tagName.toLowerCase() === "select") {
      inputEl.addEventListener("change", function () {
        filterValues[index] = inputEl.value;
        filterTableData(filterValues, tableSelector);
      });
    } else {
      inputEl.addEventListener("keyup", function () {
        filterValues[index] = inputEl.value;
        filterTableData(filterValues, tableSelector);
      });
    }
  });

  function filterTableData(filterValues, tableSelector) {
    var tableEl = document.querySelector(tableSelector + " tbody");
    var rows = tableEl.querySelectorAll("tr");

    rows.forEach(function (row) {
      var shouldShowRow = true;

      Object.keys(filterValues).forEach(function (key) {
        var columnIndex = parseInt(key);
        var tdValue = row
          .querySelectorAll("td")
          [columnIndex].textContent.toLowerCase();
        var filterValue = filterValues[key].toLowerCase();

        if (tdValue.indexOf(filterValue) === -1) {
          shouldShowRow = false;
        }
      });

      if (shouldShowRow) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

  // Initial filter
  filterTableData(filterValues, tableSelector);
}
