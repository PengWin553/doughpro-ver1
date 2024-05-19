function loadData() {
    fetch("admin-display-stocks.php", {
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
                let tableRow = `
                    <tr>
                        <td>${item.stock_id}</td>
                        <td>${item.inventory_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.expiry_date}</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update btn-update-delete btn-update-stock" 
                                id="${item.stock_id}" 
                                data-inventory-name="${item.inventory_name}" 
                                data-quantity="${item.quantity}" 
                                data-expiry-date="${item.expiry_date}">Edit</button>
                            <button class="btn-update-delete btn-delete btn-delete-stock" id="${item.stock_id}">Delete</button>
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
    loadData();
});
