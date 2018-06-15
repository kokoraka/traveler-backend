<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route as Route;

class RouteController extends Controller {

    public function all() {
        return ($data = Route::all()) ? $this->response(true, 200, 'Route retrieve successfully', $data) : $this->response(false, 404, 'Route not available');
    }

    public function retrieve($data) {
        $data = Route::where('id', '=', $data)->first();
        return ($data) ? $this->response(true, 200, 'Route retrieve successfully', $data) : $this->response(false, 404, 'Route not found');
    }

    public function store(Request $request) {  
        $this->validate($request, [
            'name' => 'required|string|max:190',
            'origin_id' => 'required|string|max:11|exists:regency,id',
            'destination_id' => 'required|string|max:11|exists:regency,id',
            'departure_at' => 'date',
            'return_at' => 'date',
            'transportation_id' => 'required|string|max:11|exists:transportation,id',
            'driver_id' => 'required|string|max:11|exists:employee,id',
        ]);
        $data = Route::create([
            'name' => $request->json('name'),
            'origin_id' => $request->json('origin_id'),
            'destination_id' => $request->json('destination_id'),
            'departure_at' => $request->json('departure_at'),
            'return_at' => $request->json('return_at'),
            'transportation_id' => $request->json('transportation_id'),
            'driver_id' => $request->json('driver_id'),
        ]);
        return $this->response(true, 200, 'Route successfully created', $data);
    }

    public function update(Request $request, $data) {
        $data = Route::where('id', '=', $data)->first();
        if ($data) {
            $this->validate($request, [
                'name' => 'required|string|max:190',
                'origin_id' => 'required|string|max:11|exists:regency,id',
                'destination_id' => 'required|string|max:11|exists:regency,id',
                'departure_at' => 'date',
                'return_at' => 'date',
                'transportation_id' => 'required|string|max:11|exists:transportation,id',
                'driver_id' => 'required|string|max:11|exists:employee,id',
            ]);
            $data->update([
                'name' => $request->json('name'),
                'origin_id' => $request->json('origin_id'),
                'destination_id' => $request->json('destination_id'),
                'departure_at' => $request->json('departure_at'),
                'return_at' => $request->json('return_at'),
                'transportation_id' => $request->json('transportation_id'),
                'driver_id' => $request->json('driver_id'),
            ]);
            return $this->retrieve($data->id);
        }
        return $this->response(false, 404, 'Route or data not found');
    }

    public function delete($data) {
        $data = Route::find($data);
        if ($data) {
            $data->delete();
            return $this->response(true, 200, 'Route sucessfully deleted');
        }
        return $this->response(false, 404, 'Route not found');
    }
}
