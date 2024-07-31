document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link a');

    function setActiveLink(clickedLink) {
        // Remove active class from all links
        navLinks.forEach(link => link.classList.remove('active'));
        
        // Add active class to clicked link
        clickedLink.classList.add('active');
        
        // Store active link in localStorage
        localStorage.setItem('activeLink', clickedLink.getAttribute('href'));
    }

    // Add click event listener to each link
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            setActiveLink(this);
        });
    });

    // Check for active link on page load
    const activeLink = localStorage.getItem('activeLink');
    if (activeLink) {
        const link = document.querySelector(`a[href="${activeLink}"]`);
        if (link) {
            link.classList.add('active');
        }
    } else {
        // If no active link is stored, set admin-dashboard.php as active
        const defaultLink = document.querySelector('a[href="admin-dashboard.php"]');
        if (defaultLink) {
            defaultLink.classList.add('active');
            localStorage.setItem('activeLink', 'admin-dashboard.php');
        }
    }
});