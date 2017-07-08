<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sender</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col text-center header"><h3 class="masthead-brand">Sender</h3></div>
    </div>
    <div class="row">
        <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="username">Username</label>
                    <input name="username" class="form-control" id="username" placeholder="Enter username" required
                           value="{{ old('username') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="password" type="password" class="form-control" id="password"
                           placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="zip">Zip file</label>
                    <input type="file" name="zip" class="form-control-file" id="zip" accept=".zip" required>
                </div>

                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col">
            <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>File name</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($history as $file)
                    <tr>
                        <td>{{ $file->name }}</td>
                        <td>{{ $file->created_at->toDateTimeString() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>