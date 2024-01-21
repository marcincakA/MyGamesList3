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
@php
    $listItemExists = \App\Models\ListItem::checkListItemExistance($game->game_id, auth()->user()?->getKey());
    $reviewExists = \App\Models\Review::checkReviewExistance($game->game_id, auth()->user()?->getKey());
@endphp
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
<div class="container pb-3">
    <div class="text-center" id="gameHeader">
        <!--generuje obsah z api endpointu-->
    </div>
    <div class="img-fluid text-center" id="imageDiv">
        <!--generuje obsah z api endpointu-->
    </div>
    <div class="row text-center">
        <div class="col-sm-6 text-center justify-content-center">
            <h2 class="">Genre:</h2>
            <ul class="list-group" id = "Genre_group">
                <!--generuje obsah z api endpointu-->
            </ul>
        </div>
        <div class="col-sm-6 text-center justify-content-center">
            <h2 class="">Info:</h2>
            <ul class="list-group" id="Info_list">
                <!--generuje obsah z api endpointu-->
            </ul>
        </div>
    </div>
    <div class="row" id="buttonRow">
        <div class="col-sm-4 mt-2 text-center" @if(!auth()->user() || $listItemExists) hidden="true" @endif>
            <div class="btn-group mt-2">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Add to your list
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="addToGameListDropDownButton('Finished')">Finished</a></li>
                    <li><a class="dropdown-item" href="#" onclick="addToGameListDropDownButton('Wish to play')">Wish to play</a></li>
                    <li><a class="dropdown-item" href="#" onclick="addToGameListDropDownButton('Dropped')">Dropped</a></li>
                    <li><a class="dropdown-item" href="#" onclick="addToGameListDropDownButton('Playing')">Playing</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4 mt-2 text-center" @if(!auth()->user() || $reviewExists) hidden="true" @endif>
            <div class="btn">
                <button class="btn btn-success" id="writeReviewButton" data-bs-toggle="modal" data-bs-target="#reviewModal" >Write a review</button>
            </div>
        </div>
        <div class="col-sm-4 mt-2 text-center" @if(!auth()->user() || !$listItemExists) hidden="true" @endif>
            <div class="btn">
                <button class="btn btn-danger" id="remove_button" onclick="removeFromList({{$game->game_id}}, {{auth()->user()?->user_id}})">Remove from list</button>
            </div>
        </div>
        <div class="col-sm-12" id = "about">
            <!--generuje obsah z api endpointu-->
        </div>
    </div>
</div>
<!--modal-->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Write a review</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="modal_review_form">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->game_id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()?->getKey() }}">
                    <div class="mb-3">
                        <label for="text" class="form-label">Review text</label>
                        <textarea class="form-control" id="text" name="text"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <input type="number" min="1" max="10" required class="form-control" name="rating" id="rating">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitReviewForm()">Submit</button>
            </div>
        </div>
    </div>
</div>
<!--reviews-->
<div class="container" id="reviews">
    <div class="text-start">
        <h3>Reviews:</h3>
    </div>
    <!--generovane api endpointom-->

