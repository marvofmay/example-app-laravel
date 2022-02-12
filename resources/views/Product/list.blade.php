@extends('layouts.app')
@section('content')
    <h3>{{ $page }}</h3>
    <a href="{{ route('create_product') }}" class="add-new-product btn btn-success">dodaj produkt</a>
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
                        <a href="{{ route('product_display', ['phrase' => $item->slug]) }}">
                        {{ $item->getName() }}                    
                        </a>({{ $item->category->name }})
                    </td>                    
                    <td>                    
                        <a href="{{ route('category_list', ['phrase' => $item->category->slug]) }}">{{ $item->category->name }}</a>   
                    </td>
                    <td>
                        <img class="img-thumbnail img-fluid" src="{{ asset($item->getMainPhoto()->filepath) }}" style="max-height: 100px;">
                    </td>
                    <td>
                        <a href="{{ route('product_photos', ['id' => $item->id]) }}">{{ count($item->photos) }}</a>     
                    </td>
                    <td>
                        <a href="{{ route('edit_product', ['id' => $item->id]) }}">edytuj</a>                
                        <a href="#" class="delete delete-product"                    
                           data-token="{{ csrf_token() }}"
                           data-method="delete"
                           data-product_id="{{ $item->id }}" >
                           usuń 
                        </a>                
                    </td>    
                </tr>
            @endforeach
            <tbody>
        </table>
        @include('layouts.partials.pagination')  
    @else
        <h4>brak produktów</h4>
    @endif    
    @include('Product.Modals.confirm_delete_product')       
    <script src="{{URL::asset('/js/product/product.js') }}"></script>
@endsection      
