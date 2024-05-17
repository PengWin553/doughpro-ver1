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
                            <td>${item.inventory_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.category_name}</td>
                            <td>${item.inventory_description}</td>
                            <td>${item.inventory_price}</td>
                            <td>${item.min_stock_level}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete btn-update-inventory" 
                                    id="${item.inventory_id}" 
                                    data-inventory-name="${item.inventory_name}" 
                                    data-inventory-category="${item.inventory_category}" 
                                    data-category-name="${item.category_name}"
                                    data-inventory-description="${item.inventory_description}" 
                                    data-inventory-price="${item.inventory_price}" 
                                    data-min-stock-level="${item.min_stock_level}">Edit</button>
                                <button class="btn-update-delete btn-delete btn-delete-inventory" id="${item.inventory_id}">Delete</button>
                            </td>
                        </tr>`;
                    tableBody.append(tableRow);
                });
            } else {
                alert("Failed to load inventory data.");
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
            alert("An unexpected error occurred. Please try again later.");
        }
    }).fail(function(xhr, status, error) {
        console.error("An error occurred while fetching inventory data:", error);
        alert("An error occurred while fetching inventory data. Please try again later.");
    });
}

$(document).ready(function() {
    loadCategories(); // Load categories when the document is ready
    loadData();
});
