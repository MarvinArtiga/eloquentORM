# La Buena Mesa — Menu Items API

RESTful API to manage restaurant menu items for the "La Buena Mesa" project.

Requirements
- PHP 8.3+
- Composer
- PostgreSQL (running in Docker as provided by the project setup)

Installation
1. Copy environment file: `cp .env.example .env` and fill your PostgreSQL credentials.
2. Install PHP dependencies: `composer install`.
3. Generate app key: `php artisan key:generate`.

Database
- Ensure PostgreSQL is running and reachable from your host.
- Configure `.env` with: `DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Run migrations: `php artisan migrate`.
- Run seeders: `php artisan db:seed`.

Running
- Start the app (local PHP server): `php artisan serve` (or use your preferred PHP-FPM + webserver).

API Endpoints
- GET `/api/menu-items` — List all menu items.
- GET `/api/menu-items/{id}` — Get a specific menu item.
- POST `/api/menu-items` — Create a menu item. (201 on success)
- PUT `/api/menu-items/{id}` — Replace an existing menu item. (200 on success)
- PATCH `/api/menu-items/{id}` — Partially update an item. (200 on success)
- DELETE `/api/menu-items/{id}` — Delete an item. (204 on success)
- GET `/api/menu-items/category/{category}` — Filter by category.

Request examples

Create (POST /api/menu-items)
{
  "name": "Spaghetti Bolognese",
  "description": "Classic beef ragu",
  "price": 14.00,
  "category": "Pastas",
  "available": true
}

Responses
- 200: OK (GET/PUT/PATCH)
- 201: Created (POST)
- 204: No Content (DELETE)
- 404: Not Found
- 422: Unprocessable Entity (validation errors)

Notes
- The project already contains Vue; this API implementation ignores the frontend.
- Tests: run `php artisan test` (Pest is configured).
