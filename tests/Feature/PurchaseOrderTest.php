<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase_order_page_running()
    {
        $user = $this->createUser([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456'
        ]);

        $response = $this->actingAs($user)
            ->get('/home/purchase-order');

        $response->assertStatus(200);
    }
}
