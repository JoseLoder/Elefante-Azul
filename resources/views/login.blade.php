<x-template>

    <x-slot name="title">
        Login
    </x-slot>

    <x-header/>

    <h1>Login</h1>

    <form action="{{ route('authenticate') }}" method="POST">
        @csrf
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" required>
        @error('name')
            <span>{{ $message }}</span>
        @enderror
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Login</button>
        <a href="{{ url()->previous() }}">Volver</a>
    </form>

</x-template>