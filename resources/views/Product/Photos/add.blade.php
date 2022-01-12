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
    
    <form class="form form-horizontal" method="post" action="{{ route('save_product_photos') }}" enctype="multipart/form-data" >
            <div class="row">&nbsp;</div>
            <div class="form-group row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <label for="file" class="col-sm-2 col-form-label">zdjęcia:</label>
                <div class="col-sm-6">
                    <input type="file" name="file[]" class="form-control" multiple id="file">
                </div>            
            </div>            
            <div class="row">&nbsp;</div>  
            <div class="form-group row">     
                <div class="col-sm-6">
                    <button class="btn btn-success" name="btn_save_product_photos">zapisz</button>
                </div>    
            </div>    
    </form>    
    
@endsection      
