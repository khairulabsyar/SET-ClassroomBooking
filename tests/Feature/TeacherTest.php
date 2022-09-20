<?php

namespace Tests\Feature;

use App\Http\Requests\AddTeacherRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ClassroomType;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TeacherTest extends TestCase
{

    // after auth implementation
    /*
     * Prepare Initialise your test with whatever like variable, seeder
     */
    public function setUp(): void
    {
        parent::setUp();

        $teacher = Teacher::factory()->create([
            'name' => 'Tester123',
            'password' => 'password123'
        ]);

        Sanctum::actingAs($teacher);

        $teacher->assignRole('Administrator');

        $teacher->givePermissionTo(['teacher:edit', 'teacher:delete']);
    }

    //another way but cannot call static
    // public function setUpBeforeClass():void
    // {
    //     parent::setUpBeforeClass();

    //     //cant do like this
    //     // $this->seed(DatabaseSeeder::class)
    // };

    /**
     * Test if we can get teacher list
     */
    public function test_get_teacher_list()
    {
        // make request
        $response = $this->getJson('api/teacher');

        // check response
        // $response->assertStatus(200)->assertJson([]);

        // based on number of data in database
        $response->assertStatus(200);
        // $response->assertStatus(200)->assertJson([])->assertJsonCount(52);
    }

    //something wrong
    public function test_can_register_teacher()
    {
        // $teacher = $this->getTeacher();

        // $teacher['name'] = 'Yau Shik Pek';

        $response = $this->postJson('api/teacher', [
            'name' => 'hello world',
            'password' => 'password'
        ]);

        // $response->assertOk();

        $this->assertDatabaseHas(Teacher::class, [
            'name' => 'hello world'
        ]);
    }

    public function test_add_teacher_validation_fail()
    {

        $response = $this->postJson('api/teacher', [
            'name' => 5000, //suppose string
            'password' => 'password2334455'
        ]);

        // validation
        $response->assertStatus(422)
            // $response->assertStatus(200)
            ->assertJson([
                'message' => 'The given data was invalid.',
                "errors" => [
                    "name" => [
                        // the string must be the same as name.string in AddTeacherRequest.php
                        "Hey, your name is Unacceptable"
                    ]
                ]
            ]);
    }

    public function test_add_teacher_password_fail()
    {
        $response = $this->postJson('api/teacher', [
            'name' => 'helloworld',
            'password' => 313123,

        ]);

        // validation
        $response->assertStatus(422)
            // $response->assertStatus(200)
            ->assertJson([
                'message' => 'The given data was invalid.',
                "errors" => [
                    "password" => [
                        // the string must be the same as password.string in AddTeacherRequest.php
                        "The password must consist of string and alpha numeric"
                    ]
                ]
            ]);
    }

    // combining both tests into 1
    public function checkInput($payload)
    {
        return FacadesValidator::make(
            $payload,
            // app()->call([AddTeacherRequest::class, 'rules'])
            (new AddTeacherRequest())->rules()
        )->stopOnFirstFailure()->passes();
    }

    public function test_all_validation()
    {
        // if the input is the same as rules in AddTeacherRequest.php, this should be correct (true)
        $this->assertEquals($this->checkInput([
            'name' => 'Waalalala',
            'password' => 'password123'
        ]), true);

        // if the input is not the same as rules in AddTeacherRequest.php, this should be falsed (false)
        $this->assertEquals($this->checkInput([
            'name' => 345678,
            'password' => ''
        ]), false);
    }

    // testing on auth route
    public function test_auth_route()
    {
        $this->getJson('api/auth')->assertStatus(200);
    }

    // testing on permission
    public function test_permission_route()
    {
        $this->getJson('api/permission-test')->assertStatus(200);
    }

    public function test_dispatch_create_teacher_job()
    {
        $this->getJson('api/execute-job')->assertStatus(200);
    }
}