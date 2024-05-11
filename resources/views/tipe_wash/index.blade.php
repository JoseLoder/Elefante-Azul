<x-templateJQuery>
    
    <x-slot name="title">
        Crear cita
    </x-slot>
    
    <x-slot name='script'>

        <script>

            $(document).ready(function () {
                var table = $('#listaLavados').DataTable({ // Inicializar la tabla
                    "paging": true, // Activar la paginación
                    "pagingType": "numbers", // Tipo de paginación
                    "lengthChange": true, // Activar el cambio de cantidad de registros por página
                    "lengthMenu": [[5, 10, -1], [5, 10, 'Todos']], // Cantidad de registros por página
                    "order": [[ 1, "asc" ]], // Ordenar por la columna 1
                    "processing": true, // Activar el procesamiento de la tabla (para mostrar el indicador de carga)
                    "serverSide": true, // Activar el procesamiento del lado del servidor (para optimizar la carga de grandes cantidades de datos)
                    "ajax": { // Configuración de la petición AJAX
                        "url": "{{ route('tipe_wash.getListado') }}", // URL de la petición
                        "type": "POST", // Tipo de petición
                        "data": {"_token": "{{ csrf_token() }}"} // Datos a enviar
                    },
                    "columns": [
                        {
                            data: 'id', // Nombre del campo en el objeto JSON
                            name: 'id', // Nombre del campo en la base de datos
                            orderable: false, // No permitir ordenar por esta columna
                            searchable: false, // No permitir buscar por esta columna
                            visible: false // No mostrar la columna en la tabla
                        }
                        ,{
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'time',
                            name: 'time'
                        },
                        {
                            data: null, // Nombre del campo en el objeto JSON
                            name: 'eliminar', // Nombre del campo en la base de datos
                            orderable: false, // No permitir ordenar por esta columna
                            searchable: false, // No permitir buscar por esta columna
                            render: function(data, type, row, meta) { // Función para personalizar la visualización de los datos                    
                                return '<input type="button" data-row="'+ meta.row +'" value="Eliminar" />' // Mostrar un botón
                            },
                        }
                        
                    ],
                    language: { // Configuración del idioma de la tabla
                        "decimal":        ",",
                        "emptyTable":     "No hay datos en la tabla",
                        "info":           "Monstrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "infoEmpty":      "",
                        "infoFiltered":   "",
                        "infoPostFix":    "",
                        "thousands":      ".",
                        "lengthMenu":     "Mostrar _MENU_ registros",
                        "loadingRecords": "Cargando...",
                        "processing":     "Procesando...",
                        "search":         "Buscar:",
                        "zeroRecords":    "No han encontrado registros",
                        "paginate": {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        "aria": {
                            "sortAscending":  ": Click/return para ordenar ascendentemente",
                            "sortDescending": ": Click/return para ordenar descendentemente"
                        }
                    }

                })

                $('#listaLavados tbody').on( 'click', 'tr input[value="Eliminar"]', function () {
                    var confirmacion = window.confirm('Va a eliminar este usuario. ¿Desea continuar?')
                        
                    var dataRow=$(this).attr('data-row')
                    var row = table.data()[dataRow];

                    if(confirmacion) {
                        $.ajax({
                            url: "{{ route('tipe_wash.eliminarTipoLavado') }}",
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                idTipeWash: row.id
                            },
                            success: function(response){
                                table.ajax.reload();
                            },
                            error: function (response) {
                                console.error("Error", response);
                                window.alert("Ha ocurrido un problema en el servidor.");
                            }
                        });
                    }  
                });

            });

        </script>

    </x-slot>

    <x-header/>

    <hgroup>
        <h1>Crear cita</h1>
        <h2>Rellena el formulario para solicitar una cita con nosotros</h2>
    </hgroup>

    <table id="listaLavados">
        <thead>
            <tr>
                <th>id</th>
                <th>description</th>
                <th>price</th>
                <th>time</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        <tbody>        
    </table>

    <x-footer/>
</x-templateJQuery>