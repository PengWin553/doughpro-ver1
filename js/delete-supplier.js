$(document).on("click", ".btn-delete-supplier", function () {
    var supplierId = $(this).attr("id");
  
    if (confirm("Are you sure you want to delete this supplier?")) {
      fetch("admin-delete-supplier.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          supplier_id: supplierId
        }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.res === "success") {
            location.reload();
          }
        })
        .catch(error => {
          console.error('Error occurred while deleting supplier:', error);
          alert("An error occurred. Please try again later.");
        });
    }
  });
  