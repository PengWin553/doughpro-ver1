function loadData() {
    $.ajax({
        url: "display-categories.php",
        method: "GET"
    }).done(function(data) {
        try {
            let result = JSON.parse(data);
            if (result.res === "success") {
                let tableBody = $("table.content-table tbody");
                tableBody.empty(); // Clear existing table data
                
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
                    tableBody.append(tableRow);
                });
            } else {
                alert("Failed to load user data.");
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
            alert("An unexpected error occurred. Please try again later.");
        }
    }).fail(function(xhr, status, error) {
        console.error("An error occurred while fetching category data:", error);
        alert("An error occurred while fetching category data. Please try again later.");
    });
}

$(document).ready(function() {
    loadData();
});
