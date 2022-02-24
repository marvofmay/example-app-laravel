import Category from '../model/category/category.js';
    
$(document).ready(function() {
    
    let category = null;
    
    $(document).on('click', '.btn-delete-category', function (e) {
        e.preventDefault(); 
        
        category = new Category (
            $(this).data('category-id'),
            $(this).data('category-name'),
            $(this).data('category-description'),
            $(this).data('token')
        );

        initModalConfirmDeleteCategory(category);       
                                       
        return false;
    });   
   
    $('#btn-confirm-delete-category').click(function () {    
        
        const deleteCategory = async () => {
            try {
                const res = await category.deleteCategory();
                showDeleteCategoryInfo (res);     
                reloadCategories();
            } catch (e) {
                console.log(e);
            } 
        }        
        
        deleteCategory();                
    });
    
    const initModalConfirmDeleteCategory = (category) => {
        
        $('#btn-cancel-delete-category').show();
        $('#btn-confirm-delete-category').show();
        $('#modal-info-body-category').html(''); 
        $('#modal-confirm-title-category').html(''); 
        $('#modal-confirm-body-category').html(''); 
        $('#modal-confirm-title-category').append(` "${category.name}"`); 
        $('#modal-confirm-body-category').html(category.description); 
        $('#modal-confirm-delete-category').modal('show');         
        
    };
    
    const showDeleteCategoryInfo = (res) => {
        $('#btn-cancel-delete-category').hide();
        $('#btn-confirm-delete-category').hide();
        $('#modal-info-body-category').html(res);                 
    };
    
    const reloadCategories = () => {
        $.ajax({
            type: 'GET',            
            accept: "application/json", 
            url: "/categories",       
            dataType: "html"
        }).success((msgFromPHPServer) => {
            $('#div-categories-list').html($(msgFromPHPServer).find('#div-categories-list').html());
        }).error((xhr, ajaxOptions, thrownError) => {                
            reject(xhr, ajaxOptions, thrownError);                 
        });                               
    };
    
});

