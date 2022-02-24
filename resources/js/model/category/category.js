class Category {

    constructor (categoryId, categoryName, categoryDescription, token) {
        this.categoryId = categoryId;
        this.categoryName = categoryName;
        this.categoryDescription = categoryDescription;
        this.token = token;
    }
    
    get name () {
        
        return this.categoryName;
    }
    
    get description () {
        
        return this.categoryDescription;
    }    
    
    deleteCategory = () => {
        
        const promise = new Promise((resolve, reject) => {            
            $.ajax({
                type: 'DELETE',            
                accept: "application/json", 
                url: "/category/delete/",
                data: { 
                    _token: this.token,
                    category_id: this.categoryId
                },                                
            }).success((msgFromPHPServer) => {
                resolve(msgFromPHPServer.success);
            }).error((xhr, ajaxOptions, thrownError) => {                
                reject(xhr, ajaxOptions, thrownError);                 
            });                       
        });
        
        return promise;    
    }    
}

export default Category;

