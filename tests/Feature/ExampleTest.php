<?php

namespace Tests\Feature;

use App\Models\ClassroomType;
use App\Models\Teacher;
use Carbon\Traits\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // use this to prevent data from adding into real data
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
