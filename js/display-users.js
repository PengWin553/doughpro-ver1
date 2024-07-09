function loadData(page = 1, limit = 7, search = '', filter = '') {
    fetch(`display-users.php?page=${page}&limit=${limit}&search=${search}&filter=${filter}`, {
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
            
            result.data.forEach(item => {
                let tableRow = `
                    <tr>
                        <td>${item.user_id}</td>
                        <td>${item.user_role}</td>
                        <td>${item.user_name}</td>
                        <td>${item.user_email}</td>
                        <td>${item.last_login_date}</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update btn-update-delete" 
                                id="${item.user_id}" 
                                data-user-name="${item.user_name}" 
                                data-user-role="${item.user_role}" 
                                data-user-email="${item.user_email}">Edit</button>
                            <button class="btn-update-delete btn-delete" id="${item.user_id}">Delete</button>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', tableRow);
            });

            // Add pagination controls
            const paginationContainer = document.querySelector(".pagination-container");
            paginationContainer.innerHTML = '';
            const totalPages = Math.ceil(result.total / result.limit);
            for (let i = 1; i <= totalPages; i++) {
                const paginationButton = document.createElement("button");
                paginationButton.innerText = i;
                paginationButton.addEventListener("click", () => loadData(i, limit, search, filter));
                if (i === result.page) {
                    paginationButton.classList.add("active");
                }
                paginationContainer.appendChild(paginationButton);
            }
        } else {
            alert("Failed to load user data.");
        }
    })
    .catch(error => {
        console.error("An error occurred while fetching user data:", error);
        alert("An error occurred while fetching user data. Please try again later.");
    });
}

document.addEventListener("DOMContentLoaded", function() {
    // Load initial data
    loadData();

    // Search functionality
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function() {
        loadData(1, 8, searchInput.value, filterSelect.value);
    });

    // Filter functionality
    const filterSelect = document.getElementById('filter-select');
    filterSelect.addEventListener('change', function() {
        loadData(1, 8, searchInput.value, filterSelect.value);
    });
});
