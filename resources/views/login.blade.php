<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
<main class="form-signin w-40 m-auto">
    <form class="gy-2 row" action="/login" method="POST">
        @csrf
        <div class="col-sm-12 text-center">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        </div>
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="form-floating">
                        <input name="login_name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput">Name</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="form-floating">
                        <input name="login_password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
                </div>
            </div>
        </div>

    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</main>
</body>
</html>
