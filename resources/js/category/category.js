$(document).ready(function() {
    $('.btn-delete-category').click(function(e) {
        e.preventDefault();
        console.log($(this).data('category-id'));
    });   
});

