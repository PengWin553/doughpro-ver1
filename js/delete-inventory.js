$(document).on("click", ".btn-delete-inventory", function () {
  var inventoryId = $(this).attr("id");

  if (confirm("Are you sure you want to delete this inventory?")) {
    fetch("admin-delete-inventory.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        inventory_id: inventoryId,
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
