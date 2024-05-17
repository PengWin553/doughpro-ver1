$(document).on("click", ".btn-delete-inventory", function() {
    var inventoryId = $(this).attr("id");
  
    if (confirm("Are you sure you want to delete this inventory?")) {
      $.ajax({
        url: "admin-delete-inventory.php",
        type: "POST",
        data: {
          inventory_id: inventoryId,
        }
      }).done(function(data) {
        let result = JSON.parse(data);
        if (result.res == "success") {
          location.reload();
        }
      });
    }
});