@extends('layouts.app')

@section('content')
    <h3>{{ $page }}</h3>
    <div class=row>
        <div class="col-md-6 col-of">    
            <form class="form needs-validation" method="post" action="{{ route('update_product', ['id' =>  $product->id]) }}" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <div class="form-group row">                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" value="{{ $product->id }}" />
                    <label for="name" class="col-sm-4 col-form-label">nazwa:</label>
                    <div class="col-sm-8 has-validation">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                        <div class="invalid-feedback d-block"></div>
                    </div>
                </div>          
                                
                <div class="form-group row">
                    <label for="category_id" class="col-sm-4 col-form-label">kategoria</label>
                    <div class="col-sm-8">
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="">wybierz</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ ($product->category_id == $category->id) ? 'selected="selected"' : '' }} >{{ $category->name }}</option>
                            @endforeach
                        </select>    
                        <span></span>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="category_id" class="col-sm-4 col-form-label">główne zdjęcie</label>
                    <div class="col-sm-8">
                        <img class="img-thumbnail img-fluid" src="{{ asset($product->getMainPhoto()->filepath) }}" style="max-height: 100px;">    
                    </div>    
                </div>
                
                <div class="form-group row">
                    <label for="file" class="col-sm-4 col-form-label">zmień główne zdjęcie:</label>
                    <div class="col-sm-8">
                        <input type="file" name="file" class="form-control" id="file">
                    </div>            
                </div>                  
                
                <div class="row form-group">
                    <label for="name" class="col-sm-4 col-form-label">opis:</label>
                    <div class="col-sm-8">
                        <textarea id="description" class="form-control" name="description" >{{ $product->description }}</textarea>                
                        <span></span>
                    </div>    
                </div>
                
                <div class="row form-group">
                    <div class="col-sm-8 offset-sm-4">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="deleted" name="deleted" 
                                   value="{{$product->deleted }}" 
                                   @if ($product->deleted) checked @endif
                            >
                            <label class="form-check-label" for="gridCheck1">
                                usunięta?
                            </label>
                        </div>
                    </div>
                </div>                
                
                <div class="row mb-3">
                    <div class="col-sm-8 offset-sm-4">
                        <div class="form-check">
                            <input  type="checkbox" 
                                    class="form-check-input" 
                                    id="active" name="active" 
                                    value="{{ $product->active }}"
                                    @if ($product->active) checked @endif
                            >        
                            <label class="form-check-label" for="gridCheck1">
                                aktywna?
                            </label>
                        </div>
                    </div>
                </div>                                

                <button class="btn btn-primary" name="btn_update_product">aktualizuj</button>
            </form>    
        </div>    
    </div>    
@endsection      
