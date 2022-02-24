@extends('layouts.app')

@section('content')
<div class="content mt-5">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $page }}</h3>
            <a class="btn btn-success add-new-category" href="{{ route('create_category') }}">dodaj kategorię</a>
            <div id="div-categories-list">
                @if (count($filtredItems) > 0)
                    <table class="table table-hover">        
                        <thead>
                            <th>l.p.</th>
                            <th>nazwa</th>
                            <th>liczba produktów</th>
                            <th>akcja</th>
                        </thead>
                        <tbody>
                        @foreach ($itemsToDisplayOnPage as $key => $item)
                            <tr>
                                <td>
                                {{ $offset + $loop->index + 1 }}
                                </td>
                                <td>
                                <a href="{{ route('category_display', ['phrase' => $item->slug]) }}">
                                    {{ $item->getName() }} 
                                </a>
                                </td>
                                <td>
                                <a href="{{ route('products_by_category', ['slug' => $item->slug]) }}">({{count($item->products)}})</a>       
                                </td>
                                <td>
                                <a class="btn btn-warning" href="{{ route('edit_category', ['id' => $item->id]) }}">edytuj</a>
                                <button 
                                    id="btn-delete-category-{{$item->id}}"
                                    class="btn btn-danger delete btn-delete-category" 
                                    data-category-id="{{$item->id}}" 
                                    data-category-name="{{$item->name}}"
                                    data-category-description="{{$item->description}}"
                                    data-category-active="{{$item->active}}"
                                    data-category-deleted="{{$item->deleted}}"
                                    data-token="{{ csrf_token() }}"                                    
                                >
                                    usuń
                                </button>
                                <a class="btn btn-primary" href="{{ route('pdf_category', ['id' => $item->id]) }}">pdf</a>
                                <td>
                            </tr>
                        @endforeach        
                        </tbody>
                    </table>                
                    @include('layouts.partials.pagination')  
                @else
                    <h4>brak pozycji</h4>
                @endif                            
            </div>
            @include('Category.Modals.confirm_delete_category')       
            <script src="{{URL::asset('/js/category/category.js') }}"></script>
        </div>
    </div>    
</div>    
@endsection      
