@extends('layouts.app')

@section('content')
<div class="content mt-5">
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
    
    <div class="row">
        <h4 class="text-center">Wyślij wiadomość do administratora serwisu emailem lub smsem.</h4>
        <div class="col-md-6 offset-3">
            <form class="form" method="POST">
                @csrf
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div> 
                <div class="col-md-12 mt-2">
                    <label for="email" class="form-label">Wiadomość</label>
                    <textarea name="message" class="form-control" rows="10">{{ old('message') }}</textarea>
                </div> 
                <div class="col-md-12 mt-2">
                    <button class="btn btn-info" type="submit" formaction="/contact/sendemail" >wyślij email</button>
                    <button class="btn btn-info" type="submit" formaction="/contact/sendsms">wyślij sms</button>
                </div>    
            </form>    
        </div>    
    </div>    
</div>    
@endsection      
