<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <title>Wally's Widgets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <body class="antialiased">
        @if ($errors->any())
            <div class="alert alert-danger m-0">
                <ul class="m-0 list-group">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger border-0">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </body>
</html>
