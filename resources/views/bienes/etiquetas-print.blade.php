<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Etiquetas Patrimoniales QR - SMDIF San Antonio la Isla</title>
    <style>
        @page {
            size: letter portrait;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F8FAFC;
        }

        .no-print-bar {
            background: #0F2D59;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #831843;
        }

        .btn-print {
            background: #0D9488;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-back {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            margin-right: 15px;
            font-size: 13px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8mm;
            padding: 5mm;
            max-width: 216mm;
            margin: 0 auto;
        }

        .label-card {
            border: 1.5px solid #0F2D59;
            border-radius: 4px;
            padding: 6px;
            background: #fff;
            box-sizing: border-box;
            height: 48mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .label-header {
            text-align: center;
            border-bottom: 1px solid #0F2D59;
            padding-bottom: 2px;
            margin-bottom: 4px;
        }

        .label-header h6 {
            margin: 0;
            font-size: 7.5pt;
            font-weight: bold;
            color: #0F2D59;
            text-transform: uppercase;
        }

        .label-header span {
            font-size: 6pt;
            color: #64748B;
            display: block;
        }

        .label-body {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-grow: 1;
        }

        .qr-box {
            width: 26mm;
            height: 26mm;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-box svg,
        .qr-box img {
            width: 100%;
            height: 100%;
        }

        .info-box {
            font-size: 6.5pt;
            line-height: 1.2;
            color: #0F172A;
            overflow: hidden;
        }

        .info-box .inv-num {
            font-size: 7.5pt;
            font-weight: bold;
            color: #0F2D59;
            margin-bottom: 2px;
            display: block;
            font-family: monospace;
        }

        .label-footer {
            border-top: 0.5px dashed #CBD5E1;
            padding-top: 2px;
            font-size: 5.5pt;
            color: #64748B;
            text-align: center;
            text-transform: uppercase;
        }

        @media print {
            .no-print-bar {
                display: none !important;
            }

            body {
                background: #fff;
            }

            .grid-container {
                padding: 0;
                gap: 5mm;
            }

            .label-card {
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>

    <div class="no-print-bar">
        <span>Vista previa de impresión: <strong>{{ $bienes->count() }} etiquetas</strong> oficiales preparadas.</span>
        <div>
            <a href="{{ route('bienes.index') }}" class="btn-back">← Volver al Inventario</a>
            <button onclick="window.print()" class="btn-print">Imprimir Etiquetas</button>
        </div>
    </div>

    <div class="grid-container">
        @foreach($bienes as $bien)
            <div class="label-card">
                <div class="label-header">
                    <h6>SMDIF San Antonio la Isla</h6>
                    <span>Control Patrimonial · Bien Mueble</span>
                </div>
                <div class="label-body">
                    <div class="qr-box">
                        {!! QrCode::size(95)->generate($bien->numero_inventario) !!}
                    </div>
                    <div class="info-box">
                        <span class="inv-num">{{ $bien->numero_inventario }}</span>
                        <strong>Desc:</strong> {{ Str::limit($bien->descripcion, 40) }}<br>
                        <strong>Serie:</strong> {{ $bien->numero_serie ?? 'S/N' }}<br>
                        <strong>Área:</strong> {{ Str::limit($bien->unidadAdministrativa->nombre, 22) }}
                    </div>
                </div>
                <div class="label-footer">
                    Propiedad Municipal · Prohibida su Remoción
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>