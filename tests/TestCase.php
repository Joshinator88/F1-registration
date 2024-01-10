<?php

namespace Tests;

use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $loggedInUser;

    protected function login(): void
    {
        $this->loggedInUser = User::factory()->create();
        $this->actingAs($this->loggedInUser);
    }

    protected function createRace(): Race
    {
        return Race::factory()->create();
    }
}
