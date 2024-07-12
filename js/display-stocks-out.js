let currentPage = 1;
const limit = 8;

function loadStockOutData(page = 1, search = '', filter = 'all') {
    currentPage = page;

    // Use fetch to retrieve data from the PHP endpoint
    fetch(`admin-display-stocks-out.php?page=${page}&items_per_page=${limit}&search=${search}&filter=${filter}`)
        .then(response => response.json())
        .then(result => {
            if (result.res === "success") {
                let tableBody = document.querySelector("table.content-table tbody");
                tableBody.innerHTML = '';

                result.data.forEach(item => {
                    let tableRow = `
                        <tr>
                            <td>${item.stock_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.quantity}</td>
                            <td>${item.remaining_quantity}</td>
                            <td>${item.used}</td>
                            <td>${item.spoiled}</td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', tableRow);
                });

                // Update pagination controls
                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                console.error("Failed to load stock out data:", result.message);
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching stock out data:", error);
        });
}

function updatePaginationControls(page, total, limit) {
    const paginationControls = document.getElementById('pagination-controls');
    const totalPages = Math.ceil(total / limit);

    let paginationHTML = `
        <button onclick="prevStockOutPage()" ${page === 1 ? 'disabled' : ''}>Previous</button>
        <span>Page ${page} of ${totalPages}</span>
        <button onclick="nextStockOutPage()" ${page === totalPages ? 'disabled' : ''}>Next</button>
    `;

    paginationControls.innerHTML = paginationHTML;
}

function prevStockOutPage() {
    if (currentPage > 1) {
        loadStockOutData(currentPage - 1);
    }
}

function nextStockOutPage() {
    loadStockOutData(currentPage + 1);
}

document.addEventListener("DOMContentLoaded", function() {
    loadStockOutData();

    document.getElementById('searchStockOutName').addEventListener('input', function() {
        loadStockOutData(1, this.value, document.getElementById('filterUsedSpoiled').value);
    });

    document.getElementById('filterUsedSpoiled').addEventListener('change', function() {
        loadStockOutData(1, document.getElementById('searchStockOutName').value, this.value);
    });
});
