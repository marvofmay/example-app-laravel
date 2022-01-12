$(document).ready(function() {
    
    console.log('product.js'); 
    
    //on click button "delete product"
    $('.delete-product').click(function (e) {
        e.preventDefault();
        
        //$('#modal-confirm-delete-product').modal('show');
        
        $.ajax({
            method: "post",
            url: "/product/delete_product/",
            data: { 
                _token: $(this).data('token'),
                _method: $(this).data('method'),
                product_id: $(this).data('product_id')
            }
        }).done(function(msg) {
            console.log(msg);
        });        
        
        return false;
    });
    
    //on click button "confirm delete product"
    
});

