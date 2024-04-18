<!DOCTYPE html>
<html lang="en">
    <head>
            <title>Metrics</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>
    <div class="container py-4 px-3 mx-auto">
    <h2>Metrics history</h2>
        <a href="{{ route('home') }}">Run new metrics</a>
        <table class="table">
        <thead>
        <tr>
            <th>URL</th>
            <th>Strategy ID</th>
            <th>Performance Metric</th>
            <th>Accessibility Metric</th>
            <th>Best Practices Metric</th>
            <th>SEO Metric</th>
            <th>PWA Metric</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>
            @foreach($metrics as $metric)
        <tr>
            <td>{{ $metric->url }}</td>
            <td>{{ $metric->strategy->name }}</td>
            <td>{{ empty($metric->performance_metric) ? 'No Data' : $metric->performance_metric }}</td>
            <td>{{ empty($metric->accesibility_metric) ? 'No Data' : $metric->accesibility_metric }}</td>
            <td>{{ empty($metric->best_practices_metric) ? 'No Data' : $metric->best_practices_metric }}</td>
            <td>{{ empty($metric->seo_metric) ? 'No Data' : $metric->seo_metric }}</td>
            <td>{{ empty($metric->pwa_metric) ? 'No Data' : $metric->pwa_metric }}</td>
            <td>{{ empty($metric->created_at) ? 'No Data' : $metric->created_at }}</td>
        </tr>
            @endforeach
        </tbody>
        </table>
    </div>    
</body>
</html>

