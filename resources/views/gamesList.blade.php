<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Games List</title>
</head>
<body>

<div id="games-list">
    <!-- Games will be dynamically added here -->
</div>

<script>
    const isAdmin = {{auth()->user()->isAdmin}};
    // Fetch games from the API endpoint
    fetch('/api/games')
        .then(response => response.json())
        .then(data => {
            // Render games on the page
            renderGames(data.data);
        })
        .catch(error => {
            console.error('Error fetching games:', error);
        });

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
