$(document).on("click", ".btn-delete", function () {
  var userId = $(this).attr("id");

  if (confirm("Are you sure you want to delete this user?")) {
    fetch("admin-deleteUser.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        id: userId,
      }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.res === "success") {
          location.reload();
        }
      })
      .catch(error => {
        console.error('Error occurred while deleting user:', error);
        alert("An error occurred. Please try again later.");
      });
  }
});
