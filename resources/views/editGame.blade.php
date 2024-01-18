<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AddGame</title>
</head>
<body>
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
