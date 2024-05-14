<?php

namespace App\Http\Controllers;

use App\Models\TipeWash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'message' => 'Error en la validación',
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
                'message' => 'Tipo de lavado creado correctamente',
                'data' => $tipeWash
            ]);
        }
    }

    public function eliminarTipoLavado(Request $request)
    {

        $tipeWash = TipeWash::find($request->idTipeWash);
        $tipeWash->delete();

        return response()->json(['success' => true]);
    }

    public function getListado(Request $request)
    {


        //Construcción del WHERE
        $where = '';

        if (!empty($request->search['value'])) {
            $stringAdded = false;
            $where .= 'WHERE ';
            for ($i = 0; $i < count($request->columns); $i++) {

                $searchable = json_decode($request->columns[$i]['searchable']);

                if ($searchable) {
                    if ($stringAdded) {
                        $where .= ' OR ';
                    }

                    $where .= $request->columns[$i]['name'] . ' LIKE \'%' . $request->search['value'] . '%\'';
                    $stringAdded = true;
                }
            }
        }

        //Construcción del ORDER BY
        $orderBy = 'ORDER BY ' . $request->columns[$request->order[0]['column']]['name'] . ' ' . $request->order[0]['dir'];

        //Construcción de la paginación
        $paginacion = '';
        if ($request->length != -1) {
            $paginacion .= 'LIMIT ' . $request->length . ' OFFSET ' . $request->start;
        }

        //Ejecución de la consulta
        $tipeWash = DB::select('SELECT * FROM tipe_washes ' . $where . ' ' . $orderBy . ' ' . $paginacion);
        //Número de registros
        $recordsFiltered = DB::select('SELECT COUNT(id) as recordsNum FROM tipe_washes ' . $where)[0]->recordsNum;
        $recordsTotal = DB::select('SELECT COUNT(id) as recordsNum FROM tipe_washes')[0]->recordsNum;

        //Datos
        $datos = array();

        foreach ($tipeWash as $tipe) {
            $item = array();

            $item['id'] = $tipe->id;
            $item['description'] = $tipe->description;
            $item['price'] = $tipe->price;
            $item['time'] = $tipe->time;

            $datos[] = $item;
        }

        return response()->json(['draw' => $request->draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => $datos]);
    }

    public function checkDescription(Request $request)
    {
        $tipeWash = TipeWash::where('description', $request->description)->first();

        if ($tipeWash) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
}
