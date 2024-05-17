function loadData() {
    $.ajax({
        url: "admin-display-stocks.php",
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
                            <td>${item.stock_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.quantity}</td>
                            <td>${item.unit}</td>
                            <td>${item.expiry_date}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete btn-update-stock" 
                                    id="${item.stock_id}" 
                                    data-inventory-name="${item.inventory_name}" 
                                    data-quantity="${item.quantity}" 
                                    data-unit="${item.unit}"
                                    data-expiry-date="${item.expiry_date}" 
                                >Edit</button>
                                <button class="btn-update-delete btn-delete btn-delete-stock" id="${item.stock_id}">Delete</button>
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
    loadData();
});