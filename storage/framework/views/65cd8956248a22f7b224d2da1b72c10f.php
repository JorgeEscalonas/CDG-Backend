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
        .columns-container {
            display: flex;
            justify-content: space-around;
            margin-top: 5px;
            gap: 5mm;
        }
        .column {
            flex: 1;
            max-width: 90mm;
        }
        table {
            width: 100%;
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
            padding: 2.75mm;
            text-align: center;
        }
        th:first-child, td:first-child {
            width: 10mm;
        }
        th:last-child, td:last-child {
            width: 80mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e($titulo); ?></h1>
    </div>

    <div class="columns-container">
        <div class="column">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($index % 2 == 0): ?>
                        <tr>
                            <td><?php echo e($proveedor->idProveedor); ?></td>
                            <td><?php echo e($proveedor->nombreP); ?></td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($index % 2 == 1): ?>
                        <tr>
                            <td><?php echo e($proveedor->idProveedor); ?></td>
                            <td><?php echo e($proveedor->nombreP); ?></td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\Casa de los granos\CDG Backend\resources\views/reportes/proveedores.blade.php ENDPATH**/ ?>