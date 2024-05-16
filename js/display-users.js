function loadData() {
    $.ajax({
        url: "display-users.php",
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
                            <td>${item.user_id}</td>
                            <td>${item.user_role}</td>
                            <td>${item.user_name}</td>
                            <td>${item.user_email}</td>
                            <td>${item.last_login_date}</td>
                            <td class="actions-buttons-container">
                                <button class="btn-update btn-update-delete" id="${item.user_id}" data-user-name="${item.user_name}" data-user-role="${item.user_role}" data-user-email="${item.user_email}">Edit</button>
                                <button class="btn-update-delete btn-delete" id="${item.user_id}">Delete</button>
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
        console.error("An error occurred while fetching user data:", error);
        alert("An error occurred while fetching user data. Please try again later.");
    });
}

$(document).ready(function() {
    loadData();
});

