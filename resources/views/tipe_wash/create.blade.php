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

    <form>
        {{-- COMPROBACIONES DE js
            Descripción, debe de ser
            requerido,
            string, 
            le hacemos un trim(),
            Lo añadimos al string "Lavado ",
            comprobar que no exista en la base de datos tanto en mayúscula como en minúscula
        --}}
        <label for="description">Descripción</label>
        <input type="text" name="description" id="description">
        <span id="errorDescription" ></span>

    
        {{-- COMPROBACIONES DE js
            Precio, debe de ser
            requerido,
            numérico,
            entero,
            ser un valor positivo
        --}}
        <label for="price">Precio</label>
        <input type="number" name="price" id="price">

        <span id="errorPrice"></span>

    
        {{-- COMPROBACIONES DE js
            Tiempo, debe de ser
            requerido,
            numérico,
            entero,
            ser un valor positivo
        --}}
        <label for="time">Tiempo</label>
        <input type="number" name="time" id="time">
        
        <span id="errorTime"></span>
        
    
        {{-- ENVIO CON AJAX
            El boton de enviar estará deshabilitado hasta que se cumplan todas las validaciones,
            en ese momento se habilitará y se podrá enviar el formulario mediante AJAX,
            si todo ha ido bien se mostrará un mensaje de éxito y se redirigirá al usuario a la página de inicio,
            si ha habido algún error se mostrará un mensaje de error y se mantendrá en la página actual
        --}}
        <button  type="submit" id="send" disabled>Crear pedido</button>
        @if (Auth::check())
            <a href="{{ route('tipe_wash.index') }}">Ver Listado</a>
        @endif
    </form>
    <x-footer/>
    <script>
        let send = [];
        let errors = [];
        let buttonSend = document.getElementById('send');

        let description = document.getElementById('description');
        let descriptionError = document.getElementById('errorDescription');

        let price = document.getElementById('price');
        let priceError = document.getElementById('errorPrice');

        let time = document.getElementById('time');
        let timeError = document.getElementById('errorTime');

        description.addEventListener('blur', () => {
            //Validación local
            let descriptionValue = description.value.trim();
            if (descriptionValue !== '') {
               if (descriptionValue.split(' ')[0].toLowerCase() !== 'lavado'){
                    descriptionValue = 'Lavado ' + descriptionValue;
                }

                descriptionValue = descriptionValue.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

                description.value = descriptionValue;
    
                send['description'] = descriptionValue;
                errors['description'] = '';
            }else {
                errors['description'] = 'El nombre no puede estar vacío';
            }

            //Validación remota
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('description', descriptionValue);

            fetch("{{ route('tipe_wash.checkDescription') }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    errors['description'] = 'El nombre de este tipo de lavado ya existe';
                    send['description'] = undefined; //De esta manera aunque me habiliten el boton de enviar modificando el html, no se enviará el formulario
                }

                validated() //por la asincronía del fetch, debo de llamar a la función de validación aquí
            })

        });

        price.addEventListener('blur', () => {
            let priceValue = price.value;
            if (priceValue !== '') {
                if (isNaN(priceValue)) {

                    errors['price'] = 'El precio debe ser un valor numérico';

                }else {

                    priceValue = parseInt(priceValue);

                    if (priceValue > 0) {
                        send['price'] = priceValue;
                        errors['price'] = '';
                    }else {
                        errors['price'] = 'El precio debe ser un valor positivo';
                    }

                }
            }else {
            errors['price'] = 'El precio no puede estar vacío';
            }

            validated()
        });

        time.addEventListener('blur', () => {
            let timeValue = time.value;
            if (timeValue !== '') {
                if (isNaN(timeValue)) {

                    errors['time'] = 'El tiempo debe ser un valor numérico';

                }else {

                    timeValue = parseInt(timeValue);

                    if (timeValue > 0) {
                        send['time'] = timeValue;
                        errors['time'] = '';
                    }else {
                        errors['time'] = 'El tiempo debe ser un valor positivo';
                    }

                }
            }else {
            errors['time'] = 'El tiempo no puede estar vacío';
            }
            validated()
        });

        const validated = () => {
            
            let noErrors = true;

            if('description' in errors && errors['description'] != ''){
                descriptionError.innerHTML = errors['description'];
                noErrors = false;
            }else {
                descriptionError.innerHTML = '';
            }

            if('price' in errors && errors['price'] != ''){
                priceError.innerHTML = errors['price'];
                noErrors = false;
            }else {
                priceError.innerHTML = '';
            }

            if('time' in errors && errors['time'] != ''){
                timeError.innerHTML = errors['time'];
                noErrors = false;
            }else {
                timeError.innerHTML = '';
            }
            
            if (noErrors && Object.keys(errors).length === 3) {
                buttonSend.disabled = false;
            } else {
                buttonSend.disabled = true;
            }
        }

        buttonSend.addEventListener('click', (e) => {
            e.preventDefault();

            //La siguiente condicional nos garantiza que no envie nada si habilitan el boton de enviar manualmente en el html (Si el archivo .js esta ofuscado)
            if (send['description'] === undefined || send['price'] === undefined || send['time'] === undefined) {
                return;
            }

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('description', send['description']);
            formData.append('price', send['price']);
            formData.append('time', send['time']);

            fetch("{{ route('tipe_wash.store') }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = "{{ route('tipe_wash.index') }}";
                }else {
                    alert(data.message);
                    if('description' in data.errors) {
                        descriptionError.innerHTML = data.errors.description[0];
                    }
                    if('price' in data.errors) {
                        priceError.innerHTML = data.errors.price[0];
                    }
                    if('time' in data.errors) {
                        timeError.innerHTML = data.errors.time[0];
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</x-template>