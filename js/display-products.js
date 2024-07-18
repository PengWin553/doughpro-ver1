let currentPage = 1;
const limit = 8;

function loadData(page = 1, search = '') {
    currentPage = page;

    fetch(`admin-display-products.php?page=${page}&items_per_page=${limit}&search=${search}`)
        .then(response => response.json())
        .then(result => {
            if (result.res === "success") {
                let tableBody = document.querySelector("table.content-table tbody");
                tableBody.innerHTML = '';

                result.data.forEach(item => {
                    let tableRow = `
                        <tr>
                            <td>${item.product_id}</td>
                            <td>${item.product_name}</td>
                            <td>${item.price}</td>
                            <td>${item.total_products}</td>
                            <td>${item.remaining_products}</td>
                            <td>${item.shelf_life}</td>
                            <td>${item.date_produced}</td>
                            <td>${item.spoilage_date}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete btn-update-product" 
                                    id="${item.product_id}" 
                                    data-product-name="${item.product_name}" 
                                    data-price="${item.price}" 
                                    data-total-products="${item.total_products}" 
                                    data-remaining-products="${item.remaining_products}"
                                    data-shelf-life="${item.shelf_life}"
                                    data-date-produced="${item.date_produced}"
                                    data-spoilage-date="${item.spoilage_date}">Edit</button>
                                <button class="btn-update-delete btn-delete btn-delete-product" id="${item.product_id}">Delete</button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', tableRow);
                });

                // Update pagination controls
                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                console.error("Failed to load product data:", result.message);
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching product data:", error);
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