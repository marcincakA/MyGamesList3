<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$game->name}}</title>
</head>
<body>
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
            <form action="">
                @csrf
                <select>
                    <option value="Finnished">Finnished</option>
                    <option value="Wish to play">Wish to play</option>
                    <option value="Dropped">Dropped</option>
                    <option value="Playing">Playing</option>
                    <option value="None">None</option>
                </select>
                <button type="button" onclick="addToList()">Add to your list</button>
            </form>
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
        const isAdmin = {{auth()->user()->isAdmin}};
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
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

    fetch('{{ url('api/reviews/game/'.$game->game_id) }}',{
        method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            renderReviews(data.data);
        })
        .catch(error => {
            console.error('Error fetching reviews:')
        });

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

    function addToList(){

    }
    </script>
</body>
</html>
