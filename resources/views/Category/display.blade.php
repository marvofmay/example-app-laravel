@extends('layouts.app')

@section('content')
    <h3>{{ $page }}</h3>
    nazwa {{ $category->name }}
    <br />
    opis {{ $category->description }}
    <br /><br />
    <a class="btn btn-primary" href="{{ route('pdf_category', ['id' => $category->id]) }}">pdf</a>
@endsection      
