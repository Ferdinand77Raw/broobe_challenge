<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StrategyController;
use App\Models\Category;
use App\Models\Strategy;
use App\Models\MetricHistoryRun;

class MetricsHistoryRunController extends Controller
{
    public function showMetricsForm()
    {
        $categories = Category::all();
        $strategies = Strategy::all();
        return view('metricssearch', ['categories' => $categories, 'strategies' => $strategies, 'showMetricsSearch' => true]);
    }

    public function storeMetrics(Request $request)
{
    $request->validate([
        'url' => 'required',
        'strategy_id' => 'required',
        'categories' => 'required',
    ], [
        'url.required' => 'El campo URL es obligatorio.',
        'strategy_id.required' => 'El campo Estrategia es obligatorio.',
        'categories.required' => 'Debe seleccionar al menos una categoría.',
    ]);

    $url = $request->input('url');
    $strategy_id = $request->input('strategy_id');
    $categories = $request->input('categories');

    //Se crea un array asociativo para mapear categorías provenientes de la petición con los campos en la base de datos
    $categoryFieldMapping = [
        'Accessibility' => 'accesibility_metric',
        'Best Practices' => 'best_practices_metric',
        'Performance' => 'performance_metric',
        'SEO' => 'seo_metric',
        'PWA' => 'pwa_metric',
    ];

    $metricsHistoryRun = new MetricHistoryRun();

    // Se llenan los campos comunes con los datos recibidos del formulario
    $metricsHistoryRun->url = $url;
    $metricsHistoryRun->strategy_id = $strategy_id;

    foreach ($categories as $category => $score) {
        // Se verifica si la categoría tiene un campo correspondiente en la base de datos
        if (array_key_exists($category, $categoryFieldMapping)) {
            $field = $categoryFieldMapping[$category];
            // Aquí se asigna el puntaje al campo correspondiente
            $metricsHistoryRun->$field = $score;
        } else {
            return response()->json(['error' => 'Esta categoría no tiene un campo correspondiente: ' . $category], 400);
        }
    }

    $metricsHistoryRun->save();

    return response()->json(['message' => 'Metrics saved successfully']);
}


    public function showSavedMetrics()
    {
        $metrics = MetricHistoryRun::with('strategy')->get();
    
        return view('metricshistory', ['metrics' => $metrics, 'showMetricsSearch' => false]);
    }
}
