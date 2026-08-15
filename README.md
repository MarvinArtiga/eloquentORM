
# La Buena Mesa — Menu Items API

API RESTful para gestionar los elementos del menú del restaurante "La Buena Mesa".

## Requisitos

- PHP 8.3 o superior
- Composer
- PostgreSQL (el proyecto asume que PostgreSQL corre en Docker; Laravel correrá localmente)

## Instalación

1. Copia el archivo de ejemplo y edítalo con tus credenciales de PostgreSQL:

```bash
cp .env.example .env
# editar .env y completar DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

2. Instala dependencias PHP:

```bash
composer install
php artisan key:generate
```

3. Ejecuta migraciones y seeders:

```bash
php artisan migrate
php artisan db:seed
```

4. Arranca el servidor de desarrollo:

```bash
php artisan serve
# por defecto: http://127.0.0.1:8000
```

## Endpoints (API)

Todas las rutas devuelven JSON y están prefijadas con `/api` (archivo: [routes/api.php](routes/api.php)).

- GET `/api/menu-items` — Lista todos los elementos.
- GET `/api/menu-items/{id}` — Obtiene un elemento por `id`.
- POST `/api/menu-items` — Crea un elemento. Respuesta: `201 Created`.
- PUT `/api/menu-items/{id}` — Reemplaza un elemento existente. Respuesta: `200 OK`.
- PATCH `/api/menu-items/{id}` — Actualiza parcialmente un elemento. Respuesta: `200 OK`.
- DELETE `/api/menu-items/{id}` — Elimina un elemento. Respuesta: `204 No Content`.
- GET `/api/menu-items/category/{category}` — Filtra por categoría.

### Validaciones (Form Requests)

- `name`: required|string|max:255
- `description`: nullable|string
- `price`: required|numeric|min:0
- `category`: required|string|max:255
- `available`: boolean

### Ejemplos de uso (curl)

Listar todos:

```bash
curl -sS http://127.0.0.1:8000/api/menu-items
```

Obtener uno (id=1):

```bash
curl -sS http://127.0.0.1:8000/api/menu-items/1
```

Crear un elemento:

```bash
curl -sS -X POST http://127.0.0.1:8000/api/menu-items \
  -H "Content-Type: application/json" \
  -d '{"name":"Ensalada","price":8.5,"category":"Entradas","description":"Fresca"}'
```

Actualizar (PUT):

```bash
curl -sS -X PUT http://127.0.0.1:8000/api/menu-items/1 \
  -H "Content-Type: application/json" \
  -d '{"name":"Ensalada Updated","price":9.0,"category":"Entradas"}'
```

Eliminar:

```bash
curl -sS -X DELETE http://127.0.0.1:8000/api/menu-items/1
```

Filtrar por categoría:

```bash
curl -sS http://127.0.0.1:8000/api/menu-items/category/Entradas
```

### Ejemplo de respuesta (GET /api/menu-items)

```json
{
  "data": [
    {
      "id": 1,
      "name": "Bruschetta",
      "description": "Grilled bread with tomatoes and basil",
      "price": 7.5,
      "category": "Entradas",
      "available": true,
      "created_at": "2026-08-14 12:00:00",
      "updated_at": "2026-08-14 12:00:00"
    }
  ]
}
```

## Estructura principal del proyecto

- `app/Models/MenuItem.php` — Eloquent model.
- `app/Http/Controllers/MenuItemController.php` — Controlador REST.
- `app/Http/Requests/StoreMenuItemRequest.php` — Validación al crear.
- `app/Http/Requests/UpdateMenuItemRequest.php` — Validación al actualizar.
- `app/Http/Resources/MenuItemResource.php` — Transformador de respuestas JSON.
- `database/migrations/*_create_menu_items_table.php` — Migration para la tabla `menu_items`.
- `database/seeders/MenuItemSeeder.php` — Seeder inicial con categorías reales.
- `routes/api.php` — Rutas de la API.
- `tests/Feature/MenuItemTest.php` — Tests funcionales/Pest para los endpoints.

## Ejecutar tests

La suite de tests usa Pest (ya configurado). Ejecuta:

```bash
php artisan test --filter=MenuItemTest -v
```

Si las pruebas dan problemas por driver, verifica que el driver PDO correspondiente esté instalado (p.ej. `pdo_pgsql`) y que la base de datos definida en `.env` sea accesible.

## Notas

- No incluyas credenciales reales en `.env.example`. Ese archivo contiene valores de ejemplo; copia a `.env` y adapta.
- Las rutas de la API están registradas en el bootstrap del proyecto; usa `php artisan route:list --path=menu-items` para verificarlas.

