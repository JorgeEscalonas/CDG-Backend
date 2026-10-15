# Documentación de API: HappyMarket Enterprise v1

Esta documentación detalla los endpoints disponibles para que el frontend pueda consumir los servicios del backend.

**Base URL:** `http://localhost:3000/api/v1`

---

## 🔒 Autenticación
Todos los endpoints (excepto Login y Register) requieren un Token JWT enviado en el header:
`Authorization: Bearer <TU_TOKEN>`

### 1. Registro de Usuario
**POST** `/auth/register`
- **Body:**
```json
{
  "nombre": "Juan Perez",
  "email": "juan@example.com",
  "password": "mi-password-seguro"
}
```

### 2. Inicio de Sesión
**POST** `/auth/login`
- **Body:**
```json
{
  "email": "admin@happymarket.com",
  "password": "admin123"
}
```
- **Response (200 OK):**
```json
{
  "id": 1,
  "nombre": "Admin",
  "email": "admin@happymarket.com",
  "token": "eyJhbGciOi..."
}
```

---

## 📦 Gestión de Productos
Implementa paginación, búsqueda y ordenamiento desde el servidor.

### 1. Listar Productos
**GET** `/products`
- **Query Params (Opcionales):**
  - `page`: Número de página (Default: 1)
  - `limit`: Items por página (Default: 10)
  - `sort`: Campo por el cual ordenar (Default: `id`)
  - `order`: Dirección del orden `ASC` o `DESC` (Default: `ASC`)
  - `search`: Texto para filtrar por nombre, categoría o descripción.
- **Response:**
```json
{
  "totalItems": 200,
  "totalPages": 20,
  "currentPage": 1,
  "products": [...]
}
```

### 2. Crear Producto
**POST** `/products`
- **Body:**
```json
{
  "nombre": "Manzana",
  "precio": 50.5,
  "stock": 100,
  "categoria": "Frutas",
  "descripcion": "Manzana roja fresca",
  "imagen": "url-de-la-imagen",
  "supplierId": 1
}
```

---

## 📊 Analytics & Dashboard Hub
Endpoints diseñados para alimentar los gráficos y alertas del dashboard.

### 1. Resumen de Inventario (KPIs)
**GET** `/analytics/summary`
- **Retorna:** Valor total del inventario, stock total y conteo por categorías.

### 2. Análisis ABC (Pareto)
**GET** `/analytics/abc-analysis`
- **Retorna:** Lista de productos clasificados en **A** (80% del valor), **B** (15%) y **C** (5%), útil para priorizar activos.

### 3. Alertas de Stock Bajo
**GET** `/analytics/alerts`
- **Query Params:** `threshold` (Opcional, Default: 10).
- **Retorna:** Productos cuyo stock es menor al límite de seguridad.

---

## 🕒 Auditoría (Audit Logs)
### Listar Trazabilidad
**GET** `/audit`
- **Propósito:** Ver quién modificó qué cosa y cuándo.
- **Response:** Incluye `oldValue` y `newValue` para ver el cambio exacto.

---

## 🏢 Proveedores (Suppliers)
### CRUD de Proveedores
**Endpoints:** `GET`, `POST`, `PUT`, `DELETE` en `/suppliers`
- **Body esperado:**
```json
{
  "nombre": "Proveedor Global S.A.",
  "contacto": "Maria Lopez",
  "email": "contacto@global.com",
  "telefono": "123456789",
  "direccion": "Av. Central 123",
  "categoria": "Perecederos"
}
```

---

## 💡 Tips para el Frontend (Vue/Axios)
1. **Interceptores**: Configura un interceptor en Axios para inyectar automáticamente el `token` del localStorage en cada petición.
2. **Tablas Reactivas**: Al usar el endpoint de `/products`, envía los parámetros de búsqueda y paginación directamente a la API para evitar cargar 200+ registros en el navegador.
3. **Imágenes**: Usa el campo `imagen` que retorna la API. Actualmente genera URLs de `picsum.photos` para pruebas.
