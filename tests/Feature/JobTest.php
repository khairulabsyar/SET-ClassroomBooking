<?php

namespace Tests\Feature;

use App\Jobs\CreateTeacherJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JobTest extends TestCase
{
    public function test_job_run()
    {
        // fake and block actualy queue is run
        Queue::fake();

        $this->getJson('api/execute-job')
            ->assertStatus(200);

        // check job is called
        Queue::assertPushed(CreateTeacherJob::class, 1);

        // you cannot assert database added since it not run
        // $this->assertDatabaseHas(Teacher::class,['name'=> 'Ironman']);
    }
}