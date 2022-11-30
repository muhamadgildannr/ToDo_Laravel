@extends('layout')
@section('content')
<div class="content">
        <div class="container reglog">
          <h1>Daftar</h1>
          
            <form method="POST" action="{{route('register.post')}}">

                @csrf
                <input type="hidden" name="tujuan" value="DAFTAR">

                <label>Username</label>
                <br>
                <input name="username" type="text">
                <br>
                <label>Nama</label>
                <br>
                <input name="name" type="text">
                <br>
                <label>Email</label>
                <br>
                <input name="email" type="email">
                <br>
                <label>Password</label>
                <br>
                <input name="password" type="password">
                <br>
                
                <button type="submit">Daftar</button>
                <p> Sudah punya akun?
                  <a href="/">Login di sini</a>
                  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
                </p>
            </form>
        </div>
        </div>
    @endsection