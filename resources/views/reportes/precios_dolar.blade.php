<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            width: 40mm;
            height: auto;
            margin-bottom: 5px;
        }
        h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 5px 0;
        }
        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 5px;
        }
        table {
            border-collapse: collapse;
            font-size: 9pt;
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }
        td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        th:first-child, td:first-child {
            width: 60mm;
        }
        th:last-child, td:last-child {
            width: 80mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Precio (Bs.)</th>
                    <th>Fecha de Actualización</th>
                </tr>
            </thead>
            <tbody>
                @foreach($precios as $precio)
                <tr>
                    <td>{{ number_format($precio->precio, 2, '.', '') }}</td>
                    <td>{{ \Carbon\Carbon::parse($precio->fecha_actualizacion)->format('d/m/Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

