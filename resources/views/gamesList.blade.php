<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Games List</title>
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
    <!--navbarend-->
</header>
<div id="games-list">
    <!-- Games will be dynamically added here -->
</div>

<script>
    const isAdmin = {{auth()->user() ? auth()->user()->isAdmin : 'false'}};

    // Fetch games from the API endpoint
    fetch('/api/games')
        .then(response => response.json())
        .then(data => {
            // Render games on the page
            renderGames(data.data)
        })
        .catch(error => {
            console.error('Error fetching games:', error);
        });
    //New function
    // Function to render games on the page
    function renderGames(games) {
        const gamesList = document.getElementById('games-list');

        games.forEach(game => {
            const gameDiv = document.createElement('div');
            gameDiv.style = "background-color: rgb(128,128,128); padding: 10px; margin: 10px;";

            const titleLink = document.createElement('h3');
            titleLink.innerHTML = `<a href="/viewGames/${game.game_id}/${game.name}">${game.name}</a>`;
            gameDiv.appendChild(titleLink);

            const developer = document.createTextNode(game.developer);
            const publisher = document.createTextNode(game.publisher);

            gameDiv.appendChild(developer);
            gameDiv.appendChild(publisher);

            if (isAdmin) {
                const editLink = document.createElement('p');
                editLink.innerHTML = `<a href="/edit_game/${game.game_id}">Edit</a>`;
                gameDiv.appendChild(editLink);

                const deleteButton = document.createElement('button');
                deleteButton.innerText = 'DELETE';
                deleteButton.addEventListener('click', function() {
                    if (confirmReq()) {
                        submitGameDelete(`${game.game_id}`);
                    }
                });

                gameDiv.appendChild(deleteButton);
            }

            gamesList.appendChild(gameDiv);
        });
    }
    function submitGameDelete(id) {
        fetch('/api/games/' + id, {
                method: 'DELETE', // Specify the HTTP method
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    location.reload();
                    console.log('Game deleted successfully!');
                })
                .catch(error => {
                    console.error('Error deleting game:', error);
                });



    }
    // Function to confirm game deletion
    function confirmReq() {
        var yesNo = confirm("Naozaj chces vymazat tuto hru?");
        return yesNo;
    }
</script>
</body>
</html>
