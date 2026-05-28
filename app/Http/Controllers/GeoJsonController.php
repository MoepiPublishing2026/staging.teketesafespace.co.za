<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoJsonController extends Controller
{
    private const ALLOWED = [
        'map_data',
        'easterncape',
        'freestate',
        'gauteng',
        'kwazulunatal',
        'limpopo',
        'mpumalanga',
        'northerncape',
        'northwest',
        'westerncape',
    ];

    public function show(string $file)
    {
        if (!in_array($file, self::ALLOWED, true)) {
            abort(404);
        }

        $localPath = public_path("geojson/{$file}.json");
        if (is_readable($localPath)) {
            return response()->file($localPath, [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'public, max-age=604800',
            ]);
        }

        $body = Cache::remember("zadmaps_geojson_{$file}", now()->addDays(7), function () use ($file) {
            $url = "https://raw.githubusercontent.com/datawizzards/zadmaps/master/geojson/{$file}.json";
            $response = Http::timeout(25)->get($url);

            if (!$response->successful()) {
                abort(502, 'Map data could not be loaded.');
            }

            return $response->body();
        });

        return response($body, 200, [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
