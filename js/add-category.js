$('#btn-add_category').click(function(event) {
    // get the values from the form
    var categoryName = $("#add_category").val();

    if (categoryName.trim().length > 0) {
        fetch("admin-add-category.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                category_name: categoryName,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.res === "success") {
                location.reload();
            } else if (data.res === "exists" || data.res === "error") {
                alert(data.msg);
            }
        })
        .catch(error => {
            console.error('Error occurred while adding category:', error);
            alert("An error occurred. Please try again later.");
        });
    } else {
        alert("Please fill out all fields.");
    }
});
