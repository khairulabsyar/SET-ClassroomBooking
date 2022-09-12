<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherFactoryController extends Controller
{
    /**
     * Initialise something at class
     * can be middleware, variable, service class
     */
    public function __construct()
    {
        $this->var = 'Initialise Variable';
    }

    /**
     * Creating fake teacher data
     */
    function __invoke()
    {
        $generated = Teacher::factory()->upTheName()->create();

        return $generated;
        // return 'Initialise Variable' to user
        // return $this->var;
    }
}