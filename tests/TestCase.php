<?php

namespace Tests;

use App\Jobs\CreateTeacherJob;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function getTeacher()
    {
        return Teacher::factory()->make()->toArray();
    }
}