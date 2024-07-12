// Populate the Update Users Modal with data
$(document).on("click", ".btn-update-supplier", function() {
    var supplier_id = $(this).attr("id");
    var supplier_name = $(this).data("supplier-name");
    var supply = $(this).data("supply");

    // Set values in the update modal
    $("#update_supplier_id").val(supplier_id);
    $("#update_supplier").val(supplier_name);
    $("#update_supply").val(supply);

    $("#updateSupplierModal").modal("show");
});

$("#btn-update_supplier").click(function() {
    console.log('The update supplier button was pressed');

    // Get the updated data from the form
    var supplierId = $("#update_supplier_id").val();
    var supplierName = $("#update_supplier").val();
    var supply = $("#update_supply").val();

    var formData = new FormData();

    // Append form data
    formData.append('supplier_id', supplierId);
    formData.append('supplier_name', supplierName);
    formData.append('supply', supply);

    if (supplierName.length > 0 && supply.length > 0) {
        fetch("admin-update-suppliers.php", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            if (result.res === "success") {
                location.reload();
            }
        })
        .catch(error => {
            console.error("An error occurred while updating supplier info:", error);
            alert("An error occurred while updating supplier info. Please try again later.");
        });
    }
});