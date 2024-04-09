<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TipeWash;
use Illuminate\Support\Facades\Validator;
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
     * Respond to API request to create the form 
     */
    public function apiCreate()
    {

        $listado = TipeWash::all();

        return response()->json([
            'status' => true,
            'data' => $listado,
            'message' => null,
            'errors' => null,
            'token' => null
        ], 200);
    }

    /**
     * Respond to API request to store the form 
     */

    public function apiStore(Request $request)
    {
        $appointment = new Appointment();

        $validated = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z]+$/',
            'phone' =>  'required|regex:/^[679][0-9]{8}$/',
            'license_plate' => 'required|regex:/^[0-9]{4}[a-zA-Z]{3}$/',
            'entry' => 'required|date|after_or_equal:today',
            'brand' => 'required',
            'model' => 'required',
            'tipe_wash_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Validation error',
                'errors' => $validated->errors(),
                'token' => null
            ], 400);
        }

        $appointment = Appointment::create(
            $appointment->prepareToInsert($validated, $request)
        );

        return response()->json([
            'status' => true,
            'data' => $appointment,
            'message' => 'Appointment created successfully',
            'errors' => null,
            'token' => null
        ], 201);
    }
}
