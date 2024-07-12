let currentPage = 1;
const limit = 8;

function loadData(page = 1, search = '', filter = 'all') {
    currentPage = page;

    // Use fetch to retrieve data from the PHP endpoint
    fetch(`admin-display-stocks.php?page=${page}&items_per_page=${limit}&search=${search}&filter=${filter}`)
        .then(response => response.json())
        .then(result => {
            if (result.res === "success") {
                let tableBody = document.querySelector("table.content-table tbody");
                tableBody.innerHTML = '';

                let currentDate = new Date();

                result.data.forEach(item => {
                    let expiryDate = new Date(item.expiry_date);
                    let timeDiff = expiryDate - currentDate;
                    let dayDiff = timeDiff / (1000 * 3600 * 24); // Difference in days

                    let rowClass = '';
                    if (dayDiff <= 20 && dayDiff >= 0) {
                        rowClass = 'expiring-soon';
                    } else if (expiryDate < currentDate) {
                        rowClass = 'already-expired';
                    }

                    let tableRow = `
                        <tr class="${rowClass}">
                            <td>${item.stock_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.expiry_date}</td>
                            <td>${item.quantity}</td>
                            <td>${item.remaining_quantity}</td>
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

                // Update pagination controls
                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                console.error("Failed to load stock data:", result.message);
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching stock data:", error);
        });
}

function updatePaginationControls(page, total, limit) {
    const paginationControls = document.getElementById('pagination-controls');
    const totalPages = Math.ceil(total / limit);

    let paginationHTML = `
        <button onclick="prevPage()" ${page === 1 ? 'disabled' : ''}>Previous</button>
        <span>Page ${page} of ${totalPages}</span>
        <button onclick="nextPage()" ${page === totalPages ? 'disabled' : ''}>Next</button>
    `;

    paginationControls.innerHTML = paginationHTML;
}

function prevPage() {
    if (currentPage > 1) {
        loadData(currentPage - 1, document.getElementById('searchStockName').value, document.getElementById('filterExpiry').value);
    }
}

function nextPage() {
    loadData(currentPage + 1, document.getElementById('searchStockName').value, document.getElementById('filterExpiry').value);
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();

    document.getElementById('searchStockName').addEventListener('input', function() {
        loadData(1, this.value, document.getElementById('filterExpiry').value);
    });

    document.getElementById('filterExpiry').addEventListener('change', function() {
        loadData(1, document.getElementById('searchStockName').value, this.value);
    });
});
