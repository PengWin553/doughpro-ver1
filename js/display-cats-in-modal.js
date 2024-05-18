document.addEventListener("DOMContentLoaded", function() {
    fetch('admin-display-cats-in-modal.php', {
        method: 'GET',
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
    .then(response => {
        if (response.res === 'success') {
            var select = document.getElementById('add_category');
            response.data.forEach(function(category) {
                let option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.category_name;
                select.appendChild(option);
            });
        } else {
            console.error("Error fetching categories: ", response.message);
        }
    })
    .catch(error => {
        console.error("Fetch error: ", error);
    });
});
