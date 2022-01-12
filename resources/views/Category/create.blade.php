@extends('layouts.app')

@section('content')
    <h3>{{ $page }}</h3>
    
    @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif      
    <form class="form" method="post" action="{{ route('save_category') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">nazwa</label>
            <div class="col-sm-6">
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
            </div>
        </div>  
        
        <div class="row">&nbsp;</div>          
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">opis</label>
            <div class="col-sm-6">
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
        </div> 

        <div class="row">&nbsp;</div>          
        <div class="form-group row">     
            <div class="col-sm-6">
                <button class="btn btn-success" name="btn_save_category">zapisz</button>
            </div>    
        </div> 
    </form>    
@endsection      
