@extends('layouts.app')

@section('content')
    <h3>{{ $page }}</h3>
    nazwa {{ $item->name }}
    <br />
    opis {{ $item->description }}
@endsection      
