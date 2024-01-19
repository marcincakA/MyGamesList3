<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyList</title>
</head>
<body>
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
        renderListItems(data.data)
    })
    .catch(error => {
        console.error('Error fetching list items', error);
    })

    function renderListItems(listItems) {
        const gameListDiv = document.getElementById('gameList');
        listItems.forEach(listItem => {
            const listDiv = document.createElement('div');
            listDiv.style = "background-color: rgb(128,128,128); padding: 10px; margin: 10px;";

            const gameTitle = document.createElement('h3');
            gameTitle.innerHTML = `<a href="/viewGames/${listItem.game_id}/${listItem.game_name}">${listItem.game_name}</a>`;
            listDiv.appendChild(gameTitle);

            const status = document.createTextNode(listItem.status);

            listDiv.appendChild(status);

            if(isAdmin || listItem.user_id === userId) {
                const remove = document.createElement('button');
                remove.innerText = 'REMOVE';
                remove.addEventListener('click', function(){
                    if(confirmReq()) {
                        removeFromList(listItem.game_id, listItem.user_id);
                    }
                })
                //todo dories
                listDiv.appendChild(remove);
            }
            gameListDiv.appendChild(listDiv);
        })

    }
    // Function to confirm game deletion
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
