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
    $scores = $request->input('scores');

    //Se crea un array asociativo para mapear categorías provenientes de la peticion con los campos en la base de datos
    $categoryFieldMapping = [
        'Performance' => 'performance_metric',
        'Accessibility' => 'accesibility_metric',
        'Best Practices' => 'best_practices_metric',
        'SEO' => 'seo_metric',
        'PWA' => 'pwa_metric',
    ];

    $metricsHistoryRun = new MetricHistoryRun();

    // Se llenan los campos comunes con los datos recibidos del formulario
    $metricsHistoryRun->url = $url;
    $metricsHistoryRun->strategy_id = $strategy_id;

    // Llenar los campos de puntajes con los datos de las categorías
    foreach ($categories as $index => $category) {
        $score = $scores[$index];
        // Se verifica si la categoría tiene un campo correspondiente en la base de datos
            if (array_key_exists($category, $categoryFieldMapping)) {
                $field = $categoryFieldMapping[$category];
                // Aquí se asigna el puntaje al campo correspondiente
                $metricsHistoryRun->$field = $score;
            } else {
            // Manejar casos donde la categoría no tiene un campo correspondiente
            // Aquí puedes registrar un mensaje de error o manejar la situación de otra manera
            // Por ejemplo, puedes omitir esta categoría o registrarla en un registro de errores
            }
    }

    $metricsHistoryRun->save();

    return response()->json(['message' => 'Metrics saved successfully']);
    
    }

    public function showSavedMetrics()
    {
         // Obtener todas las métricas guardadas
        //$metrics = MetricHistoryRun::all();
        $metrics = MetricHistoryRun::with('strategy')->get();
    
        // Pasar las métricas a la vista
        return view('metricshistory', ['metrics' => $metrics, 'showMetricsSearch' => false]);
    }
}
