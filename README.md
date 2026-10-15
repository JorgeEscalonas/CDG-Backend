# Casa de los Granos - Sistema Backend API

API RESTful desarrollada para la gestión de inventario y precios de la empresa Casa de los Granos. Construida sobre el framework Laravel 11, esta aplicación proporciona una interfaz robusta para la administración de productos, categorías, proveedores y el monitoreo de la tasa de cambio oficial.

## Tecnologías Utilizadas

* Framework: Laravel 11
* Lenguaje: PHP 8.2+
* Base de Datos: MySQL / MariaDB
* Autenticación: Laravel Sanctum (Tokens de Acceso Personal)
* Generación de Reportes: Barryvdh/Laravel-DomPDF

## Arquitectura y Estándares

El proyecto ha sido desarrollado bajo estándares modernos de desarrollo en Laravel:

* API Resources: Implementación de una capa de transformación para estandarizar las respuestas JSON y asegurar el tipado correcto de los datos.
* Form Requests: Validación desacoplada de los controladores para mejorar la mantenibilidad y limpieza del código.
* Migrations: Definición de la estructura de base de datos como código, permitiendo la portabilidad y versionado del esquema.
* Eloquent ORM: Gestión eficiente de relaciones entre modelos y lógica de negocio integrada (ej. cálculo automático de PVP).

## Instalación y Configuración

Siga estos pasos para desplegar el entorno de desarrollo:

1. Instalar dependencias mediante Composer:

   ```bash
   composer install
   ```

2. Configurar el archivo de entorno:

   ```bash
   cp .env.example .env
   # En Windows (CMD):
   # copy .env.example .env
   ```

3. Generar la clave única de la aplicación:

   ```bash
   php artisan key:generate
   ```

4. Configurar las credenciales de base de datos en el archivo `.env`.

5. Ejecutar las migraciones para crear la estructura de tablas:

   ```bash
   php artisan migrate
   ```

6. Iniciar el servidor local:

   ```bash
   php artisan serve
   ```

## Especificaciones de la API

### Formato de Respuestas Exitosas

Todas las respuestas exitosas siguen la siguiente estructura:

```json
{
    "success": true,
    "data": { ... },
    "message": "Operación exitosa"
}
```

### Formato de Errores de Validación (HTTP 422)

```json
{
    "success": false,
    "errors": {
        "campo": ["Descripción del error"]
    }
}
```

### Endpoints Principales

#### Autenticación

* POST /api/login - Inicio de sesión y obtención de token.
* POST /api/logout - Revocación del token actual (Protegido).
* GET /api/me - Información del usuario autenticado (Protegido).

#### Gestión de Inventario (CRUD)

* GET|POST /api/productos - Listado y creación de productos.
* GET|PUT|DELETE /api/productos/{id} - Detalle, edición y eliminación de productos.
* GET|POST /api/categorias - Listado y creación de categorías.
* GET|PUT|DELETE /api/categorias/{id} - Detalle, edición y eliminación de categorías.
* GET|POST /api/proveedores - Listado y creación de proveedores.
* GET|PUT|DELETE /api/proveedores/{id} - Detalle, edición y eliminación de proveedores.

#### Monitoreo de Divisa

* GET /api/dolar/ultimo - Obtiene la última tasa registrada.
* GET /api/dolar/historial - Listado histórico de fluctuaciones.
* POST /api/dolar - Registro manual de nueva tasa de cambio.
* GET /api/dolar/api - Consulta en tiempo real a API externa.

## Generación de Reportes

La API incluye endpoints para la generación de documentos PDF:

* /api/reportes/productos
* /api/reportes/precios-dolar

---
Servidor por defecto: <http://localhost:8000>
API Base: <http://localhost:8000/api>
