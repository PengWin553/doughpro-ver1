function loadData() {
    fetch("display-categories.php", {
        method: "GET"
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
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
                        <td>${item.category_id}</td>
                        <td>${item.category_name}</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update btn-update-delete btn-update-category" id="${item.category_id}" data-category-name="${item.category_name}">Edit</button>
                            <button class="btn-update-delete btn-delete btn-delete-category" id="${item.category_id}">Delete</button>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', tableRow);
            });
        } else {
            alert("Failed to load user data.");
        }
    })
    .catch(error => {
        console.error("An error occurred while fetching category data:", error);
        alert("An error occurred while fetching category data. Please try again later.");
    });
}

document.addEventListener("DOMContentLoaded", function() {
    loadData();
});
