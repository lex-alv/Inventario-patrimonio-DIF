<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inventario General de Bienes Muebles · SMDIF San Antonio la Isla</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
            color: #0F172A;
            margin: 15px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0F2D59;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0;
            font-size: 13px;
            color: #0F2D59;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 3px 0;
            font-size: 10.5px;
            color: #475569;
        }

        .header p {
            margin: 0;
            font-size: 8.5px;
            color: #64748B;
        }

        .meta-info {
            width: 100%;
            margin-bottom: 10px;
            font-size: 8px;
        }

        table.tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.tabla-datos th {
            background-color: #0F2D59;
            color: #fff;
            padding: 4px;
            font-size: 8px;
            text-transform: uppercase;
        }

        table.tabla-datos td {
            border: 1px solid #CBD5E1;
            padding: 4px;
        }

        .titulo-cuenta {
            background-color: #F1F5F9;
            font-weight: bold;
            font-size: 8.5px;
            color: #0F2D59;
            padding: 5px;
            border-left: 3px solid #831843;
        }

        .subtotal {
            background-color: #F8FAFC;
            font-weight: bold;
            text-align: right;
        }

        .total-box {
            margin-top: 15px;
            width: 45%;
            float: right;
            border: 1px solid #0F2D59;
            border-collapse: collapse;
        }

        .total-box td {
            padding: 6px;
            font-size: 9px;
        }

        .firmas {
            width: 100%;
            margin-top: 70px;
            text-align: center;
        }

        .firmas td {
            width: 33.33%;
            padding: 0 15px;
        }

        .linea {
            border-top: 1px solid #0F172A;
            padding-top: 4px;
            font-weight: bold;
            font-size: 8px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Sistema Municipal DIF de San Antonio la Isla</h2>
        <h3>Coordinación Administrativa · Departamento de Control Patrimonial</h3>
        <p>PADRÓN E INVENTARIO GENERAL DE BIENES MUEBLES (CONAC / OSFEM)</p>
    </div>

    <table class="meta-info">
        <tr>
            <td><strong>Fecha de corte:</strong> {{ date('d/m/Y') }}</td>
            <td align="right"><strong>Total de activos registrados:</strong> {{ $totalActivos }} bienes</td>
        </tr>
    </table>

    @foreach($cuentas as $cuenta)
        <table class="tabla-datos">
            <thead>
                <tr>
                    <th colspan="7" class="titulo-cuenta" align="left">
                        CUENTA: {{ $cuenta->codigo }} — {{ $cuenta->nombre }}
                    </th>
                </tr>
                <tr>
                    <th width="13%">No. Inventario</th>
                    <th width="31%">Descripción del Activo</th>
                    <th width="12%">Marca / Modelo</th>
                    <th width="12%">No. Serie</th>
                    <th width="14%">Área de Adscripción</th>
                    <th width="8%">Estado</th>
                    <th width="10%" align="right">Costo Histórico</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotalCuenta = 0; @endphp
                @foreach($cuenta->bienes as $bien)
                    @php $subtotalCuenta += $bien->costo_adquisicion; @endphp
                    <tr>
                        <td align="center" style="font-family: monospace;"><strong>{{ $bien->numero_inventario }}</strong></td>
                        <td>{{ $bien->descripcion }}</td>
                        <td>{{ $bien->marca ?? 'S/M' }} / {{ $bien->modelo ?? 'S/M' }}</td>
                        <td style="font-family: monospace;">{{ $bien->numero_serie ?? 'S/N' }}</td>
                        <td>{{ $bien->unidadAdministrativa->nombre }}</td>
                        <td align="center">{{ $bien->estado_conservacion }}</td>
                        <td align="right" style="font-family: monospace;">${{ number_format($bien->costo_adquisicion, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td colspan="6">Subtotal Cuenta {{ $cuenta->codigo }}:</td>
                    <td align="right" style="font-family: monospace;">${{ number_format($subtotalCuenta, 2) }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <table class="total-box">
        <tr>
            <td bgcolor="#0F2D59" style="color: white;"><strong>VALOR TOTAL DEL PATRIMONIO:</strong></td>
            <td align="right" bgcolor="#F8FAFC" style="font-family: monospace;"><strong>${{ number_format($totalGeneral, 2) }} MXN</strong></td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <table class="firmas">
        <tr>
            <td>
                <div class="linea">Elaboró<br><small>Encargado de Control Patrimonial</small></div>
            </td>
            <td>
                <div class="linea">Revisó<br><small>Coordinador(a) Administrativo(a)</small></div>
            </td>
            <td>
                <div class="linea">Autorizó<br><small>Director(a) General del SMDIF</small></div>
            </td>
        </tr>
    </table>

</body>

</html>