<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TipeWash;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listado = TipeWash::all();

        return view('appointments.create', compact('listado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $appointment = new Appointment();

        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z]+$/',
            'phone' =>  'required|regex:/^[679][0-9]{8}$/',
            'license_plate' => 'required|regex:/^[0-9]{4}[a-zA-Z]{3}$/',
            'entry' => 'required|date|after_or_equal:today',
            'brand' => 'required',
            'model' => 'required',
            'tipe_wash_id' => 'required',
        ]);


        $appointment = Appointment::create(
            $appointment->prepareToInsert($validated, $request)
        );

        return redirect()->route('appointments.show', $appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return view('appointments.ticket', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
