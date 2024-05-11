<header>
    <nav>
        <ul>
            <li><a href='{{route('home')}}'>Home</a></li>
            <li><a href='{{route('appointments.create')}}'>Pedir cita</a></li>
            @if (Auth::check())
                <li><a href='{{route('appointments.index')}}'>Ver citas</a></li>
                <li><a href='{{route('tipe_wash.create')}}'>Crear lavado</a></li>
                <li><a href='{{route('tipe_wash.index')}}'>Listado de lavados</a></li> 
                <li><a href='{{route('logout')}}'>Logout</a></li>
            @else
                <li><a href='{{route('login')}}'>Login</a></li>
            @endif
        </ul>
    </nav>
</header>