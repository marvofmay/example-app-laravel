@extends('layouts.app')

@section('content')
    <h3>{{ $page }}</h3>
    nazwa {{ $category->name }}
    <br />
    opis {{ $category->description }}
@endsection      
