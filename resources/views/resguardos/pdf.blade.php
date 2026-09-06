<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cédula de Resguardo Individual</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #003366;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            color: #003366;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 4px 0;
            font-size: 13px;
            color: #555;
        }

        .header p {
            margin: 0;
            font-size: 10px;
            color: #777;
        }

        .datos-box {
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        .datos-box td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .bg-gray {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 20%;
        }

        table.tabla-bienes {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.tabla-bienes th {
            background-color: #003366;
            color: white;
            padding: 6px;
            font-size: 10px;
            border: 1px solid #003366;
        }

        table.tabla-bienes td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 10px;
        }

        .firmas {
            width: 100%;
            margin-top: 60px;
            text-align: center;
        }

        .firmas td {
            width: 50%;
            padding: 0 30px;
        }

        .linea {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-weight: bold;
        }

        .declaratoria {
            margin-top: 20px;
            font-size: 9px;
            text-align: justify;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Sistema Municipal DIF San Antonio la Isla</h2>
        <h3>Coordinación Administrativa - Control Patrimonial</h3>
        <p>CÉDULA INDIVIDUAL DE RESGUARDO DE BIENES MUEBLES</p>
    </div>

    <table class="datos-box">
        <tr>
            <td class="bg-gray">Folio Resguardo:</td>
            <td><strong>{{ $resguardo->folio_resguardo }}</strong></td>
            <td class="bg-gray">Fecha Emisión:</td>
            <td>{{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="bg-gray">Responsable:</td>
            <td>{{ $resguardo->empleado->nombre_completo }}</td>
            <td class="bg-gray">No. Empleado:</td>
            <td>{{ $resguardo->empleado->numero_empleado }}</td>
        </tr>
        <tr>
            <td class="bg-gray">Cargo:</td>
            <td>{{ $resguardo->empleado->cargo }}</td>
            <td class="bg-gray">Área de Adscripción:</td>
            <td>{{ $resguardo->empleado->unidadAdministrativa->nombre }}</td>
        </tr>
    </table>

    <table class="tabla-bienes">
        <thead>
            <tr>
                <th width="15%">No. Inventario</th>
                <th width="35%">Descripción</th>
                <th width="15%">Marca / Modelo</th>
                <th width="15%">No. Serie</th>
                <th width="10%">Estado</th>
                <th width="10%">Valor Reg.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resguardo->detalles as $detalle)
                <tr>
                    <td align="center"><strong>{{ $detalle->bien->numero_inventario }}</strong></td>
                    <td>{{ $detalle->bien->descripcion }}</td>
                    <td>{{ $detalle->bien->marca ?? 'S/M' }} / {{ $detalle->bien->modelo ?? 'S/M' }}</td>
                    <td>{{ $detalle->bien->numero_serie ?? 'S/N' }}</td>
                    <td align="center">{{ $detalle->bien->estado_conservacion }}</td>
                    <td align="right">${{ number_format($detalle->bien->costo_adquisicion, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="declaratoria">
        Declaro recibir bajo mi custodia y resguardo los bienes muebles descritos en la presente cédula,
        comprometiéndome a destinarlos exclusivamente para las labores encomendadas a mi cargo en el Sistema Municipal
        DIF y a reportar cualquier daño, extravío o requerimiento de baja conforme a la normativa patrimonial aplicable.
    </div>

    <table class="firmas">
        <tr>
            <td>
                <div class="linea">{{ $resguardo->empleado->nombre_completo }}<br><small>Servidor Público
                        Receptor</small></div>
            </td>
            <td>
                <div class="linea">Control Patrimonial y Almacén<br><small>Entrega Conforme</small></div>
            </td>
        </tr>
    </table>

</body>

</html>