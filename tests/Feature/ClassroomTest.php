<?php

namespace Tests\Feature;

use App\Http\Requests\AddTeacherRequest;
use App\Models\Attachment;
use App\Models\Classroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ClassroomType;
use App\Models\Teacher;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClassroomTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->teacher = Teacher::factory()->create();

        Sanctum::actingAs($this->teacher);
    }

    public function test_can_get_all_classroom_list()
    {
        // Seed Classroom, use relationship
        Classroom::factory(10)->for($this->teacher)->create();

        // index()
        $response = $this->getJson('api/classroom');

        $response->assertJson([
            "data" => [[
                'teacher_name' => $this->teacher->name
            ]]
        ]) // collection
            ->assertJsonCount(10, 'data');
    }

    public function test_teacher_can_create_new_classroom()
    {
        // generate random fake classroom data
        $class = Classroom::factory()->make();
        // dd($class);
        // $data = Arr::except($class->toArray(), ['teachers_id']);

        // call store endpoint and pass data
        $this->postJson('api/classroom', $class->toArray())
            // it is an object
            ->assertJson([
                "data" => [
                    'teacher_name' => $this->teacher->name,
                    'topic' => $class->name,
                ]
            ]);
    }

    public function test_teacher_can_update_existing_classroom()
    {
        $class = Classroom::factory()->for($this->teacher)->create();

        $this->putJson('api/classroom/' . $class->id, [
            'name' => 'Uga Bung ga'
        ])->assertJson([
            "data" => [
                "topic" => 'Uga Bung ga'
            ]
        ]);

        $this->assertDatabaseHas(Classroom::class, [
            'teachers_id' => $this->teacher->id,
            'name' => "Uga Bung ga"
        ]);
    }

    public function test_teacer_view_existing_classroom()
    {
        $class = Classroom::factory()->for($this->teacher)->create();

        $this->getJson('api/classroom/' . $class->id)->assertJson([
            "data" => [
                'topic' => $class->name,
            ]
        ]);
    }

    public function test_teacher_can_delete()
    {
        $class = Classroom::factory()->for($this->teacher)->create();

        $this->deleteJson('api/classroom/' . $class->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing(Classroom::class, [
            "teachers_id" => $this->teacher->id,
            "name" => $class->name,
        ]);
    }

    public function test_teacher_can_create_classroom_with_attachment()
    {
        // generate classroom data
        $class = Classroom::factory()->make();
        $attachment = Attachment::factory()->make();

        $payload = array_merge($class->toArray(), $attachment->toArray());

        // check detail classroom return with attachment if exist
        $this->postJson('api/classroom/' . $class->id, $payload)->assertJson([
            'data' => [
                'teacher_name' => $this->teacher->name,
                'topic' => $class->name,
                'attachment' => $attachment->uri
            ]
        ]);

        // check uri is save inside Attachment table
        $this->assertDatabaseCount(Attachment::class, 1);
    }

    public function test_teacher_can_create_classroom_without_attachment()
    {
        // generate classroom data
        $class = Classroom::factory()->make();

        // check detail classroom return with attachment not exist
        $this->postJson('api/classroom/' . $class->id, $class->toArray())->assertJson([
            'data' => [
                'teacher_name' => $this->teacher->name,
                'topic' => $class->name,
                'attachment' => null
            ]
        ]);

        // check uri is save inside Attachment table
        $this->assertDatabaseCount(Attachment::class, 0);
    }

    public function test_teacher_can_update_existing_classroom_attachment()
    {
        $class = Classroom::factory()->for($this->teacher)->create();
        $attachment = Attachment::factory()->for($class)->create();
        $newAttachment = Attachment::factory()->make();

        $this->putJson('api/classroom/' . $class->id, $newAttachment->toArray())->assertJson([
            'data' => [
                'teacher_name' => $this->teacher->name,
                'topic' => $class->name,
                'attachment' => $newAttachment->uri
            ]
        ]);

        $this->assertDatabaseMissing(Attachment::class, [
            'classroom_id' => $class->id,
            'uri' => $attachment->uri
        ]);

        $this->assertDatabaseHas(Attachment::class, [
            'classroom_id' => $class->id,
            'uri' => $newAttachment->uri
        ]);
    }

    // public function test_public_can_search_class_using_teacher_id()
    // {
    //     // class belong to intended teacher we want to search
    //     $classA = Classroom::factory()->for($this->teacher)->create();
    //     $classB = Classroom::factory()->for($this->teacher)->create();

    //     // classroom belong to other teacher
    //     $classC = Classroom::factory()->for(Teacher::factory()->create())->create();

    //     $this->postJson('api/classroom/search', [
    //         'teacher_id' => $this->teacher->id
    //     ])->assertJson([
    //         'data' => [
    //             ['topic' => $classA->name],
    //             ['topic' => $classB->name]
    //         ]
    //     ])->assertJsonCount(2, 'data');
    // }

    public function test_public_can_search_class_using_teacher_id()
    {
        // class belong to intended teacher we want to search
        $classA = Classroom::factory()->for($this->teacher)->create();
        $classB = Classroom::factory()->for($this->teacher)->create();
        // classroom belong to other teacher
        $classC = Classroom::factory()->for(Teacher::factory()->create())->create();

        $this->postJson('api/classroom/search', [
            'teachers_id' => $this->teacher->id
        ])
            ->assertJson([
                "data" => [
                    ["topic" => $classA->name],
                    ["topic" => $classB->name]
                ]
            ])
            ->assertJsonCount(2, "data");
    }

    public function test_public_can_search_class_using_topic_and_class_type()
    {
        $classA = Classroom::factory()->for($this->teacher)->create([
            'name' => "Match Course A", 'type_id' => 2
        ]);

        $classB = Classroom::factory()->for($this->teacher)->create([
            'name' => "Geography", 'type_id' => 1
        ]);

        $classC = Classroom::factory()->for($this->teacher)->create([
            'name' => "Geographic Channel", 'type_id' => 3
        ]);

        $this->postJson('api/classroom/search', [
            'type_name' => 'live',
            'search_topic' => 'geo'
        ])->assertJson([
            'data' => [
                ['topic' => $classB->name]
            ]
        ])->assertJsonCount(1, 'data');
    }

    public function test_public_can_search_class_using_topic_and_teacher_name()
    {
        $teacher = Teacher::factory()->create(['name' => 'Samad Ali']);
        $classA = Classroom::factory()->for($teacher)->create([
            'name' => "Data Science Beginner"
        ]);

        $classB = Classroom::factory()->for($teacher)->create([
            'name' => "Calculus"
        ]);

        $classC = Classroom::factory()->for($teacher)->create([
            'name' => "Calculus For Noob"
        ]);

        $this->postJson('api/classroom/search', [
            'search_teacher_name' => 'Ali',
            'search_topic' => 'Calculus'
        ])->assertJson([
            'data' => [
                ['topic' => $classB->name],
                ['topic' => $classC->name]
            ]
        ])->assertJsonCount(2, 'data');
    }
}