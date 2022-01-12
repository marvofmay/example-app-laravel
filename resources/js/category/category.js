$(document).ready(function() {
   console.log('bbbb'); 
    $('.delete-category').click(function(e) {
        e.preventDefault();
        console.log($(this).data('category-id'));
    });   
});

