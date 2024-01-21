<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>{{$game->name}}</title>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSignin">Button</button>
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
<div class="container pb-3">
    <div class="text-center" id="gameHeader">
    </div>
    <div class="img-fluid text-center" id="imageDiv">
        <img class="img-fluid rounded-3" src="" alt="">
    </div>
    <div class="row text-center">
        <div class="col-sm-6 text-center justify-content-center">
            <h2 class="">Genre:</h2>
            <ul class="list-group" id = "Genre_group">
            </ul>
        </div>
        <div class="col-sm-6 text-center justify-content-center">
            <h2 class="">Info:</h2>
            <ul class="list-group" id="Info_list">
            </ul>
        </div>
    </div>
    <div class="row" id="buttonRow">
        <div class="col-sm-6 mt-2 text-center">
            <div class="btn">
                <button class="btn btn-success">Write a review</button>
            </div>
        </div>
        <div class="col-sm-12 text-start">
            <h3>About:</h3>
        </div>
        <div class="col">
            sadfjldsjfklajfl;dsj;kfldjas;kfjsdkjfsdlk;ajflksdjf;lsadjf;ljdslkafjsdlkjfkl;sdj;
        </div>
    </div>
</div>
    <div>
        <h1>{{$game->name}}</h1>
    </div>
    <div>
        <ul> {{--tu treba for loop pre kazdy nenulovy atribut--}}
            <li>Publisher: {{$game->publisher}}</li>
            <li>Developer: {{$game->developer}}</li>
            <li>{{$game->category1}}</li>
            <li>{{$game->category2}}</li>
            <li>{{$game->category3}}</li>
        </ul>
        <div>
            @php

                $listItemExists = \App\Models\ListItem::checkListItemExistance($game->game_id, auth()->user()?->getKey());
            @endphp
            @if(!$listItemExists)
                <form action="" id="addToList">
                    @csrf
                    <input type="" name="game_id" value="{{ $game->game_id }}">
                    <input type="" name="user_id" value="{{ auth()->user()?->user_id }}">
                    <select name="status">
                        <option value="Finished">Finished</option>
                        <option value="Wish to play">Wish to play</option>
                        <option value="Dropped">Dropped</option>
                        <option value="Playing">Playing</option>
                    </select>
                    <button type="button" onclick="addToGameList()">Add to your list</button>
                </form>
            @else
                <form action="" id="removeFromList">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->game_id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()?->user_id }}">
                    <button type="button" onclick="removeFromList()">Remove</button>
                </form>
            @endif


        </div>
    </div>
    <div>
        <img src="{{$game->image}}">
    </div>
    <div>
        {{$game->about}}
    </div>
    @if(auth()->check())
        <h2>Write a review</h2>
        <form id="reviewForm" action="{{ url('api/reviews') }}" method="POST">
            @csrf
            <input type="hidden" name="game_id" value="{{ $game->game_id }}">
            <input type="hidden" name="user_id" value="{{ auth()->user()->getKey() }}">
            <input name="text" type="text" placeholder="text" required>
            <input name="rating" type="number" min="1" max="10" placeholder="rating" required>
            <button type="button" onclick="submitReviewForm()">Submit</button>
        </form>
    @endif

    <div id = "reviews">

    </div>


    <script>
        const loggedInUserId = {{ auth()->check() ? auth()->user()->getKey() : 'null' }};
        const isAdmin = {{auth()->user()?->isAdmin}};
        const gameId = {{$game->game_id}};
        var reviewExistsVar = false;
        var listItemExistsVar = false;
        fetchGame(gameId);
        checkReviewExistance(gameId,loggedInUserId);
        checkItemExistance(gameId, loggedInUserId);
        function checkReviewExistance(gameId, userId) {
            fetch(`/api/reviews/findReview/`+gameId+"/"+userId)
                .then(response => response.json())
                .then(data => {
                    reviewExistsVar = data.exists;
                    console.log(" review Exists: ",reviewExistsVar);
                    // Use listItemExists as needed
                })
                .catch(error => {
                    console.error('Error checking list item:', error);
                });
        }
        function checkItemExistance(gameId, userId) {
            fetch(`/api/listItem/find/`+gameId+"/"+userId)
                .then(response => response.json())
                .then(data => {
                    listItemExistsVar = data.exists;
                    console.log("Exists list item: ",listItemExistsVar);
                    return listItemExistsVar === true;
                    // Use listItemExists as needed
                })
                .catch(error => {
                    console.error('Error checking list item:', error);
                });
        }
        fetchReviews();
        function submitReviewForm() {
            var form = document.getElementById('reviewForm');
            var formData = new FormData(form);

            fetch('{{ url('api/reviews') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Optionally, you can handle the response here
                    // For example, you might want to show a success message
                    alert('Review submitted successfully!');
                    // You can also reset the form if needed
                    form.reset();
                    fetchReviews();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }



    function renderReviews(reviews) {
        const reviewsDiv = document.getElementById('reviews');
        reviews.forEach(review => {
            const reviewDiv = document.createElement('div');
            reviewDiv.style = "background-color: rgb(128,128,128); padding: 10px; margin: 10px;";

            const reviewBy = document.createElement('h4');
            reviewBy.textContent = `Review by: ${review.user_name}`;
            const rating = document.createElement('p');
            rating.textContent = `Rating: ${review.rating}`;

            const text = document.createElement('p');
            text.textContent = review.text;

            reviewDiv.appendChild(reviewBy);
            reviewDiv.appendChild(rating);
            reviewDiv.appendChild(text);

            if (loggedInUserId && review.user_id === loggedInUserId || isAdmin) {
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit';
                editButton.addEventListener('click', () => {
                    // Add your edit logic here
                    //todo modal
                    alert('Edit button clicked for review ID: ' + review.id);
                });

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                //deleteButton.id = 'deleteButton';
                deleteButton.addEventListener('click', () => {
                    const reviewId = review.id;
                    fetch(`{{url('api/reviews') }}/${reviewId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                        }
                    })
                    .then(response => {
                        if(!response.ok) {
                            throw new Error('Problem');
                        }
                        alert('Review deleted successfully!');
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error: ', error);
                    });
                });

                reviewDiv.appendChild(editButton);
                reviewDiv.appendChild(deleteButton);
            }

            reviewsDiv.appendChild(reviewDiv);
        });
    }

    function addToGameList() {
        var form = document.getElementById('addToList');
        var formData = new FormData(form);
        fetch('{{url('api/items')}}', {
            method: 'POST',
            body: formData,
            headers: {
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
    function fetchReviews() {
        fetch('{{ url('api/reviews/game/'.$game->game_id) }}',{
            method: 'GET',
        })
            .then(response => response.json())
            .then(data => {
                renderReviews(data.data);
            })
            .catch(error => {
                console.error('Error fetching reviews:');
            });
    }

    function fetchGame(gameId) {
        fetch('/api/games/' + gameId, {
            method: 'GET'
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                renderGame(data.data);
            })
            .catch(error => {
                console.error('Error fetching game');
            });
    }

    function renderGame(game) {
        //header
        const headerDiv = document.getElementById('gameHeader');
        const title = document.createElement('h1');
        title.textContent = game.name;
        headerDiv.appendChild(title);

        //image
        const imageDiv = document.getElementById('imageDiv');
        const image = document.createElement('img');
        image.src = game.image;
        image.alt = game.name;
        image.classList = "img-fluid rounded-3";
        imageDiv.appendChild(image);

        //list items - genre
        const genreList = document.getElementById('Genre_group');
        const li1 = document.createElement('li');
        const li2 = document.createElement('li');
        const li3 = document.createElement('li');
        li1.classList = "list-group-item";
        li1.textContent = game.category1;
        li2.classList = "list-group-item";
        li2.textContent = game.category2;
        li3.classList = "list-group-item";
        li3.textContent = game.category3;
        genreList.appendChild(li1);
        genreList.appendChild(li2);
        genreList.appendChild(li3);

        //list items - info
        const infoList = document.getElementById('Info_list');
        const li4 = document.createElement('li');
        const li5 = document.createElement('li');
        li4.classList = "list-group-item";
        li5.classList = "list-group-item";
        li4.textContent = "Publisher: " + game.publisher;
        li5.textContent = "Developer: " + game.developer;
        infoList.appendChild(li4);
        infoList.appendChild(li5);

        checkItemExistance(game.game_id, loggedInUserId);
        console.log("Exists list item sss: ",listItemExistsVar);
        /*if(checkItemExistance(game.game_id, loggedInUserId)) {
            //delete button
            const buttonRow = document.getElementById('buttonRow');
            const wrapperDiv = document.createElement('div');
            wrapperDiv.classList = "col-sm-6 mt-2 text-center";
            const innerDiv = document.createElement('div');
            innerDiv.classList = "btn";
            const delButton = document.createElement('button');
            delButton.classList = "btn btn-danger";
            delButton.textContent = "Remove from list";
            innerDiv.appendChild(delButton);
            wrapperDiv.appendChild(innerDiv);
            buttonRow.appendChild(wrapperDiv);

        }*/

    }
    </script>
</body>
</html>
