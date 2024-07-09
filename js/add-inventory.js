$('#btn-add_inventory').click(function(event){
    // Prevent the default form submission
    event.preventDefault();
    
    // get the values from the form
    var inventoryName = $("#add_inventory_name").val();
    var category = $("#add_category").val();
    var description = $("#add_inventory_description").val();
    var price = $("#add_inventory_price").val();
    var stock = $("#add_min_stock_level").val();
    var unit = $("#add_inventory_unit").val();

    if (inventoryName.trim().length > 0) {
        fetch("admin-add-inventory.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                inventory_name: inventoryName,
                inventory_category: category,
                inventory_description: description,
                inventory_price: price,
                inventory_stock: stock,
                inventory_unit: unit,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.res === "success") {
                location.reload();
            } else if (data.res === "exists" || data.res === "error") {
                // Display error message
                alert(data.msg);
            }
        })
        .catch(error => {
            console.error('Error occurred while adding inventory:', error);
            alert("An error occurred. Please try again later.");
        });
    } else {
        alert("Please fill out all fields.");
    }
});
