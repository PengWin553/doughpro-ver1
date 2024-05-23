function loadData() {
    fetch("display-inventory.php", {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(result => {
        if (result.res === "success") {
            let tableBody = document.querySelector("table.content-table tbody");
            tableBody.innerHTML = ''; // Clear existing table data
            
            result.data.forEach(item => {
                // Check if current_stock is less than min_stock_level
                let rowClass = item.current_stock < item.min_stock_level ? 'low-stock' : '';

                let tableRow = `
                    <tr class="${rowClass}">
                        <td>${item.inventory_id}</td>
                        <td>${item.inventory_name}</td>
                        <td>${item.category_name}</td>
                        <td>${item.inventory_description}</td>
                        <td>${item.inventory_price}</td>
                        <td>${item.current_stock}</td>
                        <td>${item.min_stock_level}</td>
                        <td>${item.unit}</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update btn-update-delete btn-update-inventory" 
                                id="${item.inventory_id}" 
                                data-inventory-name="${item.inventory_name}" 
                                data-inventory-category="${item.inventory_category}" 
                                data-category-name="${item.category_name}"
                                data-inventory-description="${item.inventory_description}" 
                                data-inventory-price="${item.inventory_price}" 
                                data-min-stock-level="${item.min_stock_level}"
                                data-inventory-unit="${item.unit}"
                            >Edit</button>
                            <button class="btn-update-delete btn-delete btn-delete-inventory" id="${item.inventory_id}">Delete</button>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', tableRow);
            });
        } else {
            alert("Failed to load inventory data.");
        }
    })
    .catch(error => {
        console.error("An error occurred while fetching inventory data:", error);
        alert("An error occurred while fetching inventory data. Please try again later.");
    });
}

document.addEventListener("DOMContentLoaded", function() {
    loadCategories(); // Load categories when the document is ready
    loadData();
});
