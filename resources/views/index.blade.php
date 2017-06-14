<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Uptilt Weather</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div id="app">
    <header>
        <nav>
            <div class="nav-wrapper blue">
                <form @submit.prevent="fetchLatLng()">
                    <div class="input-field">
                        <input id="search"
                               type="search"
                               v-model="location_search"
                               value="Louisville, KY"
                               required>
                        <label class="label-icon" for="search"><i class="material-icons">location_on</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </header>
    <main>
        <div class="main-content">
            <div class="weather-panel--wrapper">
                <weather-panel></weather-panel>
            </div>
            <div class="radar-panel--wrapper blue-grey lighten-2 map-column-wrapper">
                <radar-panel></radar-panel>
            </div>
        </div>
    </main>
    <footer class="page-footer blue-grey">
        <div class="footer-copyright">
            <div class="container center-align">
                <span>Crafted with &#x2764; by <a href="https://github.com/defrostedtuna" class="white-text">Rick Bennett</a></span>
            </div>
        </div>
    </footer>
</div>

<!-- Bleh -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<!-- Because I don't want to compile it again for a small application -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
<!-- Mah stuffs -->
<script src="{{ asset('js/skycons.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- Google maps after Vue stuffs -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhdIXhHMJfdvScWTa8lSYgbOJnwpQCyhc">
</script>

</body>
</html>