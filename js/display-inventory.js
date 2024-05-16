function loadData() {
    $.ajax({
        url: "display-inventory.php",
        method: "GET"
    }).done(function(data) {
        try {
            let result = JSON.parse(data);
            if (result.res === "success") {
                let tableBody = $("table.content-table tbody");
                tableBody.empty(); // Clear existing table data
                
                result.data.forEach(item => {
                    let tableRow = `
                        <tr>
                            <td>${item.product_id}</td>
                            <td>${item.product_name}</td>
                            <td>${item.product_category}</td>
                            <td>${item.product_description}</td>
                            <td>${item.product_price}</td>
                            <td>${item.min_stock_level}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete" id="${item.product_id}" data-product-name="${item.product_name}" data-product-category="${item.product_category}" data-product-description="${item.product_description} data-product-price="${item.product_price} data-min-stock-level="${item.min_stock_level}">Edit</button>
                                <button class="btn-update-delete btn-delete" id="${item.product_id}">Delete</button>
                            </td>
                        </tr>`;
                    tableBody.append(tableRow);
                });
            } else {
                alert("Failed to load user data.");
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
            alert("An unexpected error occurred. Please try again later.");
        }
    }).fail(function(xhr, status, error) {
        console.error("An error occurred while fetching product data:", error);
        alert("An error occurred while fetching product data. Please try again later.");
    });
}

$(document).ready(function() {
    loadData();
});
