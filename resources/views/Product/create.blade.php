@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 30px;">
        <h3>{{ $page }}</h3>
    </div>    
    <div class="row" style="margin-top: 30px;">        
        @if (count($errors) > 0)
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif            
        <form class="form form-horizontal" method="post" action="{{ route('save_product') }}" enctype="multipart/form-data" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">nazwa</label>
                <div class="col-sm-6">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                    <span></span>
                </div>
            </div>   
            <div class="row">&nbsp;</div>                
            <div class="form-group row">
                <label for="category_id" class="col-sm-2 col-form-label">kategoria</label>
                <div class="col-sm-6">
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">wybierz</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{ (old('category_id') == $category->id) ? 'selected="selected"' : '' }} >{{$category->name}}</option>
                        @endforeach
                    </select>    
                    <span></span>
                </div>
            </div>   
            <div class="row">&nbsp;</div>  
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">opis</label>
                <div class="col-sm-6">
                    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                    <span></span>
                </div>
            </div> 
            <div class="row">&nbsp;</div>
            <div class="form-group row">
                <label for="file" class="col-sm-2 col-form-label">główne zdjęcie</label>
                <div class="col-sm-6">
                    <input type="file" name="file" class="form-control" id="file">
                </div>            
            </div>            
            <div class="row">&nbsp;</div>  
            <div class="form-group row">     
                <div class="col-sm-6">
                    <button class="btn btn-success" name="btn_save_product">zapisz</button>
                </div>    
            </div>    
        </form>    
    </div>    
@endsection      
