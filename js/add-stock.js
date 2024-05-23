$('#btn-add_stock').click(function(event) {
    event.preventDefault(); // Prevent the default form submission
    // get the values from the form
    var name = $("#add_stock_name").val();
    var quantity = $("#set_quantity").val();
    var expiry = $("#set_expiry_date").val();

    if (name.trim().length > 0 && quantity.trim().length > 0 && expiry.trim().length > 0) {
        fetch("admin-add-stock.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                stock_name: name,
                stock_quantity: quantity,
                stock_expiry: expiry
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
            console.error('Error occurred while adding stock:', error);
            alert("An error occurred. Please try again later.");
        });
    } else {
        alert("Please fill out all fields.");
    }
});
