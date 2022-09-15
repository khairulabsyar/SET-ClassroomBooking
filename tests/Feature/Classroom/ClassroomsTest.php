<?php

namespace Tests\Feature;

use App\Http\Requests\AddTeacherRequest;
use App\Models\Classrooms;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ClassroomType;
use App\Models\Teacher;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClassroomsTest extends TestCase
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
        Classrooms::factory(10)->for($this->teacher)->create();

        // index()
        $response = $this->getJson('api/classroom');

        $response
            ->assertJson([
                "data" => [[
                    'teacher_name' => $this->teacher->name
                ]]
            ]) // collection
            ->assertJsonCount(10, 'data');
    }

    public function test_teacher_can_create_new_classroom()
    {
        // generate random fake classroom data
        $class = Classrooms::factory()->make();
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
        $class = Classrooms::factory()->for($this->teacher)->create();

        $this->putJson('api/classroom/' . $class->id, [
            'name' => 'Uga Bung ga'
        ])
            ->assertJson([
                "data" => [
                    "topic" => 'Uga Bung ga'
                ]
            ]);

        $this->assertDatabaseHas(Classrooms::class, [
            'teachers_id' => $this->teacher->id,
            'name' => "Uga Bung ga"
        ]);
    }

    public function test_teacer_view_existing_classroom()
    {
        $class = Classrooms::factory()->for($this->teacher)->create();

        $this->getJson('api/classroom/' . $class->id)
            ->assertJson([
                "data" => [
                    'topic' => $class->name,
                ]
            ]);
    }

    public function test_teacher_can_delete()
    {
        $class = Classrooms::factory()->for($this->teacher)->create();

        $this->deleteJson('api/classroom/' . $class->id)
            ->assertStatus(204);
        $this->assertDatabaseMissing(Classrooms::class, [
            "teachers_id" => $this->teacher->id,
            "name" => $class->name,
        ]);
    }
}