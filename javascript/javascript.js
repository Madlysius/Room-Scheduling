function deleteConfirmation(deleteType, id) {
  if (confirm("Are you sure you want to delete this " + deleteType + "?")) {
    window.location.href =
      "./php/delete-data.php?delete=" +
      deleteType +
      "&" +
      deleteType +
      "_id=" +
      id;
  }
}
