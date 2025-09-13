// assets/js/script.js

$(document).ready(function() {
    
    // Add a confirmation dialog for all delete buttons
    $('.btn-delete').on('click', function(e) {
        e.preventDefault(); // Stop the link from navigating immediately
        
        const href = $(this).attr('href'); // Get the URL from the link
        
        if (confirm("Are you sure you want to delete this record? This action cannot be undone.")) {
            // If the user clicks "OK", navigate to the delete URL
            window.location.href = href;
        }
    });

});