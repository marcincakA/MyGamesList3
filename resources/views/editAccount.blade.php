<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Edit</title>
</head>
<body>
<header class="bg-white">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">MyGamesList</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/viewGames">Games</a>
                    </li>
                    @if(auth()->user())
                        <li class="nav-item">
                            <a class="nav-link" href="/myList/{{auth()->user()->getKey()}}">My List</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/editAccount/{{auth()->user()->getKey()}}">Edit account</a></li>
                                <li><a class="dropdown-item" href="#">
                                        <form action="/logout" method="POST">
                                            @csrf
                                            <button>Logout</button>
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if(auth()->user()?->isAdmin)
                            <li class="nav-item">
                                <a class="nav-link" href="/add_game">Add game</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/showLogin">Log in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/showRegister">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="form-signin w-40 m-auto">
    <form class="row g-2 justify-content-center" action="/editAccount/{{$user->user_id}}" method="POST">
        @method('PUT')
        @csrf
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-auto">
                    <h1 class="h3 mb-3 fw-normal col-md-auto text-center">Create an account</h1>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="form-floating">
                        <input name="name" type="text" class="form-control" id="floatingInputName" placeholder="name" required value="{{$user->name}}">
                        <label for="floatingInputName">Name</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="form-floating">
                        <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required value="{{$user->email}}">
                        <label for="floatingInput">Email</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="form-floating">
                        <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required value="{{$user->password}}">
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="form-floating">
                        <input name="password_confirmation" type="password" class="form-control" id="floatingPasswordRepeat" placeholder="Password" required value="{{$user->password}}">
                        <label for="floatingPasswordRepeat">Password repeat</label>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()?->isAdmin)
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" id="isAdminCheckbox" name = "isAdmin" type="checkbox"  {{$user->isAdmin == 1 ? 'checked' : ''}}>
                        <label for="isAdminCheckbox" class="form-check-label">Is admin</label>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-5">
                <button class="btn btn-primary w-100 py-2" type="submit">Edit</button>
            </div>
        </div>
    </form>
        @if(auth()?->user()->user_id == $user->user_id || auth()?->user()->isAdmin) @endif
        <div class="row justify-content-center mt-2">
            <div class="col-md-5">
                <form action="/deleteAccount/{{$user->user_id}}" method="POST" onsubmit="return confirmAccDel()">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100 py-2" type="submit">Delete</button>
                </form>
            </div>
        </div>




    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</main>
    <script>
        function confirmAccDel() {
            var yesNo = confirm("Naozaj chces vymazat tento ucet?");
            return yesNo
        }
    </script>

</body>
</html>
