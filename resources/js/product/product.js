import Product from '../model/product/product.js';
    
$(document).ready(function() {
    
    let product = null;
    
    $(document).on('click', '.btn-delete-product', function (e) {
        e.preventDefault(); 
        
        product = new Product (
            $(this).data('product-id'),
            $(this).data('product-name'),
            $(this).data('product-description'),
            $(this).data('token')
        );

        initModalConfirmDeleteProduct(product);       
                                       
        return false;
    });   
   
    $('#btn-confirm-delete-product').click(function () {    
        
        const deleteProduct = async () => {
            try {
                const res = await product.deleteProduct();
                showDeleteProductInfo (res);     
                reloadProducts();
            } catch (e) {
                console.log(e);
            } 
        }        
        
        deleteProduct();                
    });
    
    const initModalConfirmDeleteProduct = (product) => {
        
        $('#btn-cancel-delete-product').show();
        $('#btn-confirm-delete-product').show();
        $('#modal-info-body-product').html(''); 
        $('#modal-confirm-title-product').html(''); 
        $('#modal-confirm-body-product').html(''); 
        $('#modal-confirm-title-product').append(` "${product.name}"`); 
        $('#modal-confirm-body-product').html(product.description); 
        $('#modal-confirm-delete-product').modal('show');         
        
    };
    
    const showDeleteProductInfo = (res) => {
        $('#btn-cancel-delete-product').hide();
        $('#btn-confirm-delete-product').hide();
        $('#modal-info-body-product').html(res);                 
    };
    
    const reloadProducts = () => {
        $.ajax({
            type: 'GET',            
            accept: "application/json", 
            url: "/products",       
            dataType: "html"
        }).success((msgFromPHPServer) => {
            $('#div-products-list').html($(msgFromPHPServer).find('#div-products-list').html());
        }).error((xhr, ajaxOptions, thrownError) => {                
            reject(xhr, ajaxOptions, thrownError);                 
        });                               
    };
    
});

