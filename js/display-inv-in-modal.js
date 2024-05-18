$(document).ready(function(){
    // Fetch inventory names for dropdown
    fetch('admin-display-inv-in-modal.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(response => {
        console.log("Response from server: ", response);
        if (response.res === 'success') {
            var inventoryNames = response.data;

            // Populate select dropdown with inventory names
            var select = document.getElementById('add_stock_name');
            inventoryNames.forEach(item => {
                var option = document.createElement('option');
                option.value = item.inventory_id;
                option.textContent = item.inventory_name;
                select.appendChild(option);
            });
        } else {
            console.error("Error fetching inventory names: ", response.message);
        }
    })
    .catch(error => {
        console.error("Fetch error: ", error);
    });
});

