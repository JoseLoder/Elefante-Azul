<?php

namespace App\Http\Controllers;

use App\Models\TipeWash;
use Illuminate\Http\Request;

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
        // validamos los datos del formulario
        $request->validate([
            'description' => 'required | unique:tipe_washes',
            'price' => 'required | numeric | min:0',
            'time' => 'required | numeric | min:0',
        ]);

        // guardamos los datos en la tabla tipe_wash
        TipeWash::create($request->all());

        // redireccionamos a la vista index
        return redirect()->route('tipe_wash.index');
    }
}
