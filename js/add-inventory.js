$("#btn-add_inventory").click(function(event) {
    // get the values from the form
    var inventoryName = $("#add_inventory_name").val();
    var category = $("#add_category").val();
    var description = $("#add_inventory_description").val();
    var price = $("#add_inventory_price").val();
    var stock = $("#add_min_stock_level").val();

    if (inventoryName.trim().length > 0) {
        $.ajax({
            url: "admin-add-inventory.php",
            method: "POST",
            data: {
                inventory_name: inventoryName,
                inventory_category: category,
                inventory_description: description,
                inventory_price: price,
                inventory_stock: stock,
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
