$('#btn-add_supplier').click(function(event) {
    event.preventDefault(); // Prevent the default form submission

    // get the values from the form
    var supplierName = $("#add_supplier").val();
    var supplierEmail = $("#add_supplier_email").val();
    var supplierContactNumber = $("#add_supplier_contact_number").val();
    var supplierAddress = $("#add_supplier_address").val();
    var supply = $("#add_supply").val();

    if (supplierName.trim().length > 0) {
        fetch("admin-add-supplier.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                supplier_name: supplierName,
                supplier_email: supplierEmail,
                supplier_contact_number: supplierContactNumber,
                supplier_address: supplierAddress,
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
