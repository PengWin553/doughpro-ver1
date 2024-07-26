let currentPage = 1;
const limit = 8;

function loadData(page = 1, searchQuery = '') {
    currentPage = page;

    // Use fetch to retrieve data from the PHP endpoint
    fetch(`display-suppliers.php?page=${page}&search=${encodeURIComponent(searchQuery)}`)
        .then(response => response.json())
        .then(result => {
            if (result.res === "success") {
                let tableBody = document.querySelector("table.content-table tbody");
                tableBody.innerHTML = '';

                result.data.forEach(item => {
                    let tableRow = `
                        <tr>
                            <td>${item.supplier_id}</td>
                            <td>${item.supplier_name}</td>
                            <td>${item.email}</td>
                            <td>${item.contact_number}</td>
                            <td>${item.address}</td>
                            <td>${item.supply}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete btn-update-supplier" id="${item.supplier_id}" data-supplier-name="${item.supplier_name}" data-supply="${item.supply}">Edit</button>
                                <button class="btn-update-delete btn-delete btn-delete-supplier" id="${item.supplier_id}">Delete</button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', tableRow);
                });

                // Update pagination controls
                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                console.error("Failed to load category data:", result.message);
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching category data:", error);
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
        const searchQuery = document.getElementById('searchInput').value;
        loadData(currentPage - 1, searchQuery);
    }
}

function nextPage() {
    const searchQuery = document.getElementById('searchInput').value;
    loadData(currentPage + 1, searchQuery);
}

function liveSearch() {
    const searchQuery = document.getElementById('searchInput').value;
    loadData(1, searchQuery);
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();
});
