$(document).ready(function() {
    $.ajax({
        url: 'admin-display-cats-in-modal.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.res === 'success') {
                var select = $('#add_category');
                response.data.forEach(function(category) {
                    select.append('<option value= "' + category.category_id + '">' + category.category_name + '</option>');
                });
            } else {
                console.error("Error fetching categories: ", response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: ", textStatus, errorThrown);
        }
    });
});
