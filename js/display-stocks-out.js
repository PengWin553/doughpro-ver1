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

                    let actionButton;
                    if (item.expired > 0) {
                        if (item.remaining_quantity > 0) {
                            actionButton = `<button class="btn-update btn-update-delete btn-discard-stock" id="${item.stock_id}" data-remaining="${item.remaining_quantity}">Discard Stock</button>`;
                        } else {
                            actionButton = `<button class="btn-update btn-update-delete btn-none" disabled>None</button>`;
                        }
                    } else {
                        if (item.remaining_quantity == 0){
                            actionButton = `<button class="btn-update btn-update-delete btn-none" disabled>None</button>`;
                        }else{
                            actionButton = `<button class="btn-update btn-update-delete btn-use-stock" id="${item.stock_id}">Use Stock</button>`;
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
                            <td>${item.discarded}</td>
                            <td>${item.expiry_date}</td>
                            <td>${item.updated_at}</td>
                            <td class="actions-buttons-container">
                                ${actionButton}
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

    // Add event listener for Discard Stock button
    document.querySelector('table.content-table tbody').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-discard-stock')) {
            const stockId = e.target.id;
            const remainingQuantity = e.target.getAttribute('data-remaining');
            openDiscardModal(stockId, remainingQuantity);
        }
    });

    // Add event listener for Confirm Discard button
    document.getElementById('confirmDiscardStock').addEventListener('click', function() {
        const stockId = document.getElementById('discardStockId').value;
        const quantity = document.getElementById('discardQuantity').value;
        discardStock(stockId, quantity);
    });

    // Add event listener for modal close button
    document.querySelector('#discardStockModal .btn-close').addEventListener('click', function() {
        const discardModal = bootstrap.Modal.getInstance(document.getElementById('discardStockModal'));
        discardModal.hide();
    });
});

function openDiscardModal(stockId, remainingQuantity) {
    document.getElementById('discardStockId').value = stockId;
    document.getElementById('discardQuantity').value = remainingQuantity;
    new bootstrap.Modal(document.getElementById('discardStockModal')).show();
}

function discardStock(stockId, quantity) {
    fetch('admin-discard-stock.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `stock_id=${stockId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.res === 'success') {
            const discardModal = bootstrap.Modal.getInstance(document.getElementById('discardStockModal'));
            discardModal.hide();
            loadData(currentPage, document.getElementById('searchStockOutName').value, document.getElementById('filterUsedSpoiled').value);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}