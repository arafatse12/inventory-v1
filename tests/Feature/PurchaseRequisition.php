<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseRequisition extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase_requisition_page_running()
    {
        $user = $this->createUser([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456'
        ]);

        $response = $this->actingAs($user)
            ->get('/home/purchase-requisition');

        $response->assertStatus(200);
    }
}
