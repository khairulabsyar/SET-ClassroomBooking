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

    /**
     * Test if we can get teacher list
     */
    public function test_get_teacher_list()
    {
        // make request
        $response = $this->getJson('api/teacher-list');

        // check response
        // $response->assertStatus(200)->assertJson([]);

        // based on number of data in database
        $response->assertStatus(200)->assertJson([])->assertJsonCount(50);

        $this->assertDatabaseHas(ClassroomType::class, ['id' => 2, 'type' => 'recorded']);
    }

    public function test_can_register_teacher()
    {

        // $response = $this->postJson('api/teacher-list', [
        //     'name' => "khairul absyar",
        //     'password' => "helloworld"
        // ]);

        //testing factory
        $teacher = $this->getTeacher(); // check TestCase.php

        $response = $this->postJson('api/teacher-list', $teacher);

        $response->assertOk();

        // $this->assertDatabaseHas(Teacher::class, [
        //     'name' => 'KHAIRUL ABSYAR'
        // ]);

        // testing factory
        $this->assertDatabaseHas(Teacher::class, [
            'name' => $teacher['name']
        ]);
    }
}