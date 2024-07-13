document.addEventListener('DOMContentLoaded', function() {
    const useStockModal = new bootstrap.Modal(document.getElementById('useStockModal'));

    // Event delegation for dynamically created buttons
    document.querySelector('table.content-table tbody').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-use-stock')) {
            const stockId = e.target.id;
            document.getElementById('useStockId').value = stockId;
            useStockModal.show();
        }
    });

    document.getElementById('confirmUseStock').addEventListener('click', function() {
        const stockId = document.getElementById('useStockId').value;
        const quantity = document.getElementById('useQuantity').value;

        if (quantity > 0) {
            fetch('admin-use-stock.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `stock_id=${stockId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.res === 'success') {
                    useStockModal.hide();
                    // Reload the data to reflect the changes
                    loadData(currentPage, document.getElementById('searchStockOutName').value, document.getElementById('filterUsedSpoiled').value);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        } else {
            alert('Please enter a valid quantity.');
        }
    });
});