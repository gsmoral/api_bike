<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

use Tests\TestCase;

use App\Models\User;
use App\Models\Bike;
use App\Models\Item;

class BikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Try to get Bikes without authorization.
     *
     * @return void
     */
    public function testSecuredEndpointRequiresAuthentication()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/bikes');

        $response->assertStatus(401);
    }

    /**
     * Try creating a bike with the IDs of the associated items.
     *
     * @return void
     */
    public function testCreateBikeWithAssociatedItems()
    {

        $user = User::factory()->create();

        // Create 5 items in the database
        $items = Item::factory()->count(5)->create();

        $itemIds = $items->pluck('id')->toArray();

        // Data of the bike to create
        $data = [
            'name' => 'Mi Bike',
            'manufacturer' => 'Fabricante',
            'description' => 'Descripción de la bike',
            'price' => 99.99,
            'item_ids' => $itemIds,
        ];

        // Send a POST request to the endpoint to create a bike
        $response = $this->actingAs($user)->postJson('/api/bikes', $data);

        // Check the response code
        $response->assertStatus(201);

        // Check the structure of the JSON response
        $response->assertJsonStructure([
            'status',
            'data' => [
                'name',
                'description',
                'price',
                'updated_at',
                'created_at',
                'id',
                'items' => [
                    '*' => [
                        'id',
                        'model',
                        'type',
                        'description',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]
        ]);

        // Verify that the bike has been created in the database
        $this->assertDatabaseHas('bikes', [
            'name' => 'Mi Bike',
            'manufacturer' => 'Fabricante',
            'description' => 'Descripción de la bike',
            'price' => 99.99,
        ]);

        // Verify that the 5 items are associated with the bike
        $bike = Bike::where('name', 'Mi Bike')->first();
        $this->assertCount(5, $bike->items);
        $this->assertEquals($items->pluck('id')->toArray(), $bike->items->pluck('id')->toArray());
    }
}
