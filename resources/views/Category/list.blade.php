@extends('layouts.app')

@section('content')
<div class="content mt-5">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $page }}</h3>
            <a class="btn btn-success add-new-category" href="{{ route('create_category') }}">dodaj kategorię</a>
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
                            (k: {{$offset + $loop->index + 1}})
                            </td>
                            <td>
                            <a href="{{ route('category_display', ['phrase' => $item->slug]) }}">
                                {{ $item->getName() }} 
                            </a>
                            </td>
                            <td>
                            <a href="{{ route('product_list', ['phrase' => $item->slug]) }}">({{count($item->products)}})</a>       
                            </td>
                            <td>
                            <a class="btn btn-warning" href="{{ route('edit_category', ['id' => $item->id]) }}">edytuj</a>
                            <button class="btn btn-danger delete btn-delete-category" data-category-id="{{$item->id}}" >usuń</button>
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

        <script src="{{URL::asset('/js/category/category.js') }}"></script>
        </div>
    </div>    
</div>    
@endsection      
