<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>AddGame</title>
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
                                <a class="nav-link active" href="/add_game">Add game</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">Log in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container-fluid text-center">
    <h1>Add game</h1>
</div>
<div class="container-sm">
    <form action="/addGame" method ="POST" class="row">
        @csrf
        <div class="form-floating mb-3 col-md-12">
            <input type="text" class="form-control" id="Name" placeholder="name" name = "name" value="{{old('name')}}">
            <label for="Name">Title</label>
        </div>
        <div class="form-floating mb-3 col-md-6">
            <input type="text" class="form-control" id="Publisher" placeholder="name" name = "publisher" value="{{old('publisher')}}">
            <label for="Publisher">Publisher</label>
        </div>
        <div class="form-floating mb-3 col-md-6">
            <input type="text" class="form-control" id="Developer" placeholder="name" name = 'developer' value="{{old('developer')}}">
            <label for="Developer">Developer</label>
        </div>
        <div class="form-floating mb-3 col-md-4">
            <input type="text" class="form-control" id="Category1" placeholder="name" name="category1" value="{{old('category1')}}">
            <label for="Category1">Category 1</label>
        </div>
        <div class="form-floating mb-3 col-md-4">
            <input type="text" class="form-control" id="Category2" placeholder="name" name="category2" value="{{old('category2')}}">
            <label for="Category2">Category 2</label>
        </div>
        <div class="form-floating mb-3 col-md-4">
            <input type="text" class="form-control" id="Category3" placeholder="name" name="category3" value="{{old('category3')}}">
            <label for="Category3">Category 3</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="Image" placeholder="name" name="image" value="{{old('image')}}">
            <label for="Image">Image link</label>
        </div>
        <div class="form-floating mb-3">
            <textarea type="text" class="form-control" id="About" placeholder="name" style="height: 10vh" name="about">{{old('about')}}</textarea>
            <label for="About">About</label>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Add game</button>
        </div>
    </form>
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
</body>
</html>
