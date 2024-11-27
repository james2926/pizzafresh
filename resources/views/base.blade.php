<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@3.x/css/materialdesignicons.min.css" rel="stylesheet">
    <title>Pizza Fresh</title>
</head>

<body>
    <div id="app">
        <main-component></main-component>
    </div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/all.js"></script>
    <script type="text/javascript" src="{{ url(mix('app/main.js')) }}"></script>
    <script>
   
    </script>
</body>
<style>
     .swal2-popup {
        font-size: 1.6rem !important;
        font-family: 'Roboto', sans-serif !important;
        }
</style>
</html>