</div>

    <!--old code just in case-->
    <div hidden="true">
        <h1 hidden="true">{{$game->name}}</h1>
    </div>
    <div hidden="true">
        <ul> {{--tu treba for loop pre kazdy nenulovy atribut--}}
            <li>Publisher: {{$game->publisher}}</li>
            <li>Developer: {{$game->developer}}</li>
            <li>{{$game->category1}}</li>
            <li>{{$game->category2}}</li>
            <li>{{$game->category3}}</li>
        </ul>
        <div>
            @if(!$listItemExists)
                <form type="hidden" action="" id="addToList">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->game_id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()?->user_id }}">
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
    <div hidden="true">
        <img src="{{$game->image}}">
    </div>
    <div hidden="true">
        {{$game->about}}
    </div>
    <div hidden="true">
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
    </div>


    <div id = "reviews">

    </div>


    <script>
        const loggedInUserId = {{ auth()->check() ? auth()->user()->getKey() : 'null' }};
        const isAdmin = {{auth()->user()?->isAdmin ?? 'null'}};
        const gameId = {{$game->game_id}};
        var reviewExistsVar = false;
        var listItemExistsVar = false;
        var reviewIdVar = null;

        fetchGame(gameId);
        fetchReviews();
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

        function submitReviewForm() {
            console.log('here');
            //var form = document.getElementById('reviewForm');
            var form = document.getElementById('modal_review_form');
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
                    form.reset();
                    fetchReviews();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function submitReviewFormEdit() {
            console.log('here');
            //var form = document.getElementById('reviewForm');
            var form = document.getElementById('modal_review_form');
            var formData = new FormData(form);
            var reviewId = parseInt(formData.get("id"));
            console.log('reviewId', reviewId);
            fetch(`http://127.0.0.1:8000/api/reviews/${reviewIdVar}`, {
                method: 'PUT',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    form.reset();
                    fetchReviews();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function renderReviewBootstrap(reviews) {
            const reviewDiv = document.getElementById('reviews');
            reviews.forEach(review => {
                const divContainer = document.createElement('div');
                divContainer.classList = "container bg-dark bg-opacity-25 mt-3 rounded-3 mb-3";

                const row1 = document.createElement('div');
                row1.classList = "row text-start";

                const col1 = document.createElement('div');
                col1.classList = "col-sm-6";

                const col2 = document.createElement('div');
                col2.classList = "col-sm-6";

                const col3 = document.createElement('div');
                col3.classList = "col-sm-12";

                const name = document.createElement('strong');
                name.textContent = "Review by: " + review.user_name;
                col1.appendChild(name);

                const rating = document.createElement('strong');
                rating.textContent = "Rating: " + review.rating;
                col2.appendChild(rating);

                const text = document.createElement('div');
                text.textContent = review.text;
                col3.appendChild(text);

                row1.appendChild(col1);
                row1.appendChild(col2);
                row1.appendChild(col3);

                const removeCol = document.createElement('div');
                removeCol.classList = "col";

                if (loggedInUserId && review.user_id === loggedInUserId || isAdmin) {
                    //delete
                    const btnDiv = document.createElement('div');
                    btnDiv.classList = "btn-group";

                    const innerDiv = document.createElement('div');
                    innerDiv.classList = "btn";
                    const innerDiv2 = document.createElement('div');
                    innerDiv2.classList = "btn";

                    const btn = document.createElement('button');
                    btn.classList = "btn btn-danger";
                    btn.textContent = "Remove";
                    btn.addEventListener('click', () => {
                        const reviewId = review.id;
                        deleteReview(reviewId);
                    });

                    const btn2 = document.createElement('a');
                    btn2.classList = "btn btn-success";
                    btn2.href = `/editReview/`+review.id;

                    btn2.textContent = "Edit";

                    innerDiv.appendChild(btn);
                    innerDiv.appendChild(btn2);
                    btnDiv.appendChild(innerDiv);
                    removeCol.appendChild(btnDiv);
                }

                row1.appendChild(removeCol);
                divContainer.appendChild(row1);
                reviewDiv.appendChild(divContainer);
            });

        }
        function setUpModalEdit(review) {
            console.log('id', review.id);
            reviewIdVar = review.id;
            const reviewId = document.getElementById('edit_reviewId');
            reviewId.value = review.id;
            const gameId = document.getElementById('edit_GameId');
            gameId.value = review.game_id;
            const userId = document.getElementById('edit_UserId');
            userId.value = review.user_id;
            const text = document.getElementById('edit_TextId');
            text.value = review.text;
            const rating = document.getElementById('edit_Rating');
            rating.value = review.rating;
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
                        //todo modal
                        alert('Edit button clicked for review ID: ' + review.id);
                    });

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    //deleteButton.id = 'deleteButton';
                    deleteButton.addEventListener('click', () => {
                        const reviewId = review.id;
                        deleteReview(reviewId);
                    });

                    reviewDiv.appendChild(editButton);
                    reviewDiv.appendChild(deleteButton);
                }

                reviewsDiv.appendChild(reviewDiv);
            });
        }

        function deleteReview(id) {
            fetch(`{{url('api/reviews') }}/`+id, {
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
                location.reload();
            })
            .catch(error => {
                console.error('Error: ', error);
            });
        }

        function addToGameListDropDownButton(status) {
            var form = document.getElementById('addToList');
            var formData = new FormData(form);
            formData.append('status', status);
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
                    //renderReviews(data.data);
                    renderReviewBootstrap(data.data);
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
        const aboutDiv = document.getElementById('about');
        aboutDiv.textContent = game.about;

    }
    </script>
</body>
</html>
