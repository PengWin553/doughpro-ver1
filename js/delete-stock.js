$(document).on("click", ".btn-delete-stock", function () {
    var stockId = $(this).attr("id");
  
    if (confirm("Are you sure you want to delete this stock?")) {
      fetch("admin-delete-stock.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          stock_id: stockId
        }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.res === "success") {
            location.reload();
          }
        })
        .catch(error => {
          console.error('Error occurred while deleting stock:', error);
          alert("An error occurred. Please try again later.");
        });
    }
  });
  