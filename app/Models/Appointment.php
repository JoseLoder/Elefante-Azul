<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry',
        'exit',
        'name',
        'phone',
        'car',
        'license_plate',
        'tipe_wash_id',
        'tipe_wash',
        'wheels',
        'price'
    ];

    public function prepareToInsert($validated, $request)
    {
        //Declaración de variables.
        $validated['price'] = 0;
        $validated['exit'] = 0;

        //comprobamos si existe llantas y le asociamos el valor parseado a entero y si no lo declaramos como 0
        // isset($validated['wheels']) ? $validated['wheels'] : $validated['wheels'] = 0;
        $validated['wheels'] = $request->has('wheels') ? $request->input('wheels') : 0;

        //Después se lo añadimos al precio y a la salida.
        $validated['price'] += intval($validated['wheels']);
        $validated['exit'] += intval($validated['wheels']);


        // Concatenar marca y modelo en una variable coche
        $validated['car'] = $validated['brand'] . ' ' . $validated['model'];

        //Obtener el tipo lavado y su descripción.
        $tipe = TipeWash::where('id', $validated['tipe_wash_id'])->first();

        // Guardamos la descripción del tipo de lavado para ahorrar consultas en el servidor cuando se imprima el ticket
        $validated['tipe_wash'] = $tipe['description'];

        // Sumar a los datos de la cita el precio y el tiempo del tipo de lavado.. y declarar $validated['exit']
        $validated['price'] = intval($validated['price']) + intval($tipe['price']);
        $validated['exit'] = intval($validated['exit']) + intval($tipe['time']);

        // Generar fecha

        // Generamos el formato
        $appointmentDate = Carbon::createFromFormat('Y-m-d', $validated['entry']);

        // Inicialmente arrancamos desde las 8 am
        $appointmentDate->hour(8)->minute(0);

        // En esta linea de código me devuelve un número en intervalos de 30 minutos hasta 540
        $randomMinutes = rand(0, 18) * 30;

        // Los sumo
        $appointmentDate->addMinutes($randomMinutes);

        // Comprobar que no se pasa de las 17 horas al haberlos sumado
        if ($appointmentDate->hour > 17) {
            $appointmentDate->hour(17)->minute(0);
        }

        // Guardamos la fecha y hora de entrada.
        $validated['entry'] = Carbon::createFromFormat('Y-m-d H:i:s', $appointmentDate->toDateString() . ' ' . $appointmentDate->toTimeString());

        // Generamos la fecha u la hora de salida partiendo de los minutos que hemos acomulado en $datos['salida']
        $validated['exit'] = Carbon::createFromFormat('Y-m-d H:i:s', $appointmentDate->toDateString() . ' ' . $appointmentDate->addMinute($validated['exit'])->toTimeString());

        return $validated;
    }

    public function tipeWash()
    {
        return $this->belongsTo(TipeWash::class);
    }
}
