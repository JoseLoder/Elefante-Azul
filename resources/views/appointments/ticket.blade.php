@php
    use Carbon\Carbon;
@endphp

<x-template>
    
        <x-slot name="title">
            Ticket
        </x-slot>
    
        <x-header/>
    
        <h1>Ticket</h1>

        <div role="contentinfo" id='ticket'>
            <ul>
                <li>Fecha = {{ Carbon::parse($appointment->entry)->format('d-m-Y') }}</li>
                <li>Hora de entrada = {{ Carbon::parse($appointment->entry)->format('h:i A') }}</li>
                <li>Hora de salida = {{ Carbon::parse($appointment->exit)->format('h:i A') }}</li>
                <li>Nombre = {{$appointment->name}}</li>
                <li>Teléfono = {{$appointment->phone}}</li>
                <li>Coche = {{$appointment->car}}</li>
                <li>Matrícula = {{$appointment->license_plate}}</li>
                <li>Tipo de Lavado = {{$appointment->tipe_wash}}</li>
                <li>Limpieza de llantas = {{$appointment->wheels > 0 ? 'Sí' : 'No'}}</li>
                <li>Precio total = {{$appointment->price}}€</li>
            </ul>
        
            <hr>
        
            <a href="{{ route('home') }}">Volver</a>
        
        </div>

        <x-footer/>
</x-template>