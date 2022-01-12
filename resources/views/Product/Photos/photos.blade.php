@extends('layouts.app')
@section('content')
    <h3>{{ $page }}</h3>
    <a href="{{ route('product_add_photos', ['id' => $product->id]) }}">dodaj zdjęcia</a>
    @if (count($photos) > 0)
            @foreach ($photos as $key => $item)            
                <img class="img-thumbnail img-fluid" src="{{ asset($item->filepath) }}" style="max-height: 100px;">
            @endforeach
            <tbody>      
    @else
        <h4>brak zdjęć</h4>
    @endif                
@endsection      
