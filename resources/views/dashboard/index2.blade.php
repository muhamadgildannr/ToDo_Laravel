@extends('layout')
@section('content')
 <div class="container">
          <h1>Login</h1>
          @if (Session::get('success'))
      <div class="alert alert-success w-75">
          {{ Session::get('success') }}
      </div>
      @endif
      @if (Session::get('fail'))
      <div class="alert alert-danger w-75">
        {{Session::get('fail')}}
      </div>
      @endif
      @if (Session::get('notAllowed'))
      <div class="alert alert-danger w-75">
        {{Session::get('notAllowed')}}
      </div>
      @endif
      @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          <form method="POST" action="{{route('loginauth')}}" class="reglog">
            @csrf
                <!-- tipe hidden tidak akan tampil pada website --> 
                <input name="tujuan" type="hidden" value="LOGIN" >

                <label>Username</label>
                <br>
                <input name="username" type="text">
                <br>
                <label>Password</label>
                <br>
                <input name="password" type="password">
                <br>

                <button type="submit">Log In</button>
              
                  <a href="register"><button style="background-color: red; margin-top: 10px !important;">Daftar disini</button></a>
            </form>
        </div>
 @endsection