$(document).on("click", ".btn-delete", function() {
    var userId = $(this).attr("id");
  
    if (confirm("Are you sure you want to delete this user?")) {
      $.ajax({
        url: "admin-deleteUser.php",
        type: "POST",
        data: {
          id: userId
        }
      }).done(function(data) {
        let result = JSON.parse(data);
        if (result.res == "success") {
          location.reload();
        }
      });
    }
});