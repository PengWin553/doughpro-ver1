$(document).on("click", ".btn-delete-category", function() {
    var categoryId = $(this).attr("id");
  
    if (confirm("Are you sure you want to delete this category?")) {
      $.ajax({
        url: "admin-delete-category.php",
        type: "POST",
        data: {
          category_id: categoryId
        }
      }).done(function(data) {
        let result = JSON.parse(data);
        if (result.res == "success") {
          location.reload();
        }
      });
    }
});