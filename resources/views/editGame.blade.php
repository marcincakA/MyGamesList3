<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <a class="nav-link" href="/add_game">Add game</a>
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
<div style="border: 3px solid;">
    <form action="/edit_game/{{$game->game_id}}" method="POST" id = "editGameForm">
        @csrf
        @method('PUT')
        <input name = "name" type="text" placeholder="Game title" value = "{{$game->name}}" required>
        <input name = "publisher" type="text" placeholder="Publisher" value = "{{$game->publisher}}" required>
        <input name = "developer" type="text" placeholder="Developer" value = "{{$game->developer}}">
        <input name = "category1" type="text" placeholder="Category1" value = "{{$game->category1}}">
        <input name = "category2" type="text" placeholder="Category2" value = "{{$game->category2}}">
        <input name = "category3" type="text" placeholder="Category3" value = "{{$game->category3}}">
        <input name = "image" type="text" placeholder="Image" value = "{{$game->image}}">
        <textarea name="about" type="text" placeholder="nieco o hre" required>{{$game->about}}</textarea> {{--//normalne by som sa zabil za toto velke pismeno na zaciatku 20 min debugu--}}
        <button type="submit">Uprav hru</button>
    </form>
    <a href="/back">Back</a>
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
<script>
    function submitEditGameForm() {
        var form = document.getElementById('editGameForm');
        var formData = new FormData(form);
        console.log('URL:', form.action);
        console.log('Headers:', {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        });
        fetch(form.action, {
            method: 'PUT',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => response.json())
            .then(data => {
                //location.reload();
                //alert('succes');
                console.log('Game updated successfully:', data);
            })
            .catch(error => {
                // Handle error, if needed
                console.error('Error updating game:', error);
            });
    }
</script>
</html>
