<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 5mm;
        }
        .header {
            text-align: center;
            margin-bottom: 5mm;
        }
        .logo {
            width: 40mm;
            height: auto;
            margin-bottom: 5px;
        }
        h1 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2mm 0;
        }
        table {
            width: 100%;
            max-width: 190mm;
            border-collapse: collapse;
            font-size: 7pt;
            margin-top: 5px;
            table-layout: fixed;
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            font-weight: bold;
            font-size: 7pt;
        }
        td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            height: 5mm;
            font-size: 6.5pt;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 22%;">Nombre</th>
                <th style="width: 18%;">Proveedor</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 12%;">Costo</th>
                <th style="width: 12%;">PVP</th>
                <th style="width: 13%;">Bs.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td style="font-size: 6pt;">{{ $producto->idProducto }}</td>
                <td style="font-size: 6pt; text-align: left; padding-left: 2px; word-wrap: break-word; overflow: hidden;">{{ Str::limit($producto->nombre, 20) }}</td>
                <td style="font-size: 6pt; text-align: left; padding-left: 2px; word-wrap: break-word; overflow: hidden;">{{ Str::limit($producto->proveedor->nombreP ?? 'N/A', 15) }}</td>
                <td style="font-size: 6pt; text-align: left; padding-left: 2px; word-wrap: break-word; overflow: hidden;">{{ Str::limit($producto->categoria->nombreC ?? 'N/A', 12) }}</td>
                <td style="font-size: 6pt;">${{ number_format($producto->costo, 2, '.', '') }}</td>
                <td style="font-size: 6pt;">${{ number_format($producto->pvp, 2, '.', '') }}</td>
                <td style="font-size: 6pt;">
                    @if($tasaDolar)
                        Bs.S{{ number_format($producto->pvp * $tasaDolar, 2, '.', '') }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

