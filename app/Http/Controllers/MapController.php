<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller {
    public function index() {
        $points = [
            ['name' => 'Kista', 'lat' => 59.403, 'lng' => 17.944],
            ['name' => 'Rajkot', 'lat' => 22.273, 'lng' => 70.751],
        ];
        return view('index', compact('points'));
    }
}
