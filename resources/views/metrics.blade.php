<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Metrics</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <h1>Broobe Challenge</h1>  
        <div class="container py-4 px-3 mx-auto">
        @if ($showMetricsSearch)
            @include('metrics-search')
        @else
            @include('metrics-history')
        @endif    
    </div>    
</body>