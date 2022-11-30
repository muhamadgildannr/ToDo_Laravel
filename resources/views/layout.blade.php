<!DOCTYPE HTML>
<html>
    <head>
        <title>Todo</title>
        <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <style>
        a.btn-outline{
            margin-left: 80%;
        }
        p{
            padding: 7px;   
        }
    
    </style>
    <body>
        @if (Auth::check())

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <h2><strong>Todo App</strong></h2>
        <p>{{Auth::user()->name}}</p><br>
        <a class="btn btn-outline-dark" type="submit" href="{{route('logout')}}">Logout</a>
</nav>
@endif
        @yield('content')
    </body>
</html>