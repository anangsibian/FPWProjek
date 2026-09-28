<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('halaman about dapat diakses publik', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
});

test('api endpoint v1 categories dapat diakses dan mengembalikan json', function () {
    Category::create(['name' => 'Sembako', 'description' => 'Bahan pokok']);

    $response = $this->getJson('/api/v1/categories');

    $response->assertStatus(200)
             ->assertJsonFragment(['name' => 'Sembako']);
});

test('api endpoint v1 products dapat membuat dan mengambil data produk', function () {
    $category = Category::create(['name' => 'Minuman']);

    $postData = [
        'category_id' => $category->id,
        'code' => 'MIN-001',
        'name' => 'Teh Botol Sosro',
        'price' => 5000,
        'stock' => 50,
        'unit' => 'pcs',
        'image' => 'teh-botol.jpg',
    ];

    $createResponse = $this->postJson('/api/v1/products', $postData);
    $createResponse->assertStatus(201)
                   ->assertJsonFragment(['name' => 'Teh Botol Sosro', 'formatted_price' => 'Rp 5.000']);

    $getResponse = $this->getJson('/api/v1/products');
    $getResponse->assertStatus(200)
                ->assertJsonFragment(['code' => 'MIN-001']);
});

test('rute users dilindungi otorisasi admin', function () {
    // Tanpa login -> redirect ke login
    $this->get('/users')->assertRedirect('/login');

    // Login sebagai kasir -> 403 Forbidden
    $kasir = User::create([
        'name' => 'Kasir Rina',
        'email' => 'kasir@test.com',
        'password' => 'password',
        'role' => 'kasir',
    ]);

    $this->actingAs($kasir)->get('/users')->assertStatus(403);

    // Login sebagai admin -> 200 OK
    $admin = User::create([
        'name' => 'Admin Toko',
        'email' => 'admin@test.com',
        'password' => 'password',
        'role' => 'admin',
    ]);

    $this->actingAs($admin)->get('/users')->assertStatus(200);
});

test('rute pos history dapat diakses oleh kasir dan admin', function () {
    $kasir = User::create([
        'name' => 'Kasir Rina',
        'email' => 'kasir2@test.com',
        'password' => 'password',
        'role' => 'kasir',
    ]);

    $this->actingAs($kasir)->get('/pos/history')->assertStatus(200);
});
