<?php


namespace Tests;
use App\Models\User;

trait ObjectFactory
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);

    }
}
