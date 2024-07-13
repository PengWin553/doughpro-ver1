let currentPage = 1;
const limit = 8;

function loadData(page = 1, search = '') {
    currentPage = page;

    fetch(`admin-display-stocks-out.php?page=${page}&items_per_page=${limit}&search=${search}`)
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
        loadData(currentPage - 1, document.getElementById('searchStockName').value);
    }
}

function nextPage() {
    loadData(currentPage + 1, document.getElementById('searchStockName').value);
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();

    document.getElementById('searchStockName').addEventListener('input', function() {
        loadData(1, this.value);
    });
});