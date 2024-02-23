<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        .titulo {
            text-align: center;
            font-size: 2rem;
            color: black;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
        <div class="d-flex justify-content-end">
            <img src="https://i.ibb.co/m6CBzK9/logo-basic-alert.png" alt="logo-basic-alert" border="0">
        </div>
    <div>
        <h4 class="text-center mb-5">Reporte de DNI generados</h4>
        <h5 class="text-right mb-5">Fecha de reporte : {{ $date_now }}</h5>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Número de dni</th>
                <th scope="col">Tipo de dni de mascota</th>
                <th scope="col">Nombre de la mascota</th>
                <th scope="col">Apellido de la mascota</th>
                <th scope="col">Número de celular</th>
            </tr>
            </thead>
            <tbody>
            {{ $counter = 1 }}
            @foreach($all_dni as $dni)
            <tr>
                <th scope="row">{{ $counter++ }}</th>
                <td>{{ $dni->dni_number_pet }}</td>
                <td>{{ $dni->dni_type_pet }}</td>
                <td>{{ $dni->name_pet }}</td>
                <td>{{ $dni->lastname_pet }}</td>
                <td>{{ $dni->cellphone_owner }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
