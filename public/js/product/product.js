$(document).ready((function(){console.log("product.js"),$(".delete-product").click((function(t){return t.preventDefault(),$.ajax({method:"post",url:"/product/delete_product/",data:{_token:$(this).data("token"),_method:$(this).data("method"),product_id:$(this).data("product_id")}}).done((function(t){console.log(t)})),!1}))}));