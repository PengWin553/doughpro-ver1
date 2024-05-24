function formatDateToMySQL(date) {
    let year = date.getFullYear();
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
    let day = date.getDate().toString().padStart(2, '0');

    return `${year}-${month}-${day}`;
}

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

            // Get the current date
            let currentDate = new Date();

            result.data.forEach(item => {
                let expiryDate = new Date(item.expiry_date);
                let timeDiff = expiryDate - currentDate;
                let dayDiff = timeDiff / (1000 * 3600 * 24); // Difference in days

                let rowClass = dayDiff <= 20 ? 'expiring-soon' : '';

                let tableRow = `
                    <tr class="${rowClass}">
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
