<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>MyList</title>
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
                            <a class="nav-link active" href="/myList/{{auth()->user()->getKey()}}">My List</a>
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
<div class="container-fluid text-center">
    <h1>My gaming list</h1>
</div>
<div class="table-responsive-md">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Game</th>
            <th scope="col">Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="tbody">
        <!--toto generuj-->

        </tbody>
    </table>
</div>
<div id = "gameList">
    <!--generating list items here-->
</div>
</body>
<script>
    const userId = {{auth()->user()?->getKey()}};
    const isAdmin = {{auth()->user()?->isAdmin}};
    //fetch list items
    fetch(`/api/listItem/findUser/`+userId,{
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        renderTableItems(data.data);
    })
    .catch(error => {
        console.error('Error fetching list items', error);
    })
    function renderTableItems(tableItems) {
        const tbody = document.getElementById('tbody');
        tableItems.forEach(tableItem => {
            //name
            const tr = document.createElement('tr');
            const gameName = document.createElement('td');
            gameName.innerHTML =`<a href="/viewGames/${tableItem.game_id}/${tableItem.game_name}">${tableItem.game_name}</a>`;

            tr.appendChild(gameName);

            const status = document.createElement('td');
            const statusSpan = document.createElement('span')
            //status

            switch(tableItem.status) {
                case 'Finished':
                    statusSpan.classList = "badge text-bg-success";
                    statusSpan.textContent = "Finished";
                    break;
                case 'Wish to play':
                    statusSpan.classList = "badge text-bg-secondary";
                    statusSpan.textContent = "Wish to play";
                    break;
                case 'Dropped':
                    statusSpan.classList = "badge text-bg-danger";
                    statusSpan.textContent = "Dropped";
                    break;
                case 'Playing':
                    statusSpan.classList = "badge text-bg-primary";
                    statusSpan.textContent = "Playing";
                    break;
                default:
                    console.error("Cant render status", tableItem.status);
                }
                status.appendChild(statusSpan);
                tr.appendChild(status);
                //delete button
                const deleteTd = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.classList = "btn btn-danger";
                deleteButton.textContent = "Delete";
                deleteButton.addEventListener('click', function() {
                    if (confirmReq()) {
                        removeFromList(tableItem.game_id, tableItem.user_id);
                    }
                });
                deleteTd.appendChild(deleteButton);
                tr.appendChild(deleteTd);

                tbody.appendChild(tr);


        })
    }

    function confirmReq() {
        var yesNo = confirm("Naozaj chces vymazat tuto hru?");
        return yesNo;
    }

    function removeFromList(gameId, userId) {
        var form = document.getElementById('removeFromList');
        fetch(`{{url('api/listItem/delete')}}/${gameId}/${userId}`, {
            method: 'DELETE',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => response.json())
            .then(data => {
                location.reload();
                console.log('succes');
            })
            .catch(error => {
                console.error("error");
            })
    }
</script>
</html>
