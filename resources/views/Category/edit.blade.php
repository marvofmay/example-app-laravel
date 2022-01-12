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
    
    <div class=row>
        <div class="col-md-6 col-of">    
            <form class="form needs-validation" method="post" action="{{ route('update_category', ['id' => $data->id]) }}">
                {{ method_field('PUT') }}
                <div class="row mb-3">                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" value="{{ $data->id }}" />
                    <label for="name" class="col-sm-2 col-form-label">nazwa:</label>
                    <div class="col-sm-10 has-validation">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                    </div>
                </div>                                                                
                
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">opis:</label>
                    <div class="col-sm-10">
                        <textarea id="description" class="form-control" name="description" >{{ $data->description }}</textarea>                
                    </div>    
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="deleted" name="deleted" 
                                   value="{{ $data->deleted }}" 
                                   @if ($data->deleted) checked @endif
                            >
                            <label class="form-check-label" for="gridCheck1">
                                usunięta?
                            </label>
                        </div>
                    </div>
                </div>                
                
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="form-check">
                            <input  type="checkbox" 
                                    class="form-check-input" 
                                    id="active" name="active" 
                                    value="{{ $data->active }}"
                                    @if ($data->active) checked @endif
                            >        
                            <label class="form-check-label" for="gridCheck1">
                                aktywna?
                            </label>
                        </div>
                    </div>
                </div>                                

                <button class="btn btn-primary" name="btn_update_category">aktualizuj</button>
            </form>    
        </div>    
    </div>    
@endsection      
