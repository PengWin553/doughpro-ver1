let currentPage = 1;
const limit = 8;

function loadData(page = 1, search = '', filter = 'all') {
    currentPage = page;

    fetch(`admin-display-stocks-out.php?page=${page}&items_per_page=${limit}&search=${search}&filter=${filter}`)
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

                        // Automatically update the expired column if the item has expired
                        if (item.remaining_quantity > 0 && item.expired === 0) {
                            updateExpiredStock(item.stock_id, item.remaining_quantity);
                            item.expired = item.remaining_quantity; // Set expired to remaining quantity
                        }
                    }

                    let tableRow = `
                        <tr class="${rowClass}">
                            <td>${item.stock_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.quantity}</td>
                            <td>${item.remaining_quantity}</td>
                            <td>${item.used}</td>
                            <td>${item.expired}</td>
                            <td>${item.expiry_date}</td>
                            <td>${item.updated_at}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete btn-use-stock" id="${item.stock_id}">
                                    Use Stock
                                </button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', tableRow);
                });

                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                console.error("Failed to load stock data:", result.message);
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching stock data:", error);
        });
}

function updateExpiredStock(stockId, remainingQuantity) {
    fetch('admin-update-expired-stock.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            stock_id: stockId,
            remaining_quantity: remainingQuantity
        })
    })
    .then(response => response.json())
    .then(result => {
        if (result.res !== "success") {
            console.error("Failed to update expired stock:", result.message);
        }
    })
    .catch(error => {
        console.error("An error occurred while updating expired stock:", error);
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
        loadData(currentPage - 1, document.getElementById('searchStockOutName').value, document.getElementById('filterUsedSpoiled').value);
    }
}

function nextPage() {
    loadData(currentPage + 1, document.getElementById('searchStockOutName').value, document.getElementById('filterUsedSpoiled').value);
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();

    document.getElementById('searchStockOutName').addEventListener('input', function() {
        loadData(1, this.value, document.getElementById('filterUsedSpoiled').value);
    });

    document.getElementById('filterUsedSpoiled').addEventListener('change', function() {
        loadData(1, document.getElementById('searchStockOutName').value, this.value);
    });
});
