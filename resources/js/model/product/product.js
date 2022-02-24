class Product {

    constructor (productId, productName, productDescription, token) {
        this.productId = productId;
        this.productName = productName;
        this.productDescription = productDescription;
        this.token = token;
    }
    
    get name () {
        
        return this.productName;
    }
    
    get description () {
        
        return this.productDescription;
    }    
    
    deleteProduct = () => {
        
        const promise = new Promise((resolve, reject) => {            
            $.ajax({
                type: 'DELETE',            
                accept: "application/json", 
                url: "/product/delete/",
                data: { 
                    _token: this.token,
                    product_id: this.productId
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

export default Product;

