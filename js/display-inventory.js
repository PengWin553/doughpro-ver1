let currentPage = 1;
const limit = 8;
let searchTerm = '';
let categoryFilter = '';

function loadCategories() {
    fetch('get-categories.php')
        .then(response => response.json())
        .then(categories => {
            const categoryFilterElement = document.getElementById('categoryFilter');
            categoryFilterElement.innerHTML = '<option value="">All Categories</option>'; // Reset and add default option
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.category_name;
                categoryFilterElement.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading categories:', error));
}

function loadData(page = 1) {
    currentPage = page;

    fetch(`display-inventory.php?page=${page}&items_per_page=${limit}&search=${searchTerm}&category=${categoryFilter}`)
        .then(response => response.json())
        .then(result => {
            if (result.res === "success") {
                let tableBody = document.querySelector("table.content-table tbody");
                tableBody.innerHTML = ''; // Clear existing table data
                
                result.data.forEach(item => {
                    let rowClass = item.current_stock < item.min_stock_level ? 'low-stock' : '';

                    let tableRow = `
                        <tr class="${rowClass}">
                            <td>${item.inventory_id}</td>
                            <td>${item.inventory_name}</td>
                            <td>${item.category_name}</td>
                            <td>${item.inventory_description}</td>
                            <td>${item.unit}</td>
                            <td>₱${item.inventory_price}</td>
                            <td>${item.current_stock}</td>
                            <td>${item.min_stock_level}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete btn-update-inventory" 
                                    id="${item.inventory_id}" 
                                    data-inventory-name="${item.inventory_name}" 
                                    data-inventory-category="${item.inventory_category}" 
                                    data-category-name="${item.category_name}"
                                    data-inventory-description="${item.inventory_description}" 
                                    data-inventory-price="${item.inventory_price}" 
                                    data-min-stock-level="${item.min_stock_level}"
                                    data-inventory-unit="${item.unit}"
                                >Edit</button>
                                <button class="btn-update-delete btn-delete btn-delete-inventory" id="${item.inventory_id}">Delete</button>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', tableRow);
                });

                // Update pagination controls
                updatePaginationControls(result.page, result.total, result.limit);
            } else {
                alert("Failed to load inventory data.");
            }
        })
        .catch(error => {
            console.error("An error occurred while fetching inventory data:", error);
            alert("An error occurred while fetching inventory data. Please try again later.");
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
        loadData(currentPage - 1);
    }
}

function nextPage() {
    loadData(currentPage + 1);
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();
    loadCategories();

    const searchInput = document.getElementById('searchInput');
    const categoryFilterElement = document.getElementById('categoryFilter');

    searchInput.addEventListener('input', function() {
        searchTerm = this.value;
        currentPage = 1;
        loadData();
    });

    categoryFilterElement.addEventListener('change', function() {
        categoryFilter = this.value;
        currentPage = 1;
        loadData();
    });
});