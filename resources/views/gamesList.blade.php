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
    <!--navbarend-->
</header>
<div class="container-fluid text-center">
    <h1>Games</h1>
</div>
<div id="games-list">
    <!-- Games will be dynamically added here -->
</div>

<script>
    const isAdmin = {{auth()->user() ? auth()->user()->isAdmin : 'false'}};

    // Fetch games
    fetch('/api/games')
        .then(response => response.json())
        .then(data => {
            // Render games
            RenderGamesBootstrap(data.data);
        })
        .catch(error => {
            console.error('Error fetching games:', error);
        });
    function RenderGamesBootstrap(games) {
        const gamesList = document.getElementById('games-list');
        games.forEach(game => {
            const containerDiv = document.createElement('div');
            containerDiv.classList = "container-sm bg-dark bg-opacity-25 mt-2 rounded 3";
            //row 1
            const row1 = document.createElement('div');
            const row1col1 = document.createElement('div');
            row1col1.classList = "col-sm-12  gy-2 justify-content-center";
            const h2 = document.createElement('h2');
            const link = document.createElement('a');
            link.classList = "link-dark link-underline-opacity-0";
            link.href = "/viewGames/"+ game.game_id +"/" + game.name;
            link.textContent = game.name;
            h2.appendChild(link);
            row1col1.appendChild(h2);
            row1.appendChild(row1col1);
            containerDiv.appendChild(row1);
            //row 2
            const row2 = document.createElement('div');
            row2.classList = "row";
            const row2col1 = document.createElement('col');
            const row2col2 = document.createElement('col');
            row2col1.classList = "col-sm-6";
            row2col2.classList = "col-sm-6";
            row2col1.innerHTML = "<strong>Developer:</strong>" + game.developer;
            row2col2.innerHTML = "<strong>Publisher:</strong>" + game.publisher;
            row2.appendChild(row2col1);
            row2.appendChild(row2col2);
            containerDiv.appendChild(row2);
            //row 3
            const row3 = document.createElement('div');
            row3.classList = "row";
            const row3col1 = document.createElement('div');
            const row3col2 = document.createElement('div');
            const row3col3 = document.createElement('div');
            row3col1.classList = "col-sm-4";
            row3col2.classList = "col-sm-4";
            row3col3.classList = "col-sm-4";
            row3col1.textContent = game.category1;
            row3col2.textContent = game.category2;
            row3col3.textContent = game.category3;
            row3.appendChild(row3col1);
            row3.appendChild(row3col2);
            row3.appendChild(row3col3);
            containerDiv.appendChild(row3);
            //admin Row
            if(isAdmin) {
                const row4 = document.createElement('div');
                row4.classList = "row pb-2";
                const row4col1 = document.createElement('div');
                row4col1.classList = "col-sm-6 pt-1 pb-1";
                const editButton = document.createElement('button');
                editButton.classList = "btn btn-success";
                editButton.textContent = "Edit";
                editButton.onclick = function () {
                    window.location.href = "/edit_game/"+game.game_id;
                }
                const row4col2 = document.createElement('div');
                row4col2.classList = "col-sm-6 pt-1 pb-1";
                const deleteButton = document.createElement('button');
                deleteButton.classList = "btn btn-danger";
                deleteButton.textContent = "Delete";
                deleteButton.addEventListener('click', function() {
                    if (confirmReq()) {
                        submitGameDelete(`${game.game_id}`);
                    }
                });
                row4col1.appendChild(editButton);
                row4col2.appendChild(deleteButton);
                row4.appendChild(row4col1);
                row4.appendChild(row4col2);
                containerDiv.appendChild(row4);
            }
            gamesList.appendChild(containerDiv);
        })
    }
    // Function to render games on the page

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
