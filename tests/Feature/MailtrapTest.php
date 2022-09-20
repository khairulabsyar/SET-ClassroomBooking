<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MailtrapTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Http::fake([
            'https://mailtrap.io/api/*' => Http::response([
                [
                    [
                        'project_id' => 1392869
                    ]
                ]
            ], 200)
        ]);
    }

    public function test_mailtrap_return_project_id()
    {
        $this->getJson('api/mailtrap-inboxes')
            ->assertJson([
                ['project_id' => '']
            ]);
    }
}