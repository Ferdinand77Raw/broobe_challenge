<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoogleServiceController extends Controller
{
    public function requestGoogle(Request $request)
    {
        $url = $request->input('url');
        $category = $request->input('category');
        $strategy = $request->input('strategy');

        // Construir la URL con los parámetros
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&key=AIzaSyDCrPAzhzWxZbJxPYIEURODTvBFVVRNHbY&strategy=$strategy";
        foreach ($category as $cat) {
            $apiUrl .= "&category=$cat";
        }

        // Inicializar el cliente Guzzle
        $client = new Client();

        try {
            // Realizar la solicitud GET a la URL de la API
            $response = $client->request('GET', $apiUrl);

            // Decodificar la respuesta JSON
            $data = json_decode($response->getBody(), true);

            // Retornar los datos obtenidos de la API
        
            return response()->json($data);
        } catch (\Exception $e) {
            // Manejar errores de la solicitud
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
