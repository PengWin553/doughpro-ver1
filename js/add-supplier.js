$('#btn-add_supplier').click(function(event) {
    event.preventDefault(); // Prevent the default form submission

    // get the values from the form
    var supplierName = $("#add_supplier").val();
    var supply = $("#add_supply").val();

    if (supplierName.trim().length > 0) {
        fetch("admin-add-supplier.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                supplier_name: supplierName,
                supply: supply,
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
            console.error('Error occurred while adding supplier:', error);
            alert("An error occurred. Please try again later.");
        });
    } else {
        alert("Please fill out all fields.");
    }
});
