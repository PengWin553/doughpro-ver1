let currentPage = 1;
const limit = 8;

function loadData(page = 1, search = '') {
    currentPage = page;

    fetch(`to-order-list.php?page=${page}&items_per_page=${limit}&search=${search}`)
        .then(response => response.json())
        .then(result => {
            if (result.res === "success") {
                let tableBody = document.querySelector("table.content-table tbody");
                tableBody.innerHTML = '';

                result.data.forEach(item => {
                    let tableRow = `
                        <tr>
                            <td>${item.to_order_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.to_order_quantity}</td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', tableRow);
                });

                // Update pagination controls
                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                console.error("Failed to load to order data:", result.message);
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching to order data:", error);
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
        loadData(currentPage - 1, document.getElementById('searchToOrderName').value);
    }
}

function nextPage() {
    loadData(currentPage + 1, document.getElementById('searchToOrderName').value);
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();

    document.getElementById('searchInput').addEventListener('input', function() {
        loadData(1, this.value);
    });
});