<?php

namespace App\Jobs;

use App\Models\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

/*
 *  Register a random teacher at 1pm every day
 */

class CreateTeacherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    // when using delay need to add this, declare the job may take more than default server timeout to max 300 seconds
    public $timeout = 3000;

    // without overlapping
    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        // block from running for the same 'name
        return [(new WithoutOverlapping($this->name))->dontRelease()];
    }

    /**
     * Execute the job. Logic here
     *
     * @return void
     */
    public function handle()
    {
        Teacher::factory()->create(["name" => $this->name]);
    }
}