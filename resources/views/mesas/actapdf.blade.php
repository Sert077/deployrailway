<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Elección</title>
    <!-- Agrega tus enlaces a estilos, si es necesario -->
</head>

<style>
    /* Estilos CSS aquí */

    body {
        font-family: "Uni Sans" , sans-serif;
        line-height: 1.6;
        font-size: 12px;
        margin: 20px; /* Agregado un margen al contenedor */
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    h2 {
        text-align: center;
        font-size: 12px;
        margin-bottom: 10px; /* Espaciado inferior */
    }

    h3, p {
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0; /* Ajuste en el margen de las tablas */
    }

    table, th, td {
        border: 1px solid #000;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #E30613;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .container table {
        margin-bottom: 20px; /* Ajuste en el margen inferior de las tablas */
    }
</style>

<body>
    <div class="container">
        <form action="{{ isset($mesas) ? url('/mesas/' . $mesas->id) : url('/mesas') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($mesas))
                {{ method_field('PATCH') }}
            @endif

            <h2>UNIVERSIDAD MAYOR DE SAN SIMÓN</h2>
            <h2>TRIBUNAL ELECTORAL UNIVERSITARIO</h2>
            <h3>Elección a {{ $eleccion->nombre }}</h3> 
            <h2>ACTA DE APERTURA</h2>

            <p>En Cochabamba, a las {{ $eleccion->fecha }}, de conformidad con la Convocatoria y el Reglamento Electoral Universitario, se dio inicio al funcionamiento de la mesa {{ $mesa->numeromesa }}.</p>

            <!-- Acta de Apertura - Tabla de Jurados -->
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Jurado</th>
                        <th>Nombre</th>
                        <th>Firma</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurados as $jurado)
                        <tr>
                            <td>{{ $jurado->tipojurado }}</td>
                            <td>{{ "$jurado->nombre $jurado->apellidoPaterno $jurado->apellidoMaterno" }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Acta de Cierre - Tabla de Resultados de Frentes -->
            <h2>ACTA DE CIERRE</h2>

            <p>A las horas... transcurridas... horas de votación continua se procedió al cierre de la mesa {{ $mesa->numeromesa }}, efectuándose inmediatamente el escrutinio de votos, con los siguientes resultados:</p>

            <table>
                <thead>
                    <tr>
                        <th>Frente</th>
                        <th>Votos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($frentes as $frente)
                        <tr>
                            <td>{{ $frente->nombrefrente }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Votos válidos:</h3>
            <h3>Votos blancos:</h3>
            <h3>Votos nulos:</h3>
            <h3>Total de votos emitidos:</h3>

            <!-- Tabla de Jurados al final -->
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Jurado</th>
                        <th>Nombre</th>
                        <th>Firma</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurados as $jurado)
                        <tr>
                            <td>{{ $jurado->tipojurado }}</td>
                            <td>{{ "$jurado->nombre $jurado->apellidoPaterno $jurado->apellidoMaterno" }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </form>
    </div>
</body>

</html>

