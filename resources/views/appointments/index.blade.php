@php
    use Carbon\Carbon;
@endphp

<x-template>
    
    <x-slot name="title">
        Citas
    </x-slot>

    <x-header/>

    <h1>Citas</h1>
    <div class="abajo">
        <table>
            <!--Creamos la cabecera de la tabla-->
            <thead>
                </tr>
                    <th>Fecha</th>
                    <th>Hora entrada</th>
                    <th>Hora salida</th>
                    <th>Modelo</th>
                    <th>Matrícula</th>
                    <th>Lavado</th>
                    <th>Precio</th>
                    <th>Contacto</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($appointments as $appointment)
                
            <tr>
                <td>{{Carbon::parse($appointment->entry)->format('d-m-Y') }}</td>
                <td>{{Carbon::parse($appointment->entry)->format('h:i A')}}</td>
                <td>{{Carbon::parse($appointment->exit)->format('h:i A')}}</td>
                <td>{{explode(" ", $appointment->car)[1]}}</td>
                <td>{{$appointment->license_plate}}</td>
                <td>
                    {{$appointment->tipe_wash}} 
                    @if ($appointment->wheels > 0)
                    <img title="Con lavado de llantas." src="https://www.juntadeandalucia.es/educacion/gestionafp/datos/tareas/DAW/DWES_42625171/2023-24/DAW_DWES_2_2023-24_Individual__650793/rueda.png" alt="Con Limpieza de llantas" width="16" height="16" style="margin: 0px; padding: 0px;">
                    @endif
                </td>
                <td>{{$appointment->price . ' €'}}</td>
                <td>
                    <span style=color:black;margin:15px title="{{"Nombre: " . $appointment->name  . ", Teléfono: " . $appointment->phone}}" class="material-symbols-outlined">
                        phone_in_talk
                    </span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    
    
    
        <a  href="{{ route('appointments.create') }}">Generar nueva cita</a>
    
    </div>
    <x-footer/>
</x-template>