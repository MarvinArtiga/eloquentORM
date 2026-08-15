<?php

use App\Models\MenuItem;

beforeEach(function () {
    // Ensure DB is clean per RefreshDatabase
});

it('returns a list of menu items', function () {
    MenuItem::create(['name' => 'Item A', 'price' => 1.00, 'category' => 'Entradas']);
    MenuItem::create(['name' => 'Item B', 'price' => 2.00, 'category' => 'Platos principales']);

    $response = $this->getJson('/api/menu-items');

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id','name','description','price','category','available','created_at','updated_at']]]);
});

it('returns a specific menu item', function () {
    $item = MenuItem::create(['name' => 'Item C', 'price' => 3.50, 'category' => 'Pastas']);

    $this->getJson('/api/menu-items/'.$item->id)
        ->assertStatus(200)
        ->assertJsonPath('data.id', $item->id);
});

it('returns 404 for missing menu item', function () {
    $this->getJson('/api/menu-items/999999')->assertStatus(404);
});

it('creates a menu item', function () {
    $payload = ['name' => 'New Item', 'price' => 4.99, 'category' => 'Bebidas'];

    $this->postJson('/api/menu-items', $payload)
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'New Item');

    $this->assertDatabaseHas('menu_items', ['name' => 'New Item']);
});

it('returns 422 for invalid create data', function () {
    $this->postJson('/api/menu-items', ['price' => -1])->assertStatus(422);
});

it('updates a menu item with PUT', function () {
    $item = MenuItem::create(['name' => 'Old', 'price' => 5.00, 'category' => 'Entradas']);

    $this->putJson('/api/menu-items/'.$item->id, ['name' => 'Updated', 'price' => 6.00, 'category' => 'Entradas'])
        ->assertStatus(200)
        ->assertJsonPath('data.name', 'Updated');

    $this->assertDatabaseHas('menu_items', ['id' => $item->id, 'name' => 'Updated']);
});

it('partially updates a menu item with PATCH', function () {
    $item = MenuItem::create(['name' => 'Partial', 'price' => 7.00, 'category' => 'Pastas']);

    $this->patchJson('/api/menu-items/'.$item->id, ['price' => 8.50])
        ->assertStatus(200)
        ->assertJsonPath('data.price', 8.5);

    $this->assertDatabaseHas('menu_items', ['id' => $item->id, 'price' => 8.50]);
});

it('deletes a menu item', function () {
    $item = MenuItem::create(['name' => 'To Delete', 'price' => 2.50, 'category' => 'Postres']);

    $this->deleteJson('/api/menu-items/'.$item->id)->assertStatus(204);

    $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
});

it('filters items by category', function () {
    MenuItem::create(['name' => 'A', 'price' => 1.00, 'category' => 'Entradas']);
    MenuItem::create(['name' => 'B', 'price' => 2.00, 'category' => 'Bebidas']);

    $this->getJson('/api/menu-items/category/Entradas')
        ->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.category', 'Entradas');
});
