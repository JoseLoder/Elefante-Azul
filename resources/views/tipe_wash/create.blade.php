<x-template>
    
    <x-slot name="title">
        Crear cita
    </x-slot>

    <x-header/>

    <hgroup>
        <h1>Crear cita</h1>
        <h2>Rellena el formulario para solicitar una cita con nosotros</h2>
    </hgroup>

    {{-- 
        Eliminar las validaciones de blade y sustituirlas por las de los comentarios         
    --}}

    <form action="{{ route('tipe_wash.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- COMPROBACIONES DE jQuery
            Descripción, debe de ser
            requerido,
            string, 
            le hacemos un trim(),
            Lo añadimos al string "Lavado ",
            comprobar que no exista en la base de datos tanto en mayúscula como en minúscula
        --}}
        <label for="description">Descripción</label>
        <input type="text" name="description" value="{{ old('description') }}">
        @error('description')
        <span>{{$message}}</span>
        @enderror
    
        {{-- COMPROBACIONES DE jQuery
            Precio, debe de ser
            requerido,
            numérico,
            entero,
            ser un valor positivo
        --}}
        <label for="price">Precio</label>
        <input type="number" name="price" value="{{ old('price') }}">
        @error('price')
        <span>{{$message}}</span>
        @enderror
    
        {{-- COMPROBACIONES DE jQuery
            Tiempo, debe de ser
            requerido,
            numérico,
            entero,
            ser un valor positivo
        --}}
        <label for="time">Tiempo</label>
        <input type="number" name="time" value="{{ old('time') }}">
        @error('time')
        <span>{{$message}}</span>
        @enderror
    
        {{-- ENVIO CON AJAX
            El boton de enviar estará deshabilitado hasta que se cumplan todas las validaciones,
            en ese momento se habilitará y se podrá enviar el formulario mediante AJAX,
            si todo ha ido bien se mostrará un mensaje de éxito y se redirigirá al usuario a la página de inicio,
            si ha habido algún error se mostrará un mensaje de error y se mantendrá en la página actual
        --}}
        <button  type="submit">Crear pedido</button>
        @if (Auth::check())
            <a href="{{ route('appointments.index') }}">Ver Listado</a>
        @endif
    </form>
    <x-footer/>
</x-template>