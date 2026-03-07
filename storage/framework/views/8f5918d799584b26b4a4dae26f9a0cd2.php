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
            width: 15mm;
        }
        th:last-child, td:last-child {
            width: 90mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e($titulo); ?></h1>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($categoria->idCategoria); ?></td>
                    <td><?php echo e($categoria->nombreC); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\Casa de los granos\CDG Backend\resources\views/reportes/categorias.blade.php ENDPATH**/ ?>