@extends('layouts.app')

@section('content')
<div class="content mt-5">
    <div class="row">
        <div class="col-md-12"> 
            <h3>{{ $page }}</h3>
            <a href="{{ route('create_product') }}" class="add-new-product btn btn-success">dodaj produkt</a>
            <div id="div-products-list">
                @if (count($filtredItems) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>nazwa</th>
                                <th>kategoria</th>
                                <th>główne zdjęcie</th>
                                <th>liczba zdjęć</th>
                                <th>akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($itemsToDisplayOnPage as $key => $item)            
                            <tr>
                                <td>
                                    <a href="{{ route('product_display', ['phrase' => $item->slug]) }}">{{ $item->getName() }}</a>
                                </td>                    
                                <td>                    
                                    <a href="{{ route('category_display', ['phrase' => $item->category->slug]) }}">{{ $item->category->getName() }}</a>
                                </td>
                                <td>
                                    <img class="img-thumbnail img-fluid" src="{{ asset($item->getMainPhoto()->filepath) }}" style="max-height: 100px;">
                                </td>
                                <td>
                                    <a href="{{ route('product_photos', ['id' => $item->id]) }}">{{ count($item->photos) }}</a>     
                                </td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('edit_product', ['id' => $item->id]) }}">edytuj</a>                
                                    <button 
                                        id="btn-delete-product-{{$item->id}}"
                                        class="btn btn-danger delete btn-delete-product" 
                                        data-product-id="{{$item->id}}"
                                        data-product-name="{{$item->name}}"
                                        data-product-description="{{$item->description}}"
                                        data-product-active="{{$item->active}}"
                                        data-product-deleted="{{$item->deleted}}"
                                        data-token="{{ csrf_token() }}"
                                    >
                                        usuń
                                    </button>          
                                    <a class="btn btn-primary" href="{{ route('pdf_product', ['id' => $item->id]) }}">pdf</a>
                                </td>    
                            </tr>
                        @endforeach
                        <tbody>
                    </table>
                    @include('layouts.partials.pagination')  
                @else
                    <h4>brak produktów</h4>
                @endif    
            </div>
            @include('Product.Modals.confirm_delete_product')       
            <script src="{{URL::asset('/js/product/product.js') }}"></script>
        </div>
    </div>  
</div>    
@endsection      
