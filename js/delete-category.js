$(document).on("click", ".btn-delete", function () {
  var categoryId = $(this).attr("id");

  if (confirm("Are you sure you want to delete this category?")) {
    fetch("admin-delete-category.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        category_id: categoryId
      }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.res === "success") {
          location.reload();
        }
      })
      .catch(error => {
        console.error('Error occurred while deleting category:', error);
        alert("An error occurred. Please try again later.");
      });
  }
});
