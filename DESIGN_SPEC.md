# Sistema de Gestión de Beneficiarios, Donaciones e Inventario

## 1. Resumen
Aplicación web para administrar beneficiarios, inventario de medicamentos y aparatos donados, y órdenes de entrada/entrega. Control de acceso por roles y permisos. Backend Laravel (PHP) con API REST; frontend React (sugerido).

## 2. Roles y permisos
- **Administrador**: CRUD usuarios, beneficiarios, inventario, órdenes.
- **Operador**: CRUD beneficiarios, inventario y órdenes.
- **Consultor**: Visualización (dashboard, listados).

Permisos definidos mediante `Gate` o `middleware` de roles.

## 3. Modelo de datos

### Tablas principales

1. `users` (Laravel default + role enum)
2. `beneficiarios`:
   - id, nombre, fecha_nacimiento, genero, direccion, telefono, email,
   - ingresos (json), gastos (json), discapacidad (json), documentos (json), fecha_registro
3. `productos`:
   - id, nombre, tipo, descripcion, stock, unidad, fecha_vencimiento, proveedor
4. `ordenes_entrada`:
   - id, fecha, proveedor, observaciones
5. `ordenes_entrada_items`:
   - id, orden_id, producto_id, cantidad, lote, fecha_vencimiento
6. `ordenes_entrega`:
   - id, fecha, beneficiario_id, observaciones
7. `ordenes_entrega_items` similar a entrada
8. `historial_movimientos` opcional para entradas/salidas

Modelo ERD sugerido (se puede generar con dbdiagram.io).

## 4. Casos de uso

1. Login/Logout.
2. Crear/editar/desactivar usuario (Admin).
3. Registrar beneficiario (Operador/Admin).
4. Gestionar productos (CRUD).
5. Registrar orden de entrada y actualizar stock.
6. Registrar orden de entrega con validación de stock.
7. Visualizar dashboard con indicadores.

## 5. Mockups
(Describir brevemente cada vista, se pueden anexar bocetos en archivo separado.)
- Login
- Dashboard: tarjetas indicadores, gráfico de género.
- Listado beneficiarios con acciones.
- Formulario beneficiario.
- Listado productos.
- Formulario producto.
- Formulario orden entrada/entrega.
- Gestión usuarios.

## 6. Especificación de API

| Método | Ruta | Descripción | Roles | Ejemplo Request | Ejemplo Response |
|--------|------|-------------|-------|-----------------|------------------|
| POST | /api/login | Autenticación | public | `{email,password}` | `{token}` |
| GET | /api/beneficiarios | Listar | admin,op,consult | | `[{...}]` |
| POST | /api/beneficiarios | Crear | admin,op | {...} | {...} |
| PUT | /api/beneficiarios/{id} | Actualizar | admin,op | {...} | {...} |
| DELETE| /api/beneficiarios/{id} | Eliminar | admin,op | | `{message}` |
| ... | ... | ... | ... | ... | ... |

(Definir endpoints similares para productos, órdenes, usuarios.)

Indicaciones: proteger con middleware `auth:api` y verificar roles.

## 7. Configuración inicial

- Seeders:
  - Roles: admin, operador, consultor.
  - Usuarios de prueba con contraseñas.

## 8. Tecnología y seguridad

- Laravel 10, Sanctum o Passport para JWT.
- Validación request con FormRequests.
- Hash passwords.
- Uso de Eloquent ORM.
- Frontend React con axios hacia API.

---

Esta documentación sirve de base para que un equipo de desarrollo implemente la solución. Continúa adaptando según requisitos adicionales.
