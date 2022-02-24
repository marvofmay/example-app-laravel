@extends('layouts.app')

@section('content')
    <h3>{{ $page }}</h3>
    nazwa {{ $item->name }}
    <br />
    opis {{ $item->description }}
    <br /><br />
   <a class="btn btn-primary" href="{{ route('pdf_product', ['id' => $item->id]) }}">pdf</a>    
@endsection      
