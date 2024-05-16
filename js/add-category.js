$("#btn-add_category").click(function(event) {
    // get the values from the form
    var categoryName = $("#add_category").val();

    if (categoryName.trim().length > 0) {
        $.ajax({
            url: "admin-add-category.php",
            method: "POST",
            data: {
                category_name: categoryName,
            },
            success: function(data) {
                var result = JSON.parse(data);
                if (result.res === "success") {
                    location.reload();
                } else if (result.res === "exists") {
                    alert(result.msg);
                } else {
                    alert(result.msg);
                }
            }
        });
    } else {
        alert("Please fill out all fields.");
    }
});
