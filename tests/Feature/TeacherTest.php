<?php

namespace Tests\Feature\Teacher;

use App\Http\Requests\AddTeacherRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ClassroomType;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use DatabaseTransactions;
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
        $response->assertStatus(200)->assertJson([])->assertJsonCount(50);

        $this->assertDatabaseHas(ClassroomType::class, ['id' => 2, 'type' => 'recorded']);
    }

    //something wrong
    // public function test_can_register_teacher()
    // {
    //     // $response = $this->postJson('api/teacher-list', [
    //     //     'name' => "khairul absyar",
    //     //     'password' => "helloworld"
    //     // ]);

    //     //testing factory
    //     $teacher = $this->getTeacher(); // check TestCase.php

    //     var_dump($teacher);
    //     $response = $this->postJson('api/teacher', $teacher);

    //     $response->assertOk();

    //     // $this->assertDatabaseHas(Teacher::class, [
    //     //     'name' => 'KHAIRUL ABSYAR'
    //     // ]);

    //     // testing factory
    //     $this->assertDatabaseHas(Teacher::class, [
    //         'name' => $teacher['name']
    //     ]);
    // }

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
            'password' => 313123
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
}