<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_brand_page_running()
    {
        $user = $this->createUser([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456'
        ]);
        

        $response = $this->actingAs($user)
            ->get('/home/brand');

        $response->assertStatus(200);

    }
}
