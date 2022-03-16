@extends('layouts.app')

@section('content')
    <h3>STRONA GŁÓWNA</h3>
    @if (Auth::user())
        Auth::user()->name
    @endif
    
    @if (Auth::check())
        @if (Auth::user()->hasRole('moderator')) Witaj moderator @endif
        @if (Auth::user()->hasRole('admin')) Witaj admin @endif         
    @endif
@endsection      
