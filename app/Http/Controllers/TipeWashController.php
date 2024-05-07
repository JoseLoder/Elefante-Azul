<?php

namespace App\Http\Controllers;

use App\Models\TipeWash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipeWashController extends Controller
{
    public function index()
    {
        // mostraremos todos los registros de la tabla tipe_wash
        $tipeWash = TipeWash::all();

        return view('tipe_wash.index', compact('tipeWash'));
    }

    public function create()
    {
        // mostraremos el formulario para crear un nuevo registro
        return view('tipe_wash.create');
    }

    public function store(Request $request)
    {
        // validamos los datos del formulario con el objeto Validator para tener más control sobre la validación

        $validator = Validator::make($request->all(), [
            'description' => 'required | unique:tipe_washes',
            'price' => 'required | numeric | min:0',
            'time' => 'required | numeric | min:0',
        ]);

        if ($validator->fails()) {
            // si la validación falla, devolvemos un mensaje de error
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        } else {
            // guardamos los datos en la tabla tipe_wash si la validación es correcta
            $tipeWash = new TipeWash;

            $tipeWash->description = $request->description;
            $tipeWash->price = $request->price;
            $tipeWash->time = $request->time;

            $tipeWash->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Tipe Wash created successfully',
                'data' => $tipeWash
            ]);
        }
    }
}
